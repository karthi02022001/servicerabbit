<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TaskerProfile;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(): View
    {
        $admin = Auth::guard('admin')->user();

        // Get overview statistics - include ALL keys the view expects
        $stats = [
            // User stats
            'total_users' => User::where('is_tasker', false)->count(),
            'total_taskers' => User::where('is_tasker', true)->count(),

            // Verification stats
            'pending_verifications' => TaskerProfile::where('verification_status', 'submitted')->count(),

            // Booking stats
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'bookings_this_month' => Booking::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),

            // Revenue stats
            'total_revenue' => Transaction::where('type', 'commission')
                ->where('status', 'completed')
                ->sum('amount'),
            'revenue_this_month' => Transaction::where('type', 'commission')
                ->where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),

            // Payout stats
            'pending_payouts' => Transaction::where('type', 'payout')
                ->where('status', 'pending')
                ->sum('amount'),
        ];

        // Get recent bookings
        $recentBookings = Booking::with(['user', 'tasker', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get pending tasker verifications
        $pendingVerifications = TaskerProfile::with('user')
            ->where('verification_status', 'submitted')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Alias for blade compatibility
        $pendingTaskers = $pendingVerifications;

        // Get recent users
        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Monthly revenue chart data (last 6 months)
        $months = [];
        $revenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            $revenue[] = Transaction::where('type', 'commission')
                ->where('status', 'completed')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('amount') ?? 0;
        }

        // Booking status distribution for chart
        $bookingsByStatus = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Chart data formatted for JavaScript
        $chartData = [
            'months' => $months,
            'revenue' => $revenue,
            'bookingStatus' => [
                $bookingsByStatus['completed'] ?? 0,
                $bookingsByStatus['pending'] ?? 0,
                $bookingsByStatus['in_progress'] ?? 0,
                $bookingsByStatus['cancelled'] ?? 0,
            ],
        ];

        return view('admin.dashboard.index', compact(
            'admin',
            'stats',
            'recentBookings',
            'pendingVerifications',
            'pendingTaskers',
            'recentUsers',
            'chartData'
        ));
    }
}
