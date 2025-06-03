<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Wishlist::where('user_id', Auth::id())->get();
        return view('wishlist', compact('items'));
    }

    public function add_to_wishlist(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if (!$existing) {
            Wishlist::create([
                'user_id'      => Auth::id(),
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'quantity'     => $request->quantity ?? 1,
                'price'        => $product->sale_price ?? $product->regular_price,
            ]);
        }

        return redirect()->back();
    }

    public function remove_item($id)
    {
        Wishlist::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->back();
    }

    public function empty_wishlist()
    {
        Wishlist::where('user_id', Auth::id())->delete();
        return redirect()->back();
    }
}
