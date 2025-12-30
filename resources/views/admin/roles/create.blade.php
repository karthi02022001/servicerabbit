@extends('admin.layouts.app')

@section('title', 'Create Role')
@section('page-title', 'Create New Role')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Role Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="e.g., Content Manager"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="2" 
                                  placeholder="Brief description of this role">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_default">
                            Set as default role for new admins
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Permissions</h5>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll()">Select All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">Deselect All</button>
                    </div>
                </div>
                <div class="card-body">
                    @error('permissions')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    
                    <div class="row">
                        @foreach($permissions as $groupName => $groupPermissions)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="permission-group">
                                <div class="permission-group-header d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="bi bi-folder me-2 text-primary"></i>
                                        {{ $groupName }}
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-link p-0" onclick="toggleGroup('{{ Str::slug($groupName) }}')">
                                        Toggle
                                    </button>
                                </div>
                                <div class="permission-list ps-4">
                                    @foreach($groupPermissions as $permission)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input permission-checkbox group-{{ Str::slug($groupName) }}" 
                                               type="checkbox" 
                                               name="permissions[]" 
                                               id="permission_{{ $permission->id }}" 
                                               value="{{ $permission->id }}"
                                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                            @if($permission->description)
                                            <small class="text-muted d-block">{{ $permission->description }}</small>
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-2"></i> Create Role
                </button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Help</h5>
            </div>
            <div class="card-body">
                <h6 class="fw-semibold mb-2">About Roles</h6>
                <p class="text-muted small">
                    Roles define what actions an admin can perform in the system. 
                    Each role can have multiple permissions assigned to it.
                </p>
                
                <h6 class="fw-semibold mb-2 mt-3">Permission Groups</h6>
                <ul class="text-muted small ps-3">
                    <li><strong>Users</strong> - Manage customer accounts</li>
                    <li><strong>Taskers</strong> - Manage tasker profiles & verification</li>
                    <li><strong>Bookings</strong> - Handle booking operations</li>
                    <li><strong>Payments</strong> - Process payments & payouts</li>
                    <li><strong>Categories</strong> - Manage service categories</li>
                    <li><strong>Reviews</strong> - Moderate user reviews</li>
                    <li><strong>Settings</strong> - System configuration</li>
                </ul>
                
                <div class="alert alert-info small mt-3 mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Super Admins automatically have all permissions.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.permission-group {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1rem;
    height: 100%;
}

.permission-group-header h6 {
    font-size: 0.9rem;
}

.permission-list .form-check-label {
    font-size: 0.85rem;
}

.form-check-input:checked {
    background-color: #FF6B35;
    border-color: #FF6B35;
}
</style>

@push('scripts')
<script>
function selectAll() {
    document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
}

function deselectAll() {
    document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
}

function toggleGroup(groupSlug) {
    const checkboxes = document.querySelectorAll('.group-' + groupSlug);
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    checkboxes.forEach(cb => cb.checked = !allChecked);
}
</script>
@endpush
@endsection