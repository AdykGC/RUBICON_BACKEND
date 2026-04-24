<?php namespace App\Http\Controllers\Product;

use App\Models\Machine;
use App\Http\Controllers\Product\BaseController;
use App\Http\Requests\Product\MachineUpdateRequest;

use Illuminate\Support\Facades\Auth;

class MachineUpdateController extends BaseController{

    // Список аппаратов текущего пользователя
    public function __invoke(MachineUpdateRequest $request, $id) {
        try {
            $machine = Machine::where('user_id', Auth::id())->findOrFail($id);

            // 1. обновляем данные
            $machine->update($request->validated());
            // 2. обновляем qr_code (после обновления serial_number)
            if ($machine->serial_number) {
                $machine->qr_code = "http://213.155.20.92/pay?id=" . $machine->serial_number;
            } else {
                $machine->qr_code = null;
            }
            $machine->save();

            $machine->refresh();

            return $this->success(
                ['machine' => $machine],
                'Машина успешно обновлена'
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}