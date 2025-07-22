<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function details()
    {
        return view('user.account-details');
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

        return redirect()->route('user.details')
            ->with('success', 'Account details updated successfully!');
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

        return redirect()->route('user.details')
            ->with('success', 'Password updated successfully!');
    }

    public function orders()
{
    $user = Auth::user();

    $orders = Order::withCount('items')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('user.account-orders', compact('orders'));
}
public function orderDetails(Order $order)
{
    if ($order->user_id !== Auth::id()) {
        abort(403);
    }

    $order->load('items.product'); // لو محتاج المنتج أيضًا

    return view('user.order-details', compact('order'));
}


}
