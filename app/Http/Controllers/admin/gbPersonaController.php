<?php
namespace siga\Http\Controllers\admin;

use Auth;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\EstadoCivil;
use siga\Modelo\admin\Persona;
use siga\Modelo\admin\Usuario;
use siga\Modelo\admin\Rol;
use siga\Modelo\acopio\acopio_almendra\LineaTrabajo;
use siga\Modelo\acopio\acopio_almendra\TipoGarantia;
use siga\Modelo\acopio\acopio_almendra\Departamento;
use siga\Modelo\acopio\acopio_almendra\TipoRelacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Session;

class gbPersonaController extends Controller {
	public function index() {
		$idrol=Session::get('ID_ROL');
		if ($idrol == 1 || $idrol == 9 || $idrol == 8 || $idrol == 22 || $idrol == 29) {
			$pers1   = Persona::OrderBy('prs_id', 'desc')->pluck('prs_nombres', 'prs_id');
			$usuario = Usuario::OrderBy('usr_id', 'desc')->pluck('usr_usuario', 'usr_id');
			$data    = EstadoCivil::combo();
			$dataList = LineaTrabajo::combo();
			$dataRol = Rol::combo();
			$dataTipg = TipoGarantia::combo();
			$dataExp = Departamento::comboExp();
			$dataRel = TipoRelacion::combo();
			$dataRel1 = TipoRelacion::combo1();
			return view('backend.administracion.admin.gbPersonas.index', compact('pers1', 'usuario', 'data','dataList','dataRol','dataTipg','dataExp','dataRel','dataRel1'));
		}else{
			return redirect('/home');
		}
		
	}

	public function create() {
		$personas = Persona::getListar();
		return Datatables::of($personas)->addColumn('acciones', function ($persona) {
				return '<button value="'.$persona->prs_id.'" class="btncirculo btn-xs btn-warning" onClick="MostrarPersona(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button>
            <button value="'.$persona->prs_id.'" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
			})
			->editColumn('id', 'ID: {{$prs_id}}')	->
		addColumn('nombreCompleto', function ($nombres) {
				return $nombres->prs_nombres.' '.$nombres->prs_paterno.' '.$nombres->prs_materno;
			})->editColumn('id', 'ID: {{$prs_id}}')->
            addColumn('areaProd', function ($areaProd) {
                if ($areaProd->prs_linea_trabajo == 1) {
                    return '<h4 class="text-center"><span class="label label-success">Almendra</span></h4>';
                } elseif ($areaProd->prs_linea_trabajo == 2){
               	 	return '<h4 class="text-center"><span class="label label-primary">Lacteos</span></h4>';
               	} elseif ($areaProd->prs_linea_trabajo == 3){
               	 	return '<h4 class="text-center"><span class="label label-warning">Miel</span></h4>';
            	} elseif ($areaProd->prs_linea_trabajo == 4) {
                	return '<h4 class="text-center"><span class="label label-danger">Frutos</span></h4>';
            	}
        })			->editColumn('id', 'ID: {{$prs_id}}')
			->make(true);
	}

	public function store(Request $request) {
		Persona::create([
				'prs_nombres'            => $request['prs_nombres'],
				'prs_paterno'            => $request['prs_paterno'],
				'prs_materno'            => $request['prs_materno'],
				'prs_ci'                 => $request['prs_ci'],
				'prs_direccion'          => $request['prs_direccion'],
				'prs_direccion2'         => $request['prs_direccion2'],
				'prs_telefono'           => $request['prs_telefono'],
				'prs_telefono2'          => $request['prs_telefono2'],
				'prs_celular'            => $request['prs_celular'],
				'prs_empresa_telefonica' => 'Ninguna',
				'prs_correo'             => $request['prs_correo'],
				'prs_id_estado_civil'    => $request['prs_id_estado_civil'],
				'prs_sexo'               => $request['prs_sexo'],
				'prs_fec_nacimiento'     => $request['prs_fec_nacimiento'],
				'prs_id_archivo_cv'      => 1,
				'prs_usr_id'             => Auth::user()->usr_id,

				'prs_linea_trabajo'      => $request['prs_linea_trabajo'],
				'prs_id_garantia'        => $request['prs_id_garantia'],
				'prs_id_relacion'        => $request['prs_id_relacion'],
				//'prs_id_produccion'      => $request['prs_id_produccion'],
				'prs_id_tipopersona'     => $request['prs_id_tipopersona'],
				'prs_id_zona'            => $request['prs_id_zona'],
				'prs_nomparentesco'      => $request['prs_nomparentesco'],
				'prs_ciparentesco'       => $request['prs_ciparentesco'],
				'prs_exparentesco'       => $request['prs_exparentesco'],
				'prs_numbien'            => $request['prs_numbien'],
				'prs_valorbien'          => $request['prs_valorbien'],
			]);

		return response()->json(['Mensaje' => 'Se registro correctamente']);
	}

	public function edit($id) {

		$persona = Persona::find($id);

		$data = \DB::table('_bp_estados_civiles')
			->select('estcivil_id', 'estcivil')
			->where('estcivil_estado', 'A')
			->get();

		return response()->json($persona->toArray());
	}

	public function update(Request $request, $id) {
		$persona = Persona::find($id);
		$persona->fill($request->all());
		$persona->save();
		return response()->json(['mensaje' => 'Se actualizo la persona']);
	}

	public function show($id) {

	}

	public function destroy($id) {
		$persona = Persona::getDestroy($id);
		return response()->json(['mensaje' => 'Se elimino correcta,ente']);
	}

}
