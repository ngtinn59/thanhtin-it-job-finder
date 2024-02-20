<?php

namespace App\Http\Controllers\Api\Recruitments;

use App\Models\skills_required;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class skills_requiredController extends Controller
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'recruitments_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $input = $validator->validated();
        $education = skills_required::create($input);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $education
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(skills_required $skills_required)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, skills_required $skills_required)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(skills_required $skills_required)
    {
        //
    }
}
