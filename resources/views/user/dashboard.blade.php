@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">My Dashboard</h2>

            <div class="card">
                <div class="card-header">My Recent Orders</div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('shop.orders') }}" class="btn btn-sm btn-primary">View Details</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>You haven't placed any orders yet.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">Start Shopping</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
