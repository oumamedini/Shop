@extends('layouts.shop')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Checkout</h4>
                </div>
                <div class="card-body">
                    @guest
                        <div class="alert alert-info">
                            Please <a href="{{ route('login') }}">login</a> to continue with checkout.
                        </div>
                    @else
                        <form action="{{ route('shop.place-order') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="client_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                                       id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                                @error('client_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="client_address" class="form-label">Delivery Address</label>
                                <textarea class="form-control @error('client_address') is-invalid @enderror" 
                                          id="client_address" name="client_address" rows="3" required>{{ old('client_address') }}</textarea>
                                @error('client_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="client_phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('client_phone') is-invalid @enderror" 
                                       id="client_phone" name="client_phone" value="{{ old('client_phone') }}" required>
                                @error('client_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Place Order</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Order Summary</h4>
                </div>
                <div class="card-body">
                    @php $total = 0 @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0">{{ $details['name'] }}</h6>
                                    <small class="text-muted">Qty: {{ $details['quantity'] }}</small>
                                </div>
                                <span>${{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    @endif

                    <hr>

                    <div class="d-flex justify-content-between">
                        <h5>Total:</h5>
                        <h5>${{ number_format($total, 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
