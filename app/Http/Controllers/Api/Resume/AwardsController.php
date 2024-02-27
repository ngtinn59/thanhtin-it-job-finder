<?php

namespace App\Http\Controllers\Api\Resume;

use App\Models\Award;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\educations;
use App\Models\profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AwardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where("id", auth()->user()->id)->firstOrFail();
        $profiles = profile::where("users_id", $user->id)->firstOrFail();
        $awards = Award::where("profiles_id", $profiles->id)->get();

        $awardsData = $awards->map(function ($awards) {
            return [
                'id' => $awards->id,
                'title' => $awards->title,
                'name' => $awards->name,
                'date' => $awards->date,
                'description' => $awards->description,

            ];
        });

        // Trả về danh sách giáo dục dưới dạng JSON
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $awardsData
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $profile = $user->profiles->first();
        $profiles = $profile->id;

        $data = [
            'title' => $request->input('title'),
            'profiles_id' =>$profiles,
            'name' => $request->input('name'),
            'date' => $request->input('date'),
            'description' => $request->input('description')
        ];


        $validator = Validator::make($data, [
            'title' => 'required',
            'profiles_id' => 'required',
            'name' => 'required',
            'date' => 'required',
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
        $Award = Award::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $Award
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Award $award)
    {
        // Check if the award belongs to the authenticated user
        $user = User::where("id", auth()->user()->id)->first();
        $profile = $user->profiles->first();
        if ($award->profiles_id !== $profile->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to the award',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => [
                'title' => $award->title,
                'name' => $award->name,
                'date' => $award->date,
                'description' => $award->description,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Award $award)
    {
        $data = [
            'description' => $request->description,
            'date' => $request->date,
            'name' => $request->name,
            'title' => $request->title,
        ];


        $award->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Award me updated successfully',
            'data' => $award,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Award $award)
    {
        $award->delete();
        return response()->json([
            'success' => true,
            'message' => 'Award me deleted successfully',
        ]);

    }
}
