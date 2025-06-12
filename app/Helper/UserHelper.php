<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
class UserHelper
{
    public static function userInfo()
    {
        $user = Auth::user();
        $info = [
            'username' => $user->username,
            'privilage' => $user->privilage
        ];
        return $info;
    }
}
