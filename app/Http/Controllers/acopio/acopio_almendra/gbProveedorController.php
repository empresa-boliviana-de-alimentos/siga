<?php

namespace siga\Http\Controllers\acopio\acopio_almendra;

use Illuminate\Http\Request;
use siga\Http\Requests;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_almendra\Proveedor;
use siga\Modelo\acopio\acopio_almendra\Municipio;
use siga\Modelo\acopio\acopio_almendra\Comunidad;
use siga\Modelo\acopio\acopio_almendra\Asociacion;
use siga\Modelo\acopio\acopio_almendra\Tipo_Proveedor;
use siga\Modelo\acopio\acopio_almendra\Departamento;
use siga\Modelo\admin\Usuario;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Redirect;
use Carbon\Carbon;
use PDF;
use Auth;
use Session;

class gbProveedorController extends Controller
{
    public function index()
    {
        $Proveedor = Proveedor::getListar();
        $dataMuni = Municipio::combo();
        $dataComu = Comunidad::combo();
        $dataSoc = Asociacion::combo();
        $dataTipoProv = Tipo_Proveedor::combo();
        $dataDep = Departamento::comboDep();
        $dataExp = Departamento::comboExp();
	$usuario = Usuario::getListar();
        return view('backend.administracion.acopio.acopio_almendra.gbProveedores.index', compact('Proveedor','dataMuni','dataComu', 'dataSoc','dataTipoProv', 'dataDep', 'dataExp','usuario'));
    }

    public function create()
    {   
        $idrol=Session::get('ID_ROL');
        if ($idrol == 13) {
            $Proveedor = Proveedor::join('acopio.departamento as dep', 'acopio.proveedor.prov_exp', '=', 'dep.dep_id')
                                    ->where('prov_estado', 'A')
                                    // ->where('prov_id_usr', $user)
                                    ->where('prov_id_linea', 1)
                                    ->where('prov_id_tipo',3)
                                    ->get();
        }else{
            $Proveedor = Proveedor::getListar();
        }
        
        return Datatables::of($Proveedor)->addColumn('acciones', function ($Proveedor) {
            return '<button value="' . $Proveedor->prov_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarProveedor(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button><button value="' . $Proveedor->prov_id . '" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
        })
            ->editColumn('id', 'ID: {{$prov_id}}')
            ->addColumn('ci', function ($ci) {
            return $ci->prov_ci . ' ' . $ci->dep_exp;
        })
            //->editColumn('id', 'ID: {{$prov_id}}')
            ->make(true);
    }

    public function store(Request $request)
    {
        //obtenemos el campo file definido en el formulario
      // $file = $request->file('imgProveedor');
 
       //obtenemos el nombre del archivo
       //$nombreImagen = 'Proveedor_'.time().'_'.$file->getClientOriginalName();
 
       //indicamos que queremos guardar un nuevo archivo en el disco local
       //\Storage::disk('local')->put($nombreImagen,  \File::get($file));
	$date = Carbon::now();
        Proveedor::create([
             'prov_nombre'         => $request['prov_nombre'],
            'prov_ap'             => $request['prov_ap'],
            'prov_am'             => $request['prov_am'],
            'prov_ci'             => $request['prov_ci'],
            'prov_exp'            => $request['prov_exp'],
            'prov_tel'         	  => $request['prov_tel'],
            'prov_id_tipo'        => $request['prov_id_tipo'],
            'prov_id_convenio'    => $request['prov_id_convenio'],
            'prov_departamento'   => $request['prov_departamento'],
            'prov_id_municipio'   => $request['prov_id_municipio'],
            'prov_id_comunidad'   => $request['prov_id_comunidad'],
            'prov_id_asociacion'  => $request['prov_id_asociacion'],
            'prov_estado'         => "A",
            'prov_fecha_reg'	  => $date,
            'prov_id_linea'	      => 1,
            'prov_id_usr'         => Auth::user()->usr_id,
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function registraMunicipio(Request $request)
    {
        Municipio::create([
            'mun_nombre'           => $request['mun_nombre'],
            'mun_id_dep'   		   => $request['mun_id_dep'],
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function registraComunidad(Request $request)
    {
        Comunidad::create([
            'com_nombre'         => $request['com_nombre'],
            'com_id_mun'         => $request['com_id_mun'],
            'com_estado'         => 'A',
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

     public function registraAsociacion(Request $request)
    {
        Asociacion::create([
            'aso_nombre'          => $request['aso_nombre'],
            'aso_sigla'           => $request['aso_sigla'],
            'aso_id_mun'          => $request['aso_id_mun'],
            'aso_estado'          => 'A',
            'aso_fecha_reg'       => "2018-10-10 14:20:00",
            'aso_id_usr'          => 1,
            'aso_id_linea'        => 1,
           // 'prs_usr_id'             => Auth::user()->usr_id,
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function edit($id)
    {
        $proveedor = Proveedor::setBuscar($id);
        return response()->json($proveedor);
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::setBuscar($id);
        $proveedor->fill($request->all());
        $proveedor->save();
        return response()->json($proveedor->toArray());
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::getDestroy($id);
        return response()->json($proveedor);

    }
 }
