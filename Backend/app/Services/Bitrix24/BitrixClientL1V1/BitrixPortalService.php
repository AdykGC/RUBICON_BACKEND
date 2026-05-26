<?php

namespace App\Services\Bitrix24\BitrixClientL1V1;

use App\DTO\Bitrix24\BitrixClientL1V1\UninstallPayload;
use App\Models\BitrixPortal;
use Illuminate\Support\Facades\Log;

class BitrixPortalService
{
    public function uninstall(UninstallPayload $payload): void
    {
        if (!$payload->memberId) {
            Log::warning('bitrix.uninstall.empty_member_id');
            return;
        }

        $updated = BitrixPortal::where('member_id', $payload->memberId)->update([
            'status' => 'uninstalled',
            'uninstalled_at' => now()->utc(),
            'access_token' => null,
            'refresh_token' => null,
        ]);

        if ($updated === 0) {
            Log::warning('bitrix.uninstall.not_found', [
                'member_id' => $payload->memberId,
            ]);
        }
    }
}
