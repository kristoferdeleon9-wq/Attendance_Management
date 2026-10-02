<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/test', function () {
    return response()->json([
        'message' => 'AttendEase API is working!'
    ]);
});

Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }

    $user = Auth::user();

    if (!in_array($user->role, ['admin', 'teacher'])) {
        Auth::logout();

        return response()->json([
            'message' => 'Your account does not have a valid role.'
        ], 403);
    }

    $token = $user->createToken('android-app')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'user' => $user,
    ]);
});