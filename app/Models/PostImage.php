<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{

    protected $fillable = ['filename', 'post_id'];
    protected $table = 'post_images';
}

