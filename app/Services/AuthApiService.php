<?php

namespace App\Services;

use App\Events\UserRegistered;
use App\Events\UserForgotPassword;
use App\Events\UserEmailVerification;
use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\Api\ForgotPasswordApiRequest;
use App\Http\Requests\Api\StoreUserApiRequest;
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

        if(!$user->hasVerifiedEmail())
        {
            Auth::guard('user')->logout();
            throw new \Exception('Please verify your email before logging.', 403);
        }

        $user->tokens()->delete();
        $remember = $request->boolean('remember');


        $token = $remember
                ? $user->createToken('api-token')->plainTextToken
                : $user->createToken('api-token', ['*'], now()->addMinutes(120))->plainTextToken;

        return [
            'token'      => $token,
            'token_type' => 'Bearer',
            'expires_at' => $remember ? null : now()->addMinutes(120)->toDateTimeString(),
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
     * @param Request $request
     * @return void
     */

    public function logout(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
    }

    /**
     * Get the authenticated user
     * Get /api/auth/me
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
     * Post /api/auth/register
     * @param StoreUserApiRequest $request
     * @return void
     */
    public function register(StoreUserApiRequest $request): void
    {
        $validated = $request->validated();

        if(Customer::emailExists($validated['email']))
        {
            throw new \Exception('Email already exists', 403);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'country' => $validated['country'] ?? null,
        ]);

        UserEmailVerification::dispatch($user);
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

        $resetLink = Url('api/v1/auth/reset-password'
                            .'?token=' . $token
                            .'&email=' . urlencode($user->email));

        UserForgotPassword::dispatch($user, $token, $resetLink);
    }

    /**
     * Summary of isValidResetToken
     * @param string $email
     * @param string $token
     * @return bool
     */
    public function isValidResetToken(string $email, string $token): bool
    {
        $record = $this->authRepository->findByEmailAndTokens($email, $token);

        if(!$record)
        {
            return false;
        }

        return true;
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

        $user->update(['password' => $request->password]);

        $this->authRepository->deleteByEmail($request->email);
    }

    /**
     * Summary of resendVerificationEmail
     * Post /api/auth/ResendVerificationEmail
     * @param string $email
     * @return void
     */
    public function resendVerificationEmail(string $email): void
    {
        $user = User::where('email', $email)->first();

        if(!$user || $user->hasVerifiedEmail())
        {
            return;
        }

        UserEmailVerification::dispatch($user);
    }

    /**
     * Summary of verifyEmail
     * Get /api/v1/auth/verify/{id}/{hash}
     * @param string $id
     * @param string $hash
     * @return void
     */
    public function verifyEmail(string $id, string $hash): void
    {
        $user = User::findOrFail($id);

        if(! hash_equals($hash, sha1($user->email)))
        {
            throw new \Exception('Invalid verification link', 400);
        }

        if($user->hasVerifiedEmail())
        {
            throw new \Exception('Email already verified', 400);
        }

        $user->markEmailAsVerified();

        UserRegistered::dispatch($user,'api.v1.email.verify');
    }
}
