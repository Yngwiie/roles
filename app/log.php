<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    /**
     * funcion para buscar por nombre en la tabla LOG
     * @param mixed $query
     * @param mixed $busqueda
     * 
     * @return void
     */
    public function scopeName_o_rut($query,$busqueda){
        if($busqueda!=""){
            return $query->where('name_user','LIKE',"%$busqueda%")
                         ->orWhere('rut','LIKE',"%$busqueda%");
        }
    }

    /**
     * funcion para buscar entre dos fechas en LOG
     * @param mixed $query
     * @param mixed $fechai
     * @param mixed $fechaf
     * 
     * @return void
     */
    public function scopeFecha($query,$fechai,$fechaf){

        if($fechai && $fechaf){
            /* dd($fechai." ".$fechaf); */
            $query1 = $query->WhereBetween(DB::raw('DATE(created_at)'),[$fechai,$fechaf]);
            return $query1;
        }
    }
}
