<?php

namespace App\Services;

use App\Http\Requests\InfoUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;

interface ProfileServiceInterface
{
    public function profile(): mixed;

    public function userProfile(): mixed;

    public function infoUpdate(InfoUpdateRequest $request): mixed;

    public function userInfoUpdate(InfoUpdateRequest $request): mixed;

    public function passwordUpdate(PasswordUpdateRequest $request): mixed;

    public function userPasswordUpdate(PasswordUpdateRequest $request): mixed;
}
