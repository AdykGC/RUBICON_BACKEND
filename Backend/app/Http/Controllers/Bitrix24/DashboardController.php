<?php namespace App\Http\Controllers\Bitrix24;


use App\Services\Bitrix24\Bitrix24Service;  // добавлено
use App\Models\BitrixPortal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {
public function __invoke(Request $request)
{
    $memberId = $request->query('member_id');
    $authIdFromFrame = $request->query('AUTH_ID'); // Получаем токен из iframe

    if (!$memberId) {
        return response('Missing member_id', 403);
    }

    $portal = BitrixPortal::where('member_id', $memberId)->firstOrFail();

    // Если Битрикс24 передал в iframe AUTH_ID, обновляем токен в БД
    if ($authIdFromFrame && $authIdFromFrame !== $portal->access_token) {
        $portal->update(['access_token' => $authIdFromFrame]);
        // Обновляем объект $portal, чтобы сервис использовал новый токен
        $portal->refresh();
    }

    $service = new Bitrix24Service($portal);
    $userInfo = $service->call('user.current');

    return view('bitrix.dashboard', compact('userInfo'));
}
}