<?php namespace Database\Factories;

use App\Models\User;
use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MachineFactory extends Factory
{
    protected $model = Machine::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Vending',
            'type' => $this->faker->randomElement(['Snack', 'Drink', 'Coffee', 'Combo']),
            'location' => $this->faker->address(),
            'serial_number' => $this->faker->unique()->bothify('RUB-######'),
            'user_id' => User::factory(),
            'connection_type' => $this->faker->randomElement(['4G', 'WiFi', 'Ethernet']),
            'install_price' => $this->faker->randomFloat(2, 5000, 20000),
            'price_adjustment' => $this->faker->randomFloat(2, 0, 500),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'is_active' => true,
        ];
    }
}