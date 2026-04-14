<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BITRIX\{ BitrixOAuthController, OAuthRedirectController, OAuthCallbackController, Bitrix24SaleController, };

Route::get('/', function () {
    return view('welcome');
});
// https://80cb-2-72-34-5.ngrok-free.app/bitrix/oauth/redirect
#Route::get('/bitrix/oauth/redirect', [BitrixOAuthController::class, 'redirectToProvider']);   #   → редирект в Bitrix
#Route::get('/bitrix/oauth/callback', [BitrixOAuthController::class, 'handleCallback']);   #   → получаем токен

Route::get('/bitrix/oauth/redirect', [OAuthRedirectController::class, 'redirectToProvider']);
Route::get('/bitrix/oauth/callback', [OAuthCallbackController::class, 'handleCallback']);



// https://80cb-2-72-34-5.ngrok-free.app/sales/2/send-bitrix
Route::get('/sales/{sale}/send-bitrix', [Bitrix24SaleController::class, 'sendToBitrix']);   #   → отправка сделки



// https://80cb-2-72-34-5.ngrok-free.app/bitrix/test
Route::get('/bitrix/test', function () { return view('bitrix.TestPage1'); });