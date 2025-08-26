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
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card p-4 h-100">
                        <h4 class="mb-3">Customer Information</h4>
                        <p><strong>Customer:</strong> {{ $order->user->name ?? '—' }}</p>
                        <p><strong>Phone:</strong> {{ $order->user->mobile ?? '—' }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                        <p><strong>Last Updated:</strong> {{ $order->updated_at->format('Y-m-d H:i') }}</p>
                        <p><strong>Payment Method:</strong> {{ $order->payment_method ?? '—' }}</p>
                        <p><strong>Transaction ID:</strong> {{ $order->transaction_id ?? '—' }}</p>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card p-4 h-100">
                        <h4 class="mb-3">Delivery Information</h4>
                        <p><strong>Name:</strong> {{ $order->name ?? '—' }}</p>
                        <p><strong>Phone:</strong> {{ $order->phone ?? '—' }}</p>
                        <p><strong>Address:</strong> {{ $order->address ?? '—' }}</p>
                        <p><strong>Locality:</strong> {{ $order->locality ?? '—' }}</p>
                        <p><strong>City:</strong> {{ $order->city ?? '—' }}</p>
                        <p><strong>State:</strong> {{ $order->state ?? '—' }}</p>
                        <p><strong>ZIP:</strong> {{ $order->zip ?? '—' }}</p>
                        <p><strong>Landmark:</strong> {{ $order->landmark ?? '—' }}</p>
                    </div>
                </div>

                <div class="col-lg-12 mb-4">
                    <div class="card p-4">
                        <h4 class="mb-3">Delivery Location</h4>
                        <div id="delivery-map" style="height: 400px; width: 100%;"></div>

                        @if($order->latitude && $order->longitude)
                        <div class="mt-4 text-center">
                            <a href="https://maps.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}"
                                target="_blank"
                                class="btn btn-primary">
                                <i class="icon-location-pin"></i> Get Directions
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card p-4">
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

                                @php
                                    $subtotal = $order->items->sum(function($item) {
                                        return $item->quantity * $item->price;
                                    });
                                    $discount = $order->discount ?? 0;
                                    $totalAfterDiscount = max($subtotal - $discount, 0);
                                    $vatRate = 0.15;
                                    $vatAmount = $totalAfterDiscount * $vatRate;
                                    $finalTotal = $totalAfterDiscount + $vatAmount;
                                @endphp

                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                                    <td>${{ number_format($subtotal, 2) }}</td>
                                </tr>

                                @if($discount > 0)
                                <tr>
                                    <td colspan="3" class="text-end text-danger"><strong>Discount</strong></td>
                                    <td class="text-danger">- ${{ number_format($discount, 2) }}</td>
                                </tr>
                                @endif

                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total After Discount</strong></td>
                                    <td>${{ number_format($totalAfterDiscount, 2) }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="text-end"><strong>VAT (15%)</strong></td>
                                    <td>${{ number_format($vatAmount, 2) }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="text-end"><strong>Final Total</strong></td>
                                    <td><strong>${{ number_format($finalTotal, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-4">Back to Orders</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lat = parseFloat('{{ $order->latitude ?? 0 }}');
        const lng = parseFloat('{{ $order->longitude ?? 0 }}');

        if (lat && lng) {
            const map = L.map('delivery-map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup('Delivery Location')
                .openPopup();
        } else {
            document.getElementById('delivery-map').innerHTML = '<p class="text-center mt-4">Location information not available.</p>';
        }
    });
</script>
@endpush