<?php

namespace App\Services\Product;

use App\Models\{Machine, Transaction};
use Illuminate\Support\Facades\Auth;

class MachineAnalyticsService
{
    public function getMachineDetails($machineId)
    {
        // Ищем автомат конкретного пользователя
        $machine = Machine::where('id', $machineId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$machine) {
            throw new \Exception('Автомат не найден или доступ запрещен');
        }

        // Считаем доход только по успешным транзакциям
        $totalRevenue = Transaction::where('machine_id', $machineId)
            ->where('status', 'completed')
            ->sum('amount');

        return [
            'info' => $machine,
            'analytics' => [
                'total_revenue' => (float)$totalRevenue,
                'transactions_count' => Transaction::where('machine_id', $machineId)->count(),
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