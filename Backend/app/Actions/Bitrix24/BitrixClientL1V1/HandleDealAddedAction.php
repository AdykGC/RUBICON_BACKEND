<?php

namespace App\Actions\Bitrix24\BitrixClientL1V1;

use App\DTO\Bitrix24\BitrixClientL1V1\EventPayload;
use App\Models\BitrixPortal;
use App\Services\Bitrix24\BitrixClientL1V1\BitrixClientService;
use Illuminate\Support\Facades\Log;

class HandleDealAddedAction
{
    public function execute(EventPayload $payload): void
    {
        // 1. Найти портал
        $portal = BitrixPortal::find($payload->portalId);

        if (!$portal) {
            Log::warning('bitrix.deal_add.portal_not_found', [
                'portal_id' => $payload->portalId,
            ]);
            return;
        }

        // 2. Создать клиент Bitrix
        $client = new BitrixClientService($portal);

        // 3. Достать ID сделки из payload
        $dealId = data_get($payload->payload, 'data.FIELDS.ID');

        if (!$dealId) {
            Log::warning('bitrix.deal_add.no_deal_id', [
                'payload' => $payload->payload,
            ]);
            return;
        }

        // 4. Получить полные данные сделки из Bitrix
        $deal = $client->call('crm.deal.get', [
            'id' => $dealId,
        ]);

        // 5. Лог (пока как заглушка бизнес-логики)
        Log::info('bitrix.deal_add.processed', [
            'deal_id' => $dealId,
            'title' => $deal['TITLE'] ?? null,
        ]);

        // 6. TODO: здесь твоя бизнес-логика
        // - создать сущность в твоей системе
        // - синхронизировать CRM
        // - запустить workflow
    }
}