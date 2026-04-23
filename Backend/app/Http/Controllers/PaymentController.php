<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // Получить баланс автомата
    public function getBalance($id)
    {
        $machine = Machine::find($id);
        if (!$machine) {
            return response()->json(['error' => 'Machine not found'], 404);
        }
        return response()->json(['balance' => $machine->balance]);
    }

    // Пополнение баланса
    public function topUp(Request $request)
    {
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $machine = Machine::find($request->machine_id);

        // Здесь вы должны интегрироваться с Kaspi QR API для реальной оплаты
        // Сейчас эмуляция успешной оплаты

        DB::beginTransaction();
        try {
            // Создаём запись о пополнении
            $topUp = TopUp::create([
                'machine_id' => $machine->id,
                'amount' => $request->amount,
                'status' => 'completed',
                'transaction_id' => 'KASPI_' . uniqid(),
            ]);

            // Увеличиваем баланс автомата
            $machine->increment('balance', $request->amount);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Баланс успешно пополнен',
                'new_balance' => $machine->balance,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ошибка при пополнении'], 500);
        }
    }
}