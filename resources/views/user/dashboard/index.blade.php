@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-wrapper">
    <div class="container-fluid px-4 py-4">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3 col-xl-2">
                @include('user.partials.sidebar')
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10">
                <!-- Welcome Section -->
                <div class="welcome-section mb-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="welcome-content">
                                <span class="welcome-badge">
                                    <i class="bi bi-stars me-1"></i> Welcome back
                                </span>
                                <h1 class="welcome-title">
                                    Hello, {{ $user->first_name }}! 
                                    <span class="wave-emoji">👋</span>
                                </h1>
                                <p class="welcome-text">
                                    Ready to get things done? Find skilled taskers for your home projects, errands, and more.
                                </p>
                                <div class="welcome-actions mt-3">
                                    <a href="{{ route('home') }}" class="btn btn-light btn-lg me-2">
                                        <i class="bi bi-search me-2"></i> Find a Tasker
                                    </a>
                                    <a href="{{ route('user.bookings.index') }}" class="btn btn-outline-light btn-lg">
                                        <i class="bi bi-calendar-check me-2"></i> View Bookings
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="welcome-illustration">
                                <img src="https://illustrations.popsy.co/amber/man-riding-a-rocket.svg" alt="Welcome" class="img-fluid">
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
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $stats['total_bookings'] ?? 0 }}</span>
                                    <span class="stat-label">Total Bookings</span>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <a href="{{ route('user.bookings.index') }}">View all <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-success">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $stats['completed_bookings'] ?? 0 }}</span>
                                    <span class="stat-label">Completed</span>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <span class="text-success"><i class="bi bi-graph-up-arrow me-1"></i> Great progress!</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-warning">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $stats['pending_bookings'] ?? 0 }}</span>
                                    <span class="stat-label">Pending</span>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <span class="text-warning"><i class="bi bi-hourglass-split me-1"></i> In progress</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-info">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $stats['total_reviews'] ?? 0 }}</span>
                                    <span class="stat-label">Reviews Given</span>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <a href="{{ route('user.reviews.index') }}">See reviews <i class="bi bi-arrow-right"></i></a>
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
                                <a href="{{ route('home') }}" class="quick-action-card">
                                    <div class="quick-action-icon bg-gradient-primary">
                                        <i class="bi bi-search"></i>
                                    </div>
                                    <span class="quick-action-title">Browse Services</span>
                                    <span class="quick-action-desc">Find taskers near you</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="{{ route('user.bookings.index') }}" class="quick-action-card">
                                    <div class="quick-action-icon bg-gradient-success">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <span class="quick-action-title">My Bookings</span>
                                    <span class="quick-action-desc">Track your tasks</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="{{ route('user.messages.index') }}" class="quick-action-card">
                                    <div class="quick-action-icon bg-gradient-info">
                                        <i class="bi bi-chat-dots"></i>
                                    </div>
                                    <span class="quick-action-title">Messages</span>
                                    <span class="quick-action-desc">Chat with taskers</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="{{ route('user.profile.edit') }}" class="quick-action-card">
                                    <div class="quick-action-icon bg-gradient-purple">
                                        <i class="bi bi-person-gear"></i>
                                    </div>
                                    <span class="quick-action-title">Settings</span>
                                    <span class="quick-action-desc">Manage your profile</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Two Column Section -->
                <div class="row g-4 mb-4">
                    <!-- Upcoming Bookings -->
                    <div class="col-lg-6">
                        <div class="section-card h-100">
                            <div class="section-header d-flex justify-content-between align-items-center">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-calendar-event text-primary me-2"></i>
                                    Upcoming Bookings
                                </h5>
                                <a href="{{ route('user.bookings.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    View All
                                </a>
                            </div>
                            <div class="section-body">
                                @forelse($upcomingBookings ?? [] as $booking)
                                <div class="booking-item {{ !$loop->last ? 'mb-3' : '' }}">
                                    <div class="booking-item-icon">
                                        <i class="bi bi-calendar2-check"></i>
                                    </div>
                                    <div class="booking-item-content">
                                        <h6 class="booking-item-title">{{ $booking->category->name ?? 'Service' }}</h6>
                                        <p class="booking-item-meta">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                            <span class="mx-1">•</span>
                                            {{ $booking->time_slot ?? 'TBD' }}
                                        </p>
                                    </div>
                                    <div class="booking-item-status">
                                        <span class="status-badge status-{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>
                                @empty
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-calendar-x"></i>
                                    </div>
                                    <h6 class="empty-state-title">No upcoming bookings</h6>
                                    <p class="empty-state-text">Ready to get something done?</p>
                                    <a href="{{ route('home') }}" class="btn btn-primary btn-sm rounded-pill">
                                        <i class="bi bi-search me-1"></i> Find a Tasker
                                    </a>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="col-lg-6">
                        <div class="section-card h-100">
                            <div class="section-header d-flex justify-content-between align-items-center">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-activity text-success me-2"></i>
                                    Recent Activity
                                </h5>
                                <a href="{{ route('user.bookings.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    View All
                                </a>
                            </div>
                            <div class="section-body">
                                @forelse($recentBookings ?? [] as $booking)
                                <div class="activity-item {{ !$loop->last ? 'mb-3' : '' }}">
                                    <div class="activity-avatar">
                                        @if($booking->tasker && $booking->tasker->avatar)
                                            <img src="{{ asset('storage/' . $booking->tasker->avatar) }}" alt="">
                                        @else
                                            <span>{{ substr($booking->tasker->first_name ?? 'T', 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div class="activity-content">
                                        <h6 class="activity-title">{{ $booking->category->name ?? 'Service' }}</h6>
                                        <p class="activity-meta">
                                            {{ $booking->tasker->first_name ?? 'Tasker' }} {{ $booking->tasker->last_name ?? '' }}
                                            <span class="mx-1">•</span>
                                            {{ $booking->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="activity-status">
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'accepted' => 'info',
                                                'paid' => 'primary',
                                                'in_progress' => 'primary',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                'declined' => 'danger',
                                            ];
                                        @endphp
                                        <span class="status-badge status-{{ $booking->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                    </div>
                                </div>
                                @empty
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h6 class="empty-state-title">No recent activity</h6>
                                    <p class="empty-state-text">Your booking history will appear here</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Become a Tasker CTA -->
                @if(!$user->is_tasker)
                <div class="tasker-cta-card">
                    <div class="tasker-cta-content">
                        <div class="tasker-cta-icon">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <div class="tasker-cta-text">
                            <h4>Start Earning Money Today!</h4>
                            <p>Join thousands of taskers and turn your skills into income. Set your own hours, choose your tasks, and get paid.</p>
                        </div>
                        <div class="tasker-cta-action">
                            <a href="{{ route('become-tasker') }}" class="btn btn-light btn-lg">
                                Become a Tasker <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="tasker-cta-decoration">
                        <div class="decoration-circle circle-1"></div>
                        <div class="decoration-circle circle-2"></div>
                        <div class="decoration-circle circle-3"></div>
                    </div>
                </div>
                @endif

                <!-- Popular Categories -->
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="bi bi-grid text-primary me-2"></i>
                            Popular Services
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="row g-3">
                            @php
                                $categories = [
                                    ['name' => 'Home Cleaning', 'icon' => 'bi-house-heart', 'color' => 'primary'],
                                    ['name' => 'Furniture Assembly', 'icon' => 'bi-box-seam', 'color' => 'success'],
                                    ['name' => 'Moving Help', 'icon' => 'bi-truck', 'color' => 'warning'],
                                    ['name' => 'Handyman', 'icon' => 'bi-tools', 'color' => 'info'],
                                    ['name' => 'Yard Work', 'icon' => 'bi-flower1', 'color' => 'success'],
                                    ['name' => 'Painting', 'icon' => 'bi-brush', 'color' => 'purple'],
                                ];
                            @endphp
                            @foreach($categories as $category)
                            <div class="col-6 col-md-4 col-lg-2">
                                <a href="{{ route('categories.index') }}" class="category-card">
                                    <div class="category-icon bg-{{ $category['color'] }}-subtle">
                                        <i class="bi {{ $category['icon'] }} text-{{ $category['color'] }}"></i>
                                    </div>
                                    <span class="category-name">{{ $category['name'] }}</span>
                                </a>
                            </div>
                            @endforeach
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

.booking-item-icon {
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

/* Activity Item */
.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 12px;
    transition: all 0.3s;
}

.activity-item:hover {
    background: #f3f4f6;
}

.activity-avatar {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    flex-shrink: 0;
    overflow: hidden;
}

.activity-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-title {
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    font-size: 0.95rem;
}

.activity-meta {
    font-size: 0.8rem;
    color: #6b7280;
    margin: 0;
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

/* Tasker CTA */
.tasker-cta-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 24px;
    padding: 2.5rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.tasker-cta-content {
    display: flex;
    align-items: center;
    gap: 2rem;
    position: relative;
    z-index: 1;
}

.tasker-cta-icon {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    flex-shrink: 0;
}

.tasker-cta-text {
    flex: 1;
}

.tasker-cta-text h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.tasker-cta-text p {
    color: rgba(255,255,255,0.9);
    margin: 0;
    font-size: 0.95rem;
}

.tasker-cta-action .btn-light {
    background: white;
    color: #764ba2;
    font-weight: 600;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    border: none;
    transition: all 0.3s;
}

.tasker-cta-action .btn-light:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.tasker-cta-decoration {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.decoration-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
}

.circle-1 { width: 200px; height: 200px; top: -100px; right: -50px; }
.circle-2 { width: 150px; height: 150px; bottom: -75px; right: 100px; }
.circle-3 { width: 100px; height: 100px; top: 50%; left: 10%; }

/* Category Card */
.category-card {
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

.category-card:hover {
    background: white;
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.category-icon {
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

.text-purple { color: #8b5cf6; }

.category-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: #374151;
}

/* Responsive */
@media (max-width: 991.98px) {
    .welcome-section {
        padding: 2rem;
    }
    
    .welcome-title {
        font-size: 1.75rem;
    }
    
    .tasker-cta-content {
        flex-direction: column;
        text-align: center;
    }
    
    .tasker-cta-action {
        margin-top: 1rem;
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
}
</style>
@endsection