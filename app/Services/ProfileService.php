<?php

namespace App\Services;

use App\Http\Requests\InfoUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\CustomerPasswordUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    public function editProfile(): mixed
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

        $user->update([$validated]);

        return $user;

    }

    public function passwordUpdate(CustomerPasswordUpdateRequest $request): mixed
    {

        $validated = $request->validated();
        $customer = Auth::guard('buyer')->user();

        if(!$customer instanceof \App\Models\Customer)
        {
            throw new \Exception('Customer not found');
        }

        $customer->update(['password' => $validated['password']]);

        return $customer;

    }

    public function userPasswordUpdate(PasswordUpdateRequest $request): mixed
    {
        $validated = $request->validated();
        $user = Auth::guard('user')->user();


        if(!$user instanceof \App\Models\User)
        {
            throw new \Exception('User not found');
        }

        $user->update(['password' => $validated['password']]);

        return $user;

    }

    public function userAvatarUpdate(InfoUpdateRequest $request): mixed
    {
        $validated = $request->validated();
        $user = Auth::guard('user')->user();

        if(!$user instanceof \App\Models\User)
        {
            throw new \Exception('User not found');
        }

        if($request->hasFile('avatar'))
        {
            if($user->avatar)
            {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            $filename = $request->file('avatar')->store('avatars', 'public');

            $user->update(['avatar' => basename($filename)]);
        }

        return $user;
    }
}

