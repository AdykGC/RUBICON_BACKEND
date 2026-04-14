<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Простой тестовый эндпоинт
     */
    public function test()
    {
        return response()->json([
            'message' => 'API работает!',
            'timestamp' => now(),
            'data' => [
                'status' => 'success',
                'version' => '1.0.0'
            ]
        ]);
    }

    /**
     * Тест аутентификации
     */
    public function authTest(Request $request)
    {
        return response()->json([
            'message' => 'Аутентификация работает!',
            'user' => $request->user(),
            'authenticated' => auth()->check()
        ]);
    }

    /**
     * Тест CORS
     */
    public function corsTest()
    {
        return response()->json([
            'message' => 'CORS работает!',
            'allowed_origins' => config('cors.allowed_origins', []),
            'supports_credentials' => config('cors.supports_credentials', false)
        ]);
    }
}