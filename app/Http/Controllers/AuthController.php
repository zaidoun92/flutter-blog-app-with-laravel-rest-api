<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Http\User;

class AuthController extends Controller
{
    //

    public function register(Request $request) {

        // vaildate fields
        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // create user
        $user = User::create([
            'name' => $attrs['name'],
            'email'=> $attrs['email'],
            'password' => bcrypt($attrs['password'])
        ]);

        // return user & token in response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 200);
    }


    // login user
    public function login(Request $request) {

        // vaildate fields
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // attempt login
        if (!Auth::attempt($attrs)) {

            return response([
                'message' => 'Invalid credentials.'
            ], 403);
        }


        // return user & token in response
        return response([
            'user' => $request->user(),
            'token' => $request->user()->createToken('secret')->plainTextToken
        ], 200);
    }


    // logout user
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response([
            'message' => 'Logout success',
        ], 200);
    }


    // get user details
    public function user()
    {
        return response([
            'user' => auth()->user(),
        ], 200);
    }
}
