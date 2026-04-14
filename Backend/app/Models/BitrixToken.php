<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitrixToken extends Model
{
    protected $fillable = [
        'access_token',
        'refresh_token',
        'domain',
        'portal_url', // для редиректа пользователя
        'rest_url',   // для REST API вызовов
    ];
}