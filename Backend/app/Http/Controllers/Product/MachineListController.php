<?php namespace App\Http\Controllers\Product;

use App\Http\Controllers\Product\BaseController;
use Illuminate\Http\Request;


class MachineListController extends BaseController{


    public function __invoke() {
        try {
            $data = $this->service->index();
            return $this->success($data, 'Машины успешно получены');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
