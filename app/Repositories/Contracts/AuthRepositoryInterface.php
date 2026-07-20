<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Api\ResetPasswordApiRequest;

interface AuthRepositoryInterface
{

    public function createToken(string $email, string $token): void;

    /**
     * @param string $email
     * @param string $token
     * @return object|null (null if email not found or experied token)
     */
    public function findByEmailAndTokens(string $email, string $token): ?object;

    /**
     * Delete token
     * Ensure the token can only be used once
     */
    public function deleteByEmail(string $email): void;

}
