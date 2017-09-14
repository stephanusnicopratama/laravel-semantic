<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Middleware\Authenticate;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            // Authentication passed...
            $status = true ;
        } else {
            $status = false;
        }
        return json_encode(array('status' => $status));
    }
}
