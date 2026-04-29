<?php namespace App\Http\Controllers\MachineAnalytics;

use App\Http\Controllers\MachineAnalytics\BaseController;
use Illuminate\Http\Request;
use App\Models\Machine;


class getParamsController extends BaseController {
    /**
     * @param int $machineId — Laravel автоматически пробросит ID из маршрута
     */
    public function __invoke(Request $request, $machineId)
    {
        try {
            // Вызываем логику из сервиса, который инжектится в BaseController
            $data = $this->service->getMachineDetails($machineId);
            
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }
}