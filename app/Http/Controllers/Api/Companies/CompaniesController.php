<?php

namespace App\Http\Controllers\Api\Companies;

use App\Http\Controllers\Controller;
use App\Models\aboutme;
use App\Models\Company;
use App\Models\Country;
use App\Models\Location;
use App\Models\Location_Comapny;
use App\Models\Profile;
use App\Models\User;
use App\Utillities\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $company = Company::all();
        return response()->json([
            'success' => true,
            'message' => 'Company locations retrieved successfully.',
            'company' => $company
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     */
    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $country = $company->country_id;
        $country = Country::find($country);

        return response()->json([
            'success' => true,
            'message' => 'Company locations retrieved successfully.',
            'company' => $company,
            'country' => $country
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {

        Company::where('id', $company->id)->update([
            'name' => $request->input('name'),
            'company_size' => $request->input('company_size'),
            'company_type' => $request->input('company_type'),
            'Working_days' => $request->input('Working_days'),
            'Overtime_policy' => $request->input('Overtime_policy'),
            'webstie' => $request->input('webstie'),
            'facebook' => $request->input('facebook'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'success'   => true,
            'message'   => "success update",
            "data" => $company
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }

    public function logo(Request $request)
    {
        $user_id = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'logo' => 'required|image|mimes:jpeg,jpg,png|max:1024',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;

            // Retrieve the old logo filename
            $oldLogo = Company::where('users_id', $user_id)->value('logo');

            // Delete the old logo file
            if(is_file(public_path('uploads/logo/' . $oldLogo))){
                unlink(public_path('uploads/logo/' . $oldLogo));
            }

            $file->move('uploads/logo/', $filename);

            // Update the logo filename in the database
            Company::where('users_id', $user_id)->update([
                'logo' => $filename
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Logo updated successfully.',
                'logo_filename' => $filename
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No logo file provided.',
            ], 400);
        }
    }
}
