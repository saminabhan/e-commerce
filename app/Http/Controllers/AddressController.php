<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::orderBy('is_default', 'desc')->latest()->get();
        return view('addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('addresses.create');
    }

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
            Address::where('is_default', true)->update(['is_default' => false]);
        }

        Address::create($request->all());

        return redirect()->route('addresses.index')->with('success', 'Address added successfully');
    }

    public function edit(Address $address)
    {
        return view('addresses.edit', compact('address'));
    }

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

    public function destroy(Address $address)
    {
        $address->delete();
        return redirect()->route('addresses.index')->with('success', 'Address deleted successfully');
    }
}
