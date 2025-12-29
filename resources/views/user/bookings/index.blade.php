@extends('layouts.app')

@section('title', 'My Bookings')

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
                    <h5 class="mb-0">My Bookings</h5>
                </div>
                <div class="card-body">
                    @if(($bookings ?? collect([]))->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x display-1 text-muted"></i>
                            <h5 class="mt-3">No bookings yet</h5>
                            <p class="text-muted">Start by booking a service from our taskers!</p>
                            <a href="{{ route('categories.index') }}" class="btn btn-primary">Browse Services</a>
                        </div>
                    @else
                        @foreach($bookings as $booking)
                            <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                                <div>
                                    <h6 class="mb-1">{{ $booking->service->title ?? 'Service' }}</h6>
                                    <small class="text-muted">{{ $booking->booking_date }} at {{ $booking->start_time }}</small>
                                </div>
                                <span class="badge bg-{{ $booking->status == 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection