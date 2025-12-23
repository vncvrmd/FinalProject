@php
    if (!function_exists('is_active')) {
        function is_active($routeName) {
            return request()->routeIs($routeName) 
                ? 'bg-blue-900 text-white' 
                : 'text-gray-400 hover:bg-gray-800 hover:text-white';
        }
    }
@endphp

<nav class="mt-6">
    <a href="{{ route('dashboard') }}" 
       class="flex items-center px-4 py-2 mt-2 transition-colors duration-200 transform rounded-md {{ is_active('dashboard') }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6-4l.01.01M12 10l.01.01M12 14l.01.01M12 18l.01.01M12 6l.01.01M15 10l.01.01M15 14l.01.01M15 18l.01.01M9 10l.01.01M9 14l.01.01M9 18l.01.01"></path></svg>
        <span class="ml-3">Dashboard</span>
    </a>

    {{-- USERS: Admin Only --}}
    @if(Auth::user()->role === 'admin')
    <a href="{{ route('users.index') }}" 
       class="flex items-center px-4 py-2 mt-2 transition-colors duration-200 transform rounded-md {{ is_active('users.*') }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        <span class="ml-3">Users</span>
    </a>
    @endif

    {{-- PRODUCTS & CUSTOMERS: Admin and Employee --}}
    @if(in_array(Auth::user()->role, ['admin', 'employee']))
    <a href="{{ route('products.index') }}" 
       class="flex items-center px-4 py-2 mt-2 transition-colors duration-200 transform rounded-md {{ is_active('products.*') }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h12"></path></svg>
        <span class="ml-3">Products</span>
    </a>

    <a href="{{ route('customers.index') }}" 
       class="flex items-center px-4 py-2 mt-2 transition-colors duration-200 transform rounded-md {{ is_active('customers.*') }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        <span class="ml-3">Customers</span>
    </a>
    @endif
    
    {{-- TRANSACTIONS & SALES: Visible to Everyone --}}
    <a href="{{ route('transactions.index') }}" 
       class="flex items-center px-4 py-2 mt-2 transition-colors duration-200 transform rounded-md {{ is_active('transactions.*') }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 8h16M4 12h16M4 16h16"></path></svg>
        <span class="ml-3">Transactions</span>
    </a>
    
    <a href="{{ route('sales.index') }}" 
       class="flex items-center px-4 py-2 mt-2 transition-colors duration-200 transform rounded-md {{ is_active('sales.*') }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1M11 15h1M15 15h1M3 6h18v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6z"></path></svg>
        <span class="ml-3">Sales</span>
    </a>
    
    {{-- LOGS: Admin Only --}}
    @if(Auth::user()->role === 'admin')
    <a href="{{ route('logs.index') }}" 
       class="flex items-center px-4 py-2 mt-2 transition-colors duration-200 transform rounded-md {{ is_active('logs.*') }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <span class="ml-3">Logs</span>
    </a>
    @endif

    {{-- SEPARATOR --}}
    <div class="mt-8 border-t border-gray-700 mx-4"></div>

    {{-- PROFILE: Visible to Everyone --}}
    <a href="{{ route('profile.show') }}" 
       class="flex items-center px-4 py-2 mt-4 transition-colors duration-200 transform rounded-md {{ is_active('profile.*') }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        <span class="ml-3">My Profile</span>
    </a>

    {{-- Logout Button --}}
    <form method="POST" action="{{ route('logout') }}" class="px-4 mt-2 mb-6">
        @csrf
        <button type="submit" class="flex items-center text-red-400 hover:text-red-200 transition-colors duration-200 w-full text-left">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span class="ml-3">Logout</span>
        </button>
    </form>
</nav>