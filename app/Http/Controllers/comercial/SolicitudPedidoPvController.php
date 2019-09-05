<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_registros\Insumo;
use siga\Modelo\insumo\insumo_recetas\Receta;
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
    	return view('backend.administracion.comercial.solicitud_pedido_pv.formNuevaSolicitudPedidoPv', compact('listarProducto'));    
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
}
