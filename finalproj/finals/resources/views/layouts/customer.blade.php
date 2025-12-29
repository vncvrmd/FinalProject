<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Customer Portal') | JV TechHub</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#ecfeff',
                            100: '#cffafe',
                            200: '#a5f3fc',
                            300: '#67e8f9',
                            400: '#22d3ee',
                            500: '#06b6d4',
                            600: '#0891b2',
                            700: '#0e7490',
                            800: '#155e75',
                            900: '#164e63',
                            950: '#083344',
                        },
                        dark: {
                            bg: '#020617',
                            card: '#0f172a',
                            border: '#1e293b',
                            hover: '#334155',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'bounce-in': 'bounceIn 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        bounceIn: {
                            '0%': { opacity: '0', transform: 'scale(0.9)' },
                            '50%': { transform: 'scale(1.02)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                    }
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
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #64748b; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #475569; }
        
        /* Card hover animation */
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }
    </style>
    @stack('styles')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-cyan-50 dark:from-dark-bg dark:via-slate-900 dark:to-slate-800 text-slate-800 dark:text-slate-200 antialiased min-h-screen">
    
    {{-- Customer Portal Header --}}
    <header class="sticky top-0 z-50 bg-white/80 dark:bg-dark-card/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-dark-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo & Brand --}}
                <a href="{{ route('customer.index') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl overflow-hidden ring-2 ring-emerald-400/30 transform group-hover:scale-105 transition-all duration-300 shadow-lg shadow-emerald-500/10">
                        <img src="{{ asset('images/logo.png') }}" alt="JV TechHub" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <span class="text-xl font-bold bg-gradient-to-r from-emerald-600 to-cyan-600 bg-clip-text text-transparent">JV TechHub</span>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Customer Portal</p>
                    </div>
                </a>

                {{-- Right Actions --}}
                <div class="flex items-center space-x-4">
                    {{-- Dark Mode Toggle --}}
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                            class="p-2 rounded-xl bg-slate-100 dark:bg-dark-hover text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 transition-all duration-300">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    {{-- Back to Admin Button --}}
                    <a href="{{ route('dashboard') }}" 
                       class="hidden sm:flex items-center px-4 py-2 rounded-xl bg-slate-100 dark:bg-dark-hover text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 transition-all duration-300 text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Dashboard
                    </a>

                    {{-- User Menu --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-dark-hover transition-colors">
                            @if(Auth::user()->profile_image)
                                <img class="h-8 w-8 rounded-lg object-cover ring-2 ring-emerald-500/30" 
                                     src="{{ asset('storage/' . Auth::user()->profile_image) }}" 
                                     alt="{{ Auth::user()->full_name }}">
                            @else
                                <div class="h-8 w-8 rounded-lg ring-2 ring-emerald-500/30 bg-gradient-to-br from-emerald-500 to-cyan-500 flex items-center justify-center">
                                    <span class="text-white font-bold text-xs">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
                                </div>
                            @endif
                            <span class="hidden sm:block text-sm font-medium text-slate-700 dark:text-slate-300">{{ Auth::user()->full_name }}</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 rounded-xl bg-white dark:bg-dark-card shadow-xl ring-1 ring-black/5 dark:ring-white/10 py-1 z-50">
                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-dark-hover">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="min-h-[calc(100vh-8rem)]">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white dark:bg-dark-card border-t border-slate-200 dark:border-dark-border py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <p>&copy; {{ date('Y') }} JV TechHub. All rights reserved.</p>
                <p class="text-xs">Customer Shopping Portal</p>
            </div>
        </div>
    </footer>

    {{-- Toast Notifications --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-4 right-4 z-50 px-6 py-3 rounded-xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/30 flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         class="fixed bottom-4 right-4 z-50 px-6 py-3 rounded-xl bg-red-500 text-white shadow-lg shadow-red-500/30 flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    @stack('scripts')
</body>
</html>
