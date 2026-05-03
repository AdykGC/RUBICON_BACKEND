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


#Route::get('/license', function () { return view('legal.license'); });
#Route::get('/privacy', function () { return view('legal.privacy'); });
#    Route::any('/bitrix/install', InstallController::class)->name('bitrix.install');
#    Route::post('/bitrix/uninstall', [InstallController::class, 'uninstall']) ->middleware(VerifyBitrixSignature::class) ->name('bitrix.uninstall');
#    Route::get('/bitrix/dashboard', DashboardController::class)->name('bitrix.dashboard');



/* ********************************    BITRIX 24    ******************************** */
use App\Http\Controllers\Bitrix24\{
    InstallController,
    UninstallController,
    DashboardController,
    PlacementController,
    EventController
};
use App\Http\Controllers\Bitrix24\InstallUiController;
use App\Http\Middleware\VerifyBitrixSignature;

// Legal
Route::view('/license', 'legal.license');
Route::view('/privacy', 'legal.privacy');






// 1) Общая установка приложения (REST, не iframe)
Route::any('/bitrix/install', InstallController::class)
    ->name('bitrix.install');


// 2) Страница мастера установки (iframe в Битриксе)
Route::any('/bitrix/install/ui', function () {
    // TODO: здесь вместо '...' передай реальный токен из БД, если он нужен
    return view('bitrix.install', [
        'applicationTokenFromServer' => '...',
    ]);
})->name('bitrix.install.ui');


// 2) Uninstall
Route::post('/bitrix/uninstall', [UninstallController::class, '__invoke']) ->middleware(VerifyBitrixSignature::class) ->name('bitrix.uninstall');

// 3) Мастер установки в iframe (UI)
Route::any('/bitrix/install/ui', InstallUiController::class) ->name('bitrix.install.ui');

// 4) Dashboard iframe
Route::any('/bitrix/dashboard', DashboardController::class) ->name('bitrix.dashboard');

// 5) Placements (например CRM_DEAL_DETAIL_TAB)
Route::any('/bitrix/placement/{placement}', [PlacementController::class, '__invoke']) ->middleware(VerifyBitrixSignature::class) ->name('bitrix.placement');

// 6) Events (ONCRMDEALADD и т.п.)
Route::post('/bitrix/events/{event}', [EventController::class, '__invoke']) ->middleware(VerifyBitrixSignature::class) ->name('bitrix.events');

// 7) Облегчённый мастер установки
Route::match(['get', 'post'], '/bitrix/install/ui-lite', function () { return view('bitrix.install-lite'); })->name('bitrix.install.ui-lite');