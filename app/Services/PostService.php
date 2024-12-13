<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PostService
{

    public function createPost(User $user, array $data)
    {
        DB::beginTransaction();
        $post = Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $user->id,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'status' => 'published',
            'address' => $data['address'],
            'rating' => 5,
        ]);
        if (!$post) {
            DB::rollBack();
            throw new \Exception('Попробуйте повторить попытку позже1.');
        }
        /*$ids = '(' . implode(',', $data['gallery']) . ')';
        print_r($ids);*/
        $update = PostImage::whereIn('id', $data['gallery'])->update(['post_id' => $post->id]);
        if (!$update) {
            DB::rollBack();
            throw new \Exception('Попробуйте повторить попытку позже2.');
        }
        DB::commit();
        return $post;
    }

    public function getPosts()
    {
        return Post::with('getFirstImage')->paginate(20);
    }

    public function getNearestPosts($latitude, $longitude, $radius = 200, $perPage = 20, $currentPage = 1)
    {
        $posts = Post::select('*')
            ->selectRaw(
                '(6371 * ACOS(
            COS(RADIANS(?)) * COS(RADIANS(latitude)) *
            COS(RADIANS(longitude) - RADIANS(?)) +
            SIN(RADIANS(?)) * SIN(RADIANS(latitude))
        )) AS distance',
                [$latitude, $longitude, $latitude]
            )
            ->with(['getFirstImage','user'])
            ->orderBy('distance', 'asc')// Сортировка по расстоянию
            ->paginate(20);
        return $posts;
    }
}
