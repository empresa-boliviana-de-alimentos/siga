<?php

namespace siga\Http\Controllers\producto_terminado;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;

class CanastilloController extends Controller
{
    public function index()
    {
    	return view('backend.administracion.producto_terminado.datos.canastillos.index');
    }
}
