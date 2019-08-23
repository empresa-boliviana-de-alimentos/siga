<?php

namespace siga\Http\Controllers;

use Illuminate\Http\Request;

class prueba extends Controller {
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
	public function listarProveedores() {
		$success = array("code"    => 200);
		$error   = array("message" => "error de instancia", "code" => 602);
		try {
			$sqlListar = Proveedor::getListarApp();
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
					'prov_nombre'    => $request['prov_nombre'],
					'prov_ap'        => $request['prov_ap'],
					'prov_am'        => $request['prov_am'],
					'prov_ci'        => intval($request['prov_ci']),
					'prov_exp'       => $request['prov_exp'],
					'prov_tel'       => intval($request['prov_tel']),
					'prov_fecha_reg' => $date,
					'prov_id_linea'  => 1,
					'prov_estado'    => 'A',
					'prov_id_usr'    => 1,
				]);
			$resultado   = array('estado' => 1, 'mensaje' => 'Creacion éxitosa', 'prov_id' => $data->prov_id);
			$errorResult = array('estado' => 2, 'mensaje' => 'Creacion fallida');
			return response()->json($resultado);
		} catch (Exception $e) {
			return response()->json(["error" => $error]);
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
}
