<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Freshwork\ChileanBundle\Rut;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        

        $validator = Validator::make($data,[
            'rutSinFormato' => ['required','cl_rut']
        ],['rutSinFormato.cl_rut' => 'El rut no es válido']);
        
        if($validator->fails()){
            return $validator;
        }
        //se le da formato al rut con puntos y guión
        $rutNuevo = Rut::parse($data['rutSinFormato'])->fix()->format();
        array_push($data,$rutNuevo);
        $data['rut'] = $rutNuevo;

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'rutSinFormato' => ['required','cl_rut'],
            'rut' => ['unique:users','cl_rut']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $rutNuevo = Rut::parse($data['rutSinFormato'])->fix()->format();
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'rut' => $rutNuevo,
            'password' => Hash::make($data['password']),
        ]);
    }
}
