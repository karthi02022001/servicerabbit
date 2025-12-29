@extends('layouts.app')

@section('title', 'Verification Pending')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="bg-white rounded-4 shadow-sm p-5 text-center">
                <div class="mb-4">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-hourglass-split fs-1"></i>
                    </div>
                </div>
                
                <h3 class="fw-bold mb-3">Verification in Progress</h3>
                
                <p class="text-muted mb-4">
                    Thank you for completing your tasker registration! Your profile is currently being reviewed by our team.
                </p>
                
                <div class="bg-light rounded-4 p-4 mb-4 text-start">
                    <h6 class="fw-semibold mb-3">What happens next?</h6>
                    <ul class="mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Our team reviews your ID documents
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            We verify your profile information
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            You'll receive an email with the decision
                        </li>
                        <li>
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Once approved, you can start accepting tasks
                        </li>
                    </ul>
                </div>
                
                <div class="alert alert-info text-start">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Average review time:</strong> 24-48 hours
                </div>
                
                @if(auth()->user()->taskerProfile)
                    <div class="d-flex gap-3 justify-content-center flex-wrap mb-4">
                        <div class="text-center">
                            <div class="badge {{ auth()->user()->taskerProfile->step_profile_completed ? 'bg-success' : 'bg-secondary' }} mb-1">
                                <i class="bi bi-{{ auth()->user()->taskerProfile->step_profile_completed ? 'check' : 'clock' }}"></i>
                            </div>
                            <small class="d-block text-muted">Profile</small>
                        </div>
                        <div class="text-center">
                            <div class="badge {{ auth()->user()->taskerProfile->step_categories_completed ? 'bg-success' : 'bg-secondary' }} mb-1">
                                <i class="bi bi-{{ auth()->user()->taskerProfile->step_categories_completed ? 'check' : 'clock' }}"></i>
                            </div>
                            <small class="d-block text-muted">Services</small>
                        </div>
                        <div class="text-center">
                            <div class="badge {{ auth()->user()->taskerProfile->step_availability_completed ? 'bg-success' : 'bg-secondary' }} mb-1">
                                <i class="bi bi-{{ auth()->user()->taskerProfile->step_availability_completed ? 'check' : 'clock' }}"></i>
                            </div>
                            <small class="d-block text-muted">Availability</small>
                        </div>
                        <div class="text-center">
                            <div class="badge {{ auth()->user()->taskerProfile->id_verified ? 'bg-success' : 'bg-warning' }} mb-1">
                                <i class="bi bi-{{ auth()->user()->taskerProfile->id_verified ? 'check' : 'hourglass-split' }}"></i>
                            </div>
                            <small class="d-block text-muted">ID Verify</small>
                        </div>
                        <div class="text-center">
                            <div class="badge {{ auth()->user()->taskerProfile->step_payment_completed ? 'bg-success' : 'bg-secondary' }} mb-1">
                                <i class="bi bi-{{ auth()->user()->taskerProfile->step_payment_completed ? 'check' : 'clock' }}"></i>
                            </div>
                            <small class="d-block text-muted">Payment</small>
                        </div>
                    </div>
                    
                    @if(auth()->user()->taskerProfile->verification_status === 'rejected')
                        <div class="alert alert-danger text-start">
                            <h6 class="alert-heading">
                                <i class="bi bi-x-circle me-2"></i>Verification Rejected
                            </h6>
                            <p class="mb-2">Unfortunately, your verification was not approved.</p>
                            @if(auth()->user()->taskerProfile->rejection_reason)
                                <p class="mb-0"><strong>Reason:</strong> {{ auth()->user()->taskerProfile->rejection_reason }}</p>
                            @endif
                            <hr>
                            <a href="{{ route('tasker.register.step4') }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-arrow-repeat me-1"></i> Resubmit Documents
                            </a>
                        </div>
                    @endif
                @endif
                
                <hr class="my-4">
                
                <p class="text-muted small mb-3">
                    Have questions? Contact our support team
                </p>
                
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-house me-1"></i> Go to Dashboard
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                        <i class="bi bi-envelope me-1"></i> Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection