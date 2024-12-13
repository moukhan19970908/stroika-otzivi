<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id','fio','avatar');
    }

    public function images(){
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    public function masterComments(): HasMany{
        return $this->hasMany(MasterComment::class, 'post_id', 'id');
    }

    public function rieltorComments(): HasMany{
        return $this->hasMany(RieltorComment::class, 'post_id', 'id');
    }
}
