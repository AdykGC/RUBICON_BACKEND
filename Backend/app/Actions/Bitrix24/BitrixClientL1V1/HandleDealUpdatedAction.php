<?php

namespace App\Actions\Bitrix24\BitrixClientL1V1;

use App\DTO\Bitrix24\BitrixClientL1V1\EventPayload;
use App\Models\BitrixPortal;
use App\Services\Bitrix24\BitrixClientL1V1\BitrixClientService;
use Illuminate\Support\Facades\Log;

class HandleDealUpdatedAction
{
    public function execute(EventPayload $payload): void
    {
        $portal = BitrixPortal::find($payload->portalId);
        if (!$portal) { 
            Log::warning(...); 
            return; 
        }

        $client = new BitrixClientService($portal);

        $dealId = data_get( $payload->payload, 'data.FIELDS.ID' );

        if (!$dealId) {
            Log::warning('bitrix.deal_update.no_id');
            return;
        }

        $deal = $client->call('crm.deal.get', [
            'id' => $dealId,
        ]);

        Log::info('bitrix.deal.loaded', [
            'deal_id' => $dealId,
            'title' => $deal['TITLE'] ?? null,
        ]);

        // TODO:
        // sync domain model
    }
}