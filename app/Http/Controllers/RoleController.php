<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\User;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;

class RoleController extends Controller
{
    /**
     * Funcion para listar los roles y devolverlos a la vista roles.index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::busqueda($request->get('busqueda'))->paginate(15);

        return view('roles.index',compact('roles'));
    }
    /**
     * Función para crear rol con sus permisos. 
     * 
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create',compact('permissions'));
    }
     /**
     * Función para guardar los datos de un rol y sus permisos.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'slug' => 'required|unique:roles|max:18',
            'name' => 'required|unique:roles|min:3|max:45',
        ]);

        $role = Role::create($request->all());

        $role->permissions()->sync($request->get('permissions'));

        return redirect()->route('roles.edit',$role->id)
            ->with('info','Rol guardado con éxito');
    }

    /**
     * funcion para mostrar el detalle de un rol.
     *
     * @param  Role $role rol que se desea mostrar.
     * @return \Illuminate\Http\Response se devuelve la vista show y los datos del rol.
     */
    public function show(Role $role)
    {   
        $users = User::all();
        $cantidad_usuarios = 0;
        foreach($users as $user){
            if($user->hasRole($role->slug)){
                $cantidad_usuarios+=1;
            }
        }
        return view('roles.show',compact('role','cantidad_usuarios'));
    }

    /**
     * función para obtener los datos de un rol y poder editarlos.
     *
     * @param  Role $role rol que se desea editar.
     * @return \Illuminate\Http\Response devuelve la vista de editar y los datos del rol y sus permisos.
     */
    public function edit(Role $role)
    {   
        $permissions = Permission::get();
        return view('roles.edit',compact('role','permissions'));
    }

    /**
     * Función para actualizar rol y sus permisos.
     *
     * @param  Role $role rol que se desea actualizar.
     * @return \Illuminate\Http\Response se devuelve la vista de edit y un mensaje de éxito.
     */
    public function update(Request $request,Role $role)
    {
        $validatedData = $request->validate([
            'slug' => 'required|unique:roles|max:18',
            'name' => 'required|unique:roles|min:3|max:190',
        ]);
        //actualizar rol
        $role->update($request->all());

        //actualizar permisos
        $role->permissions()->sync($request->get('permissions'));

        return redirect()->route('roles.edit',$role->id)
            ->with('success','Rol actualizado con éxito');
    }

    /**
     * función para eliminar un rol.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Role $role)
    {
        $roles = Role::busqueda($request->get('busqueda'))->paginate(15);
        $role-> delete();

        return redirect()->route('roles.index',$roles)
            ->with('success','Rol eliminado con éxito');
    }
    public function cantidadusuariosrol(Request $request,Role $role)
    {
        $roles = Role::busqueda($request->get('busqueda'))->paginate(15);
        $users = User::all();
        foreach($users as $user){
            if($user->hasRole($role->slug)){
                $message =  'hay personas con rol';
                return view('modal.modal',compact('message','roles','role'));
            }
        }
        $message = '¿Esta seguro?';

        return view('modal.modal',compact('message','roles','role'));
    }



   

}
