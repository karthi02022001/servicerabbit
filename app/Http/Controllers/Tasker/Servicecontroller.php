<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\TaskCategory;
use App\Models\TaskSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of tasker's services.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $services = Service::where('tasker_profile_id', $profile->id)
            ->with(['category', 'subcategory'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tasker.services.index', compact('services', 'profile'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $categories = TaskCategory::where('status', 'active')
            ->orderBy('sort_order')
            ->with(['subcategories' => function ($q) {
                $q->where('status', 'active')->orderBy('sort_order');
            }])
            ->get();

        return view('tasker.services.create', compact('profile', 'categories'));
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $validated = $request->validate([
            'category_id' => 'required|exists:task_categories,id',
            'subcategory_id' => 'nullable|exists:task_subcategories,id',
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'pricing_type' => 'required|in:hourly,fixed,quote',
            'hourly_rate' => 'required_if:pricing_type,hourly|nullable|numeric|min:10|max:500',
            'fixed_price' => 'required_if:pricing_type,fixed|nullable|numeric|min:10|max:10000',
            'minimum_hours' => 'nullable|numeric|min:0.5|max:8',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'experience_description' => 'nullable|string|max:500',
        ]);

        // Check if service with same category already exists
        $existingService = Service::where('tasker_profile_id', $profile->id)
            ->where('category_id', $validated['category_id'])
            ->where('subcategory_id', $validated['subcategory_id'])
            ->first();

        if ($existingService) {
            return back()->withInput()
                ->withErrors(['category_id' => 'You already have a service in this category/subcategory.']);
        }

        $service = Service::create([
            'tasker_profile_id' => $profile->id,
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'pricing_type' => $validated['pricing_type'],
            'hourly_rate' => $validated['hourly_rate'] ?? null,
            'fixed_price' => $validated['fixed_price'] ?? null,
            'minimum_hours' => $validated['minimum_hours'] ?? null,
            'experience_years' => $validated['experience_years'] ?? null,
            'experience_description' => $validated['experience_description'] ?? null,
            'is_active' => true,
        ]);

        // Update profile rate range
        $this->updateProfileRateRange($profile);

        return redirect()->route('tasker.services.index')
            ->with('success', 'Service added successfully!');
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        // Ensure service belongs to this tasker
        if ($service->tasker_profile_id !== $profile->id) {
            abort(403);
        }

        $categories = TaskCategory::where('status', 'active')
            ->orderBy('sort_order')
            ->with(['subcategories' => function ($q) {
                $q->where('status', 'active')->orderBy('sort_order');
            }])
            ->get();

        return view('tasker.services.edit', compact('service', 'profile', 'categories'));
    }

    /**
     * Update the specified service.
     */
    public function update(Request $request, Service $service)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        // Ensure service belongs to this tasker
        if ($service->tasker_profile_id !== $profile->id) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:task_categories,id',
            'subcategory_id' => 'nullable|exists:task_subcategories,id',
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'pricing_type' => 'required|in:hourly,fixed,quote',
            'hourly_rate' => 'required_if:pricing_type,hourly|nullable|numeric|min:10|max:500',
            'fixed_price' => 'required_if:pricing_type,fixed|nullable|numeric|min:10|max:10000',
            'minimum_hours' => 'nullable|numeric|min:0.5|max:8',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'experience_description' => 'nullable|string|max:500',
        ]);

        // Check for duplicate (excluding current service)
        $existingService = Service::where('tasker_profile_id', $profile->id)
            ->where('category_id', $validated['category_id'])
            ->where('subcategory_id', $validated['subcategory_id'])
            ->where('id', '!=', $service->id)
            ->first();

        if ($existingService) {
            return back()->withInput()
                ->withErrors(['category_id' => 'You already have a service in this category/subcategory.']);
        }

        $service->update([
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'pricing_type' => $validated['pricing_type'],
            'hourly_rate' => $validated['hourly_rate'] ?? null,
            'fixed_price' => $validated['fixed_price'] ?? null,
            'minimum_hours' => $validated['minimum_hours'] ?? null,
            'experience_years' => $validated['experience_years'] ?? null,
            'experience_description' => $validated['experience_description'] ?? null,
        ]);

        // Update profile rate range
        $this->updateProfileRateRange($profile);

        return redirect()->route('tasker.services.index')
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Toggle service active status.
     */
    public function toggle(Service $service)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        // Ensure service belongs to this tasker
        if ($service->tasker_profile_id !== $profile->id) {
            abort(403);
        }

        $service->update([
            'is_active' => !$service->is_active,
        ]);

        // Update profile rate range
        $this->updateProfileRateRange($profile);

        $status = $service->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Service {$status} successfully!");
    }

    /**
     * Remove the specified service.
     */
    public function destroy(Service $service)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        // Ensure service belongs to this tasker
        if ($service->tasker_profile_id !== $profile->id) {
            abort(403);
        }

        // Check if service has active bookings
        $activeBookings = $service->bookings()
            ->whereIn('status', ['pending', 'accepted', 'paid', 'in_progress'])
            ->count();

        if ($activeBookings > 0) {
            return back()->withErrors(['service' => 'Cannot delete service with active bookings.']);
        }

        $service->delete();

        // Update profile rate range
        $this->updateProfileRateRange($profile);

        return redirect()->route('tasker.services.index')
            ->with('success', 'Service deleted successfully!');
    }

    /**
     * Get subcategories for a category (AJAX).
     */
    public function getSubcategories(TaskCategory $category)
    {
        $subcategories = $category->subcategories()
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get(['id', 'name']);

        return response()->json($subcategories);
    }

    /**
     * Update profile's hourly rate range.
     */
    private function updateProfileRateRange($profile)
    {
        $activeServices = Service::where('tasker_profile_id', $profile->id)
            ->where('is_active', true)
            ->where('pricing_type', 'hourly')
            ->get();

        if ($activeServices->count() > 0) {
            $profile->update([
                'hourly_rate_min' => $activeServices->min('hourly_rate'),
                'hourly_rate_max' => $activeServices->max('hourly_rate'),
            ]);
        } else {
            $profile->update([
                'hourly_rate_min' => null,
                'hourly_rate_max' => null,
            ]);
        }
    }
}
