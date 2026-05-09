<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();

        return [
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'company_title' => $faker->company(),
            'phone' => $faker->phoneNumber(),
            'address' => $faker->address(),
            'password' => Hash::make('HelloWorld1'),
            'is_active' => true,
        ];
    }
}