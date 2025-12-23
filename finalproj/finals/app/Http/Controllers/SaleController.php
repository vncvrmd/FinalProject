<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // FIX 1: Eager load 'transactions' (plural) and nested relationships
        $sales = Sale::with(['customer', 'transactions.product'])
            ->when($search, function ($query, $search) {
                // Search by payment method
                $query->where('payment_method', 'like', "%{$search}%")
                // Search by customer name (Direct relationship now)
                ->orWhereHas('customer', function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%");
                })
                // Search by product name (Inside the plural transactions)
                ->orWhereHas('transactions.product', function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('sales.index', compact('sales'));
    }
}