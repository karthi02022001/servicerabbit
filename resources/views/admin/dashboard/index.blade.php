@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back! Here\'s your service overview.')

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner d-flex flex-column flex-md-row justify-content-between align-items-center">
    <div class="welcome-content">
        <div class="welcome-label">Welcome Back</div>
        <h1 class="welcome-title">{{ Auth::guard('admin')->user()->full_name }}</h1>
        <div class="welcome-date">
            <i class="bi bi-calendar3"></i>
            {{ now()->format('l, F d, Y') }}
        </div>
    </div>
    <div class="welcome-actions mt-3 mt-md-0">
        @if(Route::has('admin.taskers.pending'))
        <a href="{{ route('admin.taskers.pending') }}" class="btn btn-light">
            <i class="bi bi-plus-lg"></i> New Tasker
        </a>
        @endif
        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-light">
            <i class="bi bi-activity"></i> Activity Log
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon primary">
                    <i class="bi bi-people-fill"></i>
                </div>
                <span class="stat-change up">
                    <i class="bi bi-arrow-up"></i> 12%
                </span>
            </div>
            <div class="stat-value">{{ number_format($stats['total_users'] ?? 0) }}</div>
            <div class="stat-label">Total Users</div>
            <div class="stat-progress">
                <div class="stat-progress-bar primary" style="width: 75%"></div>
            </div>
            <div class="stat-footer">
                <span>Active Users</span>
                <span>{{ $stats['active_users'] ?? 0 }} Users</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon success">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <span class="stat-change up">
                    <i class="bi bi-arrow-up"></i> 8%
                </span>
            </div>
            <div class="stat-value">{{ number_format($stats['total_taskers'] ?? 0) }}</div>
            <div class="stat-label">Active Taskers</div>
            <div class="stat-progress">
                <div class="stat-progress-bar success" style="width: 60%"></div>
            </div>
            <div class="stat-footer">
                <span>Verified</span>
                <span>{{ $stats['verified_taskers'] ?? 0 }} Taskers</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon info">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <span class="stat-change live">
                    Live
                </span>
            </div>
            <div class="stat-value">{{ number_format($stats['total_bookings'] ?? 0) }}</div>
            <div class="stat-label">Total Bookings</div>
            <div class="stat-progress">
                <div class="stat-progress-bar info" style="width: 45%"></div>
            </div>
            <div class="stat-footer">
                <span>In Progress</span>
                <span>{{ $stats['active_bookings'] ?? 0 }} Bookings</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon warning">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <span class="stat-change up">
                    <i class="bi bi-arrow-up"></i> 24%
                </span>
            </div>
            <div class="stat-value">${{ number_format($stats['total_revenue'] ?? 0, 0) }}</div>
            <div class="stat-label">Revenue (Month)</div>
            <div class="stat-progress">
                <div class="stat-progress-bar warning" style="width: 80%"></div>
            </div>
            <div class="stat-footer">
                <span>This Month</span>
                <span>${{ number_format($stats['revenue_this_month'] ?? 0, 0) }} Earned</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-graph-up"></i>
                    Revenue & Booking Trend
                </h5>
                <div class="card-header-actions">
                    <div class="btn-toggle-group">
                        <button class="btn-toggle" data-period="week">Week</button>
                        <button class="btn-toggle active" data-period="month">Month</button>
                        <button class="btn-toggle" data-period="year">Year</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-pie-chart"></i>
                    Booking Status Distribution
                </h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <div class="chart-container" style="height: 250px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-lightning"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.roles.index') }}" class="quick-stat">
                    <div class="quick-stat-icon bg-primary-light">
                        <i class="bi bi-shield-lock text-primary"></i>
                    </div>
                    <div class="quick-stat-content">
                        <div class="quick-stat-label">Manage Roles</div>
                        <div class="quick-stat-value">{{ $stats['total_roles'] ?? 0 }} Roles</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
                
                <a href="{{ route('admin.admins.index') }}" class="quick-stat">
                    <div class="quick-stat-icon bg-success-light">
                        <i class="bi bi-person-gear text-success"></i>
                    </div>
                    <div class="quick-stat-content">
                        <div class="quick-stat-label">Admin Users</div>
                        <div class="quick-stat-value">{{ $stats['total_admins'] ?? 0 }} Admins</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
                
                <div class="quick-stat">
                    <div class="quick-stat-icon bg-warning-light">
                        <i class="bi bi-hourglass-split text-warning"></i>
                    </div>
                    <div class="quick-stat-content">
                        <div class="quick-stat-label">Pending Verifications</div>
                        <div class="quick-stat-value">{{ $stats['pending_taskers'] ?? 0 }} Taskers</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>
                
                <div class="quick-stat">
                    <div class="quick-stat-icon bg-danger-light">
                        <i class="bi bi-exclamation-triangle text-danger"></i>
                    </div>
                    <div class="quick-stat-content">
                        <div class="quick-stat-label">Pending Reviews</div>
                        <div class="quick-stat-value">{{ $stats['pending_reviews'] ?? 0 }} Reviews</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-activity"></i>
                    Recent Activity
                </h5>
                <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-secondary btn-sm">
                    View All
                </a>
            </div>
            <div class="card-body p-0">
                <div class="activity-list">
                    @forelse($recentActivity ?? [] as $activity)
                    <div class="activity-item px-4">
                        <div class="activity-icon bg-{{ $activity->action_badge }}-light">
                            <i class="bi {{ $activity->action_icon }} text-{{ $activity->action_badge }}"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">
                                <strong>{{ $activity->admin->full_name ?? 'System' }}</strong>
                                {{ $activity->description }}
                            </div>
                            <div class="activity-time">
                                <i class="bi bi-clock me-1"></i>
                                {{ $activity->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-activity display-4 d-block mb-3"></i>
                        No recent activity
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get theme colors based on current theme
    const getChartColors = () => {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        return {
            text: isDark ? '#94a3b8' : '#64748b',
            grid: isDark ? '#334155' : '#e2e8f0',
            primary: '#FF6B35',
            success: '#10B981',
            warning: '#F59E0B',
            info: '#3B82F6',
            danger: '#EF4444'
        };
    };
    
    let colors = getChartColors();
    
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Revenue ($)',
                    data: [1200, 1900, 1500, 2500, 2200, 3000, 2800, 3500, 4000, 3800, 4200, 5000],
                    borderColor: colors.primary,
                    backgroundColor: 'rgba(255, 107, 53, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'Bookings',
                    data: [20, 35, 28, 45, 40, 55, 50, 65, 75, 70, 80, 95],
                    borderColor: colors.success,
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        color: colors.text,
                        usePointStyle: true,
                        padding: 20
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: colors.grid
                    },
                    ticks: {
                        color: colors.text
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: {
                        color: colors.grid
                    },
                    ticks: {
                        color: colors.text,
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    },
                    ticks: {
                        color: colors.text
                    }
                }
            }
        }
    });
    
    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'In Progress', 'Pending', 'Cancelled'],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: [
                    colors.success,
                    colors.info,
                    colors.warning,
                    colors.danger
                ],
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: colors.text,
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });
    
    // Update charts on theme change
    const themeToggle = document.getElementById('themeToggle');
    themeToggle.addEventListener('click', function() {
        setTimeout(() => {
            colors = getChartColors();
            
            // Update revenue chart
            revenueChart.options.plugins.legend.labels.color = colors.text;
            revenueChart.options.scales.x.grid.color = colors.grid;
            revenueChart.options.scales.x.ticks.color = colors.text;
            revenueChart.options.scales.y.grid.color = colors.grid;
            revenueChart.options.scales.y.ticks.color = colors.text;
            revenueChart.options.scales.y1.ticks.color = colors.text;
            revenueChart.update();
            
            // Update status chart
            statusChart.options.plugins.legend.labels.color = colors.text;
            statusChart.update();
        }, 100);
    });
    
    // Toggle buttons
    document.querySelectorAll('.btn-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            this.parentElement.querySelectorAll('.btn-toggle').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            // Here you would update the chart data based on the selected period
        });
    });
});
</script>
@endpush