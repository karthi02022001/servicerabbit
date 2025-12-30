@extends('layouts.app')

@section('title', 'Application Submitted - Become a Tasker')

@section('content')
<div class="completion-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="completion-card">
                    <!-- Success Animation -->
                    <div class="success-animation">
                        <div class="checkmark-circle">
                            <div class="checkmark"></div>
                        </div>
                    </div>
                    
                    <h1 class="completion-title">Application Submitted!</h1>
                    <p class="completion-subtitle">
                        Congratulations {{ auth()->user()->first_name }}! Your tasker application has been submitted successfully.
                    </p>
                    
                    <!-- Status Card -->
                    <div class="status-card">
                        <div class="status-icon pending">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="status-content">
                            <h5>Verification In Progress</h5>
                            <p>Our team is reviewing your documents. This typically takes 1-2 business days.</p>
                        </div>
                    </div>
                    
                    <!-- What's Next -->
                    <div class="whats-next">
                        <h4><i class="bi bi-arrow-right-circle me-2"></i>What Happens Next?</h4>
                        
                        <div class="timeline">
                            <div class="timeline-item completed">
                                <div class="timeline-dot">
                                    <i class="bi bi-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <strong>Application Submitted</strong>
                                    <span>Just now</span>
                                </div>
                            </div>
                            
                            <div class="timeline-item active">
                                <div class="timeline-dot">
                                    <i class="bi bi-search"></i>
                                </div>
                                <div class="timeline-content">
                                    <strong>Document Review</strong>
                                    <span>In progress (1-2 business days)</span>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-dot">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div class="timeline-content">
                                    <strong>Email Notification</strong>
                                    <span>We'll notify you once verified</span>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-dot">
                                    <i class="bi bi-play-circle"></i>
                                </div>
                                <div class="timeline-content">
                                    <strong>Start Earning</strong>
                                    <span>Accept tasks and get paid</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Application Summary -->
                    <div class="summary-section">
                        <h4><i class="bi bi-file-text me-2"></i>Application Summary</h4>
                        
                        <div class="summary-grid">
                            <div class="summary-item">
                                <div class="summary-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="summary-content">
                                    <span>Headline</span>
                                    <strong>{{ $profile->headline }}</strong>
                                </div>
                            </div>
                            
                            <div class="summary-item">
                                <div class="summary-icon">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <div class="summary-content">
                                    <span>Experience</span>
                                    <strong>{{ $profile->years_of_experience }}+ years</strong>
                                </div>
                            </div>
                            
                            <div class="summary-item">
                                <div class="summary-icon">
                                    <i class="bi bi-grid"></i>
                                </div>
                                <div class="summary-content">
                                    <span>Services</span>
                                    <strong>{{ $profile->services->count() }} categories</strong>
                                </div>
                            </div>
                            
                            <div class="summary-item">
                                <div class="summary-icon">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="summary-content">
                                    <span>Hourly Rate</span>
                                    <strong>${{ number_format($profile->hourly_rate_min, 0) }} - ${{ number_format($profile->hourly_rate_max, 0) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="completion-actions">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-house me-2"></i>
                            Go to Dashboard
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to Home
                        </a>
                    </div>
                    
                    <!-- Help -->
                    <div class="help-section">
                        <p>
                            <i class="bi bi-question-circle me-1"></i>
                            Have questions? <a href="{{ route('contact') ?? '#' }}">Contact our support team</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.completion-container {
    background: linear-gradient(135deg, #f9fafb 0%, #fff 100%);
    min-height: calc(100vh - 80px);
    padding: 3rem 0;
}

.completion-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    padding: 3rem;
    text-align: center;
}

/* Success Animation */
.success-animation {
    margin-bottom: 2rem;
}

.checkmark-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #10b981, #34d399);
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: scaleIn 0.5s ease;
}

.checkmark {
    width: 40px;
    height: 20px;
    border-left: 4px solid white;
    border-bottom: 4px solid white;
    transform: rotate(-45deg);
    margin-top: -5px;
    animation: drawCheck 0.5s ease 0.3s forwards;
    opacity: 0;
}

@keyframes scaleIn {
    0% { transform: scale(0); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

@keyframes drawCheck {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

.completion-title {
    font-size: 2.25rem;
    font-weight: 700;
    color: #1A1A2E;
    margin-bottom: 0.75rem;
}

.completion-subtitle {
    font-size: 1.125rem;
    color: #6b7280;
    margin-bottom: 2rem;
}

/* Status Card */
.status-card {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    text-align: left;
}

.status-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.status-icon.pending {
    background: #f59e0b;
    color: white;
}

.status-content h5 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #92400e;
    margin-bottom: 0.25rem;
}

.status-content p {
    margin: 0;
    font-size: 0.9rem;
    color: #b45309;
}

/* What's Next */
.whats-next {
    text-align: left;
    margin-bottom: 2rem;
}

.whats-next h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1A1A2E;
    margin-bottom: 1.5rem;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 11px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e5e7eb;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-dot {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    color: #9ca3af;
    position: relative;
    z-index: 1;
    flex-shrink: 0;
    margin-left: -2rem;
}

.timeline-item.completed .timeline-dot {
    background: #10b981;
    color: white;
}

.timeline-item.active .timeline-dot {
    background: #FF6B35;
    color: white;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(255, 107, 53, 0.4); }
    50% { box-shadow: 0 0 0 8px rgba(255, 107, 53, 0); }
}

.timeline-content {
    flex: 1;
}

.timeline-content strong {
    display: block;
    font-size: 0.95rem;
    color: #1A1A2E;
}

.timeline-content span {
    font-size: 0.85rem;
    color: #6b7280;
}

/* Summary Section */
.summary-section {
    text-align: left;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f9fafb;
    border-radius: 16px;
}

.summary-section h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1A1A2E;
    margin-bottom: 1.25rem;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.summary-icon {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FF6B35;
    font-size: 1.125rem;
}

.summary-content span {
    display: block;
    font-size: 0.75rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.summary-content strong {
    font-size: 0.9rem;
    color: #1A1A2E;
}

/* Actions */
.completion-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 2rem;
}

.completion-actions .btn {
    padding: 0.875rem 1.75rem;
    border-radius: 12px;
    font-weight: 600;
}

.completion-actions .btn-primary {
    background: linear-gradient(135deg, #FF6B35, #e55a2b);
    border: none;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.help-section {
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.help-section p {
    margin: 0;
    color: #6b7280;
    font-size: 0.9rem;
}

.help-section a {
    color: #FF6B35;
    text-decoration: none;
}

.help-section a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 767.98px) {
    .completion-card {
        padding: 2rem 1.5rem;
    }
    
    .completion-title {
        font-size: 1.75rem;
    }
    
    .status-card {
        flex-direction: column;
        text-align: center;
    }
    
    .summary-grid {
        grid-template-columns: 1fr;
    }
    
    .completion-actions {
        flex-direction: column;
    }
}
</style>
@endpush