<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bitrix24\{ InstallController, DashboardController, };
use App\Http\Middleware\VerifyBitrixSignature;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/bitrix/install', InstallController::class)->name('bitrix.install');
Route::post('/bitrix/uninstall', [InstallController::class, 'uninstall']) ->middleware(VerifyBitrixSignature::class) ->name('bitrix.uninstall');
Route::get('/bitrix/dashboard', DashboardController::class)->name('bitrix.dashboard');