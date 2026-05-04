<?php

namespace App\Services\Bitrix24;

use App\Models\BitrixPortal;

class BitrixServiceFactory
{
    public function make(BitrixPortal $portal): Bitrix24Service
    {
        return new Bitrix24Service($portal);
    }
}