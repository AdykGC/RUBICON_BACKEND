<?php namespace App\Services\Bitrix24;

use Illuminate\Support\Facades\Http;
use App\Models\BitrixPortal;
use Illuminate\Support\Facades\Log;

class Bitrix24Service {
    protected string $webhookUrl;
    protected BitrixPortal $portal;
    protected int $retryCount = 0;




    public function __construct(BitrixPortal $portal) {
        $this->portal = $portal;
    }



    public function call(string $method, array $params = [])
{
    if (!$this->portal->expires_at || $this->portal->expires_at->lte(now())) {
        $this->refreshToken();
    }

    $url = rtrim($this->portal->client_endpoint, '/') . '/' . $method . '.json';
    $response = Http::asForm()->post($url, array_merge($params, [
        'auth' => $this->portal->access_token,
    ]));
    $data = $response->json();

    if (isset($data['error']) && $data['error'] === 'expired_token') {
        if ($this->retryCount >= 1) {
            throw new \Exception('Too many token refresh attempts');
        }
        $this->retryCount++;
        $this->refreshToken();
        return $this->call($method, $params);
    }

    $this->retryCount = 0;
    return $data;
}

    protected function refreshToken() {
        // Обновление токена через единый OAuth-сервер
        $response = Http::asForm()->post("https://oauth.bitrix.info/oauth/token/", [
            'grant_type'    => 'refresh_token',
            'client_id'     => config('services.bitrix.client_id'),
            'client_secret' => config('services.bitrix.client_secret'),
            'refresh_token' => $this->portal->refresh_token,
        ]);
        $data = $response->json();

        if (!isset($data['access_token'], $data['refresh_token'])) {
            Log::error('Unable to refresh token', ['portal_id' => $this->portal->id, 'data' => $data]);
            throw new \Exception('Unable to refresh token');
        }
        
        $this->portal->update([
            'access_token'  => $data['access_token'],
            'refresh_token' => $data['refresh_token'],
            'expires_at'    => now()->addSeconds($data['expires_in']),
        ]);
        $this->portal->refresh();
    }
}