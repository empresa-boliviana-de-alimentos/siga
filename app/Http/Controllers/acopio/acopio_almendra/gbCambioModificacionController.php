<?php

namespace siga\Http\Controllers\acopio\acopio_almendra;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use siga\Modelo\admin\Usuario;
use Illuminate\Support\Facades\Input;
use siga\Modelo\acopio\acopio_almendra\Acopio;
use siga\Modelo\acopio\acopio_almendra\Solicitud_Cambio;
use siga\Modelo\acopio\acopio_almendra\Aprobacion_Soljefe;
use siga\Modelo\acopio\acopio_almendra\Aprobacion_Solgerente;
use Yajra\Datatables\Datatables;
use Auth;

class gbCambioModificacionController extends Controller
{
    public function index()
    {
    	$comprador = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')
    						->join('public._bp_zonas as zona','public._bp_usuarios.usr_zona_id','=','zona.zona_id')
    						->where('usr_id',Auth::user()->usr_id)->first();
    	$solicitudes = Solicitud_Cambio::where('solcam_usr_id',Auth::user()->usr_id)->get();
    	// dd($comprador);
    	return view('backend.administracion.acopio.acopio_almendra.gbCambioModificacion.index', compact('comprador', 'solicitudes'));
    }
    public function create()
    {
        $solicitudes = Solicitud_Cambio::join('public._bp_usuarios as usu','acopio.solicitud_cambio.solcam_usr_id','=','usu.usr_id')
        							   ->join('public._bp_personas as perso','usu.usr_prs_id','=','perso.prs_id')
        							   ->where('solcam_usr_id',Auth::user()->usr_id)->orderBy('acopio.solicitud_cambio.solcam_id','desc')
                                       ->where('solcam_estado','<>','C')
                                       ->where('solcam_estado','<>','D')->get();
        return Datatables::of($solicitudes)
        	->addColumn('nombreComprador', function ($nombreComprador) {
            return $nombreComprador->prs_nombres. ' ' .$nombreComprador->prs_paterno.' '.$nombreComprador->prs_materno;
            })
            ->addColumn('estadoSolicitud', function ($estadoSolicitud) {
            	if ($estadoSolicitud->solcam_estado == 'A') {
            		return '<div class="text-center"><span class="btn btn-primary">ENVIADO</span></div>';
            	}elseif($estadoSolicitud->solcam_estado == 'B'){
            		return '<div class="text-center"><span class="btn btn-warning">PENDIENTE</span></div>';
            	}elseif($estadoSolicitud->solcam_estado == 'C'){
            		return '<div class="text-center"><span class="btn btn-success">ACEPTADO</span></div>';
            	}elseif($estadoSolicitud->solcam_estado == 'D'){
            		return '<div class="text-center"><span class="btn btn-danger">RECHAZADO</span></div>';
            	}
            })
            ->addColumn('tipoSolicitud', function ($tipoSolicitud) {
            	if ($tipoSolicitud->solcam_tipo_id == 1) {
            		return '<div class="text-center"><span class="btn btn-default" style="background: #ACB1AE; color: white"><i class="fa fa-sort-numeric-asc" aria-hidden="true"> CANTIDAD</i></span></div>';
            	}elseif ($tipoSolicitud->solcam_tipo_id == 2) {
            		return '<div class="text-center"><span class="btn btn-default" style="background: #ACB1AE; color: white"><i class="fa fa-balance-scale" aria-hidden="true"> PESO</i></span></div>';
            	}elseif ($tipoSolicitud->solcam_tipo_id == 3) {
            		return '<div class="text-center"><span class="btn btn-default" style="background: #ACB1AE; color: white"><i class="fa fa-hashtag" aria-hidden="true"> NUMERO RECIBO</i></span></div>';
            	}elseif ($tipoSolicitud->solcam_tipo_id == 4) {
            		return '<div class="text-center"><span class="btn btn-default" style="background: #ACB1AE; color: white"><i class="fa fa-remove" aria-hidden="true"> ELIMINACION</i></span></div>';
            	}elseif ($tipoSolicitud->solcam_tipo_id == 5) {
            		return '<div class="text-center"><span class="btn btn-default" style="background: #ACB1AE; color: white"><i class="fa fa-money" aria-hidden="true"> PRECIO</i></span></div>';
            	}
            })
            ->make(true);
    }
    // LISTA HOSTIRICO DEL SOLICITANTE
    public function solicitudCambioRealizadasCreate()
    {
        $solicitudes = Solicitud_Cambio::join('public._bp_usuarios as usu','acopio.solicitud_cambio.solcam_usr_id','=','usu.usr_id')
                                       ->join('public._bp_personas as perso','usu.usr_prs_id','=','perso.prs_id')
                                       ->where('solcam_usr_id',Auth::user()->usr_id)->orderBy('acopio.solicitud_cambio.solcam_id','desc')
                                       ->where('solcam_estado','<>','A')
                                       ->where('solcam_estado','<>','B')->get();
        return Datatables::of($solicitudes)
            ->addColumn('nombreComprador', function ($nombreComprador) {
            return $nombreComprador->prs_nombres. ' ' .$nombreComprador->prs_paterno.' '.$nombreComprador->prs_materno;
            })
            ->addColumn('estadoSolicitud', function ($estadoSolicitud) {
                if ($estadoSolicitud->solcam_estado == 'A') {
                    return '<div class="text-center"><span class="btn btn-primary">ENVIADO</span></div>';
                }elseif($estadoSolicitud->solcam_estado == 'B'){
                    return '<div class="text-center"><span class="btn btn-warning">PENDIENTE</span></div>';
                }elseif($estadoSolicitud->solcam_estado == 'C'){
                    return '<div class="text-center"><span class="btn btn-success">ACEPTADO</span></div>';
                }elseif($estadoSolicitud->solcam_estado == 'D'){
                    return '<div class="text-center"><span class="btn btn-danger">RECHAZADO</span></div>';
                }
            })
            ->addColumn('tipoSolicitud', function ($tipoSolicitud) {
                if ($tipoSolicitud->solcam_tipo_id == 1) {
                    return '<div class="text-center"><span class="btn btn-default" style="background: #ACB1AE; color: white"><i class="fa fa-sort-numeric-asc" aria-hidden="true"> CANTIDAD</i></span></div>';
                }elseif ($tipoSolicitud->solcam_tipo_id == 2) {
                    return '<div class="text-center"><span class="btn btn-default" style="background: #ACB1AE; color: white"><i class="fa fa-balance-scale" aria-hidden="true"> PESO</i></span></div>';
                }elseif ($tipoSolicitud->solcam_tipo_id == 3) {
                    return '<div class="text-center"><span class="btn btn-default" style="background: #ACB1AE; color: white"><i class="fa fa-hashtag" aria-hidden="true"> NUMERO RECIBO</i></span></div>';
                }elseif ($tipoSolicitud->solcam_tipo_id == 4) {
                    return '<div class="text-center"><span class="btn btn-default" style="background: #ACB1AE; color: white"><i class="fa fa-remove" aria-hidden="true"> ELIMINACION</i></span></div>';
                }elseif ($tipoSolicitud->solcam_tipo_id == 5) {
                    return '<div class="text-center"><span class="btn btn-default" style="background: #ACB1AE; color: white"><i class="fa fa-money" aria-hidden="true"> PRECIO</i></span></div>';
                }
            })
            ->make(true);
    }    
    public function store(Request $request)
    {
    	Solicitud_Cambio::create([
    		'solcam_aco_id' => $request['solcam_aco_id'],
    		'solcam_usr_id' => $request['solcam_usr_id'],
    		'solcam_cantidad' => $request['solcam_cantidad'],
    		'solcam_costo_unitario' => $request['solcam_costo_unitario'],
    		'solcam_costo_total' => $request['solcam_costo_total'],
    		'solcam_peso_caja' => $request['solcam_peso_caja'],
    		'solcam_nro_recibo' => $request['solcam_nro_recibo'],
    		'solcam_tipo_id' => $request['solcam_tipo_id'],
    		'solcam_observacion' => $request['solcam_observacion']
    	]);
    	return response()->json(['Mensaje' => 'Se registro correctamente']);
    }
    // BUSCAR ACOPIO REALIZADO
    public function buscarAcopioAlmendra()
    {
    	$acopio_num = Input::get('term');
    	$acopio = Acopio::join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
    					->where('aco_num_rec','=', $acopio_num)
    					->where('aco_id_usr','=',Auth::user()->usr_id)->get();
    	// dd($acopio);
    	$valid_tags = [];
        foreach ($acopio as $tag) {
            $valid_tags[] = ['id' => $tag->aco_id, 'text' => 'NRO RECIBO: '.$tag->aco_num_rec.', PROVEEDOR: '.$tag->prov_nombre.' '.$tag->prov_ap.' '.$tag->prov_am.', FECHA ACOPIO: '.date("d-m-Y",strtotime($tag->aco_fecha_acop)) ];
            // $valid_tags[] = ['id' => $tag->aco_id, 'text' => $tag->aco_num_rec ];
        }
        return \Response::json($valid_tags);
    }
    // OBTENER DATOS DEL ACOPIO ALMENDRA SELECCIONADO
    public function datosAcopioAlmemdra()
    {
    	$aco_id = Input::get('acopio_id');
    	$acopio = Acopio::join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
    					->where('aco_id',$aco_id)->first();
    	return \Response::json($acopio);
    }

