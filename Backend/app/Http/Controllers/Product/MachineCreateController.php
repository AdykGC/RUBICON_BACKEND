<?php namespace App\Http\Controllers\Product;

use App\Http\Controllers\Product\BaseController;
use App\Http\Requests\Product\MachineCreateRequest;


class MachineCreateController extends BaseController{
    public function __invoke(MachineCreateRequest $request) {
        $data = $this->service->create($request);
        return $data;
    }
}
