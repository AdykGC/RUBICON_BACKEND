<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 100, 5000),

            'status' => $this->faker->randomElement([
                'pending',
                'completed',
                'failed',
            ]),

            'transaction_id' => strtoupper(
                $this->faker->bothify('TXN###??')
            ),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}