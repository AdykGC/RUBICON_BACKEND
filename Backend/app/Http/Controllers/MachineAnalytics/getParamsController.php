<?php namespace App\Http\Controllers\MachineAnalytics;

use App\Http\Controllers\MachineAnalytics\BaseController;
use Illuminate\Http\Request;
use App\Models\Machine;

class getParamsController extends BaseController
{
    /**
     * @param int $machineId — Laravel пробрасывает ID из URL {machineId}
     */
    public function __invoke(Request $request, $machineId)
    {
        try {
            // ВАЖНО: Присваиваем результат вызова сервиса переменной $data
            $data = $this->service->getMachineDetails($machineId);
            
            return $this->success($data);
        } catch (\Exception $e) {
            // Если автомат не найден или ошибка в SQL — вернет 404/400 вместо 500
            return $this->error($e->getMessage(), 404);
        }
    }
}