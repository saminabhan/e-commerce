<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // صفحة عرض كل الطلبات مع الباجينيشن
    public function index()
    {
        $orders = Order::latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    // صفحة عرض تفاصيل طلب واحد
    public function show(Order $order)
    {
        $order->load('items.product', 'user'); // نحمّل بيانات العناصر والعميل
        return view('admin.orders.show', compact('order'));
    }
}
