<?php

namespace App\Http\Controllers\Api\Resume;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfilesResource;
use App\Models\profiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class profilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
//    public function index()
//    {
//        $profiles = profiles::all();
//
//        return response()->json([
//            'success'   => true,
//            'message'   => "success",
//            "data" => $profiles
//        ]);
//    }

    public function index(){
        $users = profiles::with(["educations", "skills", "projects.stacks"])->get();
        $userData = $users->map(function ($user) {
            return [
                'title' => $user->title,
                'data' => [
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'date_of_birth' => $user->date_of_birth,
                    'gender' => $user->gender,
                    'address' => $user->address,
                    'portfolio_url' => $user->portfolio_url,
                    'github_url' => $user->github_url,

                    'skills' => $user->skills->pluck('name')->toArray(),
                    'experiences' => $user->experiences->map(function ($experience) {
                        return [
                            'title' => $experience->title,
                            'company' => $experience->company,
                            'description' => $experience->description,
                            'stat_date' => $experience->stat_date,
                            'end_date' => $experience->end_date,
                            'description' => $experience->description,
                            'projects' => $experience->projects
                        ];
                    }),
                    'projects' => $user->projects->map(function ($project) {
                        return [
                            'name' => $project->name,
                            'url' => $project->url,
                            'description' => $project->description,
                            'repository' => $project->repository,
                            'stacks' => $project->stacks->pluck('name')->toArray(),
                        ];
                    }),
                ]
            ];
        });

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $userData
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $data = [
           'users_id' => Auth::user()->getAuthIdentifier(),
           'name' => $request->name,
           'title' => $request->title,
           'phone' => $request->phone,
           'email' => Auth::user()->email,
           'date_of_birth' => $request->date_of_birth,
           'gender' => $request->true ? '1' : '0',
           'address' => $request->address,
           'portfolio_url' => $request->portfolio_url,
           'github_url' => $request->github_url,
           'linkedin_url' => $request->linkedin_url,
       ];

       $profiles = profiles::create($data);
       return new ProfilesResource($profiles);
    }

    /**
     * Display the specified resource.
     */
    public function show(profiles $profiles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, profiles $profiles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(profiles $profiles)
    {
        //
    }
}
