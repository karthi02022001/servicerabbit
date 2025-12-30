<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Service;
use App\Models\TaskerProfile;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the tasker dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->taskerProfile;

        // Get dashboard stats
        $stats = $this->getDashboardStats($user, $profile);

        // Get recent bookings
        $recentBookings = Booking::where('tasker_id', $user->id)
            ->with(['user', 'service', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get upcoming bookings (today and future)
        $upcomingBookings = Booking::where('tasker_id', $user->id)
            ->whereIn('status', ['accepted', 'paid'])
            ->where('booking_date', '>=', now()->toDateString())
            ->with(['user', 'service', 'category'])
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // Get pending booking requests
        $pendingRequests = Booking::where('tasker_id', $user->id)
            ->where('status', 'pending')
            ->with(['user', 'service', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get recent reviews
        $recentReviews = Review::where('reviewee_id', $user->id)
            ->where('status', 'approved')
            ->with(['reviewer', 'booking'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get wallet info
        $wallet = $user->wallet;

        // Get earnings chart data (last 7 days)
        $earningsChart = $this->getEarningsChartData($user);

        return view('tasker.dashboard.index', compact(
            'user',
            'profile',
            'stats',
            'recentBookings',
            'upcomingBookings',
            'pendingRequests',
            'recentReviews',
            'wallet',
            'earningsChart'
        ));
    }

    /**
     * Get dashboard statistics.
     */
    private function getDashboardStats($user, $profile): array
    {
        // Today's bookings
        $todayBookings = Booking::where('tasker_id', $user->id)
            ->whereDate('booking_date', today())
            ->whereIn('status', ['accepted', 'paid', 'in_progress'])
            ->count();

        // Pending requests
        $pendingCount = Booking::where('tasker_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // This month's earnings
        $monthlyEarnings = Booking::where('tasker_id', $user->id)
            ->where('status', 'completed')
            ->whereMonth('completed_at', now()->month)
            ->whereYear('completed_at', now()->year)
            ->sum('tasker_payout');

        // Total earnings
        $totalEarnings = Booking::where('tasker_id', $user->id)
            ->where('status', 'completed')
            ->sum('tasker_payout');

        // Completed tasks
        $completedTasks = Booking::where('tasker_id', $user->id)
            ->where('status', 'completed')
            ->count();

        // Active services
        $activeServices = Service::where('tasker_profile_id', $profile->id)
            ->where('is_active', true)
            ->count();

        // Response rate (accepted + declined / total requests in last 30 days)
        $last30DaysRequests = Booking::where('tasker_id', $user->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $respondedRequests = Booking::where('tasker_id', $user->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->whereIn('status', ['accepted', 'declined', 'paid', 'completed', 'in_progress'])
            ->count();

        $responseRate = $last30DaysRequests > 0 
            ? round(($respondedRequests / $last30DaysRequests) * 100) 
            : 100;

        return [
            'today_bookings' => $todayBookings,
            'pending_requests' => $pendingCount,
            'monthly_earnings' => $monthlyEarnings,
            'total_earnings' => $totalEarnings,
            'completed_tasks' => $completedTasks,
            'active_services' => $activeServices,
            'average_rating' => $profile->average_rating,
            'total_reviews' => $profile->total_reviews,
            'response_rate' => $responseRate,
            'completion_rate' => $profile->completion_rate,
        ];
    }

    /**
     * Get earnings chart data for last 7 days.
     */
    private function getEarningsChartData($user): array
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('M d');

            $dayEarnings = Booking::where('tasker_id', $user->id)
                ->where('status', 'completed')
                ->whereDate('completed_at', $date)
                ->sum('tasker_payout');

            $data[] = (float) $dayEarnings;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
