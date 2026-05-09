<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Machine;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)
            ->has(
                Machine::factory(3)
                    ->has(
                        Transaction::factory(5)
                    )
            )
            ->create();
    }
}
