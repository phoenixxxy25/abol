<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $fillable = ['title'];
    protected $table = 'tags';
}
