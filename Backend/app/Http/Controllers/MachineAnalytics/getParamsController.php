<?php namespace App\Http\Controllers\MachineAnalytics;

use App\Http\Controllers\MachineAnalytics\BaseController;
use Illuminate\Http\Request;
use App\Models\Machine;

class getParamsController extends BaseController{

public function __invoke(Request $request, $machineId)
    {
        // Валидируем входные параметры (даты)
        $request->validate([
            'start' => 'required|date',
            'end'   => 'required|date|after_or_equal:start',
        ]);

        // Проверяем существование аппарата
        if (!Machine::where('id', $machineId)->exists()) {
            return $this->error('Machine not found', 404);
        }

        try {
            $data = $this->service->getAnalytics(
                $machineId,
                $request->start,
                $request->end
            );
            return $this->success($data, 'Аналитика успешно получена');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
