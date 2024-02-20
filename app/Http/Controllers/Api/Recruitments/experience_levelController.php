<?php

namespace App\Http\Controllers\Api\Recruitments;

use App\Models\Experience_level;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class experience_levelController extends Controller
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
        $Experience_level =  Experience_level::create($input);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $Experience_level
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Experience_level $experience_level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Experience_level $experience_level)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience_level $experience_level)
    {
        //
    }
}
