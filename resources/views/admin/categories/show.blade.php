@extends('admin.layouts.app')

@section('title', 'View Category')
@section('page-title', 'Category Details')
@section('page-subtitle', $category->name)

@push('styles')
<link href="{{ asset('assets/admin/css/show.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="profile-card mb-4">
            <div class="profile-card-body">
                <div class="profile-avatar" style="background: {{ $category->color ?? 'var(--primary-gradient)' }};">
                    @if($category->icon)
                        <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}">
                    @else
                        <i class="bi bi-grid-3x3-gap"></i>
                    @endif
                </div>
                <h4 class="profile-name">{{ $category->name }}</h4>
                <p class="profile-email">{{ $category->slug }}</p>
                
                <div class="profile-badges">
                    @if($category->status == 'active')
                        <span class="status-badge-lg active">
                            <i class="bi bi-check-circle-fill"></i> Active
                        </span>
                    @else
                        <span class="status-badge-lg inactive">
                            <i class="bi bi-x-circle-fill"></i> Inactive
                        </span>
                    @endif
                    
                    @if($category->is_featured)
                        <span class="badge bg-warning"><i class="bi bi-star-fill"></i> Featured</span>
                    @endif
                </div>
                
                <div class="profile-actions">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-secondary">
                            @if($category->status == 'active')
                                <i class="bi bi-pause-circle me-1"></i> Deactivate
                            @else
                                <i class="bi bi-play-circle me-1"></i> Activate
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-box-value">{{ $category->subcategories_count }}</div>
                <div class="stat-box-label">Subcategories</div>
            </div>
            <div class="stat-box">
                <div class="stat-box-value">{{ $category->services_count }}</div>
                <div class="stat-box-label">Services</div>
            </div>
            <div class="stat-box highlight">
                <div class="stat-box-value">{{ $category->bookings_count ?? 0 }}</div>
                <div class="stat-box-label">Bookings</div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="{{ route('admin.subcategories.create', ['category_id' => $category->id]) }}" class="quick-action-btn">
                        <i class="bi bi-plus-circle"></i>
                        Add Subcategory
                    </a>
                    <a href="{{ route('admin.subcategories.index', ['category' => $category->id]) }}" class="quick-action-btn">
                        <i class="bi bi-list-nested"></i>
                        View Subcategories
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h6>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-item-label">Category Name</div>
                        <div class="detail-item-value">{{ $category->name }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">URL Slug</div>
                        <div class="detail-item-value">{{ $category->slug }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">Sort Order</div>
                        <div class="detail-item-value">{{ $category->sort_order }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">Brand Color</div>
                        <div class="detail-item-value">
                            @if($category->color)
                            <span style="display:inline-block;width:20px;height:20px;background:{{ $category->color }};border-radius:4px;vertical-align:middle;margin-right:8px;"></span>
                            {{ $category->color }}
                            @else
                            <span class="text-muted">Not set</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($category->short_description)
                <div class="mt-4">
                    <label class="text-muted small">Short Description</label>
                    <p class="mb-0">{{ $category->short_description }}</p>
                </div>
                @endif
                
                @if($category->description)
                <div class="mt-3">
                    <label class="text-muted small">Full Description</label>
                    <p class="mb-0">{{ $category->description }}</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Pricing & Fees -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-currency-dollar me-2"></i>Pricing & Fees</h6>
            </div>
            <div class="card-body">
                <div class="price-breakdown">
                    <div class="price-row">
                        <span class="price-label">Average Hourly Rate</span>
                        <span class="price-value">
                            @if($category->avg_hourly_rate)
                            ${{ number_format($category->avg_hourly_rate, 2) }}/hr
                            @else
                            <span class="text-muted">Not set</span>
                            @endif
                        </span>
                    </div>
                    <div class="price-row">
                        <span class="price-label">Platform Commission</span>
                        <span class="price-value text-success">{{ $category->commission_percentage }}%</span>
                    </div>
                    <div class="price-row">
                        <span class="price-label">Cancellation Fee</span>
                        <span class="price-value fee">{{ $category->cancellation_fee_percentage }}%</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Requirements -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-shield-check me-2"></i>Requirements</h6>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-item-label">Vehicle Required</div>
                        <div class="detail-item-value">
                            @if($category->vehicle_required)
                            <span class="badge bg-success"><i class="bi bi-check"></i> Yes</span>
                            @else
                            <span class="badge bg-secondary"><i class="bi bi-x"></i> No</span>
                            @endif
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">Background Check</div>
                        <div class="detail-item-value">
                            @if($category->background_check_required)
                            <span class="badge bg-success"><i class="bi bi-check"></i> Required</span>
                            @else
                            <span class="badge bg-secondary"><i class="bi bi-x"></i> Not Required</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Subcategories -->
        @if($category->subcategories->count() > 0)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-list-nested me-2"></i>Subcategories</h6>
                <a href="{{ route('admin.subcategories.create', ['category_id' => $category->id]) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg"></i> Add
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Services</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->subcategories as $sub)
                            <tr>
                                <td>
                                    <strong>{{ $sub->name }}</strong>
                                    <small class="text-muted d-block">{{ $sub->slug }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $sub->services_count }} services</span>
                                </td>
                                <td>
                                    @if($sub->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.subcategories.edit', $sub) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- SEO Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-search me-2"></i>SEO Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Meta Title</label>
                    <p class="mb-0">{{ $category->meta_title ?: $category->name }}</p>
                </div>
                <div>
                    <label class="text-muted small">Meta Description</label>
                    <p class="mb-0">{{ $category->meta_description ?: 'Not set' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Timestamps -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Timestamps</h6>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-item-label">Created At</div>
                        <div class="detail-item-value">{{ $category->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">Last Updated</div>
                        <div class="detail-item-value">{{ $category->updated_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Back Button -->
<div class="mt-4">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Categories
    </a>
</div>
@endsection