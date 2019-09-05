<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;

class PuntoVentaController extends Controller
{
    public function index()
    {
    	//dd("PUNTOS DE VENTA");
    	return view('backend.administracion.comercial.punto_venta.index');
    }
    public function nuevoPuntoVenta()
    {
    	return view('backend.administracion.comercial.punto_venta.nuevoFormPuntoVenta');
    }
}
