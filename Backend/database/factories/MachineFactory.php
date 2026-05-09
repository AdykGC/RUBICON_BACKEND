<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MachineFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Автомат '.$this->faker->randomNumber(3),

            'type' => $this->faker->randomElement([
                'Drink',
                'Snack',
                'Coffee',
            ]),

            'location' => $this->faker->address(),

            'mac_address' => $this->faker->macAddress(),

            'connection_type' => $this->faker->randomElement([
                '4G',
                'WiFi',
                'Ethernet',
            ]),

            'install_price' => $this->faker->randomFloat(2, 10000, 100000),

            'price_adjustment' => $this->faker->randomFloat(2, -10, 10),

            'latitude' => $this->faker->latitude(),

            'longitude' => $this->faker->longitude(),

            'balance' => $this->faker->randomFloat(2, 0, 10000),

            'is_active' => true,
        ];
    }
}