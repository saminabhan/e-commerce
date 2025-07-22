@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="main-content-inner" dir="ltr">
    <div class="container-fluid p-4">

        <h2 class="mb-4">Order #{{ $order->id }} Details</h2>

        <div class="wg-box p-4 shadow-sm rounded-3 bg-white">

            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Customer:</strong>
                    <p class="text-muted">{{ $order->user->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Phone:</strong>
                    <p class="text-muted">{{ $order->phone ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Status:</strong>
                    <p class="text-muted">{{ ucfirst($order->status) }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Order Date:</strong>
                    <p class="text-muted">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>

            <hr>

            <div class="row text-center mb-4">
                <div class="col-md-4">
                    <div class="fw-semibold text-secondary">Subtotal</div>
                    <div class="fs-5">${{ number_format($order->subtotal, 2) }}</div>
                </div>
                <div class="col-md-4">
                    <div class="fw-semibold text-secondary">Tax</div>
                    <div class="fs-5">${{ number_format($order->tax, 2) }}</div>
                </div>
                <div class="col-md-4">
                    <div class="fw-bold text-primary">Total</div>
                    <div class="fs-5">${{ number_format($order->total, 2) }}</div>
                </div>
            </div>

            @if($order->items && $order->items->count())
                <h5 class="mb-3">Items</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name ?? '—' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <a href="{{ route('admin.index') }}" class="btn btn-outline-primary mt-4">Back to Orders</a>
        </div>

    </div>
</div>
@endsection
