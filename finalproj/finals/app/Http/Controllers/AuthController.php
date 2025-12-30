<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
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
        $throttleKey = 'login:' . $request->ip();
        $lockoutKey = 'lockout:' . $request->ip();
        $failedAttemptsKey = 'failed_attempts:' . $request->ip();
        
        // Check for persistent lockout (15 min after 10 failed attempts)
        if (Cache::has($lockoutKey)) {
            $remainingSeconds = Cache::get($lockoutKey) - time();
            $minutes = ceil($remainingSeconds / 60);
            throw ValidationException::withMessages([
                'username' => "Account temporarily locked due to too many failed attempts. Try again in {$minutes} minute(s).",
            ]);
        }

        // Rate limiting: Max 5 attempts per minute per IP
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            // Track total failed attempts
            $totalAttempts = Cache::increment($failedAttemptsKey);
            
            // Lock for 15 minutes after 10 total failures
            if ($totalAttempts >= 10) {
                Cache::put($lockoutKey, time() + 900, 900); // 15 minutes
                Cache::forget($failedAttemptsKey);
                
                throw ValidationException::withMessages([
                    'username' => 'Account temporarily locked due to too many failed attempts. Try again in 15 minutes.',
                ]);
            }
            
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'username' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            // Clear rate limiter and failed attempts on successful login
            RateLimiter::clear($throttleKey);
            Cache::forget($failedAttemptsKey);
            
            $request->session()->regenerate();

            // Get the authenticated user instance directly
            $user = Auth::user();

            Log::create([
                'user_id' => $user->user_id,
                'action' => 'Logged in',
                'date_time' => now(),
            ]);

            return redirect()->intended(route('dashboard'));
        }

        // Increment rate limiter on failed attempt
        RateLimiter::hit($throttleKey, 60);
        
        // Initialize failed attempts counter if not exists
        if (!Cache::has($failedAttemptsKey)) {
            Cache::put($failedAttemptsKey, 1, 1800); // 30 min expiry
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
                'user_id' => Auth::user()->user_id,
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