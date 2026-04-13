<?php

namespace App\Services;

use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterRequest;
use View;

interface AuthServiceInterface
{
    public function login(): mixed;

    public function loginPost(LoginPostRequest $request): mixed;

    public function userLoginPost(LoginPostRequest $request): mixed;

    public function logout(): void;

    public function userLogout(): void;

    public function register(): mixed;

    public function userRegister(): mixed;

    public function registerPost(RegisterRequest $request): mixed;

    public function userRegisterPost(RegisterRequest $request): mixed;

}
