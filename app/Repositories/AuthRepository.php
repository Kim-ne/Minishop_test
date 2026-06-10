<?php

namespace App\Repositories;

use App\Repositories\Contracts\AuthRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class AuthRepository implements AuthRepositoryInterface
{
    private string $table = 'password_reset_tokens';

    public function createToken(string $email, string $token): void
    {
        DB::table($this->table)->updateOrInsert(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ]

        );
    }


    public function findByEmailAndTokens(string $email, string $token): ?object
    {
        $record = DB::table($this->table)
                ->where('email', $email)
                ->where('token', $token)
                ->first();

        return $record;

        if(!$record)
        {
            return null;
        }

        $expireMinutes = config('auth.passwords.users.expire', 60);
        $isExpired = Carbon::parse($record->created_at)
                    ->addMinutes($expireMinutes)
                    ->isPast();

        if($isExpired)
        {
            return null;
        }

        return $record;
    }

    public function deleteByEmail(string $email): void
    {
        DB::table($this->table)
            ->where('email', $email)->delete();
    }
}

