@extends('layouts.shop')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Categories</div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('shop.index') }}" 
                       class="list-group-item list-group-item-action {{ !isset($category) ? 'active' : '' }}">
                        All Products
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('shop.category', $cat) }}" 
                           class="list-group-item list-group-item-action {{ isset($category) && $category->id == $cat->id ? 'active' : '' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($products as $product)
                    <div class="col">
                        <div class="card h-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p class="card-text"><strong>${{ number_format($product->price, 2) }}</strong></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('shop.product.show', $product) }}" class="btn btn-primary">View Details</a>
                                    <form action="{{ route('shop.cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
