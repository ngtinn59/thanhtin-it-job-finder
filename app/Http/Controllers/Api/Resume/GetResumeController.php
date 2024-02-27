<?php

namespace App\Http\Controllers\Api\Resume;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GetResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where("id", auth()->user()->id)->firstOrFail();
        $profile = profile::where("users_id", $user->id)->get();
        $profilesData = $profile->map(function ($profile) {
            return [
                'title' => $profile->title,
                'name' => $profile->name,
                'phone' => $profile->phone,
                'email' => $profile->email,
                'date_of_birth' => $profile->date_of_birth,
                'gender' => $profile->gender,
                'address' => $profile->address,
                'portfolio_url' => $profile->portfolio_url,
                'github_url' => $profile->github_url,
                'linkedin_url' => $profile->linkedin_url,
                'educations' => $profile->educations->map(function ($education) {
                    return [
                        'shcool_name' => $education->shcool_name,
                        'degree' => $education->degree,
                        'start_date' => $education->start_date,
                        'end_date' => $education->end_date,
                        'studying' => $education->studying,
                        'details' => $education->details,
                    ];
                }),
                'skills' => $profile->skills->map(function ($skill) {
                    $levelString = '';
                    switch ($skill->level) {
                        case 1:
                            $levelString = 'Beginner';
                            break;
                        case 2:
                            $levelString = 'Intermediate';
                            break;
                        case 3:
                            $levelString = 'Excellent';
                            break;
                        default:
                            $levelString = 'Unknown';
                            break;
                    }

                    return [
                        'name' => $skill->name,
                        'level' => $levelString,
                    ];
                }),
                'projects' => $profile->projects->map(function ($project) {
                    return [
                        'name' => $project->name,
                        'start_date' => $project->start_date,
                        'end_date' => $project->end_date,
                        'url' => $project->url,
                        'description' => $project->description,
                        'repository' => $project->repository,
                    ];
                }),
                'Certificates' => $profile->certificates->map(function ($certificates) {
                    return [
                        'name' => $certificates->name,
                        'title' => $certificates->title,
                        'date' => $certificates->date,
                        'link' => $certificates->link,
                        'description' => $certificates->description,

                    ];
                }),
                'experiences' => $profile->experiences->map(function ($experience) {
                    return [
                        'title' => $experience->title,
                        'company' => $experience->company,
                        'start_date' => $experience->start_date,
                        'end_date' => $experience->end_date,
                        'description' => $experience->description,
                        'projects' => $experience->projects,
                    ];
                }),
                'Awards' => $profile->awards->map(function ($awards) {
                    return [
                        'title' => $awards->title,
                        'name' => $awards->name,
                        'date' => $awards->date,
                        'link' => $awards->link,
                        'description' => $awards->description,
                    ];
                }),
            ];
        });
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $profilesData
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
