@extends('layouts.app')

@section('title', 'Find Taskers')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <h1 class="display-5 fw-bold">Find Trusted Taskers</h1>
        <p class="lead text-muted">Browse our network of verified professionals</p>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <!-- Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Filters</h5>
                    
                    <form action="{{ route('taskers.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($allCategories ?? [] as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Price Range</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Minimum Rating</label>
                            <select name="min_rating" class="form-select">
                                <option value="">Any Rating</option>
                                <option value="4" {{ request('min_rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                                <option value="4.5" {{ request('min_rating') == '4.5' ? 'selected' : '' }}>4.5+ Stars</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Sort By</label>
                            <select name="sort" class="form-select">
                                <option value="rating" {{ request('sort', 'rating') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                                <option value="reviews" {{ request('sort') == 'reviews' ? 'selected' : '' }}>Most Reviews</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Results -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="text-muted">{{ $taskers->total() }} taskers found</span>
            </div>
            
            @if($taskers->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-people display-1 text-muted"></i>
                    <h5 class="mt-3">No taskers found</h5>
                    <p class="text-muted">Try adjusting your filters</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($taskers as $tasker)
                        <div class="col-md-6 col-xl-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        @if($tasker->avatar)
                                            <img src="{{ Storage::url($tasker->avatar) }}" alt="{{ $tasker->first_name }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #FF6B35, #ff8c5a); color: white; font-size: 1.5rem; font-weight: 600;">
                                                {{ strtoupper(substr($tasker->first_name, 0, 1)) }}{{ strtoupper(substr($tasker->last_name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <h5 class="mb-1">{{ $tasker->first_name }} {{ $tasker->last_name }}</h5>
                                    <p class="text-muted small">{{ $tasker->taskerProfile->headline ?? '' }}</p>
                                    
                                    <div class="mb-3">
                                        <span class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= ($tasker->taskerProfile->average_rating ?? 0) ? '-fill' : '' }}"></i>
                                            @endfor
                                        </span>
                                        <small class="text-muted">({{ $tasker->taskerProfile->total_reviews ?? 0 }})</small>
                                    </div>
                                    
                                    <p class="fw-bold text-primary mb-3">${{ number_format($tasker->taskerProfile->hourly_rate ?? 0, 2) }}/hr</p>
                                    
                                    <a href="{{ route('taskers.show', $tasker->id) }}" class="btn btn-outline-primary btn-sm">View Profile</a>
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
@endsection