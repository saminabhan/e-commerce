@extends('layouts.admin')
@section('title', 'Order Details')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">

        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order #{{ $order->user_order_number }}</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.orders.index') }}">
                        <div class="text-tiny">Orders</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Order Details</div></li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="col-lg-12 p-3">

                <div class="mb-5">
                    <p><strong>Customer:</strong> {{ $order->user->name ?? '—' }}</p>
                    <p><strong>Phone:</strong> {{ $order->user->phone ?? '—' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                </div>

                <h4 class="mb-3">Items</h4>
                <table class="table table-bordered mb-0">
                    <thead class="bg-light">
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
                            <td>{{ $item->product->name ?? '—' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-4">Back to Orders</a>
            </div>
        </div>

    </div>
</div>
@endsection
        