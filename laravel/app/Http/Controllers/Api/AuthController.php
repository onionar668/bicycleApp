<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'required|string|min:3',
            'email' => 'required|string|unique:users',
            'phone' => 'string|unique:users',
            'password' => 'required|string'
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => $validate->errors()
            ], 400);
        }

       $user = User::create([
            'id' => $request->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone
        ]);

        return response()->json([
            'message' => 'User create successfully',
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => $validate->errors()
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User sign-out successfully'
        ], 200);
    }
    public function me(Request $request)
    {
        /** @var App\Models\User */

        $user = Auth::user();

        $user->load('booking');

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'balance' => $user->balance,
            'booking' => $user->booking
        ], 200);
    }

    public function meHistory()
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $user->load('balanceHistory');

        return response()->json([
            'data' => $user->balanceHistory
        ]);
    }
}
