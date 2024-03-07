<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Company_size;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Company_sizesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company_size = Company_size::all();
        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $company_size
        ]);
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
        $company_size = Company_size::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $company_size
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company_size $company_size)
    {
        dd($company_size->id);
        return response()->json([
            'success' => true,
            'message' => 'success',
            "data" => $company_size
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company_size $company_size)
    {
        $data = $request->all();


        $company_size->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Company_size updated successfully',
            'data' => $company_size,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company_size $company_size)
    {
        $company_size->delete();
        return response()->json([
            'success' => true,
            'message' => 'Company_size deleted successfully',
        ]);
    }
}
