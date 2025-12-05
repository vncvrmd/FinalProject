@extends('layouts.app')

@section('title', 'Customer Management')

@section('page-title', 'Customer Management')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('customers.index') }}" method="GET" class="w-full max-w-sm">
                <div class="flex items-center border-b border-gray-300 py-2">
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" name="search" placeholder="Search by name, contact..." value="{{ request('search') }}">
                    <button class="flex-shrink-0 bg-transparent hover:bg-gray-100 text-gray-500 hover:text-gray-800 text-sm py-1 px-2 rounded" type="submit">
                        Search
                    </button>
                </div>
            </form>
            <a href="{{ route('customers.create') }}" class="bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 px-3 rounded-md text-sm transition duration-150">
                + Add Customer
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($customers as $customer)
                    <tr class="border-b border-gray-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $customer->customer_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $customer->contact_information }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $customer->address }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('customers.edit', $customer->customer_id) }}" class="text-blue-700 hover:text-blue-900">Edit</a>
                                <form action="{{ route('customers.destroy', $customer->customer_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No customers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>
@endsection