<?php

namespace App\Http\Controllers\Api\Resume;

use App\Models\aboutme;
use App\Models\Award;
use App\Models\Certificate;
use App\Http\Controllers\Controller;
use App\Models\profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CertificatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where("id", auth()->user()->id)->firstOrFail();
        $profiles = profile::where("users_id", $user->id)->firstOrFail();
        $certificate = Certificate::where("profiles_id", $profiles->id)->get();
        $certificateData = $certificate->map(function ($certificate) {
            return [
                'name' => $certificate->name,
                'title' => $certificate->title,
                'date' => $certificate->date,
                'description' => $certificate->description,
                'link' => $certificate->link
            ];
        });

        // Trả về danh sách giáo dục dưới dạng JSON
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $certificateData
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $profile = $user->profile->first();
        $profiles = $profile->id;

        $data = [
            'title' => $request->input('title'),
            'profiles_id' =>$profiles,
            'name' => $request->input('name'),
            'date' => $request->input('date'),
            'description' => $request->input('description'),
            'link' => $request->input('link')

        ];


        $validator = Validator::make($data, [
            'title' => 'required',
            'profiles_id' => 'required',
            'name' => 'required',
            'date' => 'required',
            'description' => 'required',
            'link' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validated();
        $certificate = Certificate::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $certificate
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $profile = $user->profile->first();
        if ($certificate->profiles_id == $profile->id) {
            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => [
                    'title' => $certificate->title,
                    'name' => $certificate->name,
                    'date' => $certificate->date,
                    'link' => $certificate->link,
                ],
            ]);
        }else{

        }


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        $data = [
            'description' => $request->description,
            'date' => $request->date,
            'name' => $request->name,
            'title' => $request->title,
            'link' => $request->link
        ];


        $certificate->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Award me updated successfully',
            'data' => $certificate,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return response()->json([
            'success' => true,
            'message' => 'Certificate me deleted successfully',
        ]);
    }
}
