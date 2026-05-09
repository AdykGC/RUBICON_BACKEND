<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();

        return [
            'amount' => $faker->randomFloat(2, 100, 5000),

            'status' => $faker->randomElement([
                'pending',
                'completed',
                'failed',
            ]),

            'transaction_id' => strtoupper($faker->bothify('TXN###??')),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}