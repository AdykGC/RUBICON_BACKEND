<?php

namespace Database\Seeders;

use App\Models\Machine;
use App\Models\TopUp;
use Illuminate\Database\Seeder;

class TopUpSeeder extends Seeder
{
    public function run(): void
    {
        $machine = Machine::where('serial_number', 'RUB-795211')->first();
        if ($machine) {
            TopUp::create([
                'machine_id' => $machine->id,
                'amount' => 500,
                'status' => 'completed',
                'transaction_id' => 'TEST_001',
            ]);
            $machine->increment('balance', 500);
        }
    }
}