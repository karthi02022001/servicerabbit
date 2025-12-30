@extends('admin.layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')
@section('page-subtitle', 'Manage task categories and settings')

@push('styles')
<link href="{{ asset('assets/admin/css/index.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header-section">
    <div class="page-header-content">
        <h2>
            <i class="bi bi-grid-3x3-gap"></i>
            Task Categories
        </h2>
        <p>Manage categories, commission rates, and settings</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.subcategories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-list-nested"></i>
            Subcategories
        </a>
        <a href="{{ route('admin.categories.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i>
            Add Category
        </a>
    </div>
</div>

<!-- Gradient Stats Cards -->
<div class="gradient-stats">
    <div class="gradient-stat-card purple">
        <div class="gradient-stat-header">
            <div class="gradient-stat-info">
                <div class="gradient-stat-value">{{ $stats['total'] }}</div>
                <div class="gradient-stat-label">Total Categories</div>
            </div>
            <div class="gradient-stat-icon">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </div>
        </div>
        <div class="gradient-stat-footer">
            <span class="gradient-stat-badge">
                <i class="bi bi-list-ul"></i>
                All records
            </span>
        </div>
    </div>
    
    <div class="gradient-stat-card green">
        <div class="gradient-stat-header">
            <div class="gradient-stat-info">
                <div class="gradient-stat-value">{{ $stats['active'] }}</div>
                <div class="gradient-stat-label">Active</div>
            </div>
            <div class="gradient-stat-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
        </div>
        <div class="gradient-stat-footer">
            <span class="gradient-stat-badge">
                <i class="bi bi-toggle-on"></i>
                Enabled
            </span>
        </div>
    </div>
    
    <div class="gradient-stat-card yellow">
        <div class="gradient-stat-header">
            <div class="gradient-stat-info">
                <div class="gradient-stat-value">{{ $stats['featured'] }}</div>
                <div class="gradient-stat-label">Featured</div>
            </div>
            <div class="gradient-stat-icon">
                <i class="bi bi-star-fill"></i>
            </div>
        </div>
        <div class="gradient-stat-footer">
            <span class="gradient-stat-badge">
                <i class="bi bi-stars"></i>
                Highlighted
            </span>
        </div>
    </div>
    
    <div class="gradient-stat-card orange">
        <div class="gradient-stat-header">
            <div class="gradient-stat-info">
                <div class="gradient-stat-value">{{ $stats['inactive'] }}</div>
                <div class="gradient-stat-label">Inactive</div>
            </div>
            <div class="gradient-stat-icon">
                <i class="bi bi-pause-circle-fill"></i>
            </div>
        </div>
        <div class="gradient-stat-footer">
            <span class="gradient-stat-badge">
                <i class="bi bi-toggle-off"></i>
                Disabled
            </span>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-section">
    <form action="{{ route('admin.categories.index') }}" method="GET" class="filter-row">
        <div class="filter-search">
            <i class="bi bi-search search-icon"></i>
            <input type="text" 
                   class="form-control" 
                   name="search" 
                   placeholder="Search category name, slug..." 
                   value="{{ request('search') }}">
        </div>
        
        <div class="filter-select">
            <select class="form-select" name="status">
                <option value="">Status - All</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        
        <div class="filter-select">
            <select class="form-select" name="featured">
                <option value="">Featured - All</option>
                <option value="yes" {{ request('featured') == 'yes' ? 'selected' : '' }}>Featured</option>
                <option value="no" {{ request('featured') == 'no' ? 'selected' : '' }}>Not Featured</option>
            </select>
        </div>
        
        <div class="filter-actions">
            <button type="submit" class="btn-filter btn-primary">
                <i class="bi bi-funnel"></i>
                Filter
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn-filter btn-outline">
                <i class="bi bi-x-circle"></i>
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Data Table Card -->
<div class="data-card">
    <div class="data-card-header">
        <h5 class="data-card-title">
            <i class="bi bi-table"></i>
            Categories
            <span class="data-card-count">({{ $categories->total() }} records)</span>
        </h5>
        <div class="data-card-actions">
            <button class="btn btn-outline-secondary btn-sm" title="Export">
                <i class="bi bi-download"></i>
            </button>
        </div>
    </div>
    
    <div class="data-table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Category</th>
                    <th>Subcategories</th>
                    <th>Commission</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        <span class="text-muted">{{ $category->sort_order }}</span>
                    </td>
                    <td>
                        <div class="item-cell">
                            <div class="item-avatar primary">
                                @if($category->icon)
                                    <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}">
                                @else
                                    <i class="bi bi-grid"></i>
                                @endif
                            </div>
                            <div class="item-info">
                                <div class="item-name">{{ $category->name }}</div>
                                <small class="item-subtitle">{{ $category->slug }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.subcategories.index', ['category' => $category->id]) }}" 
                           class="badge bg-info text-decoration-none">
                            {{ $category->subcategories_count }} subcategories
                        </a>
                    </td>
                    <td>
                        <span class="fw-semibold text-success">{{ $category->commission_percentage }}%</span>
                        <small class="text-muted d-block">Cancel: {{ $category->cancellation_fee_percentage }}%</small>
                    </td>
                    <td>
                        <form action="{{ route('admin.categories.toggle-featured', $category) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Toggle Featured">
                                @if($category->is_featured)
                                    <i class="bi bi-star-fill text-warning fs-5"></i>
                                @else
                                    <i class="bi bi-star text-muted fs-5"></i>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td>
                        @if($category->status == 'active')
                        <span class="status-badge active">
                            <i class="bi bi-check-circle-fill"></i>
                            Active
                        </span>
                        @else
                        <span class="status-badge inactive">
                            <i class="bi bi-x-circle-fill"></i>
                            Inactive
                        </span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.categories.show', $category) }}" 
                               class="btn-action view" 
                               title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="btn-action edit" 
                               title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($category->subcategories_count == 0 && $category->services_count == 0)
                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="bi bi-grid-3x3-gap"></i>
                            </div>
                            <h4>No Categories Found</h4>
                            <p>There are no categories matching your criteria. Start by adding a new category.</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-2"></i>
                                Add Category
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($categories->hasPages())
    <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;border-top:1px solid #e5e7eb;background:#fff;border-radius:0 0 16px 16px;flex-wrap:wrap;gap:1rem;">
        <div style="font-size:0.875rem;color:#6b7280;">
            Showing <strong style="color:#1f2937;">{{ $categories->firstItem() }}</strong> to <strong style="color:#1f2937;">{{ $categories->lastItem() }}</strong> 
            of <strong style="color:#1f2937;">{{ $categories->total() }}</strong> entries
        </div>
        <nav style="display:flex;align-items:center;gap:0.35rem;">
            @if($categories->onFirstPage())
                <span style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 0.5rem;font-size:0.875rem;font-weight:500;color:#9ca3af;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;cursor:not-allowed;">
                    <i class="bi bi-chevron-left"></i>
                </span>
            @else
                <a href="{{ $categories->previousPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 0.5rem;font-size:0.875rem;font-weight:500;color:#374151;background:#fff;border:1px solid #e5e7eb;border-radius:8px;text-decoration:none;">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif
            
            @foreach($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                @if($page == $categories->currentPage())
                    <span style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 0.75rem;font-size:0.875rem;font-weight:600;color:#fff;background:linear-gradient(135deg,#FF6B35,#e55a2b);border:none;border-radius:8px;box-shadow:0 2px 8px rgba(255,107,53,0.3);">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 0.75rem;font-size:0.875rem;font-weight:500;color:#374151;background:#fff;border:1px solid #e5e7eb;border-radius:8px;text-decoration:none;">{{ $page }}</a>
                @endif
            @endforeach
            
            @if($categories->hasMorePages())
                <a href="{{ $categories->nextPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 0.5rem;font-size:0.875rem;font-weight:500;color:#374151;background:#fff;border:1px solid #e5e7eb;border-radius:8px;text-decoration:none;">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 0.5rem;font-size:0.875rem;font-weight:500;color:#9ca3af;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;cursor:not-allowed;">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif
        </nav>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            new bootstrap.Alert(alert).close();
        });
    }, 5000);
});
</script>
@endpush