<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log extends Model 
{

    protected $table = "log";
    
    protected $fillable = [
        'name_user', 'rut','email', 'navegador','ip',
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
