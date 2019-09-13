<?php

namespace siga\Http\Controllers\producto_terminado;

use Auth;
use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Http\Modelo\acopio\acopio_lacteos\Canastillo;
use siga\Modelo\insumo\insumo_recetas\Receta;
use Yajra\Datatables\Datatables;

class CanastilloController extends Controller {

	public function index() {
		$receta = Receta::orderBy('rece_id', 'desc')->pluck('rece_nombre', 'rece_id');
		//dd($receta);
		return view('backend.administracion.producto_terminado.datos.canastillos.index', compact('receta'));
	}

	public function create() {
		$canastillos = Canastillo::getListarCanastillos();
		return Datatables::of($canastillos)->addColumn('acciones', function ($canastillos) {
			return '<button value="' . $canastillos->ctl_id . '" class="btncirculo btn-xs btn-warning"
                		onClick="MostrarCanastillos(this);" data-toggle="modal" data-target="#myUpdateCanastillo"><i class="fa fa-pencil-square"></i></button>
            		<button value="' . $canastillos->ctl_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarCanastillo(this);"><i class="fa fa-trash-o"></i></button>';
		})
			->editColumn('ctl_foto_canastillo', '@if($ctl_foto_canastillo==null)
							<img src=img/sinfoto.png style="height:50px;width:50px;"/>
						@else
							<img src=archivo/canastillo/{{$ctl_foto_canastillo}} style="height:50px;width:50px;"/>
						@endif')
			->make(true);
	}

	public function store(Request $request) {
		$ids = Auth::user()->usr_id;
		//obtenemos el campo file definido en el formulario
		$file = $request->file('ctl_foto_canastillo');
		//obtenemos el nombre del archivo
		$nombreImagen = 'canastillo_' . time() . '_' . $file->getClientOriginalName();
		//indicamos que queremos guardar un nuevo archivo en el disco local
		\Storage::disk('canastillo')->put($nombreImagen, \File::get($file));
		if ($request->ajax()) {
			Canastillo::create([
				'ctl_descripcion' => strtoupper($request['ctl_descripcion']),
				'ctl_codigo' => strtoupper($request['ctl_codigo']),
				'ctl_rece_id' => $request['ctl_rece_id'],
				'ctl_altura' => strtoupper($request['ctl_altura']),
				'ctl_ancho' => strtoupper($request['ctl_ancho']),
				'ctl_largo' => $request['ctl_largo'],
				'ctl_peso' => $request['ctl_peso'],
				'ctl_material' => strtoupper($request['ctl_material']),
				'ctl_observacion' => strtoupper($request['ctl_observacion']),
				'ctl_logo' => strtoupper($request['ctl_logo']),
				'ctl_foto_canastillo' => $nombreImagen,
				'ctl_almacenamiento' => strtoupper($request['ctl_almacenamiento']),
				'ctl_transporte' => strtoupper($request['ctl_transporte']),
				'ctl_aplicacion' => strtoupper($request['ctl_aplicacion']),
				'ctl_usr_id' => $ids,
				'ctl_estado' => 'A',
			]);
			return response()->json(['Mensaje' => 'Canastillo creado']);
		} else {
			return response()->json(['Mensaje' => 'Canastillo no fue registrado']);
		}
		return response()->json();
	}

	public function show($id) {

	}

	public function edit($id) {
		$canastillos = Canastillo::getcanastillos($id);
		return response()->json($canastillos);
	}

	public function update(Request $request, $id) {
		$canastillos = Canastillo::getcanastillos($id);
		$canastillos->fill($request->all());
		$canastillos->save();
		return response()->json($canastillos->toArray());
	}

	public function destroy($id) {
		$canastillos = Canastillo::getDestroy($id);
		return response()->json($canastillos);
	}

	public function updateCanastillo(Request $request) {
		$ids_usr = Auth::user()->usr_id;
		//return response()->json($request->all());
		$file = $request->file('uimgCanastillo');
		//obtenemos el nombre del archivo
		if (empty($request->get('imgCapture'))) {
			if (empty($file)) {
				$nombreImagen = "sin_imagen";
			} else {
				$nombreImagen = 'canastillo_' . time() . '_' . $file->getClientOriginalName();
				//indicamos que queremos guardar un nuevo archivo en el disco local
				\Storage::disk('canastillo')->put($nombreImagen, \File::get($file));
			}
		} else {
			if (empty($file)) {
				$nombreImagen = $request->get('imgCapture');
			} else {
				$nombreImagen = 'canastillo_' . time() . '_' . $file->getClientOriginalName();
				//indicamos que queremos guardar un nuevo archivo en el disco local
				\Storage::disk('local')->put($nombreImagen, \File::get($file));
			}
		}
		$canastillo = Canastillo::find($request->get('ctl_id'));
		$canastillo->ctl_descripcion = $request->get('ctl_descripcion1');
		$canastillo->ctl_codigo = strtoupper($request->get('ctl_codigo1'));
		$canastillo->ctl_rece_id = strtoupper($request->get('ctl_rece_id1'));
		$canastillo->ctl_altura = strtoupper($request->get('ctl_altura1'));
		$canastillo->ctl_ancho = $request->get('ctl_ancho1');
		$canastillo->ctl_largo = $request->get('ctl_largo1');
		$canastillo->ctl_peso = strtoupper($request->get('ctl_peso1'));
		$canastillo->ctl_material = $request->get('ctl_material1');
		$canastillo->ctl_observacion = $request->get('ctl_observacion1');
		$canastillo->ctl_logo = $request->get('ctl_logo1');
		$canastillo->ctl_almacenamiento = $request->get('ctl_almacenamiento1');
		$canastillo->ctl_transporte = $request->get('ctl_transporte1');
		$canastillo->ctl_aplicacion = $request->get('ctl_aplicacion1');
		$canastillo->ctl_foto_canastillo = $nombreImagen;
		$canastillo->save();
		return response()->json(['mensaje' => 'Se actualizo la canastillo']);
	}

}
