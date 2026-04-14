<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\User\BaseController;
use App\Http\Requests\User\UserRegisterRequest;

class UserRegisterController extends BaseController{
    public function __invoke(UserRegisterRequest $request) {


        try {
            $data = $this->service->register($request);
            return $this->success($data, 'Вход успешен');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 401);
        }
    }
}
