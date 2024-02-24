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
        $input = [
            'title' => $request->input('title'),
            'company' => $request->input('company'),
            'stat_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'description' => $request->input('description'),
            'profiles_id' => $request->input('profiles_id')
        ];

        $validator = Validator::make($input, [
            'title' => 'required',
            'company' => 'required',
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
