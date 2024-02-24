<?php

namespace App\Http\Controllers\Api\Resume;

use App\Http\Controllers\Controller;
use App\Models\educations;
use App\Models\profiles;
use App\Models\User;
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
        $profiles = profiles::where("users_id", $user->id)->firstOrFail();
        $educations = educations::where("profiles_id", $profiles->id)->get();

        $educationsData = $educations->map(function ($education) {
            return [
                'id' => $education->id,
                'shcool_name' => $education->shcool_name,
                'degree' => $education->degree,
                'date_range' => $education->date_range,
                'details' => $education->details,
                'studying' => $education->studying,
            ];
        });

        // Trả về danh sách giáo dục dưới dạng JSON
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $educationsData
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'shcool_name' => $request->input('shcool_name'),
            'degree' => $request->input('degree'),
            'start-date' => $request->input('start-date'),
            'end-date' => $request->input('end-date'),
            'details' => $request->input('details'),
            'studying' => $request->studying ? 1 : 0,
            'profiles_id' => $request->input('profiles_id')
        ];

        $validator = Validator::make($data, [
            'shcool_name' => 'required',
            'degree' => 'required',
            'start-date' => 'required',
            'end-date' => 'required',
            'studying' => 'required',
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
            "data" => $education
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(educations $education)
    {

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, educations $education)
    {
        $data = [
            'shcool_name' => $request->input('shcool_name'),
            'degree' => $request->input('degree'),
            'start-date' => $request->input('start-date'),
            'end-date' => $request->input('end-date'),
            'details' => $request->input('details'),
            'studying' => $request->studying ? 1 : 0,
            'profiles_id' => $request->input('profiles_id')
        ];

        $validator = Validator::make($data, [
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validated();

        $education->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Education updated successfully',
            'data' => $education,
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
            'message' => 'Education deleted successfully'
        ]);
    }
}
