<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\InfoUpdateRequest;
use App\Models\Category;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\ProfileServiceInterface;
use App\Http\Requests\PasswordUpdateRequest;

class ProfileController extends Controller
{

    public function __construct(
        protected AuthServiceInterface $authService,
        protected ProfileServiceInterface $profileService,
    ) {}

    /** Profile */
    function profile()
    {
        $this->profileService->profile();

        return view('frontend.auth.profile',
        ['categories' => Category::all()]);
    }

    function infoUpdate(InfoUpdateRequest $request)
    {
        try
        {
            $this->profileService->infoUpdate($request);

            return redirect()->route('profile',['tab' => 'info']    )->with('success', 'Profile updated successfully');

        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    function passwordUpdate(PasswordUpdateRequest $request)
    {
        try
        {
            $this->profileService->passwordUpdate($request);

            return redirect()->route('profile',['tab' => 'password'])->with('success', 'Password updated successfully');

        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
