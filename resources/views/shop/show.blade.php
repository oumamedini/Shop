@extends('layouts.shop')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p class="text-muted">Category: {{ $product->category->name }}</p>
            <h2 class="text-primary">${{ number_format($product->price, 2) }}</h2>
            <div class="my-4">
                <h4>Description</h4>
                <p>{{ $product->description }}</p>
            </div>
            <form action="{{ route('shop.cart.add', $product) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-lg btn-success">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
