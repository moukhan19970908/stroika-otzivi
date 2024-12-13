<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\NearPostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createPost(CreatePostRequest $request, PostService $postService)
    {
        try {
            $post = $postService->createPost($request->user(), $request->all());
            return response()->json(['success' => true, 'data' => $post], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getPosts(Request $request, PostService $postService)
    {
        try {
            $posts = $postService->getPosts();
            return response()->json(['success' => true, 'data' => $posts], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getNearestPosts(NearPostRequest $request, PostService $postService)
    {
        try {
            $posts = $postService->getNearestPosts($request->latitude, $request->longitude);
            return response()->json(['success' => true, 'data' => $posts], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function topPosts(Request $request)
    {
        return response()->json(['success' => true, 'data' => Post::withCount('rieltorComments')->with('user', 'getFirstImage')
            ->orderBy('rieltor_comments_count', 'desc')
            ->paginate(20)]);
    }

    public function getPostById($id)
    {
        return Post::with(['images', 'user', 'masterComments.user', 'rieltorComments.user'])->find($id);
    }

}
