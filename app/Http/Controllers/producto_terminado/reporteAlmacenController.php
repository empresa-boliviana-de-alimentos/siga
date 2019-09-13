<?php

namespace siga\Http\Controllers\producto_terminado;

use siga\Http\Controllers\Controller;

class reporteAlmacenController extends Controller {
	public function inicio() {
		return view('backend.administracion.producto_terminado.reporteAlmacen.index');
	}
}
