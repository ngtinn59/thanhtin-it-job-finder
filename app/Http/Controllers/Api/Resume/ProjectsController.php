<?php

namespace App\Http\Controllers\Api\Resume;

use App\Models\Certificate;
use App\Models\experiences;
use App\Models\Profile;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Models\projects;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where("id", auth()->user()->id)->firstOrFail();
        $profiles = profile::where("users_id", $user->id)->firstOrFail();
        $project = Project::where("profiles_id", $profiles->id)->get();
        $projectData = $project->map(function ($project) {
            return [
                'title' => $project->title,
                'start_date' => $project->start_date,
                'end_date' => $project->end_date,
                'description' => $project->description,
            ];
        });

        // Trả về danh sách giáo dục dưới dạng JSON
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $projectData,
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
            'title' => $request->input('title'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'description' => $request->input('description'),
            'profiles_id' => $profiles_id
        ];

        $validator = Validator::make($data, [
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
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
        $projects = project::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $projects,
            'status_code' => 200
        ]);

    }

    /**
     * Display the specified resource.
     */
    /**
     * Display the specified resource.
     */
    public function show(Request $request, Project $project)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $profile = $user->profile->first();

        if ($project->profiles_id == $profile->id) {
            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $project,
                'status_code' => 200
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
    public function update(Request $request, Project $project)
    {
        $data = $request->all();

        $project->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully',
            'data' => $project,
            'status_code' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully',
            'status_code' => 200
        ]);
    }
}
