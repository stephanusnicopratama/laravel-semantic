<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Gate;
use DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            $status = true;
        } else {
            $status = false;
        }
        $check = Auth::attempt(['username' => $username, 'password' => $password]);
        return json_encode(array('status' => $status));
    }

    public function logout()
    {
        if (Auth::user()) {
            Auth::logout();
            $status = true;
        } else {
            $status = false;
        }
        return json_encode(array('status' => $status));
    }

    public function checkPassword(Request $request)
    {
        $dbPassword = DB::table('users')->where('id', Auth::user()->id)->pluck('password');
        $password = $request->input('password');
        if (Hash::check($password, $dbPassword[0])) {
            $data = true;
        } else {
            $data = false;
        }
        return json_encode(array('status' => $data));
    }

    public function checkUsername(Request $request)
    {
        $username = $request->input('username');
        $dbUsername = User::where('username', $username)->get();
        if (count($dbUsername) > 0) {
            $data = true;
        } else {
            $data = false;
        }
        return json_encode(array('status' => $data));
    }

    public function editUser(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password1');
        $email = $request->input('email');
        $role = $request->input('role');
        try {
            DB::beginTransaction();
            $data = DB::table('users')->where('id', Auth::user()->id)
                ->update([
                    'email' => $email,
                    'username' => $username,
                    'role' => $role,
                    'password' => Hash::make($password)
                ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return json_encode(array('status' => $data));
    }

}
