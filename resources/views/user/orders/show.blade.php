@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order #{{ $order->id }} Details</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <div class="text-tiny">Order Details</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="body-title pb-2">Customer</div>
                    <div class="text-muted">{{ $order->user->name ?? 'N/A' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="body-title pb-2">Phone</div>
                    <div class="text-muted">{{ $order->phone ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="body-title pb-2">Status</div>
                    <div class="text-muted">{{ ucfirst($order->status) }}</div>
                </div>
                <div class="col-md-6">
                    <div class="body-title pb-2">Order Date</div>
                    <div class="text-muted">{{ $order->created_at->format('Y-m-d H:i') }}</div>
                </div>
            </div>

            <div class="divider my-4"></div>

            <div class="row text-center mb-4">
                <div class="col-md-4">
                    <div class="body-title pb-1 text-secondary">Subtotal</div>
                    <div class="fs-5">${{ number_format($order->subtotal, 2) }}</div>
                </div>
                <div class="col-md-4">
                    <div class="body-title pb-1 text-secondary">Tax</div>
                    <div class="fs-5">${{ number_format($order->tax, 2) }}</div>
                </div>
                <div class="col-md-4">
                    <div class="body-title pb-1 text-primary fw-bold">Total</div>
                    <div class="fs-5 fw-semibold">${{ number_format($order->total, 2) }}</div>
                </div>
            </div>
        </div>

        @if($order->items && $order->items->count())
            <div class="wg-box mt-4">
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
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('admin.index') }}" class="btn btn-outline-primary tf-button w208">Back to Orders</a>
        </div>
    </div>
</div>
@endsection
