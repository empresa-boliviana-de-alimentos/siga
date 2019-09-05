<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;

class IngresoPuntoVentaController extends Controller
{
    public function index()
    {
    	//dd("INGRESO PRODUCTOS PUNTO DE VENTA");
    	return view('backend.administracion.comercial.ingreso_punto_venta.index');
    }
}
