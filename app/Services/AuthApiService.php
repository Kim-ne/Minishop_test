<?php

namespace App\Services;

use App\Events\UserRegistered;
use App\Events\UserForgotPassword;
use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\Api\ForgotPasswordApiRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\Api\ResetPasswordApiRequest;
use App\Services\Contracts\AuthApiServiceInterface;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class AuthApiService implements AuthApiServiceInterface
{
    function __construct(
        protected AuthRepositoryInterface $authRepository)
    {}
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

    /**
     * Get the authenticated user
     * Get /api/auth/me
     *
     * @param Request $request
     * @return array
     */
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

    /**
     * Summary of register
     * @param StoreUserRequest $request
     * @return User
     */
    public function register(StoreUserRequest $request): User
    {
        $validated = $request->validated();

        if(Customer::emailExists($validated['email']))
        {
            throw new \Exception('Email already exists');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'country' => $validated['country'] ?? null,
        ]);

        UserRegistered::dispatch($user);

        return $user;

    }

    /**
     * Forgot Password create token and send email
     * Post /api/auth/ForgotPassword
     * @param ForgotPasswordApiRequest $request
     * @return void
     */
    public function forgotPassword(ForgotPasswordApiRequest $request): void
    {
        $user = User::where('email', $request->email)->first();

        if(!$user)
        {
            return;
        }

        $token = Str::random(64);

        $this->authRepository->createToken($user->email, $token);

        UserForgotPassword::dispatch($user, $token);
    }

    /**
     * Reset Password
     * Post /api/auth/ResetPassword
     * @param ResetPasswordApiRequest $request
     * @return void
     */
    public function resetPassword(ResetPasswordApiRequest $request): void
    {
        $record = $this->authRepository->findByEmailAndTokens($request->email, $request->token);

        if(!$record)
        {
            throw new \Exception('Token not found or expired', 422);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user)
        {
            throw new \Exception('User not found', 404);
        }

        $user->update(['password' => Hash::make($request->password)]);

        $this->authRepository->deleteByEmail($request->email);
    }
}
