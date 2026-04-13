<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Services\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(
        protected AuthServiceInterface $authService,
    ) {}

    /**
     * Login page
    */
    function login()
    {
        $this->authService->login();

        return view('frontend.auth.login',
        ['categories' => Category::all()]);
    }

    /**
     * LoginPost for customer
    */
    function loginPost(LoginPostRequest $request)
    {
        try
        {
            $this->authService->loginPost($request);

            return redirect()->route('home')->with('success', 'Login success');

        } catch (\Exception $e)
        {
            return redirect()->back()
                            ->withInput($request->only('email'))->with('error', $e->getMessage());
        }
    }

    /** Logout */

    function logout()
    {
        $this->authService->logout();

        return redirect()->route('home');
    }

    /* Register page
    */
    function register()
    {
        $this->authService->register();

        return view('frontend.auth.register',
        ['categories' => Category::all()]);
    }

    /* Register Post for user
    */
    function registerPost(RegisterRequest $request)
    {
        try
        {
            $user = $this->authService->registerPost($request);

            Auth::guard('buyer')->login($user);
            $request->session()->regenerate();

            return redirect()->route('home')->with('success', 'Registration success');

        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }


    }
}
