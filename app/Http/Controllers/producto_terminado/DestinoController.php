<?php

namespace siga\Http\Controllers\producto_terminado;

use Auth;
use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Http\Modelo\acopio\acopio_lacteos\Destino;
use siga\Modelo\acopio\acopio_almendra\Departamento;
use siga\Modelo\acopio\acopio_almendra\LineaTrabajo;
use Yajra\Datatables\Datatables;

class DestinoController extends Controller {

	public function index() {
		$lineaTrabajo = LineaTrabajo::OrderBy('ltra_id', 'desc')->pluck('ltra_nombre', 'ltra_id');
		$planta = \DB::table('_bp_planta')->OrderBy('id_planta', 'desc')->pluck('nombre_planta', 'id_planta');
		$departamento = Departamento::OrderBy('dep_id', 'desc')->pluck('dep_nombre', 'dep_id');
		return view('backend.administracion.producto_terminado.datos.destinos.index', compact('lineaTrabajo', 'planta', 'departamento'));
	}

	public function create() {
		$destinos = Destino::getListarDestinos();
		return Datatables::of($destinos)->addColumn('acciones', function ($destinos) {
			return '<button value="' . $destinos->de_id . '" class="btncirculo btn-xs btn-warning"
                onClick="MostrarDestinos(this);" data-toggle="modal" data-target="#myUpdateDestino"><i class="fa fa-pencil-square"></i></button>
            <button value="' . $destinos->de_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarDestino(this);"><i class="fa fa-trash-o"></i></button>';
		})->make(true);
	}

	public function store(Request $request) {
		$ids = Auth::user()->usr_id;
		if ($request->ajax()) {
			Destino::create([
				'de_nombre' => strtoupper($request['de_nombre']),
				'de_codigo' => strtoupper($request['de_codigo']),
				'de_mercado' => $request['de_mercado'],
				'de_linea_trabajo' => strtoupper($request['de_linea_trabajo']),
				'de_planta_id' => strtoupper($request['de_planta_id']),
				'de_departamento' => $request['de_departamento'],
				'de_usr_id' => $ids,
				'de_estado' => 'A',
			]);
			return response()->json(['Mensaje' => 'Vehiculo creado']);
		} else {
			return response()->json(['Mensaje' => 'Vehiculo no fue registrado']);
		}
		return response()->json();
	}

	public function show($id) {

	}

	public function edit($id) {
		$destino = Destino::getDestinos($id);
		return response()->json($destino);
	}

	public function update(Request $request, $id) {
		$destino = Destino::getDestinos($id);
		$destino->fill($request->all());
		$destino->save();
		return response()->json($destino->toArray());
	}

	public function destroy($id) {
		$destino = Destino::getDestroy($id);
		return response()->json($destino);
	}
}
