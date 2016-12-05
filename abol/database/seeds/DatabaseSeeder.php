<?php

use Illuminate\Database\Seeder;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call('PostsSeeder');
    }
}

class PostsSeeder extends Seeder {
	public function run()
	{
		DB::table('posts')->delete();
		Post::create([
			'title' => 'First',
			'slug'  => 'First_slug',
			'excerpt' => '<b>First</b> excerpt',
			'content' => '<b>First</b> content',
			'author' => 'First author',
			'publ_at' => DB::raw('CURRENT_TIMESTAMP'),
			'published' => true
		]);

		Post::create([
			'title' => 'Second',
			'slug'  => 'Second_slug',
			'excerpt' => '<b>Second</b> excerpt',
			'content' => '<b>Second</b> content',
			'author' => 'Second author',
			'publ_at' => DB::raw('CURRENT_TIMESTAMP'),
			'published' => false
		]);

		Post::create([
			'title' => 'Third',
			'slug'  => 'Third_slug',
			'excerpt' => '<b>Third</b> excerpt',
			'content' => '<b>Third</b> content',
			'author' => 'Third author',
			'publ_at' => DB::raw('CURRENT_TIMESTAMP'),
			'published' => true
		]);


	}
}
