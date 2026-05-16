<?php

namespace App\Services;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Collection;

interface RoleServiceInterface
{
    public function index(): Collection;

    public function store(StoreUserRequest $request): User;

    public function update(UpdateUserRequest $request, int $id): User;

    public function destroy(int $id): bool;


}
