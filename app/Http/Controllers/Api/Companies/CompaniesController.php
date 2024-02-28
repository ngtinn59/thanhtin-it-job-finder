<?php

namespace App\Http\Controllers\Api\Companies;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

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
            'Working_days' => $request->Working_days,
            'Overtime_policy' => $request->Overtime_policy,
            'webstie' => $request->webstie,
            'facebook' => $request->facebook,
            'logo' => $request->logo,
            'address' => $request->address,
            'description' => $request->description
        ];
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
