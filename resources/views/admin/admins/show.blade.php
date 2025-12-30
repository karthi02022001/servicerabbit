@extends('admin.layouts.app')

@section('title', 'View Admin')
@section('page-title', 'Admin Details')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center py-4">
                <img src="{{ $admin->avatar_url }}" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;">
                <h4 class="mb-1">{{ $admin->full_name }}</h4>
                <p class="text-muted mb-3">{{ $admin->email }}</p>
                <div class="d-flex justify-content-center gap-2 mb-3">
                    @if($admin->is_super_admin)<span class="badge bg-danger">Super Admin</span>@endif
                    <span class="badge bg-{{ $admin->is_active ? 'success' : 'secondary' }}">{{ $admin->is_active ? 'Active' : 'Inactive' }}</span>
                </div>
                <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Account Info</h5></div>
            <div class="card-body">
                <p><small class="text-muted">Phone:</small> {{ $admin->phone ?? 'N/A' }}</p>
                <p><small class="text-muted">Created:</small> {{ $admin->created_at->format('M d, Y h:i A') }}</p>
                <p class="mb-0"><small class="text-muted">Last Login:</small> {{ $admin->last_login_at?->format('M d, Y h:i A') ?? 'Never' }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Roles & Permissions</h5></div>
            <div class="card-body">
                @if($admin->is_super_admin)
                    <div class="alert alert-danger mb-0"><i class="bi bi-shield-fill me-2"></i><strong>Super Admin</strong> - Full access to all features.</div>
                @else
                    <h6 class="mb-3">Assigned Roles</h6>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @forelse($admin->roles as $role)
                            <span class="badge bg-primary" style="padding:0.5rem 1rem;font-size:0.85rem;">{{ $role->name }}</span>
                        @empty
                            <span class="text-muted">No roles assigned</span>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Activity</h5>
                <a href="{{ route('admin.activity-logs.index', ['admin_id' => $admin->id]) }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentActivity as $activity)
                <div class="d-flex p-3 border-bottom">
                    <div class="me-3">
                        <span class="badge bg-{{ $activity->action_badge }}"><i class="bi {{ $activity->action_icon }}"></i></span>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <strong class="text-capitalize">{{ str_replace('_', ' ', $activity->action) }}</strong>
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="text-muted small mb-0">{{ $activity->description }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 text-muted">No recent activity</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection