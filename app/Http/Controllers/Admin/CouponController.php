<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index() {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create() {
        return view('admin.coupons.create');
    }

    public function store(Request $request) {
        $request->validate([
            'code' => 'required|unique:coupons',
            'discount' => 'required|numeric',
            'type' => 'required|in:fixed,percent',
        ]);

        Coupon::create($request->all());
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created');
    }

    // صفحة التعديل
    public function edit(Coupon $coupon) {
        return view('admin.coupons.edit', compact('coupon'));
    }

    // تحديث الكوبون
    public function update(Request $request, Coupon $coupon) {
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'discount' => 'required|numeric',
            'type' => 'required|in:fixed,percent',
        ]);

        $coupon->update($request->all());
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated');
    }

        public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }

}
