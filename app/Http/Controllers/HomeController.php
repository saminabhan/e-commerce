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
    

    
    
}
