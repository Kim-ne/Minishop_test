<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Login page
    */
    function login()
    {
        return view('frontend.auth.login',
        ['categories' => Category::all()]);
    }

    /**
     * Login post for customer
    */
    function loginPost(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|email|max:50',
            'password' => 'required|max:50',
            'remember' => 'boolean'
        ]);

        $cer = Auth::guard('buyer')->attempt([
            'email' => $validated['username'],
            'password' => $request->password
        ], $request->boolean('remember'));

        if($cer){
            if(Auth::user()->status == 1){
                $request->session()->regenerate();
                $request->session()->regenerateToken();
                return redirect()->route('home');
            } else{
            Auth::guard('buyer')->logout();
            return redirect()->back()->with('error', 'Invalid username or password');
            }
        };
        return redirect()->back()->with('error', 'Login success');
    }

     /**
      * Sumary Login Post for admin
      * @param Request $request
      * @return \Illuminate\Http\RedirectResponse
      */
     function adminLoginPost(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|email|max:50',
            'password' => 'required|max:50',
            'remember' => 'boolean'
        ]);

        $cer = Auth::guard('user')->attempt([
            'email' => $validated['name'],
            'password' => $request->password
        ], $request->boolean('remember'));

        if($cer){
            if(Auth::user()->status == 1){
                $request->session()->regenerate();
                $request->session()->regenerateToken();
                return redirect()->route('home');
            } else{
            Auth::guard('user')->logout();
            return redirect()->back()->with('error', 'Invalid username or password');
            }
        };
        return redirect()->back()->with('error', 'Login success');
    }


    /** Logout */

    function logout()
    {
        Auth::guard('buyer')->logout();
        return redirect()->route('home');
    }

    /** Profile */
    function profile()
    {
        return view('frontend.auth.profile',
        ['categories' => Category::all()]);
    }

    function register(){
        return view('frontend.auth.register',
        ['categories' => Category::all()]);
    }

    function registerPost(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:50|min:4',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()
            ],
            'password_confirmation' => 'required',
            'email_confirmation' => 'required|email|same:email',
            'phone' => 'digits_between:9,15|nullable',
            'country'=>'max:50|min:2|string|nullable',
        ]);

        $users = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'phone' => $validated['phone'] ?? null,
                    'country' => $validated['country'] ?? null,
            ]);


        Auth::guard('user')->login($users);
        $request->session()->regenerate();
        return redirect()->route('home')->with('success', 'Registration success');

    }
}
