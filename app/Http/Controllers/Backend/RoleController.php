<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\RoleServiceInterface;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function __construct
    (
        protected RoleServiceInterface $roleService,
    )
    {}
    /**
     * Summary of index
     * @return view
     */
    public function index(): View
    {
        $users = $this->roleService->index();

        return view('Backend.auth.role', [
            'users' => $users
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        try
        {
            $this->roleService->store($request);

            return redirect()->route('roles.index')->with('success', 'User created successfully');

        } catch (\Exception $e)
        {
            return redirect()->back()
                            ->withInput($request->only('email'))->with('error', $e->getMessage());
        }
    }

    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        try
        {
            $this->roleService->update($request, $id);

            return redirect()->route('roles.index')->with('success', 'User updated successfully');

        } catch (\Exception $e)
        {
            return redirect()->back()
                            ->withInput($request->only('email'))->with('error', $e->getMessage());
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try
        {
            $this->roleService->destroy($id);

            return redirect()->route('roles.index')->with('success', 'User deleted successfully');

        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
