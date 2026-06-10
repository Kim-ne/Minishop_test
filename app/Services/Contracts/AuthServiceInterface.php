<?php

namespace App\Services\Contracts;

use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Models\Customer;

interface AuthServiceInterface
{
    public function login(): mixed;

    public function loginPost(LoginPostRequest $request): Customer;

    public function userLoginPost(LoginPostRequest $request): User;

    public function logout(): void;

    public function userLogout(): void;

    public function register(): mixed;

    public function userRegister(): mixed;

    public function registerPost(RegisterRequest $request): Customer;

    public function userRegisterPost(StoreUserRequest $request): User;

    public function forgotPassword(ForgotPasswordRequest $request): void;

    public function resetPassword(ResetPasswordRequest $request): void;
}
