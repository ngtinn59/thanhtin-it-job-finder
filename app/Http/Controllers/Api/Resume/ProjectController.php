<?php

namespace App\Http\Controllers\Api\Resume;

use App\Http\Controllers\Controller;
use App\Models\aboutme;
use App\Models\profiles;
use App\Models\projects;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where("id", auth()->user()->id)->firstOrFail();
        $profiles = profiles::where("users_id", $user->id)->firstOrFail();
        $projects = projects::where("profiles_id", $profiles->id)->get();
        $projectsdata = $projects->map(function ($projects) {
            return [
                'name' => $projects->name,
                'description' => $projects->description,
                'url' => $projects->url,
                'repository' => $projects->repository,
                'stacks' => $projects->stacks->pluck('name')->toArray(),

            ];
        });

        // Trả về danh sách giáo dục dưới dạng JSON
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $projectsdata
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'url' => 'required',
            'description' => 'required',
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

        $input = $validator->validated();
        $projects = Projects::create($input);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $projects
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(projects $projects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, projects $projects)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(projects $projects)
    {
        //
    }
}
