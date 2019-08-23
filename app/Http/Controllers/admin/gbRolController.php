<?php

namespace siga\Http\Controllers\admin;

use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Rol;
use siga\Modelo\acopio\acopio_almendra\LineaTrabajo;
use Illuminate\Http\Request;
use Redirect;
use Yajra\Datatables\Datatables;

class gbRolController extends Controller {

	public function index() {
		$rol = Rol::getListar();
		$linea_trabajo = LineaTrabajo::combo();
		return view('backend.administracion.admin.gbRoles.index', compact('rol','linea_trabajo'));
	}

	public function create() {
		$rol = Rol::getListar();
		return Datatables::of($rol)->addColumn('acciones', function ($rol) {
				return '<button value="'.$rol->rls_id.'" class="btncirculo btn-xs btn-warning" onClick="Mostrar(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button>
            <button value="'.$rol->rls_id.'" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
			})->editColumn('id', 'ID: {{$rls_id}}')->
            addColumn('areaProd', function ($areaProd) {
                if ($areaProd->rls_linea_trabajo == 1) {
                    return '<h4 class="text-center"><span class="label label-success">Almendra</span></h4>';
                } elseif ($areaProd->rls_linea_trabajo == 2){
               	 	return '<h4 class="text-center"><span class="label label-primary">Lacteos</span></h4>';
               	} elseif ($areaProd->rls_linea_trabajo == 3){
               	 	return '<h4 class="text-center"><span class="label label-warning">Miel</span></h4>';
            	} elseif ($areaProd->rls_linea_trabajo == 4) {
                	return '<h4 class="text-center"><span class="label label-danger">Frutos</span></h4>';
            	}
       	})	
			->editColumn('id', 'ID: {{$rls_id}}')
			->make(true);
	}

	public function store(Request $request) {
		Rol::create([
				'rls_rol'    => $request['rls_rol'],
				'rls_usr_id' => 1,
				'rls_estado' => 'A',
				'rls_linea_trabajo' => $request['linea_trabajo'],
			]);
		return redirect()->route('Rol.index')->with('success', 'El rol se registro correctamente');
	}

	public function show($id) {

	}

	public function edit($id) {

		$rol = Rol::setBuscar($id);
		return response()->json($rol);
	}

	public function update(Request $request, $id) {

		$rol = Rol::setBuscar($id);

		$rol->fill($request->all());
		$rol->save();
		return response()->json($rol->toArray());
	}

	public function destroy($id) {
		$rol = Rol::getDestroy($id);
		return response()->json($rol);

	}
}