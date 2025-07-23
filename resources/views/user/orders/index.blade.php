@extends('layouts.app')
@section('title', 'My Orders | Sami Store')

@section('content')
<main class="pt-90">
  <div class="mb-4 pb-4"></div>
  <section class="my-account container">
    <h2 class="page-title"><span>My</span> Orders</h2>
    <div class="row">
      <div class="col-lg-3">
        @include('user.account-nav')
      </div>
      <div class="col-lg-9">
        <div class="page-content my-account__orders">

          @if($orders->count())
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Order No</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th>Items</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $order)
                  <tr>
                    <td>{{ $order->user_order_number }}</td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>{{ $order->items->sum('quantity') }}</td>
                    <td><a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-primary">View</a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <p>You have no orders yet.</p>
          @endif

        </div>
      </div>
    </div>
  </section>
</main>
@endsection
