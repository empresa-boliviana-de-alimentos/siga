<?php

namespace siga\Http\Controllers\producto_terminado;

use Auth;
use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Http\Modelo\acopio\acopio_lacteos\Vehiculo;
use Yajra\Datatables\Datatables;

class VehiculoController extends Controller {
	public function index() {
		return view('parametricas.vehiculos.index');
	}

	public function create() {
		$vehiculos = Vehiculo::getListarVehiculos();
		return Datatables::of($vehiculos)->addColumn('acciones', function ($vehiculos) {
			return '<button value="' . $vehiculos->veh_id . '" class="btncirculo btn-xs btn-warning"
                onClick="MostrarVehiculos(this);" data-toggle="modal" data-target="#myUpdateVehiculos"><i class="fa fa-pencil-square"></i></button>
            <button value="' . $vehiculos->veh_id . '" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
		})->make(true);
	}

	public function store(Request $request) {
		$ids = Auth::user()->usr_id;
		if ($request->ajax()) {
			Vehiculo::create([
				'veh_placa' => strtoupper($request['veh_placa']),
				'veh_marca' => strtoupper($request['veh_marca']),
				'veh_modelo' => $request['veh_modelo'],
				'veh_tipo' => strtoupper($request['veh_tipo']),
				'veh_chasis' => strtoupper($request['veh_chasis']),
				'veh_roseta_soat' => $request['veh_roseta_soat'],
				'veh_roseta_inspeccion' => $request['veh_roseta_inspeccion'],
				'veh_restriccion_transito' => strtoupper($request['veh_restriccion_transito']),
				'veh_restriccion_municipio' => strtoupper($request['veh_restriccion_gamlp']),
				'veh_usr_id' => $ids,
				'veh_estado' => 'A',
			]);
			return response()->json(['Mensaje' => 'Vehiculo creado']);
		} else {
			return response()->json(['Mensaje' => 'Vehiculo no fue registrado']);
		}
		return response()->json();
	}

	public function show($id) {
		//
	}

	public function edit($id) {
		$vehiculos = Vehiculo::getVehiculos($id);
		return response()->json($vehiculos);

	}

	public function update(Request $request, $id) {
		$vehiculos = Vehiculo::getVehiculos($id);
		$vehiculos->fill($request->all());
		$vehiculos->save();
		return response()->json($vehiculos->toArray());
	}

	public function destroy($id) {
		$vehiculos = Vehiculo::getDestroy($id);
		return response()->json($vehiculos);

	}

}
