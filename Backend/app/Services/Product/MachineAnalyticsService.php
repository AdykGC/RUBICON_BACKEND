<?php

namespace App\Services\Product;

use App\Models\{Machine, Transaction};
use Illuminate\Support\Facades\Auth;

class MachineAnalyticsService
{
    public function getMachineDetails($machineId)
{
    $machine = Machine::where('id', $machineId)
        ->where('user_id', Auth::id())
        ->first();

    if (!$machine) {
        throw new \Exception('Автомат не найден или доступ запрещен');
    }

    $baseQuery = Transaction::where('machine_id', $machineId)
        ->where('status', 'completed');

    // 💰 Общая выручка
    $totalRevenue = (clone $baseQuery)->sum('amount');

    // 🔢 Кол-во транзакций (только completed!)
    $transactionsCount = (clone $baseQuery)->count();

    // 📅 Разбивка по дням
    $daily = (clone $baseQuery)
        ->selectRaw('DATE(created_at) as date, SUM(amount) as revenue, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->map(function ($row) {
            return [
                'date' => $row->date,
                'revenue' => (float) $row->revenue,
                'count' => (int) $row->count,
            ];
        });

    return [
        'info' => $machine,
        'analytics' => [
            'total_revenue' => (float) $totalRevenue,
            'transactions_count' => (int) $transactionsCount,
            'daily' => $daily,
        ]
    ];
}

    public function list()
    {
        return Machine::where('user_id', Auth::id())->get();
    }

    public function index()
    {
        return []; // Исправлено: добавлена точка с запятой
    }
}