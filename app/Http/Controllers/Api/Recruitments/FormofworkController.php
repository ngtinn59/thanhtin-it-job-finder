<?php

namespace App\Http\Controllers\Api\Recruitments;

use App\Models\Formofwork;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormofworkController extends Controller
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
        $Formofwork = Formofwork::create($input);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $Formofwork
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Formofwork $formofwork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Formofwork $formofwork)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formofwork $formofwork)
    {
        //
    }
}
