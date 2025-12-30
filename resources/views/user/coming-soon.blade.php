@extends('layouts.app')

@section('title', $feature . ' - Coming Soon')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center py-5 px-4">
                    <div class="coming-soon-icon mb-4">
                        <div class="icon-wrapper mx-auto">
                            <i class="bi bi-rocket-takeoff"></i>
                        </div>
                    </div>
                    
                    <h2 class="fw-bold mb-3">{{ $feature }}</h2>
                    <h4 class="text-muted mb-4">Coming Soon!</h4>
                    
                    <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">
                        We're working hard to bring you this feature. Stay tuned for updates!
                    </p>
                    
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('home') }}" class="btn btn-primary px-4">
                            <i class="bi bi-house me-2"></i> Go Home
                        </a>
                        @auth
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                        @else
                        <a href="{{ route('register') }}" class="btn btn-outline-primary px-4">
                            <i class="bi bi-person-plus me-2"></i> Sign Up
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Features Preview -->
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-search fs-4"></i>
                            </div>
                            <h6 class="fw-semibold">Browse Services</h6>
                            <small class="text-muted">Find the perfect tasker for any job</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-calendar-check fs-4"></i>
                            </div>
                            <h6 class="fw-semibold">Easy Booking</h6>
                            <small class="text-muted">Book services in just a few clicks</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-shield-check fs-4"></i>
                            </div>
                            <h6 class="fw-semibold">Verified Taskers</h6>
                            <small class="text-muted">All taskers are background verified</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.coming-soon-icon .icon-wrapper {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, var(--primary, #FF6B35) 0%, #ff8c5a 100%);
    border-radius: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: float 3s ease-in-out infinite;
}

.coming-soon-icon .icon-wrapper i {
    font-size: 3.5rem;
    color: white;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-15px);
    }
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary, #FF6B35), #ff8c5a);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #e55a2b, var(--primary, #FF6B35));
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(255, 107, 53, 0.3);
}

.btn-outline-primary {
    border-color: var(--primary, #FF6B35);
    color: var(--primary, #FF6B35);
}

.btn-outline-primary:hover {
    background-color: var(--primary, #FF6B35);
    border-color: var(--primary, #FF6B35);
}
</style>
@endsection