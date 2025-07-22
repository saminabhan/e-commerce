<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{
   public function index()
{
    $orders = Order::with('items', 'user')->latest()->get();

    return view('admin.index', [
        'totalOrders' => $orders->count(),
        'totalAmount' => $orders->sum('total'),
        'pendingOrders' => $orders->where('status', 'pending')->count(),
        'pendingAmount' => $orders->where('status', 'pending')->sum('total'),
        'deliveredOrders' => $orders->where('status', 'delivered')->count(),
        'deliveredAmount' => $orders->where('status', 'delivered')->sum('total'),
        'canceledOrders' => $orders->where('status', 'cancelled')->count(),
        'canceledAmount' => $orders->where('status', 'cancelled')->sum('total'),
        'recentOrders' => $orders->take(10),
    ]);
}

public function order_show($id)
{
    $order = Order::findOrFail($id);
    return view('admin.orders.show', compact('order'));
}


    public function brands(){
        $brands = Brand::orderBy('id','DESC')->paginate(10);
        return view('admin.brands' ,compact('brands'));
    }

    public function add_brand(){
        return view('admin.brand-add');
    }

    public function brand_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extention;
        $this->GenerateBrandThumbailsImage($image ,$file_name);
        $brand->image = $file_name;
        $brand->save();
        
        return redirect()->route('admin.brands')->with('status','Brand has been added successfully!');
    }

    public function brand_edit($id){
        $brand = Brand::find($id);
        return view('admin.brand-edit' ,compact('brand'));
    }

    public function brand_update(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,' . $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if($request->hasFile('image')){
            if(File::exists(public_path('uploads/brands') .'/'. $brand->image)){
                File::delete(public_path('uploads/brands') .'/'. $brand->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extention;
            $this->GenerateBrandThumbailsImage($image ,$file_name);
            $brand->image = $file_name;
        }
        $brand->save();
        
        return redirect()->route('admin.brands')->with('status','Brand has been updated successfully!');
    }

    public function GenerateBrandThumbailsImage($image ,$imageName){
        $destinationPath = public_path('uploads/brands');
        $img = Image::read($image->path());
        $img->cover(124,124,"top");
        $img->resize(124,124,function($constraint){
            $constraint->aspecRatio();
        })->save($destinationPath.'/'.$imageName);
    }

    public function brand_delete($id){
        $brand = Brand::find($id);
        if(File::exists(public_path('uploads/brands') .'/'. $brand->image)){
            File::delete(public_path('uploads/brands') .'/'. $brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status','Brand has been deleted successfully!');
    }

    public function categories(){
        $categories = Category::orderBy('id','DESC')->paginate(10);
        return view('admin.categories' ,compact('categories'));
    }

    public function add_category(){
        return view('admin.category-add');
    }

    public function category_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extention;
        $this->GenerateCategoryThumbailsImage($image ,$file_name);
        $category->image = $file_name;
        $category->save();
        
        return redirect()->route('admin.categories')->with('status','Category has been added successfully!');
    }

    public function GenerateCategoryThumbailsImage($image ,$imageName){
        $destinationPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124,124,"top");
        $img->resize(124,124,function($constraint){
            $constraint->aspecRatio();
        })->save($destinationPath.'/'.$imageName);
    }

    public function category_edit($id){
        $category = Category::find($id);
        return view('admin.category-edit' ,compact('category'));
    }

    public function category_update(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if($request->hasFile('image')){
            if(File::exists(public_path('uploads/categories') .'/'. $category->image)){
                File::delete(public_path('uploads/categories') .'/'. $category->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extention;
            $this->GenerateCategoryThumbailsImage($image ,$file_name);
            $category->image = $file_name;
        }
        $category->save();
        
        return redirect()->route('admin.categories')->with('status','Category has been updated successfully!');
    }

    public function category_delete($id){
        $category = Category::find($id);
        if(File::exists(public_path('uploads/categories') .'/'. $category->image)){
            File::delete(public_path('uploads/categories') .'/'. $category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status','Category has been deleted successfully!');
    }
    
    public function products(){
        $products = Product::orderBy('id','DESC')->paginate(10);
        return view('admin.products' ,compact('products'));
    }

    public function add_product(){
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();
        return view('admin.product-add' ,compact('categories','brands'));
    }

    public function product_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);
        
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbailsImage($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = [];

        if ($request->hasFile('images')) {
            $allowedFileExtensions = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            
            foreach ($files as $file) {
                $extension = $file->extension(); // More secure
                if (in_array($extension, $allowedFileExtensions)) {
                    $fileName = $current_timestamp . '-' . uniqid() . '.' . $extension;
                    $this->GenerateProductThumbailsImage($file, $fileName);
                    $gallery_arr[] = $fileName;
                }
            }

            $gallery_images = implode(',', $gallery_arr);
            $product->images = $gallery_images; // Optional: Consider using a relation for better data management
        }

        $product->save();

        return redirect()->route('admin.products')->with('status','Product has been added successfully!');
    }

    public function GenerateProductThumbailsImage($image ,$imageName){
        $destinationPathThumbail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');
        $img = Image::read($image->path());

        $img->cover(540,689,"top");

        $img->resize(540,689,function($constraint){
            $constraint->aspecRatio();
        })->save($destinationPath.'/'.$imageName);
        
        $img->resize(104,104,function($constraint){
            $constraint->aspecRatio();
        })->save($destinationPathThumbail.'/'.$imageName);
    }

    public function product_edit($id){
        $product = Product::find($id);
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();
        return view('admin.product-edit' ,compact('product' , 'categories', 'brands'));
    }

    public function product_update(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $request->id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            if(File::exists(public_path('uploads/products') .'/'. $product->image)){
                File::delete(public_path('uploads/products') .'/'. $product->image);
            }
            if(File::exists(public_path('uploads/products/thumbnails') .'/'. $product->image)){
                File::delete(public_path('uploads/products/thumbnails') .'/'. $product->image);
            }
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbailsImage($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = [];

        if ($request->hasFile('images')) {
            foreach ( explode(',',$product->images) as $ofile ){
                if(File::exists(public_path('uploads/products') .'/'. $ofile)){
                    File::delete(public_path('uploads/products') .'/'. $ofile);
                }
                if(File::exists(public_path('uploads/products/thumbnails') .'/'. $ofile)){
                    File::delete(public_path('uploads/products/thumbnails') .'/'. $ofile);
                }
            }

            $allowedFileExtensions = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            
            foreach ($files as $file) {
                $extension = $file->extension(); // More secure
                if (in_array($extension, $allowedFileExtensions)) {
                    $fileName = $current_timestamp . '-' . uniqid() . '.' . $extension;
                    $this->GenerateProductThumbailsImage($file, $fileName);
                    $gallery_arr[] = $fileName;
                }
            }

            $gallery_images = implode(',', $gallery_arr);
            $product->images = $gallery_images; // Optional: Consider using a relation for better data management
        }

        $product->save();

        return redirect()->route('admin.products')->with('status','Product has been updated successfully!');

    }

    public function product_delete($id){
        $product = Product::find($id);

        if(File::exists(public_path('uploads/products') .'/'. $product->image)){
            File::delete(public_path('uploads/products') .'/'. $product->image);
        }
        if(File::exists(public_path('uploads/products/thumbnails') .'/'. $product->image)){
            File::delete(public_path('uploads/products/thumbnails') .'/'. $product->image);
        }

        foreach ( explode(',',$product->images) as $ofile ){
            if(File::exists(public_path('uploads/products') .'/'. $ofile)){
                File::delete(public_path('uploads/products') .'/'. $ofile);
            }
            if(File::exists(public_path('uploads/products/thumbnails') .'/'. $ofile)){
                File::delete(public_path('uploads/products/thumbnails') .'/'. $ofile);
            }
        }

        $product->delete();
        return redirect()->route('admin.products')->with('status','Product has been deleted successfully!');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateDetails(Request $request){
        /** @var User $user */

    $user = Auth::user();

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('users')->ignore($user->id),
        ],
        'mobile' => [
            'required',
            'string',
            'max:20',
            Rule::unique('users')->ignore($user->id),
        ],
    ], [
        'email.unique' => 'This email address is already registered with another account.',
        'mobile.unique' => 'This mobile number is already registered with another account.',
    ]);

    $user->update($validatedData);

    return redirect()->route('admin.settings')->with('status', 'Details updated successfully!');

    }

    public function updatePassword(Request $request){
        /** @var User $user */
        $user = Auth::user();

        $validatedData = $request->validate([
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('The current password is incorrect.');
                    }
                },
            ],
            'new_password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ]);

        $user->password = Hash::make($validatedData['new_password']);
        $user->save();

    return redirect()->route('admin.settings')->with('status', 'Password updated successfully!');
    }
}
