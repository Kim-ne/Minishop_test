<?php

namespace App\Services;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Services\Contracts\RoleServiceInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class RoleService implements RoleServiceInterface
{
    /**
     * Summary of index
     * @return Collection
     */
    public function index(): Collection
    {
        $users = User::forRoleManagement();

        return $users;
    }

    /**
     * Summary of store
     * @param StoreUserRequest $request
     * @return User
     */

    public function store(StoreUserRequest $request): User
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        return $user;
    }

    /**
     * Summary of update
     * @param UpdateUserRequest $request
     * @param int $id
     * @return User
     */

    public function update(UpdateUserRequest $request, int $id): User
    {
        $validated = $request->validated();

        $user = User::findOrFail($id);

        if($user->id === auth()->guard('user')->id())
        {
            throw new \Exception('You cannot change your own role');
        }

        $user->update([
            'role' => $validated['role'],
        ]);

        return $user;
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return bool
     */

    public function destroy(int $id): bool
    {
        $user = User::findOrFail($id);

        if($user->id === auth()->guard('user')->id())
        {
            throw new \Exception('You cannot delete your own account');
        }

        $user->delete();
        return true;
    }
}

