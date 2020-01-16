<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\log;
use Illuminate\Support\Facades\DB;
class LogController extends Controller
{
    public function index(Request $request){
        $logs = log::busqueda($request->get('busqueda'))->paginate(15);
        return view('log.index',compact('logs'));
    }
    /**
     * Funcion para eliminar datos del LOG entre dos fechas.
     */
    public function eliminarDatos(Request $request){
        $logs = Log::whereBetween(DB::raw('DATE(created_at)'),[$request->fechainicio,$request->fechafinal])->delete();
        if($logs == 0){
            return redirect()->route('users.log')->with('error', 'No hay registro entre las fechas ingresadas.');
        }else{
            return redirect()->route('users.log')->with('success', 'Registros eliminados correctamente.');
        }
        
    }
}
