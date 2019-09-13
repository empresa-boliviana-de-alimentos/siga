<?php

namespace siga\Http\Controllers\producto_terminado;

use Auth;
use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Http\Modelo\acopio\acopio_lacteos\Conductor;
use Yajra\Datatables\Datatables;

class ConductorController extends Controller {

	public function index() {
		//
	}

	public function create() {
		$conductor = Conductor::getListarConductor();
		return Datatables::of($conductor)->addColumn('acciones', function ($conductor) {
			return '<button value="' . $conductor->pcd_id . '" class="btncirculo btn-xs btn-warning"
                onClick="MostrarConductor(this);" data-toggle="modal" data-target="#myUpdateConductor"><i class="fa fa-pencil-square"></i></button>
            <button value="' . $conductor->pcd_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarConductor(this);"><i class="fa fa-trash-o"></i></button>';
		})
			->addColumn('nombreCompleto', function ($nombres) {
				return $nombres->pcd_nombres . ' ' . $nombres->pcd_paterno . ' ' . $nombres->pcd_materno;
			})->make(true);
	}

	public function store(Request $request) {
		$ids = Auth::user()->usr_id;
		if ($request->ajax()) {
			Conductor::create([
				'pcd_id_estado_civil' => strtoupper($request['pcd_id_estado_civil']),
				'pcd_ci' => $request['pcd_ci'],
				'pcd_nro_licencia' => $request['pcd_nro_licencia'],
				'pcd_categoria' => strtoupper($request['pcd_categoria']),
				'pcd_nombres' => strtoupper($request['pcd_nombres']),
				'pcd_paterno' => strtoupper($request['pcd_paterno']),
				'pcd_materno' => strtoupper($request['pcd_materno']),
				'pcd_direccion' => strtoupper($request['pcd_direccion']),
				'pcd_telefono' => $request['pcd_telefono'],
				'pcd_celular' => $request['pcd_celular'],
				'pcd_correo' => $request['pcd_correo'],
				'pcd_sexo' => $request['pcd_sexo'],
				'pcd_fec_nacimiento' => $request['pcd_fec_nacimiento'],
				'pcd_veh_id' => $request['pcd_veh_id'],
				'pcd_usr_id' => $ids,
			]);
			return response()->json(['Mensaje' => 'Conductor creado']);
		} else {
			return response()->json(['Mensaje' => 'Conductor no fue registrado']);
		}
		return response()->json();
	}

	public function show($id) {
		//
	}

	public function edit($id) {
		$conductor = Conductor::getConductor($id);
		return response()->json($conductor);
	}

	public function update(Request $request, $id) {
		$conductor = Conductor::getConductor($id);
		$conductor->fill($request->all());
		$conductor->save();
		return response()->json($conductor->toArray());
	}

	public function destroy($id) {
		$conductor = Conductor::getDestroy($id);
		return response()->json($conductor);
	}
}