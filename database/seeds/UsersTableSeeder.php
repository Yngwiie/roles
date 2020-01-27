<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Role; 
use App\User;
use Illuminate\Support\Facades\Auth;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Role::create([
            'name' => 'Administrador',
            'slug' => 'admin',
            'special' => 'all-access',
        ]);
        $user = User::create([
            'name' => 'Admin',
            'rut' =>'19.718.662-3',
            'email_verified_at' => now(),
            'estado' =>'verificado',
            'email' => 'reivaj_31@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRoles('admin');
        $user->save();

        $rol = Role::create([
            'name' => 'Revisor',
            'slug' => 'revi',
        ]);
        $rol->givePermissionTo('users.index','roles.index');
        

    }
}
