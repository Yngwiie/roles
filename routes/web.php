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
    Route::get('/', function () {
        return view('home');
    })->middleware('verified');
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

    Route::delete('roles/destroy','RoleController@destroy')->name('roles.destroy')
        ->middleware('can:roles.destroy');

    Route::get('roles/{role}/edit','RoleController@edit')->name('roles.edit')
        ->middleware('can:roles.edit');

    
    //usuarios
    Route::get('users','UserController@index')->name('users.index')
        ->middleware('can:users.index');
    Route::get('usersNoVerificados','UserController@indexNoVerificados')->name('users.indexNoVerificados')
        ->middleware('can:users.index');
    //usuarios sin rol
    Route::get('users/sinRol','UserController@indexSinRol')->name('users.sinrol')
        ->middleware('can:users.index');

    Route::put('users/{user}/edit','UserController@update')->name('users.update')
        ->middleware('can:users.create');

    Route::get('users/{user}','UserController@show')->name('users.show')
        ->middleware('can:users.show');

    Route::delete('users/destroy','UserController@destroy')->name('users.destroy')
        ->middleware('can:users.destroy');
    
    Route::get('users/{user}/edit','UserController@edit')->name('users.edit')
        ->middleware('can:users.edit');
    //habilitar usuario
    Route::get('restaurar','UserController@restaurarUsuario')->name('users.restaurar')
        ->middleware('can:users.destroy');
    //exportar a excel
    Route::get('exportarexcel','UserController@exportarExcel')->name('users.excel')
        ->middleware('can:users.index');
    
    //edicion datos personales
    Route::get('users/{user}/editar','UserController@editarDatosPersonales')->name('users.edicionPersonal')
        ->middleware('can:user.editardatospersonales');
    Route::put('users/{user}/actualizar','UserController@actualizarDatosPersonales')->name('users.actualizarDatosPersonales')
        ->middleware('can:user.editardatospersonales');
    //imprimir pdf
    Route::get('users/{user}/pdf','UserController@exportarpdf')->name('users.usuariopdf')
        ->middleware('can:users.show');;

    //enviar correo al administrador

    Route::get('enviarcorreo/{user}','UserController@enviarCorreoAdmin')->name('users.enviarcorreo');

    //ruta para log
    Route::get('log','LogController@index')->name('users.log')
        ->middleware('can:users.auditoria');
    Route::get('log/eliminar','LogController@destroy')->name('log.eliminar')
        ->middleware('can:users.auditoria');
    Route::get('log/excel','LogController@exportarExcel')->name('log.excel')
        ->middleware('can:users.auditoria');
    //ruta para respaldar base de datos
    Route::get('respaldo','BackupController@backup_tables')->name('db.guardar')
        ->middleware('can:bd.respaldar');
});

