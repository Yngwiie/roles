<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['verify' => true]);
Route::get('profile',function(){
    return 'this is profile';
})->middleware('verified');

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function(){
    //rutas roles
    Route::post('roles/store','RoleController@store')->name('roles.store')
        ->middleware('can:roles.create');

    Route::get('roles','RoleController@index')->name('roles.index')
        ->middleware('can:roles.index');

    Route::get('roles/create','RoleController@create')->name('roles.create')
        ->middleware('can:roles.create');

    Route::put('roles/{role}','RoleController@update')->name('roles.update')
        ->middleware('can:roles.create');

    Route::get('roles/{role}','RoleController@show')->name('roles.show')
        ->middleware('can:roles.show');

    Route::delete('roles/{role}/destroy','RoleController@destroy')->name('roles.destroy')
        ->middleware('can:roles.destroy');

    Route::get('roles/{role}/edit','RoleController@edit')->name('roles.edit')
        ->middleware('can:roles.edit');
    //cant usuarios rol
    Route::get('roles/{role}/cantU','RoleController@cantidadusuariosrol')->name('roles.cantidadusuariosrol');

    
    //usuarios
    Route::get('users','UserController@index')->name('users.index')
        ->middleware('can:users.index');
    Route::get('usersNoVerificados','UserController@indexNoVerificados')->name('users.indexNoVerificados')
        ->middleware('can:users.index');

    Route::put('users/{user}/edit','UserController@update')->name('users.update')
        ->middleware('can:users.create');

    Route::get('users/{user}','UserController@show')->name('users.show')
        ->middleware('can:users.show');

    Route::delete('users/{user}','UserController@destroy')->name('users.destroy')
        ->middleware('can:users.destroy');
    
    Route::get('users/{user}/edit','UserController@edit')->name('users.edit')
        ->middleware('can:users.edit');
    //habilitar usuario
    Route::get('users/{user}/restaurar','UserController@restaurarUsuario')->name('users.restaurar');
   
    //edicion datos personales
    Route::get('users/{user}/editar','UserController@editarDatosPersonales')->name('users.edicionPersonal');
    Route::put('users/{user}/editar','UserController@actualizarDatosPersonales')->name('users.actualizarDatosPersonales');

    //imprimir pdf
    Route::get('users/{user}/pdf','UserController@exportarpdf')->name('users.usuariopdf');

    //enviar correo al administrador

    Route::get('enviarcorreo/{user}','UserController@enviarCorreoAdmin')->name('users.enviarcorreo');

    //ruta para log
    Route::get('log','LogController@index')->name('users.log');
});
