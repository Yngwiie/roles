<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Log;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
     * @$log->navegador=void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Envía la respuesta después de que el usuario se autentifique.
     * Elimina el resto de sesiones de este usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $previous_session = Auth::User()->session_id;
        if ($previous_session) {
            Session::getHandler()->destroy($previous_session);
        }

        Auth::user()->session_id = Session::getId();
        Auth::user()->save();
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
    public function authenticated(Request $request,$user )
    {
        
        $log = new Log();
        $log->name_user=$user->name;
        $log->rut=$user->rut;
        $log->email=$user->email;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        //obtener navegador.
        if(strpos($user_agent, 'MSIE') !== FALSE)
            $log->navegador='Internet explorer';
        elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
            $log->navegador='Microsoft Edge';
        elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
            $log->navegador='Internet explorer';
        elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
            $log->navegador="Opera Mini";
        elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
            $log->navegador="Opera";
        elseif(strpos($user_agent, 'Firefox') !== FALSE)
            $log->navegador='Mozilla Firefox';
        elseif(strpos($user_agent, 'Chrome') !== FALSE)
            $log->navegador='Google Chrome';
        elseif(strpos($user_agent, 'Safari') !== FALSE)
            $log->navegador="Safari";
        else
            $log->navegador='No se detecto navegador.';
        
        //Identificar la ip del usuario
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            $log->ip=$_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            $log->ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            $log->ip=$_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            $log->ip=$_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            $log->ip=$_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            $log->ip=$_SERVER["REMOTE_ADDR"];
        } 
        $log->save();
    }
    

}
