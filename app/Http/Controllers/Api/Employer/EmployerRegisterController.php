<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Location_Comapny;
use App\Models\User;
use App\Utillities\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployerRegisterController extends Controller
{
    public function employerRegister(Request $request)
    {
        $data =[
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ];

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validated();
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'account_type' => Constant::user_level_employer,
            'status' => Constant::user_status_active,
            'password' => Hash::make($request->password),
        ]);

        Company::create([
            'users_id'=>$user->id,
            'country_id'=> request('country_id'),
            'name'=> request('name'),
        ]);



        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
