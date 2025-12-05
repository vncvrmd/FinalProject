<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $transactions = Transaction::with(['product', 'customer'])
            ->when($search, function ($query, $search) {
                // Search by customer name
                $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%");
                })
                // Or search by product name
                ->orWhereHas('product', function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        // We need all products and customers for the dropdowns
        $products = Product::orderBy('product_name')->get();
        $customers = Customer::orderBy('customer_name')->get();
        
        return view('transactions.create', compact('products', 'customers'));
    }

    public function store(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:customers,customer_id',
        'payment_method' => 'required|string',
        'products' => 'required|array',
        'products.*' => 'exists:products,product_id',
        'quantities' => 'required|array',
        'quantities.*' => 'integer|min:1',
    ]);

    try {
        DB::beginTransaction();

        // 1. Create the Sale (Receipt) first
        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'payment_method' => $request->payment_method,
            'sales_date' => now(),
            'total_amount' => 0, // We will calculate this in the loop
        ]);

        $totalAmount = 0;
        $products = $request->products;
        $quantities = $request->quantities;

        // 2. Loop through each item in the cart
        foreach ($products as $index => $productId) {
            $quantity = $quantities[$index];
            $product = Product::find($productId);

            // Check Stock
            if ($product->quantity_available < $quantity) {
                throw new \Exception("Not enough stock for " . $product->product_name);
            }

            // Create Transaction (Line Item)
            Transaction::create([
                'sale_id' => $sale->sales_id,
                'product_id' => $productId,
                'quantity_sold' => $quantity,
                'price_at_sale' => $product->price,
            ]);

            // Deduct Stock
            $product->decrement('quantity_available', $quantity);

            // Add to total
            $totalAmount += ($product->price * $quantity);
        }

        // 3. Update the final total on the Sale
        $sale->update(['total_amount' => $totalAmount]);

        // 4. Log it
        Log::create([
            'user_id' => Auth::id() ?? 1,
            'action' => 'Created sale #' . $sale->sales_id . ' with ' . count($products) . ' items.',
            'date_time' => now(),
        ]);

        DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error: ' . $e->getMessage());
    }

    return redirect()->route('sales.index')->with('success', 'Sale completed successfully!');
    }
}
