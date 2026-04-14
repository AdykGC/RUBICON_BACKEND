<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id',
        'product_id',
        'quantity',
        'total',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}