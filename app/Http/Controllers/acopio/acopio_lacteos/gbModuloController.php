<?php

namespace siga\Http\Controllers\acopio\acopio_lacteos;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_lacteos\Modulo;
use Yajra\Datatables\Datatables;
use siga\Modelo\acopio\acopio_lacteos\ProveedorL;
use siga\Modelo\acopio\acopio_almendra\Departamento;
use siga\Modelo\acopio\acopio_lacteos\AcopioCA;//ACOPIO LACTEOS
use siga\Modelo\acopio\acopio_lacteos\AcopioGR;
use siga\Modelo\acopio\acopio_lacteos\Precio;
use siga\Modelo\admin\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Fpdf;
use TCPDF;

class gbModuloController extends Controller
{
    public function index()
    {
        $dia_actual = date('Y-m-d');
        $dias_atras= date('Y-m-d', strtotime('-5 day'));

        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $cantidad_recibido = AcopioGR::select( DB::raw('SUM(detlac_cant) as cant_total_recibida'))->where('detlac_id_planta','=',$planta->id_planta)->where('detlac_fecha','>=',$dias_atras)->where('detlac_fecha','<=',$dia_actual)->first();
        
        $cantidad_acopiada = AcopioCA::select( DB::raw('SUM(dac_cant_uni) as cant_total_acopiada'))
                                     ->where('dac_id_planta','=',$planta->id_planta)
                                     ->where('dac_fecha_acop','>=',$dias_atras)->where('dac_fecha_acop','<=',$dia_actual)
                                     ->where('dac_estado','=','A')->first();
        // dd($cantidad_acopiada);
        if (!$cantidad_recibido) {
            $cantidad_recibido = 0;
        }else{            
            $cantidad_recibido = $cantidad_recibido->cant_total_recibida;
        }
        if (!$cantidad_acopiada) {
            $cantidad_acopiada =0;
            $cantidad_total = $cantidad_recibido - $cantidad_acopiada;           
        }else{
            // dd("2");
            $cantidad_acopiada = $cantidad_acopiada->cant_total_acopiada;
            $cantidad_total = $cantidad_recibido - $cantidad_acopiada;
        }
        $persona = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $fech= AcopioGR::getfecha();   
        $fecha= $fech['detlac_fecha_reg'];
        $modulo = Modulo::getListarModulo();
         // dd($modulo);      
        return view('backend.administracion.acopio.acopio_lacteos.modulo.index',compact('modulo', 'fecha', 'persona','cantidad_recibido','cantidad_acopiada', 'cantidad_total'));
    }

    public function create()
    {
        $modulo = Modulo::getListarModulo();
        return Datatables::of($modulo)->addColumn('acciones', function ($modulo) {
            return '<a class="btn btn-primary btn-sm" onClick="#" style="background:#512E5F; width:120px;" href="ListarProveedoresModulo/' . $modulo->modulo_id . '">PROVEEDORES</a> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:120px;" href="ListarAcopioProv/'.$modulo->modulo_id.'">ACOPIOS</a> '; 
        })
           ->editColumn('id', 'ID: {{$modulo_id}}')
           ->addColumn('nombreCompleto', function ($nombres) {
            return $nombres->modulo_nombre . ' ' . $nombres->modulo_paterno . ' ' . $nombres->modulo_materno;
        })     
            ->editColumn('id', 'ID: {{$modulo_id}}')
            ->make(true);
    }

