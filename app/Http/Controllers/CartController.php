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
        $userId = auth()->id();
        $items = Cart::where('user_id', $userId)->get();

        foreach ($items as $item) {
            $product = $item->product;
            if (!$product) {
                $item->delete();
                continue;
            }

            $currentPrice = $product->sale_price ?? $product->regular_price;
            if ($item->price != $currentPrice) {
                $item->price = $currentPrice;
                $item->save();
            }
        }

        $items = Cart::where('user_id', $userId)->get();

        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $quantity = $request->quantity ?? 1;
        $price = $product->sale_price ?? $product->regular_price;

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            // Update price in case it changed since last add
            $cartItem->price = $price;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id'      => auth()->id(),
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'quantity'     => $quantity,
                'price'        => $price,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function increase_cart_quantity($id)
    {
        $cartItem = Cart::where('user_id', auth()->id())->findOrFail($id);
        $product = $cartItem->product;

        if ($product) {
            $currentPrice = $product->sale_price ?? $product->regular_price;
            $cartItem->price = $currentPrice;
        }

        $cartItem->quantity += 1;
        $cartItem->save();

        return redirect()->back();
    }

    public function decrease_cart_quantity($id)
    {
        $cartItem = Cart::where('user_id', auth()->id())->findOrFail($id);

        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->save();
        } else {
            $cartItem->delete();
        }

        return redirect()->back();
    }

    public function remove_item($id)
    {
        Cart::where('user_id', auth()->id())->findOrFail($id)->delete();
        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::where('user_id', auth()->id())->delete();
        return redirect()->back();
    }
}
