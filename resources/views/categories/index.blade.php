@extends('layouts.app')

@section('title', 'All Categories')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Browse All Categories</h1>
        <p class="lead text-muted">Find the right tasker for any job</p>
    </div>
    
    <div class="row g-4">
        @forelse($categories ?? [] as $category)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm category-card text-center">
                        <div class="card-body py-4">
                            <div class="category-icon mb-3" style="background-color: {{ $category->color ?? '#FF6B35' }}20;">
                                @if($category->icon)
                                    <img src="{{ Storage::url('categories/' . $category->icon) }}" alt="{{ $category->name }}" style="width: 40px; height: 40px;">
                                @else
                                    <i class="bi bi-briefcase" style="font-size: 2rem; color: {{ $category->color ?? '#FF6B35' }};"></i>
                                @endif
                            </div>
                            <h6 class="card-title mb-1">{{ $category->name }}</h6>
                            <small class="text-muted">{{ $category->services_count ?? 0 }} services</small>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-folder-x display-1 text-muted"></i>
                <h5 class="mt-3">No categories available</h5>
                <p class="text-muted">Check back later for new categories</p>
            </div>
        @endforelse
    </div>
</div>

<style>
.category-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}
.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}
.category-icon {
    width: 70px;
    height: 70px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}
</style>
@endsection