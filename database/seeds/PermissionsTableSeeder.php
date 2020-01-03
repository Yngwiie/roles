<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //permisos de usuario
        Permission::create([
            'name' => 'Navegar usuarios',
            'slug' => 'users.index',
            'description' => 'Lista y navega todos los usuarios del sistema',
        ]);
        Permission::create([
            'name' => 'Ver detalle de usuario',
            'slug' => 'users.show',
            'description' => 'Ver en detalle cada usuario del sistema',
        ]);
        Permission::create([
            'name' => 'Edición de usuarios',
            'slug' => 'users.edit',
            'description' => 'Editar cualquier dato de un usuario del sistema',
        ]);
        Permission::create([
            'name' => 'Eliminar usuario',
            'slug' => 'users.destroy',
            'description' => 'Eliminar cualquier usuario del sistema',
        ]);

         //permisos de usuario
        Permission::create([
            'name' => 'Navegar roles',
            'slug' => 'roles.index',
            'description' => 'Lista y navega todos los roles del sistema',
        ]);
        Permission::create([
            'name' => 'Ver detalle de rol',
            'slug' => 'roles.show',
            'description' => 'Ver en detalle cada rol del sistem',
        ]);
        Permission::create([
            'name' => 'Creación de rol',
            'slug' => 'roles.create',
            'description' => 'Crear un rol',
        ]);
        Permission::create([
            'name' => 'Edición de roles',
            'slug' => 'roles.edit',
            'description' => 'Editar cualquier dato de un rol del sistema',
        ]);
        Permission::create([
            'name' => 'Eliminar roles',
            'slug' => 'roles.destroy',
            'description' => 'Eliminar cualquier usuario del sistema',
        ]);
        
    }
}
