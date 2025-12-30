@extends('admin.layouts.app')

@section('title', 'Edit Subcategory')
@section('page-title', 'Edit Subcategory')
@section('page-subtitle', 'Update subcategory details')

@push('styles')
<link href="{{ asset('assets/admin/css/create_edit.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('admin.subcategories.update', $subcategory) }}" method="POST" enctype="multipart/form-data">
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
                    <div class="mb-3">
                        <label class="form-label form-label-required">Parent Category</label>
                        <select name="category_id" 
                                class="form-select @error('category_id') is-invalid @enderror" 
                                required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label form-label-required">Subcategory Name</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $subcategory->name) }}"
                                   placeholder="e.g., Office Furniture Assembly"
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
                                   value="{{ old('slug', $subcategory->slug) }}"
                                   placeholder="auto-generated">
                            <small class="form-text">Leave empty to auto-generate</small>
                            @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="4"
                                  placeholder="Describe this subcategory...">{{ old('description', $subcategory->description) }}</textarea>
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
                    <div class="mb-3">
                        <label class="form-label">Subcategory Image</label>
                        <div class="file-upload-preview mb-2">
                            @if($subcategory->image)
                            <div id="image-preview">
                                <img src="{{ asset('storage/' . $subcategory->image) }}" 
                                     style="width:100px;height:100px;object-fit:cover;border-radius:10px;">
                            </div>
                            <form action="{{ route('admin.subcategories.remove-image', $subcategory) }}" 
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
                        <small class="form-text">Recommended: 600x400px, PNG/JPG/WebP (max 2MB)</small>
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Settings -->
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <h5 class="form-card-title">
                        <i class="bi bi-gear"></i>
                        Settings
                    </h5>
                </div>
                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-required">Sort Order</label>
                            <input type="number" 
                                   name="sort_order" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   value="{{ old('sort_order', $subcategory->sort_order) }}"
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
                                <option value="active" {{ old('status', $subcategory->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $subcategory->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                   {{ old('is_featured', $subcategory->is_featured) ? 'checked' : '' }}>
                        </div>
                        <div class="toggle-content">
                            <strong>Featured Subcategory</strong>
                            <small>Display prominently in category page</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>
                    Update Subcategory
                </button>
                <a href="{{ route('admin.subcategories.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg me-1"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>
    
    <div class="col-lg-4">
        <!-- Subcategory Info Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Subcategory Info</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Created:</span>
                        <span>{{ $subcategory->created_at->format('M d, Y') }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Updated:</span>
                        <span>{{ $subcategory->updated_at->format('M d, Y') }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted">Services:</span>
                        <span class="badge bg-info">{{ $subcategory->services()->count() }}</span>
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
                <h6>Parent Category</h6>
                <p>You can move this subcategory to a different category if needed.</p>
                
                <h6>Featured</h6>
                <p>Featured subcategories appear at the top of category pages.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
</script>
@endpush