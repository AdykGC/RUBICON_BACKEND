<?php namespace App\Http\Controllers\Hardware;

use App\Http\Controllers\Hardware\BaseController;
use Illuminate\Http\Request;
use App\Models\Device;

class MqttESPRegController extends BaseController{
    public function __invoke(Request $request) {
        $request->validate([
            'mac' => 'required|string',
        ]);

        $device = Device::firstOrCreate(
            ['mac' => $request->mac],
            ['name' => 'ESP32']
        );

        return response()->json([
            'device_id' => $device->id,
            'mac' => $device->mac
        ]);
    }
}
