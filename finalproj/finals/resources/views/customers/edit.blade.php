@extends('layouts.app')

@section('title', 'Edit Customer')

@section('page-title', 'Edit Customer')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Back Button --}}
        <a href="{{ route('customers.index') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Customers
        </a>

        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-dark-border overflow-hidden">
            {{-- Header --}}
            <div class="px-8 py-6 border-b border-gray-100 dark:border-dark-border bg-gradient-to-r from-[#0f2744] via-[#0a1628] to-[#0e7490]">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($customer->customer_name, 0, 2)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $customer->customer_name }}</h2>
                        <p class="text-primary-100 text-sm">Update customer information</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                @if($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-red-700 dark:text-red-400">Please correct the errors below:</p>
                                <ul class="mt-2 text-sm text-red-600 dark:text-red-300 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('customers.update', $customer->customer_id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2">
                        <label for="customer_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Customer Name</label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $customer->customer_name) }}" required 
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                    </div>
                    <div class="space-y-2">
                        <label for="contact_information" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Contact Information</label>
                        <input type="text" name="contact_information" id="contact_information" value="{{ old('contact_information', $customer->contact_information) }}" required 
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                    </div>
                    <div class="space-y-2">
                        <label for="address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $customer->address) }}" required 
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                    </div>
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-[#0f2744] to-[#0e7490] text-white font-semibold shadow-lg shadow-cyan-500/30 hover:shadow-xl hover:shadow-cyan-500/40 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection