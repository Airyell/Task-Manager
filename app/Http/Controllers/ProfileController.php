<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // This is redundant if ProfileController extends Controller already, but harmless.

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\UpdateUserProfile;


class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = $this->user(); // Use the existing user() method to get the user object

        // You might want to pass the user object to a view.
        // For example, if you have a view at resources/views/profile/index.blade.php
        return view('profile.index', compact('user'));
    }

    /**
     * Construct the user object.
     *
     * @return \App\User
     */
    public function user()
    {
        $user  = auth()->user();

        // Check if $user->profile exists and is a string before unserializing
        if (isset($user->profile) && is_string($user->profile)) {
            $user->profile = unserialize($user->profile);
        } else {
            // If profile doesn't exist or isn't a string, initialize it as an empty array
            $user->profile = [];
        }

        $user->image = (
            isset($user->profile['image'])
        ) ? $user->profile['image'] : 'images/user-icon.svg';

        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function showblackchips()
    {
        $user = $this->user();
        return view('showblackchips', compact('user')); // Assuming 'showblackchips' is a view
    }

    // You might also want a method to update the profile
    public function update(UpdateUserProfile $request)
    {
        $user = auth()->user();
        $profile = is_string($user->profile) ? unserialize($user->profile) : ($user->profile ?? []); // Ensure profile is an array

        // Handle image upload if 'avatar' is in the request
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('/uploads/avatars/' . $filename)); // Save to public path
            $profile['image'] = '/uploads/avatars/' . $filename; // Store the path
        }

        // Merge other profile data from the request
        // Ensure you define what fields are allowed in UpdateUserProfile request
        $profile = array_merge($profile, $request->except(['_token', '_method', 'avatar'])); // Exclude non-profile fields

        $user->profile = serialize($profile);
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // You might also have a 'edit' method to display the form for editing
    public function edit()
    {
        $user = $this->user();
        return view('profile.edit', compact('user'));
    }
}