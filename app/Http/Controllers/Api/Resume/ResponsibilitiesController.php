<?php

namespace App\Http\Controllers\Api\Resume;

use App\Http\Controllers\Controller;
use App\Models\responsibilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResponsibilitiesController extends Controller
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
            'details' => 'required',
            'experiences_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $input = $validator->validated();
        $responsibilities = responsibilities::create($input);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $responsibilities
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(responsibilities $responsibilities)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, responsibilities $responsibilities)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(responsibilities $responsibilities)
    {
        //
    }
}
