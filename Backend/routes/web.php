<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bitrix24\{ InstallController, DashboardController, };
use App\Http\Middleware\VerifyBitrixSignature;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Hardware\MqttCommandController;


use Illuminate\Http\Request;
#Route::get('/', function () { return view('welcome'); });

Route::get('/', function () { return view('website.rubicon'); })->name('home');
Route::get('/product', function () { return view('website.product'); })->name('product');
Route::get('/pay', function (Request $request) { return view('website.pay', [ 'machineId' => $request->get('id', '78:21:84:E2:DA:18') ]); })->name('pay');



Route::any('/bitrix/install', InstallController::class)->name('bitrix.install');
Route::post('/bitrix/uninstall', [InstallController::class, 'uninstall']) ->middleware(VerifyBitrixSignature::class) ->name('bitrix.uninstall');
Route::get('/bitrix/dashboard', DashboardController::class)->name('bitrix.dashboard');


Route::get('/license', function () { return view('legal.license'); });
Route::get('/privacy', function () { return view('legal.privacy'); });





// (методы работают с serial_number)
Route::get('/machine/balance/{serialNumber}', [PaymentController::class, 'getBalanceBySerial']);
Route::post('/machine/topup', MqttCommandController::class);