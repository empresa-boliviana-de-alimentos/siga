<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_registros\Insumo;
use siga\Modelo\insumo\insumo_recetas\Receta;
class SolicitudPedidoPvController extends Controller
{
    public function index()
    {
    	return view('backend.administracion.comercial.solicitud_pedido_pv.index');
    }
    public function nuevaSolicitudPedidoPv()
    {
    	$listarInsumo = Insumo::with('unidad_medida')->leftjoin('insumo.sabor as sab','insumo.insumo.ins_id_sabor','=','sab.sab_id')
                                ->where('ins_id_tip_ins',1)->orWhere('ins_id_tip_ins',3)->get();
    	return view('backend.administracion.comercial.solicitud_pedido_pv.formNuevaSolicitudPedidoPv', compact('listarInsumo'));    
    }
}
