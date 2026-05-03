<?php namespace App\Http\Controllers\Bitrix24;

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

        // 1) Принимаем только POST с ONAPPINSTALL
        if (! $request->isMethod('post')) {
            return response('Method not allowed', 405);
        }

        $event = $request->input('event');
        $auth  = $request->input('auth', []);

        if ($event !== 'ONAPPINSTALL' || empty($auth['member_id']) || empty($auth['domain'])) {
            Log::warning('Bad install payload', ['event' => $event, 'auth' => $auth]);
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

        Log::info('BitrixPortal saved', ['member_id' => $auth['member_id']]);

        return response('', 200);
    }
}