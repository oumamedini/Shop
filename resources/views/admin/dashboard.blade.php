@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Admin Dashboard</h2>
            
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 bg-gradient-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Orders</h6>
                                    <h2 class="mb-0">{{ $totalOrders ?? 0 }}</h2>
                                </div>
                                <div class="icon-shape rounded-circle bg-opacity-25 bg-white text-white">
                                    <i class="fas fa-shopping-cart fa-2x"></i>
                                </div>
                            </div>
                            <a href="{{ route('admin.orders.index') }}" class="text-white text-decoration-none small">
                                View Details <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Revenue</h6>
                                    <h2 class="mb-0">${{ number_format($totalRevenue ?? 0, 2) }}</h2>
                                </div>
                                <div class="icon-shape rounded-circle bg-opacity-25 bg-white text-white">
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                            <div class="text-white small">
                                <i class="fas fa-chart-line me-1"></i>
                                Total Revenue
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Products</h6>
                                    <h2 class="mb-0">{{ $totalProducts ?? 0 }}</h2>
                                </div>
                                <div class="icon-shape rounded-circle bg-opacity-25 bg-white text-white">
                                    <i class="fas fa-box fa-2x"></i>
                                </div>
                            </div>
                            <a href="{{ route('admin.products.index') }}" class="text-white text-decoration-none small">
                                Manage Products <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Categories</h6>
                                    <h2 class="mb-0">{{ $totalCategories ?? 0 }}</h2>
                                </div>
                                <div class="icon-shape rounded-circle bg-opacity-25 bg-white text-white">
                                    <i class="fas fa-tags fa-2x"></i>
                                </div>
                            </div>
                            <a href="{{ route('admin.categories.index') }}" class="text-white text-decoration-none small">
                                Manage Categories <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders & Top Products -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card border-0">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">Recent Orders</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentOrders ?? [] as $order)
                                        <tr>
                                            <td>#{{ $order['id'] }}</td>
                                            <td>{{ $order['customer_name'] }}</td>
                                            <td>${{ number_format($order['total'], 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order['status_color'] }}">
                                                    {{ $order['status'] }}
                                                </span>
                                            </td>
                                            <td>{{ $order['created_at']->format('M d, Y') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">No recent orders</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">Top Products</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($topProducts ?? [] as $product)
                                <div class="list-group-item border-0 py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $product['name'] }}</h6>
                                            <small class="text-muted">
                                                {{ $product['orders_count'] }} orders
                                            </small>
                                        </div>
                                        <span class="badge bg-success">
                                            ${{ number_format($product['revenue'], 2) }}
                                        </span>
                                    </div>
                                </div>
                                @empty
                                <div class="list-group-item border-0 py-4 text-center">
                                    No products found
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-opacity-25 {
        --bs-bg-opacity: 0.25;
    }
</style>
@endpush
@endsection
