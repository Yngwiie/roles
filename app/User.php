<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;  
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use App\Notifications\ResetPasswordNotification;

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
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Metodo para poder realizar la busqueda o filtrado.
     * Se puede hacer por nombre, rut , email o estado(verificado o no verificado).
     */
    public function scopeBusqueda($query,$busqueda)
    {
        if($busqueda!=""){
            $query->where('name','LIKE',"%$busqueda%")
                  ->orWhere('rut','LIKE',"%$busqueda%")
                  ->orwhere('email','LIKE',"%$busqueda%")
                  ->orWhere('estado','LIKE',"%$busqueda%");
        }
       
    }
}
