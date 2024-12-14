<?php

namespace App\Services;

use App\Models\MasterComment;
use App\Models\Post;
use App\Models\User;
use Exception;

class GuestService
{
    public function getProfileById($id)
    {
        $user = User::find($id);
        if ($user->user_type_id == 3) {
            $posts = Post::where('user_id', $user->id)->pluck('id')->toArray();
            return [
                'user' => $user,
                'comment_count' => MasterComment::whereIn('post_id', $posts)->count(),
                'emotion_rating' => MasterComment::avg('emotion_rating'),
                'payment_rating' => MasterComment::avg('payment_rating'),
                'quality_rating' => MasterComment::avg('quality_rating'),
                'delivery_rating' => MasterComment::avg('delivery_rating'),
                'honesty_rating' => MasterComment::avg('honesty_rating'),
            ];
        }
        return [
            'user' => $user,
        ];
    }

    public function getUserComments($id){
        $user = User::find($id);
        if ($user->user_type_id != 3) {
            throw new Exception('Нету комментов');
        }
        $posts = Post::where('user_id', $user->id)->pluck('id')->toArray();
        if (!$posts){
            throw new Exception('Нету комментов');
        }
        return MasterComment::whereIn('post_id', $posts)->with('post')->get();
    }
}
