<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
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
            // Optional: update quantity if already exists
            $existing->quantity += $request->quantity ?? 1;
            $existing->save();
            $item = $existing;
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
}
