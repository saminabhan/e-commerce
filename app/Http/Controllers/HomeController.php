<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   
    public function index(){
        $saleProducts = Product::whereNotNull('sale_price')->inRandomOrder()->limit(8)->get();
        $products = Product::inRandomOrder()->limit(16)->get();
        $newestProducts = Product::orderBy('created_at', 'desc')->limit(8)->get();
    
        return view('index', [
            'saleProducts' => $saleProducts,
            'products' => $products,
            'newestProducts' => $newestProducts,
        ]);
    }
    
public function about(){    
        return view('about.index');
    }
public function search(Request $request)
{
    $keyword = $request->input('search-keyword');
    
    if (empty($keyword)) {
        return redirect()->route('shop.index')->with('error', 'Please enter a search keyword');
    }

    // بحث شامل بدون حد أقصى للنتائج
    $products = \App\Models\Product::with(['category', 'brand'])
        ->where(function($query) use ($keyword) {
            $query->where('name', 'like', "%$keyword%")
                  ->orWhere('description', 'like', "%$keyword%")
                  ->orWhere('short_description', 'like', "%$keyword%")
                  ->orWhereHas('category', function($q) use ($keyword) {
                      $q->where('name', 'like', "%$keyword%");
                  })
                  ->orWhereHas('brand', function($q) use ($keyword) {
                      $q->where('name', 'like', "%$keyword%");
                  });
        })
        ->where('stock_status', 'instock') // فقط المنتجات المتوفرة
        ->orderBy('name', 'asc')
        ->get(); // إزالة limit لعرض كل النتائج

    // للصفحة العادية
    return view('shop.search', compact('products', 'keyword'));
}

// البحث المباشر المحسن
public function liveSearch(Request $request)
{
    $keyword = $request->input('q');
    
    if (empty($keyword) || strlen($keyword) < 2) {
        return response()->json([
            'products' => [],
            'total' => 0
        ]);
    }

    $products = \App\Models\Product::with(['category', 'brand'])
        ->where(function($query) use ($keyword) {
            $query->where('name', 'like', "%$keyword%")
                  ->orWhere('description', 'like', "%$keyword%")
                  ->orWhere('short_description', 'like', "%$keyword%")
                  ->orWhereHas('category', function($q) use ($keyword) {
                      $q->where('name', 'like', "%$keyword%");
                  })
                  ->orWhereHas('brand', function($q) use ($keyword) {
                      $q->where('name', 'like', "%$keyword%");
                  });
        })
        ->where('stock_status', 'instock')
        ->orderBy('name', 'asc')
        ->limit(8) // عرض أول 8 نتائج فقط في البحث المباشر
        ->get();

    return response()->json([
        'products' => $products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => number_format($product->sale_price ?: $product->regular_price, 2),
                'image' => asset('uploads/products/' . $product->image), // تصحيح المسار
                'url' => route('shop.product.details', $product->slug), // استخدام الـ slug
                'category' => $product->category ? $product->category->name : 'Uncategorized'
            ];
        }),
        'total' => $products->count()
    ]);
}
    
}
