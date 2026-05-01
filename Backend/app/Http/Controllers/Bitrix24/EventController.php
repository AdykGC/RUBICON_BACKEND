<?php namespace App\Http\Controllers\Bitrix24;

use App\Models\BitrixPortal;
use App\Services\Bitrix24\BitrixServiceFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function __invoke(
        string $event,
        Request $request,
        BitrixServiceFactory $factory
    ) {
        // В events Bitrix часто НЕ присылает member_id явно.
        // Его можно хранить внутри handler URL (например, через query) или
        // вытащить по domain, если он есть в auth.

        $domain = $request->input('auth.DOMAIN')
            ?? $request->input('DOMAIN')
            ?? $request->input('domain');

        if (!$domain) {
            Log::warning('Bitrix event without domain', [
                'event' => $event,
                'body'  => $request->all(),
            ]);
            return response('', 200); // отвечаем OK, но логируем
        }

        $portal = BitrixPortal::where('domain', $domain)->first();

        if (!$portal) {
            Log::warning('Bitrix event for unknown portal', [
                'event'  => $event,
                'domain' => $domain,
            ]);
            return response('', 200);
        }

        $service = $factory->make($portal);

        $payload = $request->all();

        // Разбор типов событий
        switch ($event) {
            case 'crm-deal-add':
            case 'ONCRMDEALADD':
                $this->handleDealAdd($payload, $service, $portal);
                break;

            case 'crm-deal-update':
            case 'ONCRMDEALUPDATE':
                $this->handleDealUpdate($payload, $service, $portal);
                break;

            case 'on-app-uninstall':
            case 'ONAPPUNINSTALL':
                $this->handleAppUninstall($payload, $portal);
                break;

            default:
                Log::info('Unhandled Bitrix event', [
                    'event'   => $event,
                    'domain'  => $domain,
                    'payload' => $payload,
                ]);
        }

        return response('', 200);
    }

    protected function handleDealAdd(array $payload, $service, BitrixPortal $portal): void
    {
        // В payload обычно data.FIELDS.ID
        $dealId = $payload['data']['FIELDS']['ID'] ?? null;

        if (!$dealId) {
            return;
        }

        // Лучше отправить в очередь, но для примера — прямо здесь:
        $deal = $service->call('crm.deal.get', ['id' => $dealId]);

        // Дальше — твоя бизнес‑логика: логирование, синхронизация и т.п.
        Log::info('New deal from Bitrix', [
            'portal_id' => $portal->id,
            'deal_id'   => $dealId,
            'deal'      => $deal,
        ]);
    }

    protected function handleDealUpdate(array $payload, $service, BitrixPortal $portal): void
    {
        $dealId = $payload['data']['FIELDS']['ID'] ?? null;

        if (!$dealId) {
            return;
        }

        $deal = $service->call('crm.deal.get', ['id' => $dealId]);

        Log::info('Updated deal from Bitrix', [
            'portal_id' => $portal->id,
            'deal_id'   => $dealId,
            'deal'      => $deal,
        ]);
    }

    protected function handleAppUninstall(array $payload, BitrixPortal $portal): void
    {
        // Дублируем/усиливаем UninstallController: чистим портал и данные.
        Log::info('Bitrix app uninstall event', [
            'portal_id' => $portal->id,
            'domain'    => $portal->domain,
        ]);

        $portal->delete();
    }
}