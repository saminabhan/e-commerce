<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    // عرض قائمة العناوين
    public function index()
    {
        $addresses = Address::orderBy('is_default', 'desc')->latest()->get();
        return view('addresses.index', compact('addresses'));
    }

    // عرض صفحة إضافة عنوان جديد
    public function create()
    {
        return view('addresses.create');
    }

    // حفظ العنوان الجديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'zip' => 'required|string|max:20',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'is_default' => 'nullable|boolean',
        ]);

        if ($request->has('is_default') && $request->is_default) {
            // إزالة العلامة من العناوين الأخرى
            Address::where('is_default', true)->update(['is_default' => false]);
        }

        Address::create($request->all());

        return redirect()->route('addresses.index')->with('success', 'Address added successfully');
    }

    // صفحة تعديل عنوان
    public function edit(Address $address)
    {
        return view('addresses.edit', compact('address'));
    }

    // تحديث العنوان
    public function update(Request $request, Address $address)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'zip' => 'required|string|max:20',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'is_default' => 'nullable|boolean',
        ]);

        if ($request->has('is_default') && $request->is_default) {
            Address::where('is_default', true)->update(['is_default' => false]);
        }

        $address->update($request->all());

        return redirect()->route('addresses.index')->with('success', 'Address updated successfully');
    }

    // حذف العنوان
    public function destroy(Address $address)
    {
        $address->delete();
        return redirect()->route('addresses.index')->with('success', 'Address deleted successfully');
    }
}
