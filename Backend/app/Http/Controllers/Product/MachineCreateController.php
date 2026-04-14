<?php namespace App\Http\Controllers\Product;

use App\Http\Controllers\Product\BaseController;
use App\Http\Requests\Product\MachineCreateRequest;


class MachineCreateController extends BaseController{


    public function __invoke(MachineCreateRequest $request) {
        try {
            $data = $this->service->create($request);
            return $this->success($data, 'Машина успешно создана');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
