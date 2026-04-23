<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'location',
        'serial_number',
        'user_id',

        'connection_type',
        'install_price',
        'price_adjustment',
        'latitude',
        'longitude',
        'is_active'
    ];

    // Связь с пользователем
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function sales() {
        return $this->hasMany(Sale::class);
    }
}