    // LISTAR SOLCITUDES RECIBIDAS
    public function listaSolRecibidas()
    {
        $solicutdes_recibidas = Solicitud_Cambio::join('public._bp_usuarios as usuario','acopio.solicitud_cambio.solcam_usr_id','=','usuario.usr_id')
                                                ->join('public._bp_personas as persona','usuario.usr_prs_id','=','persona.prs_id')
                                                ->get();
        // dd($solicutdes_recibidas);
        return view('backend.administracion.acopio.acopio_almendra.gbCambioModificacion.indexRecibidas',compact($solicutdes_recibidas));
    }
    public function listaSolRecibidasCreate()
    {
        $solicutdes_recibidas = Solicitud_Cambio::join('public._bp_usuarios as usuario','acopio.solicitud_cambio.solcam_usr_id','=','usuario.usr_id')
                                                ->join('public._bp_personas as persona','usuario.usr_prs_id','=','persona.prs_id')
                                                ->join('public._bp_zonas as zona','usuario.usr_zona_id','zona.zona_id')
                                                ->join('acopio.tipo_solicitud_cambio as tisol','acopio.solicitud_cambio.solcam_tipo_id','=','tisol.tipsolcam_id')
                                                ->where('solcam_estado','<>','C')
                                                ->where('solcam_estado','<>','D')->get();
         return Datatables::of($solicutdes_recibidas)
         ->addColumn('nombreComprador', function ($nombreComprador) {
            return $nombreComprador->prs_nombres. ' ' .$nombreComprador->prs_paterno.' '.$nombreComprador->prs_materno;
         })->addColumn('nombreTipoSol', function ($nombreTipoSol) {
            return $nombreTipoSol->tipsolcam_nombre;
         })->addColumn('opciones', function ($opciones) {
            if ($opciones->solcam_estado == 'A') {
                return '<div class="text-center"><button value="' . $opciones->solcam_id . '" class="btn btn-primary glyphicon glyphicon-eye-open" onClick="MostrarSolicitud(this);LimiarCampo(this);" data-toggle="modal" data-target="#modalSolicitud"></button><button value="' . $opciones->solcam_id . '" class="btn btn-danger glyphicon glyphicon-remove-sign" onClick="EliminarSolicitud(this);"></button></div>'; 
            }elseif ($opciones->solcam_estado == 'B') {
                return '<div class="text-center"><span class="btn btn-warning">PENDIENTE</span></div>';
            }elseif ($opciones->solcam_estado == 'C'){
                return '<div class="text-center"><span class="btn btn-success">APROBADO</span></div>';
            }elseif ($opciones->solcam_estado == 'D'){
                return '<div class="text-center"><span class="btn btn-danger">RECHAZADO</span></div>';
            }
                       
         })->make(true);
    }
    // LISTAR SOLCITUDES ATENDIDAS HISTORICO JEFE ACOPIO
    public function solicitudCambioAtendidaCreate()
    {
        $solicutdes_recibidas = Solicitud_Cambio::join('public._bp_usuarios as usuario','acopio.solicitud_cambio.solcam_usr_id','=','usuario.usr_id')
                                                ->join('public._bp_personas as persona','usuario.usr_prs_id','=','persona.prs_id')
                                                ->join('public._bp_zonas as zona','usuario.usr_zona_id','zona.zona_id')
                                                ->join('acopio.tipo_solicitud_cambio as tisol','acopio.solicitud_cambio.solcam_tipo_id','=','tisol.tipsolcam_id')
                                                ->where('solcam_estado','<>','A')
                                                ->where('solcam_estado','<>','B')->get();
         return Datatables::of($solicutdes_recibidas)
         ->addColumn('nombreComprador', function ($nombreComprador) {
            return $nombreComprador->prs_nombres. ' ' .$nombreComprador->prs_paterno.' '.$nombreComprador->prs_materno;
         })->addColumn('nombreTipoSol', function ($nombreTipoSol) {
            return $nombreTipoSol->tipsolcam_nombre;
         })->addColumn('opciones', function ($opciones) {
            if ($opciones->solcam_estado == 'A') {
                return '<div class="text-center"><button value="' . $opciones->solcam_id . '" class="btn btn-primary glyphicon glyphicon-eye-open" onClick="MostrarSolicitud(this);" data-toggle="modal" data-target="#modalSolicitud"></button><button value="' . $opciones->solcam_id . '" class="btn btn-danger glyphicon glyphicon-remove-sign" onClick="EliminarSolicitud(this);"></button></div>'; 
            }elseif ($opciones->solcam_estado == 'B') {
                return '<div class="text-center"><span class="btn btn-warning">PENDIENTE</span></div>';
            }elseif ($opciones->solcam_estado == 'C'){
                return '<div class="text-center"><span class="btn btn-success">APROBADO</span></div>';
            }elseif ($opciones->solcam_estado == 'D'){
                return '<div class="text-center"><span class="btn btn-danger">RECHAZADO</span></div>';
            }
                       
         })->make(true);
    }

