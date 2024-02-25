<?php

namespace App\Http\Controllers\Api\Resume;

use App\Models\aboutme;
use App\Models\skills;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class skillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'profiles_id' => $request->input('profiles_id')
        ];

        $validator = Validator::make($data, [
            'name' => 'required',
            'profiles_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validated();
        $skills = skills::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $skills
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(skills $skills)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, skills $skills)
    {
        dd($skills->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(skills $skills)
    {
        //
    }
}
