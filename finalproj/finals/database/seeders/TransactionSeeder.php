<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Log;
use App\Models\User;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $customers = Customer::all();
        $user = User::first();

        // Safety check
        if ($products->isEmpty() || $customers->isEmpty()) {
            $this->command->info('Skipping TransactionSeeder: No products or customers found.');
            return;
        }

        // Create 10 different Sales (Receipts)
        for ($i = 0; $i < 10; $i++) {
            $customer = $customers->random();
            
            // 1. Create the Sale (Receipt) first
            $sale = Sale::create([
                'customer_id' => $customer->customer_id,
                'total_amount' => 0, // Will calculate below
                'payment_method' => ['cash', 'credit card'][rand(0, 1)],
                'sales_date' => now(),
            ]);

            // 2. Add random items to this sale (1 to 3 items per receipt)
            $totalAmount = 0;
            $numberOfItems = rand(1, 3);

            for ($j = 0; $j < $numberOfItems; $j++) {
                $product = $products->random();
                $quantity = rand(1, 3);

                Transaction::create([
                    'sale_id' => $sale->sales_id, // Link to the Sale we just made
                    'product_id' => $product->product_id,
                    'quantity_sold' => $quantity,
                    'price_at_sale' => $product->price,
                ]);

                $totalAmount += ($product->price * $quantity);
            }

            // 3. Update the total amount on the receipt
            $sale->update(['total_amount' => $totalAmount]);

            // 4. Log the action (if a user exists)
            if ($user) {
                Log::create([
                    'user_id' => $user->user_id,
                    'action' => "Seeder created Sale #{$sale->sales_id} with {$numberOfItems} items",
                    'date_time' => now()
                ]);
            }
        }
    }
}