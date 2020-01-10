<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\log;
class LogController extends Controller
{
    public function index(Request $request){
        $logs = log::busqueda($request->get('busqueda'))->paginate(15);
        return view('log.index',compact('logs'));
    }
}
