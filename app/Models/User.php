<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Summary of table
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'company',
        'address',
        'first_name',
        'last_name',
        'city',
        'Postal_code',
        'city',
        'about_me',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    static function nameExists(string $name):bool
    {
        return self::where('name', $name)->exists();
    }

    static function emailExists(string $email):bool
    {
        return self::where('email', $email)->exists();
    }

    // function getCountryAttribute(): ?string
    // {
    //     switch ($this->attributes['country']) {
    //         case 1:
    //             return 'Germany';
    //             break;
    //         case 2:
    //             return 'Canada';
    //             break;
    //         case 3:
    //             return 'Usa';
    //             break;
    //         case 4:
    //             return 'Aus';
    //             break;
    //         default:
    //             return null;
    //     }
    // }
}
