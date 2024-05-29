<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function signin(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
    
        // Check email
        $user = User::where('email', $fields['email'])->first();
    
        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Incorrect email and/or password'], 401);
        }
    
        $token = $user->createToken('secret-token')->plainTextToken;
    
        $response = [
            'user' => $user,
            'token' => $token
        ];
    
        return response($response, 201);
    }
    
    public function signout(Request $request)
    {
        auth()->user()->tokens->each(function ($token) {
            $token->delete();
        });
    
        return [
            'message' => 'You have been signed out.'
        ];
    }

    public function allUsers(Request $request)
    {

        $user = User::all();
        echo "<pre>";
        print_r(json_decode($user));
        echo "</pre>";
        die('48');
    }
}
