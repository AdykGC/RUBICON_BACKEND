<?php namespace App\Http\Controllers\Bitrix24\BitrixClientL1V1;

use App\DTO\Bitrix24\BitrixClientL1V1\InstallPayload;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bitrix24\BitrixClientL1V1\InstallRequest;
use App\Services\Bitrix24\BitrixClientL1V1\BitrixInstallService;
use Illuminate\Support\Facades\Log;

class InstallController extends Controller
{
    public function __invoke( InstallRequest $request, BitrixInstallService $service ) {

        $payload = InstallPayload::fromRequest($request);
        Log::info('bitrix.install.received', [
            'member_id' => $payload->memberId,
            'domain' => $payload->domain,
        ]);

        $portal = $service->install($payload);
        Log::info('bitrix.portal.saved', [
            'portal_id' => $portal->id,
            'member_id' => $portal->member_id,
        ]);

        return view('bitrix.install', [
            'applicationTokenFromServer' => $portal->application_token,
        ]);
    }
}