<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the tasker dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        $taskerProfile = $user->taskerProfile;

        // Get tasker statistics
        $stats = [
            'todays_bookings' => Booking::where('tasker_id', $user->id)
                ->whereDate('booking_date', now()->toDateString())
                ->count(),
            'pending_requests' => Booking::where('tasker_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'completed_tasks' => Booking::where('tasker_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'monthly_earnings' => Transaction::where('tasker_id', $user->id)
                ->where('type', 'earning')
                ->where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
        ];

        // Performance metrics
        $performance = [
            'rating' => $taskerProfile->average_rating ?? 0,
            'total_reviews' => $taskerProfile->total_reviews ?? 0,
            'completion_rate' => $this->calculateCompletionRate($user->id),
            'response_time' => $this->calculateAverageResponseTime($user->id),
        ];

        // Get pending bookings
        $pendingBookings = Booking::where('tasker_id', $user->id)
            ->where('status', 'pending')
            ->with(['user', 'category', 'service'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get upcoming bookings (today and future)
        $upcomingBookings = Booking::where('tasker_id', $user->id)
            ->whereIn('status', ['accepted', 'paid'])
            ->where('booking_date', '>=', now()->toDateString())
            ->with(['user', 'category', 'service'])
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // Get recent reviews
        $recentReviews = Review::where('reviewee_id', $user->id)
            ->where('status', 'approved')
            ->with('reviewer')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('tasker.dashboard.index', compact(
            'user',
            'taskerProfile',
            'stats',
            'performance',
            'pendingBookings',
            'upcomingBookings',
            'recentReviews'
        ));
    }

    /**
     * Calculate tasker's completion rate.
     */
    private function calculateCompletionRate(int $taskerId): float
    {
        $totalBookings = Booking::where('tasker_id', $taskerId)
            ->whereIn('status', ['completed', 'cancelled', 'declined'])
            ->count();

        if ($totalBookings === 0) {
            return 100;
        }

        $completedBookings = Booking::where('tasker_id', $taskerId)
            ->where('status', 'completed')
            ->count();

        return round(($completedBookings / $totalBookings) * 100, 1);
    }

    /**
     * Calculate average response time in hours.
     */
    private function calculateAverageResponseTime(int $taskerId): string
    {
        // This would typically be calculated from booking status history
        // For now, return a placeholder
        return '< 1 hour';
    }
}
