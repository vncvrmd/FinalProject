<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $sales = Sale::with(['transaction.customer', 'transaction.product'])
            ->when($search, function ($query, $search) {
                // Search by payment method
                $query->where('payment_method', 'like', "%{$search}%")
                // Or search by customer name
                ->orWhereHas('transaction.customer', function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%");
                })
                // Or search by product name
                ->orWhereHas('transaction.product', function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('sales.index', compact('sales'));
    }
}