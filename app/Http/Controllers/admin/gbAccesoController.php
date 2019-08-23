<?php

namespace siga\Http\Controllers\admin;

use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Acceso;
use siga\Modelo\admin\Opcion;
use siga\Modelo\admin\Rol;
use siga\Modelo\admin\Usuario;
use Illuminate\Http\Request;

use Redirect;
use Session;
use Yajra\Datatables\Datatables;

class gbAccesoController extends Controller {
	public function index() {
		$rol     = Rol::OrderBy('rls_id', 'asc')->pluck('rls_rol', 'rls_id');
		$opc     = Opcion::OrderBy('opc_id', 'asc')->pluck('opc_opcion', 'opc_id');
		$usuario = Usuario::OrderBy('usr_id', 'desc')->pluck('usr_usuario', 'usr_id');
		$acceso  = Acceso::where('acc_estado', 'A')
			->join('_bp_opciones as o', 'o.opc_id', '=', '_bp_accesos.acc_opc_id')
			->join('_bp_roles as r', 'r.rls_id', '=', '_bp_accesos.acc_rls_id')
			->join('_bp_usuarios as u', 'u.usr_id', '=', '_bp_accesos.acc_usr_id')
			->get();
		return view('backend.administracion.admin.gbAccesos.index', compact('acceso, rol, opc, usuario'));
	}

	public function create() {
		$acceso = Acceso::getListar();
		return Datatables::of($acceso)->addColumn('acciones', function ($acceso) {
				return '<button value="'.$acceso->acc_id.'" class="btncirculo btn-xs btn-warning" onClick="MostrarAcceso(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button><button value="'.$acceso->acc_id.'" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
			})
			->editColumn('id', 'ID: {{$prs_id}}')	->
		addColumn('nombreCompleto', function ($nombres) {
				return $nombres->prs_nombres.' '.$nombres->prs_paterno.' '.$nombres->prs_materno;
			})
			->editColumn('id', 'ID: {{$prs_id}}')
			->make(true);
	}

	public function store(Request $request) {
		Acceso::create([
				'acc_rls_id' => $request['acc_rls_id'],
				'acc_opc_id' => $request['acc_opc_id'],
				'acc_usr_id' => 1,
			]);
		return redirect()->route('Acceso.index')->with('success', 'El acceso se registro correctamente');
	}
	public function show($id) {
		$acceso = Acceso::where('acc_id', $id)->update(['acc_estado' => 'B']);
		Session::flash('message', 'Acceso eliminado correctamente');
		return redirect()->route('Acceso.index')->with('success', 'El Acceso se elimino correctamente');

	}
	public function edit($id) {
		$rol    = Rol::OrderBy('rls_id', 'desc')->pluck('rls_rol', 'rls_id');
		$opc    = Opcion::OrderBy('opc_id', 'desc')->pluck('opc_opcion', 'opc_id');
		$acceso = Acceso::find($id);
		return view('admin.gbAccesos.update', compact('acceso', 'rol', 'opc'));
	}
	public function update(Request $request, $id) {
		$acceso = Acceso::find($id);
		$acceso->fill($request->all());
		$acceso->save();
		Session::flash('message', 'Acceso Editado Correctamente');
		return redirect()->route('Acceso.index')->with('success', 'El acceso se actualizo correctamente');
	}

	public function destroy($id) {

	}
}
