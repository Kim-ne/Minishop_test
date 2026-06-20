<?php

namespace App\Services\Contracts;

use App\Http\Requests\Api\ForgotPasswordApiRequest;
use App\Http\Requests\Api\ResetPasswordApiRequest;
use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;



interface CustomerApiServiceInterface
{
    public function index(): Collection;

    public function login(LoginApiRequest $request): array;

    public function logout(Request $request): void;

    public function show(int $id): Customer;

    public function toggleStatus(int $id): Customer;

    public function destroy(int $id): bool;

    public function register(RegisterRequest $request): void;

    public function forgotPassword(ForgotPasswordApiRequest $request): void;

    public function resetPassword(ResetPasswordApiRequest $request): void;
    public function resendVerificationEmail(string $email): void;
    public function verifyEmail(int $id, string $hash): void;

}
