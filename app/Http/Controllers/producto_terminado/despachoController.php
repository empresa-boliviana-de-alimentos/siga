<?php

namespace siga\Http\Controllers\producto_terminado;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Http\Modelo\ProductoTerminado\Correlativo;
use siga\Http\Modelo\ProductoTerminado\despachoORP;
use siga\Http\Modelo\ProductoTerminado\IngresoCanastilla;
use siga\Http\Modelo\ProductoTerminado\IngresoORP;
use siga\Http\Modelo\ProductoTerminado\stock_pt;
use siga\Modelo\admin\Usuario;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Http\Modelo\ProductoTerminado\ProductoTerminadoHistorial;
use Yajra\Datatables\Datatables;

class despachoController extends Controller {

	public function index() {
		$planta = \DB::table('_bp_planta')->OrderBy('id_planta', 'desc')->get();
		$despacho = \DB::table('producto_terminado.destino')->OrderBy('de_id', 'asc')->pluck('de_nombre', 'de_id');
		//return response()->json($despacho);
		return view('backend.administracion.producto_terminado.despacho.index', compact('planta', 'despacho'));
	}

	public function create() {

	}

	public function store(Request $request) {

	}

	public function show($id) {

	}

	public function edit($id) {

	}

	public function update(Request $request, $id) {

	}

	public function destroy($id) {

	}

