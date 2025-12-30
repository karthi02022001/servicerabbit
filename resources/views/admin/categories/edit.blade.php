@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')
@section('page-subtitle', 'Update category details')

@push('styles')
<link href="{{ asset('assets/admin/css/create_edit.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <h5 class="form-card-title">
                        <i class="bi bi-info-circle"></i>
                        Basic Information
                    </h5>
                </div>
                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label form-label-required">Category Name</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $category->name) }}"
                                   placeholder="e.g., Furniture Assembly"
                                   required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" 
                                   name="slug" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   value="{{ old('slug', $category->slug) }}"
                                   placeholder="auto-generated">
                            <small class="form-text">Leave empty to auto-generate</small>
                            @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <input type="text" 
                               name="short_description" 
                               class="form-control @error('short_description') is-invalid @enderror" 
                               value="{{ old('short_description', $category->short_description) }}"
                               placeholder="Brief description (max 255 characters)"
                               maxlength="255">
                        @error('short_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Full Description</label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="4"
                                  placeholder="Detailed description of this category...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Media -->
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <h5 class="form-card-title">
                        <i class="bi bi-image"></i>
                        Media
                    </h5>
                </div>
                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category Icon</label>
                            <div class="file-upload-preview mb-2">
                                @if($category->icon)
                                <div id="icon-preview">
                                    <img src="{{ asset('storage/' . $category->icon) }}" 
                                         style="width:100px;height:100px;object-fit:cover;border-radius:10px;">
                                </div>
                                <form action="{{ route('admin.categories.remove-icon', $category) }}" 
                                      method="POST" class="d-inline mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Remove this icon?')">
                                        <i class="bi bi-trash"></i> Remove
                                    </button>
                                </form>
                                @else
                                <div class="preview-placeholder" id="icon-preview">
                                    <i class="bi bi-image"></i>
                                </div>
                                @endif
                            </div>
                            <input type="file" 
                                   name="icon" 
                                   class="form-control @error('icon') is-invalid @enderror"
                                   accept="image/png,image/jpeg,image/svg+xml"
                                   onchange="previewImage(this, 'icon-preview')">
                            <small class="form-text">Recommended: 64x64px, PNG/SVG/JPG (max 1MB)</small>
                            @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category Image</label>
                            <div class="file-upload-preview mb-2">
                                @if($category->image)
                                <div id="image-preview">
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         style="width:100px;height:100px;object-fit:cover;border-radius:10px;">
                                </div>
                                <form action="{{ route('admin.categories.remove-image', $category) }}" 
                                      method="POST" class="d-inline mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Remove this image?')">
                                        <i class="bi bi-trash"></i> Remove
                                    </button>
                                </form>
                                @else
                                <div class="preview-placeholder" id="image-preview">
                                    <i class="bi bi-image"></i>
                                </div>
                                @endif
                            </div>
                            <input type="file" 
                                   name="image" 
                                   class="form-control @error('image') is-invalid @enderror"
                                   accept="image/png,image/jpeg,image/webp"
                                   onchange="previewImage(this, 'image-preview')">
                            <small class="form-text">Recommended: 800x600px, PNG/JPG/WebP (max 2MB)</small>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Brand Color</label>
                        <div class="input-group" style="max-width: 200px;">
                            <input type="color" 
                                   name="color" 
                                   class="form-control form-control-color" 
                                   value="{{ old('color', $category->color ?? '#FF6B35') }}"
                                   style="height: 42px;">
                            <input type="text" 
                                   class="form-control" 
                                   value="{{ old('color', $category->color ?? '#FF6B35') }}"
                                   pattern="^#[0-9A-Fa-f]{6}$"
                                   id="color-text">
                        </div>
                        <small class="form-text">Used for category branding</small>
                    </div>
                </div>
            </div>
            
            <!-- Pricing & Fees -->
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <h5 class="form-card-title">
                        <i class="bi bi-currency-dollar"></i>
                        Pricing & Fees
                    </h5>
                </div>
                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Average Hourly Rate</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       name="avg_hourly_rate" 
                                       class="form-control @error('avg_hourly_rate') is-invalid @enderror" 
                                       value="{{ old('avg_hourly_rate', $category->avg_hourly_rate) }}"
                                       step="0.01"
                                       min="0"
                                       max="9999.99"
                                       placeholder="0.00">
                            </div>
                            <small class="form-text">Display rate (for reference)</small>
                            @error('avg_hourly_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label form-label-required">Commission Rate</label>
                            <div class="input-group">
                                <input type="number" 
                                       name="commission_percentage" 
                                       class="form-control @error('commission_percentage') is-invalid @enderror" 
                                       value="{{ old('commission_percentage', $category->commission_percentage) }}"
                                       step="0.01"
                                       min="0"
                                       max="100"
                                       required>
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="form-text">Platform fee from bookings</small>
                            @error('commission_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label form-label-required">Cancellation Fee</label>
                            <div class="input-group">
                                <input type="number" 
                                       name="cancellation_fee_percentage" 
                                       class="form-control @error('cancellation_fee_percentage') is-invalid @enderror" 
                                       value="{{ old('cancellation_fee_percentage', $category->cancellation_fee_percentage) }}"
                                       step="0.01"
                                       min="0"
                                       max="100"
                                       required>
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="form-text">Fee for late cancellations</small>
                            @error('cancellation_fee_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Requirements & Settings -->
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <h5 class="form-card-title">
                        <i class="bi bi-gear"></i>
                        Requirements & Settings
                    </h5>
                </div>
                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-required">Sort Order</label>
                            <input type="number" 
                                   name="sort_order" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   value="{{ old('sort_order', $category->sort_order) }}"
                                   min="0"
                                   required>
                            <small class="form-text">Lower numbers appear first</small>
                            @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-required">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="toggle-item">
                        <div class="form-check form-switch">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   name="is_featured" 
                                   value="1"
                                   id="is_featured"
                                   {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
                        </div>
                        <div class="toggle-content">
                            <strong>Featured Category</strong>
                            <small>Display prominently on homepage and search</small>
                        </div>
                    </div>
                    
                    <div class="toggle-item">
                        <div class="form-check form-switch">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   name="vehicle_required" 
                                   value="1"
                                   id="vehicle_required"
                                   {{ old('vehicle_required', $category->vehicle_required) ? 'checked' : '' }}>
                        </div>
                        <div class="toggle-content">
                            <strong>Vehicle Required</strong>
                            <small>Taskers must have a vehicle to offer services</small>
                        </div>
                    </div>
                    
                    <div class="toggle-item">
                        <div class="form-check form-switch">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   name="background_check_required" 
                                   value="1"
                                   id="background_check_required"
                                   {{ old('background_check_required', $category->background_check_required) ? 'checked' : '' }}>
                        </div>
                        <div class="toggle-content">
                            <strong>Background Check Required</strong>
                            <small>Taskers must pass background verification</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- SEO -->
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <h5 class="form-card-title">
                        <i class="bi bi-search"></i>
                        SEO Settings
                    </h5>
                </div>
                <div class="form-card-body">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" 
                               name="meta_title" 
                               class="form-control @error('meta_title') is-invalid @enderror" 
                               value="{{ old('meta_title', $category->meta_title) }}"
                               placeholder="SEO title (leave empty to use category name)"
                               maxlength="255">
                        @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" 
                                  class="form-control @error('meta_description') is-invalid @enderror" 
                                  rows="3"
                                  placeholder="SEO description (recommended: 150-160 characters)"
                                  maxlength="500">{{ old('meta_description', $category->meta_description) }}</textarea>
                        @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>
                    Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg me-1"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>
    
    <div class="col-lg-4">
        <!-- Category Info Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Category Info</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Created:</span>
                        <span>{{ $category->created_at->format('M d, Y') }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Updated:</span>
                        <span>{{ $category->updated_at->format('M d, Y') }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Subcategories:</span>
                        <span class="badge bg-info">{{ $category->subcategories()->count() }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted">Services:</span>
                        <span class="badge bg-primary">{{ $category->services()->count() }}</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Help Card -->
        <div class="help-card">
            <div class="help-card-header">
                <h6><i class="bi bi-question-circle me-2"></i>Help Guide</h6>
            </div>
            <div class="help-card-body">
                <h6>Commission Rate</h6>
                <p>The platform fee charged on each booking. Standard is 10-20%.</p>
                
                <h6>Cancellation Fee</h6>
                <p>Fee charged when users cancel after deadline. Typically 5-10%.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Image preview
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" style="width:100px;height:100px;object-fit:cover;border-radius:10px;">';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Color picker sync
document.querySelector('input[name="color"]').addEventListener('input', function(e) {
    document.getElementById('color-text').value = e.target.value;
});

document.getElementById('color-text').addEventListener('input', function(e) {
    if (/^#[0-9A-Fa-f]{6}$/.test(e.target.value)) {
        document.querySelector('input[name="color"]').value = e.target.value;
    }
});
</script>
@endpush