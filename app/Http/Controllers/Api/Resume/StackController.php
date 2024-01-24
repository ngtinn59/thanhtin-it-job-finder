<?php

namespace App\Http\Controllers\Api\Resume;

use App\Http\Controllers\Controller;
use App\Models\stacks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StackController extends Controller
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
            'projects_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $input = $validator->validated();
        $stacks = stacks::create($input);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $stacks
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(stacks $stacks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, stacks $stacks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(stacks $stacks)
    {
        //
    }
}
