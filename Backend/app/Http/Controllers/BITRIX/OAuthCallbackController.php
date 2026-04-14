<?php namespace App\Http\Controllers\BITRIX;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\BitrixToken;

class OAuthCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        // dd($request->all());
        $code = $request->query('code');
        if (!$code) {
            return "Ошибка: код авторизации не получен";
        }

        // Обмениваем code на токен
        $response = Http::asForm()->post('https://oauth.bitrix24.tech/oauth/token/', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.bitrix.client_id'),
            'client_secret' => config('services.bitrix.client_secret'),
            'code' => $code,
            'redirect_uri' => config('services.bitrix.redirect_uri'),
        ]);


        $data = $response->json();
        if (!isset($data['access_token'])) {
            return "Ошибка получения токена: " . json_encode($data);
        }

        // dd($response->json());

        // Сохраняем токен в базе
BitrixToken::updateOrCreate(
    ['id' => 1],
    [
        'access_token' => $data['access_token'],
        'refresh_token' => $data['refresh_token'],
        'domain' => $data['domain'], // oauth.bitrix24.tech или b24-90nei8.bitrix24.kz
        'portal_url' => "https://{$data['domain']}/welcome/",
        'rest_url' => rtrim($data['client_endpoint'], '/'), // для REST
        'expires_at' => now()->addSeconds($data['expires_in'] ?? 3600),
    ]
);
$portalUrl = rtrim($data['client_endpoint'], '/'); // убираем /rest/
$portalUrl = str_replace('/rest', '', $portalUrl) . '/welcome/';
// dd($portalUrl);
        return redirect()->away($portalUrl);
    }
}