<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Only seed if no users exist (prevents duplicates on redeploy)
        if (User::count() === 0) {
            // Create admin accounts directly without factories (factories require Faker which is dev-only)
            User::create([
                'full_name' => 'Super Admin',
                'email' => 'admin@example.com',
                'username' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]);

            User::create([
                'full_name' => 'Super Admin (Vince)',
                'username' => 'spvstwu',
                'email' => 'vincevermudo@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]);

            // Only run other seeders and factories in non-production
            if (app()->environment('local', 'testing')) {
                User::factory(10)->create();

                $this->call([
                    ProductSeeder::class,
                    CustomerSeeder::class,
                    TransactionSeeder::class,
                ]);
            }
        }
    }
}