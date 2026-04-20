<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitrixPortal extends Model {
    protected $table = 'bitrix_portals';

    protected $fillable = [
        'member_id', 'domain', 'access_token',
        'refresh_token', 'client_endpoint', 'expires_at',
        'application_token',
    ];
}