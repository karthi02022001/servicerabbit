@extends('layouts.app')

@section('title', ($tasker->first_name ?? 'Tasker') . ' ' . ($tasker->last_name ?? '') . ' - Tasker Profile')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Main Profile -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row gap-4">
                        <div class="text-center">
                            @if($tasker->avatar)
                                <img src="{{ Storage::url($tasker->avatar) }}" alt="{{ $tasker->first_name }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px; background: linear-gradient(135deg, #FF6B35, #ff8c5a); color: white; font-size: 2.5rem; font-weight: 600;">
                                    {{ strtoupper(substr($tasker->first_name, 0, 1)) }}{{ strtoupper(substr($tasker->last_name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-grow-1">
                            <h2 class="mb-1">{{ $tasker->first_name }} {{ $tasker->last_name }}</h2>
                            <p class="text-muted mb-2">{{ $tasker->taskerProfile->headline ?? 'Professional Tasker' }}</p>
                            
                            <div class="d-flex flex-wrap gap-3 mb-3">
                                <span class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= ($tasker->taskerProfile->average_rating ?? 0) ? '-fill' : '' }}"></i>
                                    @endfor
                                    <strong class="text-dark ms-1">{{ number_format($tasker->taskerProfile->average_rating ?? 0, 1) }}</strong>
                                </span>
                                <span class="text-muted">|</span>
                                <span class="text-muted">{{ $tasker->taskerProfile->total_reviews ?? 0 }} reviews</span>
                                <span class="text-muted">|</span>
                                <span class="text-muted">{{ $tasker->taskerProfile->total_completed_tasks ?? 0 }} tasks completed</span>
                            </div>
                            
                            @if($tasker->taskerProfile->city)
                                <p class="mb-2">
                                    <i class="bi bi-geo-alt text-primary me-1"></i>
                                    {{ $tasker->taskerProfile->city }}{{ $tasker->taskerProfile->state ? ', ' . $tasker->taskerProfile->state : '' }}
                                </p>
                            @endif
                            
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-success">
                                    <i class="bi bi-patch-check me-1"></i>Verified
                                </span>
                                @if($tasker->taskerProfile->has_vehicle)
                                    <span class="badge bg-info">
                                        <i class="bi bi-truck me-1"></i>Has Vehicle
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- About -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">About</h5>
                    <p class="text-muted">{{ $tasker->taskerProfile->bio ?? 'No bio provided.' }}</p>
                </div>
            </div>
            
            <!-- Services -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">Services Offered</h5>
                    @forelse($tasker->taskerProfile->services ?? [] as $service)
                        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                            <div>
                                <h6 class="mb-1">{{ $service->title ?? $service->category->name ?? 'Service' }}</h6>
                                <small class="text-muted">{{ $service->category->name ?? '' }}</small>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-primary">${{ number_format($service->hourly_rate ?? $tasker->taskerProfile->hourly_rate ?? 0, 2) }}/hr</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No services listed yet.</p>
                    @endforelse
                </div>
            </div>
            
            <!-- Reviews -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">Reviews</h5>
                    @forelse($tasker->reviewsReceived ?? [] as $review)
                        <div class="py-3 border-bottom">
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <strong>{{ $review->is_anonymous ? 'Anonymous' : ($review->reviewer->first_name ?? 'User') }}</strong>
                                    <span class="text-warning ms-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} small"></i>
                                        @endfor
                                    </span>
                                </div>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0 text-muted">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <p class="text-muted">No reviews yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h3 class="text-primary mb-0">${{ number_format($tasker->taskerProfile->hourly_rate ?? 0, 2) }}</h3>
                        <small class="text-muted">per hour</small>
                    </div>
                    
                    @auth
                        <a href="#" class="btn btn-primary w-100 btn-lg mb-3">
                            <i class="bi bi-calendar-check me-2"></i>Book Now
                        </a>
                        <a href="#" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-chat-dots me-2"></i>Message
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 btn-lg mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login to Book
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection