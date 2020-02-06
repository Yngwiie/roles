<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;  
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;//utilizo borrado suave, quiere decir que solamente cambio el 
                    // estado de una variable en la Base de Datos.
    use HasRolesAndPermissions;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'rut','email', 'password','estado',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Atributo para utilizar borrado suave, el cual guardara la fecha de cuando se borre
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * Envia la notificacion de reiniciar contraseña.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
    /**
     * Metodo para poder realizar la busqueda o filtrado para usuarios verificados.
     * Se puede hacer por nombre, rut , email o estado(verificado o no verificado).
     */
    public function scopeBusqueda($query,$busqueda)
    {   
        $query->where('estado',"verificado");
        $query->where('id','!=',1); 
        if($busqueda!=""){
            $query->where([['name','LIKE',"%$busqueda%"],['estado',"verificado"]])
                  ->orWhere([['rut','LIKE',"%$busqueda%"],['estado',"verificado"]])
                  ->orwhere([['email','LIKE',"%$busqueda%"],['estado',"verificado"]]);
        }
       
    }

    /**
     * Metodo para poder realizar la busqueda o filtrado para usuarios no verificados.
     * Se puede hacer por nombre, rut o email.
     */
    public function scopeBusqueda_no_verificados($query,$busqueda)
    {   
        $query->where('estado',"no verificado");
        $query->where('id','!=',1); 
        if($busqueda!=""){
            $query->where([['name','LIKE',"%$busqueda%"],['estado',"no verificado"]])
                  ->orWhere([['rut','LIKE',"%$busqueda%"],['estado',"no verificado"]])
                  ->orwhere([['email','LIKE',"%$busqueda%"],['estado',"no verificado"]]);
        }
       
    }
    
    /**
     * Funcion para buscar usuarios sin rol a traves de consulta query.
     * Se puede buscar por nombre, rut o email.
     * @param mixed $query
     * @param mixed $busqueda
     * 
     * @return void
     */
    public function scopeBusqueda_sin_rol($query,$busqueda)
    {
        $query->where('id','!=',1); 
        if($busqueda!=""){
            $query->where([['name','LIKE',"%$busqueda%"]])
                  ->orWhere([['rut','LIKE',"%$busqueda%"]])
                  ->orwhere([['email','LIKE',"%$busqueda%"]]);
        }
    }
}
