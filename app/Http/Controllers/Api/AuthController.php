<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class AuthController extends Controller
{
    /////////////////////////////////////////
    // REGISTER
    /////////////////////////////////////////
    public function register(Request $request)
    {   
        // validation
        $validateRegister = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validateRegister['password'] = bcrypt($request->password);

        // validate, then, create/register user
        $user = User::create($validateRegister);
        
        // create token
        $accessToken = $user->createToken('authToken')->accessToken;

        // return data
        return response([
            'user'=>$user,
            'access_token'=>$accessToken,
            'message'=>'You have successfully registered'
        ]);
    }

    /////////////////////////////////////////
    // LOGIN
    /////////////////////////////////////////
    public function login(Request $request)
    {
        // validation
        $validateLogin = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(!auth()->attempt($validateLogin)){
            return response([
                'message'=>'Invalid credentials'
            ]);
        } else {
            // token generation
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            // return user
            return response([
                'user'=>auth()->user(),
                'access_token'=>$accessToken,
                'message'=>'You have successfully loged-in'
            ]);
        }
    }

}
