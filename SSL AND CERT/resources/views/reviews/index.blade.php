@extends('layouts.master')
@section('title', 'Product Reviews')
@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Reviews for {{ $product->name }}</h2>
        </div>
        <div class="col-md-4 text-end">
            @can('add_review')
            <a href="{{ route('reviews.create', $product->id) }}" class="btn btn-primary">Add Your Review</a>
            @endcan
            <a href="{{ route('products_list') }}" class="btn btn-secondary">Back to Products</a>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Average Rating: {{ number_format($product->average_rating, 1) }} / 5</h5>
                        <span>{{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($reviews->count() > 0)
        @foreach($reviews as $review)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h5 class="mb-0">{{ $review->user->name }}</h5>
                            <small class="text-muted">{{ $review->created_at->format('F j, Y') }}</small>
                        </div>
                        <div>
                            <span class="badge bg-primary">Rating: {{ $review->rating }}/5</span>
                        </div>
                    </div>
                    <p class="card-text">{{ $review->comment }}</p>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            No reviews yet. Be the first to review this product!
        </div>
    @endif
</div>
@endsection
