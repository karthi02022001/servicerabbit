@extends('layouts.app')

@section('title', 'Verification')

@section('content')
<div class="dashboard-wrapper">
    <div class="container-fluid px-4 py-4">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3 col-xl-2">
                @include('tasker.partials.sidebar')
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10">
                <!-- Page Header -->
                <div class="page-header-card mb-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="page-header-content">
                                <span class="page-badge">
                                    <i class="bi bi-shield-check me-1"></i> Verification
                                </span>
                                <h1 class="page-title">Account Verification</h1>
                                <p class="page-description">
                                    Complete verification to build trust with customers and unlock all features.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="page-header-illustration">
                                <img src="https://illustrations.popsy.co/amber/security.svg" alt="Verification" class="img-fluid" style="max-height: 150px;">
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Verification Status Card -->
                <div class="verification-status-card mb-4">
                    <div class="status-icon status-{{ $profile->verification_status }}">
                        @if($profile->verification_status === 'approved')
                            <i class="bi bi-patch-check-fill"></i>
                        @elseif($profile->verification_status === 'submitted')
                            <i class="bi bi-hourglass-split"></i>
                        @elseif($profile->verification_status === 'rejected')
                            <i class="bi bi-x-circle"></i>
                        @else
                            <i class="bi bi-shield-exclamation"></i>
                        @endif
                    </div>
                    <div class="status-content">
                        <h3 class="status-title">
                            @if($profile->verification_status === 'approved')
                                Verified Account
                            @elseif($profile->verification_status === 'submitted')
                                Under Review
                            @elseif($profile->verification_status === 'rejected')
                                Verification Rejected
                            @else
                                Verification Required
                            @endif
                        </h3>
                        <p class="status-description">
                            @if($profile->verification_status === 'approved')
                                Your account has been verified. Customers can see your verified badge.
                            @elseif($profile->verification_status === 'submitted')
                                Your documents are being reviewed. This usually takes 1-2 business days.
                            @elseif($profile->verification_status === 'rejected')
                                Your verification was rejected. Please resubmit your documents.
                                @if($profile->rejection_reason)
                                    <br><strong>Reason:</strong> {{ $profile->rejection_reason }}
                                @endif
                            @else
                                Submit your ID documents to get verified and start accepting bookings.
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Verification Steps -->
                    <div class="col-lg-8">
                        <div class="section-card">
                            <div class="section-header">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-list-check text-primary me-2"></i>
                                    Verification Steps
                                </h5>
                            </div>
                            <div class="section-body p-0">
                                <!-- Step 1: Email -->
                                <div class="verification-step completed">
                                    <div class="step-number">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <div class="step-content">
                                        <h6>Email Verification</h6>
                                        <p>Your email has been verified</p>
                                    </div>
                                    <div class="step-status">
                                        <span class="badge bg-success rounded-pill">Completed</span>
                                    </div>
                                </div>

                                <!-- Step 2: Phone -->
                                <div class="verification-step {{ $user->phone ? 'completed' : 'pending' }}">
                                    <div class="step-number">
                                        @if($user->phone)
                                            <i class="bi bi-check-lg"></i>
                                        @else
                                            <span>2</span>
                                        @endif
                                    </div>
                                    <div class="step-content">
                                        <h6>Phone Number</h6>
                                        <p>{{ $user->phone ? 'Phone number added' : 'Add your phone number' }}</p>
                                    </div>
                                    <div class="step-status">
                                        @if($user->phone)
                                            <span class="badge bg-success rounded-pill">Completed</span>
                                        @else
                                            <a href="{{ route('tasker.profile.edit') }}" class="btn btn-sm btn-primary rounded-pill">Add Phone</a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Step 3: Profile -->
                                <div class="verification-step {{ $profile->bio && $profile->headline ? 'completed' : 'pending' }}">
                                    <div class="step-number">
                                        @if($profile->bio && $profile->headline)
                                            <i class="bi bi-check-lg"></i>
                                        @else
                                            <span>3</span>
                                        @endif
                                    </div>
                                    <div class="step-content">
                                        <h6>Complete Profile</h6>
                                        <p>{{ $profile->bio && $profile->headline ? 'Profile completed' : 'Add headline and bio' }}</p>
                                    </div>
                                    <div class="step-status">
                                        @if($profile->bio && $profile->headline)
                                            <span class="badge bg-success rounded-pill">Completed</span>
                                        @else
                                            <a href="{{ route('tasker.profile.edit') }}" class="btn btn-sm btn-primary rounded-pill">Complete</a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Step 4: ID Verification -->
                                <div class="verification-step {{ in_array($profile->verification_status, ['submitted', 'approved']) ? 'completed' : ($profile->verification_status === 'rejected' ? 'rejected' : 'pending') }}">
                                    <div class="step-number">
                                        @if($profile->verification_status === 'approved')
                                            <i class="bi bi-check-lg"></i>
                                        @elseif($profile->verification_status === 'submitted')
                                            <i class="bi bi-hourglass-split"></i>
                                        @elseif($profile->verification_status === 'rejected')
                                            <i class="bi bi-x-lg"></i>
                                        @else
                                            <span>4</span>
                                        @endif
                                    </div>
                                    <div class="step-content">
                                        <h6>ID Verification</h6>
                                        <p>
                                            @if($profile->verification_status === 'approved')
                                                Identity verified
                                            @elseif($profile->verification_status === 'submitted')
                                                Documents under review
                                            @elseif($profile->verification_status === 'rejected')
                                                Please resubmit documents
                                            @else
                                                Submit government-issued ID
                                            @endif
                                        </p>
                                    </div>
                                    <div class="step-status">
                                        @if($profile->verification_status === 'approved')
                                            <span class="badge bg-success rounded-pill">Verified</span>
                                        @elseif($profile->verification_status === 'submitted')
                                            <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                                        @elseif($profile->verification_status === 'rejected')
                                            <span class="badge bg-danger rounded-pill">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill">Required</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ID Document Upload -->
                        @if(!in_array($profile->verification_status, ['submitted', 'approved']))
                        <div class="section-card mt-4">
                            <div class="section-header">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-upload text-warning me-2"></i>
                                    Submit ID Documents
                                </h5>
                            </div>
                            <div class="section-body">
                                <form action="{{ route('tasker.profile.submit-verification') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <label class="form-label fw-medium">Document Type</label>
                                            <select name="document_type" class="form-select form-select-lg" required>
                                                <option value="">Select document type</option>
                                                <option value="passport" {{ $profile->document_type == 'passport' ? 'selected' : '' }}>Passport</option>
                                                <option value="drivers_license" {{ $profile->document_type == 'drivers_license' ? 'selected' : '' }}>Driver's License</option>
                                                <option value="national_id" {{ $profile->document_type == 'national_id' ? 'selected' : '' }}>National ID Card</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Front Side</label>
                                            <div class="document-upload">
                                                <input type="file" name="document_front" id="documentFront" class="d-none" accept="image/*" required>
                                                <label for="documentFront" class="upload-area">
                                                    <i class="bi bi-cloud-arrow-up"></i>
                                                    <span>Click to upload front side</span>
                                                    <small>JPG, PNG up to 5MB</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Back Side</label>
                                            <div class="document-upload">
                                                <input type="file" name="document_back" id="documentBack" class="d-none" accept="image/*">
                                                <label for="documentBack" class="upload-area">
                                                    <i class="bi bi-cloud-arrow-up"></i>
                                                    <span>Click to upload back side</span>
                                                    <small>Optional for passport</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                                <label class="form-check-label" for="termsCheck">
                                                    I confirm that the documents are genuine and belong to me
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="bi bi-shield-check me-2"></i>Submit for Verification
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Benefits & Tips -->
                    <div class="col-lg-4">
                        <!-- Benefits -->
                        <div class="section-card mb-4">
                            <div class="section-header">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-star text-warning me-2"></i>
                                    Benefits
                                </h5>
                            </div>
                            <div class="section-body">
                                <div class="benefit-item">
                                    <div class="benefit-icon bg-success-subtle">
                                        <i class="bi bi-patch-check text-success"></i>
                                    </div>
                                    <div>
                                        <h6>Verified Badge</h6>
                                        <p class="text-muted mb-0 small">Display a trust badge on your profile</p>
                                    </div>
                                </div>
                                <div class="benefit-item">
                                    <div class="benefit-icon bg-primary-subtle">
                                        <i class="bi bi-graph-up-arrow text-primary"></i>
                                    </div>
                                    <div>
                                        <h6>Higher Visibility</h6>
                                        <p class="text-muted mb-0 small">Appear higher in search results</p>
                                    </div>
                                </div>
                                <div class="benefit-item">
                                    <div class="benefit-icon bg-warning-subtle">
                                        <i class="bi bi-people text-warning"></i>
                                    </div>
                                    <div>
                                        <h6>More Bookings</h6>
                                        <p class="text-muted mb-0 small">Customers prefer verified taskers</p>
                                    </div>
                                </div>
                                <div class="benefit-item">
                                    <div class="benefit-icon bg-info-subtle">
                                        <i class="bi bi-wallet2 text-info"></i>
                                    </div>
                                    <div>
                                        <h6>Faster Payouts</h6>
                                        <p class="text-muted mb-0 small">Unlock faster withdrawal options</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Accepted Documents -->
                        <div class="section-card">
                            <div class="section-header">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-file-earmark-text text-info me-2"></i>
                                    Accepted Documents
                                </h5>
                            </div>
                            <div class="section-body">
                                <ul class="document-list">
                                    <li><i class="bi bi-check-circle text-success me-2"></i>Passport</li>
                                    <li><i class="bi bi-check-circle text-success me-2"></i>Driver's License</li>
                                    <li><i class="bi bi-check-circle text-success me-2"></i>National ID Card</li>
                                </ul>
                                <div class="alert alert-light border mt-3 mb-0">
                                    <i class="bi bi-info-circle text-primary me-2"></i>
                                    <small>Documents must be valid, clearly visible, and not expired.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Wrapper */
