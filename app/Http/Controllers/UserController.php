<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Event;
use Auth;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use Barryvdh\DomPDF\Facade as PDF;

class UserController extends Controller
{
    /**
     * Función para listar en pantalla todos los usuarios que no estan eliminados.
     *
     * @return \Illuminate\Http\Response la vista index junto con los usuarios no eliminados.
     */
    public function index(Request $request)
    {   
        
                       //scope
        $users = User::busqueda($request->get('busqueda'))->withTrashed()->paginate(15);

        return view('users.index',compact('users'));
    }
    /**
     * Funcion para listar en pantalla todos los usuarios que no estan eliminados y
     * que no esten verificados
     * @return  \Illuminate\Http\Response retorna vista indexNoVerificados con los usuarios.
     */
    public function indexNoVerificados(Request $request)
    {   
                       //scope
        $users = User::busqueda_no_verificados($request->get('busqueda'))->withTrashed()->paginate(15);

        return view('users.indexNoverificados',compact('users'));
    }
    /**
     * función para obtener datos personales del usuario.
     *
     * @param  User $user usuario que se desea mostrar.
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $user = User::withTrashed()->find($id);
        $roles = $user->roles;//obtengo los roles que tiene el usuario
        return view('users.show',compact('user','roles'));
    }

    /**
     * función para obtener los datos del usuario , tanto datos personales como roles.
     *
     * @param  User  $user usuario que se desea editar.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::withTrashed()->find($id);
        $roles = Role::get();//obtengo los roles que tiene el usuario
        return view('users.edit',compact('user','roles'));
    }    

    /**
     * Esta funcion elimina a un usuario.
     * 
     * @param User $user es el usuario que se desea eliminar
     * @return \Illuminate\Http\Response Respuesta de confirmación
     */
    public function destroy(User $user)
    {   
        $user-> delete();

        return redirect()->back()->with('success', 'Eliminado Correctamente.');
    }
    public function editarDatosPersonales(User $user)
    {
        return view('users.editPersonal',compact('user'));
    }

    public function actualizarDatosPersonales(Request $request,User $user){
        $rules = [//reglas para los campos de contraseña
            'passantigua' => 'required',
            'password' => 'required|min:8|max:18',
        ];

        $messages = [ //mensajes que se devolvera dependiendo el error.
            'passantigua.required' => 'El campo es requerido',
            'password.required' => 'El campo es requerido',
            'password.min' => 'El mínimo permitido son 8 caracteres',
            'password.max' => 'El máximo permitido son 18 caracteres',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->route('users.edicionPersonal',$user->id)->withErrors($validator);
        }
        else{
            if(Hash::check($request->passantigua,Auth::user()->password)){
                $user = User::find(Auth::user()->id);
                $user->name = $request['name'];
                $user->where('email', '=', Auth::user()->email)
                     ->update(['password' => Hash::make($request['password'])]);
                $user->save();
                return redirect()->route('home')->with('success', 'actualizado correctamente.');
            }
            else{
                return redirect()->route('users.edicionPersonal',$user->id)->with('error','Credenciales incorrectas');
            }
        }
    }
    /**
     * Actualiza el usuario y su rol.
     * 
     *@param User $user usuario que se actualiza
     * @return \Illuminate\Http\Response Respuesta de confirmación
     */
    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:1|max:190',
        ]);
        $user = User::withTrashed()->find($id);
        //actualizar usuario
        $user->update($request->all());

        //actualizar roles
        $user->roles()->sync($request->get('roles'));

        return redirect()->route('users.edit',$user->id)
            ->with('success','Usuario actualizado con éxito');
    }

    public function exportarpdf(User $user)
    {
        $roles = Role::get();//obtengo los roles que tiene el usuario

 //       $pdf = PDF::loadView('users.show',compact('user','roles'));
        $pdf = PDF::loadView('users.usuariopdf',compact('user','roles'));
        return $pdf->download("usuario.pdf");
    }


    /**
     * Metodo para enviar correo a administrador
     */
    public function enviarCorreoAdmin($id)
    {
        
        $user = User::withTrashed()->find($id);
        $correos = $user->cant_correos;
        $correos = $correos - 1;
        $user->cant_correos = $correos;
        $user->save();
        $data = array(
            'name'=>$user->name,
            'email'=>$user->email,
            'rut'=>$user->rut,
        );  
        Mail::send('emails.emailAdmin',$data,function($message){
            $message->from('yngwiie00@gmail.com','Roles y Permisos');

            $message->to('yngwiie00@gmail.com')->subject('Petición para asignar rol');
        }); 

        return redirect()->route('home')
        ->with('success','Correo enviado');
    }
    /**
     * Función para restaurar un usuario Deshabilitado(eliminado con sofdelete)
     */
    public function restaurarUsuario($id){
        User::onlyTrashed()->find($id)->restore();

        return redirect()->route('users.index')
            ->with('success','Usuario habilitado correctamente');
    }
}
