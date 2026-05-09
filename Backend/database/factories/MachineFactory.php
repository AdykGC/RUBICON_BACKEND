<?php

namespace Database\Factories;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class MachineFactory extends Factory
{
    protected $model = Machine::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();

        return [
            'name' => 'Автомат ' . $faker->randomNumber(3),

            'type' => $faker->randomElement([
                'Drink',
                'Snack',
                'Coffee',
            ]),

            'location' => $faker->address(),

            'mac_address' => $faker->macAddress(),

            'connection_type' => $faker->randomElement([
                '4G',
                'WiFi',
                'Ethernet',
            ]),

            'install_price' => $faker->randomFloat(2, 10000, 100000),

            'price_adjustment' => $faker->randomFloat(2, -10, 10),

            'latitude' => $faker->latitude(),

            'longitude' => $faker->longitude(),

            'balance' => $faker->randomFloat(2, 0, 10000),

            'is_active' => true,
        ];
    }
}