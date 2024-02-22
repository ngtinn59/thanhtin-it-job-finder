<?php

namespace App\Http\Controllers\Api\Recruitments;

use App\Http\Controllers\Controller;
use App\Models\profiles;
use App\Models\recruitments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecruitmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){

        $users = recruitments::with("job_requirements")
            ->with("form_of_work")
            ->with("experience_level")
            ->get();

        $userData = $users->map(function ($user) {
            return [
                'title' => $user->title,
                'position' => $user->position,
                'quantity' => $user->quantity,
                'min_salary' => $user->min_salary,
                'max_salary' => $user->max_salary,
                'expiration_date' => $user->expiration_date,
                'address_work' => $user->address_work,
                'benefits' => $user->benefits,
                'recruitment_status' => $user->recruitment_status,
                'job_requirements' => $user->job_requirements->map(function ($job_requirements) {
                    return [
                        'body' => $job_requirements->name,
                    ];
                }),
                'job_description' => $user->job_requirements->map(function ($job_description) {
                    return [
                        'body' => $job_description->name,
                    ];
                }),
                'form_of_work' => $user->form_of_work->map(function ($form_of_work) {
                    return [
                        'body' => $form_of_work->name,
                    ];
                }),
                'experience_level' => $user->experience_level->map(function ($experience_level) {
                    return [
                        'body' => $experience_level->name,
                    ];
                }),

            ];
        });

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $userData
        ]);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = [
            'users_id' => Auth::id(),
            'title' => $request->title,
            'position' => $request->position,
            'min_salary' => $request->min_salary,
            'max_salary' => $request->max_salary,
            'expiration_date' => $request->expiration_date,
            'quantity' => $request->quantity,
            'address_work' => $request->address_work,
            'benefits' => $request->benefits,
            'recruitment_status' => $request->recruitment_status
        ];

        $validator = Validator::make($input, [
            'users_id' => 'required',
            'title' => 'required',
            'position' => 'required',
            'min_salary' => 'required',
            'max_salary' => 'required',
            'quantity' => 'required',
            'expiration_date' => 'required',
            'address_work' => 'required',
            'benefits' => 'required',
            'recruitment_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $input = $validator->validated();
        $recruitments = recruitments::create($input);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $recruitments
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(recruitments $recruitments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, recruitments $recruitments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(recruitments $recruitments)
    {
        //
    }
}
