<?php namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\User\BaseController;
use Illuminate\Http\Request;

class UserLogoutController extends BaseController{
    public function __invoke(Request $request) {
        /** @var User $user */
        $request->user()->currentAccessToken()->delete();
        return $this->service->logout();
    }
}
