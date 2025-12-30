@extends('layouts.app')

@section('title', 'Earnings')

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
                <!-- Page Header -->
                <div class="page-header-card mb-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="page-header-content">
                                <span class="page-badge">
                                    <i class="bi bi-wallet2 me-1"></i> Earnings
                                </span>
                                <h1 class="page-title">My Earnings</h1>
                                <p class="page-description">
                                    Track your income, view transaction history, and manage your payouts.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="page-header-illustration">
                                <img src="https://illustrations.popsy.co/amber/earning-money.svg" alt="Earnings" class="img-fluid" style="max-height: 150px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wallet Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="wallet-card wallet-available">
                            <div class="wallet-card-body">
                                <div class="wallet-icon">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <div class="wallet-content">
                                    <span class="wallet-label">Available Balance</span>
                                    <span class="wallet-value">${{ number_format($wallet->available_balance ?? 0, 2) }}</span>
                                </div>
                            </div>
                            @if(($wallet->available_balance ?? 0) >= 50)
                            <div class="wallet-footer">
                                <a href="#" class="btn btn-light btn-sm rounded-pill">
                                    <i class="bi bi-arrow-up-right me-1"></i>Withdraw
                                </a>
                            </div>
                            @else
                            <div class="wallet-footer">
                                <small class="text-white-50">Min. $50 to withdraw</small>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="wallet-card wallet-pending">
                            <div class="wallet-card-body">
                                <div class="wallet-icon">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <div class="wallet-content">
                                    <span class="wallet-label">Pending Balance</span>
                                    <span class="wallet-value">${{ number_format($wallet->pending_balance ?? 0, 2) }}</span>
                                </div>
                            </div>
                            <div class="wallet-footer">
                                <small class="text-white-50">Released after completion</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="wallet-card wallet-total">
                            <div class="wallet-card-body">
                                <div class="wallet-icon">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <div class="wallet-content">
                                    <span class="wallet-label">Total Earned</span>
                                    <span class="wallet-value">${{ number_format($wallet->total_earned ?? 0, 2) }}</span>
                                </div>
                            </div>
                            <div class="wallet-footer">
                                <small class="text-white-50">Lifetime earnings</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Stats -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="bi bi-bar-chart text-primary me-2"></i>
                            Period Summary
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="row g-4 text-center">
                            <div class="col-md-4">
                                <div class="summary-metric">
                                    <div class="metric-icon bg-gradient-primary">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="metric-value">${{ number_format($summary['total'], 2) }}</div>
                                    <div class="metric-label">Total Earnings</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="summary-metric">
                                    <div class="metric-icon bg-gradient-success">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div class="metric-value">{{ $summary['tasks'] }}</div>
                                    <div class="metric-label">Tasks Completed</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="summary-metric">
                                    <div class="metric-icon bg-gradient-info">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div class="metric-value">{{ number_format($summary['hours'], 1) }}h</div>
                                    <div class="metric-label">Hours Worked</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Date Filter -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="bi bi-funnel text-warning me-2"></i>
                            Filter Transactions
                        </h5>
                    </div>
                    <div class="section-body">
                        <form action="{{ route('tasker.profile.earnings') }}" method="GET">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label fw-medium">From Date</label>
                                    <input type="date" name="start_date" class="form-control form-control-lg" value="{{ $startDate }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-medium">To Date</label>
                                    <input type="date" name="end_date" class="form-control form-control-lg" value="{{ $endDate }}">
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                            <i class="bi bi-search me-2"></i>Apply
                                        </button>
                                        <a href="{{ route('tasker.profile.earnings') }}" class="btn btn-outline-secondary btn-lg">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="section-card">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <h5 class="section-title mb-0">
                            <i class="bi bi-receipt text-success me-2"></i>
                            Transaction History
                        </h5>
                        <span class="badge bg-primary rounded-pill">{{ $earnings->total() }} transactions</span>
                    </div>
                    <div class="section-body p-0">
                        @if($earnings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Date</th>
                                        <th>Customer</th>
                                        <th>Service</th>
                                        <th class="text-center">Hours</th>
                                        <th class="text-end pe-4">Earned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($earnings as $booking)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="date-cell">
                                                <strong>{{ $booking->completed_at->format('M d, Y') }}</strong>
                                                <small class="text-muted d-block">{{ $booking->completed_at->format('g:i A') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="customer-cell">
                                                <div class="customer-avatar">
                                                    @if($booking->user->avatar)
                                                        <img src="{{ asset('storage/' . $booking->user->avatar) }}" alt="">
                                                    @else
                                                        <span>{{ strtoupper(substr($booking->user->first_name, 0, 1)) }}</span>
                                                    @endif
                                                </div>
                                                <span>{{ $booking->user->full_name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="service-cell">
                                                <span class="category-badge">{{ $booking->category->name ?? 'Service' }}</span>
                                                <small class="text-muted d-block">{{ $booking->booking_number }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="hours-badge">{{ number_format($booking->actual_hours ?? $booking->estimated_hours, 1) }}h</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <span class="earned-amount">${{ number_format($booking->tasker_payout, 2) }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($earnings->hasPages())
                        <div class="d-flex justify-content-center p-4 border-top">
                            {{ $earnings->withQueryString()->links() }}
                        </div>
                        @endif
                        @else
                        <div class="empty-state py-5">
                            <div class="empty-state-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <h6 class="empty-state-title">No Earnings Yet</h6>
                            <p class="empty-state-text">Complete tasks to start earning money!</p>
                        </div>
                        @endif
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

/* Page Header Card */
.page-header-card {
    background: linear-gradient(135deg, #FF6B35 0%, #ff8c5a 50%, #ffab7a 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(255, 107, 53, 0.3);
}

.page-header-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
}

.page-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0.35rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    margin-bottom: 0.75rem;
}

.page-title {
    color: white;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-description {
    color: rgba(255,255,255,0.9);
    font-size: 1rem;
    margin: 0;
}

.page-header-illustration img {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* Wallet Cards */
.wallet-card {
    border-radius: 20px;
    overflow: hidden;
    color: white;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.wallet-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.wallet-available { background: linear-gradient(135deg, #10b981, #059669); }
.wallet-pending { background: linear-gradient(135deg, #f59e0b, #d97706); }
.wallet-total { background: linear-gradient(135deg, #6366f1, #4f46e5); }

.wallet-card-body {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.wallet-icon {
    width: 56px;
    height: 56px;
    background: rgba(255,255,255,0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.wallet-content {
    flex: 1;
}

.wallet-label {
    display: block;
    font-size: 0.85rem;
    opacity: 0.9;
    margin-bottom: 0.25rem;
}

.wallet-value {
    display: block;
    font-size: 1.75rem;
    font-weight: 700;
}

.wallet-footer {
    padding: 0.75rem 1.5rem;
    background: rgba(0,0,0,0.1);
}

.wallet-footer .btn-light {
    background: white;
    color: #059669;
    font-weight: 600;
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

/* Summary Metrics */
.summary-metric {
    padding: 1rem;
}

.metric-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin: 0 auto 1rem;
}

.bg-gradient-primary { background: linear-gradient(135deg, #FF6B35, #ff8c5a); }
.bg-gradient-success { background: linear-gradient(135deg, #10b981, #34d399); }
.bg-gradient-info { background: linear-gradient(135deg, #3b82f6, #60a5fa); }

.metric-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.metric-label {
    font-size: 0.9rem;
    color: #6b7280;
}

/* Table Styles */
.table th {
    font-weight: 600;
    color: #6b7280;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e5e7eb;
    padding: 1rem;
    background: #f9fafb;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #f3f4f6;
}

.table tbody tr:hover {
    background: #f9fafb;
}

.date-cell strong {
    color: #1f2937;
    font-size: 0.9rem;
}

.customer-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.customer-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    overflow: hidden;
}

.customer-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.category-badge {
    display: inline-block;
    padding: 0.25rem 0.6rem;
    background: #f3f4f6;
    border-radius: 6px;
    font-size: 0.8rem;
    color: #4b5563;
    font-weight: 500;
}

.hours-badge {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    background: #eff6ff;
    color: #2563eb;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
}

.earned-amount {
    font-weight: 700;
    color: #10b981;
    font-size: 1.1rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
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
}

/* Responsive */
@media (max-width: 991.98px) {
    .page-header-card {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
}

@media (max-width: 767.98px) {
    .wallet-card-body {
        padding: 1rem;
    }
    
    .wallet-value {
        font-size: 1.5rem;
    }
}
</style>
@endsection