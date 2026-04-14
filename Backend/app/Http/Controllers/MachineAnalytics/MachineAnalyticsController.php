<?php namespace App\Http\Controllers\MachineAnalytics;

use App\Http\Controllers\MachineAnalytics\BaseController;
use Illuminate\Http\Request;


class MachineAnalyticsController extends BaseController{


    public function __invoke() {
        try {
            $data = $this->service->index();
            return $this->success($data, 'Машины успешно получены');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