    public function store(Request $request)
    {    
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $this->validate(request(), [
                'nombre_modulo' => 'required',
                // 'modulo_nombres' => 'required',
                // 'modulo_paterno' => 'required',    
                // 'modulo_materno' => 'required',
                // 'modulo_ci' => 'required',     
                // 'modulo_telefono' => 'required',
                'modulo_direccion' => 'required'                
        ]); 
        Modulo::create([
            'modulo_modulo'     => $request['nombre_modulo'],
            'modulo_nombre'     => $request['modulo_nombres'],
            'modulo_paterno'    => $request['modulo_paterno'],
            'modulo_materno'    => $request['modulo_materno'],
            'modulo_ci'         => $request['modulo_ci'],
            'modulo_dir'        => $request['modulo_direccion'],
            'modulo_tel'        => $request['modulo_telefono'],
            'modulo_usr_id'		=> Auth::user()->usr_id,
            'modulo_id_planta'  => $planta->id_planta
           // 'id_usuario'        => Auth::user()->usr_id,
            

        ]);

        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function listarProveedoresModulo($id)
    {   
        $dia_actual = date('Y-m-d');
        $dias_atras= date('Y-m-d', strtotime('-5 day'));

        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $cantidad_recibido = AcopioGR::select( DB::raw('SUM(detlac_cant) as cant_total_recibida'))->where('detlac_id_planta','=',$planta->id_planta)->where('detlac_fecha','>=',$dias_atras)->where('detlac_fecha','<=',$dia_actual)->first();
        
        $cantidad_acopiada = AcopioCA::select( DB::raw('SUM(dac_cant_uni) as cant_total_acopiada'))
                                     ->where('dac_id_planta','=',$planta->id_planta)
                                     ->where('dac_fecha_acop','>=',$dias_atras)->where('dac_fecha_acop','<=',$dia_actual)
                                     ->where('dac_estado','=','A')->first();
        // dd($cantidad_acopiada);
        if (!$cantidad_acopiada) {
            $cantidad_acopiada =0;
            $cantidad_total = $cantidad_recibido->cant_total_recibida - $cantidad_acopiada;           
        }else{
            $cantidad_acopiada = $cantidad_acopiada->cant_total_acopiada;
            $cantidad_total = $cantidad_recibido->cant_total_recibida - $cantidad_acopiada;
        }

        $exp=Departamento::comboExp();
        $dep=Departamento::comboDep();
        $id_modulo = $id;
        $datos_modulo =Modulo::where('modulo_id',$id)->first();
        // dd($datos_modulo);
    	return view('backend.administracion.acopio.acopio_lacteos.proveedor.index', compact('datos_modulo','id_modulo','exp','dep','cantidad_recibido','cantidad_acopiada', 'cantidad_total'));
    }

    public function listarProveedoresDell($id)
    {
        $id_prov = $id;
        $datos_prov =ProveedorL::where('prov_id',$id)->first();
        
        return view('backend.administracion.acopio.acopio_lacteos.proveedorDetalle.index',compact('id_prov','datos_prov'));
    }

    public function listarProveedoresModulo2($id)
    {
        $proveedor = ProveedorL::getListar($id); 
        return Datatables::of($proveedor)->addColumn('acciones', function ($proveedor) {
            return '<button value="'.$proveedor->prov_id.'" class="btncirculo btn-xs btn-warning" style="background: #616A6B" onClick="MostrarRegistroAco(this);" data-toggle="modal" data-target="#myCreateRCAprov"><i class="fa fa-plus"></i></button> <a value="" class="btn btncirculo btn-xs btn-primary" style="background:#512E5F" href="/listarProveedoresDell/'.$proveedor->prov_id.'"><i class="glyphicon glyphicon-tasks"></i></a> <button value="' . $proveedor->prov_id . '" class="btncirculo btn-xs btn-primary" style="background:#FF8C00" onClick="MostrarProveedor(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button>';
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
             -> addColumn('rau', function ($pal) {
                if($pal->prov_rau==1){ 
                    return '<h5 class="text-center">SI</h5>'; 
                }else{
                    return '<h5 class="text-center">NO</h5>';
                }
                
             }) 

            ->make(true);
    }

    public function listarProveedoresDetalleMes($id)
    {
        $fecha = Input::get('mes');
        $fecha_porciones = explode("/", $fecha);
        $mes = $fecha_porciones[0];
        $anio1 = $fecha_porciones[1];
        $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
        $fechainicial = $anio1 . "-" . $mes . "-01";
        $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
        $acopiodetalle = AcopioCA::join('acopio.precio as precio','acopio.det_acop_ca.dac_id_planta','=','precio.precio_id_planta')
                                ->where('dac_fecha_acop','>=',$fechainicial)->where('dac_fecha_acop','<=',$fechafinal)
                                ->where('dac_id_prov',$id)
                                ->where('dac_estado','=','A')->get();
        
        // dd($acopiodetalle);
        return Datatables::of($acopiodetalle)
            ->addColumn('aspecto', function ($acopiodetalle) {
            if($acopiodetalle->dac_aspecto==1){ 
                return '<h5 class="text-center">Liquido</h5>'; 
            }else{
                return '<h5 class="text-center">Homogeneo</h5>';
            }                
        })->addColumn('color', function ($acopiodetalle) {
            if($acopiodetalle->dac_color==1){ 
                return '<h5 class="text-center">Blanco Opaco</h5>'; 
            }else{
                return '<h5 class="text-center">Blanco Cremoso</h5>';
            }                
        }) ->addColumn('olor', function ($acopiodetalle) {
            if($acopiodetalle->dac_olor==1){ 
                return '<h5 class="text-center">SI</h5>'; 
            }else{
                return '<h5 class="text-center">No</h5>';
            }                
        }) ->addColumn('sabor', function ($acopiodetalle) {
            if($acopiodetalle->dac_sabor==1){ 
                return '<h5 class="text-center">Poco Dulce</h5>'; 
            }else{
                return '<h5 class="text-center">Agradable</h5>';
            }                
        })->addColumn('costo_unitario', function ($acopiodetalle) {
            return  number_format($acopiodetalle->precio_costo,2,'.',',');      
        })->addColumn('costo_total', function ($acopiodetalle) {
            return  number_format($acopiodetalle->precio_costo*$acopiodetalle->dac_cant_uni,2,'.',',');      
        })->make(true);
    }

    public function listarProveedoresDetalleDia($id)
    {
        $fecha = Input::get('dia');
        $fecha_porciones = explode("/", $fecha);
        $dia = $fecha_porciones[0];
        $mes = $fecha_porciones[1];
        $anio = $fecha_porciones[2];
        $acopiodetalle = AcopioCA::join('acopio.precio as precio','acopio.det_acop_ca.dac_id_planta','=','precio.precio_id_planta')
                                 ->where('dac_fecha_acop','=',$anio."-".$mes."-".$dia)
                                 ->where('dac_id_prov',$id)
                                 ->where('dac_estado','=','A')->get();
        return Datatables::of($acopiodetalle)->addColumn('aspecto', function ($acopiodetalle) {
            if($acopiodetalle->dac_aspecto==1){ 
                return '<h5 class="text-center">Liquido</h5>'; 
            }else{
                return '<h5 class="text-center">Homogeneo</h5>';
            }                
        })->addColumn('color', function ($acopiodetalle) {
            if($acopiodetalle->dac_color==1){ 
                return '<h5 class="text-center">Blanco Opaco</h5>'; 
            }else{
                return '<h5 class="text-center">Blanco Cremoso</h5>';
            }                
        }) ->addColumn('olor', function ($acopiodetalle) {
            if($acopiodetalle->dac_olor==1){ 
                return '<h5 class="text-center">SI</h5>'; 
            }else{
                return '<h5 class="text-center">No</h5>';
            }                
        }) ->addColumn('sabor', function ($acopiodetalle) {
            if($acopiodetalle->dac_sabor==1){ 
                return '<h5 class="text-center">Poco Dulce</h5>'; 
            }else{
                return '<h5 class="text-center">Agradable</h5>';
            }                
        })->addColumn('costo_unitario', function ($acopiodetalle) {
            return  number_format($acopiodetalle->precio_costo,2,'.',',');      
        })->addColumn('costo_total', function ($acopiodetalle) {
            return  number_format($acopiodetalle->precio_costo*$acopiodetalle->dac_cant_uni,2,'.',',');      
        })->make(true);
    }

    public function listarProveedoresDetalleRango($id)
    {
        $fecha_inicio = Input::get('dia_inicio');
        $fecha_final = Input::get('dia_fin');
        $acopiodetalle = AcopioCA::join('acopio.precio as precio','acopio.det_acop_ca.dac_id_planta','=','precio.precio_id_planta')
                                 ->where('dac_fecha_acop','>=',$fecha_inicio)->where('dac_fecha_acop','<=',$fecha_final)
                                 ->where('dac_id_prov',$id)
                                 ->where('dac_estado','=','A')->get();
        return Datatables::of($acopiodetalle)->addColumn('aspecto', function ($acopiodetalle) {
            if($acopiodetalle->dac_aspecto==1){ 
                return '<h5 class="text-center">Liquido</h5>'; 
            }else{
                return '<h5 class="text-center">Homogeneo</h5>';
            }                
        })->addColumn('color', function ($acopiodetalle) {
            if($acopiodetalle->dac_color==1){ 
                return '<h5 class="text-center">Blanco Opaco</h5>'; 
            }else{
                return '<h5 class="text-center">Blanco Cremoso</h5>';
            }                
        }) ->addColumn('olor', function ($acopiodetalle) {
            if($acopiodetalle->dac_olor==1){ 
                return '<h5 class="text-center">SI</h5>'; 
            }else{
                return '<h5 class="text-center">No</h5>';
            }                
        }) ->addColumn('sabor', function ($acopiodetalle) {
            if($acopiodetalle->dac_sabor==1){ 
                return '<h5 class="text-center">Poco Dulce</h5>'; 
            }else{
                return '<h5 class="text-center">Agradable</h5>';
            }                
        })->addColumn('costo_unitario', function ($acopiodetalle) {
            return  number_format($acopiodetalle->precio_costo,2,'.',',');      
        })->addColumn('costo_total', function ($acopiodetalle) {
            return  number_format($acopiodetalle->precio_costo*$acopiodetalle->dac_cant_uni,2,'.',',');      
        })->make(true);
    }

    public function registroProveedorModulo(Request $request)
    {
        $this->validate(request(), [
                'nombres' => 'required',
                'paterno' => 'required',    
                'materno' => 'required',
                'ci' => 'required',     
                // 'expedido' => 'required|min:1',    
                'lugar_proveedor' => 'required|min:1',
                // 'departamento' => 'required|min:1', 
                'municipio' => 'required|min:1',  
                // 'tipo_proveedor' => 'required|min:1',
                'rau' => 'required|min:1'                 
        ]); 
        $fecha1=date('d/m/Y');

       $file = $request->file('imgProveedorL');        
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
            'prov_rau'            => $request['rau'],
            'prov_nit'            => $request['nro_nit'],
            'prov_cuenta'         => $request['nro_cuenta'],
            'prov_id_tipo'        => 1,
            'prov_id_convenio'    => 1,
            'prov_id_usr'         => Auth::user()->usr_id,
            'prov_lugar'          => $request['lugar_proveedor'],
            'prov_id_linea'       => 2,  
            'prov_id_recep'       => 1,
            'prov_id_modulo'      => $request['prov_id_modulo']

        ]);

        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    // LISTAR ACOPIOS
    public function listarAcopioProve($id_modulo)
    {
        $modulo = Modulo::where('modulo_id',$id_modulo)->first();
        // dd($modulo);
        return view('backend.administracion.acopio.acopio_lacteos.acopio_modulo.index', compact('modulo'));
    }

    public function listarCreateAcoProv($id_modulo)
    {
        $fecha = Input::get('mes');
        $fecha_porciones = explode("/", $fecha);
        $mes = $fecha_porciones[0];
        $anio1 = $fecha_porciones[1];
        $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
        $fechainicial = $anio1 . "-" . $mes . "-01";
        $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
        $acopios_modulo = AcopioCA::join('acopio.proveedor as prov','acopio.det_acop_ca.dac_id_prov','=','prov.prov_id')
                                     ->join('acopio.modulo as mod','prov.prov_id_modulo','=','mod.modulo_id')
                                     ->join('acopio.precio as precio','acopio.det_acop_ca.dac_id_planta','=','precio.precio_id_planta')
                                     ->where('mod.modulo_id','=',$id_modulo)
                                     ->where('dac_fecha_acop','>=',$fechainicial)->where('dac_fecha_acop','<=',$fechafinal)
                                     ->where('dac_estado','=','A')->get();
        return Datatables::of($acopios_modulo)   
            ->editColumn('id', 'ID: {{$dac_id}}')
            ->addColumn('fechaMes', function ($acopios_modulo) {
                setlocale(LC_TIME, 'es');
                $datebus = new Carbon($acopios_modulo->dac_fecha_reg);
                $dato= $datebus->formatLocalized('%B');
                return $dato;
            })
            ->addColumn('nombreProveedor', function ($acopios_modulo) {
                return $acopios_modulo->prov_nombre.' '.$acopios_modulo->prov_ap.' '.$acopios_modulo->prov_am;
            })->addColumn('precio_unitario', function ($acopios_modulo) {
                return number_format($acopios_modulo->precio_costo,2,'.',',');
            })->addColumn('precio_total', function ($acopios_modulo) {
                return number_format($acopios_modulo->precio_costo*$acopios_modulo->dac_cant_uni,2,'.',',');
            })
            ->make(true);

    }

    public function listarCreateAcoProvDia($id_modulo)
    {
        $fecha = Input::get('dia');
        $fecha_porciones = explode("/", $fecha);
        $dia = $fecha_porciones[0];
        $mes = $fecha_porciones[1];
        $anio = $fecha_porciones[2];
        $acopios_modulo = AcopioCA::join('acopio.proveedor as prov','acopio.det_acop_ca.dac_id_prov','=','prov.prov_id')
                                     ->join('acopio.modulo as mod','prov.prov_id_modulo','=','mod.modulo_id')
                                     ->join('acopio.precio as precio','acopio.det_acop_ca.dac_id_planta','=','precio.precio_id_planta')
                                     ->where('mod.modulo_id','=',$id_modulo)
                                     ->where('dac_fecha_acop','=',$anio."-".$mes."-".$dia)
                                     ->where('dac_estado','=','A')->get();
        return Datatables::of($acopios_modulo)   
            ->editColumn('id', 'ID: {{$dac_id}}')
            ->addColumn('fechaMes', function ($acopios_modulo) {
                setlocale(LC_TIME, 'es');
                $datebus = new Carbon($acopios_modulo->dac_fecha_reg);
                $dato= $datebus->formatLocalized('%B');
                return $dato;
            }) ->addColumn('nombreProveedor', function ($acopios_modulo) {
                return $acopios_modulo->prov_nombre.' '.$acopios_modulo->prov_ap.' '.$acopios_modulo->prov_am;
            })->addColumn('precio_unitario', function ($acopios_modulo) {
                return number_format($acopios_modulo->precio_costo,2,'.',',');
            })->addColumn('precio_total', function ($acopios_modulo) {
                return number_format($acopios_modulo->precio_costo*$acopios_modulo->dac_cant_uni,2,'.',',');
            })
            ->make(true);

    }

    public function listarCreateAcoProvRango($id_modulo)
    {
        $fecha_inicio = Input::get('dia_inicio');
        $fecha_final = Input::get('dia_fin');
        // dd("Inicio: ".$fecha_inicio.", Fin:".$fecha_final);
        $acopios_modulo = AcopioCA::join('acopio.proveedor as prov','acopio.det_acop_ca.dac_id_prov','=','prov.prov_id')
                                     ->join('acopio.modulo as mod','prov.prov_id_modulo','=','mod.modulo_id')
                                     ->join('acopio.precio as precio','acopio.det_acop_ca.dac_id_planta','=','precio.precio_id_planta')
                                     ->where('mod.modulo_id','=',$id_modulo)
                                     ->where('dac_fecha_acop','>=',$fecha_inicio)->where('dac_fecha_acop','<=',$fecha_final)
                                     ->where('dac_estado','=','A')->get();
        return Datatables::of($acopios_modulo)   
            ->editColumn('id', 'ID: {{$dac_id}}')
            ->addColumn('fechaMes', function ($acopios_modulo) {
                setlocale(LC_TIME, 'es');
                $datebus = new Carbon($acopios_modulo->dac_fecha_reg);
                $dato= $datebus->formatLocalized('%B');
                return $dato;
            }) ->addColumn('nombreProveedor', function ($acopios_modulo) {
                return $acopios_modulo->prov_nombre.' '.$acopios_modulo->prov_ap.' '.$acopios_modulo->prov_am;
            })->addColumn('precio_unitario', function ($acopios_modulo) {
                return number_format($acopios_modulo->precio_costo,2,'.',',');
            })->addColumn('precio_total', function ($acopios_modulo) {
                return number_format($acopios_modulo->precio_costo*$acopios_modulo->dac_cant_uni,2,'.',',');
            })
            ->make(true);
    }

    public function listarAcopiosProveedor($id_proveedor)
    {
        $acopios_proveedor = AcopioCA::where('dac_id_prov','=',$id_proveedor)->get();
        $proveedor_datos = ProveedorL::where('prov_id','=',$id_proveedor)->first();

        return view('backend.administracion.acopio.acopio_lacteos.acopio.listadoacopio', compact('acopios_proveedor','proveedor_datos'));
    }

    public function getProveedorLacteos($proveedorLac_id)
    {
        $proveedor_lac = ProveedorL::where('prov_id',$proveedorLac_id)->get();
        // dd($proveedor_lac);
        return response()->json($proveedor_lac->toArray());
    }

    public function registrarAcopioProve(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $this->validate(request(), [ 
            'certificado_aceptacion' => 'required|min:1',
            'hora' => 'required', 
            'cantidad' => 'required',   
            'tipo_envase' => 'required|min:1', 
            'condiciones_higiene' => 'required|min:1',
            // 'temperatura' => 'required', 
            // 'sng' => 'required',   
            // 'prueba_alcohol' => 'required|min:1',  
            'aspecto' => 'required|min:1', 
            'color' => 'required|min:1', 
            'olor' => 'required|min:1',  
            'sabor' => 'required|min:1',
            'fecha_acopio' => 'required'    
        ]); 
        $fecha1=date('Y-m-d');
        AcopioCA::create([
            'dac_id_prov'     => $request['cod_prov'],
            'dac_cert'        => $request['certificado_aceptacion'],
            'dac_fecha_acop'  => $request['fecha_acopio'],
            'dac_hora'        => $request['hora'],
            'dac_cant_uni'    => $request['cantidad'],
            'dac_obs'         => $request['aco_obs'],
            'dac_cond'        => $request['condiciones_higiene'],
            'dac_tem'         => $request['temperatura'],
            'dac_sng'         => $request['sng'],
            'dac_palc'        => $request['prueba_alcohol'],
            'dac_aspecto'     => $request['aspecto'],
            'dac_color'       => $request['color'],
            'dac_olor'        => $request['olor'],
            'dac_sabor'       => $request['sabor'],      
            'dac_tenv'        => $request['tipo_envase'], 
            'dac_estado'      => 'A', 
            'dac_fecha_reg'   => $fecha1, 
            'dac_id_linea'    => '2',
            'dac_id_rec'      => Auth::user()->usr_id,
            'dac_id_planta'   => $planta->id_planta
        ]);
        return response()->json(['Mensaje' => 'El acopio no fueron registrado']);
    }

    public function reportediarioAcopioModulos()
    {
        // return "Reporte de Control de CAlidad";
        $fecha=date('d/m/Y');
        // $ids=Auth::user()->usr_id;
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
       

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->AddPage('L', 'Carta');
        $pdf->Image('img/logopeqe.png', 15, 11, 35);
        $pdf->SetFont('helvetica','B',12);

        $pdf->SetXY(90, 10);
        $pdf->Cell(90,10,utf8_decode( 'EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS'),0,0,'C');
        $pdf->SetXY(90, 10);
        $pdf->Cell(90,20,utf8_decode( 'ACOPIOS DEL DIA'),0,0,'C');
        $pdf->SetXY(90, 10);
        $pdf->Cell(90,30,utf8_decode( 'MODULOS'),0,0,'C');
        $pdf->SetXY(200, 10);
        $pdf->Cell(105, 15, 'Al: '.date('d/m/Y').'', 0,0,'C');
        $pdf->Ln(30);
        //ENCABEZADO DE TABLA
        $pdf->SetFont('helvetica','B',8);
         // PDF::writeHTML($htmltable, true, false, true, false, '');
        $acopios_modulo = AcopioCA::join('acopio.proveedor as prov','acopio.det_acop_ca.dac_id_prov','=','prov.prov_id')
                                     ->join('acopio.modulo as mod','prov.prov_id_modulo','=','mod.modulo_id')
                                     ->join('acopio.precio as precio','acopio.det_acop_ca.dac_id_planta','=','precio.precio_id_planta')
                                     ->where('dac_fecha_reg','=',$fecha)
                                     ->where('dac_estado','=','A')->get();
        //CONTENIDO DE LA TABLA      
        // dd($acopios_modulo);
        $html   = '<table border="1">
                        <tr ALIGN=center border="1" bordercolor="#ffffff">
                        <th width="40"  bgcolor="#8b7bc8" border="1" align="center"><h4>No</h4></th>
                        <th width="150" bgcolor="#8b7bc8" border="1" align="center"><h4>MODULO</h4></th>
                        <th width="250" bgcolor="#8b7bc8"  border=1 align="center"><h4>PROVEEDOR</h4></th>
                        <th width="80" bgcolor="#8b7bc8"  border=1 align="center"><h4>FECHA ACOPIO</h4></th>                        
                        <th width="80"  bgcolor="#8b7bc8" border=1 align="center"><h4>CANTIDAD</h4></th>
                        <th width="80" bgcolor="#8b7bc8" border=1 align="center"><h4>COSTO UNITARIO</h4></th>
                        <th width="80" bgcolor="#8b7bc8" border=1 align="center"><h4>COSTO TOTAL</h4></th>
                    </tr>';
        $nro_mod = 0;
        $total_cantidad = 0;
        $total_precio_untario = 0;
        $total_costo = 0;
       foreach ($acopios_modulo as $key => $m) {
     //  foreach ($acopioLact as $m) {
        
            $nro_mod = $nro_mod +1;
            $total_cantidad = $total_cantidad+$m->dac_cant_uni;
            $total_precio_untario = $total_precio_untario+$m->precio_costo;
            $cant_precio = $m->dac_cant_uni * $m->precio_costo;
            $total_costo = $total_costo + $cant_precio;
            $html = $html . '<tr align="center" border=1>
                    <td align="center" border="1">' . $nro_mod. '</td>
                    <td align="center" border="1">' . $m->modulo_modulo. '</td>
                    <td align="center" border="1">' . $m->prov_nombre.' '.$m->prov_ap.' '.$m->prov_am. '</td>
                    <td align="center" border="1">' . $m->dac_fecha_acop. '</td>                    
                    <td align="center" border="1">' . $m->dac_cant_uni . '</td>
                    <td align="center" border="1">' . $m->precio_costo . '</td>
                    <td align="center" border="1">' . $cant_precio. '</td>                  
                  </tr>';
        }
        $html = $html . '<tr>
                            <td align="center" colspan="4">TOTALES</td>
                            <td align="center">'.number_format($total_cantidad,2,'.',',').'</td>
                            <td align="center">'.number_format($total_precio_untario,2,'.',',').'</td>
                            <td align="center">'.number_format($total_costo,2,'.',',').'</td>
                        </tr>';
        $htmltable = $html . '</table>';
        
        $pdf->writeHTML($htmltable, true, 0, true, 0);



            $pdf->Output();


        //});
        PDF::SetTitle('Hello World');
        PDF::AddPage();
        PDF::SetFont('helvetica', '', 10);
        //CUERPO
        $style = array(
            'border'  => false,
            'padding' => 0,
            'fgcolor' => array(128, 0, 0),
            'bgcolor' => false,
        );
     //   PDF::writeHTML($html, true, false, true, false, '');

        PDF::Output('Acopio_dia_modulos.pdf');
    }
} 
