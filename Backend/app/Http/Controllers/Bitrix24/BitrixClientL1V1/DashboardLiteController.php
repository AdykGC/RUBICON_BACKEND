<?php

namespace App\Http\Controllers\Bitrix24\BitrixClientL1V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardLiteController extends Controller
{
    public function __invoke(Request $request)
    {
        $workflow = [
            [
                'id' => 1,
                'type' => 'trigger',
                'name' => 'Лид создан',
                'x' => 100,
                'y' => 100,
            ],
            [
                'id' => 2,
                'type' => 'action',
                'name' => 'Создать задачу',
                'x' => 100,
                'y' => 250,
            ],
        ];

        return view('Bitrix24.BitrixClientL1V1.workflow.builder', ['workflow' => $workflow]);
    }
}
