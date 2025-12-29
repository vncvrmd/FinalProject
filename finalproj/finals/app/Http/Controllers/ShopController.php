<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index()
    {
        // Get products that actually have stock
        $products = Product::where('quantity_available', '>', 0)->get();
        $customers = Customer::all();
        
        return view('shop.index', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'payment_method' => 'required|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,product_id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Create the Sale Record
                $sale = Sale::create([
                    'customer_id' => $request->customer_id,
                    'total_amount' => 0, // Will update after calculating
                    'payment_method' => $request->payment_method,
                    'sales_date' => now(),
                ]);

                $totalAmount = 0;

                // 2. Loop through items to create Transactions & Update Stock
                foreach ($request->products as $item) {
                    $product = Product::findOrFail($item['id']);

                    // Check stock again to be safe
                    if ($product->quantity_available < $item['quantity']) {
                        throw new \Exception("Insufficient stock for " . $product->product_name);
                    }

                    // Create Transaction
                    Transaction::create([
                        'sale_id' => $sale->sales_id,
                        'product_id' => $product->product_id,
                        'quantity_sold' => $item['quantity'],
                        'price_at_sale' => $product->price,
                    ]);

                    // Deduct Stock
                    $product->decrement('quantity_available', $item['quantity']);

                    // Add to total
                    $totalAmount += ($product->price * $item['quantity']);
                }

                // 3. Update the Sale Total
                $sale->update(['total_amount' => $totalAmount]);
            });

            return redirect()->route('sales.index')->with('success', 'Sale completed successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error processing sale: ' . $e->getMessage());
        }
    }
}