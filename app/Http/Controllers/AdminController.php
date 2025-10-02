<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
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

    // ==================== BRANDS ====================
    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.brand-add');
    }

    public function brand_store(Request $request)
    {
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
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateBrandThumbailsImage($image, $file_name);
        $brand->image = $file_name;
        $brand->save();

        return redirect()->route('admin.brands')->with('status', 'Brand has been added successfully!');
    }

    public function brand_edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
    }

    public function brand_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,' . $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/brands') . '/' . $brand->image)) {
                File::delete(public_path('uploads/brands') . '/' . $brand->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateBrandThumbailsImage($image, $file_name);
            $brand->image = $file_name;
        }
        $brand->save();

        return redirect()->route('admin.brands')->with('status', 'Brand has been updated successfully!');
    }

    public function GenerateBrandThumbailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspecRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function brand_delete($id)
    {
        $brand = Brand::find($id);
        if (File::exists(public_path('uploads/brands') . '/' . $brand->image)) {
            File::delete(public_path('uploads/brands') . '/' . $brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'Brand has been deleted successfully!');
    }

    // ==================== CATEGORIES ====================
    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function add_category()
    {
        return view('admin.category-add');
    }

    public function category_store(Request $request)
    {
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
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateCategoryThumbailsImage($image, $file_name);
        $category->image = $file_name;
        $category->save();

        return redirect()->route('admin.categories')->with('status', 'Category has been added successfully!');
    }

    public function GenerateCategoryThumbailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspecRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function category_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
                File::delete(public_path('uploads/categories') . '/' . $category->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateCategoryThumbailsImage($image, $file_name);
            $category->image = $file_name;
        }
        $category->save();

        return redirect()->route('admin.categories')->with('status', 'Category has been updated successfully!');
    }

    public function category_delete($id)
    {
        $category = Category::find($id);
        if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
            File::delete(public_path('uploads/categories') . '/' . $category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Category has been deleted successfully!');
    }

    // ==================== PRODUCTS ====================
    public function products()
    {
        $products = Product::orderBy('id', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function add_product()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        $attributes = ProductAttribute::with('values')->get();
        return view('admin.product-add', compact('categories', 'brands', 'attributes'));
    }

 public function product_store(Request $request)
{
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
        'category_id' => 'required',
        'brand_id' => 'required',
        'variants' => 'required|array|min:1',
        'variants.*.sku' => 'required|string',
        'variants.*.quantity' => 'required|integer|min:0',
        'variants.*.images' => 'required|array|min:1',
        'variants.*.images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ], [
        'variants.required' => 'You must add at least one product variant with images',
        'variants.*.images.required' => 'Each variant must have at least one image',
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

    // استخدام أول صورة من أول variant كصورة رئيسية للمنتج
    $firstVariantImages = $request->file('variants.0.images');
    if ($firstVariantImages && count($firstVariantImages) > 0) {
        $current_timestamp = Carbon::now()->timestamp;
        $firstImage = $firstVariantImages[0];
        $imageName = $current_timestamp . '.' . $firstImage->extension();
        $this->GenerateProductThumbailsImage($firstImage, $imageName);
        $product->image = $imageName;
    } else {
        $product->image = 'default.jpg';
    }

    $product->save();

    // حفظ الـ Variants
    if ($request->has('variants') && is_array($request->variants)) {
        $current_timestamp = Carbon::now()->timestamp;

        foreach ($request->variants as $index => $variantData) {
            if (!isset($variantData['sku'])) continue;

            $variant = new ProductVariant();
            $variant->product_id = $product->id;
            $variant->sku = $variantData['sku'];
            $variant->price = $variantData['price'] ?? $product->regular_price;
            $variant->quantity = $variantData['quantity'] ?? 0;

            // حفظ صور الـ Variant
            $variantImages = [];
            if (isset($variantData['images']) && is_array($variantData['images'])) {
                foreach ($variantData['images'] as $image) {
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $imageName = $current_timestamp . '-' . uniqid() . '.' . $image->extension();
                        $this->GenerateProductThumbailsImage($image, $imageName);
                        $variantImages[] = $imageName;
                    }
                }
            }

            if (!empty($variantImages)) {
                $variant->images = implode(',', $variantImages);
            }

            $variant->save();

            // ربط الـ Attributes بالـ Variant
            if (isset($variantData['attributes'])) {
                $attributeIds = array_filter(explode(',', $variantData['attributes']));
                if (!empty($attributeIds)) {
                    $variant->attributeValues()->attach($attributeIds);
                }
            }
        }
    }

    return redirect()->route('admin.products')->with('status', 'Product has been added successfully!');
}
public function GenerateProductThumbailsImage($image, $imageName)
{
    $destinationPathThumbail = public_path('uploads/products/thumbnails');
    $destinationPath = public_path('uploads/products');
    
    try {
        $img = Image::read($image->path());
        
        $img->cover(540, 689, "top");
        $img->resize(540, 689, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);

        $img->resize(104, 104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbail . '/' . $imageName);
        
    } catch (\Exception $e) {
        // Fallback: نسخ الصورة بدون معالجة
        copy($image->path(), $destinationPath . '/' . $imageName);
        copy($image->path(), $destinationPathThumbail . '/' . $imageName);
    }
}    public function product_edit($id)
    {
        $product = Product::with('variants.attributeValues')->find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        $attributes = ProductAttribute::with('values')->get();
        return view('admin.product-edit', compact('product', 'categories', 'brands', 'attributes'));
    }

  public function product_update(Request $request)
{
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

    // تحديث الصورة الرئيسية
    if ($request->hasFile('image')) {
        if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
            File::delete(public_path('uploads/products') . '/' . $product->image);
        }
        if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
            File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
        }
        $image = $request->file('image');
        $imageName = $current_timestamp . '.' . $image->extension();
        $this->GenerateProductThumbailsImage($image, $imageName);
        $product->image = $imageName;
    }

    $product->save();

    // ==================== تحديث الـ Existing Variants ====================
    if ($request->has('existing_variants')) {
        foreach ($request->existing_variants as $variantId => $variantData) {
            $variant = ProductVariant::find($variantId);
            if ($variant && $variant->product_id == $product->id) {
                // تحديث البيانات الأساسية
                $variant->sku = $variantData['sku'] ?? $variant->sku;
                $variant->price = $variantData['price'] ?? $variant->price;
                $variant->quantity = $variantData['quantity'] ?? $variant->quantity;

                // تحديث الصور إذا تم رفع صور جديدة
                if ($request->hasFile("existing_variants.{$variantId}.images")) {
                    $newImages = [];
                    $uploadedImages = $request->file("existing_variants.{$variantId}.images");
                    
                    foreach ($uploadedImages as $image) {
                        if ($image instanceof \Illuminate\Http\UploadedFile) {
                            $imageName = $current_timestamp . '-' . uniqid() . '.' . $image->extension();
                            $this->GenerateProductThumbailsImage($image, $imageName);
                            $newImages[] = $imageName;
                        }
                    }

                    // إضافة الصور الجديدة للصور الموجودة
                    if (!empty($newImages)) {
                        $existingImages = $variant->images ? explode(',', $variant->images) : [];
                        $allImages = array_merge($existingImages, $newImages);
                        $variant->images = implode(',', $allImages);
                    }
                }

                $variant->save();
            }
        }
    }

    // ==================== إضافة New Variants ====================
    if ($request->has('new_variants') && is_array($request->new_variants)) {
        foreach ($request->new_variants as $index => $variantData) {
            // التحقق من وجود البيانات الأساسية
            if (!isset($variantData['sku']) || !isset($variantData['attributes'])) {
                continue;
            }

            $variant = new ProductVariant();
            $variant->product_id = $product->id;
            $variant->sku = $variantData['sku'];
            $variant->price = $variantData['price'] ?? $product->regular_price;
            $variant->quantity = $variantData['quantity'] ?? 0;

            // حفظ صور الـ Variant الجديد
            $variantImages = [];
            if ($request->hasFile("new_variants.{$index}.images")) {
                $uploadedImages = $request->file("new_variants.{$index}.images");
                
                foreach ($uploadedImages as $image) {
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $imageName = $current_timestamp . '-' . uniqid() . '.' . $image->extension();
                        $this->GenerateProductThumbailsImage($image, $imageName);
                        $variantImages[] = $imageName;
                    }
                }
            }

            if (!empty($variantImages)) {
                $variant->images = implode(',', $variantImages);
            }

            $variant->save();

            // ربط الـ Attributes بالـ Variant الجديد
            if (isset($variantData['attributes'])) {
                $attributeIds = array_filter(explode(',', $variantData['attributes']));
                if (!empty($attributeIds)) {
                    $variant->attributeValues()->attach($attributeIds);
                }
            }
        }
    }

    return redirect()->route('admin.products')->with('status', 'Product has been updated successfully!');
}

