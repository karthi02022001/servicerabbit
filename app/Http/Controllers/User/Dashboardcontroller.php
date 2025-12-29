<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Get user statistics
        $stats = [
            'upcoming_bookings' => Booking::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'accepted', 'paid'])
                ->where('booking_date', '>=', now()->toDateString())
                ->count(),
            'completed_bookings' => Booking::where('user_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'pending_bookings' => Booking::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'total_spent' => Booking::where('user_id', $user->id)
                ->where('status', 'completed')
                ->sum('total_amount'),
        ];

        // Get recent bookings
        $recentBookings = Booking::where('user_id', $user->id)
            ->with(['tasker', 'category', 'service'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get recent activity
        $recentActivity = [];

        // Add recent bookings to activity
        $bookings = Booking::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($bookings as $booking) {
            $recentActivity[] = [
                'type' => 'booking',
                'icon' => 'calendar-check',
                'message' => 'Booking #' . $booking->booking_number . ' - ' . ucfirst($booking->status),
                'time' => $booking->created_at->diffForHumans(),
            ];
        }

        // Add recent reviews to activity
        $reviews = Review::where('reviewer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        foreach ($reviews as $review) {
            $recentActivity[] = [
                'type' => 'review',
                'icon' => 'star',
                'message' => 'You left a ' . $review->rating . '-star review',
                'time' => $review->created_at->diffForHumans(),
            ];
        }

        // Sort activity by most recent
        usort($recentActivity, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        // Limit to 5 items
        $recentActivity = array_slice($recentActivity, 0, 5);

        return view('user.dashboard.index', compact(
            'user',
            'stats',
            'recentBookings',
            'recentActivity'
        ));
    }
}
