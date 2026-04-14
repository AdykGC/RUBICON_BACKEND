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

            $machine->update($request->validated());
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