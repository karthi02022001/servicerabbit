@extends('layouts.app')

@section('title', 'Become a Tasker - Verification')

@section('content')
<div class="registration-container">
    <div class="container py-5">
        <!-- Progress Steps -->
        <div class="progress-steps mb-5">
            <div class="step-item completed">
                <div class="step-circle"><i class="bi bi-check"></i></div>
                <span class="step-label">Profile</span>
            </div>
            <div class="step-line active"></div>
            <div class="step-item completed">
                <div class="step-circle"><i class="bi bi-check"></i></div>
                <span class="step-label">Services</span>
            </div>
            <div class="step-line active"></div>
            <div class="step-item completed">
                <div class="step-circle"><i class="bi bi-check"></i></div>
                <span class="step-label">Availability</span>
            </div>
            <div class="step-line active"></div>
            <div class="step-item active">
                <div class="step-circle">4</div>
                <span class="step-label">Verification</span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="step-card">
                    <div class="step-header">
                        <h2><i class="bi bi-shield-check me-2"></i>Identity Verification</h2>
                        <p>Upload a valid ID to verify your identity and build trust with customers</p>
                    </div>

                    <!-- Security Notice -->
                    <div class="security-notice mb-4">
                        <div class="security-icon">
                            <i class="bi bi-lock-fill"></i>
                        </div>
                        <div class="security-text">
                            <strong>Your data is secure</strong>
                            <p class="mb-0">All documents are encrypted and stored securely. We only use this information to verify your identity.</p>
                        </div>
                    </div>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('tasker.register.step4.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Document Type Selection -->
                        <div class="document-type-section mb-4">
                            <label class="form-label fw-semibold">Select Document Type <span class="text-danger">*</span></label>
                            <div class="document-types">
                                <label class="document-type-card">
                                    <input type="radio" name="id_document_type" value="passport" 
                                        {{ old('id_document_type', $profile->id_document_type) == 'passport' ? 'checked' : '' }} required>
                                    <div class="card-content">
                                        <i class="bi bi-book"></i>
                                        <span>Passport</span>
                                    </div>
                                </label>
                                <label class="document-type-card">
                                    <input type="radio" name="id_document_type" value="drivers_license"
                                        {{ old('id_document_type', $profile->id_document_type) == 'drivers_license' ? 'checked' : '' }}>
                                    <div class="card-content">
                                        <i class="bi bi-car-front"></i>
                                        <span>Driver's License</span>
                                    </div>
                                </label>
                                <label class="document-type-card">
                                    <input type="radio" name="id_document_type" value="national_id"
                                        {{ old('id_document_type', $profile->id_document_type) == 'national_id' ? 'checked' : '' }}>
                                    <div class="card-content">
                                        <i class="bi bi-person-vcard"></i>
                                        <span>National ID</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Document Upload -->
                        <div class="document-upload-section mb-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Front Side <span class="text-danger">*</span></label>
                                    <div class="upload-area" id="frontUploadArea">
                                        <input type="file" name="id_document_front" id="frontUpload" 
                                            accept="image/jpeg,image/png" class="d-none" required>
                                        <div class="upload-placeholder" id="frontPlaceholder">
                                            <i class="bi bi-cloud-arrow-up"></i>
                                            <span>Click to upload front side</span>
                                            <small>JPG or PNG, max 5MB</small>
                                        </div>
                                        <div class="upload-preview d-none" id="frontPreview">
                                            <img src="" alt="Front Preview">
                                            <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeFront()">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Back Side <span class="text-danger">*</span></label>
                                    <div class="upload-area" id="backUploadArea">
                                        <input type="file" name="id_document_back" id="backUpload" 
                                            accept="image/jpeg,image/png" class="d-none" required>
                                        <div class="upload-placeholder" id="backPlaceholder">
                                            <i class="bi bi-cloud-arrow-up"></i>
                                            <span>Click to upload back side</span>
                                            <small>JPG or PNG, max 5MB</small>
                                        </div>
                                        <div class="upload-preview d-none" id="backPreview">
                                            <img src="" alt="Back Preview">
                                            <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeBack()">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Photo Tips -->
                        <div class="tips-card mb-4">
                            <h6><i class="bi bi-lightbulb me-2"></i>Photo Tips</h6>
                            <ul class="mb-0">
                                <li>Ensure the entire document is visible</li>
                                <li>Photo must be clear and in focus</li>
                                <li>All text must be readable</li>
                                <li>Avoid glare and shadows</li>
                            </ul>
                        </div>

                        <!-- Terms Agreement -->
                        <div class="terms-section mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="terms_accepted" 
                                    id="terms" value="1" required>
                                <label class="form-check-label" for="terms">
                                    I confirm that the document I'm uploading is genuine and belongs to me. 
                                    I agree to the <a href="#" target="_blank">Terms of Service</a> and 
                                    <a href="#" target="_blank">Tasker Agreement</a>.
                                </label>
                            </div>
                        </div>

                        <!-- What Happens Next -->
                        <div class="next-steps-card mb-4">
                            <h6><i class="bi bi-info-circle me-2"></i>What Happens Next?</h6>
                            <div class="timeline-mini">
                                <div class="timeline-item-mini">
                                    <div class="timeline-dot-mini"></div>
                                    <span>Submit your application</span>
                                </div>
                                <div class="timeline-item-mini">
                                    <div class="timeline-dot-mini"></div>
                                    <span>Our team reviews your documents (1-2 business days)</span>
                                </div>
                                <div class="timeline-item-mini">
                                    <div class="timeline-dot-mini"></div>
                                    <span>Receive approval notification</span>
                                </div>
                                <div class="timeline-item-mini">
                                    <div class="timeline-dot-mini"></div>
                                    <span>Start accepting tasks!</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="step-actions">
                            <a href="{{ route('tasker.register.step3') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i> Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.registration-container { background: #f8f9fa; min-height: calc(100vh - 80px); }
.progress-steps { display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
.step-item { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; }
.step-circle { width: 45px; height: 45px; border-radius: 50%; background: #e5e7eb; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #6b7280; }
.step-item.active .step-circle, .step-item.completed .step-circle { background: linear-gradient(135deg, #FF6B35, #e55a2b); color: white; }
.step-label { font-size: 0.8rem; color: #6b7280; font-weight: 500; }
.step-item.active .step-label { color: #FF6B35; font-weight: 600; }
.step-line { flex: 1; max-width: 100px; height: 3px; background: #e5e7eb; }
.step-line.active { background: #FF6B35; }
.step-card { background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
.step-header { margin-bottom: 2rem; }
.step-header h2 { font-size: 1.5rem; font-weight: 700; color: #1A1A2E; margin-bottom: 0.5rem; }
.step-header p { color: #6b7280; margin: 0; }
.security-notice { display: flex; gap: 1rem; padding: 1.25rem; background: linear-gradient(135deg, #ecfdf5, #d1fae5); border-radius: 12px; }
.security-icon { width: 45px; height: 45px; background: #10b981; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; flex-shrink: 0; }
.security-text strong { color: #065f46; display: block; margin-bottom: 0.25rem; }
.security-text p { font-size: 0.875rem; color: #047857; }
.document-types { display: flex; gap: 1rem; flex-wrap: wrap; }
.document-type-card { flex: 1; min-width: 120px; cursor: pointer; }
.document-type-card input { display: none; }
.document-type-card .card-content { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; padding: 1.25rem; background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; transition: all 0.3s; }
.document-type-card .card-content i { font-size: 1.75rem; color: #6b7280; }
.document-type-card .card-content span { font-weight: 500; font-size: 0.875rem; color: #374151; }
.document-type-card input:checked + .card-content { border-color: #FF6B35; background: #fff5f0; }
.document-type-card input:checked + .card-content i { color: #FF6B35; }
.upload-area { border: 2px dashed #d1d5db; border-radius: 12px; cursor: pointer; transition: all 0.3s; overflow: hidden; }
.upload-area:hover { border-color: #FF6B35; background: #fff5f0; }
.upload-placeholder { padding: 2rem; text-align: center; }
.upload-placeholder i { font-size: 2.5rem; color: #9ca3af; display: block; margin-bottom: 0.5rem; }
.upload-placeholder span { display: block; font-weight: 500; color: #374151; margin-bottom: 0.25rem; }
.upload-placeholder small { color: #9ca3af; }
.upload-preview { position: relative; }
.upload-preview img { width: 100%; height: 200px; object-fit: cover; }
.upload-preview .remove-btn { position: absolute; top: 0.5rem; right: 0.5rem; border-radius: 50%; width: 30px; height: 30px; padding: 0; }
.tips-card { background: #eff6ff; border-radius: 12px; padding: 1.25rem; }
.tips-card h6 { color: #1e40af; font-weight: 600; margin-bottom: 0.75rem; }
.tips-card ul { padding-left: 1.25rem; color: #1e40af; font-size: 0.875rem; }
.tips-card li { margin-bottom: 0.25rem; }
.next-steps-card { background: #f9fafb; border-radius: 12px; padding: 1.25rem; }
.next-steps-card h6 { font-weight: 600; margin-bottom: 1rem; color: #1A1A2E; }
.timeline-mini { padding-left: 1rem; }
.timeline-item-mini { display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0; position: relative; }
.timeline-item-mini:not(:last-child)::before { content: ''; position: absolute; left: 4px; top: 24px; bottom: -8px; width: 2px; background: #d1d5db; }
.timeline-dot-mini { width: 10px; height: 10px; border-radius: 50%; background: #FF6B35; flex-shrink: 0; }
.timeline-item-mini span { font-size: 0.875rem; color: #4b5563; }
.step-actions { display: flex; justify-content: space-between; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb; }
.btn-lg { padding: 0.875rem 2rem; border-radius: 12px; font-weight: 600; }
</style>
@endpush

@push('scripts')
<script>
document.getElementById('frontUploadArea').addEventListener('click', function() {
    document.getElementById('frontUpload').click();
});

document.getElementById('backUploadArea').addEventListener('click', function() {
    document.getElementById('backUpload').click();
});

document.getElementById('frontUpload').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('frontPlaceholder').classList.add('d-none');
            document.getElementById('frontPreview').classList.remove('d-none');
            document.getElementById('frontPreview').querySelector('img').src = e.target.result;
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

document.getElementById('backUpload').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('backPlaceholder').classList.add('d-none');
            document.getElementById('backPreview').classList.remove('d-none');
            document.getElementById('backPreview').querySelector('img').src = e.target.result;
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

function removeFront() {
    event.stopPropagation();
    document.getElementById('frontUpload').value = '';
    document.getElementById('frontPlaceholder').classList.remove('d-none');
    document.getElementById('frontPreview').classList.add('d-none');
}

function removeBack() {
    event.stopPropagation();
    document.getElementById('backUpload').value = '';
    document.getElementById('backPlaceholder').classList.remove('d-none');
    document.getElementById('backPreview').classList.add('d-none');
}
</script>
@endpush