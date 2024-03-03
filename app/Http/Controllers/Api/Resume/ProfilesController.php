<?php

namespace App\Http\Controllers\Api\Resume;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Models\Skill;
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
        $profile = profile::where("users_id", $user->id)->get();
        $profilesData = $profile->map(function ($profile) {
            return [
                'title' => $profile->title,
                'name' => $profile->name,
                'phone' => $profile->phone,
                'email' => $profile->email,
                'birthday' => $profile->birthday,
                'image' => $profile->image,
                'gender' => $profile->gender == 1 ? 'Male' : 'Female',
                'location' => $profile->location,
                'website' => $profile->website,
            ];
        });

        // Trả về danh sách giáo dục dưới dạng JSON
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'title' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'birthday' => 'required',
            'gender' => 'required',
            'location' => 'required',
            'website' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra tập tin ảnh
//            'users_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $file = $request->file('image'); // Lấy đối tượng tập tin ảnh từ request
        $path = public_path('uploads/images'); // Đường dẫn lưu trữ tập tin ảnh
        $file_name = Common::uploadFile($file, $path); // Gọi phương thức uploadFile từ class Common để tải lên tập tin ảnh

        // Tạo dữ liệu mới với đường dẫn của tập tin ảnh
        $data = [
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'birthday' => $request->input('birthday'),
            'gender' => $request->input('gender'),
            'location' => $request->input('location'),
            'website' => $request->input('website'),
            'image' => $file_name, // Đường dẫn của tập tin ảnh
            'users_id' => auth()->user()->id,
        ];
        // Tạo profile mới trong cơ sở dữ liệu
        $profile = Profile::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            'data' => $profile->toArray()
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
            'image' => $request->input('image'),
            'birthday' => $request->input('birthday'),
            'gender' => $request->input('gender'),
            'location' => $request->input('location'),
            'website' => $request->input('website'),
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
