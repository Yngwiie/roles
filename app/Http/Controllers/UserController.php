<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Event;
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
    public function index()
    {
        $users = User::withTrashed()->paginate(15);

        return view('users.index',compact('users'));
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

    /**
     * Actualiza datos personales del usuario
     * 
     *@param User $user usuario que se actualiza
     * @return \Illuminate\Http\Response Respuesta de confirmación
     */
    public function actualizarDatosPersonales(Request $request,User $user)
    {
        //actualizar usuario
        $user->update($request->all());

        return redirect()->route('users.editPersonal',$user->id)
            ->with('success','Usuario actualizado con éxito');
    }

    /**
     * Actualiza el usuario y su rol.
     * 
     *@param User $user usuario que se actualiza
     * @return \Illuminate\Http\Response Respuesta de confirmación
     */
    public function update(Request $request,$id)
    {
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
        $pdf = PDF::loadView('pdf.users');
    }
}
