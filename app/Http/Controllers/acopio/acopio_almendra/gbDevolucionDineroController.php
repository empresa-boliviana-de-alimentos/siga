<?php

namespace siga\Http\Controllers\acopio\acopio_almendra;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Usuario;
use siga\Modelo\acopio\acopio_almendra\Devolucion_Dinero;
use Yajra\Datatables\Datatables;
use Auth;
use DB;

class gbDevolucionDineroController extends Controller
{
    public function index()
    {
    	$listaDevolucion = Devolucion_Dinero::getListar();
    	// dd($listaDevolucion);
    	$id=Auth::user()->usr_id;
    	$sumasig =\DB::select('select * from acopio.sp_sum_asignado(?)', array($id));
        $asig=Collect($sumasig);
        $array = json_decode($asig);
        // $asignado = $array[0]->asig_monto1;
        if (empty($array[0]->asig_monto1)) {
        	$asignado = 0;
        }else{
        	$asignado = $array[0]->asig_monto1;
        }
        $sumauti =\DB::select('select * from acopio.sp_sum_utilizado(?)', array($id));
        $uti=Collect($sumauti);
        $array1 = json_decode($uti);
        // $utilizado = $array1[0]->aco_cos_total1;
        if (empty($array1[0]->aco_cos_total1)) {
        	$utilizado = 0;
        } else {
        	$utilizado = $array1[0]->aco_cos_total1;
        }

        $monto_devolver = $asignado - $utilizado;
        // dd($monto_devolver);
    	$planta = $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')
            ->join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
    	return view ('backend.administracion.acopio.acopio_almendra.gbDevolucionDinero.index', compact('planta','monto_devolver'));
    }
    public function create()
    {
    	$devolucion = Devolucion_Dinero::getListar();
    	return Datatables::of($devolucion)->addColumn('acciones', function ($devolucion) {
            return '<div class="text-center"><a href="#" class="btn btn-md btn-primary" target="_blank">Boleta <i class="fa fa-file"></i></a></div>';
        })
            ->editColumn('id', 'ID: {{$devodi_id}}')            
            ->make(true);
    }

    public function store(Request $request)
    {
    	// $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
     //                        ->select('planta.id_planta')
     //                        ->where('usr_id','=',Auth::user()->usr_id)->first();
     //    $cod_nro = Envio_Almacen::where('enval_id_planta','=',$planta->id_planta)->select(DB::raw('MAX(enval_nro_env) as codigo_nro_env'))->first();
     //    if ($cod_nro['codigo_nro_env'] == NULL) {
     //    	$nro_cod = 1;
     //    }
     //    $nro_cod = $cod_nro['codigo_nro_env'] + 1;
    	// $envalAlm = Envio_Almacen::create([
     //        'enval_cant_total'  => $request['enval_cant_total'],
     //        'enval_cost_total'  => $request['enval_cost_total'],
     //        'enval_usr_id'      => Auth::user()->usr_id,
     //   		'enval_registrado'	=> $request['enval_registro'],
     //        'enval_estado'      => 'A',
     //        'enval_id_planta'	=> $planta->id_planta,
     //        'enval_nro_env'		=> $nro_cod,
     //        'enval_id_linea'    => 1,
     //    ]);
     //    return response()->json($envalAlm);
    }
}
