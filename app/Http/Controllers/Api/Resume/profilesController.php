<?php

namespace App\Http\Controllers\Api\Resume;

use App\Http\Controllers\Controller;
use App\Models\profiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $users = profiles::with("educations")
            ->with("skills")
            ->with(["experiences" => function ($query) {
                $query->with("responsibilities");
            }])
            ->with(["projects" => function ($query) {
                $query->with("stacks");
            }])
            ->get();
        $userData = $users->map(function ($user) {
            return [
                'name' => $user->name,
                'title' => $user->title,
                'about' => $user->about,
                'phone' => $user->phone,
                'email' => $user->email,
                'education' => $user->education,
                'skills' => $user->skills->pluck('name')->toArray(),
                'experiences' => $user->experiences->map(function ($experience) {
                    return [
                        'title' => $experience->title,
                        'company' => $experience->company,
                        'date-range' => $experience->date_range,
                        'responsibilities' => $experience->responsibilities->pluck('details')->toArray(),
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
           'about' => $request->about,
           'phone' => $request->phone,
           'email' => Auth::user()->email,
           'portfolio_url' => $request->portfolio_url,
           'github_url' => $request->github_url,
           'linkedin_url' => $request->linkedin_url,
       ];

       $profiles = profiles::create($data);
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
        $data = [
            'id' => $profiles->id,
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

        $profiles->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Education updated successfully',
            'data' => $profiles,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(profiles $profiles)
    {
        $profiles->delete();

    }
}
