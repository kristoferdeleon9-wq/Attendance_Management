<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            if (auth()->user()->role === 'admin') {
                return redirect()->route('dashboard');
            }

            if (auth()->user()->role === 'teacher') {
                return redirect()->route('dashboard');
            }

            Auth::logout();

            return back()->withErrors([
                'email' => 'Your account does not have a valid role.',
            ]);
        }

        return back()->withErrors([
            'email' => 'The email or password is incorrect.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}