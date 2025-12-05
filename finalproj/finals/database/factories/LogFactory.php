<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Select a random existing user for the log
            'user_id' => User::inRandomOrder()->first()->user_id ?? User::factory(),
            'action' => fake()->randomElement([
                'Logged in',
                'Created a new transaction',
                'Updated product stock',
                'Registered a new customer',
                'Logged out'
            ]),
            'date_time' => fake()->dateTimeThisMonth(),
        ];
    }
}