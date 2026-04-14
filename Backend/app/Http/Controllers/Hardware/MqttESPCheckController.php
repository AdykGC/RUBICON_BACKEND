<?php namespace App\Http\Controllers\Hardware;

use App\Http\Controllers\Hardware\BaseController;
use App\Models\Device;
use Illuminate\Http\Request;

class MqttESPCheckController extends BaseController {
    public function __invoke($mac) {
        $device = Device::where('mac', $mac)->first();
        if (!$device) { return response(0); }

        // пока тестовая логика
        // позже сюда подключишь платежи / задания
        $pulses = 12;

        return response($pulses);
    }
}