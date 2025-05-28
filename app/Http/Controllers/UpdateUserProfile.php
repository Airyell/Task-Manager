<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateUserProfile extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate input, allowing nullable (optional) fields
        $request->validate([
            'name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        // Update only if the field is provided
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('username')) {
            $user->username = $request->username;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
