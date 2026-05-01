<?php namespace App\Http\Controllers\Bitrix24;
    // app/Http/Controllers/Bitrix24/InstallUiController.php

use App\Models\BitrixPortal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstallUiController extends Controller
{
    public function __invoke(Request $request)
    {
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