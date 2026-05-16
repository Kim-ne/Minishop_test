<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Summary of table
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * Summary of fillable
     *
     * @var array
     */
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
        'remember_token'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public  function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public static function emailExists(string $email):bool
    {
        return self::where('email', $email)->exists();
    }

    /**
     * Customer status
     */

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    public function scopeForStatus($query)
    {
        return $query->select('id', 'firstname', 'lastname', 'email', 'phone','created_at', 'status')
                        ->orderBy('created_at', 'desc')
                        ->get();
    }
}
