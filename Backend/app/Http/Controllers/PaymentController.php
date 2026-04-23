<?php namespace App\Http\Controllers;

use App\Models\Machine;

class PaymentController extends Controller
{
    // Получить баланс автомата
    public function getBalanceBySerial($serialNumber) {
        $machine = Machine::where('serial_number', $serialNumber)->first();
        if (!$machine) { return response()->json(['error' => 'Machine not found'], 404); }
        return response()->json(['balance' => $machine->balance]);
    }
}