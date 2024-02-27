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
        $profiles = profiles::where("users_id", $user->id)->firstOrFail();
        $project = Project::where("profiles_id", $profiles->id)->get();
        $projectData = $project->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'start_date' => $project->start_date,
                'end_date' => $project->end_date,
                'url' => $project->url,
                'description' => $project->description,
                'repository' => $project->repository,
            ];
        });

        // Trả về danh sách giáo dục dưới dạng JSON
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $projectData
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
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'url' => $request->input('url'),
            'description' => $request->input('description'),
            'repository' => $request->input('repository'),
            'profiles_id' => $profiles_id
        ];

        $validator = Validator::make($data, [
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
            'url' => 'required',
            'repository' => 'required',
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
        $projects = projects::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $projects
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
        $profile = $user->profiles->first();
        if ($project->profiles_id == $profile->id) {
            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $project
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
        ]);
    }
}
