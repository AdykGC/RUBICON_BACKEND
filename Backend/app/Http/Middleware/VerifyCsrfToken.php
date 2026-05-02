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
        'bitrix/install/*', // Укажите здесь ваш маршрут для обработки установки/инициализации
        'bitrix/install/ui-lite',
        'bitrix/uninstall',
        //'/bitrix/dashboard',
        'bitrix/dashboard', // Или маршрут, который вызывает ошибку при входе
        'bitrix/placement/*',
        'bitrix/events/*',
        'bitrix/install/ui',
        'bitrix/install/ui-plain',
    ];
}
