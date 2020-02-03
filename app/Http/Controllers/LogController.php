<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\log;
use App\User;
use Session;
use App\Exports\LogExport;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Models\Audit;
use Maatwebsite\Excel\Facades\Excel;
class LogController extends Controller
{

    public function index(Request $request){
        $logs = log::orderBy('id','DESC')
        /* ->WhereBetween(DB::raw('DATE(created_at)'),[$request->fechainicio,$request->fechafinal]) */
        ->fecha($request->get('fechainicio'),$request->get('fechafinal'))  
        ->name_o_rut($request->get('busqueda'))
        ->paginate(15);
        Session::put('logs_filtro',$logs);
        return view('log.index',compact('logs'));
    }
    /**
     * Funcion para eliminar datos del LOG entre dos fechas.
     */
    public function destroy(Request $request){
        $logs = Log::whereBetween(DB::raw('DATE(created_at)'),[$request->fechainicio,$request->fechafinal])->delete();
        if($logs == 0){
            return redirect()->route('users.log')->with('error', 'No hay registro entre las fechas ingresadas.');
        }else{
            return redirect()->route('users.log')->with('success', 'Registros eliminados correctamente.');
        }
        
    }

    /**
     * Funcion para exportar datos con filtro o sin filtro a un excel.
     * @return void
     */
    public function exportarExcel(){
        return Excel::download(new LogExport(Session::get('logs_filtro')),'auditoria.xlsx');
    }
}
