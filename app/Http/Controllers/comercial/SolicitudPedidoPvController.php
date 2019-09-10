<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_registros\Insumo;
use siga\Modelo\insumo\insumo_recetas\Receta;
use siga\Modelo\admin\Usuario;
use Auth;
class SolicitudPedidoPvController extends Controller
{
    //SOLCITUD PEDIDO PUNTO DE VENTA
    public function index()
    {
    	return view('backend.administracion.comercial.solicitud_pedido_pv.index');
    }
    public function nuevaSolicitudPedidoPv()
    {
    	$listarProducto = Receta::leftjoin('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')
                                ->join('insumo.unidad_medida as umed','insumo.receta.rece_uni_id','=','umed.umed_id')->get();
        $solicitante = Usuario::join('public._bp_personas as prs','public._bp_usuarios.usr_prs_id','=','prs.prs_id')
                              ->where('usr_id',Auth::user()->usr_id)->first();
        $punto_venta = Usuario::join('public._bp_planta as pl','public._bp_usuarios.usr_planta_id','=','pl.id_planta')
                              ->where('usr_id',Auth::user()->usr_id)->first();
    	return view('backend.administracion.comercial.solicitud_pedido_pv.formNuevaSolicitudPedidoPv', compact('listarProducto','solicitante','punto_venta'));    
    }
    public function registrarSolicitudPedidoPv(Request $request)
    {
        return $request;
    }
    //SOLICITUD PEDIDO PRODUCCIÓN
    public function indexSolPedidoProdComercial()
    {
        //dd("INDEX SOLICITUD PEDIDO PRODUCCION");
        return view('backend.administracion.comercial.solicitud_pedido_prod.index');
    }
    public function nuevaSolicitudPedidoProd()
    {
        $listarProducto = Receta::leftjoin('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')
                                ->join('insumo.unidad_medida as umed','insumo.receta.rece_uni_id','=','umed.umed_id')->get();
        return view('backend.administracion.comercial.solicitud_pedido_prod.formNuevaSolicitudPedidoProd', compact('listarProducto'));
    }
    //SOLICITUDES RECIBIDAS DE PEDIDOS PUNTOS DE VENTA
    public function indexSolPedidoPvRecibidas()
    {
        //dd("PRUEBA DE SOLCITUDES RECIBIDAS");
        return view('backend.administracion.comercial.solicitud_recibida_pv.index');
    }
    public function verSolicitudPedidoPv($id)
    {
        return view('backend.administracion.comercial.solicitud_recibida_pv.verFormSolicitudRecibidaPedidoPv');
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
