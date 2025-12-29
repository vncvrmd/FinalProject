@extends('layouts.customer')

@section('title', 'Order Receipt')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    {{-- Success Animation --}}
    <div class="text-center mb-8 animate-bounce-in">
        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-400 to-cyan-400 rounded-full flex items-center justify-center mb-6 shadow-xl shadow-emerald-500/30">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Order Successful!</h1>
        <p class="text-slate-600 dark:text-slate-400">Thank you for your purchase</p>
    </div>

    {{-- Receipt Card --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl border border-slate-200 dark:border-dark-border shadow-xl overflow-hidden animate-slide-up">
        
        {{-- Receipt Header --}}
        <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 p-6 text-center">
            <div class="flex items-center justify-center mb-2">
                <img src="{{ asset('images/logo.png') }}" alt="JV TechHub" class="w-10 h-10 rounded-lg mr-3">
                <span class="text-xl font-bold text-white">JV TechHub</span>
            </div>
            <p class="text-emerald-100 text-sm">Customer Shopping Portal</p>
        </div>

        {{-- Transaction Details --}}
        <div class="p-6 border-b border-slate-200 dark:border-dark-border">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Transaction Number</p>
                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">#{{ str_pad($sale->sales_id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Date</p>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $sale->created_at->format('M d, Y') }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $sale->created_at->format('h:i A') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Customer</p>
                    <p class="font-semibold text-slate-900 dark:text-white">{{ $sale->customer->customer_name ?? 'Guest' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Payment Method</p>
                    <p class="font-semibold text-slate-900 dark:text-white">{{ $sale->payment_method }}</p>
                </div>
            </div>
        </div>

        {{-- Items List --}}
        <div class="p-6 border-b border-slate-200 dark:border-dark-border">
            <h3 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-4">Items Purchased</h3>
            
            <div class="space-y-3">
                @foreach($sale->transactions as $transaction)
                <div class="flex justify-between items-center py-3 border-b border-slate-100 dark:border-dark-border last:border-0">
                    <div class="flex-1">
                        <p class="font-medium text-slate-900 dark:text-white">{{ $transaction->product->product_name ?? 'Product' }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            ${{ number_format($transaction->price_at_sale, 2) }} × {{ $transaction->quantity_sold }}
                        </p>
                    </div>
                    <p class="font-semibold text-slate-900 dark:text-white">
                        ${{ number_format($transaction->price_at_sale * $transaction->quantity_sold, 2) }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Total --}}
        <div class="p-6 bg-slate-50 dark:bg-slate-800/50">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold text-slate-600 dark:text-slate-400">Total Amount</span>
                <span class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($sale->total_amount, 2) }}</span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="p-6 text-center border-t border-slate-200 dark:border-dark-border">
            <p class="text-slate-500 dark:text-slate-400 text-sm mb-1">Thank you for shopping with us!</p>
            <p class="text-xs text-slate-400 dark:text-slate-500">Keep this receipt for your records</p>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('customer.index') }}" 
           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-600 hover:to-cyan-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-500/30 transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Continue Shopping
        </a>
        <button onclick="window.print()" 
                class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-dark-card border border-slate-200 dark:border-dark-border text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-dark-hover rounded-xl font-bold transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print Receipt
        </button>
    </div>
</div>

@push('styles')
<style>
    @media print {
        header, footer, .no-print { display: none !important; }
        body { background: white !important; }
        .shadow-xl { box-shadow: none !important; }
    }
</style>
@endpush
@endsection
