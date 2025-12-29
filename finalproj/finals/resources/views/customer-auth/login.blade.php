@extends('layouts.customer')

@section('title', 'Customer Login')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        {{-- Logo & Header --}}
        <div class="text-center mb-8">
            <a href="{{ route('customer.auth.login') }}" class="inline-flex items-center justify-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="JV TechHub" class="w-16 h-16 rounded-xl shadow-lg">
            </a>
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Welcome Back</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Sign in to your JV TechHub account</p>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-emerald-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-emerald-700 dark:text-emerald-300 text-sm">{{ session('success') }}</span>
            </div>
        </div>
        @endif

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

        {{-- Login Form --}}
        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-xl border border-slate-200 dark:border-dark-border p-8">
            <form method="POST" action="{{ route('customer.auth.login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                           placeholder="Enter your email">
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                           placeholder="Enter your password">
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 dark:border-dark-border text-emerald-500 focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Remember me</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-600 hover:to-cyan-600 text-white rounded-xl font-bold text-lg shadow-lg shadow-emerald-500/30 transition-all duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Sign In
                </button>
            </form>
        </div>

        {{-- Register Link --}}
        <p class="text-center mt-6 text-slate-600 dark:text-slate-400">
            Don't have an account? 
            <a href="{{ route('customer.auth.register') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                Create one
            </a>
        </p>

        {{-- Admin Login Link --}}
        <p class="text-center mt-4 text-sm text-slate-500 dark:text-slate-500">
            <a href="{{ route('login') }}" class="hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                Admin/Employee Login →
            </a>
        </p>
    </div>
</div>
@endsection
