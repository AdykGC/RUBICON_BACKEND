<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceCommand extends Model
{
    protected $fillable = [
        'mac_address',
        'command_id',
        'action',
        'pulses',
        'status'
    ];
    public function machine() {
        return $this->belongsTo(Machine::class, 'mac_address', 'mac_address');
    }
}