<?php namespace App\Http\Controllers\Bitrix24;

use App\Models\BitrixPortal;
use App\Services\Bitrix24\BitrixServiceFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlacementController extends Controller {
    public function __invoke(
        string $placement,
        Request $request,
        BitrixServiceFactory $factory
    ) {
        $memberId = $request->input('member_id') ?: $request->input('MEMBER_ID');
        $domain   = $request->input('domain') ?: $request->input('DOMAIN');

        if ($memberId) {
            $portal = BitrixPortal::where('member_id', $memberId)->first();
        } elseif ($domain) {
            $portal = BitrixPortal::where('domain', $domain)->first();
        } else {
            return response('Missing portal identifier', 403);
        }

        if (!$portal) {
            return response('Portal not found', 404);
        }

        $service = $factory->make($portal);

        // В placement обычно прилетает PLACEMENT_OPTIONS, там ID сущности
        $placementOptionsRaw = $request->input('PLACEMENT_OPTIONS', '{}');
        $placementOptions    = json_decode($placementOptionsRaw, true) ?: [];

        // Пример: для CRM_DEAL_DETAIL_TAB получаем ID сделки и грузим данные
        if ($placement === 'deal-tab') {
            $dealId = $placementOptions['ID'] ?? null;

            $deal = $dealId
                ? $service->call('crm.deal.get', ['id' => $dealId])
                : null;

            return view('bitrix.placements.deal_tab', [
                'portal'    => $portal,
                'deal'      => $deal,
                'options'   => $placementOptions,
            ]);
        }

        if ($placement === 'lead-tab') {
            // аналогично для лида
        }

        // fallback
        return view('bitrix.placements.default', [
            'portal'  => $portal,
            'options' => $placementOptions,
            'code'    => $placement,
        ]);
    }
}