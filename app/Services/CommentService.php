<?php

namespace App\Services;

use App\Models\MasterComment;
use App\Models\PostImage;
use App\Models\RieltorComment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentService
{
    public function addCommentRieltor(User $user, $commentData)
    {
        DB::beginTransaction();
        $commentID = RieltorComment::create([
            'user_id' => $user->id,
            'advantage' => $commentData['advantage'],
            'disadvantage' => $commentData['disadvantage'],
            'rating' => $commentData['rating'],
            'post_id' => $commentData['post_id'],
        ]);
        if (!$commentID) {
            throw new \Exception('Попробуйте повторить попытку позже.');
        }
        $update = PostImage::whereIn('id', $commentData['gallery'])
            ->update([
                'type' => 'rieltor',
                'post_id' => $commentData['post_id']
            ]);
        if (!$update) {
            throw new \Exception('Попробуйте повторить попытку позже.');
        }
        DB::commit();
        return true;
    }

    public function addCommentMaster(User $user, $commentData)
    {
        DB::beginTransaction();
        $commentID = MasterComment::create([
            'user_id' => $user->id,
            'role' => $commentData['role'],
            'type_work' => $commentData['type_work'],
            'name_client' => $commentData['name_client'],
            'phone_client' => $commentData['phone_client'],
            'experience' => $commentData['experience'],
            'recommendations' => $commentData['recommendations'],
            'emotion_rating' => $commentData['emotion_rating'],
            'payment_rating' => $commentData['payment_rating'],
            'quality_rating' => $commentData['quality_rating'],
            'delivery_rating' => $commentData['delivery_rating'],
            'honesty_rating' => $commentData['honesty_rating'],
            'post_id' => $commentData['post_id'],
        ]);
        if (!$commentID) {
            throw new \Exception('Попробуйте повторить попытку позже.');
        }
        $update = PostImage::whereIn('id', $commentData['gallery'])
            ->update([
                'type' => 'master',
                'post_id' => $commentData['post_id']
            ]);
        if (!$update) {
            throw new \Exception('Попробуйте повторить попытку позже.');
        }
        DB::commit();
        return true;
    }
}
