<?php

namespace siga\Http\Controllers\acopio\acopio_miel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use siga\Http\Requests;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_miel\Proveedor;
use siga\Modelo\acopio\acopio_miel\Municipio;
use siga\Modelo\acopio\acopio_miel\Comunidad;
use siga\Modelo\acopio\acopio_miel\Asociacion;
use siga\Modelo\acopio\acopio_miel\Tipo_Proveedor;
use siga\Modelo\acopio\acopio_miel\Departamento;
use siga\Modelo\acopio\acopio_miel\Contrato;
use siga\Modelo\acopio\acopio_miel\Pagos;
use siga\Modelo\admin\Usuario;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\Input;//NUEVO

class ProveedorMielController extends Controller
{
   public function index()
   {
   		$proveedor = Proveedor::getListar();
        $municipio = Municipio::OrderBy('mun_id', 'desc')->pluck('mun_nombre', 'mun_id');
        $comunidad = Comunidad::OrderBy('com_id', 'desc')->pluck('com_nombre', 'com_id');
        $asociacion = Asociacion::OrderBy('aso_id', 'desc')->pluck('aso_nombre', 'aso_id');
        $tipo_proveedor = Tipo_Proveedor::OrderBy('tprov_id','asc')->where('tprov_id_linea','=',3)->pluck('tprov_tipo','tprov_id');
        $departamento = Departamento::OrderBy('dep_id', 'asc')->pluck('dep_nombre','dep_id');
        $dep_exp = Departamento::OrderBy('dep_id','asc')->pluck('dep_exp','dep_id');
   		return view('backend.administracion.acopio.acopio_miel.proveedor.index', compact('proveedor','municipio','comunidad','asociacion','tipo_proveedor','departamento','dep_exp'));
   }

