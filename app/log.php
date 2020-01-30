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
     * @param mixed $name
     * 
     * @return void
     */
    public function scopeName($query,$name){
        if($name!=""){
            
            return $query->where('name_user','LIKE',"%$name%");
        }
    }
    /**
     * funcion para buscar por rut en la tabla LOG
     * @param mixed $query
     * @param mixed $rut
     * 
     * @return void
     */
    public function scopeRut($query,$rut){
        if($rut){
            
            return $query->orWhere('rut','LIKE',"%$rut%");
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
            return $query->WhereBetween(DB::raw('DATE(created_at)'),[$fechai,$fechaf]);
        }
    }
}
