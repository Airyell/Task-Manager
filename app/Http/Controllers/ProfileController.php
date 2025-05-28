<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Show profile overview page (optional)
    public function index()
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }

    // Show the edit profile form
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    // Handle the form submission to update profile
    public function update(Request $request)
    {
        $user = auth()->user();

        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        // Update user details
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        // If user wants to change password and passed validation, hash and update it
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        // Save changes to the database
        $user->save();

        // Redirect back to profile overview with success message
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
