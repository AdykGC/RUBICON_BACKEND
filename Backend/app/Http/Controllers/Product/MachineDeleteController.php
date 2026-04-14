<?php namespace App\Http\Controllers\Product;

use App\Models\Machine;
use App\Http\Controllers\Product\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class MachineDeleteController extends BaseController {
    public function __invoke($id) {
        try {
            $machine = Machine::where('user_id', Auth::id())->findOrFail($id);
            $machine->delete();
            return $this->success( null, 'Машина успешно удалена' );
        } catch (ModelNotFoundException $e) {
            return $this->error('Машина не найдена', 404);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
