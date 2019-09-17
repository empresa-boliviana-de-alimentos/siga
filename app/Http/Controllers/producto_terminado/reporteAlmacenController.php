<?php

namespace siga\Http\Controllers\producto_terminado;

use siga\Http\Controllers\Controller;
use siga\Http\Modelo\ProductoTerminado\IngresoORP;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Http\Modelo\ProductoTerminado\IngresoCanastilla;
use DB;	

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
		$ingresoCanastillos = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta')
				->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
				->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
				->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
				->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
				//->where('iac_estado', 'A')
				->where('iac_estado_baja', 'A')
				->orderBy('iac_id', 'desc')->get();
		//dd($ingresoCanastillos);
		return view('backend.administracion.producto_terminado.reporteAlmacen.index', compact('ingresoOrp','ingresoCanastillos'));
	}
}
