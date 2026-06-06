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
        $createRelations = function ($user) {
            Machine::factory(3)->create([ 'user_id' => $user->id, ])->each(function ($machine) {
                Transaction::factory(25)->create([ 'machine_id' => $machine->id, ]);
            });
        };

        $admin = User::factory()->create([ 'email' => 'a@gmail.com', ]);
        $createRelations($admin);

        User::factory(4)->create()->each($createRelations);
    }
}