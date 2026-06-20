<?php

namespace App\Services\Contracts;

use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\Api\StoreUserApiRequest;
use App\Http\Requests\Api\ForgotPasswordApiRequest;
use App\Http\Requests\Api\ResetPasswordApiRequest;
use App\Models\User;
use Illuminate\Http\Request;


interface AuthApiServiceInterface
{
    public function login(LoginApiRequest $request): array;
    public function logout(Request $request): void;
    public function me(Request $request): array;
    public function register(StoreUserApiRequest $request): void;
    public function forgotPassword(ForgotPasswordApiRequest $request): void;
    public function isValidResetToken(string $email, string $token): bool;
    public function resetPassword(ResetPasswordApiRequest $request): void;
    public function verifyEmail(string $id, string $hash): void;
    public function resendVerificationEmail(string $email): void;

}
