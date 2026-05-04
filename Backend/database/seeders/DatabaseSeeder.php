<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Machine;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Пользователь с e-mail, совпадающим с контактом в Bitrix
        // Поставь здесь тот e-mail, который ты указал в контакте сделки
        $email = 'test@example.com';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name'          => 'Bitrix Test User',
                'company_title' => 'Rubicon',
                'phone'         => '+7 777 777 77 77',
                'address'       => 'Almaty, Kazakhstan',
                'password'      => Hash::make('Password1'),
                'is_active'     => true,
            ]
        );

        // 2. Один тестовый автомат для этого пользователя
        $machine = Machine::firstOrCreate(
            ['user_id' => $user->id, 'name' => 'Тестовый автомат Rubicon'],
            [
                'type'            => 'Drink',
                'location'        => 'Офис, 1 этаж',
                'mac_address'     => '78:21:84:E2:DA:18',
                'connection_type' => '4G',
                'install_price'   => 15000.00,
                'price_adjustment'=> 0,
                'latitude'        => 43.2567,
                'longitude'       => 76.9286,
                'balance'         => 0,
                'is_active'       => true,
            ]
        );

        // 3. Одно тестовое пополнение для автомата
        if ($machine && !Transaction::where('transaction_id', 'TEST_001')->exists()) {
            Transaction::create([
                'machine_id'     => $machine->id,
                'amount'         => 500,
                'status'         => 'completed',
                'transaction_id' => 'TEST_001',
            ]);

            $machine->increment('balance', 500);
        }
    }
}