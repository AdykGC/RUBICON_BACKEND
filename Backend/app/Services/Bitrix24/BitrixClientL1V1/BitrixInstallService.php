<?php namespace App\Services\Bitrix24\BitrixClientL1V1;

use App\DTO\Bitrix24\BitrixClientL1V1\InstallPayload;
use App\Models\BitrixPortal;
use Illuminate\Support\Facades\DB;

class BitrixInstallService {

    public function install(InstallPayload $payload): BitrixPortal {
        return DB::transaction(function () use ($payload) {

            return BitrixPortal::updateOrCreate(
                [ 'member_id' => $payload->memberId, ],
                [
                    'domain' => $payload->domain,
                    'access_token' => $payload->accessToken,
                    'refresh_token' => $payload->refreshToken ? encrypt($payload->refreshToken) : null,
                    'application_token' => $payload->applicationToken,
                    'client_endpoint' => $payload->endpoint,
                    'scope' => $payload->scope,
                    'status' => 'active',
                    'expires_at' => now()->addSeconds($payload->expiresIn),
                ]
            );
        });
    }
}