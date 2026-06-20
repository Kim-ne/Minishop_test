<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use App\Services\Contracts\AuthServiceInterface;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\ResendVerificationApiRequest;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
     * @return View|RedirectResponse
    */
    public function userLogin(): View|RedirectResponse
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
            if($e->getMessage() === \App\Services\AuthService::UNVERIFIED_EMAIL)
                {
                    return redirect()->route('user.verification.notice')
                                    ->with('error', 'Please verify your email address first' );
                }
            return redirect()->back()
                            ->withErrors(['login' => $e->getMessage()]);
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
            $this->authService->userRegisterPost($request);

            return redirect()->route('user.login')->with('success', 'Registration success! Please check your email for verification');

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

    /**
     * Summary of verifyEmailNotice
     * @return View
     */
    public function verifyEmailNotice():view
    {
        return view('Backend.auth.verify-email');
    }

    /**
     * Summary of verifyEmail
     * @param Request $request
     * @param int $id
     * @param string $hash
     * @return RedirectResponse
     */
    public function verifyEmail(Request $request,int $id,string $hash):RedirectResponse
    {

        try {
            $this->authService->verifyEmail($id, $hash);

            return redirect()->route('user.login')->with('success', 'Email verified successfully, plaease login');
        } catch (\Exception $e) {
            return redirect()->route('user.login')->with('error', $e->getMessage());
        }
    }

    /**
     * Summary of resendVerification
     * @param Request $request
     * @return RedirectResponse
     */
    public function resendVerification(Request $request): RedirectResponse
    {
        $email = session('unverified_email');

        if(!$email)
        {
            return redirect()->route('user.login')->with('error', 'Your session has expired. Please login again.');
        }

        try
        {
            $this->authService->resendVerification($email);

            return redirect()->back()->with('success', 'Verification email sent');
        } catch (\Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }

    }

}
