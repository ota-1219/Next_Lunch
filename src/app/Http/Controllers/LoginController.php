<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libs\sessionDAO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function login(Request $req)
    {
        $reqpass = $req->input('password');
        $author = DB::table('author')->where('id', 1)->first();
        $authid = $author->id;


        // \Debugbar::info($pass, $req);
        // return redirect('/manage_list');
        if ($author->password == $reqpass) {
            sessionDAO::login($authid);
            return redirect('/manage_list');

        }

        $errorMessage = 'ログインエラーです。';
        return redirect('/')->with('errorMessage', $errorMessage);;
    }

    public function logout()
    {
        sessionDAO::logout();
        return redirect('/');
    }
}