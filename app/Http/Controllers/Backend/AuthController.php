<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use App\Services\Contracts\AuthServiceInterface;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function __construct
    (
        protected AuthServiceInterface $authService,
        protected ProductServiceInterface $productService,
    )
    {}


    /**
     * Sumary Login for admin
     * @return RedirectResponse
    */
    public function userLogin(): RedirectResponse
    {
        if(Auth::guard('user')->check())
        {
            return redirect()->route('user.dashboard');
        }

        $this->authService->login();
        $category = $this->productService->getListCategory();

        return view('Backend.auth.login',
        ['categories' => $category]);
    }

    /**
      * Sumary Login Post for admin
      * @param LoginPostRequest $request
      * @return \Illuminate\Http\RedirectResponse
    */
    public function userLoginPost(LoginPostRequest $request): RedirectResponse
    {
        try
        {
            $this->authService->userLoginPost($request);

            return redirect()->route('user.dashboard')->with('success', 'Login success');

        } catch (\Exception $e)
        {
            return redirect()->back()
                            ->withInput($request->only('email'))->with('error', $e->getMessage());
        }
    }

    /**
     * Summary of userLogout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userLogout(): RedirectResponse
    {
        $this->authService->userLogout();

        return redirect()->route('user.login')->with('success', 'Logout success');
    }

    /**
     * Summary of userRegister
     * @return View
     */
    public function userRegister(): View
    {
        $this->authService->userRegister();
        $category = $this->productService->getListCategory();

        return view('Backend.auth.register',
        ['categories' => $category]);
    }

    /**
     * Summary of userRegisterPost
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function userRegisterPost(StoreUserRequest $request): RedirectResponse
    {
         try
        {
            $user = $this->authService->userRegisterPost($request);

            Auth::guard('user')->login($user);
            $request->session()->regenerate();

            return redirect()->route('user.login')->with('success', 'Registration success');

        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Summary of forgotPassword
     * @return View
     */
    public function forgotPassword(): View
    {
        return view('Backend.auth.forgot-password');
    }

    /**
     * Sumary of forgotPasswordPost
     * @param forgotPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgotPasswordPost(ForgotPasswordRequest $request): RedirectResponse
    {
        try {
            $this->authService->forgotPassword($request);

            return redirect()->back()->with('success', 'if email exist, pleasecheck your email');
        } catch (\exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Summary of resetPassword
     * @param string $token
     * @return View
     */
    public function resetPassword(string $token): View
    {
        return view('Backend.auth.reset-password',
            ['token' => $token,
            'email' => request('email')]);
    }

    /**
     * Summary of resetPasswordPost
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPasswordPost(ResetPasswordRequest $request): RedirectResponse
    {
        try {
            $this->authService->resetPassword($request);

            return redirect()->route('user.login')->with('success', 'Reset password success. Please login');
        } catch (\exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
