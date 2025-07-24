{{-- resources/views/admin/order-tracking/create.blade.php --}}
@extends('layouts.admin')
@section('title', 'Add Order Tracking')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">

        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Order Tracking</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.order-tracking.index') }}">
                        <div class="text-tiny">Order Tracking</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Add New</div></li>
            </ul>
        </div>

        <div class="wg-box p-3">
            {{-- Show Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.order-tracking.store') }}" method="POST" class="form-style-1 needs-validation" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="order_id" class="form-label">Order <span class="text-danger">*</span></label>
                    <select name="order_id" id="order_id" class="form-control" required>
                        <option value="" disabled selected>Select an order</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                #{{ $order->id }} - {{ $order->name ?? 'Customer' }} - {{ $order->created_at->format('Y-m-d') }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="" disabled selected>Select status</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" id="note" rows="3" class="form-control">{{ old('note') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="tracked_at" class="form-label">Tracking Date <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="tracked_at" id="tracked_at" class="form-control" value="{{ old('tracked_at') ?? date('Y-m-d\TH:i') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Add Tracking</button>
                <a href="{{ route('admin.order-tracking.index') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>

    </div>
</div>
@endsection
