<?php

namespace siga\Http\Controllers\producto_terminado;

use Auth;
use Carbon\Carbon;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Session;
use siga\Http\Controllers\Controller;
use siga\Http\Modelo\acopio\acopio_lacteos\Canastillo;
use siga\Http\Modelo\acopio\acopio_lacteos\Conductor;
use siga\Http\Modelo\ProductoTerminado\Correlativo;
use siga\Http\Modelo\ProductoTerminado\IngresoCanastilla;
use siga\Http\Modelo\ProductoTerminado\IngresoORP;
use siga\Http\Modelo\ProductoTerminado\stock_pt;
use siga\Http\Modelo\ProductoTerminado\ProductoTerminadoHistorial;
use siga\Modelo\admin\Usuario;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use Yajra\Datatables\Datatables;

class IngresoProductoTerminadoController extends Controller {
	public function __construct() {
		if (!\Session::has('cart')) {
			\Session::put('cart', array());
		}
	}
	public function index() {
		$planta = \DB::table('_bp_planta')->OrderBy('id_planta', 'desc')->get();
		$conductor = Conductor::select()->where('pcd_estado', 'A')->get();
		//dd($planta);
		return view('backend.administracion.producto_terminado.ingresos.index', compact('planta', 'conductor'));
	}
	public function create() {
		return view('backend.administracion.producto_terminado.ingresos.index');
	}
	public function listar_ORP() {
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->select('planta.id_planta')->where('usr_id', '=', Auth::user()->usr_id)->first();
		$orden_produccion = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
			->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
			->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id')
			->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
			->orderBy('orprod_id', 'DESC')
			->where('orprod_tiporprod_id', 1)
			->where('orprod_estado_orp', 'D')
			->where('orprod_estado_pt', 'A')
			->get();

		return Datatables::of($orden_produccion)->addColumn('opciones', function ($orden_produccion) {
			return '<button value="' . $orden_produccion->orprod_id . '" class="btn-round btn-xs btn-info"
                onClick="obtenerORP(this);" data-toggle="modal" data-target="#myCreateAlmacen"><i class="fa fa-cube fa-2x"></i></button>';
		})->addColumn('nombreReceta', function ($nombreReceta) {
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
		})->addColumn('estadoAprobacion', function ($estadoAprobacion) {
			if ($estadoAprobacion->orprod_estado_orp == 'A') {
				return $this->traeUser($estadoAprobacion->orprod_usr_id);
			} elseif ($estadoAprobacion->orprod_estado_orp == 'B') {
				return $this->traeUser($estadoAprobacion->orprod_usr_vo);
			} elseif ($estadoAprobacion->orprod_estado_orp == 'C') {
				return $this->traeUser($estadoAprobacion->orprod_usr_vodos);
			} elseif ($estadoAprobacion->orprod_estado_orp == 'D') {
				return $this->traeUser($estadoAprobacion->orprod_usr_aprob);
			}
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

	public function obtenerORP($id) {
		try {
			setlocale(LC_ALL, "es_ES");
			\Carbon\Carbon::setLocale('es');
			$orden_produccion = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
				->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
				->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id')
				->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
				->where('orprod_id', $id)
				->where('orprod_estado_pt', 'A')
				->orderBy('orprod_id', 'DESC')
				->first();
			$datetime = new Carbon($orden_produccion->orprod_fecha_vo);
			$horaInicio = $datetime->format('H:i');
			$date = new Carbon();
			$horaTope = $orden_produccion->orprod_tiempo_prod;
//			$numeral = $this->intervaloHoras($horaInicio, $horaFin);
			//$literal = $this->intervaloLiteral($horaInicio, $horaFin);

			$from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $datetime);
			$hora = $date->diffInHours($from);
			$minuto = $date->diffInMinutes($from);
			$numeral = $hora . ':' . "00";
			$literal = $this->fechaLiteral($datetime);
			if ($horaTope > $numeral) {
				$cambioHora = "false";
			} else {
				$cambioHora = "true";
			}
			return response()->json(["success" => "true", "mensaje" => "La parametrica se actualizo correctamente", "data" => $orden_produccion, "literal" => $literal, "numeral" => $numeral, "horaTope" => $cambioHora]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo actualizar la parametrica intente nuevamente", "data" => $ex]);
		}
	}

	function intervaloHoras($horainicio, $horafin, $formated = false) {
		$apertura = new DateTime($horainicio);
		$cierre = new DateTime($horafin);
		$tiempo = $apertura->diff($cierre);
		return $tiempo->format('%H:%i');
	}

	function intervaloLiteral($horainicio, $horafin, $formated = false) {
		$apertura = new DateTime($horainicio);
		$cierre = new DateTime($horafin);
		$tiempo = $apertura->diff($cierre);
		return $tiempo->format('%H horas %i minutos');
	}

	function fechaLiteral($datetime, $full = true) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'año',
			'm' => 'mes',
			'w' => 'semana',
			'd' => 'dia',
			'h' => 'hora',
			'i' => 'minuto',
			's' => 'segundo',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) {
			$string = array_slice($string, 0, 1);
		}

		return $string ? implode(', ', $string) . ' hace' : 'justo ahora';
	}
	public function listarIngresoORP() {
		$orden_produccion = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
			->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
			->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id', 'ipt_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_usr_id')
			->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
			->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
			->orderBy('orprod_id', 'DESC')
			->where('orprod_tiporprod_id', 1)
			->Where('inp.ipt_estado', 'A')
			->where('orprod_estado_pt', 'I')
			->get();
		return Datatables::of($orden_produccion)->addColumn('nombreReceta', function ($nombreReceta) {
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

	public function registrarIngreso(Request $request) {
		//return response()->json($request->all());
		$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
		$datetime = new Carbon();
		$fecha_actual = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $datetime);
		$ids = Auth::user()->usr_id;
		try {
			$sqlIngreso = IngresoORP::select()
				->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'ipt_orprod_id')
				->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
				->Where('ipt_estado', 'A')
				->where('orp.orprod_estado_pt', 'I')
				->get();
			$casoDemo = false;
			foreach ($sqlIngreso as $m) {
				if ($m->rece_id == $request['rece_id']) {
					if ($m->ipt_costo_unitario == $request['ctl_costo_unitario']) {
						$casoDemo = true;
					}
				}
			}
			$ingresoORP = IngresoORP::create([
				'ipt_orprod_id' => $request['ctl_orprod_id'],
				'ipt_cantidad' => floatval($request['ctl_cantidad_producida']),
				'ipt_lote' => strtoupper($request['ctl_lote']),
				'ipt_hora_falta' => $request['ctl_tiempo_falta'],
				'ipt_fecha_vencimiento' => $request['ctl_fecha_vencimiento'],
				'ipt_costo_unitario' => floatval($request['ctl_costo_unitario']),
				'ipt_observacion' => strtoupper($request['ctl_observaciones']),
				'ipt_sobrante' => 0,
				'ipt_usr_id' => $ids,
				'ipt_estado' => 'A',
				'ipt_estado_baja' => 'A',
			]);
			/*PRODUCTO TERMINADO HISTORIAL*/
			ProductoTerminadoHistorial::create([
				'pth_planta_id' 		=> $planta->id_planta,
				'pth_rece_id'			=> $request['rece_id'],
				'pth_ipt_id'			=> $ingresoORP->ipt_id,
				'pth_tipo'				=> 1,
				'pth_cantidad'			=> floatval($request['ctl_cantidad_producida']),
				'pth_fecha_vencimiento'	=> $request['ctl_fecha_vencimiento'],
				'pth_lote'				=> strtoupper($request['ctl_lote']),
				'pth_estado'			=> 'A',
			]);
			/*END PRODUCTO TERMINADO*/
			$orden_produccion = OrdenProduccion::select()->where('orprod_id', $request['ctl_orprod_id'])->update(['orprod_estado_pt' => 'I']);

			$sqlstock = stock_pt::select()
				->join('insumo.receta as rece', 'spt_rece_id', '=', 'rece.rece_id')
				->Where('spt_estado', 'A')
				->where('spt_rece_id', $request['rece_id'])
				->where('spt_costo_unitario', $request['ctl_costo_unitario'])
				->where('spt_planta_id', $request['planta_id'])
				->first();
			if (empty($sqlstock)) {
				$costoTotal = $request['ctl_cantidad_producida'] * floatval($request['ctl_costo_unitario']);
				$stock_pt = stock_pt::create([
					'spt_orprod_id' => $request['ctl_orprod_id'],
					'spt_planta_id' => $request['planta_id'],
					'spt_fecha' => $fecha_actual,
					'spt_cantidad' => $request['ctl_cantidad_producida'],
					'spt_costo_unitario' => floatval($request['ctl_costo_unitario']),
					'spt_costo' => $costoTotal,
					'spt_rece_id' => $request['rece_id'],
					'spt_estado' => 'A',
					'spt_usr_id' => $ids,
					'spt_estado_baja' => 'A']);
			} else {
				if ($sqlstock->spt_rece_id == $request['rece_id'] && $casoDemo == true && $sqlstock->spt_planta_id == intval($request['planta_id'])) {
					$totalUpdate = $sqlstock->spt_cantidad + $request['ctl_cantidad_producida'];
					$totalCostoU = $totalUpdate * $request['ctl_costo_unitario'];
					$stock_update = stock_pt::select()->where('spt_id', $sqlstock->spt_id)->update(['spt_cantidad' => $totalUpdate, 'spt_costo' => $totalCostoU, 'spt_fecha' => $fecha_actual, 'spt_fecha_vencimiento' => $request['ctl_fecha_vencimiento'], 'spt_fecha' => $fecha_actual]);
				} else {
					$costoTotal = $request['ctl_cantidad_producida'] * floatval($request['ctl_costo_unitario']);
					$stock_pt = stock_pt::create([
						'spt_orprod_id' => $request['ctl_orprod_id'],
						'spt_planta_id' => $request['planta_id'],
						'spt_fecha' => $fecha_actual,
						'spt_cantidad' => $request['ctl_cantidad_producida'],
						'spt_costo_unitario' => $request['ctl_costo_unitario'],
						'spt_costo' => $costoTotal,
						'spt_rece_id' => $request['rece_id'],
						'spt_estado' => 'A',
						'spt_usr_id' => $ids,
						'spt_estado_baja' => 'A']);
				}
			}

			return response()->json(["success" => "true", "mensaje" => "El ingreso ORP se registro correctamente", "data" => $ingresoORP]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo registrar el ingresoORP intente nuevamente", "data" => $ex]);
		}
	}

	public function listarIngresoCanastillaG() {
		$ids_usr = Auth::user()->usr_id;
		try {
			$IngresoCanastilla = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta')
				->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
				->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
				->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
				->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
				->where('iac_estado', 'A')
				->where('iac_estado_baja', 'A')
				->orderBy('iac_id', 'desc')->get();
			return response()->json(["success" => "true", "mensaje" => "El listado se desplego Correctamente", "data" => $IngresoCanastilla]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo consultar los datos intente nuevamente", "data" => $ex]);
		}
	}

	public function lstCanastilla() {
		$ids_usr = Auth::user()->usr_id;
		try {
			$canastilla = Canastillo::select()
				->join('insumo.receta as rr', 'rr.rece_id', '=', 'ctl_rece_id')
				->orderBy('ctl_id', 'asc')
				->where('ctl_estado', 'A')
				->get();

			return response()->json(["success" => "true", "mensaje" => "Se realizo el registro de la devolucion del activo", "data" => $canastilla]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo realizar el registro de la devolucion del activo", "data" => $ex]);
		}
	}

	//CARRITO
	// Add item
	public function add(Request $request) {
		$cart = \Session::get('cart');
		$product->quantity = 1;
		$cart[] = $product;
		\Session::put('cart', $cart);
		return redirect()->route('cart-show');
	}
	// Delete item
	public function delete(Productos $product) {
		$cart = \Session::get('cart');
		unset($cart[$product->slug]);
		\Session::put('cart', $cart);

		return redirect()->route('cart-show');
	}
	// Update item
	public function update(Productos $product, $quantity) {
		$cart = \Session::get('cart');
		$cart[$product->slug]->quantity = $quantity;
		\Session::put('cart', $cart);

		return redirect()->route('cart-show');
	}
	// Trash cart
	public function trash() {
		\Session::forget('cart');

		return redirect()->route('cart-show');
	}

	public function registrarIngresoC(Request $request) {
		$ids = Auth::user()->usr_id;
		$date = Carbon::now();
		$date = $date->format('d-m-Y');
		try {
			for ($i = 0; $i < sizeof($request->data); $i++) {
				$ingresoORP = IngresoCanastilla::create([
					'iac_ctl_id' => $request->data[$i]['ctl_id'],
//					'iac_nro_ingreso' => 'Nro Entrada ' . $sqlPedido->corr_correlativo,
					'iac_fecha_ingreso' => $date,
					'iac_cantidad' => $request->data[$i]['cantidad_carrito'],
					'iac_origen' => $request['planta'],
					'iac_observacion' => $request['observacion'],
					'iac_chofer' => $request['conductor'],
					'iac_usr_id' => $ids,
					'iac_estado' => 'A',
				]);
				if ($i == 0) {
					Correlativo::where('corr_codigo', 'ENTRADA_CANASTILLA')->where('corr_tpd_id', $request->planta)
						->increment('corr_correlativo', 1);
				}
				$sqlPedido = Correlativo::select()
					->join('public._bp_planta as planta', 'corr_tpd_id', '=', 'planta.id_planta')
					->where('corr_codigo', 'ENTRADA_CANASTILLA')
					->where('corr_tpd_id', $request->planta)
					->where('corr_estado', 'A')
					->first();
				$codigoIngreso = $sqlPedido->codigo_planta . '-ING-' . str_pad($sqlPedido->corr_correlativo, 5, '0', STR_PAD_LEFT);
				IngresoCanastilla::select()->where('iac_id', $ingresoORP->iac_id)->update(["iac_nro_ingreso" => $codigoIngreso]);
			}
			return response()->json(["success" => "true", "mensaje" => "El ingreso ORP se registro correctamente", "data" => $ingresoORP, "probando" => $sqlPedido]);
		} catch (\Illuminate\Database\QueryException $ex) {
			return response()->json(["success" => "false", "mensaje" => "No se pudo registrar el ingresoORP intente nuevamente", "data" => $ex]);
		}
	}

}
