<?php

namespace App\Http\Controllers\Api\Resume;

use App\Http\Controllers\Controller;
use App\Models\experiences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ExperiencesController extends Controller
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
            'title' => 'required',
            'company' => 'required',
            'date_range' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $input = $validator->validated();
        $experiences = Experiences::create($input);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $experiences
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(experiences $experiences)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, experiences $experiences)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(experiences $experiences)
    {
        //
    }
}
