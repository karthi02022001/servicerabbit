@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($stats['total_users'] ?? 0) }}</h3>
                <p>Total Users</p>
                <div class="stat-change positive">
                    <i class="bi bi-arrow-up"></i>
                    <span>12% this month</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($stats['total_taskers'] ?? 0) }}</h3>
                <p>Active Taskers</p>
                <div class="stat-change positive">
                    <i class="bi bi-arrow-up"></i>
                    <span>8% this month</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($stats['total_bookings'] ?? 0) }}</h3>
                <p>Total Bookings</p>
                <div class="stat-change positive">
                    <i class="bi bi-arrow-up"></i>
                    <span>23% this month</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="stat-content">
                <h3>${{ number_format($stats['total_revenue'] ?? 0, 2) }}</h3>
                <p>Total Revenue</p>
                <div class="stat-change positive">
                    <i class="bi bi-arrow-up"></i>
                    <span>15% this month</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon danger">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($stats['pending_verifications'] ?? 0) }}</h3>
                <p>Pending Verifications</p>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($stats['pending_bookings'] ?? 0) }}</h3>
                <p>Pending Bookings</p>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($stats['completed_bookings'] ?? 0) }}</h3>
                <p>Completed Tasks</p>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="stat-content">
                <h3>${{ number_format($stats['pending_payouts'] ?? 0, 2) }}</h3>
                <p>Pending Payouts</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Bookings -->
    <div class="col-12 col-xl-8">
        <div class="admin-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Recent Bookings</h5>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary">
                    View All
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>Tasker</th>
                                <th>Service</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings ?? [] as $booking)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="fw-medium text-primary">
                                        #{{ $booking->booking_number }}
                                    </a>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-cell-avatar">
                                            {{ strtoupper(substr($booking->user->first_name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="user-cell-info">
                                            <div class="name">{{ $booking->user->first_name ?? '' }} {{ $booking->user->last_name ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $booking->tasker->first_name ?? '' }} {{ $booking->tasker->last_name ?? '' }}</td>
                                <td>{{ $booking->category->name ?? 'N/A' }}</td>
                                <td>${{ number_format($booking->total_amount, 2) }}</td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'badge-pending',
                                            'accepted' => 'badge-approved',
                                            'paid' => 'badge-approved',
                                            'in_progress' => 'badge-approved',
                                            'completed' => 'badge-approved',
                                            'cancelled' => 'badge-rejected',
                                            'declined' => 'badge-rejected',
                                            'disputed' => 'badge-pending',
                                            'refunded' => 'badge-inactive',
                                        ];
                                    @endphp
                                    <span class="badge-status {{ $statusClasses[$booking->status] ?? 'badge-inactive' }}">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </td>
                                <td>{{ $booking->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No bookings yet
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pending Verifications -->
    <div class="col-12 col-xl-4">
        <div class="admin-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Pending Verifications</h5>
                <a href="{{ route('admin.taskers.pending') }}" class="btn btn-sm btn-outline-secondary">
                    View All
                </a>
            </div>
            <div class="card-body">
                @forelse($pendingVerifications ?? [] as $tasker)
                <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="user-cell-avatar">
                            {{ strtoupper(substr($tasker->user->first_name ?? 'T', 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-medium">{{ $tasker->user->first_name ?? '' }} {{ $tasker->user->last_name ?? '' }}</div>
                            <small class="text-muted">{{ $tasker->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <a href="{{ route('admin.taskers.show', $tasker->id) }}" class="btn btn-sm btn-admin-primary">
                        Review
                    </a>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-check-circle fs-1 d-block mb-2"></i>
                    No pending verifications
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Recent Users -->
        <div class="admin-card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">New Users</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                    View All
                </a>
            </div>
            <div class="card-body">
                @forelse($recentUsers ?? [] as $user)
                <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                    <div class="user-cell-avatar">
                        {{ strtoupper(substr($user->first_name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-medium">{{ $user->first_name }} {{ $user->last_name }}</div>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-people fs-1 d-block mb-2"></i>
                    No recent users
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mt-2">
    <div class="col-12 col-xl-8">
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">Revenue Overview</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-xl-4">
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">Booking Status</h5>
            </div>
            <div class="card-body">
                <canvas id="bookingStatusChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData['months'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode($chartData['revenue'] ?? [0, 0, 0, 0, 0, 0]) !!},
            borderColor: '#FF6B35',
            backgroundColor: 'rgba(255, 107, 53, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#e9ecef'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Booking Status Chart
const statusCtx = document.getElementById('bookingStatusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Completed', 'Pending', 'In Progress', 'Cancelled'],
        datasets: [{
            data: {!! json_encode($chartData['bookingStatus'] ?? [40, 25, 20, 15]) !!},
            backgroundColor: [
                '#10b981',
                '#f59e0b',
                '#3b82f6',
                '#ef4444'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        },
        cutout: '70%'
    }
});
</script>
@endpush