<?php

namespace App\Http\Controllers\Api\Resume;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utillities\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where("id", auth()->user()->id)->firstOrFail();
        $profile = Profile::where("users_id", $user->id)->get();
        $profilesData = $profile->map(function ($profile) {
            return [
                'title' => $profile->title,
                'name' => $profile->name,
                'phone' => $profile->phone,
                'email' => $profile->email,
                'birthday' => $profile->birthday,
                'image_url' => url('uploads/images/' . $profile->image), // Xây dựng URL của hình ảnh
                'gender' => $profile->gender == 1 ? 'Male' : 'Female',
                'location' => $profile->location,
                'website' => $profile->website,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $profilesData,
            'status_code' => 200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $profile = Profile::where('users_id', auth()->user()->id)->first();

        // Only perform validation if we're creating a new profile
        if (!$profile) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'birthday' => 'required',
                'location' => 'required',
                'website' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 400);
            }

            $file = $request->file('image');
            $path = public_path('uploads/images');
            $file_name = Common::uploadFile($file, $path);

            $data = [
                'name' => $request->input('name'),
                'title' => $request->input('title'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'birthday' => $request->input('birthday'),
                'gender' => $request->input('gender'),
                'location' => $request->input('location'),
                'website' => $request->input('website'),
                'image' => $file_name,
                'users_id' => auth()->user()->id,
            ];
        } else {
            // If updating, we assume the request only contains fields to be updated
            $data = $request->all();

            // Optionally handle image file if it's in the request
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = public_path('uploads/images');
                $data['image'] = Common::uploadFile($file, $path);
            }
        }

        // Use updateOrCreate to either update the existing profile or create a new one
        $profile = Profile::updateOrCreate(
            ['users_id' => auth()->user()->id],
            $data
        );

        return response()->json([
            'success' => true,
            'message' => "Profile saved successfully",
            'data' => $profile->toArray(),
            'status_code' => 200
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
                'data' => $profile,
                'status_code' => 200
            ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        $data = $request->all();
        $profile->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile me updated successfully',
            'data' => $profile,
            'status_code' => 200
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
            'status_code' => 200
        ]);
    }
}
