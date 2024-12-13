<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogAddCommentRequest;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function getBlogs(){
        return Blog::select('id','title','image',DB::raw('SUBSTRING(body,1,50) AS body'),'created_at')->paginate(15)->through(function($blog){
            return $blog;
        });
    }

    public function getBlogById($id){
        $blog =  Blog::with(['comments.user'])->where('id', $id)->first();
        return $blog;
    }

    public function addComment(BlogAddCommentRequest $request){
        try{
            $blog = BlogComment::create([
                'text' => $request->text,
                'blog_id' => $request->blog_id,
                'user_id' => auth()->user()->id,
            ]);
            return response()->json(['success' => true, 'data' => $blog], 200);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
