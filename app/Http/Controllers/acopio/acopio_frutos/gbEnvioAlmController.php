<?php

namespace siga\Http\Controllers\acopio\acopio_frutos;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\Envio_Almacen;
use siga\Modelo\acopio\acopio_lacteos\Acopio;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\Usuario;
use siga\Modelo\acopio\acopio_frutos\AcopioRF;
use Auth;

class gbEnvioAlmController extends Controller
{
     public function index()
    {   
        $fech= Envio_Almacen::getfecha();   
        $fecha= $fech['enval_registrado'];
    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta', 'planta.nombre_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();  
        $plant=$planta['id_planta'];  
        $nomplant=$planta['nombre_planta'];

    	/*$datos = Acopio::select(DB::raw('MAX(aco_id) as id'))
                        ->where('aco_id_planta', $plant)
                        ->where('aco_estado_env',0)
                        ->where('aco_cert',1)
                        ->first();*/
    	
        $datos = AcopioRF::select(DB::raw('SUM(dac_cantot) as cantidad_total'))
                          ->where('dac_id_planta', $plant)
                          ->where('dac_estado','C')
                          ->where('dac_id_linea',4)
                          ->first(); 
        //echo $datos;   
        $var = Acopio::where('aco_id', $datos['id'])->first();      
    	$cantidad=$datos['cantidad_total'];
        $cantuni=$var['aco_cos_un'];
        $tot=$cantidad*$cantuni;
 
     	//dd ($cantidad);
        return view('backend.administracion.acopio.acopio_frutos.envioAlm.index', compact('cantidad', 'nomplant', 'cantuni', 'tot', 'fecha'));  
    }

     public function create()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta', 'planta.nombre_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();  
        $plant=$planta['id_planta'];  
        $enval = Envio_Almacen::join('public._bp_planta as planta','acopio.envio_almacen.enval_id_planta','=','planta.id_planta')
                                ->where('enval_id_linea', 4)
                                ->where('enval_id_planta',$plant)
                                ->get();
        return Datatables::of($enval)->addColumn('acciones', function ($enval) {
            return '<div class="text-center"><a href="boletaEnvioAlm/' . $enval->enval_id . '" class="btn btn-md btn-primary" target="_blank">Boleta <i class="fa fa-file"></i></a></div>';
        })
            ->editColumn('id', 'ID: {{$enval_id}}')            
            ->make(true);
    }

    public function store(Request $request)
    {
        //$date = Carbon::now();//NUEVO
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $cod_nro = Envio_Almacen::where('enval_id_planta','=',$planta->id_planta)->where('enval_id_linea', 4)->select(DB::raw('MAX(enval_nro_env) as codigo_nro_env'))->first();
        if ($cod_nro['codigo_nro_env'] == NULL) {
        	$nro_cod = 1;
        }
        $nro_cod = $cod_nro['codigo_nro_env'] + 1;
    	$envalAlm = Envio_Almacen::create([
            'enval_cant_total'  => $request['enval_cant_total'],
            'enval_cost_total'  => $request['enval_cost_total'],
            'enval_usr_id'      => Auth::user()->usr_id,
       		'enval_registrado'	=> $request['enval_registro'],
            'enval_estado'      => 'A',
            'enval_id_planta'	=> $planta->id_planta,
            'enval_nro_env'		=> $nro_cod,
            'enval_id_linea'	=> 4,
        ]);
       
        DB::table('acopio.det_acop_ca')
                ->select(DB::raw('MAX(dac_id) as id'))
                ->where('dac_id_linea','=',4)
                ->where('dac_estado','=','C')
                ->where('dac_id_planta', '=', $planta->id_planta)
                //->where('aco_cert', '=',1)
                ->update(['dac_estado'=>'D']);
        return response()->json($envalAlm);
    }
}
