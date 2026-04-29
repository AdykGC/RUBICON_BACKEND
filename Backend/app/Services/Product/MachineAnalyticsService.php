<?php

namespace App\Services\Product;

use App\Models\{Machine, Transaction};
use Illuminate\Support\Facades\Auth;

class MachineAnalyticsService
{
    public function getMachineDetails($machineId)
    {
        // Ищем автомат, принадлежащий текущему пользователю
        $machine = Machine::where('id', $machineId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$machine) {
            throw new \Exception('Автомат не найден или у вас нет доступа');
        }

        // Пример получения статистики (сумма успешных транзакций)
        $totalRevenue = Transaction::where('machine_id', $machineId)
            ->where('status', 'completed')
            ->sum('amount');

        return [
            'info' => $machine,
            'analytics' => [
                'total_revenue' => $totalRevenue,
                'transactions_count' => Transaction::where('machine_id', $machineId)->count(),
            ]
        ];
    }

    public function list()
    {
        return Machine::where('user_id', Auth::id())->get();
    }
}