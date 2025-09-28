<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderTrackingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Auth::routes();
// Email Verification Routes
Route::get('/verify', [App\Http\Controllers\Auth\VerificationController::class, 'showVerificationForm'])
    ->name('verify.form'); // إزالة ->middleware('auth')

Route::post('/verify', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])
    ->name('verify.code'); // إزالة ->middleware('auth')

Route::post('/verify/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resendCode'])
    ->name('verify.resend'); // إزالة ->middleware('auth')

Route::get('password/reset', [App\Http\Controllers\Auth\LoginController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\LoginController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\LoginController::class, 'reset'])->name('password.update');


Route::middleware(['guest'])->group(function () {
    Route::get('/verify', [App\Http\Controllers\Auth\VerificationController::class, 'showVerificationForm'])
        ->name('verify.form');
    Route::post('/verify', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])
        ->name('verify.code');
    Route::post('/verify/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resendCode'])
        ->name('verify.resend');
});

// // Login Verification Routes (لتسجيل الدخول)
// Route::middleware(['guest'])->group(function () {
//     Route::get('/login/verify', [App\Http\Controllers\Auth\LoginController::class, 'showLoginVerificationForm'])
//         ->name('login.verify.form');
//     Route::post('/login/verify', [App\Http\Controllers\Auth\LoginController::class, 'verifyLoginCode'])
//         ->name('login.verify.code');
//     Route::post('/login/verify/resend', [App\Http\Controllers\Auth\LoginController::class, 'resendLoginCode'])
//         ->name('login.verify.resend');
// });


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/about', [HomeController::class, 'about'])->name('about.index');
Route::get('/products/search', [HomeController::class, 'search'])->name('products.search');

// البحث المباشر (Live Search) - مهم جداً
Route::get('/search/live', [HomeController::class, 'liveSearch'])->name('search.live');

// يمكنك أيضاً إضافة بحث AJAX للتحميل الديناميكي
Route::post('/search/ajax', [HomeController::class, 'ajaxSearch'])->name('search.ajax');

// routes للمنتجات
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('/cart/decrease-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'empty_cart'])->name('cart.empty');
    Route::get('/checkout', [PaymentController::class, 'showCheckout'])->name('checkout.index');
    Route::post('/checkout/place', [PaymentController::class, 'placeOrder'])->name('checkout.place');
    
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');

Route::get('/order/confirmation/{order}', [PaymentController::class, 'orderConfirmation'])
    ->name('order.confirmation')
    ->middleware('auth');    
    Route::get('/payment/stripe/{order}', [PaymentController::class, 'showStripeForm'])->name('payment.stripe.form');
    Route::post('/payment/process', [PaymentController::class, 'processStripe'])->name('payment.process');
    
    Route::post('/order/{order}/cancel', [PaymentController::class, 'cancelOrder'])->name('order.cancel');

Route::post('/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/remove/{rowId}', [WishlistController::class, 'remove_item'])->name('wishlist.item.remove');
Route::delete('/wishlist/clear', [WishlistController::class, 'empty_wishlist'])->name('wishlist.items.empty');

Route::get('/contact', [ContactController::class, 'index'])->name('home.contact');
Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/account', [UserController::class, 'index'])->name('user.index');
    Route::get('/account/details', [UserController::class, 'details'])->name('user.details');
    Route::put('/account/details/update', [UserController::class, 'updateDetails'])->name('user.update.details');
    Route::put('/account/password/update', [UserController::class, 'updatePassword'])->name('user.update.password');
    Route::get('/account-orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/account-orders/{order}', [UserController::class, 'orderDetails'])->name('user.order.details');
    Route::resource('addresses', AddressController::class);

    // التحقق من توفر الإيميل
    Route::post('/user/check-email', [UserController::class, 'checkEmailAvailability'])->name('user.check.email');
    
    // الروتس الجديدة للتحقق من الإيميل
    Route::post('/user/confirm-email-change', [UserController::class, 'confirmEmailChange'])->name('user.confirm.email.change');
    Route::get('/user/verify-email-change', [UserController::class, 'showEmailVerificationForm'])->name('user.verify.email.form');
    Route::post('/user/verify-email-change', [UserController::class, 'verifyEmailChange'])->name('user.verify.email.change');
    Route::get('/user/resend-email-verification', [UserController::class, 'resendEmailVerification'])->name('user.resend.email.verification');
});

Route::middleware(['auth', AuthAdmin::class])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/store', [AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update', [AdminController::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brand/delete/{id}', [AdminController::class, 'brand_delete'])->name('admin.brand.delete');

    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'add_category'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/{id}/edit', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('/admin/category/update', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete', [AdminController::class, 'category_delete'])->name('admin.category.delete');

    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'add_product'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/{id}/edit', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete', [AdminController::class, 'product_delete'])->name('admin.product.delete');

    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::put('/admin/settings/account/details/update', [AdminController::class, 'updateDetails'])->name('admin.update.details');
    Route::put('/admin/settings/account/password/update', [AdminController::class, 'updatePassword'])->name('admin.update.password');

    Route::get('admin/orders/{id}', [AdminController::class, 'order_show'])->name('admin.orders.show');

        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');

        Route::resource('order-tracking', OrderTrackingController::class)->names([
        'index' => 'admin.order-tracking.index',
        'create' => 'admin.order-tracking.create',
        'store' => 'admin.order-tracking.store',
    ]);

    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::resource('slider', SliderController::class)->names('slider');
    });
    Route::resource('coupons', CouponController::class)->names('admin.coupons');
    

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('users', AdminUserController::class);
});
    Route::resource('order-tracking', OrderTrackingController::class)->names('admin.order-tracking');


});