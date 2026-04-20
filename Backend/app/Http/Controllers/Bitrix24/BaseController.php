<?php namespace App\Http\Controllers\Bitrix24;

use App\Services\Bitrix24\Bitrix24Service;

class BaseController{
    public $service;
    public function __construct(Bitrix24Service $service){ $this->service = $service; }
}