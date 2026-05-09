<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'company_title' => fake()->company(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'password' => Hash::make('HelloWorld1'),
            'is_active' => true,
        ];
    }
}