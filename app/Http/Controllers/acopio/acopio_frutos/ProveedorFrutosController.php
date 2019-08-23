<?php

namespace siga\Http\Controllers\acopio\acopio_frutos;

use Illuminate\Http\Request;

use siga\Http\Requests;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_frutos\ProveedorF;
use siga\Modelo\acopio\acopio_frutos\Municipio;
use siga\Modelo\acopio\acopio_frutos\Comunidad;
use siga\Modelo\acopio\acopio_frutos\Asociacion;
//use siga\Modelo\acopio\acopio_frutos\Tipo_Proveedor;
use siga\Modelo\acopio\acopio_frutos\Departamento;
use siga\Modelo\acopio\acopio_frutos\Provincia;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\Usuario;
use Auth;

class ProveedorFrutosController extends Controller
{
    public function index()
    {
    	//return view('backend.administracion.acopio.acopio_frutos.proveedor.index');
    	$proveedor = ProveedorF::getListar();
      //  $combo = Departamento:: comboDep();
        $exp = Departamento:: comboExp();
        $municipio = Municipio::OrderBy('mun_id', 'desc')->pluck('mun_nombre', 'mun_id');
        $comunidad = Comunidad::OrderBy('com_id', 'desc')->pluck('com_nombre', 'com_id');
        $asociacion = Asociacion::OrderBy('aso_id', 'desc')->pluck('aso_nombre', 'aso_id');
        $provincia = Provincia::OrderBy('provi_id', 'desc')->pluck('provi_nom', 'provi_id');
        $departamento = Departamento::OrderBy('dep_id', 'desc')->pluck('dep_nombre', 'dep_id');
   		return view('backend.administracion.acopio.acopio_frutos.proveedor.index', compact('proveedor','municipio','comunidad','asociacion', 'departamento', 'exp', 'provincia'));

    }
     public function create()
    {
        $proveedor = ProveedorF::getListar();
        return Datatables::of($proveedor)->addColumn('acciones', function ($proveedor) {
            return '<button value="' . $proveedor->prov_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarPersona(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button><button value="' . $proveedor->prov_id . '" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
        })
            ->editColumn('id', 'ID: {{$prov_id}}')->
            addColumn('nombreCompleto', function ($nombres) {
            return $nombres->prov_nombre;
        })
            ->editColumn('id', 'ID: {{$prov_id}}')->
            addColumn('tipoProv', function ($tipoProv) {
                if ($tipoProv->prov_id_tipo == 1) {
                    return '<h4 class="text-center"><span class="label label-success">Proveedor</span></h4>';
                } elseif ($tipoProv->prov_id_tipo == 2){
                return '<h4 class="text-center"><span class="label label-primary">Productor</span></h4>';
            } 
            // else {
            //     return '<h4 class="text-center"><span class="label label-warning">Proveedor Externo</span></h4>';
            // }
        })
            ->editColumn('id', 'ID: {{$prov_id}}')
            ->make(true);
    }
   public function store(Request $request)
    {	
        //obtenemos el campo file definido en el formulario
      // $file = $request->file('imgProveedor');
 
       //obtenemos el nombre del archivo
       //$nombreImagen = 'ProveedorMiel_'.time().'_'.$file->getClientOriginalName();
 
       //indicamos que queremos guardar un nuevo archivo en el disco local
     //  \Storage::disk('local')->put($nombreImagen,  \File::get($file));

        $comunidad=Comunidad::create([
                'com_nombre'       => $request['com_nombre'],
                'com_estado'       => 'A',
                'com_id_prov'      => $request['provincia'],
                'com_id_linea'     => 4,
            ]);
        $comu_id = $comunidad->com_id;
        $prov = $comunidad->com_id_prov; 
        $fecha=date('d/m/Y');
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        ProveedorF::create([
            'prov_nombre'       => $request['nombres'],
            'prov_ap'           => $request['apellido_paterno'],
            'prov_am'           => $request['apellido_materno'],
            'prov_ci'           => $request['ci'],
            'prov_exp'          => $request['exp'],
            'prov_tel'          => $request['telefono'],
            'prov_direccion'    => $request['direccion'],
            //'prov_foto'         => $nombreImagen,
            'prov_departamento' => $request['id_departamento'],
            'prov_id_municipio' => 1,
            'prov_id_comunidad' => $comu_id,
            'prov_id_asociacion'=> 1,
            'prov_estado'     	=> 'A',
            'prov_fecha_reg'    => $fecha,
            'prov_id_tipo'		=> $request['id_tipo_prov'],
            'prov_id_convenio'	=> $request['id_convenio'],
            'prov_lugar'        => 1,
            'prov_id_linea'     => 4,
            'prov_id_recep'     => 1,
            'prov_rau'          => $request['prov_rau'],
            'prov_id_usr'       => Auth::user()->usr_id,
            'prov_id_provincia' => $prov,
            'prov_id_planta'    => $planta['id_planta'],
        ]);

        return response()->json($comunidad);
       // return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function edit($id)
    {
        $proveedor = ProveedorF::setBuscar($id);
        return response()->json($proveedor);
    }

    public function update(Request $request, $id)
    {
        $proveedor = ProveedorM::find($id);
        $proveedor->fill($request->all());
        $proveedor->save();
        return response()->json(['mensaje' => 'Se actualizo el proveedor']);
    }
    public function show($id)
    {

    }
    public function destroy($id)
    {
        $proveedor = ProveedorM::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }
}
