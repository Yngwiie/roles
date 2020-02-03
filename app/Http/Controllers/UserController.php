<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Event;
use Auth;
use Mail;
use App;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use Barryvdh\DomPDF\Facade as PDF;
use App\Support\Collection;
use App\Traits\Anadirlog;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;

class UserController extends Controller
{
    use Anadirlog;
    private $user;
    /**
     * Función para listar en pantalla todos los usuarios que no estan eliminados.
     *
     * @return \Illuminate\Http\Response la vista index junto con los usuarios no eliminados.
     */
    public function index(Request $request)
    {   
                       //scope
        $users = User::busqueda($request->get('busqueda'))->withTrashed()->paginate(15);
        $users_sin_paginacion = User::select("id","name","rut","email","estado","deleted_at")->busqueda($request->get('busqueda'))->withTrashed()->get();
        Session::put('users_filtro',$users_sin_paginacion);
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
        $users_sin_paginacion = User::select("id","name","rut","email","estado","deleted_at")
                ->busqueda_no_verificados($request->get('busqueda'))->withTrashed()->get();
        Session::put('users_filtro',$users_sin_paginacion);
        return view('users.indexNoverificados',compact('users'));
    }

    /**
     * Función para obtener todos los usuarios sin rol y paginarlos.
     */
    public function indexSinRol(Request $request){
        $users_todos = User::busqueda_sin_rol($request->get('busqueda'))->withTrashed()->get();
        
        $users_sin_rol = collect(new User);
        foreach($users_todos as $user){
            $roles = $user->roles;
            if($roles->count()==0){
                $users_sin_rol->push($user);
            }
        }
        $users = $users_sin_rol->paginate(15); //pagino los usuarios sin rol.

        $users_todos = User::select("id","name","rut","email","estado","deleted_at")->busqueda_sin_rol($request->get('busqueda'))->withTrashed()->get();
        
        $users_sin_rol_sin_paginacion = collect(new User);
        foreach($users_todos as $user){
            $roles = $user->roles;
            if($roles->count()==0){
                $users_sin_rol_sin_paginacion->push($user);
            }
        }
        $users_sin_paginacion = $users_sin_rol_sin_paginacion;
        Session::put('users_filtro',$users_sin_paginacion);
        return view('users.indexsinrol',compact('users'));
    }

    /**
     * Función para restaurar un usuario Deshabilitado(eliminado con sofdelete)
     */
    public function restaurarUsuario(Request $request){
        
        $user = User::onlyTrashed()->find($request->user_id)->restore();
        $user = User::find($request->user_id);

        $this->nuevaAccion('habilitar usuario',"{nombre: ".$user->name."} {rut: ".$user->rut."}",""); 
        return redirect()->back()->with('success','Usuario habilitado correctamente');
        
    }

    /**
     * función para obtener datos personales del usuario.
     *
     * @param  User $user usuario que se desea mostrar.
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        
        if($id==1){//evitar mostrar administrador.
            abort(404);
        }
        $user = User::withTrashed()->findOrFail($id);
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
        if($id==1){//evitar editar administrador
            abort(404);
        }
        $user = User::withTrashed()->findOrFail($id);

        $roles = Role::get();//obtengo todos los roles.
        return view('users.edit',compact('user','roles'));
    }    

    /**
     * funcion para eliminar un usuario.
     * 
     * @param User $user es el usuario que se desea eliminar
     * @return \Illuminate\Http\Response Respuesta de confirmación
     */
    public function destroy(Request $request)
    {   
        if($request->user_id_inhabilitar==1){//evitar eliminar administrador
            abort(404);
        }
        $user = User::findOrFail($request->user_id_inhabilitar);
        $nombre = $user->name;
        $rut = $user->rut;
        $user->delete();

        $this->nuevaAccion('inhabilitar usuario',"","{nombre: ".$nombre."} {rut: ".$rut."}"); 
        return redirect()->back()->with('success', 'Inhabilitado correctamente.');
    }

    /**
     * Función para obtener los datos del usuario que esta en session.
     */
    public function editarDatosPersonales(User $user)
    {   
        return view('users.editPersonal',compact('user'));           
        
    }

