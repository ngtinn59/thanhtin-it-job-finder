<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Company_size;
use App\Models\Company_type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Company_typesController extends Controller
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
        $data = [
            'name' => $request->input('name'),
        ];


        $validator = Validator::make($data, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validated();
        $company_type = Company_type::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $company_type
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company_type $company_type)
    {
        dd($company_type->id);
        return response()->json([
            'success' => true,
            'message' => 'success',
            "data" => $company_type
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company_type $company_type)
    {
        dd($company_type->id);

        $data = $request->all();


        $company_type->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Company_type updated successfully',
            'data' => $company_type,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company_type $company_type)
    {
        $company_type->delete();
        return response()->json([
            'success' => true,
            'message' => 'Company_type deleted successfully',
        ]);
    }
}
