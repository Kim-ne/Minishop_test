<?php

namespace App\Services;


use App\Services\Contracts\AuthApiServiceInterface;
use App\Http\Requests\Api\LoginApiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiService implements AuthApiServiceInterface
{
    /**
     * Login the user
     * Post /api/auth/login
     *
     * @param LoginApiRequest $request
     * @return array
     */
    public function login(LoginApiRequest $request): array
{
    $credentials = $request->only(['email', 'password']);
    $attempted = Auth::guard('user')->attempt($credentials);


    if (!$attempted) {
        throw new \Exception('Invalid email or password.', 401);
    }

    $user = Auth::guard('user')->user();

    if (!$user) {
        throw new \Exception('User not found after authentication.', 500);
    }

    $user->tokens()->delete();
    $token = $user->createToken('api-token')->plainTextToken;

    return [
        'token'      => $token,
        'token_type' => 'Bearer',
        'user'       => [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ],
    ];
}

    /**
     * Logout the user
     * Post /api/auth/logout
     *
     * @param Request $request
     */

    public function logout(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();

    }

    public function me(Request $request): array
    {
        $user = $request->user();

        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'created_at' => $user->created_at?->format('d/m/Y H:i'),
        ];
    }
}
