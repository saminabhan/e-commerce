@extends('layouts.app')

@section('content')
<style>
    .btn-custom-outline {
        color: #4062B1;
        border: 1px solid #4062B1;
        background-color: transparent;
        transition: all 0.3s ease;
    }

    .btn-custom-outline:hover {
        background-color: #4062B1;
        color: #fff;
        border-color: #4062B1;
    }
</style>
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Order Details</h2>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
            </div>

            <div class="col-lg-10">
                <div class="order-details-wrapper">
                    
                    <!-- Order Information -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Order #{{ $order->user_invoice_number }}</h5>
                            <div class="order-actions">
                                @if(in_array($order->status, ['pending', 'unpaid']))
                                    <form method="POST" action="{{ route('order.cancel', $order->id) }}" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-sm btn-custom-outline">
                                            <i class="fa fa-times"></i> Cancel Order
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Order Status:</strong><br>
                                    @php
                                        $color = match($order->status) {
                                            'paid', 'delivered' => 'success',
                                            'canceled' => 'danger',
                                            'pending' => 'warning',
                                            'shipped' => 'info',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ ucfirst($order->status) }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Order Date:</strong><br>
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Payment Method:</strong><br>
                                    {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Total Amount:</strong><br>
                                    <span class="h5 text-primary">${{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Shipping Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Name:</strong> {{ $order->name }}<br>
                                    <strong>Phone:</strong> {{ $order->phone }}<br>
                                    <strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Address:</strong><br>
                                    {{ $order->address }}<br>
                                    {{ $order->locality }}<br>
                                    {{ $order->city }}, {{ $order->state }} {{ $order->zip }}<br>
                                    @if($order->landmark)
                                        <strong>Landmark:</strong> {{ $order->landmark }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Order Items</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('uploads/products/' . $item->product->image) }}" 
                                                             alt="{{ $item->product_name }}" 
                                                             class="me-3" 
                                                             style="width: 60px; height: 60px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <strong>{{ $item->product_name }}</strong>
                                                        @if($item->product)
                                                            <br><small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-center">${{ number_format($item->price, 2) }}</td>
                                            <td class="text-center"><strong>${{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 offset-md-6">
                                    <table class="table">
                                        <tr>
                                            <td><strong>Subtotal:</strong></td>
                                            <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Shipping:</strong></td>
                                            <td class="text-end">Free</td>
                                        </tr>
                                        <tr>
                                            <td><strong>VAT (15%):</strong></td>
                                            <td class="text-end">${{ number_format($order->vat, 2) }}</td>
                                        </tr>
                                        <tr class="border-top">
                                            <td><strong>Total:</strong></td>
                                            <td class="text-end"><strong class="h5 text-primary">${{ number_format($order->total, 2) }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back to Orders Button -->
                    <div class="mt-4">
                        <a href="{{ route('user.orders') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Orders
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

<style>
.order-details-wrapper .card {
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.order-details-wrapper .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.order-actions .btn {
    margin-left: 10px;
}

.table td, .table th {
    vertical-align: middle;
}

.badge {
    padding: 0.5em 0.75em;
    font-size: 0.875em;
}

.order-details-wrapper img {
    border-radius: 4px;
    border: 1px solid #dee2e6;
}
</style>
@endsection

