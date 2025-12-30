@extends('admin.layouts.app')

@section('title', 'Activity Logs')
@section('page-title', 'Activity Logs')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <select class="form-select" name="admin_id">
                    <option value="">All Admins</option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>{{ $admin->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="action">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" placeholder="From">
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}" placeholder="To">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search...">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-funnel"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>Admin</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>IP</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>
                            <div>{{ $log->created_at->format('M d, Y') }}</div>
                            <small class="text-muted">{{ $log->created_at->format('h:i:s A') }}</small>
                        </td>
                        <td>
                            @if($log->admin)
                                <div class="d-flex align-items-center">
                                    <img src="{{ $log->admin->avatar_url }}" class="rounded me-2" style="width:32px;height:32px;object-fit:cover;">
                                    <div>
                                        <div class="fw-semibold">{{ $log->admin->full_name }}</div>
                                        <small class="text-muted">{{ $log->admin->email }}</small>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">Deleted Admin</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $log->action_badge }} bg-opacity-10 text-{{ $log->action_badge }}">
                                <i class="bi {{ $log->action_icon }} me-1"></i>{{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td>{{ Str::limit($log->description, 50) }}</td>
                        <td><code class="small">{{ $log->ip_address }}</code></td>
                        <td>
                            @if($log->old_values || $log->new_values)
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#log{{ $log->id }}">
                                <i class="bi bi-eye"></i>
                            </button>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-activity display-4 d-block mb-3"></i>No activity logs
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($logs->hasPages())
<div class="d-flex justify-content-center mt-4">{{ $logs->withQueryString()->links() }}</div>
@endif

<!-- Modals -->
@foreach($logs as $log)
@if($log->old_values || $log->new_values)
<div class="modal fade" id="log{{ $log->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activity Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-6"><small class="text-muted">Admin:</small> <strong>{{ $log->admin->full_name ?? 'System' }}</strong></div>
                    <div class="col-6"><small class="text-muted">Date:</small> <strong>{{ $log->created_at->format('M d, Y h:i:s A') }}</strong></div>
                </div>
                <p><small class="text-muted">Description:</small> {{ $log->description }}</p>
                @if($log->old_values)
                <h6 class="text-danger"><i class="bi bi-dash-circle me-1"></i>Old Values</h6>
                <pre class="bg-light p-3 rounded small">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                @endif
                @if($log->new_values)
                <h6 class="text-success"><i class="bi bi-plus-circle me-1"></i>New Values</h6>
                <pre class="bg-light p-3 rounded small">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection