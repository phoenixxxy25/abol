<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = ['title', 'excerpt', 'content', 'author'];
    protected $table = 'posts';

    public function getPublishedPosts()
    {
    	//$posts = Post::latest('publ_at')->where('publ_at', '<=', Carbon::now())->get();
    	
    	$posts = $this->latest('id')->get();
    	return $posts;
    }
}
