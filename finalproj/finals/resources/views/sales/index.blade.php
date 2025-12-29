@extends('layouts.app')

@section('title', 'Sales')
@section('page-title', 'Sales History')

@section('content')
<div class="space-y-6">
    {{-- Header Card --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-dark-border p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#0f2744] to-[#0e7490] flex items-center justify-center shadow-lg shadow-cyan-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Sales Records</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Complete receipts with all items</p>
                </div>
            </div>
            
            {{-- Search --}}
            <form action="{{ route('sales.index') }}" method="GET" class="flex-1 max-w-md">
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search customer, product or payment..." 
                           class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                </div>
            </form>
        </div>
    </div>

    {{-- Sales Table --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-dark-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-dark-bg border-b border-gray-100 dark:border-dark-border">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Receipt ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Items Purchased</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payment</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-dark-border">
                    @forelse($sales as $index => $sale)
                    <tr class="hover:bg-gray-50 dark:hover:bg-dark-border/30 transition-colors" style="animation: slideUp 0.3s ease-out {{ $index * 0.05 }}s both;">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-2 py-1 rounded">#{{ $sale->sales_id }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $sale->sales_date ? \Carbon\Carbon::parse($sale->sales_date)->format('M d, Y h:i A') : 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-[#0f2744] to-[#0e7490] flex items-center justify-center mr-3">
                                    <span class="text-white text-xs font-bold">{{ strtoupper(substr($sale->customer->customer_name ?? 'W', 0, 1)) }}</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $sale->customer->customer_name ?? 'Walk-in / Unknown' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <ul class="space-y-1">
                                @foreach($sale->transactions as $item)
                                    <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                                        <span class="w-2 h-2 rounded-full bg-primary-500 mr-2"></span>
                                        {{ $item->product->product_name ?? 'Deleted Item' }} 
                                        <span class="ml-1 text-xs text-gray-400 dark:text-gray-500">(x{{ $item->quantity_sold }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $paymentColors = [
                                    'cash' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                    'credit card' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                ];
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $paymentColors[strtolower($sale->payment_method)] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ strtolower($sale->payment_method) == 'cash' ? '💵' : '💳' }} {{ ucfirst($sale->payment_method) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                {{ format_peso($sale->total_amount) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-dark-bg flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No sales records found</p>
                                <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Try adjusting your search criteria</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($sales->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-dark-border">
            {{ $sales->links() }}
        </div>
        @endif
    </div>
</div>
@endsection