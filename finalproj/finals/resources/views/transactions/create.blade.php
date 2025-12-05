@extends('layouts.app')

@section('title', 'Create New Transaction')

@section('page-title', 'Create New Transaction')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-3xl mx-auto">
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                <p class="font-bold">Please correct the errors below:</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                    <select id="customer_id" name="customer_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select a customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->customer_id }}" @selected(old('customer_id') == $customer->customer_id)>
                                {{ $customer->customer_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700">Product</label>
                    <select id="product_id" name="product_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->product_id }}" @selected(old('product_id') == $product->product_id)>
                                {{ $product->product_name }} (Stock: {{ $product->quantity_available }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="quantity_sold" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity_sold" id="quantity_sold" value="{{ old('quantity_sold') }}" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                    <select id="payment_method" name="payment_method" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="cash" @selected(old('payment_method') == 'cash')>Cash</option>
                        <option value="credit card" @selected(old('payment_method') == 'credit card')>Credit Card</option>
                    </select>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-900 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 transition duration-150">
                    Create Transaction
                </button>
            </div>
        </form>
    </div>
@endsection