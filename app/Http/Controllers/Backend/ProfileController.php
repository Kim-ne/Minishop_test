<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\InfoUpdateRequest;
use App\Models\Category;
use App\Http\Requests\PasswordUpdateRequest;
use App\Services\ProfileServiceInterface;

class ProfileController extends Controller
{
    public function __construct
    (
        protected ProfileServiceInterface $profileService,
    )
    {}
    /** User Profile */
    function userProfile()
    {
        $this->profileService->userProfile();

        return view('Backend.auth.profile',
        ['categories' => Category::all()]);
    }

    /** Info update */
    function userInfoUpdate(InfoUpdateRequest $request)
    {
        try
        {
            $this->profileService->userInfoUpdate($request);
            return redirect()->back()->with('success', 'Profile updated');

        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    function userPasswordUpdate(PasswordUpdateRequest $request)
    {
        try
        {
            $this->profileService->userPasswordUpdate($request);

            return redirect()->route('userProfile')->with('success', 'Password updated');

        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}


