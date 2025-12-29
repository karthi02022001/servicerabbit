@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            @include('user.partials.sidebar')
        </div>
        
        <!-- Content -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Notifications</h5>
                    @if(($notifications ?? collect([]))->isNotEmpty())
                        <button class="btn btn-sm btn-outline-primary">Mark All as Read</button>
                    @endif
                </div>
                <div class="card-body p-0">
                    @if(($notifications ?? collect([]))->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-bell display-1 text-muted"></i>
                            <h5 class="mt-3">No notifications</h5>
                            <p class="text-muted">You're all caught up!</p>
                        </div>
                    @else
                        @foreach($notifications as $notification)
                            <div class="d-flex align-items-start gap-3 p-3 border-bottom {{ $notification->read_at ? '' : 'bg-light' }}">
                                <div class="rounded-circle bg-primary-soft text-primary d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-bell"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1">{{ $notification->data['message'] ?? 'Notification' }}</p>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-primary-soft {
    background-color: rgba(255, 107, 53, 0.1);
}
</style>
@endsection