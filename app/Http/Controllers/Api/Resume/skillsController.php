<?php

namespace App\Http\Controllers\Api\Resume;

use App\Http\Controllers\Controller;
use App\Http\Resources\skillsResource;
use App\Http\Resources\skillsResourceCollection;
use App\Models\skills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class skillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = skills::all();
        return (new skillsResourceCollection($skills))->response();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
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

        $input = $validator->validated();
        $skills = skills::create($input);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $skills
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $skills = skills::find($id);
        return (new skillsResource($skills))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, skills $skills)
    {
        dd($request->all());
        $skills->update($request->validate());

        return new skillsResource($skills);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(skills $skills)
    {
        $skills->delete();

        return response()->noContent();
    }
}
