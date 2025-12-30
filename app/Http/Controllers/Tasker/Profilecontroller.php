<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\TaskerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        return view('tasker.profile.edit', compact('user', 'profile'));
    }

    /**
     * Update the tasker profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $validated = $request->validate([
            'headline' => 'required|string|max:255',
            'professional_bio' => 'required|string|min:50|max:1000',
            'years_of_experience' => 'required|integer|min:0|max:50',
            'work_radius_km' => 'required|integer|min:5|max:100',
            'instant_booking' => 'boolean',
        ]);

        $profile->update([
            'headline' => $validated['headline'],
            'professional_bio' => $validated['professional_bio'],
            'years_of_experience' => $validated['years_of_experience'],
            'work_radius_km' => $validated['work_radius_km'],
            'instant_booking' => $request->boolean('instant_booking'),
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $avatarPath]);

        return back()->with('success', 'Profile photo updated successfully!');
    }

    /**
     * Remove profile photo.
     */
    public function removePhoto()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return back()->with('success', 'Profile photo removed successfully!');
    }

    /**
     * Update vehicle information.
     */
    public function updateVehicle(Request $request)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $validated = $request->validate([
            'has_vehicle' => 'boolean',
            'vehicle_type' => 'nullable|required_if:has_vehicle,1|in:bicycle,motorcycle,car,minivan,pickup_truck,moving_truck,van',
            'vehicle_description' => 'nullable|string|max:255',
        ]);

        $profile->update([
            'has_vehicle' => $request->boolean('has_vehicle'),
            'vehicle_type' => $request->boolean('has_vehicle') ? $validated['vehicle_type'] : null,
            'vehicle_description' => $request->boolean('has_vehicle') ? $validated['vehicle_description'] : null,
        ]);

        return back()->with('success', 'Vehicle information updated successfully!');
    }

    /**
     * Toggle availability status.
     */
    public function toggleAvailability(Request $request)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $profile->update([
            'is_available' => !$profile->is_available,
        ]);

        $status = $profile->is_available ? 'available' : 'unavailable';

        return back()->with('success', "You are now {$status} for new bookings.");
    }

    /**
     * Show verification status page.
     */
    public function verification()
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        return view('tasker.profile.verification', compact('user', 'profile'));
    }

    /**
     * Show earnings page.
     */
    public function earnings(Request $request)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;
        $wallet = $user->wallet;

        // Date range filter
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        // Get completed bookings with earnings
        $earnings = \App\Models\Booking::where('tasker_id', $user->id)
            ->where('status', 'completed')
            ->whereBetween('completed_at', [$startDate, $endDate . ' 23:59:59'])
            ->with(['user', 'service', 'category'])
            ->orderBy('completed_at', 'desc')
            ->paginate(15);

        // Summary stats
        $summary = [
            'total' => \App\Models\Booking::where('tasker_id', $user->id)
                ->where('status', 'completed')
                ->whereBetween('completed_at', [$startDate, $endDate . ' 23:59:59'])
                ->sum('tasker_payout'),
            'tasks' => \App\Models\Booking::where('tasker_id', $user->id)
                ->where('status', 'completed')
                ->whereBetween('completed_at', [$startDate, $endDate . ' 23:59:59'])
                ->count(),
            'hours' => \App\Models\Booking::where('tasker_id', $user->id)
                ->where('status', 'completed')
                ->whereBetween('completed_at', [$startDate, $endDate . ' 23:59:59'])
                ->sum('actual_hours'),
        ];

        return view('tasker.profile.earnings', compact('user', 'profile', 'wallet', 'earnings', 'summary', 'startDate', 'endDate'));
    }
}
