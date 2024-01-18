<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;

use App\Models\recruitments;

use App\Services\Recruitments\RecruitmentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $postService;

    public function __construct(RecruitmentsService $postService) {
        $this->postService = $postService;
    }
    public function index()
    {
        // Lấy thông tin người dùng đang đăng nhập
        $data = $this->postService->all();

        // Chỉ trả về thông tin của người dùng đang đăng nhập
        return response()->json($data);
    }

    public function show($id)
    {
        $post = Post::find($id);
        return response()->json($post);
    }

    public function store(Request $request)
    {
        $data = [
            'users_id' => Auth::user()->getAuthIdentifier(),
            'companies_id' => $request->companies_id,
            'title' => $request->title,
            'slug_title' => $request->slug_title,
            'position' => $request->position,
            'form_of_work' => $request->position,
            'experience_level' => $request->position,
            'skills_required' => $request->skills_required,
            'experience_details' => $request->experience_details,
            'quantity' => $request->quantity,
            'min_salary' => $request->min_salary,
            'max_salary' => $request->max_salary,
            'expiration_date' => $request->expiration_date,
            'address_work' => $request->address_work,
            'job_description' => $request->job_description,
            'job_requirements' => $request->job_requirements,
            'benefits' => $request->benefits,
            'recruitment_status' => $request->recruitment_status,
        ];

        $this->postService->create($data);
        return response()->json(['message' => 'Successs.'], 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'The article does not exist..'], 404);
        }

        $post->update($request->all());
        return response()->json(['message' => 'Bài viết đã được cập nhật thành công.'], 200);
    }

    public function destroy($id)
    {
        $this->postService->delete($id);

        $this->postService->delete($id);
        return response()->json(['message' => 'Bài viết đã được xóa thành công.'], 204);
    }

}
