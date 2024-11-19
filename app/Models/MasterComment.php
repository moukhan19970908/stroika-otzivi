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
}
