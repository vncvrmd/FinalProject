@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <p class="mb-6">Monitor your business metrics in real-time</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
        {{-- USERS: Visible only to Admin --}}
        @if(strtolower(Auth::user()->role ?? '') === 'admin')
        <div class="card bg-white p-6 rounded-lg shadow-md col-span-1">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-bold">Users</h2>
                <a href="{{ route('users.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Manage →</a>
            </div>
            <div class="table-container max-h-64 overflow-y-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $user->user_id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm flex items-center">
                                <img class="h-8 w-8 rounded-full object-cover mr-3" src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://placehold.co/32x32/EBF4FF/7F9CF5?text=' . strtoupper(substr($user->full_name, 0, 1)) }}" alt="">
                                {{ $user->full_name }}
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">
                                    {{ $user->role }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-sm italic p-4">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- PRODUCTS: Visible to Admin and Employee --}}
        @if(in_array(strtolower(Auth::user()->role ?? ''), ['admin', 'employee']))
        <div class="card bg-white p-6 rounded-lg shadow-md col-span-1">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-bold">Products</h2>
                <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Manage →</a>
            </div>
            <div class="table-container max-h-64 overflow-y-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $product->product_id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $product->product_name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-semibold text-green-700">{{ format_peso($product->price) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-sm italic p-4">No products found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- CUSTOMERS: Visible to Admin and Employee --}}
        @if(in_array(strtolower(Auth::user()->role ?? ''), ['admin', 'employee']))
        <div class="card bg-white p-6 rounded-lg shadow-md col-span-1">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-bold">Customers</h2>
                <a href="{{ route('customers.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Manage →</a>
            </div>
            <div class="table-container max-h-64 overflow-y-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($customers as $customer)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $customer->customer_id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $customer->customer_name }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-sm italic p-4">No customers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- TRANSACTIONS: Visible to Everyone --}}
        <div class="card bg-white p-6 rounded-lg shadow-md md:col-span-2 lg:col-span-3"> 
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-bold">Transactions</h2>
                <a href="{{ route('transactions.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Manage →</a>
            </div>
            <div class="table-container max-h-80 overflow-y-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $transaction->transaction_id }}</td>
                            {{-- FIX: Accessed customer via the sale relationship --}}
                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $transaction->sale->customer->customer_name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $transaction->product->product_name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">
                                    {{ $transaction->quantity_sold }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-sm italic p-4">No transactions found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SALES: Visible to Everyone --}}
        <div class="card bg-white p-6 rounded-lg shadow-md md:col-span-2 lg:col-span-3"> 
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-bold">Sales</h2>
                <a href="{{ route('sales.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Manage →</a>
            </div>
            <div class="table-container max-h-80 overflow-y-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($sales as $sale)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $sale->sales_id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-semibold text-green-700">{{ format_peso($sale->total_amount) }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $sale->payment_method == 'cash' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $sale->payment_method }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-sm italic p-4">No sales found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- LOGS: Visible only to Admin --}}
        @if(strtolower(Auth::user()->role ?? '') === 'admin')
        <div class="card bg-white p-6 rounded-lg shadow-md col-span-1 md:col-span-2 lg:col-span-3">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-bold">System Logs</h2>
                <a href="{{ route('logs.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Manage →</a>
            </div>
            <div class="table-container max-h-64 overflow-y-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($logs ?? [] as $log)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $log->user->full_name ?? 'Unknown' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $log->action }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $log->date_time->format('M d, Y h:i A') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-sm italic p-4">No logs found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
@endsection