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
        User::factory(10)->create()->each(function ($user) {

            Machine::factory(3)->create([
                'user_id' => $user->id,
            ])->each(function ($machine) {

                Transaction::factory(5)->create([
                    'machine_id' => $machine->id,
                ]);

            });

        });
    }
}