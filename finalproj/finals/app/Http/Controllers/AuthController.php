<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Get the authenticated user instance directly
            $user = Auth::user();

            Log::create([
                'user_id' => $user->user_id, // FIXED: Changed from $user->id to $user->user_id to match your database column
                'action' => 'Logged in',
                'date_time' => now(),
            ]);

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        // Optional: Log the logout action before destroying session
        if (Auth::check()) {
            Log::create([
                'user_id' => Auth::user()->user_id, // Updated to use the correct primary key for consistency
                'action' => 'Logged out',
                'date_time' => now(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}