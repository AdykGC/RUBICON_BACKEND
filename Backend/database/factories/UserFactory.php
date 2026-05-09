<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'company_title' => fake()->company(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'password' => Hash::make('password'),
            'is_active' => true,
        ];
    }
}