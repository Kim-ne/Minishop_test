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


}

