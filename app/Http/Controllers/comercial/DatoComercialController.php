<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use siga\Http\Modelo\comercial\TipoPv;
use siga\Http\Modelo\comercial\Producto;
use DB;
use Auth;

class DatoComercialController extends Controller
{
    public function index()
    {
    	return view('backend.administracion.comercial.datos.tipo_pv.index');
    }

    public function create()
    {
    	//$tipopv = DB::table('comercial.tipo_pv_comercial')->get();
    	$tipopv = TipoPv::where('tipopv_estado','A')->get();
    	return Datatables::of($tipopv)->addColumn('acciones', function ($tipopv) {
				return '<button value="'.$tipopv->tipopv_id.'" class="btncirculo btn-xs btn-warning" onClick="MostrarTipoPv(this);" data-toggle="modal" data-target="#myUpdateTipoPv"><i class="fa fa-pencil-square"></i></button>
            <button value="'.$tipopv->tipopv_id.'" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
			})
			->editColumn('id', 'ID: {{$tipopv_id}}')
			->make(true);
    }

    public function store(Request $request) {
		TipoPv::create([
				'tipopv_nombre'        => $request['tipopv_nombre'],
				'tipopv_descripcion'   => $request['tipopv_descripcion'],
				'tipopv_usr_id'        => Auth::user()->usr_id,
			]);

		return response()->json(['Mensaje' => 'Se registro correctamente']);
	}

	public function edit($id) {

		$tipopv = TipoPv::find($id);
		return response()->json($tipopv->toArray());
	}

	public function update(Request $request, $id) {
		$tipopv = TipoPv::find($id);
		$tipopv->fill($request->all());
		$tipopv->save();
		return response()->json(['mensaje' => 'Se actualizo el tipo de punto de venta']);
	}

	public function show($id) {

	}

	public function destroy($id) {
		$tipopv = TipoPv::find($id);
		$tipopv->tipopv_estado = 'B';
		$tipopv->save();
		return response()->json(['mensaje' => 'Se elimino correcta,ente']);
	}

	//PRODUCTOS
	public function indexProductos()
	{
		$productos = Producto::join('insumo.receta as rece', 'comercial.producto_comercial.prod_rece_id','=','rece.rece_id')
									->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
									->get();
		return view('backend.administracion.comercial.datos.productos.index', compact('productos'));
	}
	public function mostrarProducto($id)
	{
		$producto = Producto::join('insumo.receta as rece', 'comercial.producto_comercial.prod_rece_id','=','rece.rece_id')
							->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
							->where('prod_id',$id)->first();
		return response()->json($producto->toArray());
	}
}
