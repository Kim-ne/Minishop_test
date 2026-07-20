<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

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
        'postal_code',
        'about_me',
        'password',
        'avatar',
        'role'
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

    static function nameExists(string $name): bool
    {
        return self::where('name', $name)->exists();
    }

    static function emailExists(string $email): bool
    {
        return self::where('email', $email)->exists();
    }

    /**
     * Summary of Role constants
     */
    const ROLE_MANAGER = 'manager';
    const ROLE_STAFF = 'staff';

    public function isManager():bool
    {
        return  $this->role === self::ROLE_MANAGER;
    }

    public function isStaff():bool
    {
        return  $this->role === self::ROLE_STAFF;
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public static function scopeForRoleManagement($query)
    {
        return $query->select('id','name','email','role','created_at')
                    ->orderBy('created_at','desc')
                    ->get();
    }
}
