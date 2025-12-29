@php
    if (!function_exists('is_active')) {
        function is_active($routeName) {
            return request()->routeIs($routeName);
        }
    }
@endphp

<nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto" x-data="{ activeSection: null }">
    {{-- Navigation Label --}}
    <p x-show="!sidebarCollapsed" class="px-3 text-xs font-semibold text-primary-200/60 uppercase tracking-wider mb-4">Main Menu</p>
    
    {{-- Dashboard --}}
    <a href="{{ route('dashboard') }}" 
       class="nav-item group flex items-center px-3 py-2.5 rounded-xl transition-all duration-300 
              {{ is_active('dashboard') ? 'bg-white/20 text-white shadow-lg shadow-primary-500/20' : 'text-primary-100 hover:bg-white/10 hover:text-white' }}"
       :class="{ 'justify-center': sidebarCollapsed }">
        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ is_active('dashboard') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-all duration-300">
            <svg class="w-5 h-5 {{ is_active('dashboard') ? 'text-white' : 'text-primary-300 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <span x-show="!sidebarCollapsed" x-transition class="ml-3 font-medium">Dashboard</span>
        @if(is_active('dashboard'))
            <span x-show="!sidebarCollapsed" class="ml-auto w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        @endif
    </a>

    {{-- USERS: Admin Only --}}
    @if(Auth::user()->role === 'admin')
    <a href="{{ route('users.index') }}" 
       class="nav-item group flex items-center px-3 py-2.5 rounded-xl transition-all duration-300 
              {{ is_active('users.*') ? 'bg-white/20 text-white shadow-lg shadow-primary-500/20' : 'text-primary-100 hover:bg-white/10 hover:text-white' }}"
       :class="{ 'justify-center': sidebarCollapsed }">
        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ is_active('users.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-all duration-300">
            <svg class="w-5 h-5 {{ is_active('users.*') ? 'text-white' : 'text-primary-300 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <span x-show="!sidebarCollapsed" x-transition class="ml-3 font-medium">Users</span>
        @if(is_active('users.*'))
            <span x-show="!sidebarCollapsed" class="ml-auto w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        @endif
    </a>
    @endif

    {{-- PRODUCTS & CUSTOMERS: Admin and Employee --}}
    @if(in_array(Auth::user()->role, ['admin', 'employee']))
    
    {{-- Navigation Label --}}
    <p x-show="!sidebarCollapsed" class="px-3 pt-4 text-xs font-semibold text-primary-200/60 uppercase tracking-wider mb-2">Inventory</p>
    
    <a href="{{ route('products.index') }}" 
       class="nav-item group flex items-center px-3 py-2.5 rounded-xl transition-all duration-300 
              {{ is_active('products.*') ? 'bg-white/20 text-white shadow-lg shadow-primary-500/20' : 'text-primary-100 hover:bg-white/10 hover:text-white' }}"
       :class="{ 'justify-center': sidebarCollapsed }">
        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ is_active('products.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-all duration-300">
            <svg class="w-5 h-5 {{ is_active('products.*') ? 'text-white' : 'text-primary-300 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <span x-show="!sidebarCollapsed" x-transition class="ml-3 font-medium">Products</span>
        @if(is_active('products.*'))
            <span x-show="!sidebarCollapsed" class="ml-auto w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        @endif
    </a>

    <a href="{{ route('customers.index') }}" 
       class="nav-item group flex items-center px-3 py-2.5 rounded-xl transition-all duration-300 
              {{ is_active('customers.*') ? 'bg-white/20 text-white shadow-lg shadow-primary-500/20' : 'text-primary-100 hover:bg-white/10 hover:text-white' }}"
       :class="{ 'justify-center': sidebarCollapsed }">
        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ is_active('customers.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-all duration-300">
            <svg class="w-5 h-5 {{ is_active('customers.*') ? 'text-white' : 'text-primary-300 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <span x-show="!sidebarCollapsed" x-transition class="ml-3 font-medium">Customers</span>
        @if(is_active('customers.*'))
            <span x-show="!sidebarCollapsed" class="ml-auto w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        @endif
    </a>
    @endif
    
    {{-- TRANSACTIONS & SALES: Visible to Everyone --}}
    <p x-show="!sidebarCollapsed" class="px-3 pt-4 text-xs font-semibold text-primary-200/60 uppercase tracking-wider mb-2">Sales</p>
    
    <a href="{{ route('transactions.index') }}" 
       class="nav-item group flex items-center px-3 py-2.5 rounded-xl transition-all duration-300 
              {{ is_active('transactions.*') ? 'bg-white/20 text-white shadow-lg shadow-primary-500/20' : 'text-primary-100 hover:bg-white/10 hover:text-white' }}"
       :class="{ 'justify-center': sidebarCollapsed }">
        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ is_active('transactions.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-all duration-300">
            <svg class="w-5 h-5 {{ is_active('transactions.*') ? 'text-white' : 'text-primary-300 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
        </div>
        <span x-show="!sidebarCollapsed" x-transition class="ml-3 font-medium">Transactions</span>
        @if(is_active('transactions.*'))
            <span x-show="!sidebarCollapsed" class="ml-auto w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        @endif
    </a>
    
    <a href="{{ route('sales.index') }}" 
       class="nav-item group flex items-center px-3 py-2.5 rounded-xl transition-all duration-300 
              {{ is_active('sales.*') ? 'bg-white/20 text-white shadow-lg shadow-primary-500/20' : 'text-primary-100 hover:bg-white/10 hover:text-white' }}"
       :class="{ 'justify-center': sidebarCollapsed }">
        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ is_active('sales.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-all duration-300">
            <svg class="w-5 h-5 {{ is_active('sales.*') ? 'text-white' : 'text-primary-300 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <span x-show="!sidebarCollapsed" x-transition class="ml-3 font-medium">Sales</span>
        @if(is_active('sales.*'))
            <span x-show="!sidebarCollapsed" class="ml-auto w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        @endif
    </a>
    
    {{-- LOGS: Admin Only --}}
    @if(Auth::user()->role === 'admin')
    <p x-show="!sidebarCollapsed" class="px-3 pt-4 text-xs font-semibold text-primary-200/60 uppercase tracking-wider mb-2">System</p>
    
    <a href="{{ route('logs.index') }}" 
       class="nav-item group flex items-center px-3 py-2.5 rounded-xl transition-all duration-300 
              {{ is_active('logs.*') ? 'bg-white/20 text-white shadow-lg shadow-primary-500/20' : 'text-primary-100 hover:bg-white/10 hover:text-white' }}"
       :class="{ 'justify-center': sidebarCollapsed }">
        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ is_active('logs.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-all duration-300">
            <svg class="w-5 h-5 {{ is_active('logs.*') ? 'text-white' : 'text-primary-300 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <span x-show="!sidebarCollapsed" x-transition class="ml-3 font-medium">System Logs</span>
        @if(is_active('logs.*'))
            <span x-show="!sidebarCollapsed" class="ml-auto w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        @endif
    </a>
    @endif
</nav>

{{-- Bottom Section --}}
<div class="px-3 py-4 border-t border-white/10">
    {{-- PROFILE: Visible to Everyone --}}
    <a href="{{ route('profile.show') }}" 
       class="nav-item group flex items-center px-3 py-2.5 rounded-xl transition-all duration-300 
              {{ is_active('profile.*') ? 'bg-white/20 text-white shadow-lg shadow-primary-500/20' : 'text-primary-100 hover:bg-white/10 hover:text-white' }}"
       :class="{ 'justify-center': sidebarCollapsed }">
        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ is_active('profile.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }} transition-all duration-300">
            <svg class="w-5 h-5 {{ is_active('profile.*') ? 'text-white' : 'text-primary-300 group-hover:text-white' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <span x-show="!sidebarCollapsed" x-transition class="ml-3 font-medium">Settings</span>
    </a>

    {{-- Logout Button --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button type="submit" 
                class="nav-item group flex items-center w-full px-3 py-2.5 rounded-xl transition-all duration-300 text-red-300 hover:bg-red-500/20 hover:text-red-200"
                :class="{ 'justify-center': sidebarCollapsed }">
            <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-red-500/10 group-hover:bg-red-500/20 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>
            <span x-show="!sidebarCollapsed" x-transition class="ml-3 font-medium">Logout</span>
        </button>
    </form>
</div>