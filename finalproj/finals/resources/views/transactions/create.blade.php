@extends('layouts.app')

@section('title', 'Create New Transaction')
@section('page-title', 'Create New Transaction')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Back Button --}}
    <a href="{{ route('transactions.index') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Transactions
    </a>

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 flex items-center">
            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-800 flex items-center justify-center mr-4">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-red-700 dark:text-red-300 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-dark-border overflow-hidden">
        {{-- Header --}}
        <div class="px-8 py-6 border-b border-gray-100 dark:border-dark-border bg-gradient-to-r from-[#0f2744] via-[#0a1628] to-[#0e7490]">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">New Sale</h2>
                    <p class="text-primary-100 text-sm">Create a new transaction for a customer</p>
                </div>
            </div>
        </div>

        <form action="{{ route('transactions.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="customer_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Customer</label>
                    <select name="customer_id" id="customer_id" required 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="payment_method" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Payment Method</label>
                    <select name="payment_method" id="payment_method" required 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                        <option value="cash">💵 Cash</option>
                        <option value="credit card">💳 Credit Card</option>
                    </select>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-dark-bg rounded-xl border border-gray-200 dark:border-dark-border overflow-hidden">
                <div class="px-6 py-4 bg-gray-100 dark:bg-dark-border/50 border-b border-gray-200 dark:border-dark-border">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Products
                    </h3>
                </div>
                <div class="p-6">
                    <table class="w-full" id="product-table">
                        <thead>
                            <tr class="text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <th class="pb-3">Product</th>
                                <th class="pb-3 w-32">Quantity</th>
                                <th class="pb-3 w-24">Action</th>
                            </tr>
                        </thead>
                        <tbody id="product-list" class="space-y-2">
                        </tbody>
                    </table>
                    <button type="button" onclick="addProductRow()" 
                            class="mt-4 inline-flex items-center px-4 py-2 rounded-lg bg-gray-200 dark:bg-dark-border text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-dark-border/80 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Product
                    </button>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-[#0f2744] to-[#0e7490] text-white font-semibold shadow-lg shadow-cyan-500/30 hover:shadow-xl hover:shadow-cyan-500/40 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Complete Sale
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function addProductRow() {
        const rowId = Date.now();
        const html = `
            <tr id="row-${rowId}" class="border-b border-gray-200 dark:border-dark-border">
                <td class="py-3 pr-4">
                    <select name="products[]" required 
                            class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-card text-gray-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->product_id }}">
                                {{ $product->product_name }} (Stock: {{ $product->quantity_available }} | ₱{{ number_format($product->price, 2) }})
                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="py-3 pr-4">
                    <input type="number" name="quantities[]" min="1" value="1" required 
                           class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-card text-gray-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                </td>
                <td class="py-3">
                    <button type="button" onclick="removeRow(${rowId})" 
                            class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </td>
            </tr>
        `;
        document.getElementById('product-list').insertAdjacentHTML('beforeend', html);
    }

    function removeRow(id) {
        document.getElementById(`row-${id}`).remove();
    }

    // Add one row by default
    document.addEventListener('DOMContentLoaded', addProductRow);
</script>
@endsection