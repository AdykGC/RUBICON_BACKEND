<?php namespace App\Http\Controllers\Hardware;

use App\Http\Controllers\Hardware\BaseController;
Use App\Http\Requests\Hardware\MqttMqttCommandRequest;
use App\Models\Device;
use App\Models\DeviceCommand;
use Illuminate\Support\Str;

class MqttCommandController extends BaseController {
    public function __invoke(MqttMqttCommandRequest $request) {
        $device = Device::where('mac', $request->mac)->first();
        if (!$device) { return response()->json(['message' => 'Device not found'], 404); }

        // 1. создаём команду
        $command = DeviceCommand::create([
            'device_id' => $device->id,
            'command_id' => Str::uuid(),
            'action' => 'water',
            'pulses' => $request->pulses,
            'status' => 'pending'
        ]);
        $topic = "device/{$device->mac}";
        // 2. отправляем MQTT
        $this->service->publish($topic, [
            'command_id' => $command->command_id,
            'action' => 'water',
            'pulses' => $request->pulses
        ]);
        // 3. отмечаем как sent
        $command->update(['status' => 'sent']);
        return response()->json([
            'status' => 'sent',
            'command_id' => $command->command_id
        ]);
    }
}