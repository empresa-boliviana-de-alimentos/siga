<?php

namespace siga\Http\Controllers\insumo\insumo_solicitudes;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Usuario;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion;
use siga\Modelo\insumo\insumo_recetas\DetalleReceta;
use Yajra\Datatables\Datatables;
use DB;
use Auth;

class gbSolMaquilaController extends Controller
{
    public function index()
    {
    	return view('backend.administracion.insumo.insumo_solicitud.solicitud_maquila.index');
    }
    public function create()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
        $orden_produccion = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                            ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')
                                            ->join('insumo.planta_maquila as plantamaq','insumo.orden_produccion.orprod_planta_maquila','plantamaq.maquila_id')
                                            ->where('orprod_planta_id',$planta->id_planta)
                                            ->where('orprod_tiporprod_id',4)
                                            ->get();

        return Datatables::of($orden_produccion)->addColumn('acciones', function ($orden_produccion) {
                return '<div class="text-center"><a href="BoletaOrdenProduccion/' . $orden_produccion->orprod_id . '" class="btn btn-md btn-primary" target="_blank">'.$orden_produccion->orprod_nro_orden.'</a></div>';
        })
            ->editColumn('id', 'ID: {{$orprod_id}}')            
            
            ->make(true);

    }
    public function viewFormMaquila()
    {
    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta','id_linea_trabajo')->where('usr_id','=',Auth::user()->usr_id)->first();
    	$plantas = DB::table('public._bp_planta')->where('id_linea_trabajo',$planta->id_linea_trabajo)->get();
    	$planta_maquilas= DB::table('insumo.planta_maquila')->get();
    	return view('backend.administracion.insumo.insumo_solicitud.solicitud_maquila.partials.formCreateMaquila', compact('plantas','planta_maquilas'));
    }
    public function registroSolMaquila(Request $request)
    {
    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();     
        $id_receta = $request['receta_id'];
        //$planta_producion = $request['planta_produccion_id'];
        $cantidad_orden = $request['cantidad_producir'];
        $maquila_id = $request['destino_id'];
        $rendimiento_base =$request['rendimiento_base'];
        $observacion = $request['observacion'];
        //dd('Receta: '.$id_receta.', Planta: '.$planta_producion.', Cantidad: '.$cantidad_orden.', mercado: '.$mercado_id);
        $num = OrdenProduccion::join('public._bp_planta as plant', 'insumo.orden_produccion.orprod_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(orprod_nro_orden) as nro_op'))->where('plant.id_planta', $planta->id_planta)->first();
        $cont=$num['nro_op'];
        $nop = $cont + 1;
        $orden_produccion = OrdenProduccion::create([
            'orprod_rece_id'    => $id_receta,
            'orprod_codigo'     => '0001',
            'orprod_nro_orden'  => $nop,
            'orprod_cantidad'   => $cantidad_orden,
            'orprod_mercado_id'    => 1,
           	'orprod_planta_maquila' => $maquila_id,
            'orprod_planta_id'  => $planta->id_planta,
            'orprod_usr_id'     => Auth::user()->usr_id,
            'orprod_tiporprod_id'   => 4,
            'orprod_obs_usr'    => $observacion,
            'orprod_estado_orp' => 'C'
        ]);
        $dato_calculo = $cantidad_orden/$rendimiento_base;
        $detalle_receta = DetalleReceta::where('detrece_rece_id',$id_receta)->get();
        foreach ($detalle_receta as $detrece) {
            DetalleOrdenProduccion::create([
                'detorprod_orprod_id'   => $orden_produccion->orprod_id,
                'detorprod_ins_id'      => $detrece->detrece_ins_id,
                'detorprod_cantidad'    => $detrece->detrece_cantidad*$dato_calculo,
            ]);
        }
        
        return redirect('solMaquila')->with('success','Registro creado satisfactoriamente');
    }
}
