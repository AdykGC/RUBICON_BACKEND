<?php namespace App\Services\Product;

use App\Models\{
    Machine,
    Sale,
    Product,
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

    public function getAnalytics($machineId, $startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // 1. Выручка по дням
        $revenue = Sale::where('machine_id', $machineId)
            ->whereBetween('sales.created_at', [$start, $end])
            ->selectRaw('DATE(sales.created_at) as day, SUM(sales.total) as amount')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->map(function ($item) use ($start) {
                $dayNumber = Carbon::parse($item->day)->diffInDays($start);
                return [
                    'day' => $dayNumber,
                    'amount' => (float) $item->amount,
                ];
            })->values()->toArray();

        // 2. Продажи по дням (количество единиц)
        $salesData = Sale::where('machine_id', $machineId)
            ->whereBetween('sales.created_at', [$start, $end])
            ->selectRaw('DATE(sales.created_at) as day, SUM(sales.quantity) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->map(function ($item) use ($start) {
                $dayNumber = Carbon::parse($item->day)->diffInDays($start);
                return [
                    'day' => $dayNumber,
                    'count' => (int) $item->count,
                ];
            })->values()->toArray();

        // 3. Популярность товаров (проценты)
        $totalQuantity = Sale::where('machine_id', $machineId)
            ->whereBetween('sales.created_at', [$start, $end])
            ->sum('sales.quantity');

        $productStats = Sale::where('machine_id', $machineId)
            ->whereBetween('sales.created_at', [$start, $end])
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->selectRaw('products.name as product_name, SUM(sales.quantity) as total')
            ->groupBy('products.id', 'products.name')
            ->get();

        $popularity = $productStats->map(function ($stat) use ($totalQuantity) {
            $percentage = $totalQuantity > 0 ? round(($stat->total / $totalQuantity) * 100, 2) : 0;
            return [
                'product_name' => $stat->product_name,
                'percentage' => (float) $percentage,
            ];
        })->values()->toArray();

        return [
            'revenue' => $revenue,
            'sales' => $salesData,
            'popularity' => $popularity,
        ];
    }
}