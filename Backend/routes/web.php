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


// Install / uninstall
Route::any('/bitrix/install', InstallController::class) ->name('bitrix.install');
Route::post('/bitrix/uninstall', [UninstallController::class, '__invoke']) ->middleware(VerifyBitrixSignature::class) ->name('bitrix.uninstall');

// страница мастера установки (iframe в Битриксе)
Route::any('/bitrix/install/ui', InstallUiController::class) ->name('bitrix.install.ui');


// Dashboard iframe
Route::any('/bitrix/dashboard', DashboardController::class) ->name('bitrix.dashboard');


// Placements (CRM tabs, buttons)
Route::any('/bitrix/placement/{placement}', [PlacementController::class, '__invoke']) ->middleware(VerifyBitrixSignature::class) ->name('bitrix.placement');


// Events (ONCRMDEALADD, etc.)
Route::post('/bitrix/events/{event}', [EventController::class, '__invoke']) ->middleware(VerifyBitrixSignature::class) ->name('bitrix.events');

// Минимум HTML + Bitrix JS
Route::any('/bitrix/install/ui-plain', function () {
    return response(<<<HTML
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Rub1c0n install wizard</title>
    <script src="https://api.bitrix24.com/api/v1/"></script>
</head>
<body>
<script>
BX24.init(function () {
    BX24.fitWindow();

    BX24.callMethod('placement.bind', {
        PLACEMENT: 'CRM_DEAL_DETAIL_TAB',
        HANDLER: 'https://rub1c0n.tech/bitrix/placement/deal-tab',
        TITLE: 'Rub1c0n',
        DESCRIPTION: 'Виджет сделки'
    });

    BX24.callMethod('event.bind', {
        event: 'ONCRMDEALADD',
        handler: 'https://rub1c0n.tech/bitrix/events/crm-deal-add'
    });

    BX24.installFinish();
});
</script>
</body>
</html>
HTML, 200)->header('Content-Type', 'text/html; charset=utf-8');
});