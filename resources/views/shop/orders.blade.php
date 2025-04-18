@extends('layouts.shop')

@section('content')
<div class="container">
    <h1>My Orders</h1>
    @if($orders->count() > 0)
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Order #{{ $order->id }}</span>
                            <span class="badge bg-{{ $order->is_delivered ? 'success' : 'warning' }}">
                                {{ $order->is_delivered ? 'Delivered' : 'Pending' }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Order Details</h5>
                                    <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                                    <p><strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}</p>
                                    <p><strong>Delivery Status:</strong> {{ $order->is_delivered ? 'Delivered' : 'Pending' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5>Shipping Information</h5>
                                    <p><strong>Name:</strong> {{ $order->client_name }}</p>
                                    <p><strong>Address:</strong> {{ $order->client_address }}</p>
                                    <p><strong>Phone:</strong> {{ $order->client_phone }}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5>Product Details</h5>
                                    <p><strong>Product:</strong> {{ $order->product->name }}</p>
                                    <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                                    <p><strong>Price per unit:</strong> ${{ number_format($order->total_price / $order->quantity, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            You haven't placed any orders yet. <a href="{{ route('shop.index') }}">Start shopping</a>
        </div>
    @endif
</div>
@endsection
