<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\UserRepository;
use App\Jobs\SendMail;
use App\Models\User;
use Auth;
use Input;
use Session;
use DB;
use Redirect;

class MehController extends Controller
{

	public function profile()
    {
        return view('profile');
    }

}