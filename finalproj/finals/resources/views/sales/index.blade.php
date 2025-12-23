@extends('layouts.app')

@section('title', 'Sales')
@section('page-title', 'Sales History')

@section('content')
<div class="card bg-white p-6 rounded-lg shadow-md">
    
    {{-- Header & Search --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
        <h2 class="text-xl font-bold">Sales Records (Receipts)</h2>
        
        <form action="{{ route('sales.index') }}" method="GET" class="flex w-full md:w-auto">
            <input type="text" name="search" placeholder="Search customer, product or payment..." 
                   class="border border-gray-300 rounded-l px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="{{ request('search') }}">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r hover:bg-indigo-700 transition">
                Search
            </button>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items Purchased</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($sales as $sale)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        #{{ $sale->sales_id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $sale->sales_date ? \Carbon\Carbon::parse($sale->sales_date)->format('M d, Y h:i A') : 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $sale->customer->customer_name ?? 'Walk-in / Unknown' }}
                    </td>
                    
                    {{-- Loop through transactions to show items --}}
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <ul class="list-disc list-inside">
                            @foreach($sale->transactions as $item)
                                <li>
                                    {{ $item->product->product_name ?? 'Deleted Item' }} 
                                    <span class="text-xs text-gray-400">(x{{ $item->quantity_sold }})</span>
                                </li>
                            @endforeach
                        </ul>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ strtolower($sale->payment_method) == 'cash' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($sale->payment_method) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                        {{ format_peso($sale->total_amount) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                        No sales records found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $sales->links() }}
    </div>
</div>
@endsection