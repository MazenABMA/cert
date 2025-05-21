@extends('layouts.master')
@section('title', 'Test Page')
@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="row mt-2">
    <div class="col col-10">
        <h1>Products</h1>
    </div>
    <div class="col col-2">
        @can('add_products')
        <a href="{{route('products_edit')}}" class="btn btn-success form-control">Add Product</a>
        @endcan
    </div>
</div>
<form>
    <div class="row">
        <div class="col col-sm-2">
            <input name="keywords" type="text"  class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
        </div>
        <div class="col col-sm-2">
            <input name="min_price" type="numeric"  class="form-control" placeholder="Min Price" value="{{ request()->min_price }}"/>
        </div>
        <div class="col col-sm-2">
            <input name="max_price" type="numeric"  class="form-control" placeholder="Max Price" value="{{ request()->max_price }}"/>
        </div>
        <div class="col col-sm-2">
            <select name="order_by" class="form-select">
                <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Order By</option>
                <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
            </select>
        </div>
        <div class="col col-sm-2">
            <select name="order_direction" class="form-select">
                <option value="" {{ request()->order_direction==""?"selected":"" }} disabled>Order Direction</option>
                <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>ASC</option>
                <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>DESC</option>
            </select>
        </div>
        <div class="col col-sm-1">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div class="col col-sm-1">
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </div>
</form>

<!-- @if(!empty(request()->keywords))
<div class="card mt-2">
 <div class="card-body">
 View search result of keywords: <span>{!!request()->keywords!!}</span>
 </div>
</div>
@endif -->


@foreach($products as $product)
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col col-sm-12 col-lg-4">
                    <img src="{{asset("images/$product->photo")}}" class="img-thumbnail" alt="{{$product->name}}" width="100%">
                </div>
                <div class="col col-sm-12 col-lg-8 mt-3">
                    <div class="row mb-2">
					    <div class="col-8">
					        <h3>{{$product->name}}</h3>
					    </div>
					    <div class="col col-2">
                            @can('edit_products')
					        <a href="{{route('products_edit', $product->id)}}" class="btn btn-success form-control">Edit</a>
                            @endcan
					    </div>
					    <div class="col col-2">
                            @can('delete_products')
					        <a href="{{route('products_delete', $product->id)}}" class="btn btn-danger form-control">Delete</a>
                            @endcan
					    </div>
                        <div class="col col-2">
                            @auth
                                @if(auth()->user()->hasRole('Customer'))
                                    <form action="{{ route('buy_product', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Buy</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
					</div>
                    <table class="table table-striped">
                        <tr><th width="20%">Name</th><td>{{$product->name}}</td></tr>
                        <tr><th>Model</th><td>{{$product->model}}</td></tr>
                        <tr><th>Code</th><td>{{$product->code}}</td></tr>
                        <tr><th>Price</th><td>{{$product->price}}</td>
                        <tr><th>Available Stock</th><td>{{ $product->stock }}</td></tr>
                        <tr><th>Reviews</th>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <a href="{{ route('reviews.index', $product->id) }}" class="text-decoration-none">
                                            {{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }}
                                        </a>
                                        @if($product->reviews_count > 0)
                                            <span class="ms-2">
                                                <strong>{{ number_format($product->average_rating, 1) }}/5</strong>
                                            </span>
                                        @endif
                                    </div>
                                    @can('add_review')
                                    <a href="{{ route('reviews.create', $product->id) }}" class="btn btn-sm btn-outline-primary">Add Review</a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        <tr><th>Description</th><td>{{$product->description}}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection