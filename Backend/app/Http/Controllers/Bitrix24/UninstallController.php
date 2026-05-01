<?php namespace App\Http\Controllers\Bitrix24;

use App\Models\BitrixPortal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UninstallController extends Controller
{
    public function __invoke(Request $request)
    {
        // Здесь уже отработал VerifyBitrixSignature и проверил member_id + application_token

        $memberId = $request->input('member_id') ?: $request->input('MEMBER_ID');

        if ($memberId) {
            // Удаляем запись портала и связанные данные
            BitrixPortal::where('member_id', $memberId)->delete();

            // При желании — почистить связанные записи:
            // deals, logs, настройки и т.д.
        }

        // Bitrix ждёт HTTP 200 OK
        return response('', 200);
    }
}