<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\UserRepository;
use App\Jobs\SendMail;
use App\Models\User;

use Input;
use Session;
use DB;
use Redirect;
use Cookie;
class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    /**
     * Handle a login request to the application.
     *
     * @param  App\Http\Requests\LoginRequest  $request
     * @param  Guard  $auth
     * @return Response
     */

    public function login(Request $request)
    {
        
        if($request->get('remcheck') == "yes") $rem = true;
        else $rem = false;
        if (Auth::attempt(array('email' => $request->input('email'), 'password' => $request->input('password')), $rem)){
            $user = Auth::user();
            Auth::login($user);
            if(Auth::check()){
                return redirect()->route('home');
            }
            else {
                $request->session()->set('login_error', 'ОШИБКА! Попробуйте еще раз!');
                $request->session()->save();
                return Redirect::back();
            }
         }
         else {
            $request->session()->set('login_error', 'ОШИБКА! Такого пользователя не существует!');
            $request->session()->save();    
            return Redirect::back();
         }
    }

    public function register(User $userModel, Request $request)
    {
        if($request->input('password') != $request->input('password_confirmation')){
            $request->session()->set('regist_error', 'ОШИБКА! Пароли не совпадают!');
            $request->session()->save();
            return Redirect::back();
        }
         
        $user = new User();
        $user->email = $request->input('email');
        $user->full_name = $request->input('full_name');
        $user->birthday = $request->get('birthday');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->country = $request->input('country');
        $user->zip = $request->input('pzip');
        $user->login = $request->input('login');
        $user->password = $request->input('password');
        $user->save();

        return Redirect::to('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('/');
    }
    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}