@extends('layouts.master')
@section('title', 'Supermarket Bill')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h2>Supermarket Bill</h2>
        </div>
        <div class="card-body">
            <p><strong>Customer Name:</strong> {{ $customer_name }}</p>
            <p><strong>Order Date:</strong> {{ $order_date }}</p>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['name'] }}</td>
                        
                            <td>{{ $item['quantity'] }}</td>
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>${{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <h4 class="text-right"> Total: ${{ number_format($total_amount, 2) }}</h4>
        </div>
        
    </div>
</div>
@endsection
