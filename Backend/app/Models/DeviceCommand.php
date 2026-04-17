<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceCommand extends Model
{
    protected $fillable = [
        'device_id',
        'command_id',
        'action',
        'pulses',
        'status'
    ];
}