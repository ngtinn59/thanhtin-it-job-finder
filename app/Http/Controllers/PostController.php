<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostServiceInterface;
use App\Services\ProductCategory\ProductCategoryService;
use Illuminate\Http\Request;
class PostController extends Controller
{
    private $postService;

    public function __construct(ProductCategoryService $postService) {
        $this->postService = $postService;
    }
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    public function show($id)
    {
        $post = Post::find($id);
        return response()->json($post);
    }

    public function store(Request $request)
    {
        $data = $request->all();
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
