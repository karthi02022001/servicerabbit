@extends('layouts.app')

@section('title', $category->name ?? 'Category')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active">{{ $category->name }}</li>
            </ol>
        </nav>
        
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold">{{ $category->name }}</h1>
                <p class="lead text-muted">{{ $category->description ?? 'Find skilled taskers for ' . $category->name }}</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <span class="badge bg-primary fs-6">{{ $taskers->total() }} Taskers Available</span>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <!-- Subcategories Filter -->
        @if($category->subcategories->isNotEmpty())
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">Subcategories</h6>
                    <div class="list-group list-group-flush">
                        @foreach($category->subcategories as $sub)
                            <a href="{{ route('categories.show', $category->slug) }}?sub={{ $sub->slug }}" class="list-group-item list-group-item-action border-0">
                                {{ $sub->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
        @else
        <div class="col-12">
        @endif
            @if($taskers->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-people display-1 text-muted"></i>
                    <h5 class="mt-3">No taskers available in this category</h5>
                    <p class="text-muted">Check back later or browse other categories</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary">Browse Categories</a>
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
                    {{ $taskers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection