<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        Device::updateOrCreate(
            ['mac' => '78:21:84:E2:DA:18'],
            ['name' => 'Rubicon Module Main']
        );

        Device::factory(3)->create();
    }
}