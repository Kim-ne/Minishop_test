<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use App\Models\Category;
use App\Services\AuthServiceInterface;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct
    (
        protected AuthServiceInterface $authService,
    )
    {}
    /**
     * Login page
    */
    function userLogin()
    {
        $this->authService->login();

        return view('Backend.auth.login',
        ['categories' => Category::all()]);
    }

    /**
      * Sumary Login Post for admin
      * @param LoginPostRequest $request
      * @return \Illuminate\Http\RedirectResponse
    */
    function userLoginPost(LoginPostRequest $request)
    {
        try
        {
            $this->authService->userLoginPost($request);

            return redirect()->route('home')->with('success', 'Login success');

        } catch (\Exception $e)
        {
            return redirect()->back()
                            ->withInput($request->only('email'))->with('error', $e->getMessage());
        }
     }

    function userLogout()
    {
        $this->authService->userLogout();

        return redirect()->route('home')->with('success', 'Logout success');
    }

    function userRegister()
    {
        $this->authService->userRegister();

        return view('Backend.auth.register',
        ['categories' => Category::all()]);
    }

    function userRegisterPost(RegisterRequest $request)
    {
         try
        {
            $user = $this->authService->userRegisterPost($request);

            Auth::guard('user')->login($user);
            $request->session()->regenerate();

            return redirect()->route('home')->with('success', 'Registration success');

        } catch (\Exception $e)
        {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }


}
