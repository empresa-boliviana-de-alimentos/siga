<?php

namespace siga\Http\Controllers\acopio\acopio_lacteos;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use siga\Modelo\acopio\acopio_lacteos\ProveedorL;
use siga\Modelo\acopio\acopio_lacteos\AcopioCA;
use siga\Modelo\acopio\acopio_lacteos\AcopioGR;
use Auth;


class gbAcopiolistProv extends Controller
{
	 public function index()
    {   
        $fech= AcopioGR::getfecha();   
        $fecha= $fech['detlac_fecha_reg'];
    	$proveedor = ProveedorL::setBuscar(1068);
        return view ('backend.administracion.acopio.acopio_lacteos.acopio.listadomod', compact('proveedor','fecha'));
    }

    public function show()
    {   
    	$proveedor = ProveedorL::setBuscar(1068);
        return view ('backend.administracion.acopio.acopio_lacteos.acopio.listadomod', compact('proveedor'));
    }
}
