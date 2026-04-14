<?php namespace App\Http\Controllers\BITRIX;

use App\Services\BITRIX24\Bitrix24Service;

class BaseController{
    public $service;
    public function __construct(Bitrix24Service $service){ $this->service = $service; }
}