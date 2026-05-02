<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'bitrix/install*',
        'bitrix/uninstall*',
        'bitrix/placement/*',
        'bitrix/events/*',
        'bitrix/install/ui-lite',
        'bitrix/install/ui-plain',
        'bitrix/install/ui',
        'bitrix/dashboard',
    ];
}
