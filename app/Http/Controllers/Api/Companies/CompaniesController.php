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
        $companies = Company::with(['companytype', 'companysize', 'country', 'city'])->get();
        $companiesdata = $companies->map(function ($company) {
            $companyType = optional($company->companytype)->name;
            $companySize = optional($company->companysize)->name;
            $country = optional($company->country)->name;
            $city = optional($company->city)->name;

            return [
                'name' => $company->name,
                'company_type' => $companyType,
                'company_size' => $companySize,
                'country' => $country,
                'city' => $city,
                'Working_days' => $company->Working_days,
                'Overtime_policy' => $company->Overtime_policy,
                'webstie' => $company->webstie,
                'logo' => $company->logo,
                'facebook' => $company->facebook,
                'description' => $company->description,
                'address' => $company->address
            ];
        });
        return response()->json([
            'success' => true,
            'message' => 'Company details retrieved successfully.',
            'companies' => $companiesdata
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_size_id' => 'required',
            'company_type_id' => 'required',
            'name' => 'required',
            'Working_days' => 'required',
            'Overtime_policy' => 'required',
            'webstie' => 'required',
            'logo' => 'required',
            'facebook' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $request->only([
            'company_size_id', 'company_type_id', 'name', 'Working_days',
            'Overtime_policy', 'webstie', 'logo', 'facebook', 'description'
        ]);

        // Upload logo
        $file = $request->file('logo');
        $path = public_path('uploads/images');
        $file_name = Common::uploadFile($file, $path);

        $data['logo'] = $file_name;

        $company = Company::where('users_id', auth()->user()->id)->first();

        if ($company) {
            $company->update($data);
        } else {
            $data['users_id'] = auth()->user()->id;
            $company = Company::create($data);
        }

        return response()->json([
            'success'   => true,
            'message'   => "success update",
            "data" => $company
        ]);
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
