@extends('layouts.customer')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        {{-- Logo & Header --}}
        <div class="text-center mb-8">
            <a href="{{ route('customer.auth.login') }}" class="inline-flex items-center justify-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="JV TechHub" class="w-16 h-16 rounded-xl shadow-lg">
            </a>
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Create Account</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Join JV TechHub and start shopping</p>
        </div>

        {{-- Error Alert --}}
        @if($errors->any())
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-red-700 dark:text-red-300 text-sm">{{ $errors->first() }}</span>
            </div>
        </div>
        @endif

        {{-- Registration Form --}}
        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-xl border border-slate-200 dark:border-dark-border p-8">
            <form method="POST" action="{{ route('customer.auth.register') }}" class="space-y-5">
                @csrf

                {{-- Full Name --}}
                <div>
                    <label for="customer_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Full Name</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required autofocus
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                           placeholder="Juan Dela Cruz">
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                           placeholder="juan@example.com">
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Phone Number</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                           placeholder="09XX XXX XXXX">
                </div>

                {{-- Address --}}
                <div>
                    <label for="address" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Delivery Address</label>
                    <textarea name="address" id="address" rows="2" required
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none"
                              placeholder="Street, Barangay, City, Province">{{ old('address') }}</textarea>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                           placeholder="Minimum 6 characters">
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                           placeholder="Re-enter your password">
                </div>

                {{-- Submit Button --}}
                <button type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-600 hover:to-cyan-600 text-white rounded-xl font-bold text-lg shadow-lg shadow-emerald-500/30 transition-all duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Create Account
                </button>
            </form>
        </div>

        {{-- Login Link --}}
        <p class="text-center mt-6 text-slate-600 dark:text-slate-400">
            Already have an account? 
            <a href="{{ route('customer.auth.login') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                Sign in
            </a>
        </p>
    </div>
</div>
@endsection
