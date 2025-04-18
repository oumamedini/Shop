@extends('layouts.shop')

@section('content')
<div class="container">
    <h1>Shopping Cart</h1>
    @if(session('cart'))
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0 @endphp
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($details['image'])
                                        <img src="{{ asset('storage/' . $details['image']) }}" 
                                             alt="{{ $details['name'] }}" 
                                             class="img-thumbnail me-3" 
                                             style="width: 100px">
                                    @endif
                                    <span>{{ $details['name'] }}</span>
                                </div>
                            </td>
                            <td>${{ number_format($details['price'], 2) }}</td>
                            <td>
                                <form action="{{ route('shop.cart.update', $id) }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" 
                                           class="form-control form-control-sm" style="width: 70px" min="1">
                                    <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                                </form>
                            </td>
                            <td>${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                            <td>
                                <form action="{{ route('shop.cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td><strong>${{ number_format($total, 2) }}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('shop.checkout') }}" class="btn btn-success">
                Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    @else
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('shop.index') }}">Continue shopping</a>
        </div>
    @endif
</div>
@endsection