	public function listarCanastillaDespacho() {
		$ids_usr = Auth::user()->usr_id;
		try {
			$IngresoCanastilla = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta')
				->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
				->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
				->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
				->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
				->where('iac_estado', 'A')
				->get();
			return response()->json(["success" => "true", "mensaje" => "El listado se desplego Correctamente", "data" => $IngresoCanastilla]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo consultar los datos intente nuevamente", "data" => $ex]);
		}
	}
	public function listarORPInicial() {
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->select('planta.id_planta')->where('usr_id', '=', Auth::user()->usr_id)->first();
		$orden_produccion = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
			->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
			->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id', 'ipt_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_usr_id')
			->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
			->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
			->orderBy('orprod_id', 'DESC')
			->where('orprod_tiporprod_id', 1)
			->where('inp.ipt_estado', 'A')
			->where('orprod_estado_orp', 'D')
			->where('orprod_planta_id',$planta->id_planta)
			->get();
		return Datatables::of($orden_produccion)
			->addColumn('acciones', function ($nombreReceta) {
				return '<button value="' . $nombreReceta->ipt_id . '" class="btn-round btn-xs btn-info" onClick="obtenerORP(this);" data-toggle="modal" data-target="#modalORPDespacho"><i class="fa fa-sign-out fa-2x"></i></button>';
			})
			->addColumn('nombreReceta', function ($nombreReceta) {
				return $nombreReceta->rece_nombre . ' ' . $nombreReceta->sab_nombre . ' ' . $nombreReceta->rece_presentacion;
			})->addColumn('lineaProduccion', function ($lineaProduccion) {
			if ($lineaProduccion->rece_lineaprod_id == 1) {
				return 'LACTEOS';
			} elseif ($lineaProduccion->rece_lineaprod_id == 2) {
				return 'ALMENDRA';
			} elseif ($lineaProduccion->rece_lineaprod_id == 3) {
				return 'MIEL';
			} elseif ($lineaProduccion->rece_lineaprod_id == 4) {
				return 'FRUTOS';
			} elseif ($lineaProduccion->rece_lineaprod_id == 5) {
				return 'DERIVADOS';
			}
		})->addColumn('usuario', function ($usuario_ingreso) {
			return $this->traeUser($usuario_ingreso->ipt_usr_id);
		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->make(true);
	}
	function traeUser($id_user) {
		$user_datos = Usuario::join('public._bp_personas as per', 'public._bp_usuarios.usr_prs_id', '=', 'per.prs_id')
			->where('usr_id', $id_user)
			->first();
		//dd($id_user);
		return $user_datos->prs_nombres . ' ' . $user_datos->prs_paterno . ' ' . $user_datos->prs_materno;
	}

	public function obtenerORPIngreso($id) {
		try {
			setlocale(LC_ALL, "es_ES");
			\Carbon\Carbon::setLocale('es');
			$ingresoORP = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
				->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
				->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id')
				->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
				->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
				->where('orprod_tiporprod_id', 1)
				->whereIn('inp.ipt_estado', ['A', 'D'])
				->where('orprod_estado_orp', 'D')
				->where('inp.ipt_id', $id)
				->first();
			$date = new Carbon();
			$fecha_despacho = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $date);
			return response()->json(["success" => "true", "mensaje" => "La parametrica se actualizo correctamente", "data" => $ingresoORP, "fecha_despacho" => $fecha_despacho]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo actualizar la parametrica intente nuevamente", "data" => $ex]);
		}
	}

	public function registrarDespachoORP(Request $request) {
		$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
		$datetime = new Carbon();
		$fecha_actual = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $datetime);
		$ids = Auth::user()->usr_id;
		try {
			$despachoORP = despachoORP::create([
				'dao_ipt_id' => $request['ipt_id'],
				'dao_de_id' => $request['ipt_despacho_id'],
				'dao_cantidad' => $request['ipt_cantidad_enviar'],
				'dao_fecha_despacho' => $request['ipt_fecha_despacho'],
				'dao_usr_id' => $ids,
				'dao_tipo_orp' => 1,
				'dao_estado' => 'A',
			]);
			$ipt = IngresoORP::where('ipt_id',$request['ipt_id'])->first();
			/*PRODUCTO TERMINADO HISTORIAL*/
			ProductoTerminadoHistorial::create([
				'pth_planta_id' 		=> $planta->id_planta,
				'pth_rece_id'			=> $request['rece_id'],
				'pth_ipt_id'			=> $request['ipt_id'],
				'pth_dao_id'			=> $despachoORP->dao_id,
				'pth_tipo'				=> 2,
				'pth_cantidad'			=> $request['ipt_cantidad_enviar'],
				'pth_fecha_vencimiento'	=> $ipt->ipt_fecha_vencimiento,
				'pth_lote'				=> $ipt->ipt_lote,
				'pth_estado'			=> 'A',
			]);
			/*END PRODUCTO TERMINADO*/
			Correlativo::where('corr_codigo', 'SALIDA')->where('corr_tpd_id', $request->ipt_id_planta)
				->increment('corr_correlativo', 1);
			$sqlPedido = Correlativo::select()
				->join('public._bp_planta as planta', 'corr_tpd_id', '=', 'planta.id_planta')
				->where('corr_codigo', 'SALIDA')
				->where('corr_tpd_id', $request->ipt_id_planta)
				->where('corr_estado', 'A')
				->first();
			$codigoSalida = '-SAL-' . str_pad($sqlPedido->corr_correlativo, 5, '0', STR_PAD_LEFT);
			$ingresoORP = IngresoORP::select()->where('ipt_id', $request['ipt_id'])->update(['ipt_estado' => 'D', 'ipt_sobrante' => $request['ipt_cantidad_stock']]);
			$despachoORPUpdate = despachoORP::select()->where('dao_id', $despachoORP->dao_id)->update(['dao_codigo_salida' => $codigoSalida]);
			$sqlstock = stock_pt::select()
				->join('insumo.receta as rece', 'spt_rece_id', '=', 'rece.rece_id')
				->Where('spt_estado', 'A')
				->where('spt_rece_id', $request['rece_id'])
				->where('spt_planta_id', $request->ipt_id_planta)
				->first();
			$restoStock = $sqlstock->spt_cantidad - $request['ipt_cantidad_enviar']; //return response()->json($sqlstock);
			//return response()->json(['sqlstock' => $sqlstock, 'resto' => $restoStock, 'resto2' => $request['ipt_cantidad_enviar']]);
			$stockUpdate = stock_pt::select()->where('spt_id', $sqlstock->spt_id)->update(['spt_cantidad' => $restoStock, 'spt_fecha' => $fecha_actual]);
			return response()->json(["success" => "true", "mensaje" => "Se registro el despacho orden de produccion", "data" => $ingresoORP]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo registrar el despacho orden de produccion", "data" => $ex]);
		}
	}

	public function listarDespachoORP() {
		//$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
		//	->select('planta.id_planta')->where('usr_id', '=', Auth::user()->usr_id)->first();
		$despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo')
			->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
			->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
			->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
			->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
			->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
			->where('dao_estado', 'A')
			->where('dao_tipo_orp', 1)
			//->where('orp.orprod_planta_id',$planta->id_planta)
			->get();
		return Datatables::of($despachoORP)
			->addColumn('acciones', function ($nombreReceta) {
				return '<button value="' . $nombreReceta->ipt_id . '" class="btn-round btn-xs btn-info" onClick="obtenerORP(this);" data-toggle="modal" data-target="#modalORPDespacho"><i class="fa fa-sign-out fa-2x"></i></button>';
			})
			->addColumn('nombreReceta', function ($nombreReceta) {
				return $nombreReceta->rece_nombre . ' ' . $nombreReceta->sab_nombre . ' ' . $nombreReceta->rece_presentacion;
			})->addColumn('lineaProduccion', function ($lineaProduccion) {
			if ($lineaProduccion->rece_lineaprod_id == 1) {
				return 'LACTEOS';
			} elseif ($lineaProduccion->rece_lineaprod_id == 2) {
				return 'ALMENDRA';
			} elseif ($lineaProduccion->rece_lineaprod_id == 3) {
				return 'MIEL';
			} elseif ($lineaProduccion->rece_lineaprod_id == 4) {
				return 'FRUTOS';
			} elseif ($lineaProduccion->rece_lineaprod_id == 5) {
				return 'DERIVADOS';
			}
		})->addColumn('usuario', function ($usuario_despacho) {
			return $this->traeUser($usuario_despacho->dao_usr_id);
		})
			->make(true);
	}

	public function registrarDespachoCanastilla(Request $request) {
		$ids = Auth::user()->usr_id;
		try {
			$despachoORP = despachoORP::create([
				'dao_ipt_id' => $request['ipt_id'],
				'dao_de_id' => $request['ipt_despacho_id'],
				'dao_cantidad' => $request['ipt_cantidad_'],
				'dao_fecha_despacho' => Carbon::now(),
				'dao_usr_id' => $ids,
				'dao_estado' => 'A',
			]);
			Correlativo::where('corr_codigo', 'SALIDA')->where('corr_tpd_id', $request->ipt_id_planta)
				->increment('corr_correlativo', 1);
			$sqlPedido = Correlativo::select()
				->join('public._bp_planta as planta', 'corr_tpd_id', '=', 'planta.id_planta')
				->where('corr_codigo', 'SALIDA')
				->where('corr_tpd_id', $request->ipt_id_planta)
				->where('corr_estado', 'A')
				->first();
			$codigoSalida = $sqlPedido->codigo_planta . '-SAL-' . str_pad($sqlPedido->corr_correlativo, 5, '0', STR_PAD_LEFT);
			$ingresoORP = IngresoORP::select()->where('ipt_id', $request['ipt_id'])->update(['ipt_estado', 'A']);
			$despachoORPUpdate = despachoORP::select()->where('dao_id', $despachoORP->dao_id)->update(['dao_codigo_salida' => $codigoSalida]);
			return response()->json(["success" => "true", "mensaje" => "Se registro el despacho orden de produccion", "data" => $sqlPedido]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo registrar el despacho orden de produccion", "data" => $ex]);
		}
	}

	public function lstProductoTerminado() {
		/*$ingresoORP = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
			->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
			->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id')
			->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
			->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
			->orderBy('orprod_id', 'DESC')
			->where('orprod_tiporprod_id', 1)
			->where('inp.ipt_estado', 'D')
			->where('orprod_estado_orp', 'D')
			->where('inp.ipt_sobrante', '>', 0)
			->where('orprod_rece_id', '=', 1)
			->get();
		return response()->json($ingresoORP);*/
		$producto_terminado = \DB::select('select * from producto_terminado.sp_listado_sobrantes()');
		$sql = collect($producto_terminado);
		return Datatables::of($sql)
			->addColumn('acciones', function ($nombreReceta) {
				return '<button value="' . $nombreReceta->xipt_id . '" class="btn-round btn-xs btn-danger" onClick="obtenerPT(this,' . $nombreReceta->xtotal . ',' . $nombreReceta->xorprod_rece_id . ');" data-toggle="modal" data-target="#modalPTDespacho"><i class="fa fa-sign-out fa-2x"></i></button>';
			})
			->addColumn('nombreReceta', function ($nombreReceta) {
				return $nombreReceta->xrece_nombre . ' ' . $nombreReceta->xsab_nombre . ' ' . $nombreReceta->xrece_presentacion;
			})->addColumn('lineaProduccion', function ($lineaProduccion) {
			if ($lineaProduccion->xrece_lineaprod_id == 1) {
				return 'LACTEOS';
			} elseif ($lineaProduccion->xrece_lineaprod_id == 2) {
				return 'ALMENDRA';
			} elseif ($lineaProduccion->xrece_lineaprod_id == 3) {
				return 'MIEL';
			} elseif ($lineaProduccion->xrece_lineaprod_id == 4) {
				return 'FRUTOS';
			} elseif ($lineaProduccion->xrece_lineaprod_id == 5) {
				return 'DERIVADOS';
			}
		})->addColumn('usuario', function ($usuario_ingreso) {
			return $this->traeUser($usuario_ingreso->xipt_usr_id);
		})
			->make(true);
	}

	public function obtenerPTDespacho($id) {
		try {
			$ingresoORP = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
				->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
				->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id')
				->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
				->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
				->where('orprod_tiporprod_id', 1)
				->whereIn('inp.ipt_estado', ['A', 'D'])
				->where('orprod_estado_orp', 'D')
				->where('inp.ipt_id', $id)
				->first();
			$date = new Carbon();
			$fecha_despacho = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $date);
			return response()->json(["success" => "true", "mensaje" => "La parametrica se actualizo correctamente", "data" => $ingresoORP, "fecha_despacho" => $fecha_despacho]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo actualizar la parametrica intente nuevamente", "data" => $ex]);
		}
	}

	public function registrarDespachoPT(Request $request) {
		
		//return response()->json($request->all());
		$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
		$datetime = new Carbon();
		$fecha_actual = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $datetime);
		$ids = Auth::user()->usr_id;
		try {
			$ingresoORP = IngresoORP::create([
				'ipt_orprod_id' => $request['ipt_orprod_id'],
				'ipt_cantidad' => $request['ipt_sobrante_pt'],
				'ipt_lote' => strtoupper($request['ipt_lote']),
				'ipt_hora_falta' => $request['ipt_hora_falta'],
				'ipt_fecha_vencimiento' => $request['ipt_fecha_vencimiento'],
				'ipt_costo_unitario' => $request['ipt_costo_unitario'],
				'ipt_observacion' => 'SE AGREGO EL SOBRANTE A ESTE NUEVO INGRESO',
				'ipt_usr_id' => $ids,
				'ipt_sobrante' => 0,
				'ipt_estado' => 'D',
				'ipt_estado_baja' => 'A',
			]);
			//$ipt = IngresoORP::where('ipt_id',$request['ipt_id_pt'])->first();
			$despachoORP = despachoORP::create([
				'dao_ipt_id' => $request['ipt_id_pt'],
				'dao_de_id' => $request['ipt_despacho_id_pt'],
				'dao_cantidad' => $request['ipt_sobrante_pt'],
				'dao_fecha_despacho' => $request['ipt_fecha_despacho_pt'],
				'dao_tipo_orp' => 2,
				'dao_usr_id' => $ids,
				'dao_estado' => 'A',
			]);
			$receta = IngresoORP::join('insumo.orden_produccion as orp','producto_terminado.ingreso_almacen_orp.ipt_orprod_id','=','orp.orprod_id')
								->join('insumo.receta as rece','orp.orprod_rece_id','=','rece.rece_id')
								->where('ipt_id',$request['ipt_id_pt'])->first(); 
			/*PRODUCTO TERMINADO HISTORIAL*/
			/*ProductoTerminadoHistorial::create([
				'pth_planta_id' 		=> $planta->id_planta,
				'pth_rece_id'			=> $receta->rece_id,
				'pth_ipt_id'			=> $request['ipt_id_pt'],
				'pth_dao_id'			=> $despachoORP->dao_id,
				'pth_tipo'				=> 2,
				'pth_cantidad'			=> $request['ipt_sobrante_pt'],
				'pth_fecha_vencimiento'	=> $receta->ipt_fecha_vencimiento,
				'pth_lote'				=> $receta->ipt_lote,
				'pth_estado'			=> 'A',
			]);*/
			/*END PRODUCTO TERMINADO*/
			Correlativo::where('corr_codigo', 'SALIDA')->where('corr_tpd_id', $request->ipt_planta_pt)
				->increment('corr_correlativo', 1);
			$sqlPedido = Correlativo::select()
				->join('public._bp_planta as planta', 'corr_tpd_id', '=', 'planta.id_planta')
				->where('corr_codigo', 'SALIDA')
				->where('corr_tpd_id', $request->ipt_planta_pt)
				->where('corr_estado', 'A')
				->first();
			$codigoSalida = $sqlPedido->codigo_planta . '-SAL-' . str_pad($sqlPedido->corr_correlativo, 5, '0', STR_PAD_LEFT);
			$ingresoORP = IngresoORP::join('insumo.orden_produccion as orp1', 'orp1.orprod_id', '=', 'ipt_orprod_id')
				->join('insumo.receta as rece', 'orp1.orprod_rece_id', '=', 'rece.rece_id')
				->join('public._bp_planta as planta', 'orp1.orprod_planta_id', '=', 'planta.id_planta')
				->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id')
				->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
				->where('orprod_tiporprod_id', 1)
				->where('ipt_estado', 'D')
				->where('orp1.orprod_estado_orp', 'D')
				->where('ipt_sobrante', '>', 0)
				->where('orp1.orprod_rece_id', '=', $request->idreceta_pt)
				//->update(['ipt_sobrante' => 0]);
				->orderBy('ipt_id','asc')
				->get();
			$cantidad_aprobada = $request['ipt_despacho'];
			foreach ($ingresoORP as $ing) {
				if ($cantidad_aprobada>0) {
					if ($cantidad_aprobada >= $ing->ipt_sobrante) {
	                    $cantidad_aprobada = $cantidad_aprobada - $ing->ipt_sobrante;
	                    $descuento = $ing->ipt_sobrante;
	                    $ing->ipt_sobrante = 0;
	                }else
	                {
	                    $ing->ipt_sobrante = $ing->ipt_sobrante - $cantidad_aprobada;
	                    $descuento = $cantidad_aprobada;
	                    $cantidad_aprobada = 0;
	                }
	                $ingreso = IngresoORP::where('ipt_id',$ing->ipt_id)->first();
	                $ingreso->ipt_sobrante = $ing->ipt_sobrante;
	                $ingreso->save();
					/*PRODUCTO TERMINADO HISTORIAL*/
					ProductoTerminadoHistorial::create([
						'pth_planta_id' 		=> $planta->id_planta,
						'pth_rece_id'			=> $receta->rece_id,
						'pth_ipt_id'			=> $ing->ipt_id,
						'pth_dao_id'			=> $despachoORP->dao_id,
						'pth_tipo'				=> 2,
						'pth_cantidad'			=> $descuento,
						'pth_fecha_vencimiento'	=> $receta->ipt_fecha_vencimiento,
						'pth_lote'				=> $receta->ipt_lote,
						'pth_estado'			=> 'A',
					]);
					/*END PRODUCTO TERMINADO*/
				}
			}
			/*IngresoORP::join('insumo.orden_produccion as orp1', 'orp1.orprod_id', '=', 'ipt_orprod_id')
				->join('insumo.receta as rece', 'orp1.orprod_rece_id', '=', 'rece.rece_id')
				->join('public._bp_planta as planta', 'orp1.orprod_planta_id', '=', 'planta.id_planta')
				->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id')
				->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
				->where('orprod_tiporprod_id', 1)
				->where('ipt_estado', 'D')
				->where('orp1.orprod_estado_orp', 'D')
				->where('ipt_sobrante', '>', 0)
				->where('orp1.orprod_rece_id', '=', $request->idreceta_pt)
				->update(['ipt_sobrante' => 0]);*/
			$sqlstock = stock_pt::select()
				->join('insumo.receta as rece', 'spt_rece_id', '=', 'rece.rece_id')
				->Where('spt_estado', 'A')
				->where('spt_rece_id', $request['idreceta_pt'])
				->where('spt_costo_unitario', $request['ipt_costo_unitario'])
				->where('spt_planta_id', $request->ipt_planta_pt)
				->first();
			$restoStock = $sqlstock->spt_cantidad - $request['ipt_despacho'];
			$stockUpdate = stock_pt::select()->where('spt_id', $sqlstock->spt_id)->update(['spt_cantidad' => $restoStock, 'spt_fecha' => $fecha_actual]);
			$despachoORPUpdate = despachoORP::select()->where('dao_id', $despachoORP->dao_id)->update(['dao_codigo_salida' => $codigoSalida]);
			return response()->json(["success" => "true", "mensaje" => "Se registro el despacho orden de produccion", "data" => $ingresoORP]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo registrar el despacho orden de produccion", "data" => $ex]);
		}
	}

	public function listaDespachoPT() {
		$despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo')
			->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
			->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
			->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
			->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
			->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
			->where('dao_estado', 'A')
			->where('dao_tipo_orp', 2)
			->get();
		return Datatables::of($despachoORP)
			->addColumn('acciones', function ($nombreReceta) {
				return '<button value="' . $nombreReceta->ipt_id . '" class="btn-round btn-xs btn-info" onClick="obtenerORP(this);" data-toggle="modal" data-target="#modalORPDespacho"><i class="fa fa-sign-out fa-2x"></i></button>';
			})
			->addColumn('nombreReceta', function ($nombreReceta) {
				return $nombreReceta->rece_nombre . ' ' . $nombreReceta->sab_nombre . ' ' . $nombreReceta->rece_presentacion;
			})->addColumn('lineaProduccion', function ($lineaProduccion) {
			if ($lineaProduccion->rece_lineaprod_id == 1) {
				return 'LACTEOS';
			} elseif ($lineaProduccion->rece_lineaprod_id == 2) {
				return 'ALMENDRA';
			} elseif ($lineaProduccion->rece_lineaprod_id == 3) {
				return 'MIEL';
			} elseif ($lineaProduccion->rece_lineaprod_id == 4) {
				return 'FRUTOS';
			} elseif ($lineaProduccion->rece_lineaprod_id == 5) {
				return 'DERIVADOS';
			}
		})->addColumn('usuario', function ($usuario_despacho) {
			return $this->traeUser($usuario_despacho->dao_usr_id);
		})
			->make(true);
	}

	public function lstCanastillosG() {
		$ids_usr = Auth::user()->usr_id;
		try {
			$IngresoCanastilla = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta', 'iac_usr_id')
				->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
				->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
				->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
				->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
				->where('iac_estado', 'A')
				->orderBy('iac_id', 'desc')
				->get();
			return Datatables::of($IngresoCanastilla)
				->addColumn('acciones', function ($IngresoCanastilla) {
					return '<button value="' . $IngresoCanastilla->iac_id . '" class="btn-round btn-xs btn-info" onClick="obtenerDatosCanastillo(this);" data-toggle="modal" data-target="#modalCanastilloDespacho"><i class="fa fa-sign-out fa-2x"></i></button>';
				})->addColumn('usuario', function ($usuario_despacho) {
				return $this->traeUser($usuario_despacho->iac_usr_id);
			})->editColumn('ctl_foto_canastillo', '@if($ctl_foto_canastillo==null)
							<img src=archivo/canastillo/sinfoto.png style="height:50px;width:50px;"/>
						@else
							<img src=archivo/canastillo/{{$ctl_foto_canastillo}} style="height:50px;width:50px;"/>
						@endif')
				->make(true);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo consultar los datos intente nuevamente", "data" => $ex]);
		}
	}

	public function obtenerDatosCanastillo($id) {
		$date = new Carbon();
		$fecha_despacho = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $date);
		try {
			$datosCanastilla = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta', 'iac_usr_id', 'iac_origen')
				->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
				->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
				->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
				->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
				->where('iac_id', $id)
				->where('iac_estado', 'A')
				->where('iac_estado_baja', 'A')
				->orderBy('iac_id', 'desc')
				->first();
			return response()->json(["success" => "true", "mensaje" => "Se obtuvo el dato de la canastilla", "data" => $datosCanastilla, "fecha_despacho" => $fecha_despacho]);

		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo consultar los datos intente nuevamente", "data" => $ex]);
		}
	}

	public function regCanastillaDespacho(Request $request) {
		$ids = Auth::user()->usr_id;
		try {
			Correlativo::where('corr_codigo', 'SALIDA_CANASTILLA')->where('corr_tpd_id', $request->iac_planta_id)
				->increment('corr_correlativo', 1);
			$sqlPedido = Correlativo::select()
				->join('public._bp_planta as planta', 'corr_tpd_id', '=', 'planta.id_planta')
				->where('corr_codigo', 'SALIDA_CANASTILLA')
				->where('corr_tpd_id', $request->iac_planta_id)
				->where('corr_estado', 'A')
				->first();
			$codigoSalida = $sqlPedido->codigo_planta . '-SAL-' . str_pad($sqlPedido->corr_correlativo, 5, '0', STR_PAD_LEFT);
			$update_canastilla = IngresoCanastilla::select()->where('iac_id', $request->iac_id)
				->update(['iac_estado' => 'D', 'iac_fecha_salida' => $request->iac_fecha_despacho, 'iac_de_id' => $request->iac_de_id, 'iac_codigo_salida' => $codigoSalida]);
			return response()->json(["success" => "true", "mensaje" => "Se registro el despacho orden de produccion", "data" => $update_canastilla]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo registrar el despacho orden de produccion", "data" => $ex]);
		}
	}

	public function lstCanastillaDespacho() {
		$datosCanastilla = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta', 'iac_usr_id', 'iac_origen', 'iac_fecha_salida', 'iac_codigo_salida')
			->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
			->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
			->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
			->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
			->where('iac_estado', 'D')
			->where('iac_estado_baja', 'A')
			->orderBy('iac_id', 'desc')
			->get();
		return Datatables::of($datosCanastilla)
			->addColumn('acciones', function ($datosCanastilla) {
				return '<button value="' . $datosCanastilla->iac_id . '" class="btn-round btn-xs btn-info" onClick="obtenerDatosCanastillo(this);" data-toggle="modal" data-target="#modalCanastilloDespacho"><i class="fa fa-sign-out fa-2x"></i></button>';
			})->addColumn('usuario', function ($usuario_despacho) {
			return $this->traeUser($usuario_despacho->iac_usr_id);
		})->editColumn('ctl_foto_canastillo', '@if($ctl_foto_canastillo==null)
							<img src=archivo/canastillo/sinfoto.png style="height:50px;width:50px;"/>
						@else
							<img src=archivo/canastillo/{{$ctl_foto_canastillo}} style="height:50px;width:50px;"/>
						@endif')
			->make(true);
	}
}
