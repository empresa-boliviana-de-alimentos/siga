<?php

namespace siga\Http\Controllers\admin;

use Auth;
use siga\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
USE siga\Modelo\admin\LogSeguimiento;
use siga\Modelo\admin\Persona;
use siga\Modelo\admin\Usuario;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Redirect;
use Session;
class gbUsuarioController extends Controller {
	public function index() {
		$idrol=Session::get('ID_ROL');
		if ($idrol == 1 || $idrol == 9 || $idrol == 8 || $idrol == 22 || $idrol == 29) {
			$planta = DB::table('_bp_planta')->OrderBy('id_planta','desc')->pluck('nombre_planta','id_planta');
			$persona = Persona::OrderBy('prs_id', 'desc')->select(
	      		DB::raw("CONCAT(prs_nombres,' ',prs_paterno,' ',prs_materno) AS name"),'prs_id')->pluck('name', 'prs_id');
			return view('backend.administracion.admin.gbUsuario.index', compact('persona','planta'));
		}else{
			return redirect('/home');
		}
		
	}
	public function create() {
		$usr = Usuario::getListar();
		return datatables::of($usr)->addColumn('acciones', function ($usuario) {
				return '<button value="'.$usuario->usr_id.'" class="btncirculo btn-xs btn-primary" onClick="MostrarUsuario(this);" data-toggle="modal" data-target="#myUserUpdate"><i class="fa fa-pencil-square"></i></button>
            <button value="'.$usuario->usr_id.'" class="btncirculo btn-xs btn-danger" onClick="EliminarUsuario(this);"><i class="fa fa-trash-o"></i></button>';})
		->editColumn('id', 'ID: {{$usr_id}}')->
            addColumn('areaProd', function ($areaProd) {
                if ($areaProd->usr_linea_trabajo == 1) {
                    return '<h4 class="text-center"><span class="label label-success">Almendra</span></h4>';
                } elseif ($areaProd->usr_linea_trabajo == 2){
               	 	return '<h4 class="text-center"><span class="label label-primary">Lacteos</span></h4>';
               	} elseif ($areaProd->usr_linea_trabajo == 3){
               	 	return '<h4 class="text-center"><span class="label label-warning">Miel</span></h4>';
            	} elseif ($areaProd->usr_linea_trabajo == 4) {
                	return '<h4 class="text-center"><span class="label label-danger">Frutos</span></h4>';
            	}
        })	
		->editColumn('id', 'ID: {{$usr_id}}')	->make(true);
	}
	public function store(Request $request) {
		\DB::enableQueryLog();
		$ids = Auth::user()->usr_id;
		if ($request->ajax()) {
			Usuario::create([
					'usr_usuario' => $request['usr_usuario'],
					'password'   => bcrypt($request['usr_clave']),
					'usr_prs_id'  => $request['usr_prs_id'],
					'usr_linea_trabajo' => $request['usr_linea_trabajo'],
					'usr_planta_id' => $request['usr_planta_id'],
					'usr_usr_id'  => Auth::User()->usr_id,
					'usr_zona_id' => $request['usr_zona_id'],
					'usr_id_turno' => $request['usr_id_turno'],
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
					'log_modulo'   => 'USUARIOS',
					'log_consulta' => $resultado,
				]);
			return response()->json(["Mensaje" => "Se registro Correctamente"]);
		} else {
			return response()->json(["Mensaje" => "Hubo un error al registrar los datos"]);
		}

	}

	public function show($id) {
	}

	public function edit($id) {
		$usuario = Usuario::setBuscar($id);
		return response()->json($usuario);
	}
	public function update(Request $request, $id) {

		$dataA   = array("usr_usuario" => $request->all()['usr_usuario'],
		                 "password" => bcrypt($request->all()['usr_clave']),
		                 "usr_prs_id" => $request->all()['usr_prs_id'],
		                 "usr_id_turno" => $request->all()['usr_id_turno']);
		//dd($dataA);
		
		\DB::enableQueryLog();
		$ids = Auth::user()->usr_id;
		if ($request->ajax()) {
			$usuario = Usuario::setBuscar($id);
			$usuario->fill($dataA);
			$usuario->save();
			$consulta = \DB::getQueryLog();
			foreach ($consulta as $i => $query) {
				$resultado = json_encode($query);
			}
			\DB::disableQueryLog();
			LogSeguimiento::create([
					'log_usr_id'   => $ids,
					'log_metodo'   => 'PUT',
					'log_accion'   => 'ACTUALIZACION',
					'log_detalle'  => "el usuario".Auth::User()->usr_usuario." actualizo un nuevo registro",
					'log_modulo'   => 'USUARIOS',
					'log_consulta' => $resultado,
				]);
			return response()->json(["Mensaje" => "Usuario fue actualizado", "datos" => $dataA]);
		} else {
			return response()->json(["Mensaje" => "Hubo un error al actualizar los datos"]);
		}
	}
	public function destroy($id) {
		\DB::enableQueryLog();
		$ids      = Auth::user()->usr_id;
		$susuario = Usuario::setDestroy($id);
		$consulta = \DB::getQueryLog();
		foreach ($consulta as $i => $query) {
			$resultado = json_encode($query);
		}
		\DB::disableQueryLog();
		LogSeguimiento::create([
				'log_usr_id'   => $ids,
				'log_metodo'   => 'DELETE',
				'log_accion'   => 'ELIMINACION',
				'log_detalle'  => "el usuario".Auth::User()->usr_usuario." elimino un registro",
				'log_modulo'   => 'USUARIOS',
				'log_consulta' => $resultado,
			]);
		return response()->json(["Mensaje" => "Usuario fue eliminado"]);

	}
	// CAMBIO DE PLANTA
	public function updatePlanta($id_planta)
	{
		$id = Auth::user()->usr_id;
		$usuario = Usuario::setBuscar($id);
		$usuario->usr_planta_id = $id_planta;
		$usuario->save();
		$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',$usuario->usr_id)->first();
		Session::put('PLANTA',$planta->nombre_planta);

		return Redirect::to('/home');
	}
	public function updatePlantaAdmin($id_plantaAdmin, $id_linea)
	{
		$id = Auth::user()->usr_id;
		$usuario = Usuario::setBuscar($id);
		$usuario->usr_linea_trabajo = $id_linea;
		$usuario->usr_planta_id = $id_plantaAdmin;
		$usuario->save();
		$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',$usuario->usr_id)->first();
		Session::put('PLANTA',$planta->nombre_planta);

		return back()->withInput();	
	}
}
