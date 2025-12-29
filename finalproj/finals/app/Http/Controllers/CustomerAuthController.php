<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        $customer = Customer::create([
            'customer_name' => $request->customer_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact_information' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('customer')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('customer.index'))
                ->with('success', 'Welcome back!');
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
