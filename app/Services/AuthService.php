<?php

namespace App\Services;

use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Contracts\AuthServiceInterface;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthService implements AuthServiceInterface
{
    public function login(): mixed
    {
        // This method can be used for any pre-login logic if needed in the future
        return null;
    }

    public function loginPost(LoginPostRequest $request): mixed
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

        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return $customer;
    }

    public function userLoginPost(LoginPostRequest $request): mixed
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

        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return $user;
    }

    public function logout(): void
    {
        Auth::guard('buyer')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

    }

    public function userLogout(): void
    {
        Auth::guard('user')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

    }

    public function register(): mixed
    {
        return null;
    }

    public function userRegister(): mixed
    {
        return null;
    }

    public function registerPost(RegisterRequest $request): mixed
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


        $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'phone' => $validated['phone'] ?? null,
                    'country' => $validated['country'] ?? null,
            ]);

        return $user;
    }

    public function userRegisterPost(RegisterRequest $request): mixed
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

        $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'phone' => $validated['phone'] ?? null,
                    'country' => $validated['country'] ?? null,
            ]);

        return $user;
    }

    public function me(): mixed
    {
        if (Auth::guard('user')->check()) {
            return Auth::guard('user')->user();
        }

        if (Auth::guard('buyer')->check()) {
            return Auth::guard('buyer')->user();
        }

        return null;
    }
}