    public function mostrarSolicitudCambio($id_sol)
    {
        $solcam = Solicitud_Cambio::join('public._bp_usuarios as usu','acopio.solicitud_cambio.solcam_usr_id','=','usu.usr_id')
                                  ->join('public._bp_personas as perso','usu.usr_prs_id','=','perso.prs_id')
                                  ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')
                                  ->join('acopio.acopio as aco','acopio.solicitud_cambio.solcam_aco_id','=','aco.aco_id')
                                  ->join('acopio.proveedor as prov','aco.aco_id_prov','=','prov.prov_id')
                                  ->join('acopio.tipo_solicitud_cambio as tipsol','acopio.solicitud_cambio.solcam_tipo_id','=','tipsol.tipsolcam_id')
                                  ->where('solcam_id',$id_sol)->first();
        return response()->json($solcam);
    }

    public function aprobarSolicitudCambio(Request $request)
    {
        Aprobacion_Soljefe::create([
            'apsoljefe_aco_id' => $request['apsoljefe_aco_id'],
            'apsoljefe_usr_id' => Auth::user()->usr_id,
            'apsoljefe_solcam_id' => $request['apsoljefe_solcam_id'],
            'apsoljefe_observacion' => $request['apsoljefe_observacion']
        ]);
        // UPDATE AL ESTADO DE SOLCITUD CAMBIO
        $solicitud_cambio_update = Solicitud_Cambio::where('solcam_id',$request['apsoljefe_solcam_id'])->first();
        $solicitud_cambio_update->solcam_estado = 'B';
        $solicitud_cambio_update->save();
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function rechazarSolicitudCambio($id_solicitud)
    {
        $solicitud_cambio_rechazo = Solicitud_Cambio::where('solcam_id',$id_solicitud)->first();
        Aprobacion_Soljefe::create([
            'apsoljefe_aco_id' => $solicitud_cambio_rechazo->solcam_aco_id,
            'apsoljefe_usr_id' => Auth::user()->usr_id,
            'apsoljefe_solcam_id' => $id_solicitud,
            'apsoljefe_estado' => 'B'
        ]);
        $solicitud_cambio_rechazo->solcam_estado = 'D';
        $solicitud_cambio_rechazo->save();
        return response()->json(['mensaje' => 'Se rechazo correctamente']);
    }
    public function rechazarSolicitudCambio2(Request $request)
    {
        $solicitud_cambio_rechazo = Solicitud_Cambio::where('solcam_id',$request['apsoljefe_solcam_id'])->first();
        Aprobacion_Soljefe::create([
            'apsoljefe_aco_id' => $request['apsoljefe_aco_id'],
            'apsoljefe_usr_id' => Auth::user()->usr_id,
            'apsoljefe_solcam_id' => $request['apsoljefe_solcam_id'],
            'apsoljefe_observacion' => $request['apsoljefe_observacion'],
            'apsoljefe_estado' => 'B'
        ]);
        $solicitud_cambio_rechazo->solcam_estado = 'D';
        $solicitud_cambio_rechazo->save();
        return response()->json(['mensaje' => 'Se rechazo correctamente']);
    }

    // SOLICITUDES RECIBIDAS POR PARTE DEL GERENTE
    public function listaSolRecibidasGerente()
    {

        return view('backend.administracion.acopio.acopio_almendra.gbCambioModificacion.indexRecibidasGerente');
    }
    public function listaSolRecibidasGerenteCreate()
    {
        $aprobacion = Aprobacion_Soljefe::join('acopio.solicitud_cambio as solcam','acopio.aprobacion_soljefe.apsoljefe_solcam_id','=','solcam.solcam_id')
                                        ->join('public._bp_usuarios as usu','solcam.solcam_usr_id','=','usu.usr_id')
                                        ->join('public._bp_personas as perso','usu.usr_prs_id','=','perso.prs_id')
                                        ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')
                                        ->join('acopio.acopio as aco','solcam.solcam_aco_id','=','aco.aco_id')
                                        ->join('acopio.proveedor as prov','aco.aco_id_prov','=','prov.prov_id')
                                        ->join('acopio.tipo_solicitud_cambio as tisol','solcam.solcam_tipo_id','=','tisol.tipsolcam_id')
                                        ->where('apsoljefe_estado','A')->get();
        return Datatables::of($aprobacion)
         ->addColumn('nombreComprador', function ($nombreComprador) {
            return $nombreComprador->prs_nombres. ' ' .$nombreComprador->prs_paterno.' '.$nombreComprador->prs_materno;
         })->addColumn('nombreAprobacion', function ($nombreAprobacion) {
            return $this->nombre_usuario($nombreAprobacion->apsoljefe_usr_id);
         })->addColumn('nombreTipoSol', function ($nombreTipoSol) {
            return $nombreTipoSol->tipsolcam_nombre;
         })->addColumn('opciones', function ($opciones) {
            if ($opciones->apsoljefe_estado == 'A') {
                return '<div class="text-center"><button value="' . $opciones->apsoljefe_id . '" class="btn btn-primary glyphicon glyphicon-eye-open" onClick="MostrarSolicitudGerente(this);" data-toggle="modal" data-target="#modalSolicitudGerente"></button><button value="' . $opciones->apsoljefe_id . '" class="btn btn-danger glyphicon glyphicon-remove-sign" onClick="EliminarSolicitudGerente(this);"></button></div>'; 
            }elseif ($opciones->apsoljefe_estado == 'C'){
                return '<div class="text-center"><span class="btn btn-success">APROBADO</span></div>';
            }elseif ($opciones->apsoljefe_estado == 'D'){
                return '<div class="text-center"><span class="btn btn-danger">RECHAZADO</span></div>';
            }
                       
        })->make(true);
    }

    public function nombre_usuario($id_usuario)
    {
        $nombre_usuario = Usuario::join('public._bp_personas as perso','public._bp_usuarios.usr_prs_id','=','perso.prs_id')
                                 ->where('usr_id','=',$id_usuario)->first();
        return $nombre_usuario->prs_nombres.' '.$nombre_usuario->prs_paterno.' '.$nombre_usuario->prs_materno;
    }

    public function aprobarSolicitudCambioGerente(Request $request)
    {
        $soljefe = Aprobacion_Soljefe::where('apsoljefe_id',$request['apsoljefe_id'])->first();
        Aprobacion_Solgerente::create([
            'apsolgerente_aco_id'=>$soljefe->apsoljefe_aco_id,
            'apsolgerente_usr_id'=>Auth::user()->usr_id,
            'apsolgerente_apsoljefe_id'=>$request['apsoljefe_id'],
            'apsolgerente_msj_modal'=>$request['msj']
        ]);
        // APROBACION JEFE ACOPIO
        $soljefe->apsoljefe_estado = 'C';
        $soljefe->save();
        // SOLICITUDES CAMBIOS
        $solicitudes_cambios = Solicitud_Cambio::where('solcam_id',$soljefe->apsoljefe_solcam_id)->first();
        $solicitudes_cambios->solcam_estado = 'C';
        $solicitudes_cambios->save();
        // CAMBIOS AL ACOPIO
        $acopio = Acopio::where('aco_id',$solicitudes_cambios->solcam_aco_id)->first();
        $acopio->aco_cantidad = $solicitudes_cambios->solcam_cantidad;
        $acopio->aco_num_rec = $solicitudes_cambios->solcam_nro_recibo;
        $acopio->aco_cos_un = $solicitudes_cambios->solcam_costo_unitario;
        $acopio->aco_cos_total = $solicitudes_cambios->solcam_costo_total;
        $acopio->aco_peso_neto = $solicitudes_cambios->solcam_peso_caja;
        // dd($solicitudes_cambios->solcam_tipo_id);
        if ($solicitudes_cambios->solcam_tipo_id == 4) {
            // dd($acopio->aco_estado);
            $acopio->aco_estado = 'B';
        }
        $acopio->save();
        return response()->json(['mensaje' => 'Se acepto correctamente']);
    }

    public function rechazarSolicitudCambioGerente($id_apsoljefe)
    {
        $soljefe = Aprobacion_Soljefe::where('apsoljefe_id',$id_apsoljefe)->first();
        Aprobacion_Solgerente::create([
            'apsolgerente_aco_id'=>$soljefe->apsoljefe_aco_id,
            'apsolgerente_usr_id'=>Auth::user()->usr_id,
            'apsolgerente_apsoljefe_id'=>$id_apsoljefe,
            'apsolgerente_estado' => 'B'
        ]);
        // APROBACION JEFE ACOPIO
        $soljefe->apsoljefe_estado = 'D';
        $soljefe->save();
        // SOLICITUDES CAMBIOS
        $solicitudes_cambios = Solicitud_Cambio::where('solcam_id',$soljefe->apsoljefe_solcam_id)->first();
        $solicitudes_cambios->solcam_estado = 'D';
        $solicitudes_cambios->save();
        return response()->json(['mensaje' => 'Se rechazo correctamente']);
    }
    public function rechazarSolicitudCambioGerente2(Request $request)
    {
        $soljefe = Aprobacion_Soljefe::where('apsoljefe_id',$request['apsoljefe_id'])->first();
        Aprobacion_Solgerente::create([
            'apsolgerente_aco_id'=>$soljefe->apsoljefe_aco_id,
            'apsolgerente_usr_id'=>Auth::user()->usr_id,
            'apsolgerente_apsoljefe_id'=>$request['apsoljefe_id'],
            'apsolgerente_estado' => 'B'
        ]);
        // APROBACION JEFE ACOPIO
        $soljefe->apsoljefe_estado = 'D';
        $soljefe->save();
        // SOLICITUDES CAMBIOS
        $solicitudes_cambios = Solicitud_Cambio::where('solcam_id',$soljefe->apsoljefe_solcam_id)->first();
        $solicitudes_cambios->solcam_estado = 'D';
        $solicitudes_cambios->save();
        return response()->json(['mensaje' => 'Se rechazo correctamente']);
    }
    // LISTAR HISTORICO SOLCITUDES RECIBIDAS GERENTE
    public function historicoRecibidaCambioGerenteCreate()
    {
        $aprobacion = Aprobacion_Soljefe::join('acopio.solicitud_cambio as solcam','acopio.aprobacion_soljefe.apsoljefe_solcam_id','=','solcam.solcam_id')
                                        ->join('public._bp_usuarios as usu','solcam.solcam_usr_id','=','usu.usr_id')
                                        ->join('public._bp_personas as perso','usu.usr_prs_id','=','perso.prs_id')
                                        ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')
                                        ->join('acopio.acopio as aco','solcam.solcam_aco_id','=','aco.aco_id')
                                        ->join('acopio.proveedor as prov','aco.aco_id_prov','=','prov.prov_id')
                                        ->join('acopio.tipo_solicitud_cambio as tisol','solcam.solcam_tipo_id','=','tisol.tipsolcam_id')
                                        // ->join('acopio.aprobacion_solgerente as apsolg','acopio.aprobacion_soljefe.apsoljefe_id','=','apsolg.apsolgerente_apsoljefe_id')
                                        // ->where('')
                                        ->where('apsoljefe_estado','<>','A')
                                        ->where('apsoljefe_estado','<>','B')
                                        ->get();
        return Datatables::of($aprobacion)
         ->addColumn('fechaSolicitud', function ($fechaSolicitud) {
            return date("d-m-Y",strtotime($fechaSolicitud->solcam_fecha_registro));
         })
         ->addColumn('fechaRevision', function ($fechaRevision) {
            return date("d-m-Y",strtotime($fechaRevision->apsoljefe_fecha_registro));
         })
         ->addColumn('nombreComprador', function ($nombreComprador) {
            return $nombreComprador->prs_nombres. ' ' .$nombreComprador->prs_paterno.' '.$nombreComprador->prs_materno;
         })->addColumn('nombreAprobacion', function ($nombreAprobacion) {
            return $this->nombre_usuario($nombreAprobacion->apsoljefe_usr_id);
         })->addColumn('nombreTipoSol', function ($nombreTipoSol) {
            return $nombreTipoSol->tipsolcam_nombre;
         })->addColumn('opciones', function ($opciones) {
            if ($opciones->apsoljefe_estado == 'A') {
                return '<div class="text-center"><button value="' . $opciones->apsoljefe_id . '" class="btn btn-success glyphicon glyphicon-ok" onClick="AprobarSolicitudGerente(this);" data-toggle="modal" data-target="#modalSolicitud"></button><button value="' . $opciones->apsoljefe_id . '" class="btn btn-danger glyphicon glyphicon-remove-sign" onClick="EliminarSolicitudGerente(this);"></button></div>'; 
            }elseif ($opciones->apsoljefe_estado == 'C'){
                return '<div class="text-center"><button value="'.$opciones->apsoljefe_id.'" class="btn btn-success" onclick="MostrarModalSolicitud(this);">APROBADO</button></div>';
            }elseif ($opciones->apsoljefe_estado == 'D'){
                return '<div class="text-center"><span class="btn btn-danger">RECHAZADO</span></div>';
            }
                       
        })->make(true);
    }

    // MOSTRAR SOLCITUD GERENTE
    public function mostrarSolicitudCambioGerente($id_sol)
    {
        
        $apsoljefe_sol = Aprobacion_Soljefe::join('acopio.solicitud_cambio as solcam','acopio.aprobacion_soljefe.apsoljefe_solcam_id','=','solcam.solcam_id')
                                        ->join('public._bp_usuarios as usu','solcam.solcam_usr_id','=','usu.usr_id')
                                        ->join('public._bp_personas as perso','usu.usr_prs_id','=','perso.prs_id')
                                        ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')
                                        ->join('acopio.acopio as aco','solcam.solcam_aco_id','=','aco.aco_id')
                                        ->join('acopio.proveedor as prov','aco.aco_id_prov','=','prov.prov_id')
                                        ->join('acopio.tipo_solicitud_cambio as tisol','solcam.solcam_tipo_id','=','tisol.tipsolcam_id')
                                        ->where('apsoljefe_id',$id_sol)->first();
        return response()->json($apsoljefe_sol);
    }

    // MOSTRAR MODAL MENSAJE DE GERENTE
    public function mostrarModalSolcitudGerente($id_btn){
        $apsoljefe_sol = Aprobacion_Soljefe::join('acopio.solicitud_cambio as solcam','acopio.aprobacion_soljefe.apsoljefe_solcam_id','=','solcam.solcam_id')
                                        ->join('public._bp_usuarios as usu','solcam.solcam_usr_id','=','usu.usr_id')
                                        ->join('public._bp_personas as perso','usu.usr_prs_id','=','perso.prs_id')
                                        ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')
                                        ->join('acopio.acopio as aco','solcam.solcam_aco_id','=','aco.aco_id')
                                        ->join('acopio.proveedor as prov','aco.aco_id_prov','=','prov.prov_id')
                                        ->join('acopio.tipo_solicitud_cambio as tisol','solcam.solcam_tipo_id','=','tisol.tipsolcam_id')
                                        ->join('acopio.aprobacion_solgerente as apsolgerente','acopio.aprobacion_soljefe.apsoljefe_id','=','apsolgerente.apsolgerente_apsoljefe_id')
                                        ->where('apsoljefe_id',$id_btn)->first();
        return response()->json($apsoljefe_sol);
    }
}
