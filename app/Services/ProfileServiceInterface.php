<?php

namespace App\Services;

use App\Http\Requests\InfoUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;

interface ProfileServiceInterface
{
    public function profile(): mixed;

    public function infoUpdate(InfoUpdateRequest $request): mixed;

    public function passwordUpdate(PasswordUpdateRequest $request): mixed;
}
