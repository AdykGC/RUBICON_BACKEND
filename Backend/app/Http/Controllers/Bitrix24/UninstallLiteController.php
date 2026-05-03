<?php

namespace App\Http\Controllers\Bitrix24;

use App\Models\BitrixPortal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class UninstallLiteController extends Controller
{
    public function __invoke(Request $request)
    {
        $memberId = $request->input('member_id') ?: $request->input('MEMBER_ID');
        if ($memberId) {
            BitrixPortal::where('member_id', $memberId)->delete();
        }
        Log::info('BITRIX_UNINSTALL request', [
            'member_id' => $memberId,
            'all'       => $request->all(),
        ]);
        return response('', 200);
    }
}
