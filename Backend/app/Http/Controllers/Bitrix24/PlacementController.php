<?php

namespace App\Http\Controllers\Bitrix24;

use App\Http\Controllers\Controller;
use App\Models\BitrixPortal;
use App\Models\User;
use App\Services\Bitrix24\BitrixServiceFactory;
use Illuminate\Http\Request;

class PlacementController extends Controller
{
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

        // CRM_DEAL_DETAIL_TAB → наш placement = deal-tab
        if ($placement === 'deal-tab') {
            $dealId = $placementOptions['ID'] ?? null;

            if (!$dealId) {
                return 'Не удалось получить ID сделки';
            }

            // 1. Получаем сделку из Bitrix
            $dealResponse = $service->call('crm.deal.get', ['ID' => $dealId]); // ID в верхнем регистре [web:241]
            $deal = $dealResponse['result'] ?? null;

            if (!$deal || empty($deal['CONTACT_ID'])) {
                return 'У сделки нет основного контакта';
            }

            // 2. Получаем контакт
            $contactResponse = $service->call('crm.contact.get', ['ID' => $deal['CONTACT_ID']]);
            $contact = $contactResponse['result'] ?? null;

            if (!$contact) {
                return 'Контакт не найден в Bitrix';
            }

            // 3. Берём email контакта
            $email = null;
            if (!empty($contact['EMAIL'][0]['VALUE'])) {
                $email = $contact['EMAIL'][0]['VALUE'];
            }

            if (!$email) {
                return 'У контакта нет e-mail, не можем сопоставить с пользователем';
            }

            // 4. Ищем пользователя и его автоматы в нашей БД
            $user = User::where('email', $email)->first();

            $machines = $user
                ? $user->machines()
                    ->select('id', 'name', 'location', 'balance', 'is_active')
                    ->get()
                : collect();

            // 5. Рендерим вкладку
            return view('bitrix.placements.deal_tab', [
                'portal'   => $portal,
                'deal'     => $deal,
                'contact'  => $contact,
                'machines' => $machines,
                'options'  => $placementOptions,
            ]);
        }

        // остальные placement-ы (lead-tab и т.д.)
        return view('bitrix.placements.default', [
            'portal'  => $portal,
            'options' => $placementOptions,
            'code'    => $placement,
        ]);
    }
}