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
            'total_bookings' => Booking::where('user_id', $user->id)->count(),
            'completed_bookings' => Booking::where('user_id', $user->id)->where('status', 'completed')->count(),
            'pending_bookings' => Booking::where('user_id', $user->id)->whereIn('status', ['pending', 'accepted'])->count(),
            'total_reviews' => Review::where('reviewer_id', $user->id)->count(),
        ];

        // Get recent bookings
        $recentBookings = Booking::with(['tasker', 'category'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get upcoming bookings
        $upcomingBookings = Booking::with(['tasker', 'category'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['accepted', 'paid'])
            ->where('booking_date', '>=', now()->toDateString())
            ->orderBy('booking_date', 'asc')
            ->take(3)
            ->get();

        return view('user.dashboard.index', compact(
            'user',
            'stats',
            'recentBookings',
            'upcomingBookings'
        ));
    }
}