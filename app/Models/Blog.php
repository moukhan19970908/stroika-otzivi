<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Orchid\Screen\AsSource;

class Blog extends Model
{
    use HasApiTokens,AsSource;
    protected $fillable = ['title', 'body','image'];
}
