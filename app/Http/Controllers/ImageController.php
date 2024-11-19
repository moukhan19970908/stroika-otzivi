<?php

namespace App\Http\Controllers;

use App\Models\PostImage;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $folder = date('d.m.Y');
        $path = $request->file->store($folder . '/posts', 'public');
        $image = PostImage::create(['image_path' => env('APP_URL').'/storage/'.$path]);
        return response()->json(['success' => true, 'image_id' => $image->id], 200);
    }

    public function uploadComment(Request $request)
    {
        $folder = date('d.m.Y');
        $path = $request->file->store($folder . '/posts/comments', 'public');
        $image = PostImage::create(['image_path' => env('APP_URL').'/storage/'.$path]);
        return response()->json(['success' => true, 'image_id' => $image->id], 200);
    }
}
