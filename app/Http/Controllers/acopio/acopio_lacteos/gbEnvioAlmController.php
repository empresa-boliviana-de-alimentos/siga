<?php

namespace siga\Http\Controllers\acopio\acopio_lacteos;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\Envio_Almacen;
use siga\Modelo\acopio\acopio_lacteos\Acopio;
use siga\Modelo\acopio\acopio_lacteos\AcopioGR;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\Usuario;

use Auth;

class gbEnvioAlmController extends Controller
{
     public function index()
    {   
        $fech= Envio_Almacen::getfecha();   
        $fecha= $fech['enval_registrado'];
    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                         ->join('acopio.precio as pre','planta.id_planta','=','pre.precio_id_planta')
                         ->select('planta.id_planta', 'planta.nombre_planta', 'pre.precio_id_planta', 'pre.precio_costo')
                         ->where('usr_id','=',Auth::user()->usr_id)->first();  
        $plant=$planta['id_planta'];  
        $nomplant=$planta['nombre_planta'];
        $cantuni=$planta['precio_costo'];

        $plant1= DB::table('acopio.envio_almacen')
                ->select(DB::raw('MAX(enval_id) as id'))
                ->first();
        $var=collect($plant1); 
       
        $planta2 = Envio_Almacen::where('enval_id',$var['id'])->first();
       
    	$datos = AcopioGR::select(DB::raw('SUM(detlac_cant) as cantidad_total'))
                       // ->select('aco_estado_env')
                        ->where('detlac_id_planta', $plant)
                        // ->where('detlac_envio','S')
                        ->where('detlac_fecha',date('Y-m-d'))
                        ->first();
        $tot = $datos['cantidad_total']*$cantuni;
         //echo $tot;

        // $var = AcopioGR::where('detlac_id_planta', $plant)
        //                  ->where('aco_id_linea', 2)
        //                  ->orderbydesc('aco_id')->first();
                      
        // if ($var['aco_estado_env']==0) {
        //     $cantidad=$var['aco_cantidad'];
        //     $cantuni=$var['aco_cos_un'];
        //     $tot=$cantidad*$cantuni;
        // 	//echo $tot;
        // }
        // else
        // {
        //     $cantidad=$var['aco_cantidad'];
        //     $cantuni=$var['aco_cos_un'];
        //     $tot=$cantidad*$cantuni;
        //     $tot=0;
        // }
        return view('backend.administracion.acopio.acopio_lacteos.envioAlm.index', compact('nomplant','datos','fecha', 'cantuni','tot','plant','planta2'));  
    }

     public function create()
    {
        $enval = Envio_Almacen::getListarlacteos();
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
        $cod_nro = Envio_Almacen::where('enval_id_planta','=',$planta->id_planta)->where('enval_id_linea', 2)->select(DB::raw('MAX(enval_nro_env) as codigo_nro_env'))->first();
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
            'enval_id_linea'	=> 2,
        ]);
        // DB::table('acopio.acopio')
        //         ->select(DB::raw('MAX(aco_id) as id'))
        //         ->where('aco_id_linea','=',2)
        //         ->where('aco_id_planta','=',$planta->id_planta)
        //         ->where('aco_estado','=','A')
        //         ->where('aco_cert', '=',1)
        //         ->where('aco_id_usr','=',Auth::user()->usr_id)->update(['aco_estado_env'=>1]);
        return response()->json($envalAlm);
    }
}
