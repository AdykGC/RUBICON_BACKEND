<?php namespace App\Http\Controllers\Hardware;

use App\Http\Controllers\Hardware\BaseController;
Use App\Http\Requests\Hardware\MqttMqttCommandRequest;
use App\Models\Machine;
use App\Models\Device;

class MqttCommandController extends BaseController {
    public function __invoke(MqttMqttCommandRequest $request) {
        $machine = Machine::where('serial_number', $request->serial_number)->first();
        $pulses = (int) floor($request->amount / 5); // 1 pulse = 5 тг
        $deviceMac = '78:21:84:E2:DA:18';
        $device = Device::where('mac', $deviceMac)->first();
        if (!$device) { return response()->json(['message' => 'Device not found'], 404); }
        return $this->service->create_command($machine, $pulses, $device, $request->amount);
    }
}