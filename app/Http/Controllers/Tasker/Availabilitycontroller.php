<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\TaskerAvailability;
use App\Models\TaskerBlockedDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends Controller
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
     * Display availability management page.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        // Get weekly availability
        $availabilities = $profile->availabilities()
            ->orderBy('day_of_week')
            ->get();

        // Get upcoming blocked dates
        $blockedDates = $profile->blockedDates()
            ->where('blocked_date', '>=', now()->toDateString())
            ->orderBy('blocked_date')
            ->get();

        return view('tasker.availability.index', compact(
            'profile',
            'availabilities',
            'blockedDates'
        ))->with('daysOfWeek', $this->daysOfWeek);
    }

    /**
     * Store a new availability slot.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $validated = $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Check for overlapping slots on the same day
        $existingSlot = TaskerAvailability::where('tasker_profile_id', $profile->id)
            ->where('day_of_week', $validated['day_of_week'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->first();

        if ($existingSlot) {
            return back()->withErrors(['day_of_week' => 'This time slot overlaps with an existing slot on the same day.']);
        }

        TaskerAvailability::create([
            'tasker_profile_id' => $profile->id,
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_available' => true,
        ]);

        return back()->with('success', 'Availability slot added successfully!');
    }

    /**
     * Delete an availability slot.
     */
    public function destroy(TaskerAvailability $availability)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        // Ensure availability belongs to this tasker
        if ($availability->tasker_profile_id !== $profile->id) {
            abort(403);
        }

        $availability->delete();

        return back()->with('success', 'Availability slot removed successfully!');
    }

    /**
     * Update weekly availability.
     */
    public function updateSchedule(Request $request)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $validated = $request->validate([
            'availability' => 'required|array',
            'availability.*.enabled' => 'boolean',
            'availability.*.start_time' => 'nullable|date_format:H:i',
            'availability.*.end_time' => 'nullable|date_format:H:i',
        ]);

        DB::transaction(function () use ($validated, $profile) {
            // Remove existing availabilities
            $profile->availabilities()->delete();

            // Create new availabilities
            foreach ($validated['availability'] as $dayOfWeek => $data) {
                if (!empty($data['enabled']) && !empty($data['start_time']) && !empty($data['end_time'])) {
                    // Validate end time is after start time
                    if (strtotime($data['end_time']) <= strtotime($data['start_time'])) {
                        continue;
                    }

                    TaskerAvailability::create([
                        'tasker_profile_id' => $profile->id,
                        'day_of_week' => $dayOfWeek,
                        'start_time' => $data['start_time'],
                        'end_time' => $data['end_time'],
                        'is_available' => true,
                    ]);
                }
            }
        });

        return back()->with('success', 'Weekly schedule updated successfully!');
    }

    /**
     * Add a blocked date.
     */
    public function addBlockedDate(Request $request)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $validated = $request->validate([
            'blocked_date' => 'required|date|after_or_equal:today',
            'block_type' => 'required|in:full_day,partial',
            'start_time' => 'required_if:block_type,partial|nullable|date_format:H:i',
            'end_time' => 'required_if:block_type,partial|nullable|date_format:H:i|after:start_time',
            'reason' => 'nullable|string|max:255',
        ]);

        // Check if date already blocked
        $existingBlock = TaskerBlockedDate::where('tasker_profile_id', $profile->id)
            ->where('blocked_date', $validated['blocked_date'])
            ->first();

        if ($existingBlock && $existingBlock->isFullDay()) {
            return back()->withErrors(['blocked_date' => 'This date is already blocked.']);
        }

        TaskerBlockedDate::create([
            'tasker_profile_id' => $profile->id,
            'blocked_date' => $validated['blocked_date'],
            'start_time' => $validated['block_type'] === 'partial' ? $validated['start_time'] : null,
            'end_time' => $validated['block_type'] === 'partial' ? $validated['end_time'] : null,
            'reason' => $validated['reason'] ?? null,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Date blocked successfully!');
    }

    /**
     * Remove a blocked date.
     */
    public function removeBlockedDate(TaskerBlockedDate $blockedDate)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        // Ensure blocked date belongs to this tasker
        if ($blockedDate->tasker_profile_id !== $profile->id) {
            abort(403);
        }

        $blockedDate->delete();

        return back()->with('success', 'Blocked date removed successfully!');
    }

    /**
     * Get blocked dates for calendar (AJAX).
     */
    public function getBlockedDates(Request $request)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $start = $request->get('start', now()->startOfMonth()->toDateString());
        $end = $request->get('end', now()->endOfMonth()->toDateString());

        $blockedDates = TaskerBlockedDate::where('tasker_profile_id', $profile->id)
            ->whereBetween('blocked_date', [$start, $end])
            ->get()
            ->map(function ($block) {
                return [
                    'id' => $block->id,
                    'title' => $block->isFullDay() ? 'Blocked' : $block->time_range,
                    'start' => $block->blocked_date->format('Y-m-d'),
                    'allDay' => $block->isFullDay(),
                    'backgroundColor' => '#dc3545',
                    'borderColor' => '#dc3545',
                    'extendedProps' => [
                        'reason' => $block->reason,
                        'timeRange' => $block->time_range,
                    ],
                ];
            });

        return response()->json($blockedDates);
    }

    /**
     * Copy schedule from another day.
     */
    public function copyDay(Request $request)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $validated = $request->validate([
            'from_day' => 'required|integer|min:0|max:6',
            'to_days' => 'required|array|min:1',
            'to_days.*' => 'integer|min:0|max:6',
        ]);

        $sourceAvailability = TaskerAvailability::where('tasker_profile_id', $profile->id)
            ->where('day_of_week', $validated['from_day'])
            ->first();

        if (!$sourceAvailability) {
            return back()->withErrors(['from_day' => 'Source day has no schedule set.']);
        }

        DB::transaction(function () use ($validated, $profile, $sourceAvailability) {
            foreach ($validated['to_days'] as $targetDay) {
                if ($targetDay != $validated['from_day']) {
                    // Delete existing
                    TaskerAvailability::where('tasker_profile_id', $profile->id)
                        ->where('day_of_week', $targetDay)
                        ->delete();

                    // Copy
                    TaskerAvailability::create([
                        'tasker_profile_id' => $profile->id,
                        'day_of_week' => $targetDay,
                        'start_time' => $sourceAvailability->start_time,
                        'end_time' => $sourceAvailability->end_time,
                        'is_available' => true,
                    ]);
                }
            }
        });

        return back()->with('success', 'Schedule copied successfully!');
    }

    /**
     * Set quick schedule preset.
     */
    public function setPreset(Request $request)
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        $validated = $request->validate([
            'preset' => 'required|in:weekdays,weekends,everyday,clear',
        ]);

        DB::transaction(function () use ($validated, $profile) {
            // Clear existing
            $profile->availabilities()->delete();

            $presets = [
                'weekdays' => [1, 2, 3, 4, 5], // Mon-Fri
                'weekends' => [0, 6], // Sun, Sat
                'everyday' => [0, 1, 2, 3, 4, 5, 6],
                'clear' => [],
            ];

            foreach ($presets[$validated['preset']] as $day) {
                TaskerAvailability::create([
                    'tasker_profile_id' => $profile->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00',
                    'end_time' => '17:00',
                    'is_available' => true,
                ]);
            }
        });

        $message = match ($validated['preset']) {
            'weekdays' => 'Weekday schedule (Mon-Fri, 9AM-5PM) set successfully!',
            'weekends' => 'Weekend schedule (Sat-Sun, 9AM-5PM) set successfully!',
            'everyday' => 'Everyday schedule (9AM-5PM) set successfully!',
            'clear' => 'Schedule cleared successfully!',
        };

        return back()->with('success', $message);
    }
}
