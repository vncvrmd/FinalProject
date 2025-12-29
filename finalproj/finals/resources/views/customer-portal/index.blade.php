@use('Illuminate\Support\Facades\Auth')
@extends('layouts.customer')

@section('title', 'Shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Hero Section --}}
    <div class="text-center mb-10 animate-fade-in">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-cyan-600 bg-clip-text text-transparent mb-3">
            Welcome to JV TechHub Store
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-lg">Browse our collection and find what you need</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        {{-- LEFT: Product Catalog --}}
        <div class="flex-1">
            {{-- Search & Filter Bar --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl border border-slate-200 dark:border-dark-border p-4 mb-6 shadow-sm">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" id="productSearch" placeholder="Search products..." 
                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-dark-bg border border-slate-200 dark:border-dark-border focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                        <span>{{ $products->count() }} products available</span>
                    </div>
                </div>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4" id="productGrid">
                @forelse($products as $product)
                <div class="product-card bg-white dark:bg-dark-card rounded-2xl border border-slate-200 dark:border-dark-border overflow-hidden cursor-pointer group"
                     onclick="addToCart({{ json_encode($product) }})"
                     data-name="{{ strtolower($product->product_name) }}">
                    
                    {{-- Product Image --}}
                    <div class="aspect-square bg-gradient-to-br from-slate-100 to-slate-50 dark:from-slate-800 dark:to-slate-900 relative overflow-hidden">
                        @if($product->product_image)
                            <img src="{{ asset('storage/' . $product->product_image) }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 alt="{{ $product->product_name }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        @endif
                        
                        {{-- Add to Cart Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-4">
                            <span class="px-4 py-2 bg-white/90 dark:bg-dark-card/90 rounded-full text-sm font-semibold text-emerald-600 dark:text-emerald-400 shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                + Add to Cart
                            </span>
                        </div>

                        {{-- Stock Badge --}}
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $product->quantity_available <= 5 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-400' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400' }}">
                                {{ $product->quantity_available }} left
                            </span>
                        </div>
                    </div>
                    
                    {{-- Product Info --}}
                    <div class="p-4">
                        <h3 class="font-semibold text-slate-900 dark:text-white truncate mb-1" title="{{ $product->product_name }}">
                            {{ $product->product_name }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mb-3 h-8">
                            {{ $product->description ?? 'No description available' }}
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-16">
                    <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-600 dark:text-slate-400">No products available</h3>
                    <p class="text-slate-500 dark:text-slate-500">Check back later for new products</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- RIGHT: Shopping Cart --}}
        <div class="w-full lg:w-96 lg:sticky lg:top-24 lg:h-fit">
            <div class="bg-white dark:bg-dark-card rounded-2xl border border-slate-200 dark:border-dark-border shadow-xl overflow-hidden">
                {{-- Cart Header --}}
                <div class="p-5 bg-gradient-to-r from-emerald-500 to-cyan-500">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Shopping Cart
                        </h2>
                        <span id="cartCount" class="px-2.5 py-1 bg-white/20 rounded-full text-sm font-semibold text-white">0 items</span>
                    </div>
                </div>

                {{-- Cart Items --}}
                <div class="max-h-80 overflow-y-auto p-5 space-y-3" id="cartItemsContainer">
                    {{-- Empty State --}}
                    <div id="emptyCartMessage" class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-slate-500 dark:text-slate-400 font-medium">Your cart is empty</p>
                        <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">Click on products to add them</p>
                    </div>
                </div>

                {{-- Checkout Form --}}
                <form action="{{ route('customer.checkout') }}" method="POST" id="checkoutForm" class="p-5 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-dark-border">
                    @csrf
                    
                    {{-- Hidden Cart Data --}}
                    <div id="formInputs"></div>

                    {{-- Total --}}
                    <div class="flex justify-between items-center mb-5 pb-5 border-b border-slate-200 dark:border-dark-border">
                        <span class="text-slate-600 dark:text-slate-400 font-medium">Total</span>
                        <span class="text-3xl font-bold text-slate-900 dark:text-white" id="totalDisplay">₱0.00</span>
                    </div>

                    {{-- Logged in Customer Info --}}
                    <div class="mb-4 p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800/50">
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Ordering as</p>
                        <p class="font-semibold text-emerald-700 dark:text-emerald-300">{{ Auth::guard('customer')->user()->customer_name }}</p>
                    </div>

                    {{-- Payment Method --}}
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Payment Method</label>
                        <select name="payment_method" required 
                                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-dark-bg border border-slate-200 dark:border-dark-border focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                            <option value="Cash">Cash</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Gcash">GCash</option>
                            <option value="PayMaya">PayMaya</option>
                        </select>
                    </div>

                    {{-- Checkout Button --}}
                    <button type="submit" id="checkoutBtn" disabled 
                            class="w-full py-4 bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-600 hover:to-cyan-600 disabled:from-slate-300 disabled:to-slate-300 disabled:cursor-not-allowed text-white rounded-xl font-bold text-lg shadow-lg shadow-emerald-500/30 disabled:shadow-none transition-all duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Place Order</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = [];

    function addToCart(product) {
        const existing = cart.find(item => item.product_id === product.product_id);
        
        if (existing) {
            if (existing.quantity < product.quantity_available) {
                existing.quantity++;
                showToast('Added another ' + product.product_name);
            } else {
                showToast('Maximum stock reached!', 'error');
            }
        } else {
            cart.push({
                product_id: product.product_id,
                name: product.product_name,
                price: parseFloat(product.price),
                quantity: 1,
                max_stock: product.quantity_available
            });
            showToast(product.product_name + ' added to cart');
        }
        renderCart();
    }

    function updateQty(productId, change) {
        const item = cart.find(i => i.product_id === productId);
        if (!item) return;

        const newQty = item.quantity + change;
        
        if (newQty > 0 && newQty <= item.max_stock) {
            item.quantity = newQty;
        } else if (newQty <= 0) {
            cart = cart.filter(i => i.product_id !== productId);
            showToast('Item removed from cart');
        } else {
            showToast('Maximum stock reached!', 'error');
        }
        renderCart();
    }

    function removeItem(productId) {
        cart = cart.filter(i => i.product_id !== productId);
        showToast('Item removed from cart');
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cartItemsContainer');
        const emptyMsg = document.getElementById('emptyCartMessage');
        const formInputs = document.getElementById('formInputs');
        const totalDisplay = document.getElementById('totalDisplay');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const cartCount = document.getElementById('cartCount');

        container.innerHTML = '';
        formInputs.innerHTML = '';
        let total = 0;
        let totalItems = 0;

        if (cart.length === 0) {
            container.innerHTML = `
                <div id="emptyCartMessage" class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400 font-medium">Your cart is empty</p>
                    <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">Click on products to add them</p>
                </div>
            `;
            checkoutBtn.disabled = true;
            totalDisplay.innerText = '₱0.00';
            cartCount.innerText = '0 items';
            return;
        }

        checkoutBtn.disabled = false;

        cart.forEach((item, index) => {
            total += item.price * item.quantity;
            totalItems += item.quantity;

            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-700 animate-fade-in';
            div.innerHTML = `
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-semibold text-slate-900 dark:text-white truncate">${item.name}</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400">₱${item.price.toFixed(2)} × ${item.quantity}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="updateQty(${item.product_id}, -1)" 
                            class="w-7 h-7 rounded-lg bg-white dark:bg-dark-bg border border-slate-200 dark:border-dark-border text-slate-600 dark:text-slate-400 hover:border-red-400 hover:text-red-500 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                    </button>
                    <span class="text-sm font-bold w-6 text-center text-slate-900 dark:text-white">${item.quantity}</span>
                    <button type="button" onclick="updateQty(${item.product_id}, 1)" 
                            class="w-7 h-7 rounded-lg bg-white dark:bg-dark-bg border border-slate-200 dark:border-dark-border text-slate-600 dark:text-slate-400 hover:border-emerald-400 hover:text-emerald-500 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </button>
                    <button type="button" onclick="removeItem(${item.product_id})" 
                            class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-500 hover:bg-red-100 dark:hover:bg-red-900/40 flex items-center justify-center transition-colors ml-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            `;
            container.appendChild(div);

            formInputs.innerHTML += `
                <input type="hidden" name="products[${index}][id]" value="${item.product_id}">
                <input type="hidden" name="products[${index}][quantity]" value="${item.quantity}">
            `;
        });

        totalDisplay.innerText = '₱' + total.toFixed(2);
        cartCount.innerText = totalItems + (totalItems === 1 ? ' item' : ' items');
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 left-4 z-50 px-4 py-2 rounded-xl text-white text-sm font-medium shadow-lg animate-slide-up ${type === 'error' ? 'bg-red-500' : 'bg-emerald-500'}`;
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2500);
    }

    // Search filter
    document.getElementById('productSearch').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.product-card').forEach(card => {
            const name = card.dataset.name;
            card.style.display = name.includes(term) ? 'block' : 'none';
        });
    });
</script>
@endsection
