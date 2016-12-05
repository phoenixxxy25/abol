<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::get('/', ['as' => 'post', 'uses' => 'PostController@index']);

Route::get('home', ['as' => 'home', 'uses' => 'HomeController@home']);
$router->resource('post', 'PostController');

//$router->resource('auth', 'Auth\AuthController');
/*Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->middleware('guest');

    Route::get('/tasks', 'TaskController@index');
    Route::post('/task', 'TaskController@store');
    Route::delete('/task/{task}', 'TaskController@destroy');

    Route::auth();

});*/

Route::auth();
Route::get('profile', ['as' => 'profile', 'uses' => 'HomeController@profile']);
Route::get('admin', ['as' => 'admin', 'uses' => 'HomeController@admin']);

Route::post('search', ['as' => 'search', 'uses' => 'HomeController@search']);
Route::get('search', ['as' => 'search', 'uses' => 'HomeController@search']);

//Route::post('post/{post}', ['as' => 'post.storecomment', 'uses' => 'PostController@storecomment']);

Route::post('post/{post}', function(){
	if(Request::ajax()){
		return 'TAKE UR REQUEST!';
	}
});
Route::post('admin/edit', function(){
    if(Request::ajax()){
        return 'TAKE UR REQUEST!';
    }
});

Route::get('profile/{id}/edit', 'HomeController@editprofileform');
Route::put('profile', 'HomeController@updateprofile');
Route::get('user/{user}', 'HomeController@user');


Route::post('admin/edit', 'HomeController@editusers');


Route::get('ajax',function(){
   return view('message');
});

Route::post('search/result', 'HomeController@getSearchResult');

Route::post('post/{post}','PostController@storecomment');
Route::post('post/{post_id}/{comment_id}', 'PostController@destroycomment');

Route::post('post/{post_id}/{comment_id}/edit', 'PostController@updatecomment');


Route::get('/dologout', [
    'uses' => 'Auth\AuthController@getLogout',
    'as' => 'logout'
]);


Route::get('/images/{postid}/{image}', function($postid = null, $image = null)
{
    $foto="";

    $path = storage_path().'\\app\post_images\\'.$postid .'\\'. $image;
    //dd($path);
     if (file_exists($path)) { 
        return Response::download($path);
        //return Storage::get($path);
    }
});