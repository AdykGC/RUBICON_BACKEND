<?php namespace Database\Seeders;

use App\Models\User;
use App\Models\Machine;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@rubicon.com',
                'password' => bcrypt('password'),
            ]);
        }

        Machine::updateOrCreate(
            ['serial_number' => 'RUB-795211'],
            [
                'name' => 'Тестовый автомат Rubicon',
                'type' => 'Drink',
                'location' => 'Офис, 1 этаж',
                'user_id' => $user->id,
                'connection_type' => '4G',
                'install_price' => 15000,
                'price_adjustment' => 0,
                'latitude' => 43.2567,
                'longitude' => 76.9286,
                'balance' => 0,
                'is_active' => true,
            ]
        );

        if (Machine::count() < 6) {
            Machine::factory(5)->create(['user_id' => $user->id]);
        }
    }
}