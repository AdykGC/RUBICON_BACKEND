<?php namespace App\Http\Controllers\Bitrix24;

use App\Models\BitrixPortal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;



class InstallLiteController extends Controller {
    public function __invoke(Request $request)
    {
        Log::info('INSTALL_LITE request', [
            'method' => $request->method(),
            'url'    => $request->fullUrl(),
            'all'    => $request->all(),
        ]);

        // здесь потом разберёшь event=ONAPPINSTALL и auth[]
        return response('OK FROM INSTALL-LITE', 200);
    }
}

