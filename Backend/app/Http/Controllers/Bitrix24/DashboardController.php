<?php namespace App\Http\Controllers\Bitrix24;


use App\Services\Bitrix24\Bitrix24Service;  // добавлено
use App\Models\BitrixPortal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {
public function __invoke(Request $request)
{
    $memberId = $request->input('member_id') ?: $request->input('MEMBER_ID');

    if ($memberId) {
        $portal = BitrixPortal::where('member_id', $memberId)->first();
    } else {
        $domain = $request->input('domain') ?: $request->input('DOMAIN');

        if (!$domain) {
            return response('Missing portal идентификатор', 403);
        }

        $portal = BitrixPortal::where('domain', $domain)->first();
    }

    if (!$portal) {
        return response('Portal not found', 404);
    }

    $service = new Bitrix24Service($portal);
    $userInfo = $service->call('user.current');

    return view('bitrix.dashboard', compact('userInfo'));
}
}