<?php namespace App\Http\Controllers\User;

use App\Services\User\UserService;

class BaseController{
    public $service;
    public function __construct(UserService $service){
        $this->service = $service;
    }

    /* Успешный ответ */
    protected function success($data = null, string $message = '', int $code = 200) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    /* Ошибка */
    protected function error(string $message = '', int $code = 400, $errors = null) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}