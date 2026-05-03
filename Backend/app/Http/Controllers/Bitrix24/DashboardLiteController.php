<?php

namespace App\Http\Controllers\Bitrix24;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardLiteController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::info('DASHBOARD_LITE request', [
            'method' => $request->method(),
            'url'    => $request->fullUrl(),
            'all'    => $request->all(),
        ]);

        // Пока userInfo можем оставить пустым или заполнить минимумом
        $userInfo = [
            'NAME'  => $request->input('user_name'),   // если когда‑нибудь начнёшь прокидывать
            'EMAIL' => $request->input('user_email'),
        ];

        return view('bitrix.dashboard', compact('userInfo'));
    }
}