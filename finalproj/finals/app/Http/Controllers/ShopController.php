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
            'customer_name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'payment_method' => 'required|string|in:Cash,Credit Card,Gcash',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|exists:products,product_id',
            'products.*.quantity' => 'required|integer|min:1|max:1000',
        ]);

        try {
            $sale = DB::transaction(function () use ($request) {
                // Sanitize customer name
                $customerName = strip_tags(trim($request->customer_name));
                
                // 1. Create or find customer by name
                $customer = Customer::firstOrCreate(
                    ['customer_name' => $customerName],
                    ['contact_information' => '', 'address' => '']
                );

                // 2. Create the Sale Record
                $sale = Sale::create([
                    'customer_id' => $customer->customer_id,
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
                
                return $sale;
            });

            return redirect()->route('shop.receipt', $sale->sales_id)->with('success', 'Sale completed successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error processing sale: ' . $e->getMessage());
        }
    }

    public function receipt($saleId)
    {
        // Custom primary key lookup
        $sale = Sale::where('sales_id', $saleId)->firstOrFail();
        $sale->load(['customer', 'transactions.product']);
        
        return view('shop.receipt', compact('sale'));
    }
}