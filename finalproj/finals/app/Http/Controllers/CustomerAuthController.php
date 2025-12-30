<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

class CustomerAuthController extends Controller
{
    /**
     * Show customer registration form
     */
    public function showRegisterForm()
    {
        return view('customer-auth.register');
    }

    /**
     * Handle customer registration
     */
    public function register(Request $request)
    {
        // Rate limiting: Max 3 registration attempts per 10 minutes per IP
        $throttleKey = 'customer-register:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Too many registration attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.mixed' => 'Password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'Password must contain at least one number.',
            'password.symbols' => 'Password must contain at least one special character.',
        ]);

        $customer = Customer::create([
            'customer_name' => $request->customer_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact_information' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Clear rate limiter on successful registration
        RateLimiter::clear($throttleKey);

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.index')
            ->with('success', 'Account created successfully! Welcome to JV TechHub.');
    }

    /**
     * Show customer login form
     */
    public function showLoginForm()
    {
        return view('customer-auth.login');
    }

    /**
     * Handle customer login
     */
    public function login(Request $request)
    {
        $throttleKey = 'customer-login:' . $request->ip();
        $lockoutKey = 'customer-lockout:' . $request->ip();
        $failedAttemptsKey = 'customer-failed:' . $request->ip();
        
        // Check for persistent lockout (15 min after 10 failed attempts)
        if (Cache::has($lockoutKey)) {
            $remainingSeconds = Cache::get($lockoutKey) - time();
            $minutes = ceil($remainingSeconds / 60);
            throw ValidationException::withMessages([
                'email' => "Account temporarily locked due to too many failed attempts. Try again in {$minutes} minute(s).",
            ]);
        }
        
        // Rate limiting: Max 5 attempts per minute per IP
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            // Track total failed attempts
            $totalAttempts = Cache::increment($failedAttemptsKey);
            
            // Lock for 15 minutes after 10 total failures
            if ($totalAttempts >= 10) {
                Cache::put($lockoutKey, time() + 900, 900);
                Cache::forget($failedAttemptsKey);
                
                throw ValidationException::withMessages([
                    'email' => 'Account temporarily locked due to too many failed attempts. Try again in 15 minutes.',
                ]);
            }
            
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('customer')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Clear rate limiter and failed attempts on successful login
            RateLimiter::clear($throttleKey);
            Cache::forget($failedAttemptsKey);
            
            $request->session()->regenerate();
            return redirect()->intended(route('customer.index'))
                ->with('success', 'Welcome back!');
        }

        // Increment rate limiter on failed attempt
        RateLimiter::hit($throttleKey, 60);
        
        // Initialize failed attempts counter if not exists
        if (!Cache::has($failedAttemptsKey)) {
            Cache::put($failedAttemptsKey, 1, 1800);
        }

        // Redirect to unified login with error
        return redirect('/login?mode=customer')
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->withInput($request->only('email'));
    }

    /**
     * Handle customer logout
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login?mode=customer')
            ->with('success', 'You have been logged out.');
    }
}
