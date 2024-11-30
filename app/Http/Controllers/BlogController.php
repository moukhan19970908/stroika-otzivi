<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function getBlogs(){
        return Blog::select('id','title','image',DB::raw('SUBSTRING(body,1,50) AS body'),'created_at')->paginate(15)->through(function($blog){
            $blog->image = env('APP_URL').$blog->image;
            return $blog;
        });
    }

    public function getBlogById($id){
        $blog =  Blog::select('id','title','image','body','created_at')->where('id',$id)->first();
        $blog->image = env('APP_URL').$blog->image;
        return $blog;
    }
}
