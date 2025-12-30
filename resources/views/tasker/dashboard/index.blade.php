@extends('layouts.app')

@section('title', 'Tasker Dashboard')

@section('content')
<div class="dashboard-wrapper">
    <div class="container-fluid px-4 py-4">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3 col-xl-2">
                @include('tasker.partials.sidebar')
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10">
                <!-- Welcome Section -->
                <div class="welcome-section mb-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="welcome-content">
                                <span class="welcome-badge">
                                    <i class="bi bi-briefcase me-1"></i> Tasker Dashboard
                                </span>
                                <h1 class="welcome-title">
                                    Welcome back, {{ $user->first_name }}! 
                                    <span class="wave-emoji">👋</span>
                                </h1>
                                <p class="welcome-text">
                                    Here's what's happening with your business today. Manage your bookings, track earnings, and grow your services.
                                </p>
                                <div class="welcome-actions mt-3">
                                    @if($stats['pending_requests'] > 0)
                                        <a href="{{ Route::has('tasker.bookings.index') ? route('tasker.bookings.index', ['status' => 'pending']) : '#' }}" class="btn btn-light btn-lg me-2">
                                            <i class="bi bi-inbox me-2"></i> {{ $stats['pending_requests'] }} Pending Request{{ $stats['pending_requests'] > 1 ? 's' : '' }}
                                        </a>
                                    @else
                                        <a href="{{ route('tasker.services.index') }}" class="btn btn-light btn-lg me-2">
                                            <i class="bi bi-grid-3x3-gap me-2"></i> My Services
                                        </a>
                                    @endif
                                    <a href="{{ route('tasker.profile.earnings') }}" class="btn btn-outline-light btn-lg">
                                        <i class="bi bi-wallet2 me-2"></i> View Earnings
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="welcome-illustration">
                                <img src="https://illustrations.popsy.co/amber/business-success.svg" alt="Welcome" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="row g-4 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-primary">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="bi bi-calendar-day"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $stats['today_bookings'] }}</span>
                                    <span class="stat-label">Today's Tasks</span>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <a href="{{ Route::has('tasker.bookings.index') ? route('tasker.bookings.index') : '#' }}">View schedule <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-success">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">${{ number_format($stats['monthly_earnings'], 0) }}</span>
                                    <span class="stat-label">This Month</span>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <span class="text-success"><i class="bi bi-graph-up-arrow me-1"></i> Keep it up!</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-warning">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ number_format($stats['average_rating'], 1) }}</span>
                                    <span class="stat-label">Avg. Rating</span>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <span class="text-warning"><i class="bi bi-star me-1"></i> {{ $profile->total_reviews ?? 0 }} reviews</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-info">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $stats['completed_tasks'] }}</span>
                                    <span class="stat-label">Completed</span>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <span class="text-info"><i class="bi bi-trophy me-1"></i> Great work!</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="bi bi-lightning-charge text-warning me-2"></i>
                            Quick Actions
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <a href="{{ route('tasker.services.create') }}" class="quick-action-card">
                                    <div class="quick-action-icon bg-gradient-primary">
                                        <i class="bi bi-plus-lg"></i>
                                    </div>
                                    <span class="quick-action-title">Add Service</span>
                                    <span class="quick-action-desc">Create new offering</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="{{ route('tasker.availability.index') }}" class="quick-action-card">
                                    <div class="quick-action-icon bg-gradient-success">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <span class="quick-action-title">Availability</span>
                                    <span class="quick-action-desc">Set your schedule</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="{{ route('tasker.profile.edit') }}" class="quick-action-card">
                                    <div class="quick-action-icon bg-gradient-info">
                                        <i class="bi bi-person-gear"></i>
                                    </div>
                                    <span class="quick-action-title">Edit Profile</span>
                                    <span class="quick-action-desc">Update your info</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="{{ route('tasker.profile.earnings') }}" class="quick-action-card">
                                    <div class="quick-action-icon bg-gradient-purple">
                                        <i class="bi bi-wallet2"></i>
                                    </div>
                                    <span class="quick-action-title">Earnings</span>
                                    <span class="quick-action-desc">Track your income</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Two Column Section -->
                <div class="row g-4 mb-4">
                    <!-- Pending Requests -->
                    <div class="col-lg-6">
                        <div class="section-card h-100">
                            <div class="section-header d-flex justify-content-between align-items-center">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-inbox text-warning me-2"></i>
                                    Pending Requests
                                </h5>
                                @if($pendingRequests->count() > 0)
                                <a href="{{ Route::has('tasker.bookings.index') ? route('tasker.bookings.index', ['status' => 'pending']) : '#' }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    View All
                                </a>
                                @endif
                            </div>
                            <div class="section-body">
                                @forelse($pendingRequests as $booking)
                                <div class="booking-item {{ !$loop->last ? 'mb-3' : '' }}">
                                    <div class="booking-item-avatar">
                                        @if($booking->user->avatar)
                                            <img src="{{ asset('storage/' . $booking->user->avatar) }}" alt="">
                                        @else
                                            <span>{{ strtoupper(substr($booking->user->first_name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div class="booking-item-content">
                                        <h6 class="booking-item-title">{{ $booking->user->full_name }}</h6>
                                        <p class="booking-item-meta">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $booking->booking_date->format('M d, Y') }}
                                            <span class="mx-1">•</span>
                                            <i class="bi bi-clock me-1"></i>
                                            {{ date('g:i A', strtotime($booking->start_time)) }}
                                        </p>
                                    </div>
                                    <div class="booking-item-action">
                                        <span class="booking-price">${{ number_format($booking->tasker_payout, 0) }}</span>
                                        <div class="action-buttons mt-2">
                                            <button class="btn btn-sm btn-success rounded-pill" title="Accept">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger rounded-pill" title="Decline">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h6 class="empty-state-title">No pending requests</h6>
                                    <p class="empty-state-text">You're all caught up! New requests will appear here.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Tasks -->
                    <div class="col-lg-6">
                        <div class="section-card h-100">
                            <div class="section-header d-flex justify-content-between align-items-center">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-calendar-check text-primary me-2"></i>
                                    Upcoming Tasks
                                </h5>
                                @if($upcomingBookings->count() > 0)
                                <a href="{{ Route::has('tasker.bookings.index') ? route('tasker.bookings.index') : '#' }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    View All
                                </a>
                                @endif
                            </div>
                            <div class="section-body">
                                @forelse($upcomingBookings as $booking)
                                <div class="booking-item {{ !$loop->last ? 'mb-3' : '' }}">
                                    <div class="booking-item-icon">
                                        <i class="bi bi-calendar2-check"></i>
                                    </div>
                                    <div class="booking-item-content">
                                        <h6 class="booking-item-title">{{ $booking->category->name ?? $booking->service->title ?? 'Service' }}</h6>
                                        <p class="booking-item-meta">
                                            <i class="bi bi-person me-1"></i>
                                            {{ $booking->user->full_name }}
                                            <span class="mx-1">•</span>
                                            <i class="bi bi-clock me-1"></i>
                                            {{ date('g:i A', strtotime($booking->start_time)) }}
                                        </p>
                                    </div>
                                    <div class="booking-item-status">
                                        <span class="status-badge status-{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                        <small class="d-block text-muted mt-1">{{ $booking->booking_date->format('M d') }}</small>
                                    </div>
                                </div>
                                @empty
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-calendar-x"></i>
                                    </div>
                                    <h6 class="empty-state-title">No upcoming tasks</h6>
                                    <p class="empty-state-text">Your schedule is clear for now.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings Chart & Reviews -->
                <div class="row g-4 mb-4">
                    <!-- Earnings Chart -->
                    <div class="col-lg-8">
                        <div class="section-card h-100">
                            <div class="section-header d-flex justify-content-between align-items-center">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-graph-up text-success me-2"></i>
                                    Earnings (Last 7 Days)
                                </h5>
                                <a href="{{ route('tasker.profile.earnings') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    View Details
                                </a>
                            </div>
                            <div class="section-body">
                                <canvas id="earningsChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Reviews -->
                    <div class="col-lg-4">
                        <div class="section-card h-100">
                            <div class="section-header">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-star text-warning me-2"></i>
                                    Recent Reviews
                                </h5>
                            </div>
                            <div class="section-body">
                                @forelse($recentReviews as $review)
                                <div class="review-item {{ !$loop->last ? 'mb-3' : '' }}">
                                    <div class="review-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="review-text">{{ Str::limit($review->comment, 80) }}</p>
                                    <div class="review-footer">
                                        <span class="reviewer">{{ $review->reviewer_display_name ?? 'Anonymous' }}</span>
                                        <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                @empty
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <h6 class="empty-state-title">No reviews yet</h6>
                                    <p class="empty-state-text">Complete tasks to get reviews</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Overview -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="bi bi-bar-chart text-info me-2"></i>
                            Performance Overview
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="row g-4">
                            <div class="col-6 col-md-3">
                                <div class="performance-card">
                                    <div class="performance-circle" style="--progress: {{ $stats['response_rate'] }}; --color: #10b981;">
                                        <svg viewBox="0 0 36 36">
                                            <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                            <path class="circle-progress" stroke-dasharray="{{ $stats['response_rate'] }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                        </svg>
                                        <span class="circle-value">{{ $stats['response_rate'] }}%</span>
                                    </div>
                                    <span class="performance-label">Response Rate</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="performance-card">
                                    <div class="performance-circle" style="--progress: {{ $stats['completion_rate'] }}; --color: #3b82f6;">
                                        <svg viewBox="0 0 36 36">
                                            <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                            <path class="circle-progress" stroke-dasharray="{{ $stats['completion_rate'] }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                        </svg>
                                        <span class="circle-value">{{ $stats['completion_rate'] }}%</span>
                                    </div>
                                    <span class="performance-label">Completion Rate</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="performance-card">
                                    <div class="performance-value">${{ number_format($stats['total_earnings'], 0) }}</div>
                                    <span class="performance-label">Total Earned</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="performance-card">
                                    <div class="performance-value">{{ $stats['active_services'] }}</div>
                                    <span class="performance-label">Active Services</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- My Services Summary -->
                <div class="section-card">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <h5 class="section-title mb-0">
                            <i class="bi bi-grid-3x3-gap text-primary me-2"></i>
                            My Services
                        </h5>
                        <a href="{{ route('tasker.services.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            Manage Services
                        </a>
                    </div>
                    <div class="section-body">
                        <div class="row g-3">
                            @php
                                $services = auth()->user()->taskerProfile?->services()->where('is_active', true)->take(6)->get() ?? collect();
                            @endphp
                            @forelse($services as $service)
                            <div class="col-6 col-md-4 col-lg-2">
                                <a href="{{ route('tasker.services.edit', $service) }}" class="service-card-mini">
                                    <div class="service-icon bg-{{ ['primary', 'success', 'warning', 'info', 'purple', 'danger'][$loop->index % 6] }}-subtle">
                                        <i class="bi bi-briefcase text-{{ ['primary', 'success', 'warning', 'info', 'purple', 'danger'][$loop->index % 6] }}"></i>
                                    </div>
                                    <span class="service-name">{{ Str::limit($service->title ?? $service->category->name ?? 'Service', 15) }}</span>
                                    <span class="service-price">${{ number_format($service->hourly_rate, 0) }}/hr</span>
                                </a>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="empty-state py-4">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-grid-3x3-gap"></i>
                                    </div>
                                    <h6 class="empty-state-title">No services yet</h6>
                                    <p class="empty-state-text">Add your first service to start getting bookings</p>
                                    <a href="{{ route('tasker.services.create') }}" class="btn btn-primary btn-sm rounded-pill">
                                        <i class="bi bi-plus-lg me-1"></i> Add Service
                                    </a>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Wrapper */
.dashboard-wrapper {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    min-height: calc(100vh - 76px);
}

/* Welcome Section */
.welcome-section {
    background: linear-gradient(135deg, #FF6B35 0%, #ff8c5a 50%, #ffab7a 100%);
    border-radius: 24px;
    padding: 2.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(255, 107, 53, 0.3);
}

.welcome-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: rotate 20s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.welcome-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0.35rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    margin-bottom: 1rem;
}

.welcome-title {
    color: white;
    font-size: 2.25rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    position: relative;
}

.wave-emoji {
    display: inline-block;
    animation: wave 2.5s infinite;
    transform-origin: 70% 70%;
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    10% { transform: rotate(14deg); }
    20% { transform: rotate(-8deg); }
    30% { transform: rotate(14deg); }
    40% { transform: rotate(-4deg); }
    50% { transform: rotate(10deg); }
    60% { transform: rotate(0deg); }
}

.welcome-text {
    color: rgba(255,255,255,0.9);
    font-size: 1.1rem;
    margin-bottom: 0;
    max-width: 500px;
    position: relative;
}

.welcome-actions .btn-light {
    background: white;
    color: #FF6B35;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    border: none;
    transition: all 0.3s;
}

.welcome-actions .btn-light:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

.welcome-actions .btn-outline-light {
    border: 2px solid rgba(255,255,255,0.5);
    color: white;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
}

.welcome-actions .btn-outline-light:hover {
    background: rgba(255,255,255,0.1);
    border-color: white;
}

.welcome-illustration img {
    max-height: 200px;
    position: relative;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}

/* Stat Cards */
.stat-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.stat-card-body {
    padding: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stat-primary .stat-icon { background: rgba(255, 107, 53, 0.1); color: #FF6B35; }
.stat-success .stat-icon { background: rgba(16, 185, 129, 0.1); color: #10b981; }
.stat-warning .stat-icon { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
.stat-info .stat-icon { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }

.stat-content {
    flex: 1;
}

.stat-value {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    display: block;
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
}

.stat-footer {
    padding: 0.75rem 1.5rem;
    background: #f9fafb;
    border-top: 1px solid #f3f4f6;
    font-size: 0.8rem;
}

.stat-footer a {
    color: #FF6B35;
    text-decoration: none;
    font-weight: 500;
}

.stat-footer a:hover {
    text-decoration: underline;
}

/* Section Card */
.section-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    overflow: hidden;
}

.section-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f3f4f6;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.section-body {
    padding: 1.5rem;
}

/* Quick Actions */
.quick-action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 1.5rem 1rem;
    background: #f9fafb;
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.quick-action-card:hover {
    background: white;
    border-color: #FF6B35;
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(255, 107, 53, 0.15);
}

.quick-action-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-bottom: 1rem;
}

.bg-gradient-primary { background: linear-gradient(135deg, #FF6B35, #ff8c5a); }
.bg-gradient-success { background: linear-gradient(135deg, #10b981, #34d399); }
.bg-gradient-info { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
.bg-gradient-purple { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }

.quick-action-title {
    display: block;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.quick-action-desc {
    display: block;
    font-size: 0.8rem;
    color: #6b7280;
}

/* Booking Item */
.booking-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 12px;
    transition: all 0.3s;
}

.booking-item:hover {
    background: #f3f4f6;
}

.booking-item-icon,
.booking-item-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
    overflow: hidden;
}

.booking-item-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.booking-item-avatar span {
    font-weight: 600;
}

.booking-item-content {
    flex: 1;
    min-width: 0;
}

.booking-item-title {
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    font-size: 0.95rem;
}

.booking-item-meta {
    font-size: 0.8rem;
    color: #6b7280;
    margin: 0;
}

.booking-item-action {
    text-align: right;
    flex-shrink: 0;
}

.booking-price {
    display: block;
    font-weight: 700;
    color: #10b981;
    font-size: 1.1rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

/* Status Badge */
.status-badge {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-pending { background: #fef3c7; color: #d97706; }
.status-accepted { background: #dbeafe; color: #2563eb; }
.status-paid { background: #e0e7ff; color: #4f46e5; }
.status-in_progress { background: #dbeafe; color: #2563eb; }
.status-completed { background: #d1fae5; color: #059669; }
.status-cancelled { background: #fee2e2; color: #dc2626; }
.status-declined { background: #fee2e2; color: #dc2626; }

/* Review Item */
.review-item {
    padding: 1rem;
    background: #f9fafb;
    border-radius: 12px;
}

.review-stars i {
    font-size: 0.85rem;
    color: #fbbf24;
}

.review-text {
    font-size: 0.9rem;
    color: #4b5563;
    margin: 0.5rem 0;
    line-height: 1.5;
}

.review-footer {
    display: flex;
    justify-content: space-between;
    font-size: 0.8rem;
    color: #9ca3af;
}

.reviewer {
    font-weight: 500;
    color: #6b7280;
}

/* Performance Card */
.performance-card {
    text-align: center;
    padding: 1rem;
}

.performance-circle {
    position: relative;
    width: 100px;
    height: 100px;
    margin: 0 auto 1rem;
}

.performance-circle svg {
    transform: rotate(-90deg);
    width: 100%;
    height: 100%;
}

.performance-circle .circle-bg {
    fill: none;
    stroke: #e5e7eb;
    stroke-width: 3;
}

.performance-circle .circle-progress {
    fill: none;
    stroke: var(--color, #10b981);
    stroke-width: 3;
    stroke-linecap: round;
}

.performance-circle .circle-value {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
}

.performance-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
}

.performance-label {
    display: block;
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
}

/* Service Card Mini */
.service-card-mini {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 1.25rem 1rem;
    background: #f9fafb;
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.service-card-mini:hover {
    background: white;
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.service-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 0.75rem;
}

.bg-primary-subtle { background: rgba(255, 107, 53, 0.1); }
.bg-success-subtle { background: rgba(16, 185, 129, 0.1); }
.bg-warning-subtle { background: rgba(245, 158, 11, 0.1); }
.bg-info-subtle { background: rgba(59, 130, 246, 0.1); }
.bg-purple-subtle { background: rgba(139, 92, 246, 0.1); }
.bg-danger-subtle { background: rgba(239, 68, 68, 0.1); }

.text-primary { color: #FF6B35 !important; }
.text-purple { color: #8b5cf6 !important; }

.service-name {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.25rem;
}

.service-price {
    display: block;
    font-size: 0.8rem;
    color: #10b981;
    font-weight: 600;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 2rem 1rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    background: #f3f4f6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    color: #9ca3af;
}

.empty-state-title {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.25rem;
}

.empty-state-text {
    font-size: 0.9rem;
    color: #6b7280;
    margin-bottom: 1rem;
}

/* Responsive */
@media (max-width: 991.98px) {
    .welcome-section {
        padding: 2rem;
    }
    
    .welcome-title {
        font-size: 1.75rem;
    }
}

@media (max-width: 767.98px) {
    .welcome-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .welcome-actions .btn {
        width: 100%;
    }
    
    .stat-value {
        font-size: 1.5rem;
    }
    
    .quick-action-card {
        padding: 1rem;
    }
    
    .quick-action-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    
    .booking-item {
        flex-wrap: wrap;
    }
    
    .booking-item-action {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid #e5e7eb;
    }
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('earningsChart');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($earningsChart['labels'] ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!},
                datasets: [{
                    label: 'Earnings ($)',
                    data: {!! json_encode($earningsChart['data'] ?? [0, 0, 0, 0, 0, 0, 0]) !!},
                    backgroundColor: 'rgba(255, 107, 53, 0.8)',
                    borderRadius: 8,
                    borderSkipped: false,
                    maxBarThickness: 50
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return '$' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            },
                            font: { size: 11 },
                            color: '#9ca3af'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 11 },
                            color: '#6b7280'
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush