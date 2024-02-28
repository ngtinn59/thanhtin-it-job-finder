<?php

namespace App\Http\Controllers\Api\Companies;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompaniesController extends Controller
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
            'title' => $request->title,
            'url_tilte' => $request->url_tilte,
            'company_size' => $request->company_size,
            'company_type' => $request->company_type,
            'Working_days' => $request->Working_days,
            'Overtime_policy' => $request->Overtime_policy,
            'webstie' => $request->webstie,
            'facebook' => $request->facebook,
            'logo' => $request->logo,
            'address' => $request->address,
            'description' => $request->description,
        ];
        $validator = Validator::make($data, [
            'title' => 'required',
            'url_tilte' => 'required',
            'company_size' => 'required',
            'Working_days' => 'required',
            'Overtime_policy' => 'required',
            'webstie' => 'required',
            'facebook' => 'required',
            'logo' => 'required',
            'address' => 'required',
            'description' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validated();
        $company = Company::create($data);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $company,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
