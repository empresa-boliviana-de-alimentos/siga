<?php

namespace siga\Http\Controllers\producto_terminado;

use Auth;
use DB;
use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Http\Modelo\ProductoTerminado\IngresoCanastilla;
use siga\Modelo\admin\Usuario;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use Yajra\Datatables\Datatables;

class KardexPTController extends Controller {

	public function index() {
		$planta = \DB::table('_bp_planta')->OrderBy('id_planta', 'desc')->get();
		return view('backend.administracion.producto_terminado.kardex.index', compact('planta'));
	}

	public function create() {
		//
	}

	public function store(Request $request) {
		//
	}

	public function show($id) {
		//
	}

	public function edit($id) {
		//
	}

	public function update(Request $request, $id) {
		//
	}

	public function destroy($id) {
		//
	}

	public function listarCanastillaKardex() {
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
	public function listarPTKardex() {
		$stock_orp = \DB::select('select * from producto_terminado.sp_listado_stock()');
		$sql_stock = collect($stock_orp);
		return Datatables::of($sql_stock)->addColumn('nombreReceta', function ($nombreReceta) {
			return $nombreReceta->xrece_nombre . ' ' . $nombreReceta->xrece_presentacion;
		})
			->addColumn('fechavencimiento', function ($stock) {
				return '<button value="' . $stock->xspt_rece_id . '" class="btn-round btn-xs btn-theme04"
                onClick="obtenerFechaVencimiento(this,' . $stock->xspt_planta_id . ');" data-toggle="modal" data-target="#myPTFecha"><i class="fa fa-calendar fa-2x"></i></button>';
			})->addColumn('lotes', function ($stock) {
			return '<button value="' . $stock->xspt_rece_id . '" class="btn-round btn-xs btn-theme03"
                onClick="obtenerORP(this);" data-toggle="modal" data-target="#myCreateAlmacen"><i class="fa fa-envelope fa-2x"></i></button>';
		})->addColumn('kardexValorado', function ($stock) {
			/*return '<button value="' . $stock->xspt_rece_id . '" class="btn-round btn-xs btn-warning"
                onClick="obtenerORP(this);" data-toggle="modal" data-target="#myCreateAlmacen"><i class="glyphicon glyphicon-usd fa-2x"></i></button>
                <button value="' . $stock->xspt_rece_id . '" class="btn-round btn-xs btn-primary"
                onClick="obtenerORP(this);" data-toggle="modal" data-target="#myCreateAlmacen"><i class="fa fa-file-o fa-2x"></i></button>';*/
                return '<div class="text-center"><a style="background-color: #d4b729;border: none;color: white;padding: 5px;text-align: center;text-decoration: none;display: inline-block;font-size: 10px;margin: 4px 2px;border-radius: 50%;" href="RpKardexValoradoPt/' . $stock->xspt_rece_id . '" type="button" target="_blank"><span class="glyphicon glyphicon-usd fa-2x"></span></a></div>';
		})->addColumn('kardexFisico', function ($stock) {
                return '<div class="text-center"><a style="background-color:#2067b4;border: none;color: white;padding: 5px;text-align: center;text-decoration: none;display: inline-block;font-size: 10px;margin: 4px 2px;border-radius: 50%;" href="/RpKardexFisicoPt/' . $stock->xspt_rece_id . '" type="button" target="_blank"><span class="fa fa-file-o fa-2x"></span></a></div>';
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
		})
			->make(true);
	}
	function traeUser($id_user) {
		$user_datos = Usuario::join('public._bp_personas as per', 'public._bp_usuarios.usr_prs_id', '=', 'per.prs_id')
			->where('usr_id', $id_user)
			->first();
		//dd($id_user);
		return $user_datos->prs_nombres . ' ' . $user_datos->prs_paterno . ' ' . $user_datos->prs_materno;
	}

	public function listarFechaVencimiento($id_rece, $planta) {
		$fecha_vencimiento_stock = OrdenProduccion::select('orprod_id', 'rece.rece_id', 'rece.rece_nombre', 'rece.rece_codigo', 'rece.rece_presentacion', 'rece.rece_lineaprod_id', 'id_planta', 'nombre_planta', 'id_linea_trabajo', 'ipt_cantidad', 'ipt_lote', 'ipt_fecha_vencimiento', 'ipt_usr_id')
			->join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
			->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
			->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
			->where('orprod_tiporprod_id', 1)
			->Where('inp.ipt_estado_baja', 'A')
			->where('orprod_estado_pt', 'I')
			->where('orprod_rece_id', $id_rece)
			->where('orprod_planta_id', $planta)
			->get();

		return Datatables::of($fecha_vencimiento_stock)
			->addColumn('lineaProduccion', function ($lineaProduccion) {
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
			->make(true);
	}
}
