@extends('layouts.app')

@section('title', 'Messages')

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
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Messages</h5>
                </div>
                <div class="card-body">
                    @if(($conversations ?? collect([]))->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-chat-dots display-1 text-muted"></i>
                            <h5 class="mt-3">No messages yet</h5>
                            <p class="text-muted">Start a conversation by messaging a tasker.</p>
                        </div>
                    @else
                        @foreach($conversations as $conversation)
                            <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    {{ strtoupper(substr($conversation->tasker->first_name ?? 'T', 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $conversation->tasker->first_name ?? 'Tasker' }}</h6>
                                    <small class="text-muted">{{ $conversation->last_message ?? 'No messages' }}</small>
                                </div>
                                <small class="text-muted">{{ $conversation->updated_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection