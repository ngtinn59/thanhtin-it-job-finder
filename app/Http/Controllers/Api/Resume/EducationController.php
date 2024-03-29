<?php

namespace App\Http\Controllers\Api\Resume;

use App\Http\Controllers\Controller;
use App\Models\educations;
use App\Models\profile;
use App\Models\User;
use App\Utillities\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where("id", auth()->user()->id)->firstOrFail();
        $profiles = profile::where("users_id", $user->id)->firstOrFail();
        $educations = educations::where("profiles_id", $profiles->id)->get();

        $educationsData = $educations->map(function ($education) {
            return [
                'id' => $education->id,
                'degree' => $education->degree,
                'institution' => $education->institution,
                'start_date' => $education->start_date,
                'end_date' => $education->end_date,
                'additionalDetail' => $education->additionalDetail,
            ];
        });

        // Trả về danh sách giáo dục dưới dạng JSON
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $educationsData,
            'status_code' => 200
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $profile = $user->profile->first();
        $profiles_id = $profile->id;
        $data = [
            'degree' => $request->input('degree'),
            'institution' => $request->input('institution'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'additionalDetail' => $request->input('additionalDetail'),
            'profiles_id' => $profiles_id
        ];

        $validator = Validator::make($data, [
            'degree' => 'required',
            'institution' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|date|after:start_date',
            'additionalDetail' => 'required',
            'profiles_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validated();
        $education = educations::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $education,
            'status_code' => 200
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(educations $education)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $profile = $user->profile->first();
        if ($education->profiles_id !== $profile->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to the award',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => [
                'id' => $education->id,
                'degree' => $education->degree,
                'institution' => $education->institution,
                'start_date' => $education->start_date,
                'end_date' => $education->end_date,
                'additionalDetail' => $education->additionalDetail,
            ],
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, educations $education)
    {
        $data = $request->all();
        $education->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Education updated successfully',
            'data' => $education,
            'status_code' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(educations $education)
    {
        if (!$education) {
            return response()->json([
                'success' => false,
                'message' => 'Education not found'
            ], 404);
        }

        $education->delete();

        return response()->json([
            'success' => true,
            'message' => 'Education deleted successfully',
            'status_code' => 200
        ]);
    }
}
