<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

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
     * Login post
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
}
