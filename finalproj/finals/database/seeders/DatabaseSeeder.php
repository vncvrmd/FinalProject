<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Log; 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::factory()->create([
            'full_name' => 'Super Admin',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::factory(10)->create();

        $this->call([
            ProductSeeder::class,
            CustomerSeeder::class,
            TransactionSeeder::class,
        ]);
        Log::factory(20)->create();
    }
}