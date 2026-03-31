<?php

namespace App\Helper;
use Illuminate\Support\Facades\Auth;

class AuthHelpers
{
    public static function buyer(){
        Auth::guard('buyer')->check();
    }

    public static function user(){
        Auth::guard('user')->check();
    }


};
?>
