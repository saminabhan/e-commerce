{{-- resources/views/admin/order-tracking/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Order Tracking')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('admin.order-tracking.create') }}" class="btn btn-primary">Add New Tracking</a>
        </div>

        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order Tracking</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Order Tracking</div></li>
            </ul>
        </div>

        <div class="wg-box p-3">
            <div class="table-responsive">
                @if($trackings->count())
                    <table class="table table-striped table-bordered mb-0" style="background: white;">
                        <thead class="bg-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Status</th>
                                <th>Note</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
@foreach($trackings as $track)
<tr>
    <td>
        {{-- رابط لصفحة تفاصيل الطلب (إذا موجودة عندك route 'admin.orders.show') --}}
        @if($track->order)
            <a href="{{ route('admin.orders.show', $track->order->id) }}">
                #{{ $track->order->id }}
            </a><br>
            {{ $track->order->name ?? 'Customer' }}<br>
            <small class="text-muted">{{ optional($track->order->created_at)->format('Y-m-d') }}</small>
        @else
            N/A
        @endif
    </td>
    <td>{{ ucfirst($track->status) }}</td>
    <td>{{ $track->note ?? '-' }}</td>
    <td>{{ $track->tracked_at->format('Y-m-d H:i') }}</td>
</tr>
@endforeach
</tbody>

                    </table>
                @else
                    <p class="text-center py-4">No tracking records found.</p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
