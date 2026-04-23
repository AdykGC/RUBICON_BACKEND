<?php namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'mac' => $this->faker->unique()->macAddress(),
            'name' => $this->faker->word() . ' device',
        ];
    }
}