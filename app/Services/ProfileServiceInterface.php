<?php

namespace App\Services;

use App\Http\Requests\InfoUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\CustomerPasswordUpdateRequest;
use App\Models\Customer;

interface ProfileServiceInterface
{
    public function profile(): mixed;

    public function userProfile(): mixed;

    public function editProfile(): mixed;

    public function infoUpdate(InfoUpdateRequest $request): mixed;

    public function userInfoUpdate(InfoUpdateRequest $request): mixed;

    public function passwordUpdate(CustomerPasswordUpdateRequest $request ): mixed;

    public function userPasswordUpdate(PasswordUpdateRequest $request): mixed;

    public function userAvatarUpdate(InfoUpdateRequest $request): mixed;
}
