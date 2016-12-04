<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Input;
use View;
use Redirect;
use Illuminate\Support\Facades\Auth;
use App\Quotation;
use Requests;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagConnections;
use App\Models\PostImage;
use App\Models\Comment;
use Storage;
use App\Models\User;
use Illuminate\Support\Facades\File;


class PostController extends Controller {

	public function index(Post $postM, Request $request)
	{
		$posts = $postM->getPublishedPosts();
		return view('post.index', ['posts' => $posts]);
	}



	public function create()
	{	

		$tags = Tag::All();
		if(count($tags) == 0) $tags = [ 0 => (object)['id' => 0, 'title' => 'Тегов нет!']];
		return view('post.create', ['tags' => $tags]);
	}



	public function store(Post $postModel, Request $request)
	{
		$this->validate($request, [
	        'title' => 'required|unique:posts|max:255',
	        'content' => 'required|max:1024',
    	]);

		$id = DB::table('posts')->insertGetId(
		    array(
		    	'content' => Input::get('content'),
		     	'author' => Auth::user()->login, 
		     	'excerpt' => Input::get('excerpt'),
		     	'title' => Input::get('title'),
		     	)
		);

		$tags = Tag::All();
		foreach ($tags as $key => $value) {
			if($request->get('t'.$value['original']['id']) == "on" ) TagConnections::create(array('tag_id' => $value['original']['id'], 'post_id' => $id));
		}
		
		$newtags = explode(',', $request->get('newtags'));
		if(count($newtags) > 1){
		 	foreach ($newtags as $key => $value) {
		 		$ntag = Tag::firstOrCreate(array('title' => trim($value)));
		 		TagConnections::create(array('tag_id' => $ntag['original']['id'], 'post_id' => $id));
		 	}
		}
		else {
	 		$ntag = Tag::firstOrCreate(array('title' => trim($newtags[0])));
	 		TagConnections::create(array('tag_id' => $ntag['original']['id'], 'post_id' => $id));
 		}

		$directory = 'post_images';
		$directories = Storage::directories($directory);
		
		if(!array_search($id, $directories)) Storage::makeDirectory($directory.'/'.$id);

        
		$fput_id = 1;
        if($request->hasFile('postfiles')){
	        foreach(Input::file("postfiles") as $file) {
	        	$putfilename = $fput_id.'.jpg';

				$image = new PostImage();
		        $image->filename = $putfilename;
		        $image->post_id = $id;
		        $image->save();

			    Storage::disk('local')->put($directory.'/'.$id.'/'.$putfilename, File::get($file));
			    $fput_id++;
			}
		}

		return redirect()->route('post');
	}

	public function storecomment(Request $request, $post)
	{	
		$id = $post;
		$comment = Input::get('mehmess');
		$name = Auth::user()->login;
		$cid = DB::table('post_extras')->insertGetId(
		    array(
		    	'message' => $comment,
		     	'author' => $name, 
		     	'post_id' => $id
		     	)
		);
      return response()->json(array('msg'=> $msg, 'comment'=> $comment, 'name'=> $name, 'cid' => $cid), 200);
    }



	public function show($id)
	{

		$comments = DB::select('select * from post_extras where post_id = :id order by id desc', ['id' => $id]);
		$files = PostImage::where('post_id', '=', $id)->get();
		$post=Post::find($id);
		return view('post.show',['post'=>$post, 'comments'=>$comments, 'images' => $files]);
	}
	public function edit($id)
	{
		$post = Post::find($id);
		$files = PostImage::where('post_id', '=', $id)->get();
        return View::make('post.edit')->with('post', $post)->with('files', $files)->with('err', "none");
	}

	public function update($id, Request $request)
	{	
		$this->validate($request, [
	        'title' => 'required|max:255',
	        'content' => 'required|max:1024',
    	]);

		$post = Post::find($id);
        $post->title     = Input::get('title');
        $post->excerpt   = Input::get('excerpt');
        $post->content   = Input::get('content');
        $post->author    = Input::get('author');

        $directory = 'post_images';
		$directories = Storage::directories($directory);
		if(!array_search($id, $directories)) Storage::makeDirectory($directory.'/'.$id);
		$countFilesInFolder = count(Storage::allFiles($directory.'/'.$id));

		$countUploadFiles = count(Input::file("postfiles"));
		$totalFls = $countFilesInFolder + $countUploadFiles;
		if( $totalFls > 10 ) {
			
			$files = PostImage::where('post_id', '=', $id)->get();

			$request->session()->set('edit_post_error', 'ОШИБКА! В папке поста больше 10 файлов!('.$totalFls.')');
	 		$request->session()->save();
			return Redirect::back()->with('post', $post)->with('files', $files);
		}

		$files = PostImage::where('post_id', '=', $id)->get();
		if($files){
		 	$arr = []; $arr_fls_id = 0;
		 	foreach ($files as $key => $file) {
		 		$arr[$arr_fls_id] = $file['original'];
		 		$arr_fls_id++;
		 	}
		}

	 	foreach ($arr as $key => $file) {
	 		$fileToDel = 'pic'.$file["id"];
	 		$path = 'post_images/'.$file["post_id"].'/'.$file["filename"];
	 		$size = Storage::size($path);
	 		if(Input::get($fileToDel) == '1' AND Storage::disk('local')->exists($path)){
				Storage::delete($path);
				DB::delete('DELETE FROM post_images WHERE id = :id', ['id' => $file["id"]]);
			}
	 	}

		$countFilesInFolder = count(Storage::allFiles($directory.'/'.$id));
		$fput_id = $countFilesInFolder+1;
        if($request->hasFile('postfiles')){
	        foreach(Input::file("postfiles") as $file) {
	        	$putfilename = $fput_id.'.jpg';

				$image = new PostImage();
		        $image->filename = $putfilename;
		        $image->post_id = $id;
		        $image->save();

			    Storage::disk('local')->put($directory.'/'.$id.'/'.$putfilename, File::get($file));
			    $fput_id++;
			}
		}

        $post->save();
        $comments = DB::select('select * from post_extras where post_id = :id order by id desc', ['id' => $id]);
		$files = PostImage::where('post_id', '=', $id)->get();

        return view('post.show',['post'=>$post, 'comments'=>$comments, 'images' => $files]);
	}

	public function updatecomment($post_id, $comment_id)
	{
		DB::table('post_extras')
            ->where('id', $comment_id)
            ->update(['message' => Input::get('mehmess')]);

		return response()->json(array('text'=> Input::get('mehmess')), 200);
	}


	public function destroy($id, Post $postM)
	{
		$post = Post::find($id);
        $post->delete();
		$posts = $postM->getPublishedPosts();
		return Redirect::to('post');
	}

	public function destroycomment($post_id, $comment_id)
	{
		DB::delete('DELETE FROM post_extras WHERE id = :id', ['id' => $comment_id]);
		return response()->json(array('cid'=> $comment_id), 200);

	}



}