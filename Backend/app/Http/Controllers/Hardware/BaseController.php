<?php namespace App\Http\Controllers\Hardware;

use App\Http\Controllers\Controller;
use App\Services\Hardware\MqttService;

class BaseController extends Controller {
    public $service;
    public function __construct( MqttService $service ){ $this->service = $service; }
}