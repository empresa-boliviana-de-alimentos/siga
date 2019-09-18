<?php

namespace siga\Http\Controllers\producto_terminado;

use siga\Http\Controllers\Controller;
use siga\Http\Modelo\ProductoTerminado\IngresoORP;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Http\Modelo\ProductoTerminado\IngresoCanastilla;
use siga\Http\Modelo\ProductoTerminado\despachoORP;
use siga\Modelo\admin\Usuario;
use Auth;
use DB;
use Yajra\Datatables\Datatables;	

class reporteAlmacenController extends Controller {
	public function inicio() {
		$planta = Usuario::join('public._bp_planta as pl','public._bp_usuarios.usr_planta_id','=','pl.id_planta')
						 ->where('usr_id',Auth::user()->usr_id)->first();
		$ingresoOrp = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
			->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
			->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id', 'ipt_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_usr_id')
			->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
			->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
			->orderBy('orprod_id', 'DESC')
			->where('orprod_tiporprod_id', 1)
			->Where('inp.ipt_estado', 'A')
			->where('orprod_estado_pt', 'I')
			->where('orprod_planta_id',$planta->id_planta)
			->orderBy('ipt_id','desc')
			->get();
		$ingresoCanastillos = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta')
				->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
				->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
				->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
				->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
				//->where('iac_estado', 'A')
				->where('iac_origen',$planta->id_planta)
				->where('iac_estado_baja', 'A')
				->orderBy('iac_id', 'desc')->get();
		$despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
			->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
			->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
			->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
			->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
			->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
			->where('dao_estado', 'A')
			->where('dao_tipo_orp', 1)
			->where('orprod_planta_id',$planta->id_planta)
			->orderBy('dao_id','desc')
			->get();

		$despachoPT = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
			->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
			->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
			->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
			->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
			->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
			->where('dao_estado', 'A')
			->where('dao_tipo_orp', 2)
			->where('orprod_planta_id',$planta->id_planta)
			->orderBy('dao_id','desc')
			->get();
		$datosCanastillas = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta', 'iac_usr_id', 'iac_origen', 'iac_fecha_salida', 'iac_codigo_salida')
			->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
			->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
			->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
			->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
			->where('iac_estado', 'D')
			->where('iac_estado_baja', 'A')
			->where('iac_origen',$planta->id_planta)
			->orderBy('iac_id', 'desc')
			->get();			
		//dd($datosCanastilla);
		return view('backend.administracion.producto_terminado.reporteAlmacen.index', compact('ingresoOrp','ingresoCanastillos','despachoORP','despachoPT','datosCanastillas'));
	}
	public function listarMesInventarioProductoTerminado($mes, $anio)
	{
		$planta = Usuario::join('public._bp_planta as pl','public._bp_usuarios.usr_planta_id','=','pl.id_planta')
						 ->where('usr_id',Auth::user()->usr_id)->first();
		$anio1 = $anio;
		$diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
		$fechainicial = $anio1 . "-" . $mes . "-01";
		$fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
		$stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
						->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
						->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
						->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
						->where('spth_registrado', '>=', $fechainicial)->where('spth_registrado', '<=', $fechafinal)
						->where('spth_planta_id',$planta->id_planta)
						->get();
		return Datatables::of($stockptMes)
			->make(true);
		//dd($stockptMes);
	}
	public function listarDiaInventarioProductoTerminado($dia,$mes,$anio)
	{
		$planta = Usuario::join('public._bp_planta as pl','public._bp_usuarios.usr_planta_id','=','pl.id_planta')
						 ->where('usr_id',Auth::user()->usr_id)->first();
		$dia = $anio . "-" . $mes . "-" . $dia;
		$stockptDia = DB::table('producto_terminado.stock_producto_terminado_historial')
						->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
						->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
						->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
						//->where('spth_registrado', '>=', $dia)->where('spth_registrado', '<=', $dia)
						->where(DB::raw('cast(stock_producto_terminado_historial.spth_registrado as date)'),'=',$dia)
						->where('spth_planta_id',$planta->id_planta)
						->get();
		//dd($stockptDia);
		return Datatables::of($stockptDia)
			->make(true);
	}
	public function listarRangoInventarioProductoTerminado($dia_inicio, $mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin)
	{
		$planta = Usuario::join('public._bp_planta as pl','public._bp_usuarios.usr_planta_id','=','pl.id_planta')
						 ->where('usr_id',Auth::user()->usr_id)->first();
		$fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
		$fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
		$stockptRango = DB::table('producto_terminado.stock_producto_terminado_historial')
						->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
						->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
						->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
						->where(DB::raw('cast(stock_producto_terminado_historial.spth_registrado as date)'), '>=', $fechainicial)
						->where(DB::raw('cast(stock_producto_terminado_historial.spth_registrado as date)'), '<=', $fechafinal)
						->where('spth_planta_id',$planta->id_planta)
						->get();
		return Datatables::of($stockptRango)
			->make(true);
	}
	public function incioReporteGeneral()
	{
		return view('backend.administracion.producto_terminado.reporteGeneralAlmacen.index');
	}
}
