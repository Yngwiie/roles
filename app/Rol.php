<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Caffeinated\Shinobi\Models\Role;

class Rol extends Role
{
    
    /**
     * Funcion para buscar por nombre de rol.
     * 
     * @param mixed $query
     * @param mixed $busqueda dato por el que se desea buscar.
     * 
     * @return void
     */
    public function scopeBusqueda($query,$busqueda)
    {
        if($busqueda!=""){
            $query->where('name','LIKE',"%$busqueda%");
        }
       
    }
}
