@extends('admin.layouts.app')

@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin: ' . $admin->full_name)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.admins.update', $admin) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Basic Information</h5></div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $admin->first_name) }}" required>
                            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $admin->last_name) }}" required>
                            @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $admin->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $admin->phone) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Avatar</label>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $admin->avatar_url }}" class="rounded" style="width:60px;height:60px;object-fit:cover;">
                            <input type="file" class="form-control" name="avatar" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Change Password</h5></div>
                <div class="card-body">
                    <p class="text-muted small">Leave blank to keep current password</p>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Roles & Status</h5></div>
                <div class="card-body">
                    @if($admin->is_super_admin)
                        <div class="alert alert-info">Super Admin roles cannot be modified.</div>
                    @else
                        @error('roles')<div class="alert alert-danger">{{ $message }}</div>@enderror
                        <div class="mb-4">
                            <label class="form-label">Assign Roles</label>
                            <div class="row">
                                @foreach($roles as $role)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check p-3 bg-light rounded">
                                        <input class="form-check-input" type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->id }}"
                                               {{ in_array($role->id, old('roles', $adminRoles)) ? 'checked' : '' }}
                                               {{ $role->slug === 'super_admin' ? 'disabled' : '' }}>
                                        <label class="form-check-label" for="role_{{ $role->id }}"><strong>{{ $role->name }}</strong></label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    @if($admin->id !== Auth::guard('admin')->id())
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" 
                               {{ old('is_active', $admin->is_active) ? 'checked' : '' }} {{ $admin->is_super_admin ? 'disabled' : '' }}>
                        <label class="form-check-label" for="is_active"><strong>Active Account</strong></label>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i> Update Admin</button>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Admin Details</h5></div>
            <div class="card-body">
                <p><small class="text-muted">Created:</small> {{ $admin->created_at->format('M d, Y h:i A') }}</p>
                <p><small class="text-muted">Last Login:</small> {{ $admin->last_login_at?->format('M d, Y h:i A') ?? 'Never' }}</p>
            </div>
        </div>
        
        @if($admin->id !== Auth::guard('admin')->id() && !$admin->is_super_admin)
        <div class="card border-danger">
            <div class="card-header bg-danger bg-opacity-10 text-danger"><h5 class="mb-0">Danger Zone</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" onsubmit="return confirm('Delete this admin?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm w-100"><i class="bi bi-trash me-2"></i> Delete Admin</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection