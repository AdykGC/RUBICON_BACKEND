<?php

namespace App\Http\Controllers\Bitrix24;

use App\Http\Controllers\Controller;
use App\Models\BitrixPortal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstallLiteController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::info('INSTALL_LITE request', [
            'method' => $request->method(),
            'url'    => $request->fullUrl(),
            'all'    => $request->all(),
        ]);

        // 1. Разбираем payload установки (как сейчас)
        $memberId   = $request->input('member_id');
        $domain     = $request->input('DOMAIN');
        $authId     = $request->input('AUTH_ID');
        $refreshId  = $request->input('REFRESH_ID');
        $expiresIn  = (int) $request->input('AUTH_EXPIRES', 3600);
        $appToken   = $request->input('APPLICATION_TOKEN');
        $scope      = $request->input('APPLICATION_SCOPE');
        $endpoint   = $request->input('SERVER_ENDPOINT');

        if (empty($memberId) || empty($domain) || empty($authId)) {
            Log::warning('Bad install payload (lite)', [
                'member_id' => $memberId,
                'domain'    => $domain,
                'AUTH_ID'   => $authId,
            ]);
            return response('Bad install payload', 400);
        }

        BitrixPortal::updateOrCreate(
            ['member_id' => $memberId],
            [
                'domain'            => $domain,
                'access_token'      => $authId,
                'refresh_token'     => $refreshId,
                'application_token' => $appToken,
                'client_endpoint'   => $endpoint,
                'scope'             => $scope,
                'expires_at'        => now()->addSeconds($expiresIn),
            ]
        );

        Log::info('BitrixPortal saved (lite)', ['member_id' => $memberId]);

        // 2. Всегда возвращаем HTML, а не пустой 200
        // Вариант 1: Белый пустой IFRAME
        //return response('', 200);
        
        // Вариант 2: Сразу дашборд
        //return view('bitrix.dashboard');
        
        // Вариант 3: Сперва мастер установки
        return view('bitrix.install', [ 'applicationTokenFromServer' => $appToken ?? '', ]);
    }
}