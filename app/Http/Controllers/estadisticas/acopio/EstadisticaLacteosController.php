<?php

namespace siga\Http\Controllers\estadisticas\acopio;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_lacteos\Acopio;
use siga\Modelo\acopio\acopio_lacteos\AcopioGR;
use DB;
use Auth;	

class EstadisticaLacteosController extends Controller
{
    public function estadisticaDia()
    {
    	$plantas = DB::table('public._bp_planta')->where('id_linea_trabajo',2)->get();    	
    	return view('backend.administracion.estadistica.indexLacteos', compact('plantas'));
    }

    public function precioPlanta($id_planta)
    {
    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                         ->join('acopio.precio as pre','planta.id_planta','=','pre.precio_id_planta')
                         ->select('planta.id_planta', 'planta.nombre_planta', 'pre.precio_id_planta', 'pre.precio_costo')
                         ->where('planta.id_planta',$id_planta)->first(); 
    }
}
