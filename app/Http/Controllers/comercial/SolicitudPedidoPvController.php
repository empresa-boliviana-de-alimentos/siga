<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;

class SolicitudPedidoPvController extends Controller
{
    public function index()
    {
    	return view('backend.administracion.comercial.solicitud_pedido_pv.index');
    }
}
