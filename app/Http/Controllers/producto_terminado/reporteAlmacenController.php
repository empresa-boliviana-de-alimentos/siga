<?php

namespace siga\Http\Controllers\producto_terminado;

use siga\Http\Controllers\Controller;
use siga\Http\Modelo\ProductoTerminado\IngresoORP;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;

class reporteAlmacenController extends Controller {
	public function inicio() {
		$ingresoOrp = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
			->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
			->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id', 'ipt_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_usr_id')
			->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
			->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
			->orderBy('orprod_id', 'DESC')
			->where('orprod_tiporprod_id', 1)
			->Where('inp.ipt_estado', 'A')
			->where('orprod_estado_pt', 'I')
			->get();
		//dd($ingresoOrp);
		return view('backend.administracion.producto_terminado.reporteAlmacen.index', compact('ingresoOrp'));
	}
}
