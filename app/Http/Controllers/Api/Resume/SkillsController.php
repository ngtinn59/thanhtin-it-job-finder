<?php

namespace App\Http\Controllers\Api\Resume;

use App\Models\profiles;
use App\Models\Project;
use App\Models\projects;
use App\Models\Skill;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where("id", auth()->user()->id)->firstOrFail();
        $profiles = profiles::where("users_id", $user->id)->firstOrFail();
        $skill = Skill::where("profiles_id", $profiles->id)->get();
        $skillData = $skill->map(function ($skill) {
            return [
                'id' => $skill->id,
                'name' => $skill->name,
                'level' => $skill->level,
            ];
        });

        // Trả về danh sách giáo dục dưới dạng JSON
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $skillData
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $profile = $user->profiles->first();
        $profiles_id = $profile->id;
        $data = [
            'name' => $request->input('name'),
            'level' => $request->input('level'),
            'profiles_id' => $profiles_id
        ];

        $validator = Validator::make($data, [
            'name' => 'required',
            'level' => 'required',
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
        $skill = Skill::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $skill
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $profile = $user->profiles->first();

        if ($skill->profiles_id == $profile->id) {
            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $skill
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'fail'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $data = $request->all();

        $skill->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully',
            'data' => $skill,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully',
        ]);
    }
}
