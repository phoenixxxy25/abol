<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['message', 'author', 'post_id'];
    protected $table = 'post_extras';
}
