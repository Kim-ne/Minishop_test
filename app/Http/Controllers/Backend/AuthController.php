<?php

namespace App\Http\Controllers\Backend;

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
    function adminLogin()
    {
        return view('Backend.auth.login',
        ['categories' => Category::all()]);
    }

    /**
      * Sumary Login Post for admin
      * @param Request $request
      * @return \Illuminate\Http\RedirectResponse
    */
    function adminLoginPost(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'password' => 'required|max:50',
            'remember' => 'boolean'
        ]);

        $cer = Auth::guard('user')->attempt([
            'name' => $validated['name'],
            'password' => $request->password
        ], $request->boolean('remember'));

        if($cer){
            if(Auth::guard('user')->user()->status == 1){
                $request->session()->regenerate();
                $request->session()->regenerateToken();
                return redirect()->route('home');
            } else{
            Auth::guard('user')->logout();
            return redirect()->back()->with('error', 'Invalid username or password');
            }
        };
        return redirect()->back()->with('error', 'Login failed');
    }


    /** Logout */

    function adminLogout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('home');
    }

    /** Profile */
    function adminProfile()
    {
        return view('Backend.auth.profile',
        ['categories' => Category::all()]);
    }

}
