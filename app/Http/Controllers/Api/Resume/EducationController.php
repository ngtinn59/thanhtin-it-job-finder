<?php

namespace App\Http\Controllers\Api\Resume;

use App\Http\Controllers\Controller;
use App\Models\educations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
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

        $profilesId = $request->input('profiles_id');

        $validator = Validator::make($input, [
            'institution' => 'required',
            'degree' => 'required',
            'date-range' => 'required',
            'profiles_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $input = $validator->validated();

        // Gán giá trị 'profiles_id' từ yêu cầu (request)
        $input['profiles_id'] = $profilesId;

        $education = educations::create($input);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $education
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(educations $educations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, educations $educations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(educations $educations)
    {
        //
    }
}
