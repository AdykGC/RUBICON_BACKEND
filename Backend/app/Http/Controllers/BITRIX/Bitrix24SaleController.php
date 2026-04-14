<?php namespace App\Http\Controllers\BITRIX;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Services\BITRIX24\Bitrix24Service;
use App\Models\Sale;

class Bitrix24SaleController extends Controller
{
    protected $bitrix;

    public function __construct(Bitrix24Service $bitrix)
    {
        $this->bitrix = $bitrix;
    }

    public function sendToBitrix(Sale $sale)
    {
        $profit = $sale->total - ($sale->product->price * $sale->quantity) - $sale->machine->install_price - $sale->machine->price_adjustment;

        $result = $this->bitrix->call('crm.deal.add', [
    'fields' => [
        'TITLE' => "Продажа #{$sale->id}",
        'UF_CRM_1774792445' => $sale->machine->name,
        'UF_CRM_1774792427' => $sale->product->name,
        'UF_CRM_1774792088' => $sale->total,
        'UF_CRM_1774792364' => $profit,
        'UF_CRM_1774793124' => $sale->quantity,
    ]
]);

        return response()->json($result);
    }

    # Логика расчёта прибыли
    # profit = total - (product.price * quantity) - install_price - price_adjustment

    /*
    То есть:
        total — сумма, которую получили за продажу (может быть вручную или автоматически)
        (product.price * quantity) — себестоимость проданных товаров
        install_price — расходы на установку автомата
        price_adjustment — корректировка цены/дополнительные расходы
    Всё это считается на бэке Laravel в методе sendToBitrix.
    */

}