@extends('layouts.master')
@section('title', 'Insufficient Credit')
@section('content')

<div class="container mt-4">
    <div class="alert alert-warning">
        <h4>Insufficient Credit</h4>
        <p>Hello <strong>{{ $user->name }}</strong>,</p>
        <p>You tried to purchase <strong>{{ $product->name }}</strong> which costs <strong>${{ $product->price }}</strong>.</p>
        <p>Your current credit is <strong>${{ $user->credit }}</strong>, which is not enough to complete this purchase.</p>
        <a href="{{ route('products_list') }}" class="btn btn-primary mt-3">Back to Products</a>
    </div>
</div>

@endsection