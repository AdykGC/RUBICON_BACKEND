<?php namespace App\Services\BITRIX24;

use Illuminate\Support\Facades\Http;
use App\Models\BitrixToken;

class Bitrix24Service
{
    protected $accessToken;
    protected $restUrl;

    public function __construct()
    {
        $token = BitrixToken::first();
        if (!$token) {
            throw new \Exception('Bitrix токен не найден. Пройдите OAuth авторизацию.');
        }

        $this->accessToken = $token->access_token;
        $this->restUrl = rtrim($token->rest_url, '/'); // <-- Убираем слеш на конце

        if (!str_starts_with($this->restUrl, 'http')) {
            $this->restUrl = 'https://' . $this->restUrl;
        }
    }

    /**
     * Вызов метода Bitrix24 REST API
     */
    public function call(string $method, array $params = [])
    {
        $url = $this->restUrl . "/{$method}.json";

        $response = Http::asForm()->post($url, array_merge($params, [
            'auth' => $this->accessToken
        ]));

        $data = $response->json();

        if (isset($data['error'])) {
            throw new \Exception("Bitrix API ошибка: {$data['error_description']}");
        }

        return $data;
    }
}