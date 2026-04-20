<?php namespace App\Http\Controllers\Bitrix24;

use App\Models\BitrixPortal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyBitrixSignature; // Импортируем middleware

class InstallController extends Controller {
    public function __invoke(Request $request){
        // 1. Получаем параметры от Битрикс24
        $code = $request->input('code');
        $memberId = $request->input('member_id');
        $domain = $request->input('domain');
        if (!$code || !$memberId) { return response('Missing code or member_id', 400); }


        // 2. Обмениваем code на токены через ЕДИНЫЙ OAuth-сервер
        $tokenUrl = "https://oauth.bitrix.info/oauth/token/";
        $response = Http::asForm()->post($tokenUrl, [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.bitrix.client_id'),     // Глобальный ID
            'client_secret' => config('services.bitrix.client_secret'), // Глобальный Secret
            'code' => $code,
            'redirect_uri' => config('app.url') . '/bitrix/install', // Точное совпадение!
        ]);

        $data = $response->json();

        if (!isset($data['access_token'])) {
            \Log::error('Bitrix token exchange failed', $data);
            return response('Token exchange failed', 500);
        }


        // 3. Сохраняем токены
        BitrixPortal::updateOrCreate(
            ['member_id' => $memberId],
            [
                'domain'          => $domain,
                'access_token'    => $data['access_token'],
                'refresh_token'   => $data['refresh_token'],
                // ... (сохранение access_token, refresh_token и т.д.)
                'application_token' => $request->input('application_token') ?? $data['application_token'] ?? null,
                 // Сначала ищем в ответе обмена, потом в исходном запросе
                'client_endpoint' => $data['client_endpoint'],
                'expires_at'      => now()->addSeconds($data['expires_in']),
            ]
        );


        // 4. Сигнализируем об успешной установке
        return response('', 200);
    }
    /**
     * Обработчик удаления приложения.
     */
    public function uninstall(Request $request)
    {
        // ВАЖНО: При удалении данные авторизации НЕ ПЕРЕДАЮТСЯ[reference:6][reference:7].
        // Безопасность обеспечивает middleware VerifyBitrixSignature.
        $memberId = $request->input('member_id');

        if ($memberId) {
            BitrixPortal::where('member_id', $memberId)->delete();
            // Здесь можно добавить очистку своих данных, связанных с порталом
        }

        // Битрикс24 ожидает HTTP 200 OK
        return response('', 200);
    }
}
