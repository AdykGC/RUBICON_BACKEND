<?php namespace App\Http\Controllers\Bitrix24\BitrixClientL1V1;

use App\DTO\Bitrix24\BitrixClientL1V1\EventPayload;
use App\Http\Controllers\Controller;
use App\Jobs\Bitrix24\BitrixClientL1V1\ProcessBitrixEventJob;
use App\Models\BitrixPortal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function __invoke( string $event, Request $request ) {
        $memberId = $request->input('member_id') ?: $request->input('auth.member_id');
        if (!$memberId) {
            Log::warning('bitrix.event.empty_member_id', [
                'event' => $event,
                'payload' => $request->all(),
            ]);
            return response()->noContent();
        }


        $portal = BitrixPortal::where( 'member_id', $memberId )->first();
        if (!$portal) {
            Log::warning('bitrix.event.portal_not_found', [
                'member_id' => $memberId,
                'event' => $event,
            ]);
            return response()->noContent();
        }


        ProcessBitrixEventJob::dispatch(
            EventPayload::make(
                event: $event,
                portalId: $portal->id,
                payload: $request->all(),
            )
        );

        return response()->noContent();
    }
}