.dashboard-wrapper {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    min-height: calc(100vh - 76px);
}

/* Page Header Card */
.page-header-card {
    background: linear-gradient(135deg, #FF6B35 0%, #ff8c5a 50%, #ffab7a 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(255, 107, 53, 0.3);
}

.page-header-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
}

.page-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0.35rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    margin-bottom: 0.75rem;
}

.page-title {
    color: white;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-description {
    color: rgba(255,255,255,0.9);
    font-size: 1rem;
    margin: 0;
}

.page-header-illustration img {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* Verification Status Card */
.verification-status-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.status-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    flex-shrink: 0;
}

.status-icon.status-approved {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.status-icon.status-submitted {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.status-icon.status-rejected {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.status-icon.status-pending {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.status-title {
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.status-description {
    color: #6b7280;
    margin: 0;
}

/* Section Card */
.section-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    overflow: hidden;
}

.section-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f3f4f6;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.section-body {
    padding: 1.5rem;
}

/* Verification Steps */
.verification-step {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    transition: all 0.3s ease;
}

.verification-step:last-child {
    border-bottom: none;
}

.verification-step:hover {
    background: #f9fafb;
}

.step-number {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: #6b7280;
    flex-shrink: 0;
}

.verification-step.completed .step-number {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.verification-step.rejected .step-number {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.step-content {
    flex: 1;
}

.step-content h6 {
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.25rem;
}

.step-content p {
    font-size: 0.85rem;
    color: #6b7280;
    margin: 0;
}

/* Document Upload */
.document-upload {
    margin-top: 0.5rem;
}

.upload-area {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    border: 2px dashed #e5e7eb;
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.upload-area:hover {
    border-color: #FF6B35;
    background: rgba(255, 107, 53, 0.05);
}

.upload-area i {
    font-size: 2.5rem;
    color: #9ca3af;
    margin-bottom: 0.75rem;
}

.upload-area span {
    font-weight: 500;
    color: #4b5563;
    margin-bottom: 0.25rem;
}

.upload-area small {
    color: #9ca3af;
}

/* Benefits */
.benefit-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.benefit-item:last-child {
    margin-bottom: 0;
}

.benefit-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.bg-success-subtle { background: rgba(16, 185, 129, 0.1); }
.bg-primary-subtle { background: rgba(255, 107, 53, 0.1); }
.bg-warning-subtle { background: rgba(245, 158, 11, 0.1); }
.bg-info-subtle { background: rgba(59, 130, 246, 0.1); }

.benefit-item h6 {
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.25rem;
    font-size: 0.95rem;
}

/* Document List */
.document-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.document-list li {
    padding: 0.5rem 0;
    color: #4b5563;
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    border: none;
    border-radius: 12px;
    font-weight: 600;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #e55a2b, #FF6B35);
}

/* Responsive */
@media (max-width: 991.98px) {
    .page-header-card {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .verification-status-card {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endsection