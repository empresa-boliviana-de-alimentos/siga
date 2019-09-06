<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;

class SalidaPuntoVentaController extends Controller
{
    public function index()
    {
    	//dd("SALIDAS PUNTO DE VENTA");
    	return view('backend.administracion.comercial.salida_pv.index');
    }
}
