@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0 text-gray-800">Orders Management</h2>
                <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> New Order
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Product</th>
                                    <th class="px-4 py-3">Customer</th>
                                    <th class="px-4 py-3">Amount</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Payment</th>
                                    <th class="px-4 py-3">Shipping</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="px-4 py-3">#{{ $order->id }}</td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                @if($order->product->image)
                                                    <img src="{{ Storage::url($order->product->image) }}" 
                                                         alt="{{ $order->product->name }}" 
                                                         class="rounded me-3" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $order->product->name }}</div>
                                                    <div class="small text-secondary">Qty: {{ $order->quantity }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $order->client_name }}</span>
                                                <span class="small text-secondary">{{ $order->client_phone }}</span>
                                                <span class="small text-secondary text-truncate" style="max-width: 200px;">
                                                    {{ $order->client_address }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-semibold">${{ number_format($order->total_price, 2) }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="dropdown">
                                                <button class="badge badge-{{ $order->status === 'delivered' ? 'success' : 
                                                    ($order->status === 'cancelled' ? 'danger' : 
                                                    ($order->status === 'processing' ? 'info' : 
                                                    ($order->status === 'shipped' ? 'primary' : 'warning')))
                                                }} dropdown-toggle border-0" 
                                                        type="button" 
                                                        data-bs-toggle="dropdown">
                                                    <i class="fas fa-{{ 
                                                        $order->status === 'delivered' ? 'check' : 
                                                        ($order->status === 'cancelled' ? 'times' : 
                                                        ($order->status === 'processing' ? 'cog' : 
                                                        ($order->status === 'shipped' ? 'shipping-fast' : 'clock')))
                                                    }} me-1"></i>
                                                    {{ ucfirst($order->status) }}
                                                </button>
                                                <ul class="dropdown-menu shadow-sm">
                                                    @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                                        <li>
                                                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="{{ $status }}">
                                                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                                                    <i class="fas fa-{{ 
                                                                        $status === 'delivered' ? 'check' : 
                                                                        ($status === 'cancelled' ? 'times' : 
                                                                        ($status === 'processing' ? 'cog' : 
                                                                        ($status === 'shipped' ? 'shipping-fast' : 'clock')))
                                                                    }} me-2 text-{{ 
                                                                        $status === 'delivered' ? 'success' : 
                                                                        ($status === 'cancelled' ? 'danger' : 
                                                                        ($status === 'processing' ? 'info' : 
                                                                        ($status === 'shipped' ? 'primary' : 'warning')))
                                                                    }}"></i>
                                                                    {{ ucfirst($status) }}
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="dropdown">
                                                <button class="badge badge-{{ 
                                                    $order->payment_status === 'paid' ? 'success' : 
                                                    ($order->payment_status === 'failed' ? 'danger' : 
                                                    ($order->payment_status === 'refunded' ? 'info' : 'warning'))
                                                }} dropdown-toggle border-0" 
                                                        type="button" 
                                                        data-bs-toggle="dropdown">
                                                    <i class="fas fa-{{ 
                                                        $order->payment_status === 'paid' ? 'check' : 
                                                        ($order->payment_status === 'failed' ? 'times' : 
                                                        ($order->payment_status === 'refunded' ? 'undo' : 'clock'))
                                                    }} me-1"></i>
                                                    {{ ucfirst($order->payment_status) }}
                                                </button>
                                                <ul class="dropdown-menu shadow-sm">
                                                    @foreach(['pending', 'paid', 'failed', 'refunded'] as $status)
                                                        <li>
                                                            <form action="{{ route('orders.update-payment', $order) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="payment_status" value="{{ $status }}">
                                                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                                                    <i class="fas fa-{{ 
                                                                        $status === 'paid' ? 'check' : 
                                                                        ($status === 'failed' ? 'times' : 
                                                                        ($status === 'refunded' ? 'undo' : 'clock'))
                                                                    }} me-2 text-{{ 
                                                                        $status === 'paid' ? 'success' : 
                                                                        ($status === 'failed' ? 'danger' : 
                                                                        ($status === 'refunded' ? 'info' : 'warning'))
                                                                    }}"></i>
                                                                    {{ ucfirst($status) }}
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex flex-column">
                                                <span class="badge bg-secondary mb-1">
                                                    <i class="fas fa-truck me-1"></i>
                                                    {{ $order->shipping_method ?: 'Not set' }}
                                                </span>
                                                @if($order->tracking_number)
                                                    <span class="small text-secondary">
                                                        <i class="fas fa-barcode me-1"></i>
                                                        {{ $order->tracking_number }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.orders.edit', $order) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $order->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $order->id }}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">Delete Order</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center py-4">
                                                            <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                                            <h5>Are you sure?</h5>
                                                            <p class="text-secondary">Do you really want to delete order #{{ $order->id }}? This process cannot be undone.</p>
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
