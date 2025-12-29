@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        {{-- Welcome Banner --}}
        <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-[#0f2744] via-[#0a1628] to-[#0e7490] p-6 lg:p-8">
            <div class="absolute inset-0 bg-grid-white/[0.03] bg-[length:20px_20px]"></div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-cyan-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-1/4 w-60 h-60 bg-cyan-400/10 rounded-full blur-3xl"></div>
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold text-white">Welcome back, {{ Auth::user()->full_name }}!</h2>
                    <p class="text-cyan-100/80 mt-1">Here's what's happening with your inventory today.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-primary-700 rounded-lg font-medium text-sm hover:bg-cyan-50 transition-colors shadow-lg shadow-cyan-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        New Sale
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            @if(in_array(strtolower(Auth::user()->role ?? ''), ['admin', 'employee']))
            {{-- Products Card --}}
            <div class="animate-card hover-lift bg-white dark:bg-dark-card rounded-xl p-5 border border-slate-200 dark:border-dark-border">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-full">Active</span>
                </div>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $products->count() }}</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Products</p>
            </div>

            {{-- Customers Card --}}
            <div class="animate-card hover-lift bg-white dark:bg-dark-card rounded-xl p-5 border border-slate-200 dark:border-dark-border">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-full">Growing</span>
                </div>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $customers->count() }}</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Customers</p>
            </div>
            @endif

            {{-- Transactions Card --}}
            <div class="animate-card hover-lift bg-white dark:bg-dark-card rounded-xl p-5 border border-slate-200 dark:border-dark-border">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-full">Recorded</span>
                </div>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $transactions->count() }}</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">Transactions</p>
            </div>

            {{-- Sales Card --}}
            <div class="animate-card hover-lift bg-white dark:bg-dark-card rounded-xl p-5 border border-slate-200 dark:border-dark-border">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 px-2 py-1 rounded-full">Complete</span>
                </div>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $sales->count() }}</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Sales</p>
            </div>
        </div>

        {{-- Charts Section - Compact Layout --}}
        @if(in_array(strtolower(Auth::user()->role ?? ''), ['admin', 'employee']))
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Sales Trend Chart --}}
            <div class="col-span-2 chart-container bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Sales Overview</h3>
                    <span class="flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                        <span class="w-2 h-2 rounded-full bg-primary-500"></span>
                        Revenue
                    </span>
                </div>
                <div class="h-40">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Payment Methods Donut --}}
            <div class="chart-container bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border p-4">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-3">Payment Methods</h3>
                <div class="h-40 flex items-center justify-center">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>

            {{-- Product Stock Chart --}}
            <div class="chart-container bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border p-4">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-3">Inventory Status</h3>
                <div class="h-40">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
        </div>
        @endif

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- USERS: Visible only to Admin --}}
            @if(strtolower(Auth::user()->role ?? '') === 'admin')
            <div class="animate-card hover-lift bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 dark:border-dark-border flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h2 class="font-semibold text-slate-900 dark:text-white">Users</h2>
                    </div>
                    <a href="{{ route('users.index') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 text-sm font-medium">View all →</a>
                </div>
                <div class="max-h-64 overflow-y-auto divide-y divide-slate-100 dark:divide-dark-border">
                    @forelse($users as $user)
                    <div class="px-5 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <img class="h-9 w-9 rounded-lg object-cover" src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->full_name) . '&background=0ea5e9&color=fff' }}" alt="">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $user->full_name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->username }}</p>
                            </div>
                            <span class="px-2 py-0.5 text-xs font-medium rounded {{ $user->role === 'admin' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="px-5 py-8 text-center text-slate-500 dark:text-slate-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <p class="text-sm">No users found</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif

            {{-- PRODUCTS: Visible to Admin and Employee --}}
            @if(in_array(strtolower(Auth::user()->role ?? ''), ['admin', 'employee']))
            <div class="animate-card hover-lift bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 dark:border-dark-border flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h2 class="font-semibold text-slate-900 dark:text-white">Products</h2>
                    </div>
                    <a href="{{ route('products.index') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 text-sm font-medium">View all →</a>
                </div>
                <div class="max-h-64 overflow-y-auto divide-y divide-slate-100 dark:divide-dark-border">
                    @forelse($products as $product)
                    <div class="px-5 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center overflow-hidden">
                                @if($product->product_image)
                                    <img src="{{ asset('storage/' . $product->product_image) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $product->product_name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Stock: {{ $product->quantity_available }}</p>
                            </div>
                            <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">{{ format_peso($product->price) }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="px-5 py-8 text-center text-slate-500 dark:text-slate-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p class="text-sm">No products found</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- CUSTOMERS: Visible to Admin and Employee --}}
            <div class="animate-card hover-lift bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 dark:border-dark-border flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h2 class="font-semibold text-slate-900 dark:text-white">Customers</h2>
                    </div>
                    <a href="{{ route('customers.index') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 text-sm font-medium">View all →</a>
                </div>
                <div class="max-h-64 overflow-y-auto divide-y divide-slate-100 dark:divide-dark-border">
                    @forelse($customers as $customer)
                    <div class="px-5 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#0f2744] to-[#0e7490] flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr($customer->customer_name, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $customer->customer_name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $customer->contact_information }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="px-5 py-8 text-center text-slate-500 dark:text-slate-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-sm">No customers found</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>

        {{-- Full Width Sections --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- TRANSACTIONS: Visible to Everyone --}}
            <div class="animate-card hover-lift bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 dark:border-dark-border flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h2 class="font-semibold text-slate-900 dark:text-white">Recent Transactions</h2>
                    </div>
                    <a href="{{ route('transactions.index') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 text-sm font-medium">View all →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-800/50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">ID</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Customer</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Product</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Qty</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-dark-border">
                            @forelse($transactions as $transaction)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-5 py-3 text-sm text-slate-500 dark:text-slate-400">#{{ $transaction->transaction_id }}</td>
                                <td class="px-5 py-3 text-sm font-medium text-slate-900 dark:text-white">{{ $transaction->sale->customer->customer_name ?? 'N/A' }}</td>
                                <td class="px-5 py-3 text-sm text-slate-600 dark:text-slate-300">{{ $transaction->product->product_name ?? 'N/A' }}</td>
                                <td class="px-5 py-3">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ $transaction->quantity_sold }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-sm text-slate-500 dark:text-slate-400">No transactions found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SALES: Visible to Everyone --}}
            <div class="animate-card hover-lift bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 dark:border-dark-border flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="font-semibold text-slate-900 dark:text-white">Recent Sales</h2>
                    </div>
                    <a href="{{ route('sales.index') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 text-sm font-medium">View all →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-800/50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">ID</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Total</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Payment</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-dark-border">
                            @forelse($sales as $sale)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-5 py-3 text-sm text-slate-500 dark:text-slate-400">#{{ $sale->sales_id }}</td>
                                <td class="px-5 py-3 text-sm font-semibold text-emerald-600 dark:text-emerald-400">{{ format_peso($sale->total_amount) }}</td>
                                <td class="px-5 py-3">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded {{ strtolower($sale->payment_method) == 'cash' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' }}">
                                        {{ ucfirst($sale->payment_method) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-sm text-slate-500 dark:text-slate-400">No sales found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- LOGS: Visible only to Admin --}}
        @if(strtolower(Auth::user()->role ?? '') === 'admin')
        <div class="animate-card hover-lift bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-dark-border flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h2 class="font-semibold text-slate-900 dark:text-white">System Logs</h2>
                </div>
                <a href="{{ route('logs.index') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 text-sm font-medium">View all →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">User</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Action</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-dark-border">
                        @forelse($logs ?? [] as $log)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img class="h-8 w-8 rounded-lg object-cover" src="{{ $log->profile_image ? asset('storage/' . $log->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($log->full_name ?? 'System') . '&background=0ea5e9&color=fff' }}" alt="">
                                    <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $log->full_name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-sm text-slate-600 dark:text-slate-300">{{ $log->action }}</td>
                            <td class="px-5 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $log->date_time->format('M d, Y h:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-sm text-slate-500 dark:text-slate-400">No logs found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    
    // Chart.js default configuration
    Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
    Chart.defaults.color = isDark ? '#94a3b8' : '#64748b';
    
    // Primary colors for charts - matching JV TechHub theme (Cyan/Teal)
    const primaryColor = '#06b6d4';
    const primaryColorLight = 'rgba(6, 182, 212, 0.15)';
    
    // Grid color based on theme
    const gridColor = isDark ? 'rgba(148, 163, 184, 0.1)' : 'rgba(148, 163, 184, 0.2)';
    
    // Animation configuration
    const delayBetweenPoints = 50;
    const previousY = (ctx) => ctx.index === 0 ? ctx.chart.scales.y.getPixelForValue(100) : ctx.chart.getDatasetMeta(ctx.datasetIndex).data[ctx.index - 1].getProps(['y'], true).y;
    
    @if(in_array(strtolower(Auth::user()->role ?? ''), ['admin', 'employee']))
    // Sales Trend Chart
    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
        // Generate sample data (in real app, this would come from backend)
        const salesData = @json($sales->groupBy(function($sale) {
            return $sale->created_at->format('M');
        })->map->sum('total_amount')->values());
        
        const salesLabels = @json($sales->groupBy(function($sale) {
            return $sale->created_at->format('M');
        })->keys());
        
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: salesLabels.length ? salesLabels : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: salesData.length ? salesData : [0, 0, 0, 0, 0, 0],
                    borderColor: primaryColor,
                    backgroundColor: primaryColorLight,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: primaryColor,
                    pointBorderColor: isDark ? '#1e293b' : '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    x: {
                        type: 'number',
                        easing: 'easeOutQuart',
                        duration: 1000,
                        from: NaN,
                        delay(ctx) {
                            return ctx.index * delayBetweenPoints;
                        }
                    },
                    y: {
                        type: 'number',
                        easing: 'easeOutQuart',
                        duration: 1000,
                        from: previousY,
                        delay(ctx) {
                            return ctx.index * delayBetweenPoints;
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: isDark ? '#1e293b' : '#ffffff',
                        titleColor: isDark ? '#f1f5f9' : '#0f172a',
                        bodyColor: isDark ? '#94a3b8' : '#64748b',
                        borderColor: isDark ? '#334155' : '#e2e8f0',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            color: gridColor
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Stock Chart - Horizontal bar for compact display
    const stockCtx = document.getElementById('stockChart');
    if (stockCtx) {
        const products = @json($products->take(4)->pluck('product_name'));
        const stock = @json($products->take(4)->pluck('quantity_available'));
        
        new Chart(stockCtx, {
            type: 'bar',
            data: {
                labels: products.length ? products.map(p => p.length > 10 ? p.substring(0, 10) + '...' : p) : ['No data'],
                datasets: [{
                    label: 'Stock',
                    data: stock.length ? stock : [0],
                    backgroundColor: 'rgba(14, 165, 233, 0.8)',
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart',
                    delay(ctx) {
                        return ctx.dataIndex * 150;
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: isDark ? '#1e293b' : '#ffffff',
                        titleColor: isDark ? '#f1f5f9' : '#0f172a',
                        bodyColor: isDark ? '#94a3b8' : '#64748b',
                        borderColor: isDark ? '#334155' : '#e2e8f0',
                        borderWidth: 1,
                        padding: 8
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: gridColor
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // Payment Methods Chart
    const paymentCtx = document.getElementById('paymentChart');
    if (paymentCtx) {
        const paymentMethods = @json($sales->groupBy('payment_method')->map->count());
        const labels = Object.keys(paymentMethods);
        const data = Object.values(paymentMethods);
        
        new Chart(paymentCtx, {
            type: 'doughnut',
            data: {
                labels: labels.length ? labels.map(l => l.charAt(0).toUpperCase() + l.slice(1)) : ['Cash', 'Card', 'Other'],
                datasets: [{
                    data: data.length ? data : [60, 30, 10],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 8,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: 10
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: isDark ? '#1e293b' : '#ffffff',
                        titleColor: isDark ? '#f1f5f9' : '#0f172a',
                        bodyColor: isDark ? '#94a3b8' : '#64748b',
                        borderColor: isDark ? '#334155' : '#e2e8f0',
                        borderWidth: 1,
                        padding: 8
                    }
                }
            }
        });
    }
    @endif
});
</script>
@endpush