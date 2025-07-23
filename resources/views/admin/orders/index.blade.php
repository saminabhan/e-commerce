@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">

        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Orders</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Orders</div></li>
            </ul>
        </div>

        <div class="wg-box p-3"> {{-- أضفت padding هنا لجعل المسافة متناسقة --}}
            <div class="table-responsive"> {{-- لتمرير أفقي عند الحاجة --}}
                @if($orders->count())
                    <table class="table table-striped table-bordered mb-0" style="background: white;">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Order Number</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Order Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? '—' }}</td>
                                <td>{{ $order->user_order_number ?? '—' }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                @else
                    <p class="text-center py-4">No orders found.</p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
