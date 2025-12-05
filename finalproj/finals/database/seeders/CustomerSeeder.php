<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'customer_name' => 'John Doe',
            'contact_information' => 'john.doe@example.com',
            'address' => '123 Main St, Anytown, USA',
        ]);
        Customer::create([
            'customer_name' => 'Jane Smith',
            'contact_information' => 'jane.smith@example.com',
            'address' => '456 Oak Ave, Sometown, USA',
        ]);
    }
}
