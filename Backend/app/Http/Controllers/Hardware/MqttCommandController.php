<?php namespace App\Http\Controllers\Hardware;

use App\Http\Controllers\Hardware\BaseController;
Use App\Http\Requests\Hardware\MqttMqttCommandRequest;
use App\Models\Machine;
use App\Models\Device;

class MqttCommandController extends BaseController {
    public function __invoke(MqttMqttCommandRequest $request) {
        $machine = Machine::where('mac_address', $request->mac_address)->first();
        $pulses = (int) floor($request->amount / 5); // 1 pulse = 5 тг
        return $this->service->create_command($machine, $pulses, $request->amount);
    }
}