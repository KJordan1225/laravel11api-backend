<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate ([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);        
       
        $user = User::create($fields);

        $token = $user->createToken($request->name);

        return[
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function login(Request $request)
    {
        //Validate login fields
        $request->validate ([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);
        
        //Grab user via query
        $user = User::where('email', $request->email)->first();

        //Error handling
        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'errors' => [
                    'email' => ['The provided credentials are incorrect']
                ]
            ];
        }

        //Create token. Return user and troken.
        $token = $user->createToken($request->email);

        return[
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.'
        ];
    }
}

