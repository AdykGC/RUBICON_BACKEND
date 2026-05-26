<?php namespace App\Http\Controllers\Bitrix24\BitrixClientL1V1;

use App\DTO\Bitrix24\BitrixClientL1V1\UninstallPayload;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bitrix24\BitrixClientL1V1\UninstallRequest;
use App\Services\Bitrix24\BitrixClientL1V1\BitrixPortalService;
use Illuminate\Support\Facades\Log;

class UninstallController extends Controller
{
    public function __invoke( UninstallRequest $request, BitrixPortalService $service ) {

        $payload = UninstallPayload::fromRequest($request);
        Log::info('bitrix.uninstall.received', [
            'member_id' => $payload->memberId,
        ]);


        $service->uninstall($payload);

        return response()->noContent();
    }
}