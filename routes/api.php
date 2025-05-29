<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::post('/login', function(Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return response()->json([
            'message' => 'Login successful',
            'user' => Auth::user()
        ]);
    }

    return response()->json([
        'message' => 'Invalid credentials'
    ], 401);
});
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json(['message' => 'Logged out']);
});
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->get('/user', function () {
    return Auth::user();
});
