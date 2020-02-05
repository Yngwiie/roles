<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Caffeinated\Shinobi\Models\Role;

class Rol extends Role
{
    public function scopeBusqueda($query,$busqueda)
    {
        if($busqueda!=""){
            $query->where('name','LIKE',"%$busqueda%");
        }
       
    }
}
