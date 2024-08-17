<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * User authentication
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    
        $token = $user->createToken('Access Token')->plainTextToken;
    
        return response()->json([
            'success' => true,
            'message' => 'Authenticated',
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ],
        ]);
    }

    /**
     * User register
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/'
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    
        if (!$user) {
            return response()->json(['error' => 'Something went wrong'], 400);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => [
                'name' => $user->name,
                'email' => $user->email
            ],
        ]);
    }
}
