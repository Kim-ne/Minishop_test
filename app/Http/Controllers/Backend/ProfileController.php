<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
     /** Logout */

    function userLogout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('home');
    }

    /** Profile */
    function userProfile()
    {
        return view('Backend.auth.profile',
        ['categories' => Category::all()]);
    }

    /** update */
    function updateProfile(Request $request)
    {
        dd($user = Auth::guard('user')->user());

        $validated = $request->validate([
            'email'=>'required|email|max:50|min:10',
            'phone' => 'digits_between:9,15|nullable',
            'country'=>'max:50|min:2|string|nullable',
        ]);

        $user ->update($validated);

        return redirect()->back()->with('success', 'Profile updated');

    }

    function updatePassword(Request $request)
    {
        $user = Auth::guard('user')->user();
        if(!($user instanceof \App\Models\User)){
            return redirect()->back()->with('error', '404');
        };
        $validated = $request->validate([
            'current_password' => 'required|min:6',
            'new_password' => [
                'required',
                'confirmed',
                'max:50',
                Password::min(6)->mixedCase()->numbers()->letters(),
            ],
            'password_confirmation' => 'required|same:new_password',
        ]);

        if(!Hash::check($validated['current_password'], $user->password)){
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        $user->update(['password' => Hash::make($validated['new_password'])]);


        return redirect()->back()->with('success', 'Password updated');
    }
}

