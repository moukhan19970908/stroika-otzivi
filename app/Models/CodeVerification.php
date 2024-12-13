<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodeVerification extends Model
{
    protected $table = 'code_verification';
    protected $fillable = [
        'phone',
        'code'
    ];
}
