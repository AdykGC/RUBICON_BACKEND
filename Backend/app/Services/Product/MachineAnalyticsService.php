<?php

namespace App\Services\Product;

use App\Models\{
    Machine, Transaction
};
use Carbon\Carbon;
use Illuminate\Http\Request;

class MachineAnalyticsService
{

    public function list()
    {
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

    public function getAnalytics($machineId, $start, $end)
    {
        $query = Transaction::where('machine_id', $machineId)
            ->where('status', 'completed')
            ->whereBetween('created_at', [$start, $end]);

        $revenue = $query
            ->selectRaw('DATE(created_at) as day, SUM(amount) as amount')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->map(fn($r) => [
                'day' => (int) date('d', strtotime($r->day)),
                'amount' => (float) $r->amount,
            ]);

        $sales = $query
            ->selectRaw('DATE(created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->map(fn($r) => [
                'day' => (int) date('d', strtotime($r->day)),
                'count' => (int) $r->count,
            ]);

        $totalRevenue = $query->sum('amount');
        $totalTransactions = $query->count();

        return [
            'revenue' => $revenue,
            'sales' => $sales,
            'summary' => [
                'totalRevenue' => (float) $totalRevenue,
                'totalTransactions' => $totalTransactions,
                'avgCheck' => $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0,
            ]
        ];
    }
}
