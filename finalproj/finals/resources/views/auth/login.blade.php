<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', loginMode: '{{ request()->query('mode', 'customer') }}' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | JV TechHub</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#ecfeff', 100: '#cffafe', 200: '#a5f3fc', 300: '#67e8f9',
                            400: '#22d3ee', 500: '#06b6d4', 600: '#0891b2', 700: '#0e7490',
                            800: '#155e75', 900: '#164e63', 950: '#083344',
                        },
                        dark: { bg: '#020617', card: '#0f172a', border: '#1e293b' }
                    },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', system-ui, sans-serif; }
        
        /* Animated gradient background */
        .animated-bg {
            background: linear-gradient(-45deg, #0f2744, #0a1628, #0e7490, #06b6d4);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Pulse glow */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 40px rgba(6, 182, 212, 0.3); }
            50% { box-shadow: 0 0 80px rgba(6, 182, 212, 0.5); }
        }
        
        .pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen flex">
    
    {{-- Left Side - Branding with Logo as Hero --}}
    <div class="hidden lg:flex lg:w-1/2 animated-bg relative overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:40px_40px]"></div>
        <div class="absolute top-20 left-20 w-72 h-72 bg-cyan-400/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-primary-500/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
        
        {{-- Content --}}
        <div class="relative z-10 flex flex-col items-center justify-center w-full px-12">
            {{-- Large Logo as Hero --}}
            <div class="float-animation mb-8">
                <div class="w-48 h-48 xl:w-56 xl:h-56 rounded-full overflow-hidden pulse-glow border-4 border-white/20">
                    <img src="{{ asset('images/logo.png') }}" alt="JV TechHub" class="w-full h-full object-cover">
                </div>
            </div>
            
            {{-- Tagline --}}
            <div class="text-center max-w-md">
                <p class="text-cyan-100 text-xl xl:text-2xl font-light mb-2">Inventory & Sales</p>
                <p class="text-white/60 text-lg">Management System</p>
            </div>
            
            {{-- Feature Pills --}}
            <div class="flex flex-wrap justify-center gap-3 mt-12">
                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/10">
                    <svg class="w-4 h-4 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="text-white/80 text-sm font-medium">Analytics</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/10">
                    <svg class="w-4 h-4 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span class="text-white/80 text-sm font-medium">Secure</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/10">
                    <svg class="w-4 h-4 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="text-white/80 text-sm font-medium">Fast</span>
                </div>
            </div>
            
        </div>
    </div>
    
    {{-- Right Side - Login Form --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 bg-slate-50 dark:bg-dark-bg">
        <div class="w-full max-w-md" x-data="{ showPassword: false }">
            
            {{-- Mobile Logo --}}
            <div class="lg:hidden text-center mb-8">
                <div class="inline-block">
                    <div class="w-20 h-20 rounded-full overflow-hidden ring-4 ring-primary-500/30 shadow-xl shadow-primary-500/20 mx-auto mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="JV TechHub" class="w-full h-full object-cover">
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Inventory & Sales Management</p>
                </div>
            </div>
            
            {{-- Header with Dark Mode Toggle --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Welcome back</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Sign in to continue</p>
                </div>
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                        class="p-2.5 rounded-xl text-slate-500 hover:text-slate-700 bg-white dark:bg-dark-card hover:bg-slate-100 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-dark-border transition-all shadow-sm border border-slate-200 dark:border-dark-border">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>
            </div>

            {{-- Login Mode Tabs --}}
            <div class="flex mb-6 bg-slate-100 dark:bg-dark-card rounded-xl p-1 border border-slate-200 dark:border-dark-border">
                <button @click="loginMode = 'customer'" 
                        :class="loginMode === 'customer' ? 'bg-white dark:bg-dark-bg shadow-sm text-emerald-600 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
                        class="flex-1 py-2.5 px-4 rounded-lg font-medium text-sm transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Customer
                </button>
                <button @click="loginMode = 'staff'" 
                        :class="loginMode === 'staff' ? 'bg-white dark:bg-dark-bg shadow-sm text-primary-600 dark:text-primary-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
                        class="flex-1 py-2.5 px-4 rounded-lg font-medium text-sm transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Staff / Admin
                </button>
            </div>
            
            {{-- Login Card --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-dark-border p-8">
                
                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-red-700 dark:text-red-400">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <p class="text-sm text-emerald-700 dark:text-emerald-400">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                
                {{-- Customer Login Form --}}
                <form x-show="loginMode === 'customer'" method="POST" action="{{ route('customer.auth.login.post') }}" class="space-y-5">
                    @csrf
                    
                    {{-- Email Field --}}
                    <div class="space-y-2">
                        <label for="customer_email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <input type="email" id="customer_email" name="email" value="{{ old('email') }}"
                                   class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white dark:focus:bg-dark-card transition-all"
                                   placeholder="Enter your email" required>
                        </div>
                    </div>
                    
                    {{-- Password Field --}}
                    <div class="space-y-2">
                        <label for="customer_password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" id="customer_password" name="password"
                                   class="w-full pl-12 pr-12 py-3.5 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white dark:focus:bg-dark-card transition-all"
                                   placeholder="Enter your password" required>
                            <button type="button" @click="showPassword = !showPassword" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 dark:border-dark-border text-emerald-500 focus:ring-emerald-500">
                            <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Remember me</span>
                        </label>
                    </div>
                    
                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-600 hover:to-cyan-600 text-white font-semibold py-3.5 px-4 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:shadow-emerald-500/30 transform hover:-translate-y-0.5">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Sign in to Shop
                        </span>
                    </button>
                </form>

                {{-- Staff/Admin Login Form --}}
                <form x-show="loginMode === 'staff'" x-cloak method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
                    {{-- Username Field --}}
                    <div class="space-y-2">
                        <label for="username" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input type="text" id="username" name="username" value="{{ old('username') }}"
                                   class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 focus:bg-white dark:focus:bg-dark-card transition-all"
                                   placeholder="Enter your username" required>
                        </div>
                    </div>
                    
                    {{-- Password Field --}}
                    <div class="space-y-2">
                        <label for="staff_password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" id="staff_password" name="password"
                                   class="w-full pl-12 pr-12 py-3.5 rounded-xl border border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-dark-bg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 focus:bg-white dark:focus:bg-dark-card transition-all"
                                   placeholder="Enter your password" required>
                            <button type="button" @click="showPassword = !showPassword" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-[#0f2744] to-[#0e7490] hover:from-[#0a1628] hover:to-[#0891b2] text-white font-semibold py-3.5 px-4 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary-500/50 shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30 transform hover:-translate-y-0.5">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Sign in to Dashboard
                        </span>
                    </button>
                </form>
            </div>

            {{-- Register Link (Customer Only) --}}
            <div x-show="loginMode === 'customer'" class="mt-6 text-center">
                <p class="text-slate-600 dark:text-slate-400">
                    Don't have an account? 
                    <a href="{{ route('customer.auth.register') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                        Create one
                    </a>
                </p>
            </div>
            
            {{-- Footer --}}
            <div class="mt-8 text-center">
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    © {{ date('Y') }} JV TechHub. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>