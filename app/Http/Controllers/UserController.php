<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function getAllUser()
    {
        $data = User::all();
        return json_encode(array('data' => $data));
    }

    public function deleteUser(Request $request)
    {
        $userId = $request->input('id');
        if (DB::table('users')->where('id', $userId)->delete()) {
            $data = true;
            $request->session()->flash('alert-success', ' Report is deleted successfully.');
        }
        return json_encode(array('data' => $data));
    }

    public function addNewUser(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password1');
        $email = $request->input('email');
        $role = $request->input('role');
        $data = User::create([
            'username' => $username,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);
        if ($data) {
            $status = true;
        } else {
            $status = false;
        }
        return json_encode(array('status' => $status));
    }

    public function getOneUser(Request $request)
    {
        $userId = $request->input('id');
        $data = User::find($userId);
        return json_encode(array($data));
    }

    public function updateUser(Request $request)
    {
        $userId = $request->input('id');
        $username = $request->input('username');
        $password = $request->input('password1');
        $email = $request->input('email');
        $role = $request->input('role');
        if (($password === '') || !isset($password)) {
            $data = DB::table('users')->where('id', $userId)->update([
                'username' => $username,
                'email' => $email,
                'role' => $role
            ]);
        } else {
            $data = DB::table('users')->where('id', $userId)->update([
                'username' => $username,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role
            ]);
        }
        if ($data) {
            $status = true;
        } else {
            $status = false;
        }
        return json_encode($status);
    }
}
