@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Filters</h5>
                    
                    <form action="{{ route('search') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="q" class="form-control" value="{{ $query ?? '' }}" placeholder="What do you need help with?">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($allCategories ?? [] as $category)
                                    <option value="{{ $category->slug }}" {{ ($categorySlug ?? '') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Results -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    @if($query ?? null)
                        Search results for "{{ $query }}"
                    @else
                        All Taskers
                    @endif
                </h4>
                <span class="text-muted">{{ $taskers->total() }} taskers found</span>
            </div>
            
            @if($taskers->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search display-1 text-muted"></i>
                    <h5 class="mt-3">No taskers found</h5>
                    <p class="text-muted">Try adjusting your search or filters</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($taskers as $tasker)
                        <div class="col-md-6 col-xl-4">
                            <div class="card h-100 border-0 shadow-sm tasker-card">
                                <div class="card-body text-center">
                                    <div class="avatar-lg mx-auto mb-3">
                                        @if($tasker->avatar)
                                            <img src="{{ Storage::url($tasker->avatar) }}" alt="{{ $tasker->first_name }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #FF6B35, #ff8c5a); color: white; font-size: 1.5rem; font-weight: 600;">
                                                {{ strtoupper(substr($tasker->first_name, 0, 1)) }}{{ strtoupper(substr($tasker->last_name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <h5 class="card-title mb-1">{{ $tasker->first_name }} {{ $tasker->last_name }}</h5>
                                    <p class="text-muted small mb-2">{{ $tasker->taskerProfile->headline ?? 'Professional Tasker' }}</p>
                                    
                                    <div class="mb-3">
                                        <span class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= ($tasker->taskerProfile->average_rating ?? 0) ? '-fill' : '' }}"></i>
                                            @endfor
                                        </span>
                                        <small class="text-muted">({{ $tasker->taskerProfile->total_reviews ?? 0 }} reviews)</small>
                                    </div>
                                    
                                    <p class="fw-bold text-primary mb-3">
                                        ${{ number_format($tasker->taskerProfile->hourly_rate ?? 0, 2) }}/hr
                                    </p>
                                    
                                    <a href="{{ route('taskers.show', $tasker->id) }}" class="btn btn-outline-primary btn-sm">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $taskers->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.tasker-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.tasker-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}
</style>
@endsection