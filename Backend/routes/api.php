<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\User\{ GetUserController, UserLoginController, UserRegisterController, UserLogoutController, UserUpdateController };
use App\Http\Controllers\Product\{ MachineCreateController, MachineListController, MachineUpdateController, MachineDeleteController };
use App\Http\Controllers\MachineAnalytics\{ getParamsController };
use App\Http\Controllers\Hardware\{ MqttESPRegController, MqttCommandController };


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
        Route::get('/machine/{machine}',                                  getParamsController::class);
        //Route::post('/create',                              MachineCreateController::class);
        //Route::patch('/update/{id}',                        MachineUpdateController::class);
        //Route::post('/delete/{id}',                         MachineDeleteController::class);
    });
});


/*
2. НОВАЯ АРХИТЕКТУРА (MQTT system)
    Это модель: “сервер управляет устройствами”
FLOW:
1. HTTP → Laravel создаёт команду
2. Laravel → MQTT publish
3. ESP32 → выполняет
4. ESP32 → MQTT ACK
5. Laravel → фиксирует результат
*/

// https://f6a1-2-72-243-255.ngrok-free.app/api________
Route::post('/devices/register', MqttESPRegController::class);
Route::post('/device/command', MqttCommandController::class);

