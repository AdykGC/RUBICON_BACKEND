<?php namespace App\Actions\Bitrix24\BitrixClientL1V1;

use App\DTO\Bitrix24\BitrixClientL1V1\EventPayload;
use App\Models\BitrixPortal;

class HandleAppUninstallAction
{
    public function execute(EventPayload $payload): void
    {
        BitrixPortal::where( 'id', $payload->portalId )->update([
            'status' => 'uninstalled',
            'uninstalled_at' => now()->utc(),
            'access_token' => null,
            'refresh_token' => null,
        ]);
    }
}