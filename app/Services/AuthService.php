<?php

namespace App\Services;

use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterRequest;
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

        $user = Auth::guard('buyer')->user();

        if($user && $user->status < 1)
        {
            Auth::guard('buyer')->logout();
            throw new \Exception('Your account is inactive. Please contact support.');
        }

        return $user;
    }

    public function logout(): void
    {
        Auth::guard('buyer')->logout();
    }

    // {
    //     return Auth::guard('buyer')->user();
    // }

    public function register(): mixed
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

        $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'phone' => $validated['phone'] ?? null,
                    'country' => $validated['country'] ?? null,
            ]);

        return $user;
    }
}

