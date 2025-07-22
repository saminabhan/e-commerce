@extends('layouts.app')

@section('content')
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Orders</h2>
        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
            </div>

            <div class="col-lg-10">
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>OrderNo</th>
                                    <th>Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Tax</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-center">Delivered On</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->user_invoice_number }}</td>
                                    <td class="text-center">{{ $order->name }}</td>
                                    <td class="text-center">{{ $order->phone }}</td>
                                    <td class="text-center">${{ number_format($order->subtotal, 2) }}</td>
                                    <td class="text-center">${{ number_format($order->vat, 2) }}</td>
                                    <td class="text-center">${{ number_format($order->total, 2) }}</td>
                                    <td class="text-center">
                                        @php
                                            $color = match($order->status) {
                                                'paid', 'delivered' => '#4062B1',
                                                'canceled' => '#dc3545',
                                                'pending' => '#ffc107',
                                                default => '#6c757d',
                                            };
                                        @endphp

                                        <span class="badge text-white" style="background-color: {{ $color }};">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="text-center">{{ $order->items_count }}</td>
                                    <td class="text-center">{{ $order->delivered_on ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('user.order.details', $order->id) }}">
                                            <div class="list-icon-function view-icon">
                                                <div class="item eye">
                                                    <i class="fa fa-eye"></i>
                                                </div>                                        
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center">No orders found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>                
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
