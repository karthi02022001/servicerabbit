<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivityLog;
use App\Models\Booking;
use App\Models\Role;
use App\Models\TaskCategory;
use App\Models\TaskerProfile;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $stats = $this->getStats();
        $recentActivity = $this->getRecentActivity();

        return view('admin.dashboard.index', compact('stats', 'recentActivity'));
    }

    /**
     * Get dashboard statistics.
     */
    private function getStats(): array
    {
        // Users stats
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $newUsersToday = User::whereDate('created_at', today())->count();

        // Taskers stats
        $totalTaskers = User::where('is_tasker', true)->count();
        $verifiedTaskers = 0;
        $pendingTaskers = 0;

        if (Schema::hasTable('tasker_profiles')) {
            $verifiedTaskers = TaskerProfile::where('verification_status', 'approved')->count();
            $pendingTaskers = TaskerProfile::where('verification_status', 'submitted')->count();
        }

        // Bookings stats
        $totalBookings = 0;
        $activeBookings = 0;
        $bookingsThisMonth = 0;
        $disputedBookings = 0;

        if (Schema::hasTable('bookings')) {
            $totalBookings = Booking::count();
            $activeBookings = Booking::whereIn('status', ['pending', 'accepted', 'in_progress'])->count();
            $bookingsThisMonth = Booking::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            $disputedBookings = Booking::where('status', 'disputed')->count();
        }

        // Revenue stats
        $totalRevenue = 0;
        $revenueThisMonth = 0;

        if (Schema::hasTable('bookings')) {
            $totalRevenue = Booking::where('status', 'completed')->sum('commission_amount') ?? 0;
            $revenueThisMonth = Booking::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('commission_amount') ?? 0;
        }

        // Reviews stats
        $pendingReviews = 0;
        if (Schema::hasTable('reviews')) {
            $pendingReviews = Review::where('status', 'pending')->count();
        }

        // Categories stats
        $totalCategories = 0;
        if (Schema::hasTable('task_categories')) {
            $totalCategories = TaskCategory::count();
        }

        // Admin stats
        $totalAdmins = Admin::count();
        $totalRoles = Role::count();

        return [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers ?: $totalUsers,
            'new_users_today' => $newUsersToday,
            'total_taskers' => $totalTaskers,
            'verified_taskers' => $verifiedTaskers,
            'pending_taskers' => $pendingTaskers,
            'total_bookings' => $totalBookings,
            'active_bookings' => $activeBookings,
            'bookings_this_month' => $bookingsThisMonth,
            'disputed_bookings' => $disputedBookings,
            'total_revenue' => $totalRevenue,
            'revenue_this_month' => $revenueThisMonth,
            'pending_reviews' => $pendingReviews,
            'total_categories' => $totalCategories,
            'total_admins' => $totalAdmins,
            'total_roles' => $totalRoles,
        ];
    }

    /**
     * Get recent admin activity.
     */
    private function getRecentActivity()
    {
        return AdminActivityLog::with('admin')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
    }
}
