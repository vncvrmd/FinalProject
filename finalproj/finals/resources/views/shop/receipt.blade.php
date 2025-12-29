@extends('layouts.app')

@section('title', 'Sale Receipt')
@section('page-title', 'Sale Complete')

@section('content')
<div class="max-w-2xl mx-auto">
    
    {{-- Success Animation --}}
    <div class="text-center mb-8 animate-fade-in">
        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-400 to-cyan-400 rounded-full flex items-center justify-center mb-6 shadow-xl shadow-emerald-500/30">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Sale Complete!</h1>
        <p class="text-slate-600 dark:text-slate-400">Transaction has been recorded successfully</p>
    </div>

    {{-- Receipt Card --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl border border-slate-200 dark:border-dark-border shadow-xl overflow-hidden animate-slide-up">
        
        {{-- Receipt Header --}}
        <div class="bg-gradient-to-r from-[#0f2744] to-[#0e7490] p-6 text-center">
            <div class="flex items-center justify-center mb-2">
                <img src="{{ asset('images/logo.png') }}" alt="JV TechHub" class="w-10 h-10 rounded-lg mr-3">
                <span class="text-xl font-bold text-white">JV TechHub</span>
            </div>
            <p class="text-cyan-100 text-sm">Point of Sale Receipt</p>
        </div>

        {{-- Transaction Details --}}
        <div class="p-6 border-b border-slate-200 dark:border-dark-border">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Transaction Number</p>
                    <p class="text-2xl font-bold text-primary-600 dark:text-primary-400">#{{ str_pad($sale->sales_id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Date</p>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $sale->created_at->format('M d, Y') }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $sale->created_at->format('h:i A') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Customer</p>
                    <p class="font-semibold text-slate-900 dark:text-white">{{ $sale->customer->customer_name ?? 'Guest' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Payment Method</p>
                    <p class="font-semibold text-slate-900 dark:text-white">{{ $sale->payment_method }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Cashier</p>
                    <p class="font-semibold text-slate-900 dark:text-white">{{ Auth::user()->full_name }}</p>
                </div>
            </div>
        </div>

        {{-- Items List --}}
        <div class="p-6 border-b border-slate-200 dark:border-dark-border">
            <h3 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-4">Items Sold</h3>
            
            <div class="space-y-3">
                @foreach($sale->transactions as $transaction)
                <div class="flex justify-between items-center py-3 border-b border-slate-100 dark:border-dark-border last:border-0">
                    <div class="flex-1">
                        <p class="font-medium text-slate-900 dark:text-white">{{ $transaction->product->product_name ?? 'Product' }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            ₱{{ number_format($transaction->price_at_sale, 2) }} × {{ $transaction->quantity_sold }}
                        </p>
                    </div>
                    <p class="font-semibold text-slate-900 dark:text-white">
                        ₱{{ number_format($transaction->price_at_sale * $transaction->quantity_sold, 2) }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Total --}}
        <div class="p-6 bg-slate-50 dark:bg-slate-800/50">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold text-slate-600 dark:text-slate-400">Total Amount</span>
                <span class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($sale->total_amount, 2) }}</span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="p-6 text-center border-t border-slate-200 dark:border-dark-border">
            <p class="text-slate-500 dark:text-slate-400 text-sm mb-1">Thank you for your business!</p>
            <p class="text-xs text-slate-400 dark:text-slate-500">JV TechHub - Inventory & Sales Management</p>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center no-print">
        <a href="{{ route('shop.index') }}" 
           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-[#0f2744] to-[#0e7490] hover:from-[#0a1628] hover:to-[#0891b2] text-white rounded-xl font-bold shadow-lg shadow-primary-500/30 transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            New Sale
        </a>
        <button onclick="window.print()" 
                class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-dark-card border border-slate-200 dark:border-dark-border text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-dark-hover rounded-xl font-bold transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print Receipt
        </button>
        <a href="{{ route('sales.index') }}" 
           class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-dark-card border border-slate-200 dark:border-dark-border text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-dark-hover rounded-xl font-bold transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Sales
        </a>
        <a href="{{ route('transactions.index') }}" 
           class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-dark-card border border-slate-200 dark:border-dark-border text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-dark-hover rounded-xl font-bold transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Transactions
        </a>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .no-print, header, aside, footer { display: none !important; }
        body { background: white !important; }
        .shadow-xl { box-shadow: none !important; }
        .max-w-2xl { max-width: 100% !important; margin: 0 !important; }
    }
</style>
@endpush
@endsection