// ==================== حذف Variant ====================
public function variant_delete($id)
{
    $variant = ProductVariant::find($id);
    
    if (!$variant) {
        return response()->json(['error' => 'Variant not found'], 404);
    }

    // حذف صور الـ Variant
    if ($variant->images) {
        foreach (explode(',', $variant->images) as $vImage) {
            $vImage = trim($vImage);
            if (File::exists(public_path('uploads/products') . '/' . $vImage)) {
                File::delete(public_path('uploads/products') . '/' . $vImage);
            }
            if (File::exists(public_path('uploads/products/thumbnails') . '/' . $vImage)) {
                File::delete(public_path('uploads/products/thumbnails') . '/' . $vImage);
            }
        }
    }

    // حذف علاقات الـ Attributes
    $variant->attributeValues()->detach();
    
    // حذف الـ Variant
    $variant->delete();
    
    return response()->json([
        'success' => true, 
        'message' => 'Variant deleted successfully'
    ]);
}

    public function product_delete($id)
    {
        $product = Product::find($id);

        if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
            File::delete(public_path('uploads/products') . '/' . $product->image);
        }
        if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
            File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
        }

        foreach (explode(',', $product->images) as $ofile) {
            if (File::exists(public_path('uploads/products') . '/' . $ofile)) {
                File::delete(public_path('uploads/products') . '/' . $ofile);
            }
            if (File::exists(public_path('uploads/products/thumbnails') . '/' . $ofile)) {
                File::delete(public_path('uploads/products/thumbnails') . '/' . $ofile);
            }
        }

        // حذف صور الـ Variants
        foreach ($product->variants as $variant) {
            if ($variant->images) {
                foreach (explode(',', $variant->images) as $vImage) {
                    if (File::exists(public_path('uploads/products') . '/' . $vImage)) {
                        File::delete(public_path('uploads/products') . '/' . $vImage);
                    }
                    if (File::exists(public_path('uploads/products/thumbnails') . '/' . $vImage)) {
                        File::delete(public_path('uploads/products/thumbnails') . '/' . $vImage);
                    }
                }
            }
        }

        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Product has been deleted successfully!');
    }

    public function reorderVariantImages(Request $request, $id)
{
    $variant = ProductVariant::findOrFail($id);
    $newOrder = $request->input('order'); // array of filenames
    
    $variant->images = implode(',', $newOrder);
    $variant->save();
    
    return response()->json(['success' => true]);
}

    // ==================== ATTRIBUTES ====================
    public function attributes()
    {
        $attributes = ProductAttribute::with('values')->get();
        return view('admin.attributes', compact('attributes'));
    }

    public function attribute_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:color,text'
        ]);

        ProductAttribute::create($request->only(['name', 'type']));

        return back()->with('status', 'Attribute added successfully!');
    }

  public function attribute_value_store(Request $request)
{
    $request->validate([
        'attribute_id' => 'required|exists:product_attributes,id',
        'value' => 'required|string|max:255',
        'color_code' => 'nullable|string|max:7'
    ]);

    AttributeValue::create($request->only(['attribute_id', 'value', 'color_code']));

    return back()->with('status', 'Value added successfully!');
}

    public function attribute_delete($id)
    {
        $attribute = ProductAttribute::find($id);
        $attribute->delete();
        return back()->with('status', 'Attribute deleted successfully!');
    }

    public function attribute_value_delete($id)
    {
        $value = AttributeValue::find($id);
        $value->delete();
        return back()->with('status', 'Value deleted successfully!');
    }

    // ==================== SETTINGS ====================
    public function settings()
    {
        return view('admin.settings');
    }

    public function updateDetails(Request $request)
    {
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

    public function updatePassword(Request $request)
    {
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
    public function deleteVariantImage(Request $request, $id)
{
    try {
        $variant = ProductVariant::findOrFail($id);
        $imageToDelete = $request->image;
        
        // حذف الصورة من المجلد
        $imagePath = public_path('uploads/products/' . $imageToDelete);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        // تحديث قاعدة البيانات
        $images = explode(',', $variant->images);
        $images = array_filter($images, function($img) use ($imageToDelete) {
            return trim($img) !== $imageToDelete;
        });
        
        $variant->images = implode(',', $images);
        $variant->save();
        
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

}