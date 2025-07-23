<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTracking;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index() {
        $trackings = OrderTracking::with('order')->latest()->paginate(20);
        return view('admin.order-tracking.index', compact('trackings'));
    }

    public function create() {
        $orders = Order::all();
        return view('admin.order-tracking.create', compact('orders'));
    }

    public function store(Request $request) {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required',
            'note' => 'nullable|string',
        ]);
        OrderTracking::create($request->all());
        return redirect()->route('admin.order-tracking.index')->with('success', 'Tracking added.');
    }
}
