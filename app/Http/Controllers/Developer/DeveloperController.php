<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\profiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Profiler\Profile;

class DeveloperController extends Controller
{
    public function Profiles(Request $request)
    {
        $profile = Profiles::create([
            'users_id' => Auth::user()->getAuthIdentifier(),
            'slug_title' => 'example-slug',
            'title' => 'Example Title',
            'image_url' => 'example.jpg',
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'gender' => true,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'introduction' => $request->introduction,
        ]);

        $education = $profile->educations()->create([
            'profiles_id' => $request->profiles_id,
            'universities_id' => $request->universities_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_graduate' => true,
            'major' => $request->major,
            'grade' => $request->grade,
        ]);

        $experience = $profile->experiences()->create([
            'profiles_id' =>  $request->profiles_id,
            'skills_id' =>  $request->skills_id,
            'introduce' =>  $request->introduce,
            'companies_id' =>  $request->companies_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        $projects = $profile->projects()->create([
            'profiles_id' =>  $request->profiles_id,
            'slug_title' =>  $request->slug_title,
            'project_name' =>  $request->project_name,
            'project_date' => $request->project_date,
            'description' => $request->description
        ]);


        return response()->json(['message' => 'Profile created successfully'],201);

    }
    public function me(Request $request)
    {
        $id = Auth::user()->getAuthIdentifier();
        // Lấy thông tin hồ sơ cùng với giáo dục và dự án
        $profiles = profiles::with(['educations', 'projects'])->find($id);



        // Trả về thông tin
        return response()->json(['profiles' => $profiles]);
    }


}
