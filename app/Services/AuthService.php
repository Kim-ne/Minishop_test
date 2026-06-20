<?php

namespace App\Services;

use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Events\UserRegistered;
use App\Events\UserForgotPassword;
use App\Events\UserEmailVerification;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Services\Contracts\AuthServiceInterface;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AuthService implements AuthServiceInterface
{
    public function __construct(
        protected AuthRepositoryInterface $authRepository
    )
    {}

    const UNVERIFIED_EMAIL = 'UNVERIFIED_EMAIL';

    /**
     * Summary of login
     * @return null
     */
    public function login(): mixed
    {
        // This method can be used for any pre-login logic if needed in the future
        return null;
    }

    /**
     * Summary of loginPost
     * @param LoginPostRequest $request
     * @return Customer
     */
    public function loginPost(LoginPostRequest $request): Customer
    {
        $validated = $request->validated();

        $credentials = [
            'email' => $validated['username'],
            'password' => $request->password
        ];
        $remember = $request->boolean('remember');

        if(!Auth::guard('buyer')->attempt($credentials, $remember))
        {
            throw new \Exception('Invalid username or password');
        };

        $customer = Auth::guard('buyer')->user();

        if($customer && $customer->status < 1)
        {
            Auth::guard('buyer')->logout();
            throw new \Exception('Your account is inactive. Please contact support.');
        }

        if(!$customer->hasVerifiedEmail())
        {
            Auth::guard('buyer')->logout();
            throw new \Exception('Please verify your email before logging.');
        }

        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return $customer;
    }

    /**
     * Summary of userLoginPost
     * @param LoginPostRequest $request
     * @return User
     */
    public function userLoginPost(LoginPostRequest $request): User
    {
        $validated = $request->validated();

        $credentials = [
            'email' => $validated['username'],
            'password' => $request->password
        ];
        $remember = $request->boolean('remember');

        if(!Auth::guard('user')->attempt($credentials, $remember))
        {
            throw new \Exception('Invalid username or password');
        };

        $user = Auth::guard('user')->user();


        if($user && $user->status < 1)
        {
            Auth::guard('user')->logout();
            throw new \Exception('Your account is inactive. Please contact support.');
        }

        if($user && !$user->hasVerifiedEmail())
        {
            session(['unverified_email' => $user->email]);

            Auth::guard('user')->logout();
            throw new \Exception(self::UNVERIFIED_EMAIL);
        }

        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return $user;
    }

    /**
     * Summary of logout
     * @return void
     */
    public function logout(): void
    {
        Auth::guard('buyer')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

    }

    /**
     * Summary of userLogout
     * @return void
     */
    public function userLogout(): void
    {
        Auth::guard('user')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

    }

    /**
     * Summary of register
     * @return mixed
     */
    public function register(): mixed
    {
        return null;
    }

    /**
     * Summary of userRegister
     * @return mixed
     */
    public function userRegister(): mixed
    {
        return null;
    }

    /**
     * Summary of registerPost
     * @param RegisterRequest $request
     * @return Customer
     */
    public function registerPost(RegisterRequest $request): Customer
    {
        $validated = $request->validated();

        if(User::nameExists($validated['name']))
        {
            throw new \Exception('Name already exists');
        }

        if(User::emailExists($validated['email']))
        {
            throw new \Exception('Email already exists');
        }

        if(Customer::emailExists($validated['email']))
        {
            throw new \Exception('Email already exists');
        }


        $customer = Customer::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'phone' => $validated['phone'] ?? null,
                    'country' => $validated['country'] ?? null,
            ]);

        return $customer;
    }

    /**
     * Summary of userRegisterPost
     * @param StoreUserRequest $request
     * @return User
     */
    public function userRegisterPost(StoreUserRequest $request): User
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

        UserEmailVerification::dispatch($user);

        return $user;
    }

    /**
     * Summary of me
     * @return User
     */
    public function me(): User
    {
        if (Auth::guard('user')->check()) {
            return Auth::guard('user')->user();
        }

        if (Auth::guard('buyer')->check()) {
            return Auth::guard('buyer')->user();
        }

        return null;
    }

    /**
     * Summary of forgotPassword
     * @param ForgotPasswordRequest $request
     * @return void
     */
    public function forgotPassword(ForgotPasswordRequest $request): void
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
     * Summary of resetPassword
     * @param ResetPasswordRequest $request
     * @return void
     */
    public function resetPassword(ResetPasswordRequest $request): void
    {
        $record = $this->authRepository->findByEmailAndTokens($request->email, $request->token);

        if(!$record)
        {
            throw new \Exception('Token not found or expired');
        }

        $user = User::where('email', $request->email)->first();

        if(!$user)
        {
            throw new \Exception('User not found');
        }

        $user->update(['password' => Hash::make($request->password)]);

        $this->authRepository->deleteByEmail($request->email);
    }

    /**
     * Summary of verifyEmail
     * @param int $id
     * @param string $hash
     * @return void
     */
    public function verifyEmail(int $id,string $hash):void
    {
        $user = User::findOrFail($id);

        if(! hash_equals($hash, sha1($user->email)))
        {
            throw new \Exception('Invalid hash');
        }

        if($user->hasVerifiedEmail())
        {
            throw new \Exception('Email already verified');
        }

        $user->markEmailAsVerified();

        UserRegistered::dispatch($user);
    }

    /**
     * Summary of ResendVerification
     * @param string $email
     * @return void
     */
    public function resendVerification(string $email):void
    {
        $user = User::where('email', $email)->first();

        if(!$user ||$user->hasVerifiedEmail())
        {
            return;
        }

        UserEmailVerification::dispatch($user,'email.verify');
    }
}
