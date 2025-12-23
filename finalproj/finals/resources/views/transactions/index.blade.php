@extends('layouts.app')

@section('title', 'Transactions')
@section('page-title', 'Transaction History')

@section('content')
<div class="card bg-white p-6 rounded-lg shadow-md">
    
    {{-- Header & Search --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
        <h2 class="text-xl font-bold">All Transactions (Items Sold)</h2>
        
        <form action="{{ route('transactions.index') }}" method="GET" class="flex w-full md:w-auto">
            <input type="text" name="search" placeholder="Search product or customer..." 
                   class="border border-gray-300 rounded-l px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="{{ request('search') }}">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r hover:bg-indigo-700 transition">
                Search
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price (Each)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        #{{ $transaction->transaction_id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $transaction->created_at->format('M d, Y') }}
                    </td>
                    
                    {{-- FIX: Access Customer via Sale --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $transaction->sale->customer->customer_name ?? 'N/A' }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $transaction->product->product_name ?? 'Deleted Product' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $transaction->quantity_sold }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ format_peso($transaction->price_at_sale) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                        {{ format_peso($transaction->price_at_sale * $transaction->quantity_sold) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                        No transactions found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection