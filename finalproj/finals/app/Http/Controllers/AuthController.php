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
        // Validate the form data
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Log the action if you want to track logins
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'Logged in',
                'date_time' => now(),
            ]);

            return redirect()->intended(route('dashboard'));
        }

        // If auth fails, go back with error
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
                'user_id' => Auth::id(),
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