<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Machine>
 */
class MachineFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Автомат '.fake()->randomNumber(3),
            'type' => fake()->randomElement([
                'Drink',
                'Snack',
                'Coffee',
            ]),
            'location' => fake()->address(),
            'mac_address' => fake()->macAddress(),
            'connection_type' => fake()->randomElement([
                '4G',
                'WiFi',
                'Ethernet',
            ]),
            'install_price' => fake()->randomFloat(2, 10000, 100000),
            'price_adjustment' => fake()->randomFloat(2, -10, 10),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'balance' => fake()->randomFloat(2, 0, 10000),
            'is_active' => true,
        ];
    }
}