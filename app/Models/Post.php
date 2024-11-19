<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'latitude',
        'longitude',
        'address',
        'status',
        'description',
        'user_id',
        'rating'
    ];

    public function getFirstImage(){
        return $this->hasOne(PostImage::class, 'post_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function images(){
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }
}
