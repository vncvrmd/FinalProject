<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerStoreController extends Controller
{
    /**
     * Display the customer shopping portal
     */
    public function index()
    {
        // Get products that have stock available
        $products = Product::where('quantity_available', '>', 0)->get();
        
        return view('customer-portal.index', compact('products'));
    }

    /**
     * Process customer checkout
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,product_id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            $sale = DB::transaction(function () use ($request) {
                // Create or find customer by name
                $customer = Customer::firstOrCreate(
                    ['customer_name' => $request->customer_name],
                    ['contact_information' => '', 'address' => '']
                );

                // Create the Sale Record
                $sale = Sale::create([
                    'customer_id' => $customer->customer_id,
                    'total_amount' => 0,
                    'payment_method' => $request->payment_method,
                    'sales_date' => now(),
                ]);

                $totalAmount = 0;

                // Loop through items to create Transactions & Update Stock
                foreach ($request->products as $item) {
                    $product = Product::findOrFail($item['id']);

                    // Check stock
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

                // Update the Sale Total
                $sale->update(['total_amount' => $totalAmount]);

                return $sale;
            });

            return redirect()->route('customer.receipt', $sale->sales_id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error processing order: ' . $e->getMessage());
        }
    }

    /**
     * Display receipt after successful purchase
     */
    public function receipt($saleId)
    {
        // Manual lookup since Sale uses custom primary key
        $sale = Sale::where('sales_id', $saleId)->firstOrFail();
        
        // Load sale with customer and transactions
        $sale->load(['customer', 'transactions.product']);
        
        return view('customer-portal.receipt', compact('sale'));
    }
}
