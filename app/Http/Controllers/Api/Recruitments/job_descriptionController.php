<?php

namespace App\Http\Controllers\Api\Recruitments;

use App\Models\job_description;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class job_descriptionController extends Controller
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
            'recruitments_id' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $input = $validator->validated();
        $job_description = job_description::create($input);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $job_description
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(job_description $job_description)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, job_description $job_description)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(job_description $job_description)
    {
        //
    }
}
