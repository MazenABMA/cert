@extends('layouts.master')
@section('title', 'Add Review')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Review for {{ $product->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select name="rating" id="rating" class="form-select @error('rating') is-invalid @enderror" required>
                                <option value="">Select Rating</option>
                                <option value="5">5 - Excellent</option>
                                <option value="4">4 - Very Good</option>
                                <option value="3">3 - Good</option>
                                <option value="2">2 - Fair</option>
                                <option value="1">1 - Poor</option>
                            </select>
                            @error('rating')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="comment" class="form-label">Your Review</label>
                            <textarea name="comment" id="comment" rows="5" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products_list') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
