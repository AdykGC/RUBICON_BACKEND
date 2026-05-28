<?php

namespace App\Services\Bitrix24\BitrixClientL1V1;

use App\Models\BitrixPortal;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Illuminate\Support\Facades\Log;

class BitrixClientService
{
    public function __construct(
        protected BitrixPortal $portal,
    ) {}

    public function call(string $method, array $params = []): array
    {
        $response = Http::timeout(15) ->post(
                rtrim($this->portal->client_endpoint, '/') . '/' . $method,
                array_merge($params, [
                    'auth' => $this->portal->access_token,
                ])
            );

        if ($response->failed()) {
            throw new RuntimeException(
                "Bitrix API request failed: {$method}"
            );
        }

        $data = $response->json();

        if (isset($data['error'])) {
            throw new RuntimeException(
                $data['error_description'] ?? $data['error']
            );
        }

        return $data['result'] ?? [];
    }
}