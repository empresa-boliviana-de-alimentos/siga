<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_recetas\Receta;
use siga\Http\Modelo\comercial\Producto;
use siga\Http\Modelo\comercial\PuntoVenta;
use siga\Http\Modelo\comercial\IngresoPv;
use siga\Http\Modelo\comercial\DetalleIngresoPv;
use siga\Http\Modelo\comercial\StockPv;
use siga\Modelo\admin\Usuario;
use Auth;
use DB;

class IngresoPuntoVentaController extends Controller
{
    public function index()
    {
    	//dd("INGRESO PRODUCTOS PUNTO DE VENTA");
        $productos = Producto::join('insumo.receta as rece','comercial.producto_comercial.prod_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->where('prod_codigo','<>', null)->get();
    	//$recetas = Receta::leftjoin('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')->get();
        $punto_ventas = PuntoVenta::join('public._bp_planta as pl','comercial.punto_venta_comercial.pv_id_planta','=','pl.id_planta')
                                 ->get();
    	return view('backend.administracion.comercial.ingreso_punto_venta.index', compact('productos','punto_ventas'));
    }

    public function listarProductos()
    {
        $recetas = Receta::leftjoin('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')->get();
        return Datatables::of($recetas)   
            ->editColumn('id', 'ID: {{$rece_id}}')
            ->addColumn('acciones', function ($recetas) {
                return '<div><button value="'.$stock_insumo->ins_id.'" id="buttonsol" class="btn btn-success insumo-get" onClick="MostrarCarrito()" data-toggle="modal" data-target="#myCreateRCA">+</button></div>';
            })->addColumn('solicitud_cantidad', function($recetas){
                return '<input class="form-control" type="number"></input>';
            })->addColumn('solicitud_costo', function($recetas){
                return '<input class="form-control" type="number"></input>';
            })->addColumn('solicitud_lote', function($recetas){
                return '<input class="form-control" type="number"></input>';
            })->addColumn('solicitud_fecha_vencimiento', function($recetas){
                return '<input class="form-control" type="number"></input>';
            })->addColumn('id_insumo', function($recetas){
                return '<input class="id_insumo form-control" type="hidden" value="'.$stock_insumo->ins_id.'"></input>';
            })
            ->make(true);
    }
    public function registrarIngresoPV(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as pl','public._bp_usuarios.usr_planta_id','=','pl.id_planta')
                              ->where('usr_id',Auth::user()->usr_id)->first();
        //dd($planta);
        $punto_venta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                              ->join('comercial.punto_venta_comercial as pvc', 'planta.id_planta','=','pvc.pv_id_planta')
                              ->where('usr_id','=',Auth::user()->usr_id)->first();
        //dd($punto_venta);
        $num = IngresoPv::join('public._bp_planta as plant', 'comercial.ingreso_punto_venta_comercial.ingpv_id_planta','=','plant.id_planta')->select(DB::raw('MAX(ingpv_nro_ingreso) as nro_ing'))->where('plant.id_planta', $planta->id_planta)->first();
        $cont=$num['nro_ing'];
        $noing = $cont + 1;
        $ingresopv = IngresoPv::create([
            'ingpv_origen_pv_id'    => $request['origen'],
            'ingpv_nro_ingreso'     => $noing,
            'ingpv_obs'             => $request['observacion'],
            'ingpv_usr_id'          => Auth::user()->usr_id,
            'ingpv_pv_id'           => $punto_venta->pv_id,
            'ingpv_id_planta'       => $planta->id_planta,
        ]);
        $detingreso = json_decode($request['datos_json']);
        foreach ($detingreso as $det) {
            $deting = DetalleIngresoPv::create([
                'detingpv_ingpv_id'     => $ingresopv->ingpv_id,
                'detingpv_prod_id'      => $det->producto_id,
                'detingpv_cantidad'     => $det->cantidad,
                'detingpv_costo'        => $det->costo,
                'detingpv_lote'         => $det->lote,
                'detingpv_fecha_venc'   => $det->fecha_vencimiento,
            ]);
            StockPv::create([         
                'stockpv_prod_id'       => $det->producto_id,
                'stockpv_detingpv_id'   => $deting->detingpv_id,
                'stockpv_cantidad'      => $det->cantidad,
                'stockpv_costo'         => $det->costo,
                'stockpv_lote'          => $det->lote,
                'stockpv_fecha_venc'    => $det->fecha_vencimiento,   
                'stockpv_pv_id'         => $punto_venta->pv_id,
                'stockpv_id_planta'     => $planta->id_planta,
            ]);
        }

        return response()->json($ingresopv);
    }
}
