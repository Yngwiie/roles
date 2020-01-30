<?php

namespace App\Traits;

use App\Log;

trait Anadirlog{

    public function nuevaAccion($accion,$valoresnuevos,$valoresantiguos){
        
        $log = new Log();
        $log->name_user=auth()->user()->name;
        $log->accion=$accion;
        $log->rut=auth()->user()->rut;
        $log->valores_nuevos = $valoresnuevos;
        $log->valores_antiguos = $valoresantiguos;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        //obtener navegador.
        if(strpos($user_agent, 'MSIE') !== FALSE)
            $log->navegador='Internet explorer';
        elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
            $log->navegador='Microsoft Edge';
        elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
            $log->navegador='Internet explorer';
        elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
            $log->navegador="Opera Mini";
        elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
            $log->navegador="Opera";
        elseif(strpos($user_agent, 'Firefox') !== FALSE)
            $log->navegador='Mozilla Firefox';
        elseif(strpos($user_agent, 'Chrome') !== FALSE)
            $log->navegador='Google Chrome';
        elseif(strpos($user_agent, 'Safari') !== FALSE)
            $log->navegador="Safari";
        else
            $log->navegador='No se detecto navegador.';
        
        //Identificar la ip del usuario
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            $log->ip=$_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            $log->ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            $log->ip=$_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            $log->ip=$_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            $log->ip=$_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            $log->ip=$_SERVER["REMOTE_ADDR"];
        }
        
        $log->save();
        
    }
}