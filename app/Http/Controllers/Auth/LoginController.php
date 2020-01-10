<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Log;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request,$user )
    {
//        dd($_SERVER['HTTP_USER_AGENT']."  ".$_SERVER['REMOTE_ADDR']);
        $log = new Log();
        $log->name_user=$user->name;
        $log->rut=$user->rut;
        $log->email=$user->email;
        $log->navegador= $_SERVER['HTTP_USER_AGENT'];
        $log->ip=$_SERVER['REMOTE_ADDR'];
        $log->save();
    }
}
