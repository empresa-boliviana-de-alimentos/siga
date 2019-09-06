<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_recetas\Receta;

class TraspasoPuntoVentaController extends Controller
{
    public function index()
    {
    	return view('backend.administracion.comercial.traspaso_pv.index');
    }
    public function carritoSolicitudTraspaso()
    {
    	$recetas = Receta::leftjoin('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')->get();
    	return view('backend.administracion.comercial.traspaso_pv.carritoSolicitudTraspaso', compact('recetas'));
    }
}
