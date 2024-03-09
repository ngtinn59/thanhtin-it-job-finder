<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Utillities\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployerRegisterController extends Controller
{
    public function employerRegister(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);

        $user = User::create([
            'name'         => $validatedData['name'],
            'email'        => $validatedData['email'],
            'account_type' => Constant::user_level_employer,
            'status'       => Constant::user_status_active,
            'password'     => Hash::make($validatedData['password']),
        ]);

        Company::create([
            'users_id'   => $user->id,
            'country_id' => $validatedData['country_id'],
            'city_id'    => $validatedData['city_id'],
            'name'       => $validatedData['name'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
