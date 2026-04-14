<?php namespace App\Http\Controllers\Hardware;

use App\Http\Controllers\Hardware\BaseController;
use Illuminate\Http\Request;
use App\Models\Device;

class MqttCommandController extends BaseController {
    public function __invoke(Request $request) {
        $request->validate([
            'mac' => 'required|string',
            'pulses' => 'required|integer|min:1',
        ]);

        $device = Device::where('mac', $request->mac)->first();

        if (!$device) {
            return response()->json([
                'message' => 'Device not found'
            ], 404);
        }

        $topic = "device/{$device->mac}";

        $this->service->publish($topic, [
            'action' => 'water',
            'pulses' => $request->pulses
        ]);

        return response()->json([
            'status' => 'sent',
            'mac' => $device->mac,
            'pulses' => $request->pulses
        ]);
    }
}