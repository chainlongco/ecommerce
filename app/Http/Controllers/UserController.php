<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password))
        {
            return 'Email and Password not matched';
        }
        else
        {
            $request->session()->put('user', $user);
            return redirect('/products');
        }
    }
}
