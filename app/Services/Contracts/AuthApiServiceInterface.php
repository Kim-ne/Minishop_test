<?php

namespace App\Services\Contracts;

use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\Api\ForgotPasswordApiRequest;
use App\Http\Requests\Api\ResetPasswordApiRequest;
use App\Models\User;
use Illuminate\Http\Request;


interface AuthApiServiceInterface
{
    public function login(LoginApiRequest $request): array;
    public function logout(Request $request): void;
    public function me(Request $request): array;
    public function register(StoreUserRequest $request): User;
    public function forgotPassword(ForgotPasswordApiRequest $request): void;
    public function resetPassword(ResetPasswordApiRequest $request): void;

}
