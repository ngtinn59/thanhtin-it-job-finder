<?php

namespace App\Http\Controllers\Api\Resume;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = profile::with("skills")
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
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'portfolio_url' => $request->input('portfolio_url'),
            'github_url' => $request->input('github_url'),
            'linkedin_url' => $request->input('linkedin_url'),
            'users_id' => auth()->user()->id
        ];

        $validator = Validator::make($data, [
            'name' => 'required',
            'title' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'portfolio_url' => 'required',
            'github_url' => 'required',
            'linkedin_url' => 'required',
            'users_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validated();
        $profile = Profile::create($data);
        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $profile
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {

            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $profile
            ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {

        $data = [
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'portfolio_url' => $request->input('portfolio_url'),
            'github_url' => $request->input('github_url'),
            'linkedin_url' => $request->input('linkedin_url'),
        ];

        $profile->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile me updated successfully',
            'data' => $profile,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {

        $profile->delete();
        return response()->json([
            'success' => true,
            'message' => 'Profile me deleted successfully',
        ]);
    }
}
