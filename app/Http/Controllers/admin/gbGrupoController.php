<?php

namespace siga\Http\Controllers\admin;

use Auth;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Grupo;
use siga\Modelo\admin\LogSeguimiento;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class gbGrupoController extends Controller {

	public function index() {
		return view('backend.administracion.admin.gbGrupos.index');
	}
	public function create() {
		$grupillo = Grupo::getListar();
		return Datatables::of($grupillo)->addColumn('acciones', function ($grupo) {
				return '<button value="'.$grupo->grp_id.'" class="btncirculo btn-xs btn-warning" onClick="Mostrar(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button>
            <button value="'.$grupo->grp_id.'" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
			})
			->editColumn('id', 'ID: {{$grp_id}}')
			->make(true);
	}

	public function store(Request $request) {
		\DB::enableQueryLog();
		$ids = Auth::user()->usr_id;
		//dd($ids);
		if ($request->ajax()) {
			$grupo = Grupo::create([
					'grp_grupo'  => $request['grp_grupo'],
					'grp_imagen' => $request['grp_imagen'],
					'grp_usr_id' => $ids,
					'grp_estado' => 'A',
				]);
			$consulta = \DB::getQueryLog();
			foreach ($consulta as $i => $query) {
				$resultado = json_encode($query);
			}
			\DB::disableQueryLog();
			LogSeguimiento::create([
					'log_usr_id'   => $ids,
					'log_metodo'   => 'POST',
					'log_accion'   => 'CREACION',
					'log_detalle'  => "el usuario".Auth::User()->usr_usuario."agrego un nuevo registro",
					'log_modulo'   => 'GRUPO',
					'log_consulta' => $resultado,
				]);
			;
			return response()->json(["Mensaje" => $grupo]);
		} else {
			LogSeguimiento::create([
					'log_usr_id'   => $ids,
					'log_metodo'   => 'POST',
					'log_accion'   => 'FALLIDA',
					'log_detalle'  => "el usuario".Auth::User()->usr_usuario." ocurrio un error",
					'log_modulo'   => "GRUPO",
					'log_consulta' => "error al registrar",
				]);

			return response()->json(['Mensaje' => 'Grupo no fue registrado']);
		}
		return response()->json();

	}
	public function show($id) {

	}
	public function edit($id) {
		$grupo = Grupo::setBuscar($id);
		return response()->json($grupo->toArray());
	}

	public function update(Request $request, $id) {
		\DB::enableQueryLog();
		$ids = Auth::user()->usr_id;
		if ($request->ajax()) {
			$grupo     = Grupo::setBuscar($id);
			$resultado = $grupo;
			$grupo->fill($request->all());

			$grupo->save();
			$consulta = \DB::getQueryLog();
			foreach ($consulta as $i => $query) {
				$resultado = json_encode($query);
			}
			\DB::disableQueryLog();
			LogSeguimiento::create([
					'log_usr_id'   => $ids,
					'log_metodo'   => 'PUT',
					'log_accion'   => 'ACTUALIZACION',
					'log_detalle'  => "el usuario".Auth::User()->usr_usuario." actualizo este registro",
					'log_modulo'   => 'GRUPO',
					'log_consulta' => $resultado,
				]);
			return response()->json($grupo->toArray());
		} else {
			LogSeguimiento::create([
					'log_usr_id'   => $id,
					'log_metodo'   => 'PUT',
					'log_accion'   => 'FALLIDA',
					'log_detalle'  => "El usuario".Auth::User()->usr_usuario."no puedo actualizar",
					'log_modulo'   => "GRUPO",
					'log_consulta' => "error al actualizar",
				]);
			return response()->json(['Mensaje' => 'Grupo no fue modificado']);
		}
	}
	public function destroy($id) {
		\DB::enableQueryLog();
		$ids   = Auth::user()->usr_id;
		$grupo = Grupo::getDestroy($id);
		//dd($grupo);
		$consulta = \DB::getQueryLog();
		foreach ($consulta as $i => $query) {
			$resultados = json_encode($query);
		}
		\DB::disableQueryLog();
		LogSeguimiento::create([
				'log_usr_id'   => $ids,
				'log_metodo'   => 'DELETE',
				'log_accion'   => 'ELIMINACION',
				'log_detalle'  => "el usuario ".Auth::user()->usr_usuario."elimino este registro",
				'log_modulo'   => 'GRUPO',
				'log_consulta' => $resultados,
			]);

		return response()->json(["Mensaje" => $grupo]);
	}
}
