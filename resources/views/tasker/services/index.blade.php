@extends('layouts.app')

@section('title', 'My Services')

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
                                    <i class="bi bi-grid-3x3-gap me-1"></i> Services
                                </span>
                                <h1 class="page-title">My Services</h1>
                                <p class="page-description">
                                    Manage the services you offer to customers. Add new services to expand your offerings.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <a href="{{ route('tasker.services.create') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-plus-lg me-2"></i>Add Service
                            </a>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-primary">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="bi bi-grid-3x3-gap"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $services->total() }}</span>
                                    <span class="stat-label">Total Services</span>
                                </div>
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
                                    <span class="stat-value">{{ $services->where('is_active', true)->count() }}</span>
                                    <span class="stat-label">Active</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-warning">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="bi bi-pause-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $services->where('is_active', false)->count() }}</span>
                                    <span class="stat-label">Inactive</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-info">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $services->sum(fn($s) => $s->bookings->count()) }}</span>
                                    <span class="stat-label">Total Bookings</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rate Range Info -->
                @if($profile->hourly_rate_min && $profile->hourly_rate_max)
                <div class="info-banner mb-4">
                    <div class="info-banner-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div class="info-banner-content">
                        <strong>Your Rate Range:</strong> 
                        ${{ number_format($profile->hourly_rate_min, 0) }} - ${{ number_format($profile->hourly_rate_max, 0) }}/hr
                        <span class="text-muted ms-2">• This is shown on your public profile</span>
                    </div>
                </div>
                @endif

                <!-- Services List -->
                @if($services->count() > 0)
                <div class="section-card">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <h5 class="section-title mb-0">
                            <i class="bi bi-list-ul text-primary me-2"></i>
                            All Services
                        </h5>
                        <span class="badge bg-primary rounded-pill">{{ $services->total() }} services</span>
                    </div>
                    <div class="section-body p-0">
                        @foreach($services as $service)
                        <div class="service-list-item {{ !$service->is_active ? 'inactive' : '' }}">
                            <div class="service-icon-wrapper">
                                <div class="service-icon bg-{{ ['primary', 'success', 'warning', 'info', 'purple'][$loop->index % 5] }}-subtle">
                                    <i class="bi bi-{{ $service->category->icon ?? 'briefcase' }} text-{{ ['primary', 'success', 'warning', 'info', 'purple'][$loop->index % 5] }}"></i>
                                </div>
                            </div>
                            <div class="service-content">
                                <div class="service-header-row">
                                    <h6 class="service-title">{{ $service->title ?? $service->category->name }}</h6>
                                    <span class="status-badge status-{{ $service->is_active ? 'active' : 'inactive' }}">
                                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <div class="service-category-row">
                                    <span class="category-tag">{{ $service->category->name }}</span>
                                    @if($service->subcategory)
                                        <span class="subcategory-tag">{{ $service->subcategory->name }}</span>
                                    @endif
                                </div>
                                @if($service->description)
                                    <p class="service-description">{{ Str::limit($service->description, 120) }}</p>
                                @endif
                                <div class="service-meta">
                                    <span class="meta-item">
                                        <i class="bi bi-cash"></i>
                                        <strong>${{ number_format($service->hourly_rate, 0) }}/hr</strong>
                                    </span>
                                    @if($service->experience_years)
                                    <span class="meta-item">
                                        <i class="bi bi-briefcase"></i>
                                        {{ $service->experience_years }}+ years
                                    </span>
                                    @endif
                                    @if($service->minimum_hours)
                                    <span class="meta-item">
                                        <i class="bi bi-clock"></i>
                                        Min {{ $service->minimum_hours }}h
                                    </span>
                                    @endif
                                    <span class="meta-item">
                                        <i class="bi bi-calendar-check"></i>
                                        {{ $service->bookings->count() }} bookings
                                    </span>
                                </div>
                            </div>
                            <div class="service-actions">
                                <form action="{{ route('tasker.services.toggle', $service) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-{{ $service->is_active ? 'warning' : 'success' }} rounded-pill" 
                                            title="{{ $service->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="bi bi-{{ $service->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                </form>
                                <a href="{{ route('tasker.services.edit', $service) }}" class="btn btn-sm btn-primary rounded-pill" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('tasker.services.destroy', $service) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                @if($services->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $services->links() }}
                </div>
                @endif

                @else
                <!-- Empty State -->
                <div class="section-card">
                    <div class="section-body">
                        <div class="empty-state py-5">
                            <div class="empty-state-icon">
                                <i class="bi bi-grid-3x3-gap"></i>
                            </div>
                            <h5 class="empty-state-title">No Services Yet</h5>
                            <p class="empty-state-text">Add services to start receiving booking requests from customers</p>
                            <a href="{{ route('tasker.services.create') }}" class="btn btn-primary rounded-pill">
                                <i class="bi bi-plus-lg me-2"></i>Add Your First Service
                            </a>
                        </div>
                    </div>
                </div>
                @endif
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
    max-width: 500px;
}

