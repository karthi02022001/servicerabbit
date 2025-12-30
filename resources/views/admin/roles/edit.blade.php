@extends('admin.layouts.app')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role: ' . $role->name)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
            @csrf
            @method('PUT')
            
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
                               value="{{ old('name', $role->name) }}" 
                               {{ $role->slug === 'super_admin' ? 'readonly' : '' }}
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
                                  rows="2">{{ old('description', $role->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" 
                               {{ old('is_default', $role->is_default) ? 'checked' : '' }}
                               {{ $role->slug === 'super_admin' ? 'disabled' : '' }}>
                        <label class="form-check-label" for="is_default">
                            Set as default role for new admins
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Permissions</h5>
                    @if($role->slug !== 'super_admin')
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll()">Select All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">Deselect All</button>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    @if($role->slug === 'super_admin')
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Super Admin automatically has all permissions and cannot be modified.
                        </div>
                    @else
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
                                                   {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-2"></i> Update Role
                </button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Role Details</h5>
            </div>
            <div class="card-body">
                <p class="mb-2"><small class="text-muted">Slug:</small> <code>{{ $role->slug }}</code></p>
                <p class="mb-2"><small class="text-muted">Created:</small> {{ $role->created_at->format('M d, Y') }}</p>
                <p class="mb-0"><small class="text-muted">Admins:</small> <span class="badge bg-primary">{{ $role->admins()->count() }}</span></p>
            </div>
        </div>
        
        @if($role->slug !== 'super_admin' && $role->admins()->count() === 0)
        <div class="card border-danger">
            <div class="card-header bg-danger bg-opacity-10 text-danger">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('Delete this role?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-trash me-2"></i> Delete Role
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.permission-group { background: #f8f9fa; border-radius: 12px; padding: 1rem; height: 100%; }
.form-check-input:checked { background-color: #FF6B35; border-color: #FF6B35; }
</style>

@push('scripts')
<script>
function selectAll() { document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true); }
function deselectAll() { document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false); }
function toggleGroup(groupSlug) {
    const checkboxes = document.querySelectorAll('.group-' + groupSlug);
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    checkboxes.forEach(cb => cb.checked = !allChecked);
}
</script>
@endpush
@endsection