    /**
     * Función para actualizar los datos personales de un usuario.
     * @param Request $request contiene los nuevos datos que se actualizaran.
     * @param User $user usuario que se actualizara.
     * 
     * @return void
     */
    public function actualizarDatosPersonales(Request $request,User $user){
        $rules = [//reglas para los campos de contraseña
            'name' =>'required|min:2|max:190',
            'passantigua' => 'required',
            'password' => 'required|min:8|max:45|confirmed',
        ];

        $messages = [ //mensajes que se devolvera dependiendo el error.
            'passantigua.required' => 'La contraseña antigua es requerido',
            'password.required' => 'El campo nueva contraseña es requerido',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres',
            'password.max' => 'La nueva contraseña debe tener como maximo 45 caracteres',
            'password.confirmed' =>'No coinciden las nuevas contraseñas',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        $user1 = User::find($user->id);
        if($validator->fails()){
            return view('users.editPersonal',compact('user'))->withErrors($validator);
        }
        else{
            if(Hash::check($request->passantigua,Auth::user()->password)){
                $user = User::find(Auth::user()->id);
                $nombre_antiguo = $user->name;
                $user->name = $request['name'];
                $user->where('email', '=', Auth::user()->email)
                     ->update(['password' => Hash::make($request['password'])]);
                $user->save();
                
                if($request->passantigua == $request->password){
                    $this->nuevaAccion('Cambio datos personales',$user->name,$nombre_antiguo);   
                }else{
                    $this->nuevaAccion('Cambio datos personales(incluido contraseña)',$user->name,$nombre_antiguo);
                }
                    
                return redirect()->route('home')->with('success', 'Actualizado correctamente.');
            }
            else{
                return redirect()->route('users.edicionPersonal',$user->id)->with('error','La contraseña antigua es incorrecta');
            }
        }
    }
    /**
     * Actualiza el datos del usuario y su rol.
     * 
     *@param User $user usuario que se actualiza
     * @return \Illuminate\Http\Response Respuesta de confirmación
     */
    public function update(Request $request,$id)
    {
        if($id == 1){
            abort(404);
        }
        $validatedData = $request->validate([
            'name' => 'required|min:1|max:190',
            'roles' =>'array|required|max:1',
        ]);
        $user = User::withTrashed()->findOrFail($id);
        $roles_ant = $user->roles;
        $idrol="";
        foreach($roles_ant as $rol){
            $idrol = $rol->id;
        }
        $datos_string_antiguos = $this->pasarDatosUsuarioAstring($user,$idrol);
        

        //actualizar usuario
        $user->update($request->all());
         //actualizar roles  
        $user->roles()->sync($request->get('roles'));
        
        //pasar los datos nuevos a string
        $datos_string_nuevos = $this->pasarDatosUsuarioAstring($user,$request->get('roles')[0]);
        
        //llamamos al Función que ingresa el nuevo dato a la tabla LOG
        $this->nuevaAccion('Actualizar usuario',$datos_string_nuevos,$datos_string_antiguos);
        
        return redirect()->route('users.edit',$user->id)
            ->with('success','Usuario actualizado con éxito');
    }
    
    /**
     * Funcion para exportar los detalles de un usuario a PDF.
     * @param mixed $id identificador del usuario
     * 
     * @return void
     */
    public function exportarpdf($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $roles = $user->roles;//obtengo los roles que tiene el usuario

 //       $pdf = PDF::loadView('users.show',compact('user','roles'));
        $pdf = PDF::loadView('users.usuariopdf',compact('user','roles'));
        return $pdf->download("usuario.pdf");
    }


    /**
     * Función para enviar correo a administrador
     */
    public function enviarCorreoAdmin($id)
    {
        
        $user = User::withTrashed()->findOrFail($id);
        $data = array(
            'name'=>$user->name,
            'email'=>$user->email,
            'rut'=>$user->rut,
        );  
        $users = User::all();
        foreach($users as $user){
            $this->user = $user;
            if($user->hasRole('admin')){
                Mail::send('emails.emailAdmin',$data,function($message){
                    $message->from(config('mail.username'),'Roles y Permisos');
        
                    $message->to($this->user->email)->subject('Petición para asignar rol');
                }); 
            }
        }
        $correos = $user->cant_correos;
        $correos = $correos - 1;
        $user->cant_correos = $correos;
        $user->save();
        return redirect()->route('home')
        ->with('success','Correo enviado');
    }
    /**
     * Función para pasar los datos de un usuario en un string unico
     * @param $user el usuario que pasaremos a string
     * @param $idrol es el id del rol que tiene asignado el usuario
     */
    public function pasarDatosUsuarioAstring(User $user,$idrol){

        $datos_string = "";
        $datos_string.="{nombre: ";
        $datos_string.=$user->name.' } ';
        $datos_string.="{e-mail: ";
        $datos_string.=$user->email." } ";
        $datos_string.="{Role: ";
        if($idrol==""){
            $datos_string .= "Sin rol }";
        }else{
            $rol = Role::find($idrol);
            $datos_string.=$rol->name." } ";
        }
       
        return $datos_string;
    }
    
    /**
     * Funcion para exportar datos con filtro o sin filtro a un excel.
     * @return void
     */
    public function exportarExcel(){
        return Excel::download(new UserExport(Session::pull('users_filtro')),'usuarios_roles_permisos.xlsx');
    }
}