.page-header-card .btn-light {
    background: white;
    color: #FF6B35;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    border: none;
    transition: all 0.3s;
}

.page-header-card .btn-light:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
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
    align-items: center;
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

.stat-value {
    display: block;
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
}

.stat-label {
    display: block;
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
    margin-top: 0.25rem;
}

/* Info Banner */
.info-banner {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border-radius: 16px;
    border-left: 4px solid #3b82f6;
}

.info-banner-icon {
    width: 40px;
    height: 40px;
    background: #3b82f6;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.info-banner-content {
    color: #1e40af;
    font-size: 0.95rem;
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

/* Service List Item */
.service-list-item {
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    transition: all 0.3s ease;
}

.service-list-item:last-child {
    border-bottom: none;
}

.service-list-item:hover {
    background: #f9fafb;
}

.service-list-item.inactive {
    opacity: 0.6;
}

.service-icon-wrapper {
    flex-shrink: 0;
}

.service-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.bg-primary-subtle { background: rgba(255, 107, 53, 0.1); }
.bg-success-subtle { background: rgba(16, 185, 129, 0.1); }
.bg-warning-subtle { background: rgba(245, 158, 11, 0.1); }
.bg-info-subtle { background: rgba(59, 130, 246, 0.1); }
.bg-purple-subtle { background: rgba(139, 92, 246, 0.1); }

.text-primary { color: #FF6B35 !important; }
.text-purple { color: #8b5cf6 !important; }

.service-content {
    flex: 1;
    min-width: 0;
}

.service-header-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.service-title {
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    font-size: 1.1rem;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-active { background: #d1fae5; color: #065f46; }
.status-inactive { background: #f3f4f6; color: #6b7280; }

.service-category-row {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.category-tag {
    display: inline-block;
    padding: 0.25rem 0.6rem;
    background: #f3f4f6;
    border-radius: 6px;
    font-size: 0.75rem;
    color: #4b5563;
    font-weight: 500;
}

.subcategory-tag {
    display: inline-block;
    padding: 0.25rem 0.6rem;
    background: #fef3c7;
    border-radius: 6px;
    font-size: 0.75rem;
    color: #92400e;
    font-weight: 500;
}

.service-description {
    font-size: 0.9rem;
    color: #6b7280;
    margin-bottom: 0.75rem;
    line-height: 1.5;
}

.service-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.85rem;
    color: #6b7280;
}

.meta-item i {
    color: #9ca3af;
    font-size: 0.9rem;
}

.meta-item strong {
    color: #10b981;
}

.service-actions {
    display: flex;
    gap: 0.5rem;
    flex-shrink: 0;
}

.service-actions .btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-state-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: white;
}

.empty-state-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.empty-state-text {
    font-size: 0.95rem;
    color: #6b7280;
    margin-bottom: 1.5rem;
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
    .service-list-item {
        flex-wrap: wrap;
    }
    
    .service-actions {
        width: 100%;
        justify-content: flex-end;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
    }
}
</style>
@endsection