<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RieltorComment extends Model
{
    protected $table = 'rieltor_comments';
    protected $fillable = [
        'advantage',
        'disadvantage',
        'rating',
        'user_id',
        'post_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
