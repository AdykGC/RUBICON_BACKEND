<?php namespace App\Services\Product;

use App\Models\{
    Machine,
};
use Carbon\Carbon;
use Illuminate\Http\Request;

class MachineAnalyticsService {

    public function list() {
        try {
            $machines = Machine::where('user_id', auth()->id())->get();
            return $machines;
        } catch (\Exception $e) {
            throw new \Exception('Ошибка при получении списка: ' . $e->getMessage());
        }
    }

    public function index()
    {
        return [
            'revenue' => [
                ['x' => 0, 'y' => 100],
                ['x' => 1, 'y' => 200],
            ],
            'sales' => [
                ['x' => 0, 'y' => 10],
                ['x' => 1, 'y' => 20],
            ],
            'products' => [
                ['name' => 'Snacks', 'value' => 40],
                ['name' => 'Drinks', 'value' => 30],
            ],
        ];
    }

    public function getAnalytics()
    {
        return [ 'Return' ];
    }
}