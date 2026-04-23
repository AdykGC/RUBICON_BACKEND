<?php namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Backpack
use Backpack\CRUD\app\Models\Traits\CrudTrait;
// Spatie
use Spatie\Permission\Traits\HasRoles;
// Sanctum
use Laravel\Sanctum\HasApiTokens;
// Мягкое удаление
// use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $surname
 */

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'company_title',
        'email',
        'phone',
        'address',
        'password',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_active' => 'boolean'
    ];
}