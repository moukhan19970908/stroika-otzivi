<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterComment extends Model
{
    protected $fillable = [
        'role',
        'type_work',
        'name_client',
        'phone_client',
        'experience',
        'recommendations',
        'emotion_rating',
        'payment_rating',
        'quality_rating',
        'delivery_rating',
        'honesty_rating',
        'post_id',
        'user_id',
    ];

    public function post(){
        return $this->hasOne(Post::class,'id','post_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
