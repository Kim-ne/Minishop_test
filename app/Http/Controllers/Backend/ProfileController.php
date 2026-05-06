<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\InfoUpdateRequest;
use App\Models\Category;
use App\Http\Requests\PasswordUpdateRequest;
use App\Services\ProfileServiceInterface;
use App\Services\ProductServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;

class ProfileController extends Controller
{
    public function __construct
    (
        protected ProfileServiceInterface $profileService,
        protected ProductServiceInterface $productService,
    )
    {}

    /**
     * Summary of userProfile
     *
     * @return View
    */
    public function userProfile(): View
    {

        $this->profileService->userProfile();
        $categories = $this->productService->getListCategory();

        return view('Backend.auth.profile', [
            'categories' => $categories
        ]);
    }

    /**
     * Summary of editProfile
     *
     * @return View
     */
    public function editProfile(): View
    {
        $this->profileService->editProfile();

        return view('Backend.auth.edit-profile');
    }

    /**
     * Summary of userInfoUpdate
     *
     * @param InfoUpdateRequest $request
     * @return RedirectResponse
     */
    public function userInfoUpdate(InfoUpdateRequest $request): RedirectResponse
    {
        try
        {
            $this->profileService->userInfoUpdate($request);
            return redirect()->back()->with('success', 'Profile updated');

        } catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * Summary of userPasswordUpdate
     *
     * @param PasswordUpdateRequest $request
     * @return RedirectResponse
         */
    public function userPasswordUpdate(PasswordUpdateRequest $request): RedirectResponse
    {
        try
        {
            $this->profileService->userPasswordUpdate($request);

            return redirect()->route('editProfile')->with('success', 'Password updated');

        } catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function userAvatarUpdate(InfoUpdateRequest $request): RedirectResponse
    {
        try
        {
            $this->profileService->userAvatarUpdate($request);

            return redirect()->route('editProfile')->with('success', 'Avatar updated');

        } catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}


