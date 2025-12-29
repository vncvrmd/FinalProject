<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JV TechHub') | Inventory Management</title>
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
                        navy: {
                            50: '#f0f4ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#0a1628',
                            600: '#080f1d',
                            700: '#060b14',
                            800: '#04070d',
                            900: '#020405',
                            950: '#010203',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'slide-in': 'slideIn 0.3s ease-out',
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
                        slideIn: {
                            '0%': { opacity: '0', transform: 'translateX(-10px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
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
        
        /* Sidebar - Navy Theme matching JV TechHub logo */
        .gradient-sidebar {
            background: linear-gradient(180deg, #0f2744 0%, #0a1628 50%, #060d18 100%);
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #64748b; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #475569; }
        
        /* Animations */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        /* Animate cards on page load */
        .animate-card {
            animation: scaleIn 0.4s ease-out forwards;
            opacity: 0;
        }
        .animate-card:nth-child(1) { animation-delay: 0.05s; }
        .animate-card:nth-child(2) { animation-delay: 0.1s; }
        .animate-card:nth-child(3) { animation-delay: 0.15s; }
        .animate-card:nth-child(4) { animation-delay: 0.2s; }
        
        /* Table rows */
        .table-row-animate { animation: slideUp 0.3s ease-out forwards; opacity: 0; }
        .table-row-animate:nth-child(1) { animation-delay: 0.02s; }
        .table-row-animate:nth-child(2) { animation-delay: 0.04s; }
        .table-row-animate:nth-child(3) { animation-delay: 0.06s; }
        .table-row-animate:nth-child(4) { animation-delay: 0.08s; }
        .table-row-animate:nth-child(5) { animation-delay: 0.1s; }
        
        /* Hover lift effect */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        
        /* Chart container animation */
        .chart-container {
            animation: fadeIn 0.6s ease-out forwards;
            animation-delay: 0.3s;
            opacity: 0;
        }
    </style>
    @stack('styles')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 dark:bg-dark-bg text-slate-800 dark:text-slate-200 antialiased">
    <div x-data="{ sidebarOpen: false, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" 
         x-init="$watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val))"
         class="min-h-screen flex">
        
        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
             x-cloak></div>
        
        {{-- Sidebar --}}
        <aside 
            :class="[
                sidebarOpen ? 'translate-x-0' : '-translate-x-full',
                sidebarCollapsed ? 'lg:w-20' : 'lg:w-72'
            ]"
            class="fixed inset-y-0 left-0 z-30 w-72 gradient-sidebar transform transition-all duration-300 ease-in-out lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen shadow-2xl flex flex-col">
            
            {{-- Logo Section --}}
            <div class="flex items-center justify-between h-16 px-6 border-b border-cyan-500/20">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group" :class="{ 'justify-center w-full': sidebarCollapsed }">
                    <div class="w-10 h-10 rounded-full overflow-hidden ring-2 ring-cyan-400/40 transform group-hover:scale-110 group-hover:ring-cyan-400/60 transition-all duration-300 shadow-lg shadow-cyan-500/20">
                        <img src="{{ asset('images/logo.png') }}" alt="JV TechHub" class="w-full h-full object-cover">
                    </div>
                    <span x-show="!sidebarCollapsed" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="text-xl font-bold text-white tracking-tight">JV TechHub</span>
                </a>
                <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden lg:block text-slate-400 hover:text-cyan-400 transition-colors">
                    <svg x-show="!sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                    <svg x-show="sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            {{-- User Profile Mini --}}
            <div class="px-4 py-4 border-b border-white/10" :class="{ 'flex justify-center': sidebarCollapsed }">
                <div class="flex items-center space-x-3" :class="{ 'justify-center': sidebarCollapsed }">
                    <div class="relative">
                        @if(Auth::user()->profile_image)
                            <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white/20" 
                                 src="{{ asset('storage/' . Auth::user()->profile_image) }}" 
                                 alt="{{ Auth::user()->full_name }}">
                        @else
                            <div class="h-10 w-10 rounded-full ring-2 ring-cyan-400/30 bg-gradient-to-br from-[#0f2744] to-[#0e7490] flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
                            </div>
                        @endif
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 border-2 border-primary-900 rounded-full"></span>
                    </div>
                    <div x-show="!sidebarCollapsed" x-transition class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->full_name }}</p>
                        <p class="text-xs text-primary-200 truncate">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                </div>
            </div>

            @include('layouts.sidebar')
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Header --}}
            <header class="glass dark:bg-dark-card/80 border-b border-gray-200/50 dark:border-dark-border sticky top-0 z-20">
                <div class="flex justify-between items-center h-16 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center space-x-4">
                        <button @click.stop="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-dark-hover transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white animate-fade-in">
                                @yield('page-title')
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 hidden sm:block">Welcome back, {{ Auth::user()->full_name }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        {{-- Dark Mode Toggle --}}
                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                                class="relative p-2 rounded-xl bg-gray-100 dark:bg-dark-hover text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-300 group">
                            <svg x-show="!darkMode" x-transition:enter="transition-transform duration-300" x-transition:enter-start="rotate-90 opacity-0" x-transition:enter-end="rotate-0 opacity-100" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg x-show="darkMode" x-transition:enter="transition-transform duration-300" x-transition:enter-start="-rotate-90 opacity-0" x-transition:enter-end="rotate-0 opacity-100" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="absolute -bottom-8 left-1/2 -translate-x-1/2 px-2 py-1 bg-gray-900 dark:bg-gray-700 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                Toggle theme
                            </span>
                        </button>
                        
                        {{-- Notifications --}}
                        <div x-data="notificationDropdown()" class="relative">
                            <button @click="open = !open" type="button" class="relative p-2 rounded-xl bg-gray-100 dark:bg-dark-hover text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span x-show="notifications.length > 0" class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                            </button>
                            
                            {{-- Notifications Dropdown --}}
                            <div x-show="open" 
                                 x-cloak
                                 @click.outside="open = false"
                                 @keydown.escape.window="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 rounded-2xl bg-white dark:bg-dark-card shadow-2xl ring-1 ring-black/5 dark:ring-white/10 overflow-hidden z-50">
                                
                                {{-- Header --}}
                                <div class="px-4 py-3 bg-gradient-to-r from-[#0f2744] to-[#0e7490]">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-bold text-white">Notifications</h3>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-0.5 text-xs font-semibold bg-cyan-400/30 text-white rounded-full" x-text="notifications.length"></span>
                                            <button @click="open = false" class="p-1 rounded-lg hover:bg-white/20 text-white transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Notifications List --}}
                                <div class="max-h-80 overflow-y-auto">
                                    <template x-if="notifications.length === 0">
                                        <div class="px-4 py-8 text-center">
                                            <div class="w-12 h-12 mx-auto rounded-full bg-gray-100 dark:bg-dark-bg flex items-center justify-center mb-3">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">No new notifications</p>
                                        </div>
                                    </template>
                                    
                                    <template x-for="(notification, index) in notifications" :key="index">
                                        <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors border-b border-gray-100 dark:border-dark-border last:border-0">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0 mt-0.5">
                                                    <div :class="{
                                                        'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400': notification.type === 'danger',
                                                        'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400': notification.type === 'warning',
                                                        'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400': notification.type === 'success',
                                                        'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400': notification.type === 'info'
                                                    }" class="w-8 h-8 rounded-lg flex items-center justify-center">
                                                        <template x-if="notification.icon === 'outofstock'">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                            </svg>
                                                        </template>
                                                        <template x-if="notification.icon === 'stock'">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                            </svg>
                                                        </template>
                                                        <template x-if="notification.icon === 'sale'">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        </template>
                                                        <template x-if="notification.icon === 'transaction'">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                            </svg>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="notification.title"></p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate" x-text="notification.message"></p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1" x-text="notification.time"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                
                                {{-- Footer --}}
                                <div class="px-4 py-3 bg-gray-50 dark:bg-dark-bg border-t border-gray-100 dark:border-dark-border">
                                    <button @click="clearAll()" type="button" class="w-full text-center text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                                        Clear all notifications
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Profile Dropdown --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 p-1.5 rounded-xl hover:bg-gray-100 dark:hover:bg-dark-hover transition-colors">
                                @if(Auth::user()->profile_image)
                                    <img class="h-8 w-8 rounded-lg object-cover ring-2 ring-cyan-500/30" 
                                         src="{{ asset('storage/' . Auth::user()->profile_image) }}" 
                                         alt="{{ Auth::user()->full_name }}">
                                @else
                                    <div class="h-8 w-8 rounded-lg ring-2 ring-cyan-500/30 bg-gradient-to-br from-[#0f2744] to-[#0e7490] flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                 class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-dark-card shadow-xl ring-1 ring-black/5 dark:ring-white/10 py-2 z-50">
                                <div class="px-4 py-3 border-b border-gray-100 dark:border-dark-border">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->full_name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    My Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
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
            </header>

            {{-- Main Content Area --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 dark:bg-dark-bg">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in">
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            <footer class="bg-white dark:bg-dark-card border-t border-slate-200 dark:border-dark-border py-4 px-6">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                    <p>&copy; {{ date('Y') }} JV TechHub. All rights reserved.</p>
                    <p class="text-xs">Inventory & Sales Management System</p>
                </div>
            </footer>
        </div>
        
        {{-- Mobile Sidebar Overlay --}}
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-20 bg-gray-900/50 backdrop-blur-sm lg:hidden" 
             x-cloak></div>
    </div>

    {{-- Toast Notifications Container --}}
    <div x-data="{ notifications: [] }" 
         @notify.window="notifications.push({id: Date.now(), message: $event.detail.message, type: $event.detail.type}); setTimeout(() => notifications.shift(), 5000)"
         class="fixed bottom-4 right-4 z-50 space-y-2">
        <template x-for="notification in notifications" :key="notification.id">
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 :class="{
                     'bg-green-500': notification.type === 'success',
                     'bg-red-500': notification.type === 'error',
                     'bg-blue-500': notification.type === 'info'
                 }"
                 class="px-6 py-3 rounded-xl text-white shadow-lg">
                <span x-text="notification.message"></span>
            </div>
        </template>
    </div>

    <script>
        function notificationDropdown() {
            return {
                open: false,
                notifications: [
                    @if(isset($outOfStockProducts) && $outOfStockProducts->count() > 0)
                        @foreach($outOfStockProducts->take(2) as $product)
                            { type: 'danger', icon: 'outofstock', title: 'Out of Stock!', message: '{{ addslashes($product->product_name) }} is out of stock', time: 'Urgent' },
                        @endforeach
                    @endif
                    @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                        @foreach($lowStockProducts->take(3) as $product)
                            { type: 'warning', icon: 'stock', title: 'Low Stock Alert', message: '{{ addslashes($product->product_name) }} has only {{ $product->quantity_available }} items left', time: 'Action needed' },
                        @endforeach
                    @endif
                    @if(isset($recentSales) && $recentSales->count() > 0)
                        @foreach($recentSales->take(2) as $sale)
                            { type: 'success', icon: 'sale', title: 'New Sale', message: 'Sale #{{ $sale->sales_id }} - {{ format_peso($sale->total_amount) }}', time: '{{ $sale->created_at->diffForHumans() }}' },
                        @endforeach
                    @endif
                    @if(isset($todayTransactions) && $todayTransactions > 0)
                        { type: 'info', icon: 'transaction', title: "Today's Activity", message: '{{ $todayTransactions }} transactions processed today', time: 'Today' },
                    @endif
                ],
                clearAll() {
                    this.notifications = [];
                    this.open = false;
                }
            }
        }
    </script>
    
    @stack('scripts')

</body>
</html>