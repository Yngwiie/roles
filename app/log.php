<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log extends Model 
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'log';

    protected $table = "log";
    
    protected $fillable = [
        'name_user','accion','valores_nuevos','valores_antiguos', 'rut','navegador','ip',
    ];


    public function scopeBusqueda($query,$busqueda)
    {   
        if($busqueda!=""){
            $query->where('name_user','LIKE',"%$busqueda%")
                  ->orWhere('rut','LIKE',"%$busqueda%")
                  ->orwhere('email','LIKE',"%$busqueda%")
                  ->orWhere('created_at','LIKE',"%$busqueda%");
        }
       
    }
}
