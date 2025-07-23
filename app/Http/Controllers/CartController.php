<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTracking;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::where('user_id', Auth::id())->get();
        return view('cart', compact('items'));
    }

public function add_to_cart(Request $request)
{
    $product = Product::findOrFail($request->id);

    $existing = Cart::where('user_id', Auth::id())
        ->where('product_id', $product->id)
        ->first();

    if (!$existing) {
        $item = Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $request->quantity ?? 1,
            'price' => $product->sale_price ?? $product->regular_price,
        ]);
    } else {
        return response()->json([
            'status' => 'exists',
            'message' => 'Product already in cart',
            'id' => $existing->id,
            'cartCount' => Cart::where('user_id', Auth::id())->count()
        ]);
    }

    return response()->json([
        'status' => 'added',
        'id' => $item->id,
        'cartCount' => Cart::where('user_id', Auth::id())->count()
    ]);
}
    public function remove_item($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();

        return response()->json([
            'status' => 'removed',
            'cartCount' => Cart::where('user_id', Auth::id())->count()
        ]);
    }

    public function empty_cart()
    {
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->back();
    }

    public function increase_quantity($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->quantity += 1;
        $cartItem->save();

        return redirect()->back();
    }

    public function decrease_quantity($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);

        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->save();
        } else {
            $cartItem->delete();
        }

        return redirect()->back();
    }

public function checkout()
{
    $items = Cart::where('user_id', Auth::id())->get();

    if ($items->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Cart is empty.');
    }

    $subTotal = $items->sum(function ($item) {
        return $item->price * $item->quantity;
    });

    $vat = $subTotal * 0.15;
    $total = $subTotal + $vat;

    return view('checkout', compact('items', 'subTotal', 'vat', 'total'));
}

public function placeOrder(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'phone' => 'required|string',
        'zip' => 'required|string',
        'state' => 'required|string',
        'city' => 'required|string',
        'address' => 'required|string',
        'locality' => 'required|string',
        'landmark' => 'required|string',
    ]);

    $items = Cart::where('user_id', Auth::id())->get();

    if ($items->isEmpty()) {
        return back()->with('error', 'Cart is empty.');
    }

    $subTotal = $items->sum(fn($item) => $item->price * $item->quantity);
    $vat = $subTotal * 0.15;
    $total = $subTotal + $vat;

    $order = Order::create([
        'user_id' => Auth::id(),
        'name' => $request->name,
        'phone' => $request->phone,
        'zip' => $request->zip,
        'state' => $request->state,
        'city' => $request->city,
        'address' => $request->address,
        'locality' => $request->locality,
        'landmark' => $request->landmark,
        'subtotal' => $subTotal,
        'vat' => $vat,
        'total' => $total,
        'status' => 'pending',
    ]);

    foreach ($items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'product_name' => $item->product_name,
            'quantity' => $item->quantity,
            'price' => $item->price,
        ]);
    }

    Cart::where('user_id', Auth::id())->delete();

    return redirect()->route('payment.test', $order->id);
}

}
