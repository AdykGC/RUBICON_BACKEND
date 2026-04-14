<?php namespace App\Http\Controllers\BITRIX;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\BitrixToken;

class OAuthRedirectController extends Controller {
    // 1. Редирект на авторизацию
    public function redirectToProvider() {
        $clientId = config('services.bitrix.client_id');
        $redirectUri = urlencode(config('services.bitrix.redirect_uri'));
        $portalDomain = config('services.bitrix.portal_domain');
        $state = csrf_token();

        // dd(config('services.bitrix.client_id'));

        $url = "https://{$portalDomain}/oauth/authorize/?client_id={$clientId}&redirect_uri={$redirectUri}&response_type=code&state={$state}";
        return redirect()->away($url);
    }
}