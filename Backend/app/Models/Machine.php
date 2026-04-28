<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = [
        'name',
        'type',
        'location',
        'mac_address',
        'user_id',
        'connection_type',
        'install_price',
        'price_adjustment',
        'latitude',
        'longitude',
        'is_active',
        'qr_code'
    ];

    public function commands() {
        return $this->hasMany(DeviceCommand::class, 'mac_address', 'mac_address');
    }

    // Связь с пользователем
    public function user() {
        return $this->belongsTo(User::class);
    }
}
