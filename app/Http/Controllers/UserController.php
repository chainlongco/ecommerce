<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Not using Ajax call
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            //return redirect('/login2')->withErrors($validator->errors())->withInput();
            return response()->json(['url' => '/login2',]);
        } else {
            //Session::put('user', $user);
            return redirect('/products');
        }
        /*$request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);*/
        //return $request->input();
        /*$validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            print_r($validator->errors());
            //Session::put('errors', $validator->errors());
            return redirect('login2');
            //return redirect()->back()->withErrors($validator->errors());
        } else {
            //Session::put('user', $user);
            return redirect('/products');
        }*/
        

        /*$user = DB::table('users')->where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password))
        {
            return 'Email and Password not matched';
        }
        else
        {
            Session::put('user', $user);
            return redirect('/products');
        }*/
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login');
    }

    public function register(Request $request)
    {
        // Using Ajax call
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:254',
            'email' => 'required|unique:users|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if ($user->save()){
                return response()->json(['status'=>1, 'msg'=>'New User has been successfully registered']);
                //return view('login');
            }
        } else {
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }

        
        
    }
}
