@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Categories</h5>
                                    <p class="card-text display-4">{{ $categoriesCount }}</p>
                                    <a href="{{ route('categories.index') }}" class="btn btn-light">Manage Categories</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Products</h5>
                                    <p class="card-text display-4">{{ $productsCount }}</p>
                                    <a href="{{ route('products.index') }}" class="btn btn-light">Manage Products</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Orders</h5>
                                    <p class="card-text display-4">{{ $ordersCount }}</p>
                                    <a href="{{ route('orders.index') }}" class="btn btn-light">View Orders</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart"></i> Go to Shop
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
