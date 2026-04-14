<?php namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\User\BaseController;
use Illuminate\Http\Request;

class GetUserController extends BaseController{

    public function __invoke(Request $request) {
        /** @var User $user */
        $user = $request->user();
        return $this->service->read($user);
    }
}
