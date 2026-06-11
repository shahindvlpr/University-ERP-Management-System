<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show Login Form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials, $request->remember))
        {
            $request->session()->regenerate();

            $user = Auth::user();

            // Student Login
            if ($user->hasRole('student'))
            {
                return redirect()->route('student.dashboard');
            }

            // Teacher Login
            if ($user->hasRole('teacher'))
            {
                return redirect()->route('dashboard');
            }

            // Admin Login
            if ($user->hasRole('admin'))
            {
                return redirect()->route('dashboard');
            }

            // Default Redirect
            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Invalid credentials.',
            ])
            ->onlyInput('email');
    }

    /**
     * Logout User
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}