@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            @include('user.partials.sidebar')
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Welcome Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Welcome back, {{ auth()->user()->first_name }}!</h2>
                    <p class="text-muted mb-0">Here's what's happening with your bookings</p>
                </div>
                <a href="{{ route('categories.index') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Book a Service
                </a>
            </div>
            
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                        <i class="bi bi-calendar-event text-primary fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">{{ $stats['upcoming_bookings'] ?? 0 }}</h3>
                                    <small class="text-muted">Upcoming</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                        <i class="bi bi-check-circle text-success fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">{{ $stats['completed_bookings'] ?? 0 }}</h3>
                                    <small class="text-muted">Completed</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                        <i class="bi bi-hourglass-split text-warning fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">{{ $stats['pending_bookings'] ?? 0 }}</h3>
                                    <small class="text-muted">Pending</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                        <i class="bi bi-currency-dollar text-info fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">${{ number_format($stats['total_spent'] ?? 0, 2) }}</h3>
                                    <small class="text-muted">Total Spent</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Recent Bookings -->
                <div class="col-xl-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Bookings</h5>
                            <a href="{{ route('user.bookings.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body p-0">
                            @forelse($recentBookings ?? [] as $booking)
                                <div class="d-flex align-items-center p-3 border-bottom">
                                    <div class="flex-shrink-0">
                                        <div class="rounded bg-light p-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-briefcase text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ $booking->category->name ?? 'Service' }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-person me-1"></i>{{ $booking->tasker->first_name ?? '' }} {{ $booking->tasker->last_name ?? '' }}
                                            <span class="mx-2">•</span>
                                            <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'accepted' => 'info',
                                                'paid' => 'info',
                                                'in_progress' => 'primary',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                'declined' => 'danger',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$booking->status] ?? 'secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                        <div class="fw-bold mt-1">${{ number_format($booking->total_amount ?? 0, 2) }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="bi bi-calendar-x display-4 text-muted"></i>
                                    <p class="text-muted mt-2 mb-3">No bookings yet</p>
                                    <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm">Browse Services</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions & Activity -->
                <div class="col-xl-4">
                    <!-- Quick Actions -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('categories.index') }}" class="d-flex align-items-center text-decoration-none text-dark p-2 rounded hover-bg-light mb-2">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                    <i class="bi bi-search text-primary"></i>
                                </div>
                                <span>Find a Tasker</span>
                                <i class="bi bi-chevron-right ms-auto text-muted"></i>
                            </a>
                            <a href="{{ route('user.bookings.index') }}" class="d-flex align-items-center text-decoration-none text-dark p-2 rounded hover-bg-light mb-2">
                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                    <i class="bi bi-calendar-check text-success"></i>
                                </div>
                                <span>View Bookings</span>
                                <i class="bi bi-chevron-right ms-auto text-muted"></i>
                            </a>
                            <a href="{{ route('user.profile.edit') }}" class="d-flex align-items-center text-decoration-none text-dark p-2 rounded hover-bg-light mb-2">
                                <div class="rounded-circle bg-info bg-opacity-10 p-2 me-3">
                                    <i class="bi bi-person-gear text-info"></i>
                                </div>
                                <span>Edit Profile</span>
                                <i class="bi bi-chevron-right ms-auto text-muted"></i>
                            </a>
                            @if(!auth()->user()->is_tasker)
                            <a href="{{ route('become-tasker') }}" class="d-flex align-items-center text-decoration-none text-dark p-2 rounded bg-warning bg-opacity-10 border border-warning border-opacity-25">
                                <div class="rounded-circle bg-warning bg-opacity-25 p-2 me-3">
                                    <i class="bi bi-briefcase text-warning"></i>
                                </div>
                                <span>Become a Tasker</span>
                                <i class="bi bi-chevron-right ms-auto text-muted"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Recent Activity -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Recent Activity</h5>
                        </div>
                        <div class="card-body">
                            @forelse($recentActivity ?? [] as $activity)
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-circle bg-light p-2">
                                            <i class="bi bi-{{ $activity['icon'] ?? 'circle' }} text-{{ $activity['type'] == 'booking' ? 'primary' : ($activity['type'] == 'review' ? 'warning' : 'secondary') }}"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0 small">{{ $activity['message'] ?? '' }}</p>
                                        <small class="text-muted">{{ $activity['time'] ?? '' }}</small>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted">
                                    <i class="bi bi-activity fs-3 d-block mb-2"></i>
                                    <small>No recent activity</small>
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
.hover-bg-light:hover {
    background-color: #f8f9fa;
}
</style>
@endsection