   public function create()
    {
        $proveedor = Proveedor::getListar();
        return Datatables::of($proveedor)->addColumn('acciones', function ($proveedor) {
            return '<button value="' . $proveedor->prov_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarPersona(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button><button value="' . $proveedor->prov_id . '" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
        })
            ->editColumn('id', 'ID: {{$prov_id}}')->
            addColumn('nombreCompleto', function ($nombres) {
            return $nombres->prov_nombre;
        })
            ->editColumn('id', 'ID: {{$prov_id}}')->
            addColumn('tipoProv', function ($tipoProv) {
                if ($tipoProv->prov_id_tipo == 9) {
                    return '<h4 class="text-center"><span class="label label-success">Productor Apicola</span></h4>';
                } elseif ($tipoProv->prov_id_tipo == 10){
                return '<h4 class="text-center"><span class="label label-primary">Proveedor Apicola</span></h4>';
            } else {
                return '<h4 class="text-center"><span class="label label-warning">Proveedor Apicola por Convenio</span></h4>
                <div class="text-center"><button value="'.$tipoProv->prov_id.'" class="btn btn-xs btn-primary" onClick="MostrarProvContrato(this);" data-toggle="modal" data-target="#myContrato"><i class="fa fa-pencil-square"> Nuevo Contrato</i></button><button value="'.$tipoProv->prov_id.'" class="btn btn-xs btn-success" onClick="MostrarListaContratos(this);" data-toggle="modal" data-target="#myListContrato"><i class="fa fa-pencil-square"> Lista Contratos</i></button></div>';
            }
        })
            ->editColumn('id', 'ID: {{$prov_id}}')
            ->make(true);
    }
   public function store(Request $request)
    {	
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();        
        if ($request['tipo_proveedor'] == 11) {
            $this->validate(request(), [
                'nombres' => 'required',
                'apellido_paterno' => 'required',
                'ci' => 'required|unique:pgsql.acopio.proveedor,prov_ci',
                'exp' => 'required',
                'departamento' => 'required',
                'municipio' => 'required',
                'comunidad' => 'required',
                'asociacion' => 'required',
                'tipo_proveedor' => 'required',
                'nro_contrato' => 'required',
                'monto_prestamo' => 'numeric|required|min:100',
            ]);
            $file = $request->file('imgProveedor');
            if ($file) {
                //obtenemos el nombre del archivo
               $nombreImagen = 'ProveedorMiel_'.time().'_'.$file->getClientOriginalName();     
               //indicamos que queremos guardar un nuevo archivo en el disco local
               \Storage::disk('local')->put($nombreImagen,  \File::get($file));
            } else {
                $nombreImagen = 'sin_foto.png';
            }
            //DOCUMENTO PDF
            $file_doc = $request->file('archivo_pdf');
            // dd($file_doc);
            if ($file_doc) {
                //obtenemos el nombre del archivo
               $nombrePdf = 'Documento_ProveedorMiel_'.time().'_'.$file_doc->getClientOriginalName();     
               //indicamos que queremos guardar un nuevo archivo en el disco local
               \Storage::disk('local_doc_prov')->put($nombrePdf,  \File::get($file_doc));
            } else {
                $nombrePdf = 'sin_doc_escaneado';
            }
            $proveedor = Proveedor::create([
                'prov_nombre'       => $request['nombres'],
                'prov_ap'           => $request['apellido_paterno'],
                'prov_am'           => $request['apellido_materno'],
                'prov_ci'           => $request['ci'],
                'prov_exp'          => $request['exp'],
                'prov_tel'          => $request['telefono'],
                'prov_direccion'    => $request['direccion'],
                'prov_foto'         => $nombreImagen,
                'prov_nit'          => $request['nit'],
                'prov_cuenta'       => $request['cuenta_bancaria'],
                'prov_departamento' => $request['departamento'],
                'prov_id_municipio' => $request['municipio'],
                'prov_id_comunidad' => $request['comunidad'],
                'prov_id_asociacion'=> $request['asociacion'],
                'prov_estado'       => 'A',
                'prov_fecha_reg'    => $request['fecha_registro'],
                'prov_rau'          => $request['id_rau'],
                'prov_id_tipo'      => $request['tipo_proveedor'],
                'prov_id_convenio'  => null,
                'prov_lugar'        => null,
                'prov_id_linea'     => 3,
                'prov_id_recep'     => null,
                'prov_latitud'      => $request['lat_map'],
                'prov_longitud'     => $request['lng_map'],
                'prov_id_usr'       => Auth::user()->usr_id,
                'prov_id_planta'    => $planta->id_planta,
                'prov_fecha_insrau' => $request['fecha_inscripcion'],
                'prov_fecha_venrau' => $request['fecha_vencimiento'],
                'prov_doc_pdf'      => $nombrePdf
            ]);
            $prov_id = $proveedor->prov_id;
            $monto_pagar = $request['monto_prestamo']/7;
            // dd($prov_id);
            Contrato::create([
                'contrato_id_prov' => $prov_id,
                'contrato_nro' => $request['nro_contrato'],
                'contrato_precio' => $request['monto_prestamo'],
                'contrato_deuda'=> $monto_pagar,
                'contrato_sindicato' => '',
                'contrato_central' => '',
                'contrato_saldo' => 0,
            ]);
        } else {
            $this->validate(request(), [
                'nombres' => 'required',
                'apellido_paterno' => 'required',
                'ci' => 'required|unique:pgsql.acopio.proveedor,prov_ci',
                'exp' => 'required',
                'departamento' => 'required',
                'municipio' => 'required',
                'comunidad' => 'required',
                'asociacion' => 'required',
                'tipo_proveedor' => 'required',
            ]);
            $file = $request->file('imgProveedor');
            if ($file) {
                //obtenemos el nombre del archivo
               $nombreImagen = 'ProveedorMiel_'.time().'_'.$file->getClientOriginalName();     
               //indicamos que queremos guardar un nuevo archivo en el disco local
               \Storage::disk('local')->put($nombreImagen,  \File::get($file));
            } else {
                $nombreImagen = 'sin_foto.png';
            }
            //DOCUMENTO PDF
            $file_doc = $request->file('archivo_pdf');
            // dd($file_doc);
            if ($file_doc) {
                //obtenemos el nombre del archivo
               $nombrePdf = 'Documento_ProveedorMiel_'.time().'_'.$file_doc->getClientOriginalName();     
               //indicamos que queremos guardar un nuevo archivo en el disco local
               \Storage::disk('local_doc_prov')->put($nombrePdf,  \File::get($file_doc));
            } else {
                $nombrePdf = 'sin_doc_escaneado';
            }
            Proveedor::create([
                'prov_nombre'       => $request['nombres'],
                'prov_ap'           => $request['apellido_paterno'],
                'prov_am'           => $request['apellido_materno'],
                'prov_ci'           => $request['ci'],
                'prov_exp'          => $request['exp'],
                'prov_tel'          => $request['telefono'],
                'prov_direccion'    => $request['direccion'],
                'prov_foto'         => $nombreImagen,
                'prov_nit'          => $request['nit'],
                'prov_cuenta'       => $request['cuenta_bancaria'],
                'prov_departamento' => $request['departamento'],
                'prov_id_municipio' => $request['municipio'],
                'prov_id_comunidad' => $request['comunidad'],
                'prov_id_asociacion'=> $request['asociacion'],
                'prov_estado'       => 'A',
                'prov_fecha_reg'    => $request['fecha_registro'],
                'prov_rau'          => $request['id_rau'],
                'prov_id_tipo'      => $request['tipo_proveedor'],
                'prov_id_convenio'  => $request['id_convenio'],
                'prov_lugar'        => null,
                'prov_id_linea'     => 3,
                'prov_id_recep'     => null,
                'prov_latitud'      => $request['lat_map'],
                'prov_longitud'     => $request['lng_map'],
                'prov_id_usr'       => Auth::user()->usr_id,
                'prov_id_planta'    => $planta->id_planta,
                'prov_fecha_insrau' => $request['fecha_inscripcion'],
                'prov_fecha_venrau' => $request['fecha_vencimiento'],
                'prov_doc_pdf'      => $nombrePdf
            ]);
        }
        
        return response()->json(['Mensaje' => 'Se registro correctamente']);
         
 
    }

    public function edit($id)
    {

        $proveedor = Proveedor::find($id);

        return response()->json($proveedor->toArray());
    }

    // public function update(Request $request, $id)
    // {   
    //     $file1 = $request->file('imgProveedor1');
    //     dd($request);
    //     $proveedor = Proveedor::find($id);
    //     $proveedor->fill($request->all());
    //     $proveedor->save();
    //     return response()->json(['mensaje' => 'Se actualizo el proveedor']);
    // }
    // UPDATE A PROVEEDOR CON IMAGEN
    public function proveedorMielUpdate(Request $request, $id)
    {   
        $file1 = $request->file('imgProveedor1');
        if ($file1) {
                //obtenemos el nombre del archivo
               $nombreImagen1 = 'ProveedorMiel_'.time().'_'.$file1->getClientOriginalName();     
               //indicamos que queremos guardar un nuevo archivo en el disco local
               \Storage::disk('local')->put($nombreImagen1,  \File::get($file1));
        } else {
                $nombreImagen1 = $request['imagenActual'];
        }
        $fileDoc1 = $request->file('archivo_pdf1');
        if ($fileDoc1) {
                //obtenemos el nombre del archivo
               $nombreDoc1 = 'Documento_ProveedorMiel_'.time().'_'.$fileDoc1->getClientOriginalName();     
               //indicamos que queremos guardar un nuevo archivo en el disco local
               \Storage::disk('local_doc_prov')->put($nombreDoc1,  \File::get($fileDoc1));
        } else {
                $nombreDoc1 = $request['doc_actual_nombre'];
        }
        $proveedor = Proveedor::find($id);
        $proveedor->fill($request->all());
        $proveedor->prov_nombre = $request['nombres'];
        $proveedor->prov_ap = $request['apellido_paterno'];
        $proveedor->prov_am = $request['apellido_materno'];
        $proveedor->prov_ci = $request['ci'];
        $proveedor->prov_exp = $request['exp'];
        $proveedor->prov_tel = $request['telefono'];
        $proveedor->prov_foto = $nombreImagen1;
        $proveedor->prov_departamento = $request['id_departamento'];
        $proveedor->prov_id_municipio = $request['id_municipio1'];
        $proveedor->prov_id_comunidad = $request['id_comunidad1'];
        $proveedor->prov_id_asociacion = $request['id_asociacion1'];
        $proveedor->prov_direccion = $request['direccion'];
        $proveedor->prov_rau = $request['id_rau'];
        $proveedor->prov_nit = $request['nit'];
        $proveedor->prov_cuenta = $request['cuenta_bancaria'];
        $proveedor->prov_latitud = $request['lat_map'];
        $proveedor->prov_longitud = $request['lng_map'];
        $proveedor->prov_fecha_insrau = $request['fecha_inscripcion'];
        $proveedor->prov_fecha_venrau = $request['fecha_vencimiento'];
        $proveedor->prov_doc_pdf = $nombreDoc1;
        $proveedor->save();
        return response()->json(['mensaje' => 'Se actualizo el proveedor']);
    }
    public function show($id)
    {

    }
    public function destroy($id)
    {
        $proveedor = Proveedor::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    // BUSCADORES
    public function obtenerProvConv(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();  
        $term = $request->term ?: '';
        $tags = Proveedor::where('prov_nombre', 'like', '%'.$term.'%')->where('prov_id_tipo',11)->where('prov_estado','A')
                            ->where('prov_id_planta','=',$planta->id_planta)
                            ->take(25)->get();
        $valid_tags = [];
        foreach ($tags as $tag) {
            $valid_tags[] = ['id' => $tag->prov_id, 'foto' => $tag->prov_foto, 'text' => $tag->prov_nombre.' '.$tag->prov_ap. ' '.$tag->prov_am ];
        }
        return \Response::json($valid_tags);
    }

    public function obtenerProvFA(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();   
        $term = $request->term ?: '';
        $tags = Proveedor::where('prov_nombre', 'like', '%'.$term.'%')->where('prov_id_tipo',10)->where('prov_estado','A')->where('prov_id_planta','=',$planta->id_planta)->take(25)->get();
        $valid_tags = [];
        foreach ($tags as $tag) {
            $valid_tags[] = ['id' => $tag->prov_id, 'foto' => $tag->prov_foto, 'text' => $tag->prov_nombre.' '.$tag->prov_ap. ' '.$tag->prov_am ];
        }
        return \Response::json($valid_tags);
    }

    public function obtenerProvProd(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();  
        $term = $request->term ?: '';
        $tags = Proveedor::where('prov_nombre', 'like', '%'.$term.'%')->where('prov_id_tipo',9)->where('prov_estado','A')->where('prov_id_planta','=',$planta->id_planta)->take(25)->get();
        $valid_tags = [];
        foreach ($tags as $tag) {
            $valid_tags[] = ['id' => $tag->prov_id, 'foto' => $tag->prov_foto, 'text' => $tag->prov_nombre.' '.$tag->prov_ap. ' '.$tag->prov_am ];
        }
        return \Response::json($valid_tags);
    }

    // BUSCAR Y COLOCAR DATOS
    public function ajaxProveedor()
    {
        // $prov_id = Input::get('prov_id');
        // $proveedor= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
        //     ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
        //     ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
        //     ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
        //     ->join('acopio.acopio as aco','acopio.proveedor.prov_id', '=', 'aco.aco_id_prov')
        //     ->select('proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap',
        //         'proveedor.prov_am','proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //         'com.com_nombre','aso.aso_nombre','dep.dep_nombre',DB::raw('MAX(aco_numaco) as nroaco'))
        //     ->where('prov_id','=', $prov_id)->groupBy('proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap','proveedor.prov_am','proveedor.prov_ci','proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //         'com.com_nombre','aso.aso_nombre','dep.dep_nombre')->first();
        // // dd($proveedor);
        // if ($proveedor == null) {
        // $proveedor1= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
        //     ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
        //     ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
        //     ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
        //     ->join('acopio.contrato as cont','acopio.proveedor.prov_id','=','cont.contrato_id_prov')//NUEVO
        //     ->select('acopio.proveedor.prov_id','acopio.proveedor.prov_nombre','acopio.proveedor.prov_ap',
        //         'acopio.proveedor.prov_am','acopio.proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //         'com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_nro','cont.contrato_deuda','contrato_precio','contrato_saldo')
        // ->where('prov_id','=', $prov_id)->get();
        // //NUMACO
        // }else {
        //     $proveedor1= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
        //     ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
        //     ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
        //     ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
        //     ->join('acopio.acopio as aco','acopio.proveedor.prov_id', '=', 'aco.aco_id_prov')
        //     ->join('acopio.contrato as cont','acopio.proveedor.prov_id','=','cont.contrato_id_prov')//NUEVO
        //     ->select('proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap',
        //         'proveedor.prov_am','proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //         'com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_nro','cont.contrato_deuda','contrato_precio','cont.contrato_saldo',DB::raw('MAX(aco_numaco) as nroaco'))
        //     ->where('prov_id','=', $prov_id)->groupBy('proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap','proveedor.prov_am','proveedor.prov_ci','acopio.proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //         'com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_nro','cont.contrato_deuda','cont.contrato_precio','cont.contrato_saldo')->get();
        //     // dd($proveedor1);
        // }
        // return \Response::json($proveedor1);
        // 
        // $prov_id = Input::get('prov_id');
        // $proveedor= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
        //     ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
        //     ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
        //     ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
        //     ->join('acopio.acopio as aco','acopio.proveedor.prov_id', '=', 'aco.aco_id_prov')
        //     ->select('aco.aco_id','proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap',
        //         'proveedor.prov_am','proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //         'com.com_nombre','aso.aso_nombre','dep.dep_nombre',DB::raw('MAX(aco_numaco) as nroaco'))
        //     ->where('prov_id','=', $prov_id)->groupBy('aco.aco_id','proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap','proveedor.prov_am','proveedor.prov_ci','proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //         'com.com_nombre','aso.aso_nombre','dep.dep_nombre')->first();
        // // dd($proveedor);
        // if ($proveedor == null) {
        // $proveedor1= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
        //     ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
        //     ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
        //     ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
        //     ->join('acopio.contrato as cont','acopio.proveedor.prov_id','=','cont.contrato_id_prov')//NUEVO
        //     ->select('acopio.proveedor.prov_id','acopio.proveedor.prov_nombre','acopio.proveedor.prov_ap',
        //         'acopio.proveedor.prov_am','acopio.proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //         'com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_nro','cont.contrato_deuda','contrato_precio','contrato_saldo')
        // ->where('prov_id','=', $prov_id)->get();
        // //NUMACO
        // }else {
        //     $proveedor1= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
        //     ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
        //     ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
        //     ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
        //     ->join('acopio.acopio as aco','acopio.proveedor.prov_id', '=', 'aco.aco_id_prov')
        //     ->join('acopio.contrato as cont','acopio.proveedor.prov_id','=','cont.contrato_id_prov')//NUEVO
        //     ->join('acopio.pagos as pag','pag.pago_id_aco','=','aco.aco_id')
        //     ->select('proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap',
        //         'proveedor.prov_am','proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //         'com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_nro','cont.contrato_deuda','contrato_precio','cont.contrato_saldo',DB::raw('MAX(aco_numaco) as nroaco'),DB::raw('SUM(pago_cuota_pago) as totalpago'))
        //     ->where('prov_id','=', $prov_id)->where('aco_estado','=','A')->groupBy('proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap','proveedor.prov_am','proveedor.prov_ci','acopio.proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //         'com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_nro','cont.contrato_deuda','cont.contrato_precio','cont.contrato_saldo')->get();
        //     // dd($proveedor1);
        //     if ($proveedor1 == null) {
        //         $proveedor1= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
        //         ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
        //         ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
        //         ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
        //         ->join('acopio.contrato as cont','acopio.proveedor.prov_id','=','cont.contrato_id_prov')//NUEVO
        //         ->join('acopio.acopio as aco', 'acopio.proveedor.prov_id','=','aco.aco_id_prov')
        //         ->select('acopio.proveedor.prov_id','acopio.proveedor.prov_nombre','acopio.proveedor.prov_ap',
        //             'acopio.proveedor.prov_am','acopio.proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //             'com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_nro','cont.contrato_deuda','contrato_precio','contrato_saldo', DB::raw('MAX(aco_numaco) as nroaco'))
        //         ->groupBY('acopio.proveedor.prov_id','acopio.proveedor.prov_nombre','acopio.proveedor.prov_ap',
        //             'acopio.proveedor.prov_am','acopio.proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
        //             'com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_nro','cont.contrato_deuda','contrato_precio','contrato_saldo')
        //         ->where('prov_id','=', $prov_id)->get();
        //         // dd($proveedor1);
        //     }
        // }
        // dd($proveedor1);
        // 
        $prov_id = Input::get('prov_id');
        $contrato = Pagos::join('acopio.contrato as contra','acopio.pagos.pago_id_contrato','=','contra.contrato_id')->where('contrato_id','=',$prov_id)->get();
        // dd($contrato);
        if ($contrato->isEmpty()) {
            // dd('NO TIENE PAGOS');
            $proveedor1= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
            ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
            ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
            ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
            ->join('acopio.contrato as cont','acopio.proveedor.prov_id','=','cont.contrato_id_prov')//NUEVO
            ->select('acopio.proveedor.prov_id','acopio.proveedor.prov_nombre','acopio.proveedor.prov_ap',
                'acopio.proveedor.prov_am','acopio.proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
                'com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_id','cont.contrato_nro','cont.contrato_deuda','contrato_precio','contrato_saldo')
            ->where('contrato_id','=', $prov_id)->get();
        } else {
            // dd('TIENE PAGOS REALIZADOS');
            $proveedor1= Pagos::join('acopio.contrato as cont','acopio.pagos.pago_id_contrato', '=', 'cont.contrato_id')    
                            ->join('acopio.proveedor as prov','cont.contrato_id_prov','=','prov.prov_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.asociacion as aso', 'prov.prov_id_asociacion','=','aso.aso_id')
                            ->join('acopio.departamento as dep','prov.prov_departamento','=','dep.dep_id')
                            ->join('acopio.acopio as aco','acopio.pagos.pago_id_aco', '=', 'aco.aco_id')
                            ->select('prov.prov_id','prov.prov_nombre','prov.prov_ap','prov.prov_am','prov.prov_foto','prov.prov_rau','mun.mun_nombre','com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_id','cont.contrato_nro','cont.contrato_deuda','contrato_precio','cont.contrato_saldo',DB::raw('MAX(aco_numaco) as nroaco'),DB::raw('SUM(pago_liquido_pag) as totalpago'))//SE CAMBIO DE pago_cuota_pago  a pago_liquido_pag
                            ->where('cont.contrato_id','=', $prov_id)->where('aco_estado','=','A')->groupBy('prov.prov_id','prov.prov_nombre','prov.prov_ap','prov.prov_am','prov.prov_ci','prov.prov_foto','prov.prov_rau','mun.mun_nombre','com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_id','cont.contrato_nro','cont.contrato_deuda','cont.contrato_precio','cont.contrato_saldo')->get();
            if ($proveedor1 == null) {
                $proveedor1= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
                ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
                ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
                ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
                ->join('acopio.contrato as cont','acopio.proveedor.prov_id','=','cont.contrato_id_prov')//NUEVO
                ->join('acopio.acopio as aco', 'acopio.proveedor.prov_id','=','aco.aco_id_prov')
                ->select('acopio.proveedor.prov_id','acopio.proveedor.prov_nombre','acopio.proveedor.prov_ap',
                    'acopio.proveedor.prov_am','acopio.proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
                    'com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_id','cont.contrato_nro','cont.contrato_deuda','contrato_precio','contrato_saldo', DB::raw('MAX(aco_numaco) as nroaco'))
                ->groupBY('acopio.proveedor.prov_id','acopio.proveedor.prov_nombre','acopio.proveedor.prov_ap',
                    'acopio.proveedor.prov_am','acopio.proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
                    'com.com_nombre','aso.aso_nombre','dep.dep_nombre','cont.contrato_id','cont.contrato_nro','cont.contrato_deuda','contrato_precio','contrato_saldo')
                ->where('contrato_id','=', $prov_id)->get();
                // dd($proveedor1);
            }
        }
        
        return \Response::json($proveedor1);
    }

    public function ajaxCalculaSaldo()
    {
        $id_contrato = Input::get('contrato_id');
        $contrato = Contrato::join('acopio.pagos as pag','acopio.contrato.contrato_id','=','pag.pago_id_contrato')->
                    where('contrato_id','=',$id_contrato)->OrderBy('pag.pago_id_aco','ASC')->get();
         // dd($contrato->isEmpty());
        if ($contrato->isEmpty()) {
            $saldo = 0;
            return \Response::json($saldo);
        } else {
            $contrato1 = Contrato::join('acopio.pagos as pag','acopio.contrato.contrato_id','=','pag.pago_id_contrato')->
                            join('acopio.acopio as aco','pag.pago_id_aco','=','aco.aco_id')->
                            where('aco.aco_estado','A')->where('contrato_id','=',$id_contrato)->OrderBy('pag.pago_id_aco','ASC')->get();
            $cuota = $contrato[0]->contrato_deuda;
            // $saldo = $contrato[0]->contrato_deuda - $contrato1[0]->pago_cuota_pago;
            // $pagocuota = $contrato1[0]->pago_cuota_pago;
            $saldo = $contrato[0]->contrato_deuda - $contrato1[0]->pago_liquido_pag;
            $pagocuota = $contrato1[0]->pago_liquido_pag;        
            foreach ($contrato1 as $pago1){            
                // $pagocuota = $pago1->pago_cuota_pago;           
                // $saldo =  $cuota - $pago1->pago_cuota_pago;
                $pagocuota = $pago1->pago_liquido_pag;           
                $saldo =  $cuota - $pago1->pago_liquido_pag;
                $cuota = $saldo+$contrato[0]->contrato_deuda;            
            }
            return \Response::json($saldo);
        }
    }

    public function ajaxProveedorFaProd()
    {
        $prov_id = Input::get('prov_id');
        $proveedor= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
            ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
            ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
            ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
            ->join('acopio.acopio as aco','acopio.proveedor.prov_id', '=', 'aco.aco_id_prov')
            ->select('proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap',
                'proveedor.prov_am','proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
                'com.com_nombre','aso.aso_nombre','dep.dep_nombre','proveedor.prov_fecha_venrau',DB::raw('MAX(aco_numaco) as nroaco'))
            ->where('prov_id','=', $prov_id)->groupBy('proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap','proveedor.prov_am','proveedor.prov_ci','proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
                'com.com_nombre','aso.aso_nombre','dep.dep_nombre','proveedor.prov_fecha_venrau')->first();
        // dd($proveedor);
        if ($proveedor == null) {
        $proveedor1= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
            ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
            ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
            ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
            // ->join('acopio.contrato as cont','acopio.proveedor.prov_id','=','cont.contrato_id_prov')//NUEVO
            ->select('acopio.proveedor.prov_id','acopio.proveedor.prov_nombre','acopio.proveedor.prov_ap',
                'acopio.proveedor.prov_am','acopio.proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
                'com.com_nombre','aso.aso_nombre','dep.dep_nombre','proveedor.prov_fecha_venrau')
        ->where('prov_id','=', $prov_id)->get();
        //NUMACO
        }else {
            $proveedor1= Proveedor::join('acopio.municipio as mun','acopio.proveedor.prov_id_municipio', '=', 'mun.mun_id')
            ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad','=','com.com_id')
            ->join('acopio.asociacion as aso', 'acopio.proveedor.prov_id_asociacion','=','aso.aso_id')
            ->join('acopio.departamento as dep','acopio.proveedor.prov_departamento','=','dep.dep_id')
            ->join('acopio.acopio as aco','acopio.proveedor.prov_id', '=', 'aco.aco_id_prov')
            // ->join('acopio.contrato as cont','acopio.proveedor.prov_id','=','cont.contrato_id_prov')//NUEVO
            ->select('proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap',
                'proveedor.prov_am','proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
                'com.com_nombre','aso.aso_nombre','dep.dep_nombre','proveedor.prov_fecha_venrau',DB::raw('MAX(aco_numaco) as nroaco'))
            ->where('prov_id','=', $prov_id)->groupBy('proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap','proveedor.prov_am','proveedor.prov_ci','acopio.proveedor.prov_foto','proveedor.prov_rau','mun.mun_nombre',
                'com.com_nombre','aso.aso_nombre','dep.dep_nombre','proveedor.prov_fecha_venrau')->get();
            // dd($proveedor1);
        }
        return \Response::json($proveedor1);
    }

    // Contratos
    public function listarContratos($id_proveedor)
    {
        $contratos = Contrato::where('contrato_id_prov','=',$id_proveedor)->get();
        $contratos = Contrato::join('acopio.proveedor as prov','acopio.contrato.contrato_id_prov','=','prov.prov_id')
                    ->where('contrato_id_prov','=',$id_proveedor)->get();
        return \Response::json($contratos);
    }
    public function mostrarProvContrato($id_proveedor)
    {
        $proveedor = Proveedor::where('prov_id','=',$id_proveedor)->first();

        return $proveedor;
    }
    public function registroContrato(Request $request)
    {   
        Contrato::create([
            'contrato_id_prov'      => $request['contrato_id_prov'],
            'contrato_nro'          => $request['contrato_nro'],
            'contrato_precio'       => $request['contrato_precio'],
            'contrato_deuda'        => $request['contrato_deuda'],
            'contrato_sindicato'    => '',
            'contrato_central'      => '',
            'contrato_saldo'        => 0,
            
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }
    //end contratos
}
