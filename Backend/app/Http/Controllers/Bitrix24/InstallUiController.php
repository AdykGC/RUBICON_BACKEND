<?php namespace App\Http\Controllers\Bitrix24;
    // app/Http/Controllers/Bitrix24/InstallUiController.php

use App\Models\BitrixPortal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Log;

class InstallUiController extends Controller
{
    public function __invoke(Request $request) {
        Log::info('InstallUi hit', ['method' => $request->method(), 'all' => $request->all()]);
        /*    curl -X POST "https://rub1c0n.tech/bitrix/install/ui" \ -d "DOMAIN=b24-ykytkl.bitrix24.kz&member_id=test123"    */
        // Bitrix при открытии install UI передаст DOMAIN и/или member_id
        $memberId = $request->input('member_id') ?: $request->input('MEMBER_ID');
        $domain   = $request->input('domain') ?: $request->input('DOMAIN');

        if ($memberId) {
            $portal = BitrixPortal::where('member_id', $memberId)->first();
        } elseif ($domain) {
            $portal = BitrixPortal::where('domain', $domain)->first();
        } else {
            // Можно показать красивую ошибку
            abort(403, 'Missing portal identifier');
        }

        if (!$portal) {
            abort(404, 'Portal not found');
        }

        $applicationTokenFromServer = $portal->application_token;

        return view('bitrix.install', compact('applicationTokenFromServer'));
    }
}