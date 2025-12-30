@extends('admin.layouts.app')

@section('title', 'Admin Users')
@section('page-title', 'Admin Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Manage administrator accounts</p>
    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i> Add Admin
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search name or email...">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="role">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-funnel me-1"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Admins Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Admin</th>
                        <th>Email</th>
                        <th>Role(s)</th>
                        <th>Last Login</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $admin->avatar_url }}" alt="" class="rounded me-3" style="width:40px;height:40px;object-fit:cover;">
                                <div>
                                    <div class="fw-semibold">{{ $admin->full_name }}
                                        @if($admin->is_super_admin)<span class="badge bg-danger ms-1">Super</span>@endif
                                    </div>
                                    <small class="text-muted">{{ $admin->phone }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            @forelse($admin->roles as $role)
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $role->name }}</span>
                            @empty
                                <span class="text-muted">-</span>
                            @endforelse
                        </td>
                        <td>
                            @if($admin->last_login_at)
                                {{ $admin->last_login_at->format('M d, Y h:i A') }}
                            @else
                                <span class="text-muted">Never</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $admin->is_active ? 'success' : 'secondary' }}">
                                {{ $admin->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.admins.show', $admin) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                                @if($admin->id !== Auth::guard('admin')->id() && !$admin->is_super_admin)
                                <form method="POST" action="{{ route('admin.admins.toggle-status', $admin) }}" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-{{ $admin->is_active ? 'warning' : 'success' }}">
                                        <i class="bi bi-toggle-{{ $admin->is_active ? 'on' : 'off' }}"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-person-gear display-4 d-block mb-3"></i>No admin users found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($admins->hasPages())
<div class="d-flex justify-content-center mt-4">{{ $admins->withQueryString()->links() }}</div>
@endif
@endsection