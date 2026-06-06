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
        $createdAt = $faker->dateTimeBetween('-1 year', 'now');

        return [
            'amount' => $faker->randomFloat(2, 100, 5000),

            'status' => $faker->randomElement([
                'pending',
                'completed',
                'failed',
            ]),

            'transaction_id' => strtoupper($faker->bothify('TXN###??')),

            'created_at' => $createdAt,
            'updated_at' => $faker->dateTimeBetween($createdAt, 'now'),
        ];
    }
}