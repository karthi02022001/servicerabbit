@extends('layouts.app')

@section('content')
<div class="registration-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Progress Header -->
                <div class="progress-header">
                    <a href="{{ route('home') }}" class="back-link">
                        <i class="bi bi-arrow-left"></i>
                        Back to Home
                    </a>
                    <h2 class="registration-title">Become a Tasker</h2>
                </div>
                
                <!-- Progress Steps -->
                <div class="progress-steps">
                    <div class="step {{ $currentStep >= 1 ? 'active' : '' }} {{ $currentStep > 1 ? 'completed' : '' }}">
                        <div class="step-indicator">
                            @if($currentStep > 1)
                                <i class="bi bi-check-lg"></i>
                            @else
                                <span>1</span>
                            @endif
                        </div>
                        <div class="step-label">Profile</div>
                    </div>
                    <div class="step-line {{ $currentStep > 1 ? 'active' : '' }}"></div>
                    
                    <div class="step {{ $currentStep >= 2 ? 'active' : '' }} {{ $currentStep > 2 ? 'completed' : '' }}">
                        <div class="step-indicator">
                            @if($currentStep > 2)
                                <i class="bi bi-check-lg"></i>
                            @else
                                <span>2</span>
                            @endif
                        </div>
                        <div class="step-label">Services</div>
                    </div>
                    <div class="step-line {{ $currentStep > 2 ? 'active' : '' }}"></div>
                    
                    <div class="step {{ $currentStep >= 3 ? 'active' : '' }} {{ $currentStep > 3 ? 'completed' : '' }}">
                        <div class="step-indicator">
                            @if($currentStep > 3)
                                <i class="bi bi-check-lg"></i>
                            @else
                                <span>3</span>
                            @endif
                        </div>
                        <div class="step-label">Availability</div>
                    </div>
                    <div class="step-line {{ $currentStep > 3 ? 'active' : '' }}"></div>
                    
                    <div class="step {{ $currentStep >= 4 ? 'active' : '' }} {{ $currentStep > 4 ? 'completed' : '' }}">
                        <div class="step-indicator">
                            @if($currentStep > 4)
                                <i class="bi bi-check-lg"></i>
                            @else
                                <span>4</span>
                            @endif
                        </div>
                        <div class="step-label">Verification</div>
                    </div>
                </div>
                
                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        Please fix the errors below.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Step Content -->
                <div class="step-content">
                    @yield('step-content')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.registration-container {
    background: linear-gradient(135deg, #f9fafb 0%, #fff 100%);
    min-height: calc(100vh - 80px);
    padding: 2rem 0 4rem;
}

.progress-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.back-link:hover {
    color: #FF6B35;
}

.registration-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1A1A2E;
    margin: 0;
}

/* Progress Steps */
.progress-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 2.5rem;
    padding: 1.5rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.step-indicator {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #f3f4f6;
    border: 2px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: #9ca3af;
    transition: all 0.3s;
    margin-bottom: 0.5rem;
}

.step.active .step-indicator {
    background: linear-gradient(135deg, #FF6B35, #e55a2b);
    border-color: #FF6B35;
    color: white;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.step.completed .step-indicator {
    background: #10b981;
    border-color: #10b981;
    color: white;
}

.step-label {
    font-size: 0.8rem;
    font-weight: 500;
    color: #9ca3af;
}

.step.active .step-label,
.step.completed .step-label {
    color: #1A1A2E;
}

.step-line {
    width: 80px;
    height: 3px;
    background: #e5e7eb;
    margin: 0 0.5rem;
    margin-bottom: 1.5rem;
    border-radius: 3px;
    transition: background 0.3s;
}

.step-line.active {
    background: linear-gradient(135deg, #10b981, #34d399);
}

/* Step Content */
.step-content {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    overflow: hidden;
}

.step-card {
    padding: 2.5rem;
}

.step-card-header {
    text-align: center;
    margin-bottom: 2rem;
}

.step-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #fff5f0, #ffe8db);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 1.75rem;
    color: #FF6B35;
}

.step-card-header h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1A1A2E;
    margin-bottom: 0.5rem;
}

.step-card-header p {
    color: #6b7280;
    margin: 0;
}

/* Form Styles */
.form-section {
    margin-bottom: 2rem;
}

.form-section-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1A1A2E;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f3f4f6;
}

.form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-label-required::after {
    content: '*';
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-control, .form-select {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.form-control:focus, .form-select:focus {
    border-color: #FF6B35;
    box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
}

.form-text {
    font-size: 0.8rem;
    color: #9ca3af;
}

/* Avatar Upload */
.avatar-upload {
    text-align: center;
    margin-bottom: 2rem;
}

.avatar-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    overflow: hidden;
    border: 4px solid #fff;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.avatar-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-preview i {
    font-size: 3rem;
    color: #d1d5db;
}

/* Step Actions */
.step-actions {
    display: flex;
    justify-content: space-between;
    padding: 1.5rem 2.5rem;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
}

.btn-step {
    padding: 0.875rem 2rem;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.2s;
}

.btn-step-prev {
    background: white;
    border: 2px solid #e5e7eb;
    color: #6b7280;
}

.btn-step-prev:hover {
    border-color: #FF6B35;
    color: #FF6B35;
}

.btn-step-next {
    background: linear-gradient(135deg, #FF6B35, #e55a2b);
    border: none;
    color: white;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.btn-step-next:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
    color: white;
}

/* Toggle Switch */
.toggle-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.toggle-content {
    flex: 1;
    margin-left: 1rem;
}

.toggle-content strong {
    display: block;
    font-size: 0.95rem;
    color: #1A1A2E;
}

.toggle-content small {
    color: #6b7280;
}

/* Responsive */
@media (max-width: 767.98px) {
    .progress-steps {
        padding: 1rem;
    }
    
    .step-line {
        width: 30px;
    }
    
    .step-indicator {
        width: 36px;
        height: 36px;
        font-size: 0.875rem;
    }
    
    .step-label {
        font-size: 0.7rem;
    }
    
    .step-card {
        padding: 1.5rem;
    }
    
    .step-actions {
        padding: 1rem 1.5rem;
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-step {
        width: 100%;
    }
}
</style>
@endpush