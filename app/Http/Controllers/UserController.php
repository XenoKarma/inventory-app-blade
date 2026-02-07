<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List all users
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Show form create user
    public function create()
    {
        return view('users.create');
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|string|min:6|confirmed',
            'role' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'User created successfully.');
    }

    // Show form edit user
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email,' . $user->id,
            'password'=> 'nullable|string|min:6|confirmed',
            'role' => 'required|string',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }
}
