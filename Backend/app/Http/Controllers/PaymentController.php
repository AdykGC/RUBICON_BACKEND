<?php namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // Получить баланс автомата
    public function getBalanceBySerial($serialNumber)
    {
        $machine = Machine::where('serial_number', $serialNumber)->first();
        if (!$machine) {
            return response()->json(['error' => 'Machine not found'], 404);
        }
        return response()->json(['balance' => $machine->balance]);
    }

    public function topUpBySerial(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|exists:machines,serial_number',
            'amount' => 'required|numeric|min:1',
        ]);

        $machine = Machine::where('serial_number', $request->serial_number)->first();

        DB::beginTransaction();
        try {
            $topUp = TopUp::create([
                'machine_id' => $machine->id,
                'amount' => $request->amount,
                'status' => 'completed',
                'transaction_id' => 'KASPI_' . uniqid(),
            ]);
            $machine->increment('balance', $request->amount);
            DB::commit();

            return response()->json([
                'success' => true,
                'new_balance' => $machine->balance,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ошибка при пополнении'], 500);
        }
    }
}
