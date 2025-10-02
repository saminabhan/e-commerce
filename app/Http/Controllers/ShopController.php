<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request){
        $size = $request->query('size') ? $request->query('size') : 12;
        $o_column = "";
        $o_order = "";
        $order = $request->query('order') ? $request->query('order') : -1;
        $f_brands = $request->query('brands');//brands is the name of hidden input
        $f_categories = $request->query('categories');//categories is the name of hidden input
        $min_price = $request->query('min') ? $request->query('min') : 1;
        $max_price = $request->query('max') ? $request->query('max') : 7000;
        switch($order){
            case 1:
                $o_column = 'created_at';
                $o_order = 'DESC';
                break;
            case 2:
                $o_column = 'created_at';
                $o_order = 'ASC';
                break;
            case 3:
                $o_column = 'regular_price';
                $o_order = 'ASC';
                break;
            case 4:
                $o_column = 'regular_price';
                $o_order = 'DESC';
                break;
            default:
                $o_column = 'id';
                $o_order = 'DESC';
        }
        $brands = Brand::orderBy('name','ASC')->get();
        $categories = Category::orderBy('name','ASC')->get();
        $products = Product::when(!empty($f_brands), function($query) use ($f_brands) {
            $brandIds = explode(',', $f_brands);
            $query->whereIn('brand_id', $brandIds);
        })
        ->when(!empty($f_categories), function($query) use ($f_categories) {
            $categoryIds = explode(',', $f_categories);
            $query->whereIn('category_id', $categoryIds);
        })
        ->where(function($query) use($min_price,$max_price){
            $query->whereBetween('regular_price',[$min_price,$max_price])
            ->orWhereBetween('sale_price',[$min_price,$max_price]);
        })
        ->orderBy($o_column, $o_order)
        ->paginate($size);


        return view('shop',compact('products','size','order','brands','f_brands','categories','f_categories','min_price','max_price'));
    }

public function product_details($product_slug)
{
    $product = Product::where('slug', $product_slug)
        ->with([
            'variants' => function($query) {
                $query->with(['attributeValues' => function($q) {
                    $q->with('attribute');
                }]);
            },
            'category',
            'brand'
        ])
        ->firstOrFail();
    
    $rproducts = Product::where('slug', '!=', $product_slug)
        ->where('category_id', $product->category_id)
        ->inRandomOrder()
        ->take(8)
        ->get();
    
    return view('details', compact('product', 'rproducts'));
}
public function getVariantImages($productId, $colorId)
{
    try {
        $product = Product::findOrFail($productId);
        
        // Find variant with this color
        $variant = $product->variants()
            ->whereHas('attributeValues', function($query) use ($colorId) {
                $query->where('attribute_value_id', $colorId);
            })
            ->first();
        
        if (!$variant || !$variant->images) {
            return response()->json([
                'success' => false,
                'message' => 'No images found for this variant'
            ], 404);
        }
        
        $images = explode(',', $variant->images);
        $images = array_map('trim', $images);
        
        return response()->json([
            'success' => true,
            'images' => $images,
            'productName' => $product->name,
            'productUrl' => route('shop.product.details', ['product_slug' => $product->slug])
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error fetching variant images'
        ], 500);
    }
}

}
