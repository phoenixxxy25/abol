<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;
use URL;
use Session;
use Auth;
use Storage;
use Redirect;
use Input;
use DB;
use View;

class HomeController extends Controller
{

    public function home(Post $postM)
    {
        $posts = $postM->getPublishedPosts();
        return view('post.index', ['posts' => $posts]);
    }

    public function profile(Request $request)
    {
        if(!Auth::guest() AND Auth::user()){
            $user = User::where('id', '=', Auth::user()->id)->get();
            return view('profile', ['user' => $user]);
        
        } else return Redirect::to('login');
    }

    public function user($user)
    {
        $getuser = User::where('login', '=', $user)->get();
        return view('profile', ['user' => $getuser]);
    }

    public function editprofileform($id)
    {
       $user = User::find($id);
        
        return View::make('profile_edit')->with('user', $user);
    }

    public function updateprofile(Request $request)
    {
      DB::table('users')->where('id', Auth::user()->id)->update(['login' => Input::get('login'), 'email' => Input::get('email'), 'full_name' => Input::get('full_name'), 'address' => Input::get('address'), 'city' => Input::get('city'), 'state' => Input::get('state'), 'country' => Input::get('country'), 'zip' => Input::get('pzip')]);
      $msg = "Успешно!";
       return Redirect::to('profile');
    }

    public function search(Request $request)
    {

        if($request->input('searchobj') != null) $searchobj = $request->input('searchobj');
        else $searchobj = "Ничего не найдено!";
        $searchresult = [];
        $expld = explode(' ', $searchobj);

        $query_part= '';
        foreach ($expld as $key => $value) {
            $query_part .= ' title LIKE "%'. $value . '%" OR excerpt LIKE "%'. $value. '%" OR content LIKE "%'. $value . '%" OR ';
        }

        $query_part .= ' title LIKE "%'. $searchobj . '%" OR excerpt LIKE "%'. $searchobj. '%" OR content LIKE "%'. $searchobj.'%"';

        $searchresult = DB::select('select * from posts where '.$query_part);
        $full_query = 'select * from posts where '.$query_part;

        $name = '';

        return view('search', ['pimp' => $searchobj, 'result' => $searchresult]);
    }

    public function getSearchResult()
    {
      $msg = strip_tags(Input::get('searchval'));
      $filter = Input::get('filter');
      $searchobj =  strip_tags(Input::get('searchval'));
      $defaultSrch = true;
      $customSrch = 0;
      
      switch ($filter) {
        case 0:
          $query_part = ' title LIKE "%VALUE%" OR excerpt LIKE "%VALUE%" OR content LIKE "%VALUE%" OR ';
          break;
        case 1:
          $query_part = ' author LIKE "%VALUE%" OR ';
          break;
        case 2:
          $query_part = ' title LIKE "%VALUE%" OR excerpt LIKE "%VALUE%" OR content LIKE "%VALUE%" OR ';
          break;
        case 3:
          $query_part = ' address LIKE "%VALUE%" OR city LIKE "%VALUE%" OR country LIKE "%VALUE%" OR state LIKE "%VALUE%" OR zip LIKE "%VALUE%" OR ';
          $customSrch = 'address';
          $defaultSrch = false;
          break;
        case 4:
          $query_part = ' t.title LIKE "%VALUE%" OR ';
          $defaultSrch = false;
          $customSrch = 'tags';
          break;
        case 5:
          $query_part = ' content LIKE "%VALUE%" OR ';
          break;
        default:
          $query_part = ' default ';
   

          break;
      }
      $query = '';
      $searchobjarr = explode(' ', $searchobj);
        if(count($searchobjarr) > 1){
          foreach ($searchobjarr as $key => $value) {
              $query .= str_replace("VALUE", $value, $query_part);
          }
          $query .= substr(str_replace("VALUE", $searchobj, $query_part), 0, -3);
        }
        else $query .= substr(str_replace("VALUE", $searchobj, $query_part), 0, -3);
      if($defaultSrch){
        $msg = $query;
        $searchresult = DB::select('select * from posts where '.$query);
      }
      else {
        if($customSrch == 'tags'){
            $cquery = 'SELECT p.id, p.content, p.title FROM  `posts` AS p LEFT JOIN  `tag_connections` AS tc ON ( p.id = tc.post_id ) LEFT JOIN  `tags` AS t ON ( tc.tag_id = t.id ) WHERE '. $query;
            $searchresult = DB::select($cquery);
        }
        else if($customSrch == 'address'){
            $cquery = 'SELECT p.id, p.content, p.title FROM  `posts` AS p LEFT JOIN  `users` AS u ON ( p.author = u.login ) WHERE '. $query;
            $searchresult = DB::select($cquery);
        }
      }
      
      $arrResultJson = [];
      foreach ($searchresult as $key => $value) {

        $url = URL::to('post', $value->id);
        $value->url = $url;
        $arrResultJson[$key] = $value;
      }

      $msg = 'a';
      return response()->json(array('msg'=> $msg, 'sresult' => $arrResultJson), 200); 
    }

    public function admin(Request $request)
    {
       if(!Auth::guest() AND Auth::user() AND Auth::user()->group == 3){
            $users = User::All();
            return view('admin', ['users' => $users]);
        
        } else return Redirect::to('home');
    }

    public function editusers(Request $request)
    {

      DB::table('users')->where('id', Input::get('id'))->update(['login' => Input::get('lg'), 'email' => Input::get('em'), 'group' => Input::get('gr'), 'full_name' => Input::get('fn')]);
      $msg = "Успешно!";
        return response()->json(array('msg'=> $msg), 200);
    }

}
