<?php namespace App\Http\Controllers\Bitrix24;

use App\Models\BitrixPortal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


class InstallLiteController extends Controller {
    public function __invoke(Request $request)
{
    if ($request->isMethod('head') || $request->isMethod('get')) {
        return response('OK', 200);
    }

    if (!$request->isMethod('post')) {
        return response('Method not allowed', 405);
    }

    // Упрощённый сценарий: сразу приходят access_token, refresh_token и т.д. в auth
    $event = $request->input('event');
    $auth  = $request->input('auth', []);

    if ($event !== 'ONAPPINSTALL' || empty($auth['member_id']) || empty($auth['domain'])) {
        return response('Bad install payload', 400);
    }

    BitrixPortal::updateOrCreate(
        ['member_id' => $auth['member_id']],
        [
            'domain'            => $auth['domain'],
            'access_token'      => $auth['access_token'] ?? null,
            'refresh_token'     => $auth['refresh_token'] ?? null,
            'application_token' => $auth['application_token'] ?? null,
            'client_endpoint'   => $auth['client_endpoint'] ?? "https://{$auth['domain']}/rest/",
            'expires_at'        => now()->addSeconds($auth['expires_in'] ?? 3600),
        ]
    );

    return response('', 200);
}
}
