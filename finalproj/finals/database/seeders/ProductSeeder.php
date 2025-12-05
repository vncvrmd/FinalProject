<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'product_name' => 'Laptop Pro',
            'description' => 'A high-end laptop for professionals.',
            'price' => 1200.50,
            'quantity_available' => 50,
        ]);

        Product::create([
            'product_name' => 'Smartphone X',
            'description' => 'The latest smartphone with amazing features.',
            'price' => 799.99,
            'quantity_available' => 150,
        ]);
    }
}
