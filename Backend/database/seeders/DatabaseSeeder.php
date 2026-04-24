<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Machine;
use App\Models\Product;
use App\Models\Device;
use App\Models\TopUp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Пользователь
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'company_title' => 'Rubicon',
                'email' => 'admin@rubicon.com',
                'phone' => '+7 777 777 77 77',
                'address' => 'Almaty, Kazakhstan',
                'password' => 'Password1',
                'is_active' => true,
            ]);
        }

        // 2. Машина с serial_number = RUB-795211
        Machine::updateOrCreate(
            ['serial_number' => 'RUB-795211'],
            [
                'name' => 'Тестовый автомат Rubicon',
                'type' => 'Drink',
                'location' => 'Офис, 1 этаж',
                'user_id' => $user->id,
                'connection_type' => '4G',
                'install_price' => 15000.00,
                'price_adjustment' => 0,
                'latitude' => 43.2567,
                'longitude' => 76.9286,
                'balance' => 0,
                'is_active' => true,
            ]
        );

        // Дополнительные машины (если нужно)
        if (Machine::count() < 2) {
            Machine::create([
                'name' => 'Демо-автомат 2',
                'type' => 'Snack',
                'location' => 'Коридор, 2 этаж',
                'serial_number' => 'RUB-000002',
                'user_id' => $user->id,
                'connection_type' => 'WiFi',
                'install_price' => 12000.00,
                'price_adjustment' => 0,
                'latitude' => 43.2568,
                'longitude' => 76.9287,
                'balance' => 100,
                'is_active' => true,
            ]);
        }

        // 3. Продукты
        $products = [
            ['name' => 'Вода питьевая 0.5L', 'description' => 'Негазированная', 'price' => 150],
            ['name' => 'Coca-Cola 0.5L', 'description' => 'Газированный напиток', 'price' => 200],
            ['name' => 'Чипсы Lays', 'description' => 'Сыр', 'price' => 250],
            ['name' => 'Шоколадный батончик', 'description' => 'Молочный шоколад', 'price' => 180],
            ['name' => 'Сок J7 яблоко', 'description' => 'Прямой отжим', 'price' => 220],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['name' => $product['name']], $product);
        }

        // 4. Устройство (device) для автомата
        Device::updateOrCreate(
            ['mac' => '78:21:84:E2:DA:18'],
            ['name' => 'Rubicon Module Main']
        );

        // 5. Топ-ап (история пополнения) - необязательно, но для теста
        $machine = Machine::where('serial_number', 'RUB-795211')->first();
        if ($machine && !TopUp::where('transaction_id', 'TEST_001')->exists()) {
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