<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\TaskCategory;
use App\Models\TaskerProfile;
use App\Models\TaskerAvailability;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    /**
     * Days of week mapping.
     */
    protected $daysOfWeek = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];

    /**
     * Show the become a tasker landing page.
     */
    public function index()
    {
        $user = Auth::user();

        // If already a tasker with approved status, redirect to tasker dashboard
        if ($user->is_tasker && $user->taskerProfile && $user->taskerProfile->verification_status === 'approved') {
            return redirect()->route('tasker.dashboard');
        }

        // Check if profile exists and get current step
        $profile = $user->taskerProfile;

        if ($profile) {
            $nextStep = $this->getNextIncompleteStep($profile);
            if ($nextStep <= 4) {
                return redirect()->route('tasker.register.step' . $nextStep);
            }
        }

        return view('tasker.register.index');
    }

    /**
     * Start the registration process.
     */
    public function start()
    {
        $user = Auth::user();

        // If already a tasker with approved status, redirect to tasker dashboard
        if ($user->is_tasker && $user->taskerProfile && $user->taskerProfile->verification_status === 'approved') {
            return redirect()->route('tasker.dashboard');
        }

        // Create tasker profile if doesn't exist
        $profile = $user->taskerProfile;

        if (!$profile) {
            $profile = TaskerProfile::create([
                'user_id' => $user->id,
                'verification_status' => 'pending', // Use valid ENUM value
                'is_available' => false,
            ]);
        }

        // Redirect to first incomplete step
        $nextStep = $this->getNextIncompleteStep($profile);

        return redirect()->route('tasker.register.step' . $nextStep);
    }

    /**
     * Get the next incomplete step number.
     */
    protected function getNextIncompleteStep($profile)
    {
        if (!$profile->step_profile_completed) {
            return 1;
        }
        if (!$profile->step_categories_completed) {
            return 2;
        }
        if (!$profile->step_availability_completed) {
            return 3;
        }
        if (!$profile->step_payment_completed) {
            return 4;
        }
        return 5; // All completed
    }

    /**
     * Show Step 1 - Profile Information.
     */
    public function showStep1()
    {
        $user = Auth::user();
        $profile = $this->getOrCreateProfile($user);

        return view('tasker.register.step1', [
            'profile' => $profile,
            'currentStep' => 1,
        ]);
    }

    /**
     * Process Step 1 - Profile Information.
     */
    public function processStep1(Request $request)
    {
        $user = Auth::user();
        $profile = $this->getOrCreateProfile($user);

        $validated = $request->validate([
            'headline' => 'required|string|max:100',
            'professional_bio' => 'required|string|min:50|max:1000',
            'years_of_experience' => 'required|integer|min:0|max:50',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'work_radius_km' => 'required|integer|min:5|max:100',
            'has_vehicle' => 'boolean',
            'vehicle_type' => 'nullable|required_if:has_vehicle,1|in:bicycle,motorcycle,car,minivan,pickup_truck,moving_truck,van',
            'vehicle_description' => 'nullable|string|max:255',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $avatarPath]);
        }

        // Update profile
        $profile->update([
            'headline' => $validated['headline'],
            'professional_bio' => $validated['professional_bio'],
            'years_of_experience' => $validated['years_of_experience'],
            'work_radius_km' => $validated['work_radius_km'],
            'has_vehicle' => $request->boolean('has_vehicle'),
            'vehicle_type' => $validated['vehicle_type'] ?? null,
            'vehicle_description' => $validated['vehicle_description'] ?? null,
            'step_profile_completed' => true,
        ]);

        return redirect()->route('tasker.register.step2')
            ->with('success', 'Profile information saved! Now select your service categories.');
    }

    /**
     * Show Step 2 - Categories & Pricing.
     */
    public function showStep2()
    {
        $user = Auth::user();
        $profile = $this->getOrCreateProfile($user);

        // Check if step 1 is completed
        if (!$profile->step_profile_completed) {
            return redirect()->route('tasker.register.step1')
                ->with('warning', 'Please complete your profile first.');
        }

        $categories = TaskCategory::where('status', 'active')
            ->orderBy('sort_order')
            ->with(['subcategories' => function ($q) {
                $q->where('status', 'active')->orderBy('sort_order');
            }])
            ->get();

        $selectedServices = $profile->services()->with('category', 'subcategory')->get();

        return view('tasker.register.step2', [
            'profile' => $profile,
            'categories' => $categories,
            'selectedServices' => $selectedServices,
            'currentStep' => 2,
        ]);
    }

    /**
     * Process Step 2 - Categories & Pricing.
     */
    public function processStep2(Request $request)
    {
        $user = Auth::user();
        $profile = $this->getOrCreateProfile($user);

        $validated = $request->validate([
            'services' => 'required|array|min:1',
            'services.*.category_id' => 'required|exists:task_categories,id',
            'services.*.subcategory_id' => 'nullable|exists:task_subcategories,id',
            'services.*.title' => 'required|string|max:100',
            'services.*.description' => 'nullable|string|max:500',
            'services.*.hourly_rate' => 'required|numeric|min:10|max:500',
            'services.*.experience_years' => 'nullable|integer|min:0|max:50',
        ]);

        DB::transaction(function () use ($validated, $profile) {
            // Remove existing services
            $profile->services()->delete();

            // Create new services
            $minRate = null;
            $maxRate = null;

            foreach ($validated['services'] as $serviceData) {
                Service::create([
                    'tasker_profile_id' => $profile->id,
                    'category_id' => $serviceData['category_id'],
                    'subcategory_id' => $serviceData['subcategory_id'] ?? null,
                    'title' => $serviceData['title'],
                    'description' => $serviceData['description'] ?? null,
                    'pricing_type' => 'hourly',
                    'hourly_rate' => $serviceData['hourly_rate'],
                    'experience_years' => $serviceData['experience_years'] ?? null,
                    'is_active' => true,
                ]);

                $rate = $serviceData['hourly_rate'];
                if ($minRate === null || $rate < $minRate) {
                    $minRate = $rate;
                }
                if ($maxRate === null || $rate > $maxRate) {
                    $maxRate = $rate;
                }
            }

            // Update profile rates
            $profile->update([
                'hourly_rate_min' => $minRate,
                'hourly_rate_max' => $maxRate,
                'step_categories_completed' => true,
            ]);
        });

        return redirect()->route('tasker.register.step3')
            ->with('success', 'Services saved! Now set your availability.');
    }

    /**
     * Show Step 3 - Availability.
     */
    public function showStep3()
    {
        $user = Auth::user();
        $profile = $this->getOrCreateProfile($user);

        // Check if step 2 is completed
        if (!$profile->step_categories_completed) {
            return redirect()->route('tasker.register.step2')
                ->with('warning', 'Please select your services first.');
        }

        $availabilities = $profile->availabilities()->orderBy('day_of_week')->get();

        return view('tasker.register.step3', [
            'profile' => $profile,
            'availabilities' => $availabilities,
            'daysOfWeek' => $this->daysOfWeek,
            'currentStep' => 3,
        ]);
    }

    /**
     * Process Step 3 - Availability.
     */
    public function processStep3(Request $request)
    {
        $user = Auth::user();
        $profile = $this->getOrCreateProfile($user);

        $validated = $request->validate([
            'availability' => 'required|array',
            'availability.*.enabled' => 'boolean',
            'availability.*.start_time' => 'required_if:availability.*.enabled,1',
            'availability.*.end_time' => 'required_if:availability.*.enabled,1',
        ]);

        DB::transaction(function () use ($validated, $profile) {
            // Remove existing availabilities
            $profile->availabilities()->delete();

            // Create new availabilities
            foreach ($validated['availability'] as $dayOfWeek => $data) {
                if (!empty($data['enabled']) && !empty($data['start_time']) && !empty($data['end_time'])) {
                    TaskerAvailability::create([
                        'tasker_profile_id' => $profile->id,
                        'day_of_week' => $dayOfWeek,
                        'start_time' => $data['start_time'],
                        'end_time' => $data['end_time'],
                        'is_available' => true,
                    ]);
                }
            }

            $profile->update([
                'step_availability_completed' => true,
            ]);
        });

        return redirect()->route('tasker.register.step4')
            ->with('success', 'Availability saved! Now complete ID verification.');
    }

    /**
     * Show Step 4 - ID Verification.
     */
    public function showStep4()
    {
        $user = Auth::user();
        $profile = $this->getOrCreateProfile($user);

        // Check if step 3 is completed
        if (!$profile->step_availability_completed) {
            return redirect()->route('tasker.register.step3')
                ->with('warning', 'Please set your availability first.');
        }

        return view('tasker.register.step4', [
            'profile' => $profile,
            'currentStep' => 4,
        ]);
    }

    /**
     * Process Step 4 - ID Verification.
     */
    public function processStep4(Request $request)
    {
        $user = Auth::user();
        $profile = $this->getOrCreateProfile($user);

        $validated = $request->validate([
            'id_document_type' => 'required|in:passport,drivers_license,national_id',
            'id_document_front' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'id_document_back' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'terms_accepted' => 'required|accepted',
        ]);

        // Upload documents
        $frontPath = $request->file('id_document_front')->store('id-documents', 'public');
        $backPath = $request->file('id_document_back')->store('id-documents', 'public');

        // Update profile
        $profile->update([
            'id_document_type' => $validated['id_document_type'],
            'id_document_front' => $frontPath,
            'id_document_back' => $backPath,
            'verification_status' => 'submitted',
            'step_payment_completed' => true,
        ]);

        // Mark user as tasker
        $user->update(['is_tasker' => true]);

        return redirect()->route('tasker.register.complete')
            ->with('success', 'Congratulations! Your application has been submitted for review.');
    }

    /**
     * Show completion page.
     */
    public function complete()
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        if (!$profile || !$user->is_tasker) {
            return redirect()->route('become-tasker');
        }

        return view('tasker.register.complete', compact('profile'));
    }

    /**
     * Get or create tasker profile for user.
     */
    protected function getOrCreateProfile($user)
    {
        $profile = $user->taskerProfile;

        if (!$profile) {
            $profile = TaskerProfile::create([
                'user_id' => $user->id,
                'verification_status' => 'pending', // Use valid ENUM value
                'is_available' => false,
            ]);
        }

        return $profile;
    }
}
