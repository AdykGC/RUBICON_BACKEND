<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Hardware\MqttCommandController;


use Illuminate\Http\Request;
#Route::get('/', function () { return view('welcome'); });

Route::get('/', function () { return view('website.rubicon'); })->name('home');
Route::get('/product', function () { return view('website.product'); })->name('product');
Route::get('/pay', function (Request $request) { return view('website.pay', [ 'machineId' => $request->get('id', '78:21:84:E2:DA:18') ]); })->name('pay');

// (методы работают с serial_number)
Route::get('/machine/balance/{serialNumber}', [PaymentController::class, 'getBalanceBySerial']);
Route::post('/machine/topup', MqttCommandController::class);









/* ********************************    BITRIX 24    ******************************** */
Route::view('/license', 'legal.license');
Route::view('/privacy', 'legal.privacy');


/*                   MAIN VERSION                 */
use App\Http\Controllers\Bitrix24\{
    InstallController, UninstallController,
    DashboardController,
    PlacementController, EventController,
};

/*                   LITE VERSION                 */
use App\Http\Controllers\Bitrix24\{
    InstallLiteController,
};


Route::middleware('bitrix')->prefix('bitrix')->group(function () {
    // full install, если используется
    Route::any('/install', InstallController::class)->name('bitrix.install');


/* ---------------------------------------------- */
/*                   LITE VERSION                 */
/* ---------------------------------------------- */
    // Route::any('/install-lite', InstallLiteController::class) ->name('bitrix.install-lite');

    // iframe мастера установки (если нужен)
    Route::any('/install/ui', function () {
        return view('bitrix.install', [
            'applicationTokenFromServer' => '...',
        ]);
    })->name('bitrix.install.ui');

    // uninstall / events / placement / dashboard
    Route::post('/uninstall', [UninstallController::class, '__invoke'])
        ->name('bitrix.uninstall');

    Route::any('/dashboard', DashboardController::class)
        ->name('bitrix.dashboard');

    Route::any('/placement/{placement}', [PlacementController::class, '__invoke'])
        ->name('bitrix.placement');

    Route::post('/events/{event}', [EventController::class, '__invoke'])
        ->name('bitrix.events');
});