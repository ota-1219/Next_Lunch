<?php
namespace App\Libs;

use Session;

class sessionDAO
{
    public static function login($authid)
    {
        return Session::put('id', $authid);
    }

    public static function logout()
    {
        return Session::flush();
    }
}
