<?php

namespace siga\Http\Controllers\producto_terminado;

use siga\Http\Controllers\Controller;
use siga\Http\Modelo\acopio\acopio_lacteos\Vehiculo;
use siga\Modelo\admin\EstadoCivil;

class TransportistaController extends Controller {
	public function index() {
		$data = EstadoCivil::combo();
		$vehiculo = Vehiculo::select()->pluck('veh_placa', 'veh_id');
		return view('backend.administracion.producto_terminado.datos.transportista.index', compact('data', 'vehiculo'));
	}
}
