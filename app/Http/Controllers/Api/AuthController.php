<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Utillities\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'account_type' => Constant::user_level_developer,
            'status' => Constant::user_status_active,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(LoginRequest $request)
    {




        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response() ->json(['message' => 'Invalid login details'], 401);
        }

        $user  = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' =>  true,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }


    public function logout(Request $request) {
            $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout Sucess'], 200);
    }
}
