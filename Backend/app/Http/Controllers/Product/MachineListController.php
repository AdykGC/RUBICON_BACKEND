<?php namespace App\Http\Controllers\Product;

use App\Http\Controllers\Product\BaseController;
use Illuminate\Http\Request;


class MachineListController extends BaseController{


    public function __invoke() {
        $data = $this->service->index();
        return $data;
    }
}
