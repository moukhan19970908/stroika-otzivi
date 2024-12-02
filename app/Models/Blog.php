<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Orchid\Screen\AsSource;

class Blog extends Model
{
    use HasApiTokens,AsSource;
    protected $fillable = ['title', 'body','image'];

    public function comments(): HasMany{
        return $this->hasMany(BlogComment::class,'blog_id','id');
    }
}
