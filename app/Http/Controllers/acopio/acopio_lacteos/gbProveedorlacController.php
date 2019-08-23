<?php
namespace siga\Http\Controllers\acopio\acopio_lacteos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use siga\Http\Requests;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Persona;
use siga\Modelo\admin\Usuario;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\EstadoCivil;
use siga\Modelo\acopio\acopio_lacteos\ProveedorL;
use siga\Modelo\acopio\acopio_almendra\Departamento;

use Auth;

class gbProveedorlacController extends Controller
{
    public function index()
    {
        $exp=Departamento::comboExp();
        $dep=Departamento::comboDep();
        $proveedor=ProveedorL::orderBy('prov_id','DESC')->paginate(10);
        return view('backend.administracion.acopio.acopio_lacteos.proveedor.index',compact('proveedor', 'exp', 'dep'));         
    }

    public function create()
    {
        $proveedor = ProveedorL::getListar();
        return Datatables::of($proveedor)->addColumn('acciones', function ($proveedor) {
            return '<button value="' . $proveedor->prov_id . '" class="btncirculo btn-xs btn-primary" style="background:#FF8C00" onClick="MostrarProveedor(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button><button value="' . $proveedor->prov_id . '" class="btncirculo btn-xs btn-warning" style="background:#DC143C" onClick="EliminarPRov(this);"><i class="fa fa-trash-o"></i></button>';
        })
            ->editColumn('id', 'ID: {{$prov_id}}')->
            addColumn('nombreCompleto', function ($nombres) {
            return $nombres->prov_nombre . ' ' . $nombres->prov_ap . ' ' . $nombres->prov_am;
        })
            ->editColumn('id', 'ID: {{$prov_id}}')
            -> addColumn('lugarprov', function ($pal) {
                if($pal->prov_lugar==1)
                { return '<h5 class="text-center">Planta</h5>'; }
                return '<h5 class="text-center">Centro de Acopio</h5>'; 
             }) 
             -> addColumn('tipoprov', function ($pal) {
                if($pal->prov_id_tipo==1)
                { return '<h5 class="text-center">Proveedor</h5>'; }
                return '<h5 class="text-center">Sub Proveedor</h5>'; 
             }) 

            ->make(true);
    }

    public function store(Request $request)
    {    
        $this->validate(request(), [
                'nombres' => 'required',
                'paterno' => 'required',    
                'materno' => 'required',
                'ci' => 'required',     
                'expedido' => 'required|min:1',    
                'lugar_proveedor' => 'required|min:1',
                'departamento' => 'required|min:1', 
                'municipio' => 'required|min:1',  
                'tipo_proveedor' => 'required|min:1',                 
        ]); 
        $fecha1=date('d/m/Y');
       //obtenemos el campo file definido en el formulario
       $file = $request->file('imgProveedorL');
 
       //obtenemos el nombre del archivo
       //$nombreImagenL = 'ProveedorL_'.time().'_'.$file->getClientOriginalName();
 
       //indicamos que queremos guardar un nuevo archivo en el disco local
       //\Storage::disk('local')->put($nombreImagenL,  \File::get($file));
        
        
        ProveedorL::create([
            'prov_nombre'         => $request['nombres'],
            'prov_ap'             => $request['paterno'],
            'prov_am'             => $request['materno'],
            'prov_ci'             => $request['ci'],
            'prov_exp'            => $request['expedido'],
            'prov_tel'            => $request['pro_tel'],
            'prov_foto'           => $request['imgProveedorL'],
            'prov_direccion'      => 'NN',
            'prov_departamento'   => $request['departamento'],
            'prov_id_municipio'   => $request['municipio'],
            'prov_id_comunidad'   => 26,
            'prov_id_asociacion'  => 1,
            'prov_estado'         => 'A',
            'prov_fecha_reg'      => $fecha1,
            'prov_rau'            => 0,
            'prov_id_tipo'        => $request['tipo_proveedor'],
            'prov_id_convenio'    => 1,
           // 'id_usuario'        => Auth::user()->usr_id,
            'prov_lugar'          => $request['lugar_proveedor'],
            'prov_id_linea'       => 2,  
            'prov_id_recep'       => 1,

        ]);

        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function edit($id)
    {

        $proveedor = ProveedorL::setBuscar($id);
        return response()->json($proveedor);

    }

    public function update(Request $request, $id)
    {
        $proveedor = ProveedorL::setBuscar($id);
        $proveedor->fill($request->all());
        $proveedor->save();
        return response() -> json($proveedor -> toArray());
       // return response()->json(['mensaje' => 'Se actualizo el proveedor']);

     

    }

    public function show($id)
    {

    }

    public function destroy($id)
    {
        $proveedor = ProveedorL::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

}
