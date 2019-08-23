<?php

namespace siga\Http\Controllers\admin;

use Auth;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Acceso;

use siga\Modelo\admin\Grupo;
use siga\Modelo\admin\Rol;
use Illuminate\Http\Request;
use Session;

class gbAsignacionController extends Controller {
	public function index() {
		$idrol= Session::get('ID_ROL');
		$sqlrol=Rol::select('rls_rol')->where('rls_id',$idrol)->get();
		$nombreRol=$sqlrol[0]->rls_rol;
		$rol    = Acceso::getListarRol();
		$opc    = Acceso::getListarOpcionParam($idrol);
		$acceso = Acceso::getListarAccesoParam($idrol);
		return view('backend.administracion.admin.gbAsignacion.index', compact('rol', 'opc', 'acceso','idrol','nombreRol'));
	}

	public function accesos($id) {
		$idrol=$id;
		$sqlrol=Rol::select('rls_rol')->where('rls_id',$idrol)->get();
		$nombreRol=$sqlrol[0]->rls_rol;
		$rol    = Acceso::getListarRol();
		$opc    = Acceso::getListarOpcionParam($id);
		$acceso = Acceso::getListarAccesoParam($id);
		return view('backend.administracion.admin.gbAsignacion.index', compact('rol', 'opc', 'acceso','idrol','nombreRol'));
	}

	public function create() {
		return $grupillo = Grupo::all();
	}

	public function store(Request $request) {
		$idrol = $request['rolacceso'];
		$sqlrol=Rol::select('rls_rol')->where('rls_id',$idrol)->get();
		$nombreRol=$sqlrol[0]->rls_rol;
		if ($request->agregar=="agregar"){
		$arr_opc = $_POST['opciones'];
			for ($i = 0; $i < count($arr_opc); $i++) {
				Acceso::create([
						'acc_rls_id' => $idrol,
						'acc_opc_id' => $arr_opc[$i],
						'acc_usr_id' => Auth::User()->usr_id,
					]);
			}
			$rol    = Acceso::getListarRol();
			$opc    = Acceso::getListarOpcionParam($idrol);
			$acceso = Acceso::getListarAccesoParam($idrol);
            Session::flash('message', 'Se asigno los accesos correctamente.');
			return view('backend.administracion.admin.gbAsignacion.index', compact('rol', 'opc', 'acceso','idrol','nombreRol'));
		}else if($request->retirar=="retirar"){
		$arr_acc = $_POST['asignaciones'];
			for ($i = 0; $i < count($arr_acc); $i++) {
				Acceso::where('acc_id', $arr_acc[$i])
					->update(['acc_estado' => 'B']);
			}
			$rol    = Acceso::getListarRol();
			$opc    = Acceso::getListarOpcionParam($idrol);
			$acceso = Acceso::getListarAccesoParam($idrol);
            Session::flash('messageError', 'Se desasigno los accesos correctamente.');
		return view('backend.administracion.admin.gbAsignacion.index', compact('rol', 'opc', 'acceso','idrol','nombreRol'));
		}
	}

	public function show($id) {

		$grupo = Grupo::where('grp_id', $id)->update(['grp_estado' => 'B']);
		Session::flash('message', 'Grupo eliminado correctamente');
		$grupillo = Grupo::getListar();
		Session::flash('message', 'El grupo fue eliminado correctamente.');
		return view('admin.gbGrupos.read', compact('grupo', 'grupillo'));
	}
	public function edit($id) {
		$grupo    = Grupo::setBuscar($id);
		$grupillo = Grupo::getListar();
		return view('admin.gbGrupos.update', compact('grupo', 'grupillo'));
	}

	public function update(Request $request, $id) {
		$grupo = Grupo::setBuscar($id);
		$grupo->fill($request->all());
		$grupo->save();
		$grupillo = Grupo::getListar();
		Session::flash('message', 'El grupo se editado Correctamente');
		return view('admin.gbGrupos.read', compact('grupillo'));
	}

	public function destroy($id) {

	}
}
