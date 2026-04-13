<?php

namespace App\Services;

use App\Http\Requests\InfoUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService implements ProfileServiceInterface
{
    public function profile(): mixed
    {
        return Auth::guard('buyer')->user();
    }

     public function userProfile(): mixed
    {
        return Auth::guard('user')->user();
    }

    public function infoUpdate(InfoUpdateRequest $request): mixed
    {

        $validated = $request->validated();
        $customer = Auth::guard('buyer')->user();

        if(!$customer instanceof \App\Models\Customer)
        {
            throw new \Exception('Customer not found');
        }

        $customer->update($validated);

        return $customer;

    }

    public function userInfoUpdate(InfoUpdateRequest $request): mixed
    {

        $validated = $request->validated();
        $user = Auth::guard('user')->user();

        if(!$user instanceof \App\Models\User)
        {
            throw new \Exception('User not found');
        }

        $user->update([
            'phone' => $validated['phone'] ?? $user->phone,
            'country' => $validated['country'] ?? $user->country,
        ]);

        return $user;

    }

    public function passwordUpdate(PasswordUpdateRequest $request): mixed
    {

        $validated = $request->validated();
        $customer = Auth::guard('buyer')->user();

        if(!$customer instanceof \App\Models\Customer)
        {
            throw new \Exception('Customer not found');
        }

        $customer->update(['password' => Hash::make($validated['password'])]);

        return $customer;

    }

    public function userPasswordUpdate(PasswordUpdateRequest $request): mixed
    {
        dd(Auth::guard('user')->user(),Auth::guard('buyer')->user());
        $validated = $request->validated();
        $user = Auth::guard('user')->user();

        if(!$user instanceof \App\Models\User)
        {
            throw new \Exception('User not found');
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return $user;

    }


}

