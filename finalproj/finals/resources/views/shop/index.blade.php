@extends('layouts.app')

@section('title', 'Shop / POS')
@section('page-title', 'Point of Sale')

@section('content')
<div class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-8rem)]">
    
    {{-- LEFT SIDE: Product Grid --}}
    <div class="flex-1 flex flex-col gap-4 min-h-0">
        {{-- Search Bar --}}
        <div class="bg-white dark:bg-dark-card p-4 rounded-xl border border-slate-200 dark:border-dark-border">
            <input type="text" id="productSearch" placeholder="Search products..." 
                   class="w-full px-4 py-2 rounded-lg bg-slate-50 dark:bg-dark-bg border border-slate-200 dark:border-dark-border focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>

        {{-- Scrollable Grid --}}
        <div class="flex-1 overflow-y-auto pr-2">
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($products as $product)
                <div class="product-card bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border p-4 flex flex-col gap-3 hover:shadow-lg transition-all cursor-pointer group"
                     onclick="addToCart({{ json_encode($product) }})">
                    
                    {{-- Image Placeholder --}}
                    <div class="aspect-square rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                        @if($product->product_image)
                            <img src="{{ asset('storage/' . $product->product_image) }}" class="w-full h-full object-cover rounded-lg">
                        @else
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @endif
                    </div>

                    <div>
                        <h3 class="font-medium text-slate-900 dark:text-white truncate" title="{{ $product->product_name }}">
                            {{ $product->product_name }}
                        </h3>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-primary-600 font-bold">₱{{ number_format($product->price, 2) }}</span>
                            <span class="text-xs text-slate-500">{{ $product->quantity_available }} in stock</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- RIGHT SIDE: Cart / Checkout --}}
    <div class="w-full lg:w-96 bg-white dark:bg-dark-card rounded-xl border border-slate-200 dark:border-dark-border flex flex-col h-full shadow-xl">
        <div class="p-5 border-b border-slate-200 dark:border-dark-border">
            <h2 class="font-bold text-lg text-slate-900 dark:text-white">Current Order</h2>
        </div>

        {{-- Cart Items Area --}}
        <div class="flex-1 overflow-y-auto p-5 space-y-4" id="cartItemsContainer">
            {{-- Empty State --}}
            <div id="emptyCartMessage" class="text-center py-10 text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <p>Cart is empty</p>
                <p class="text-xs mt-1">Click products to add them</p>
            </div>
        </div>

        {{-- Checkout Form --}}
        <form action="{{ route('shop.store') }}" method="POST" id="checkoutForm" class="bg-slate-50 dark:bg-slate-800/50 p-5 border-t border-slate-200 dark:border-dark-border space-y-4">
            @csrf
            
            {{-- Hidden Inputs for Cart Data (Populated by JS) --}}
            <div id="formInputs"></div>

            {{-- Total --}}
            <div class="flex justify-between items-center mb-2">
                <span class="text-slate-500 dark:text-slate-400">Total Amount</span>
                <span class="text-2xl font-bold text-slate-900 dark:text-white" id="totalDisplay">₱0.00</span>
            </div>

            {{-- Customer Name --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Customer Name</label>
                <input type="text" name="customer_name" required placeholder="Enter customer name"
                       class="w-full px-3 py-2 rounded-lg border-slate-200 dark:border-dark-border bg-white dark:bg-dark-bg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            {{-- Payment Method --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Payment Method</label>
                <select name="payment_method" required class="w-full rounded-lg border-slate-200 dark:border-dark-border bg-white dark:bg-dark-bg text-sm py-2">
                    <option value="Cash">Cash</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Gcash">Gcash</option>
                </select>
            </div>

            <button type="submit" id="checkoutBtn" disabled 
                    class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white rounded-lg font-bold shadow-lg shadow-emerald-600/20 transition-all">
                Complete Sale
            </button>
        </form>
    </div>
</div>

<script>
    let cart = [];

    function addToCart(product) {
        const existing = cart.find(item => item.product_id === product.product_id);
        
        if (existing) {
            if(existing.quantity < product.quantity_available) {
                existing.quantity++;
            } else {
                alert('Max stock reached!');
            }
        } else {
            cart.push({
                product_id: product.product_id,
                name: product.product_name,
                price: parseFloat(product.price),
                quantity: 1,
                max_stock: product.quantity_available
            });
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
        }
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cartItemsContainer');
        const emptyMsg = document.getElementById('emptyCartMessage');
        const formInputs = document.getElementById('formInputs');
        const totalDisplay = document.getElementById('totalDisplay');
        const checkoutBtn = document.getElementById('checkoutBtn');

        container.innerHTML = '';
        formInputs.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            container.appendChild(emptyMsg);
            emptyMsg.style.display = 'block';
            checkoutBtn.disabled = true;
            totalDisplay.innerText = '₱0.00';
            return;
        }

        emptyMsg.style.display = 'none';
        checkoutBtn.disabled = false;

        cart.forEach((item, index) => {
            total += item.price * item.quantity;

            // Render Visual Item
            const div = document.createElement('div');
            div.className = 'flex justify-between items-center bg-slate-50 dark:bg-slate-800/50 p-3 rounded-lg border border-slate-100 dark:border-slate-700';
            div.innerHTML = `
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-slate-900 dark:text-white line-clamp-1">${item.name}</h4>
                    <div class="text-xs text-slate-500">₱${item.price.toFixed(2)} x ${item.quantity}</div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="updateQty(${item.product_id}, -1)" class="w-6 h-6 rounded bg-white border border-slate-200 text-slate-600 hover:border-red-500 hover:text-red-500 flex items-center justify-center">-</button>
                    <span class="text-sm font-semibold w-4 text-center">${item.quantity}</span>
                    <button type="button" onclick="updateQty(${item.product_id}, 1)" class="w-6 h-6 rounded bg-white border border-slate-200 text-slate-600 hover:border-emerald-500 hover:text-emerald-500 flex items-center justify-center">+</button>
                </div>
            `;
            container.appendChild(div);

            // Render Hidden Inputs for Server
            formInputs.innerHTML += `
                <input type="hidden" name="products[${index}][id]" value="${item.product_id}">
                <input type="hidden" name="products[${index}][quantity]" value="${item.quantity}">
            `;
        });

        totalDisplay.innerText = '₱' + total.toFixed(2);
    }

    // Simple Search Filter
    document.getElementById('productSearch').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.product-card').forEach(card => {
            const name = card.querySelector('h3').innerText.toLowerCase();
            card.style.display = name.includes(term) ? 'flex' : 'none';
        });
    });
</script>
@endsection