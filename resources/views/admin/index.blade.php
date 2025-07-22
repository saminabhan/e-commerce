@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
<div class="main-content-inner">

<div class="main-content-wrap">
    <div class="tf-section-2 mb-30">
        <div class="flex gap20 flex-wrap-mobile">
            <div class="w-half">
                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Total Orders</div>
                                <h4>{{ $totalOrders }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Total Amount</div>
                                <h4>{{ number_format($totalAmount, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Pending Orders</div>
                                <h4>{{ $pendingOrders }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wg-chart-default">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Pending Orders Amount</div>
                                <h4>{{ number_format($pendingAmount, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="w-half">
                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Delivered Orders</div>
                                <h4>{{ $deliveredOrders }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Delivered Orders Amount</div>
                                <h4>{{ number_format($deliveredAmount, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wg-chart-default mb-20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Canceled Orders</div>
                                <h4>{{ $canceledOrders }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wg-chart-default">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap14">
                            <div class="image ic-bg">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <div>
                                <div class="body-text mb-2">Canceled Orders Amount</div>
                                <h4>{{ number_format($canceledAmount, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between">
                <h5>Earnings revenue</h5>
            </div>
            <div class="flex flex-wrap gap40">
                <div>
                    <div class="mb-2">
                        <div class="block-legend">
                            <div class="dot t1"></div>
                            <div class="text-tiny">Revenue</div>
                        </div>
                    </div>
                    <div class="flex items-center gap10">
                        <h4>${{ number_format($totalAmount, 2) }}</h4>
                    </div>
                </div>
                <div>
                    <div class="mb-2">
                        <div class="block-legend">
                            <div class="dot t2"></div>
                            <div class="text-tiny">Orders</div>
                        </div>
                    </div>
                    <div class="flex items-center gap10">
                        <h4>{{ $totalOrders }}</h4>
                    </div>
                </div>
                
            </div>
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>

    </div>
    <div class="tf-section mb-30">

        <div class="wg-box">
            <div class="flex items-center justify-between">
                <h5>Recent orders</h5>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 80px">OrderNo</th>
                                <th>Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Tax</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Total Items</th>
                                <th class="text-center">Delivered On</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td class="text-center">{{ $order->user_order_number }}</td>
                                <td class="text-center">{{ $order->name }}</td>
                                <td class="text-center">{{ $order->phone }}</td>
                                <td class="text-center">${{ number_format($order->subtotal, 2) }}</td>
                                <td class="text-center">${{ number_format($order->vat, 2) }}</td>
                                <td class="text-center">${{ number_format($order->total, 2) }}</td>
                                <td class="text-center">{{ ucfirst($order->status) }}</td>
                                <td class="text-center">{{ $order->created_at }}</td>
                                <td class="text-center">{{ $order->items->sum('quantity') }}</td>
                                <td class="text-center">{{ $order->delivered_at ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

</div>
@endsection
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'], // عدل حسب بياناتك
            datasets: [{
                label: 'Revenue',
                data: [1200, 1900, 3000, 2500, 3200], // حط بيانات ديناميكية هنا
                borderColor: '#4062B1',
                fill: false,
            }]
        },
        options: {}
    });
</script>

@endpush