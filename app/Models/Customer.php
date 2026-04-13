<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'address',
        'country',
        'city',
        'zipcode',
        'password',
        'notes',
        'status',
        'ship_firstname',
        'ship_lastname',
        'ship_email',
        'ship_phone',
        'ship_address',
        'ship_country',
        'ship_city',
        'ship_zipcode',
    ];
    protected $hidden = [
        'password',
        'remember_token'];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    function orders()
    {
        return $this->hasMany(Order::class);
    }
    function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    static function emailExists(string $email):bool
    {
        return self::where('email', $email)->exists();
    }
}
