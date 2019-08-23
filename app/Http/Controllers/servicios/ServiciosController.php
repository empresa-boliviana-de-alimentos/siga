<?php

namespace siga\Http\Controllers\servicios;

use Carbon\Carbon;
use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_almendra\Acopio;
use siga\Modelo\acopio\acopio_almendra\Proveedor;

use siga\Modelo\admin\Cargo;

class ServiciosController extends Controller {
	public function listarCargos() {
		$cargo   = Cargo::select('cg_id', 'cg_nombre')->where('cg_estado', 'A')->orderBy('cg_id', 'asc')->get();
		$success = array("code"    => 200);
		$error   = array("message" => "error de instancia", "code" => 602);
		try {
			return response()->json(["data" => $cargo, "success" => $success]);
		} catch (Exception $e) {
			return response()->json(["error" => $error]);
		}
	}

	public function obtenerParqueosZona(Request $request) {
		$success = array("code"    => 200);
		$error   = array("message" => "error de instancia", "code" => 602);
		try {
			$zona     = $request['zona'];
			$estado   = $request['estado'];
			$latitud  = $request['latitud'];
			$longitud = $request['longitud'];
			$data     = \DB::select('select * from sp_get_parqueos_zona(?,?,?,?)', array($zona, $estado, $latitud, $longitud));
			return response()->json(["data" => $data, "success" => $success]);
		} catch (Exception $e) {
			return response()->json(["error" => $error]);
		}
	}
	//SERVICIOS PARA PROVEEDORES
	public function listarProveedores($id) {
		$success = array("code"    => 200);
		$error   = array("message" => "error de instancia", "code" => 602);
		try {
			$sqlListar = Proveedor::getListarApp($id);
			$data      = $sqlListar;
			return response()->json(["estado" => 1, "proveedores" => $data]);
		} catch (Exception $e) {
			return response()->json(["error" => $error]);
		}
	}

	public function registrarProveedor(Request $request) {
		$success = array("code"    => 200);
		$error   = array("message" => "error de instancia", "code" => 602);
		$date    = Carbon::now();
		try {
			$data = Proveedor::create([
					'prov_nombre'        => $request['prov_nombre'],
					'prov_ap'            => $request['prov_ap'],
					'prov_am'            => $request['prov_am'],
					'prov_ci'            => intval($request['prov_ci']),
					'prov_exp'           => $request['prov_exp'],
					'prov_tel'           => intval($request['prov_tel']),
					'prov_fecha_reg'     => $date,
					'prov_estado'        => 'A',
					'prov_id_usr'        => intval($request['prov_id_usr']),
					'prov_id_tipo'       => intval($request['prov_id_tipo']),
					'prov_id_convenio'   => $request['prov_id_convenio'],
					'prov_departamento'  => intval($request['prov_departamento']),
					'prov_id_provincia'  => intval($request['prov_id_provincia']),
					'prov_id_municipio'  => intval($request['prov_id_municipio']),
					'prov_id_comunidad'  => intval($request['prov_id_comunidad']),
					'prov_id_asociacion' => intval($request['prov_id_asociacion']),
					'prov_id_linea'      => intval($request['prov_id_linea']),
				]);
			$resultado   = array('estado' => 1, 'mensaje' => 'Creacion éxitosa', 'prov_id' => $data->prov_id);
			$errorResult = array('estado' => 2, 'mensaje' => 'Creacion fallida');
			return response()->json($resultado);
		} catch (Exception $e) {
			return response()->json($errorResult);
		}
	}

	public function listarPrueba(Request $request) {
		$success = array("code"    => 200);
		$error   = array("message" => "error de instancia", "code" => 602);
		$date    = Carbon::now();
		try {
			$sql  = Prueba::select()->where('pru_estado', 'A')->get();
			$data = collect($sql);
			return response()->json(["data" => $data, "success" => $success]);
		} catch (Exception $e) {
			return response()->json(["error" => $error]);
		}
	}

	public function listarAcopio($id) {
		$success = array("code"    => 200);
		$error   = array("message" => "error de instancia", "code" => 602);
		try {
			$sqlListar = Acopio::select('acopio.aco_id', 'acopio.aco_id_prov', 'acopio.aco_id_recep', 'acopio.aco_obs', 'acopio.aco_id_tipo_cas', 'acopio.aco_cantidad', 'acopio.aco_centro', 'acopio.aco_num_rec', 'acopio.aco_cos_un', 'acopio.aco_cos_total', 'acopio.aco_numaco', 'acopio.aco_peso_neto', 'acopio.aco_fecha_acop', 'acopio.aco_unidad', 'acopio.aco_id_proc', 'acopio.aco_id_linea', 'acopio.aco_id_usr', 'tip.tca_nombre', 'lug.proc_nombre', 'acopio.acopio.aco_fecha_acop', 'acopio.acopio.aco_numaco', 'acopio.acopio.aco_peso_neto', 'acopio.acopio.aco_cantidad', 'acopio.acopio.aco_cos_total')
				->join('acopio.tipo_castania as tip', 'acopio.acopio.aco_id_tipo_cas', '=', 'tip.tca_id')
				->join('acopio.lugar_proc as lug', 'acopio.acopio.aco_id_proc', '=', 'lug.proc_id')
				->where('aco_id_prov', $id)
				->get();
			$data = $sqlListar;
			return response()->json(["estado" => 1, "acopios" => $data]);
		} catch (Exception $e) {
			return response()->json(["error" => $error]);
		}

	}

	public function registrarAcopio(Request $request) {
		$success = array("code"    => 200);
		$error   = array("message" => "error de instancia", "code" => 602);
		$date    = Carbon::now();
		try {
			$data = Acopio::create([
					'aco_id_prov'      => $request['aco_id_prov'],
					'aco_id_proc'      => $request['aco_id_proc'],
					'aco_centro'       => $request['aco_centro'],
					'aco_peso_neto'    => $request['aco_peso_neto'],
					'aco_id_tipo_cas'  => $request['aco_id_tipo_cas'],
					'aco_numaco'       => $nid,
					'aco_unidad'       => $request['aco_unidad'],
					'aco_cantidad'     => $request['aco_cantidad'],
					'aco_cos_un'       => $request['aco_cos_un'],
					'aco_cos_total'    => $request['aco_cos_total'],
					'aco_fecha_acop'   => $request['aco_fecha_acop'],
					'aco_fecha_reg'    => "2018-10-10 14:20:00",
					'aco_obs'          => $request['aco_obs'],
					'aco_id_usr'       => Auth::user()->usr_id,
					'aco_estado'       => 'A',
					'aco_num_rec'      => $request['aco_num_rec'],
					'aco_id_recep'     => 1,
					'aco_id_linea'     => 1,
					'aco_id_comunidad' => $request['aco_id_comunidad'],
					'aco_id_prom'      => 1,
					'aco_id_destino'   => 1,
				]);
			$resultado   = array('estado' => 1, 'mensaje' => 'Creacion éxitosa', 'aco_id' => $data->aco_id);
			$errorResult = array('estado' => 2, 'mensaje' => 'Creacion fallida');
			return response()->json($resultado);
		} catch (Exception $e) {
			return response()->json(["error" => $error]);
		}
	}
}
