@extends('admin.layouts.app')

@section('title', 'Roles')
@section('page-title', 'Roles & Permissions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">Manage admin roles and their permissions</p>
    </div>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i> Create Role
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Role Name</th>
                        <th>Description</th>
                        <th>Permissions</th>
                        <th>Admins</th>
                        <th>Default</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="role-icon me-3">
                                    <div class="icon-circle bg-{{ $role->slug === 'super_admin' ? 'danger' : 'primary' }} bg-opacity-10">
                                        <i class="bi bi-shield-{{ $role->slug === 'super_admin' ? 'fill' : 'check' }} text-{{ $role->slug === 'super_admin' ? 'danger' : 'primary' }}"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $role->name }}</div>
                                    <small class="text-muted">{{ $role->slug }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted">{{ $role->description ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info bg-opacity-10 text-info">
                                {{ $role->permissions_count }} permissions
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                {{ $role->admins_count }} admins
                            </span>
                        </td>
                        <td>
                            @if($role->is_default)
                                <span class="badge bg-success">Default</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($role->slug !== 'super_admin')
                                <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" {{ $role->admins_count > 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-shield display-4 d-block mb-3"></i>
                                No roles found
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($roles->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $roles->links() }}
</div>
@endif

<style>
.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}
</style>
@endsection