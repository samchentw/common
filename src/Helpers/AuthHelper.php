<?php

namespace Samchentw\Common\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    /**
     * 取得目前使用者
     */
    public static function currentUser()
    {
        if (Auth::check()) return Auth::user();
        return null;
    }

    /**
     * 確認當前是否有登入
     */
    public static function checkLogin()
    {
        return Auth::check();
    }

}
