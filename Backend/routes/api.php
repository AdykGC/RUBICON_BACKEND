<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\User\{ GetUserController, UserLoginController, UserRegisterController, UserLogoutController, UserUpdateController };
use App\Http\Controllers\Product\{ MachineCreateController, MachineListController, MachineUpdateController, MachineDeleteController };
use App\Http\Controllers\MachineAnalytics\{ getParamsController };

use App\Http\Controllers\TestController;


// Тестовые маршруты (публичные)
Route::get('/test', [TestController::class, 'test']);
Route::get('/cors-test', [TestController::class, 'corsTest']);

Route::middleware('auth:sanctum')->get('/user', action: function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('/register',                  UserRegisterController::class);//->middleware('throttle:5,1')
    Route::post('/login',                     UserLoginController::class)->middleware('throttle:5,1');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout',                             UserLogoutController::class);
        Route::get('/user',                                GetUserController::class);
        Route::patch('/update',                             UserUpdateController::class);
    });
});

Route::prefix('machines')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/create',                              MachineCreateController::class);
        Route::get('/',                                     MachineListController::class);
        Route::patch('/update/{id}',                        MachineUpdateController::class);
        Route::post('/delete/{id}',                         MachineDeleteController::class);
    });
});








Route::prefix('analytics')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/machine/{machineId}',                                  getParamsController::class);
    });
});


/* ********************************    BITRIX 24    ******************************** */
/*                   LITE VERSION                 */
use App\Http\Controllers\Bitrix24\{
    InstallLiteController, DashboardLiteController, 
};

/* ---------------------------------------------- */
/*                   LITE VERSION                 */
/* ---------------------------------------------- */
// HEAD/GET для проверки доступности URL — отдаём 200 сразу
Route::match(['GET', 'HEAD'], '/bitrix/install-lite', function (Request $request) {
    return response('', 200);
});
Route::post('/bitrix/install-lite', InstallLiteController::class);


Route::match(['GET', 'HEAD'], '/bitrix/dashboard-lite', function (Request $request) {
    return response('', 200);
});
Route::post('/bitrix/dashboard-lite', DashboardLiteController::class);