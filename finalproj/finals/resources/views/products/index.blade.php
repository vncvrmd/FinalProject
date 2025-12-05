@extends('layouts.app')

@section('title', 'Product Management')

@section('page-title', 'Product Management')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('products.index') }}" method="GET" class="w-full max-w-sm">
                <div class="flex items-center border-b border-gray-300 py-2">
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" name="search" placeholder="Search by name, description..." value="{{ request('search') }}">
                    <button class="flex-shrink-0 bg-transparent hover:bg-gray-100 text-gray-500 hover:text-gray-800 text-sm py-1 px-2 rounded" type="submit">
                        Search
                    </button>
                </div>
            </form>
            <a href="{{ route('products.create') }}" class="bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 px-3 rounded-md text-sm transition duration-150">
                + Add Product
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($products as $product)
                    <tr class="border-b border-gray-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $product->product_image ? asset('storage/' . $product->product_image) : 'https://placehold.co/40x40/EBF4FF/7F9CF5?text=P' }}" alt="{{ $product->product_name }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->product_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ format_peso($product->price) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $product->quantity_available }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 max-w-xs truncate">{{ $product->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('products.edit', $product->product_id) }}" class="text-blue-700 hover:text-blue-900">Edit</a>
                                <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection