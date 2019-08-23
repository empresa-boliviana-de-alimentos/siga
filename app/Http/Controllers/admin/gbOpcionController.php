<?php

namespace siga\Http\Controllers\admin;

use Auth;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Grupo;
use siga\Modelo\admin\Opcion;
use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

class gbOpcionController extends Controller {

	public function index() {
		$grupos = Grupo::OrderBy('grp_id', 'desc')->pluck('grp_grupo', 'grp_id');
		return view('backend.administracion.admin.gbOpciones.index', compact('grupos'));
	}
	public function create() {
		$opc = Opcion::getListar();
		return Datatables::of($opc)->addColumn('acciones', function ($opc) {
				return '<button value="'.$opc->opc_id.'" class="btncirculo btn-xs btn-warning" onClick="Mostrar(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button>
            <button value="'.$opc->opc_id.'" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
			})
			->editColumn('id', 'ID: {{$opc_id}}')
			->make(true);
	}

	public function store(Request $request) {
		$id = Auth::user()->usr_id;
		if ($request->ajax()) {
			Opcion::create([
					'opc_opcion'    => $request['opc_opcion'],
					'opc_contenido' => $request['opc_contenido'],
					'opc_grp_id'    => $request['opc_grp_id'],
					'opc_adicional' => '1',
					'opc_orden'     => 1,
					'opc_usr_id'    => $id,
					'opc_estado'    => 'A',
				]);
			return response()->json(['Mensaje' => 'Opcion creado']);
		} else {
			return response()->json(['Mensaje' => 'Opcion no fue registrado']);
		}

		return response()->json();
	}
	public function show($id) {

	}

	public function edit($id) {
		$opcion = Opcion::setBuscar($id);
		return response()->json($opcion);
	}

	public function update(Request $request, $id) {
		$opcion = Opcion::setBuscar($id);
		$opcion->fill($request->all());
		$opcion->save();
		return response()->json($opcion->toArray());
	}

	public function destroy($id) {
		$opcion = Opcion::getDestroy($id);
		return response()->json($opcion);
	}
}
