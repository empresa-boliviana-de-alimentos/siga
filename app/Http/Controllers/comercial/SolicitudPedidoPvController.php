<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_registros\Insumo;
use siga\Modelo\insumo\insumo_recetas\Receta;
use siga\Modelo\admin\Usuario;
use siga\Http\Modelo\comercial\Producto;
use siga\Http\Modelo\comercial\SolicitudPv;
use siga\Http\Modelo\comercial\DetalleSolicitudPv;
use DB;
use Auth;
class SolicitudPedidoPvController extends Controller
{
    //SOLCITUD PEDIDO PUNTO DE VENTA
    public function index()
    {
        $solproductos = SolicitudPv::orderBy('solpv_id','DESC')->get();
    	return view('backend.administracion.comercial.solicitud_pedido_pv.index', compact('solproductos'));
    }
    public function nuevaSolicitudPedidoPv()
    {
    	$listarProducto = Producto::join('insumo.receta as rece','comercial.producto_comercial.prod_rece_id','=','rece.rece_id')
                                ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                ->join('insumo.unidad_medida as umed','rece.rece_uni_id','=','umed.umed_id')
                                ->where('prod_codigo','<>',null)->get();
        $solicitante = Usuario::join('public._bp_personas as prs','public._bp_usuarios.usr_prs_id','=','prs.prs_id')
                              ->where('usr_id',Auth::user()->usr_id)->first();
        $punto_venta = Usuario::join('public._bp_planta as pl','public._bp_usuarios.usr_planta_id','=','pl.id_planta')
                              ->where('usr_id',Auth::user()->usr_id)->first();
    	return view('backend.administracion.comercial.solicitud_pedido_pv.formNuevaSolicitudPedidoPv', compact('listarProducto','solicitante','punto_venta'));    
    }
    public function registrarSolicitudPedidoPv(Request $request)
    {
        $punto_venta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                              ->join('comercial.punto_venta_comercial as pvc', 'planta.id_planta','=','pvc.pv_id_planta')
                              ->select('pvc.pv_nombre','pvc.pv_id','planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $num = SolicitudPv::join('public._bp_planta as plant', 'comercial.solicitud_pv_comercial.solpv_id_planta','=','plant.id_planta')->select(DB::raw('MAX(solpv_nro_solicitud) as nro_sol'))->where('plant.id_planta', $punto_venta->id_planta)->first();
        $cont=$num['nro_sol'];
        $nosol = $cont + 1;
        $solpv = SolicitudPv::create([
            'solpv_pv_id'               => $punto_venta->pv_id,
            'solpv_id_planta'           => $punto_venta->id_planta,
            'solpv_nro_solicitud'       => $nosol,
            'solpv_usr_id'              => Auth::user()->usr_id,
            'solpv_obs'                 => $request['observacion'],
            'solpv_descripestado_recep' => 'ENVIADO A ENCARGADO'    
        ]);
        $solproductos = json_decode($request->productos);
        foreach ($solproductos as $solproducto) {
            DetalleSolicitudPv::create([
                'detsolpv_solpv_id' => $solpv->solpv_id,
                'detsolpv_prod_id'  => $solproducto->id,
                'detsolpv_cantidad' => $solproducto->cantidad
            ]);
        }
        return redirect('SolPedidoPvComercial')->with('success','Registro creado satisfactoriamente');
    }
    //SOLICITUD PEDIDO PRODUCCIÓN
    public function indexSolPedidoProdComercial()
    {
        //dd("INDEX SOLICITUD PEDIDO PRODUCCION");
        return view('backend.administracion.comercial.solicitud_pedido_prod.index');
    }
    public function nuevaSolicitudPedidoProd()
    {
        $listarProducto = Producto::join('insumo.receta as rece','comercial.producto_comercial.prod_rece_id','=','rece.rece_id')
                                ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                ->join('insumo.unidad_medida as umed','rece.rece_uni_id','=','umed.umed_id')
                                ->where('prod_codigo','<>',null)->get();
        return view('backend.administracion.comercial.solicitud_pedido_prod.formNuevaSolicitudPedidoProd', compact('listarProducto'));
    }
    //SOLICITUDES RECIBIDAS DE PEDIDOS PUNTOS DE VENTA
    public function indexSolPedidoPvRecibidas()
    {
        $solpvs = SolicitudPv::orderBY('solpv_id','DESC')->get(); 
        return view('backend.administracion.comercial.solicitud_recibida_pv.index', compact('solpvs'));
    }
    public function verSolicitudPedidoPv($id)
    {
        $solpv = SolicitudPv::join('public._bp_usuarios as usr','comercial.solicitud_pv_comercial.solpv_usr_id','=','usr.usr_id')
                            ->join('public._bp_personas as prs','usr.usr_prs_id','=','prs_id')
                            ->where('solpv_id',$id)->first();
        $detsolpv = DetalleSolicitudPv::join('comercial.producto_comercial as prod','comercial.detalle_solicitud_pv_comercial.detsolpv_prod_id','=','prod.prod_id')
                                      ->join('insumo.receta as rece','prod.prod_rece_id','=','rece.rece_id')
                                      ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                      ->join('insumo.unidad_medida as umed','rece.rece_uni_id','=','umed.umed_id')
                                      ->where('detsolpv_solpv_id',$id)->get();
        //dd($detsolpv);
        $punto_venta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                              ->join('comercial.punto_venta_comercial as pvc', 'planta.id_planta','=','pvc.pv_id_planta')
                              ->select('pvc.pv_nombre','pvc.pv_id','planta.id_planta')->where('usr_id','=',$solpv->solpv_usr_id)->first();
        return view('backend.administracion.comercial.solicitud_recibida_pv.verFormSolicitudRecibidaPedidoPv', compact('solpv','detsolpv','punto_venta'));
    }
    public function registrarAprobSolicitudPedidoPv(Request $request)
    {
        $solpv_aprob = SolicitudPv::find($request['solpv_id']);
        $solpv_aprob->solpv_usr_aprob = Auth::user()->usr_id;
        $solpv_aprob->solpv_obs_aprob = $request['observacion'];
        $solpv_aprob->solpv_descripestado_recep = 'APROBADO';
        $solpv_aprob->solpv_estado_recep = 'B';
        $solpv_aprob->save();

        return redirect('SolRecibidasPvComercial')->with('success','Registro creado satisfactoriamente');
    }
    //SOLICITUDES RECIBIDAS DE PEDIDOS DE PRODUCCION
    public function indexSolPedidoProdRecibidas()
    {
        return view('backend.administracion.comercial.solicitud_recibida_prod.index');
    }
    public function verSolicitudPedidoProd($id)
    {
        //dd("FORMULARIO SOLICITUD DE PEDIDO PRODUCCION");
        return view('backend.administracion.comercial.solicitud_recibida_prod.verFormSolicitudRecibidaPedidoProd');
    } 
}
