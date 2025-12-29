@extends('layouts.app')

@section('title', 'My Reviews')

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
                    <h5 class="mb-0">My Reviews</h5>
                </div>
                <div class="card-body">
                    @if(($reviews ?? collect([]))->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-star display-1 text-muted"></i>
                            <h5 class="mt-3">No reviews yet</h5>
                            <p class="text-muted">After completing a booking, you can leave a review for your tasker.</p>
                        </div>
                    @else
                        @foreach($reviews as $review)
                            <div class="py-3 border-bottom">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>{{ $review->reviewee->first_name ?? 'Tasker' }}</strong>
                                    <span class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </span>
                                </div>
                                <p class="text-muted mb-0">{{ $review->comment }}</p>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection