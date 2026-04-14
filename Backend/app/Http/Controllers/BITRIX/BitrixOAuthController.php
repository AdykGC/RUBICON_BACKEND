<?php namespace App\Http\Controllers\BITRIX;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\BitrixToken;

class BitrixOAuthController extends Controller {
    // 1. Редирект на авторизацию
    public function redirectToProvider() {
        $clientId = config('services.bitrix.client_id');
        $redirectUri = urlencode(config('services.bitrix.redirect_uri'));
        $portalDomain = config('services.bitrix.portal_domain');
        $state = csrf_token();

        $url = "https://{$portalDomain}/oauth/authorize/?client_id={$clientId}&redirect_uri={$redirectUri}&response_type=code&state={$state}";
        return redirect()->away($url);
    }

    // 2. Обработка callback с code
    public function handleCallback(Request $request)
    {
        $code = $request->query('code');
        if (!$code) {
            return "Ошибка: код авторизации не получен";
        }

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

        // Сохраняем токены в сессии или базе
        session([
            'bitrix_access_token' => $data['access_token'],
            'bitrix_refresh_token' => $data['refresh_token'],
            'bitrix_api_domain' => $data['client_endpoint'],
        ]);
        BitrixToken::updateOrCreate(
            ['id' => 1],
            [
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'domain' => 'https://' . rtrim($data['client_endpoint'], '/'),
                'expires_at' => now()->addSeconds($data['expires_in'] ?? 3600),
            ]
        );

        return "Авторизация прошла успешно! Теперь можно работать с API Битрикс24";
    }

    public function refreshToken(BitrixToken $token)
{
    $response = Http::asForm()->post('https://oauth.bitrix24.tech/oauth/token/', [
        'grant_type' => 'refresh_token',
        'client_id' => config('services.bitrix.client_id'),
        'client_secret' => config('services.bitrix.client_secret'),
        'refresh_token' => $token->refresh_token,
    ]);

    $data = $response->json();

    if (!isset($data['access_token'])) {
        throw new \Exception('Ошибка обновления токена: ' . json_encode($data));
    }

    $token->update([
        'access_token' => $data['access_token'],
        'refresh_token' => $data['refresh_token'],
        'expires_at' => now()->addSeconds($data['expires_in'] ?? 3600),
    ]);

    return $token;
}
}