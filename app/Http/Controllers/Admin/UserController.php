<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
public function index()
{
    $users = User::where('id', '!=', auth()->id()) // ما تجيب نفسك
        ->where('email', '!=', 'admin@admin.com') // ما تجيب السوبر أدمن
        ->latest()->get();

    return view('admin.users.index', compact('users'));
}


    public function create() {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'utype' => 'required|in:ADM,USR',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'utype' => $request->utype,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|string|unique:users,mobile,' . $user->id,
            'utype' => 'required|in:ADM,USR',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'utype' => $request->utype,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
