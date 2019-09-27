<?php

namespace siga\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App;
use siga\Modelo\insumo\insumo_registros\Proveedor;
use siga\Modelo\insumo\insumo_registros\EvaluacionProveedor;
use siga\Modelo\admin\Usuario;//NEW
use DB;
use siga\Modelo\insumo\insumo_registros\UnidadMedida;
use siga\Modelo\insumo\insumo_recetas\Receta;
use siga\Modelo\insumo\insumo_recetas\DetalleReceta;
use siga\Modelo\insumo\insumo_registros\Sabor;
use siga\Modelo\insumo\insumo_registros\SubLinea;
use siga\Modelo\insumo\insumo_registros\Ingreso;
use siga\Modelo\insumo\insumo_registros\DetalleIngreso;
use siga\Modelo\insumo\insumo_registros\IngresoPreliminar;
use siga\Modelo\insumo\insumo_registros\DetalleIngresoPreliminar;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion;
use siga\Modelo\insumo\insumo_devolucion\Devolucion;
use siga\Modelo\insumo\InsumoHistorial;
use siga\Modelo\insumo\Stock;
use siga\Http\Modelo\comercial\SolicitudPv;
use siga\Http\Modelo\comercial\SolicitudProd;
use siga\Http\Modelo\comercial\IngresoPv;
use siga\Http\Modelo\comercial\DetalleIngresoPv;
use siga\Http\Modelo\ProductoTerminado\IngresoCanastilla;
use siga\Http\Modelo\ProductoTerminado\despachoORP;
use siga\Http\Modelo\ProductoTerminado\ProductoTerminadoHistorial;

class ReportController extends Controller
{

    public function test_print()
    {
        $username = Auth::user()->usr_usuario;
        $title = "Reporte ";
        $date =Carbon::now();
        $storage = 'almacen isabel';
        // // $html = '<h1>Hello world</h1>';
        // return view('layouts.print', compact('username','date','title'));
        $view = \View::make('layouts.print', compact('username','date','title','storage'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        //$pdf->loadHTML($html_content)->setPaper('Letter')->setOrientation('landscape')->setOption('margin-bottom', 0); //SETTEANDO LANDSCAPE HORIZONTAL
        return $pdf->inline();
        // return 'test';
    }

    public function reporte_proveedores()
    {
        $username = Auth::user()->usr_usuario;
        $title = "EVALUACIÓN PROVEEDORES";
        $date =Carbon::now();
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
            ->where('usr_id', Auth::user()->usr_id)->first();
        $storage = $planta->nombre_planta;
        // // $html = '<h1>Hello world</h1>';
        // return view('layouts.print', compact('username','date','title'));
        $evaluaciones = EvaluacionProveedor::join('insumo.proveedor as prov','insumo.evaluacion_proveedor.eval_prov_id','=','prov.prov_id')->get();

        $view = \View::make('reportes.proveedores', compact('username','date','title','storage','evaluaciones'));
        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();

    }

    public function imprimir_receta($id_receta)
    {
        $username = Auth::user()->usr_usuario;
        $title = "RECETA";
        $date =Carbon::now();
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
            ->where('usr_id', Auth::user()->usr_id)->first();
        $storage = $planta->nombre_planta;
        $receta = Receta::join('insumo.sub_linea as subl','insumo.receta.rece_sublinea_id','=','subl.sublin_id')
                        ->join('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')
                        ->join('insumo.unidad_medida as uni','insumo.receta.rece_uni_id','=','uni.umed_id')->where('rece_id',$id_receta)
                        ->first();
        // return $receta;
        $code = $receta->rece_codigo??'';
        $dataos_json = null;
        if ($receta->rece_lineaprod_id == 1) {
            $datos_json = json_decode($receta->rece_datos_json);
        }
        $view = \View::make('reportes.receta', compact('username','date','title','storage','receta','code','datos_json'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();

    }
    public function ingreso_materia_prima($id_envio)
    {
        $username = Auth::user()->usr_usuario;
        $title = "NOTA DE INGRESO DE ORDEN PRODUCCIÓN";
        $date =Carbon::now();
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id', Auth::user()->usr_id)
                        ->first();

        $storage = $planta->nombre_planta;
        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per=Collect($usr);


        $reg = Ingreso::join('acopio.envio_almacen as env','insumo.ingreso.ing_env_acop_id','=','env.enval_id')
                      ->where('ing_env_acop_id',$id_envio)->first();
        $detalle_ingreso = DetalleIngreso::join('insumo.insumo as ins','insumo.detalle_ingreso.deting_ins_id','=','ins.ins_id')->where('deting_ing_id',$reg->ing_id)->first();

        $code = $reg['ing_enumeracion'].'/'.date('Y',strtotime($reg['ing_registrado']));

        $view = \View::make('reportes.ingreso_materia_prima', compact('username','date','title','storage','receta','reg','detalle_ingreso','per','planta'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();

    }

    public function orden_de_produccion($id_orprod)
    {

        $username = Auth::user()->usr_usuario;
        $title = "ORDEN DE PRODUCCIÓN";
        $date =Carbon::now();



        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();

        $receta = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                ->join('insumo.sub_linea as subl','rece.rece_sublinea_id','=','subl.sublin_id')
                ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                ->join('insumo.unidad_medida as uni','rece.rece_uni_id','=','uni.umed_id')
                ->join('insumo.mercado as mer','insumo.orden_produccion.orprod_mercado_id','=','mer.mer_id')
                ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')->where('orprod_id',$id_orprod)->first();

        $storage = 'LINEA PRODUCCIÓN '. $this->nombreLinea($receta->rece_lineaprod_id);

        $datos_json = null;
        if ($receta->rece_lineaprod_id == 1) {
            $datos_json = json_decode($receta->rece_datos_json);
        }

        $code = null;

        $view = \View::make('reportes.orden_de_produccion', compact('username','date','title','storage','receta','datos_json'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }

    public function solicitud_traspaso($id_orp)
    {

        $username = Auth::user()->usr_usuario;
        $title = "NOTA DE SOLICITUD POR TRAPASO";
        $date =Carbon::now();



        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)
                    ->first();

        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                    ->where('usr_id',Auth::user()->usr_id)
                    ->first();

        $storage = $planta->nombre_planta;
        $reg = OrdenProduccion::join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_traspaso','=','planta.id_planta')
                              ->join('public._bp_planta as pl','insumo.orden_produccion.orprod_planta_id','=','pl.id_planta')
                              ->join('public._bp_usuarios as usu','insumo.orden_produccion.orprod_usr_id','=','usu.usr_id')
                              ->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
                              ->where('orprod_tiporprod_id',3)->where('orprod_id',$id_orp)
                              ->first();

        $code = $reg['orprod_nro_solicitud'];

        $view = \View::make('reportes.solicitud_traspaso', compact('username','date','title','storage','reg','id_orp','code'));

        $html_content = $view->render();

        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }

    public function kardex_valorado($rep)
    {
        $username = Auth::user()->usr_usuario;
        $title = "KARDEX VALORADO";
        $date =Carbon::now();

        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)
                        ->first();

        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id',Auth::user()->usr_id)
                        ->first();

        $storage = $planta->nombre_planta;

        $insumo = InsumoHistorial::join('insumo.insumo as ins', 'insumo.insumo_historial.inshis_ins_id', '=', 'ins.ins_id')
                        ->join('insumo.unidad_medida as umed', 'ins.ins_id_uni', '=', 'umed.umed_id')
                        ->where('inshis_planta_id', '=', $planta->id_planta)
                        ->where('inshis_ins_id', $rep)
                        ->orderby('inshis_id', 'ASC')
                        ->first();

        $tabkarde = InsumoHistorial::leftJoin('insumo.detalle_ingreso','insumo.detalle_ingreso.deting_id','=','insumo.insumo_historial.inshis_deting_id')
                                    ->leftJoin('insumo.detalle_orden_produccion','insumo.detalle_orden_produccion.detorprod_id','=','insumo.insumo_historial.inshis_detorprod_id')
                                    ->leftJoin('insumo.ingreso','insumo.ingreso.ing_id','=','insumo.detalle_ingreso.deting_ing_id')
                                    ->leftJoin('insumo.orden_produccion','insumo.orden_produccion.orprod_id','=','detalle_orden_produccion.detorprod_orprod_id')
                                    ->where('insumo.insumo_historial.inshis_planta_id', '=', $planta->id_planta)
                                    ->where('insumo.insumo_historial.inshis_ins_id', $rep)
                                    ->orderBy('insumo.insumo_historial.inshis_id')
                                    ->get();
        // return $tabkarde;
        $detallesIngresos = DetalleIngreso::where('deting_ins_id',$rep)->get();

        $stocks = Stock::join('insumo.detalle_ingreso as deting', 'insumo.stock.stock_deting_id', '=', 'deting.deting_id')
			->where('stock_planta_id', $planta->id_planta)
			->where('stock_cantidad', '>', 0)
			->where('stock_ins_id', $rep)
			->orderby('deting_ing_id')
			->get();
        $code = $insumo->ins_codigo;

        $view = \View::make('reportes.kardex_valorado', compact('username','date','title','storage','insumo','tabkarde','code','detallesIngresos','stocks'));

        $html_content = $view->render();

        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();

    }

    public function kardex_fisico($rep)
    {
        $username = Auth::user()->usr_usuario;
        $title = "KARDEX FISICO";
        $date =Carbon::now();

        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)
                        ->first();

        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id',Auth::user()->usr_id)
                        ->first();

        $storage = $planta->nombre_planta;

        $insumo = InsumoHistorial::join('insumo.insumo as ins', 'insumo.insumo_historial.inshis_ins_id', '=', 'ins.ins_id')
                        ->join('insumo.unidad_medida as umed', 'ins.ins_id_uni', '=', 'umed.umed_id')
                        ->where('inshis_planta_id', '=', $planta->id_planta)
                        ->where('inshis_ins_id', $rep)
                        ->orderby('inshis_id', 'ASC')
                        ->first();

        $tabkarde = InsumoHistorial::leftJoin('insumo.detalle_ingreso','insumo.detalle_ingreso.deting_id','=','insumo.insumo_historial.inshis_deting_id')
                                    ->leftJoin('insumo.detalle_orden_produccion','insumo.detalle_orden_produccion.detorprod_id','=','insumo.insumo_historial.inshis_detorprod_id')
                                    ->leftJoin('insumo.ingreso','insumo.ingreso.ing_id','=','insumo.detalle_ingreso.deting_ing_id')
                                    ->leftJoin('insumo.orden_produccion','insumo.orden_produccion.orprod_id','=','detalle_orden_produccion.detorprod_orprod_id')
                                    ->where('insumo.insumo_historial.inshis_planta_id', '=', $planta->id_planta)
                                    ->where('insumo.insumo_historial.inshis_ins_id', $rep)
                                    ->orderBy('insumo.insumo_historial.inshis_id')
                                    ->get();


        $code = $insumo->ins_codigo;

        $view = \View::make('reportes.kardex_fisico', compact('username','date','title','storage','insumo','tabkarde','code'));

        $html_content = $view->render();

        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();

    }

    public function nota_de_salida($id_orp_aprob)
    {
        $username = Auth::user()->usr_usuario;
        $title = "NOTA DE SALIDA ";
        $date =Carbon::now();
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id', Auth::user()->usr_id)
                        ->first();

        $storage = $planta->nombre_planta;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();

        $reg = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')
                                ->join('insumo.mercado as merc','insumo.orden_produccion.orprod_mercado_id','=','merc.mer_id')
                                ->where('orprod_id','=',$id_orp_aprob)
                                ->first();

        $detroprod = DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                ->where('detorprod_orprod_id',$reg->orprod_id)
                                ->get();


        $code = $reg['orprod_nro_salida'].'/'.date('Y',strtotime($reg['orprod_registrado']));

        $view = \View::make('reportes.nota_de_salida', compact('username','date','title','storage','receta','reg','detroprod','usuario','code'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();

    }

    public function nota_de_ingreso($id_ingreso)
    {
        $username = Auth::user()->usr_usuario;
        $title = "NOTA INGRESO";

        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id', Auth::user()->usr_id)
                        ->first();

        $storage = $planta->nombre_planta;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per=Collect($usuario);
        $reg = Ingreso::join('insumo.tipo_ingreso as tip', 'insumo.ingreso.ing_id_tiping', '=', 'tip.ting_id')
                        ->where('ing_id',$id_ingreso)
                        ->first();
        $fecha = Carbon::parse($reg['ing_fecha_remision']);


        $mesesLiteral = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $deta_ingreso = DetalleIngreso::join('insumo.insumo as ins','insumo.detalle_ingreso.deting_ins_id','=','ins.ins_id')
                                                ->leftjoin('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                ->join('insumo.proveedor as prov','insumo.detalle_ingreso.deting_prov_id','=','prov.prov_id')
                                                ->where('deting_ing_id',$id_ingreso)->get();


        $code = $reg['ing_enumeracion'].'/'.date('Y',strtotime($reg['ing_registrado']));
        $date =date('d/m/Y',strtotime($reg['ing_registrado']));

        $view = \View::make('reportes.nota_de_ingreso', compact('username','date','title','storage','reg','deta_ingreso','usuario','code','per'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }

    public function nombreLinea($id){
        if ($id == 1) {
            return 'LACTEOS';
        }elseif($id == 2){
            return 'ALMENDRA';
        }elseif($id == 3){
            return 'MIEL';
        }elseif($id == 4){
            return 'FRUTOS';
        }elseif($id == 5){
            return 'DERIVADOS';
        }
    }
    
    public function boleta_solicitud_adicional($id_orprod)
    {
        $username = Auth::user()->usr_usuario;
        $title = "INSUMO ADICIONAL";
        $date =Carbon::now();



        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();

        $receta = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                ->join('insumo.sub_linea as subl','rece.rece_sublinea_id','=','subl.sublin_id')
                ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                ->join('insumo.unidad_medida as uni','rece.rece_uni_id','=','uni.umed_id')
                ->join('insumo.mercado as mer','insumo.orden_produccion.orprod_mercado_id','=','mer.mer_id')
                ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')->where('orprod_id',$id_orprod)->first();

        $storage = 'LINEA PRODUCCIÓN '. $this->nombreLinea($receta->rece_lineaprod_id);

        $datos_json = null;
        if ($receta->rece_lineaprod_id == 1) {
            $datos_json = json_decode($receta->rece_datos_json);
        }

        $code = null;

        $view = \View::make('reportes.boleta_solicitud_adicional', compact('username','date','title','storage','receta','datos_json'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }

    public function boleta_devolucion_sobrante($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "DEVOLUCION SOBRANTE";
        $date =Carbon::now();

        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_user =  Auth::user()->usr_id;

        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id_user)->first();
        $devolucion = Devolucion::join('public._bp_planta as planta','insumo.devolucion.devo_planta_id','=','planta.id_planta')
                              ->join('public._bp_usuarios as usu','insumo.devolucion.devo_usr_id','=','usu.usr_id')
                              ->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
                              ->join('insumo.orden_produccion as orp','insumo.devolucion.devo_nro_orden','=','orp.orprod_id')
                              ->join('insumo.receta as rece','orp.orprod_rece_id','=','rece.rece_id')
                              ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                              ->where('devo_id',$id)
                              ->first();       
        $code = null;
        $view = \View::make('reportes.boleta_devolucion_sobrante', compact('username','date','title','planta','devolucion'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }

    public function boleta_devolucion_defectuoso($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "DEVOLUCION DEFECTUOSO";
        $date =Carbon::now();

        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_user =  Auth::user()->usr_id;

        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id_user)->first();
        $devolucion = Devolucion::join('public._bp_planta as planta','insumo.devolucion.devo_planta_id','=','planta.id_planta')
                              ->join('public._bp_usuarios as usu','insumo.devolucion.devo_usr_id','=','usu.usr_id')
                              ->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
                              ->join('insumo.orden_produccion as orp','insumo.devolucion.devo_nro_orden','=','orp.orprod_id')
                              ->join('insumo.receta as rece','orp.orprod_rece_id','=','rece.rece_id')
                              ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                              ->where('devo_id',$id)
                              ->first();       
        $code = null;
        $view = \View::make('reportes.boleta_devolucion_defectuoso', compact('username','date','title','planta','devolucion'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }

    public function boleta_aprobacion_sobrante($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "NOTA DE ACEPTACIÓN DEVOLUCIÓN DEFECTUOSO";
        $date =Carbon::now();

        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_user =  Auth::user()->usr_id;

        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id_user)->first();
        $devolucion = Devolucion::join('public._bp_planta as planta','insumo.devolucion.devo_planta_id','=','planta.id_planta')
                              ->join('public._bp_usuarios as usu','insumo.devolucion.devo_usr_id','=','usu.usr_id')
                              ->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
                              ->join('insumo.orden_produccion as orp','insumo.devolucion.devo_nro_orden','=','orp.orprod_id')
                              ->join('insumo.receta as rece','orp.orprod_rece_id','=','rece.rece_id')
                              ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                              ->where('devo_id',$id)
                              ->first();       
        $code = null;
        $view = \View::make('reportes.boleta_aceptacion_sobrante', compact('username','date','title','planta','devolucion'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }

    public function boleta_aprobacion_defectuoso($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "NOTA DE ACEPTACIÓN DEVOLUCIÓN DEFECTUOSO";
        $date =Carbon::now();

        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_user =  Auth::user()->usr_id;

        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id_user)->first();
        $devolucion = Devolucion::join('public._bp_planta as planta','insumo.devolucion.devo_planta_id','=','planta.id_planta')
                              ->join('public._bp_usuarios as usu','insumo.devolucion.devo_usr_id','=','usu.usr_id')
                              ->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
                              ->join('insumo.orden_produccion as orp','insumo.devolucion.devo_nro_orden','=','orp.orprod_id')
                              ->join('insumo.receta as rece','orp.orprod_rece_id','=','rece.rece_id')
                              ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                              ->where('devo_id',$id)
                              ->first();       
        $code = null;
        $view = \View::make('reportes.boleta_aceptacion_defectuoso', compact('username','date','title','planta','devolucion'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();    
    }

    public function ReportPreliminarIngreso($id)
    {
        //dd("REPORTE PRELIMINAR");
        $username = Auth::user()->usr_usuario;
        $title = "NOTA INGRESO";

        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id', Auth::user()->usr_id)
                        ->first();

        $storage = $planta->nombre_planta;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per=Collect($usuario);
        $reg = IngresoPreliminar::join('insumo.tipo_ingreso as tiping','insumo.ingreso_preliminar.ingpre_id_tiping','=','tiping.ting_id')
                                ->where('insumo.ingreso_preliminar.ingpre_id',$id)->first();
        $fecha = Carbon::parse($reg['ing_fecha_remision']);


        $mesesLiteral = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        //$deta_ingreso = DetalleIngreso::join('insumo.insumo as ins','insumo.detalle_ingreso.deting_ins_id','=','ins.ins_id')
        //                                        ->leftjoin('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
        //                                        ->join('insumo.proveedor as prov','insumo.detalle_ingreso.deting_prov_id','=','prov.prov_id')
        //                                        ->where('deting_ing_id',$id_ingreso)->get();
        $deta_ingreso = DetalleIngresoPreliminar::join('insumo.proveedor as prov','insumo.detalle_ingreso_preliminar.detingpre_prov_id','=','prov.prov_id')
                                        ->join('insumo.insumo as ins','insumo.detalle_ingreso_preliminar.detingpre_ins_id','=','ins.ins_id')
                                        ->leftjoin('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                        ->where('detingpre_ingpre_id',$id)->get();


        $code = $reg['ingpre_enumeracion'].'/'.date('Y',strtotime($reg['ingpre_registrado']));
        $date =date('d/m/Y',strtotime($reg['ingpre_registrado']));

        $view = \View::make('reportes.nota_de_ingreso_preliminar', compact('username','date','title','storage','reg','deta_ingreso','usuario','code','per'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }

    public function ingreso_materia_prima_pri($id)
    {
        //dd("Hola");
        $username = Auth::user()->usr_usuario;
        $title = "NOTA DE INGRESO DE MATERIA PRIMA";
        $date =Carbon::now();
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id', Auth::user()->usr_id)
                        ->first();

        $storage = $planta->nombre_planta;
        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per=Collect($usr);


        $reg = Ingreso::join('acopio.envio_almacen as env','insumo.ingreso.ing_env_acop_id','=','env.enval_id')
                      ->where('ing_id',$id)->first();
        //dd($reg);
        $detalle_ingreso = DetalleIngreso::join('insumo.insumo as ins','insumo.detalle_ingreso.deting_ins_id','=','ins.ins_id')->where('deting_ing_id',$reg->ing_id)->first();



        $code = $reg['ing_enumeracion'].'/'.date('Y',strtotime($reg['ing_registrado']));

        $view = \View::make('reportes.ingreso_materia_prima_pri', compact('username','date','title','storage','receta','reg','detalle_ingreso','per','planta'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }
    //******************************************************REPORTES GENERALES*************************************************************//
    public function RpMensual()
    {
        //dd("REPORTE GENERAL MENSUAL");
        $username = Auth::user()->usr_usuario;
        $title = "REPORTE MENSUAL";
        $date =Carbon::now();
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id', Auth::user()->usr_id)
                        ->first();

        $storage = $planta->nombre_planta;
        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per=Collect($usr);


        $insumo_ingreso = DetalleIngreso::select(DB::raw('SUM(deting_cantidad) as deting_cantidad'),'deting_ins_id','deting_costo')->join('insumo.ingreso as ing','insumo.detalle_ingreso.deting_ing_id','=','ing.ing_id')->where('ing_planta_id', '=', $planta->id_planta)->groupBy('deting_costo','deting_ins_id')->orderby('deting_ins_id', 'ASC')->get();
        //dd($reg);
        $view = \View::make('reportes.reporte_mensual', compact('username','date','title','storage','insumo_ingreso','per','storage','planta'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        //$pdf->loadHTML($html_content);
        $pdf->loadHTML($html_content)->setPaper('Letter')->setOrientation('landscape')->setOption('margin-bottom', 0);
        return $pdf->inline();
    }

    public function RptIngresoGeneral()
    {
        //dd("REPORTE PDF INGRESO GENERAL");
        $username = Auth::user()->usr_usuario;
        $title = "REPORTE GENERAL DE INGRESOS";
        $date =Carbon::now();
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id', Auth::user()->usr_id)
                        ->first();
        $storage = $planta->nombre_planta;
        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per=Collect($usr);
        $ingreso = Ingreso::where('ing_planta_id',$planta->id_planta)->get();
        //dd($ingreso);
        $insumo_ingreso = DetalleIngreso::join('insumo.ingreso as ing','insumo.detalle_ingreso.deting_ing_id','=','ing.ing_id')->where('ing_planta_id', '=', $planta->id_planta)->orderby('deting_ins_id', 'ASC')->get();
        $view = \View::make('reportes.reporte_ingreso_general', compact('username','date','title','storage','insumo_ingreso','per','storage','planta','ingreso'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content)->setPaper('Letter')->setOrientation('landscape')->setOption('margin-bottom', 0);
        return $pdf->inline();
    }

    public function RptSolicitudGeneral()
    {
        $username = Auth::user()->usr_usuario;
        $title = "REPORTE GENERAL DE SOLICITUD";
        $date =Carbon::now();
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id', Auth::user()->usr_id)
                        ->first();
        $storage = $planta->nombre_planta;
        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per=Collect($usr);
        $orprod = OrdenProduccion::where('orprod_planta_id',$planta->id_planta)->get();
        $detorprod = DetalleOrdenProduccion::join('insumo.orden_produccion as orp','insumo.detalle_orden_produccion.detorprod_orprod_id','=','orp.orprod_id')->where('orprod_planta_id', '=', $planta->id_planta)->orderby('detorprod_ins_id', 'ASC')->get();
        $view = \View::make('reportes.reporte_solicitud_general', compact('username','date','title','storage','detorprod','per','storage','planta','orprod'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content)->setPaper('Letter')->setOrientation('landscape')->setOption('margin-bottom', 0);
        return $pdf->inline();
    }

    public function RptSalidasGeneral()
    {
        $username = Auth::user()->usr_usuario;
        $title = "REPORTE GENERAL DE SALIDA";
        $date =Carbon::now();
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id', Auth::user()->usr_id)
                        ->first();
        $storage = $planta->nombre_planta;
        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per=Collect($usr);
        $orprod = OrdenProduccion::where('orprod_planta_id',$planta->id_planta)->get();
        $detorprod = DetalleOrdenProduccion::join('insumo.orden_produccion as orp','insumo.detalle_orden_produccion.detorprod_orprod_id','=','orp.orprod_id')->where('orprod_planta_id', '=', $planta->id_planta)->where('orprod_estado_orp','D')->orderby('detorprod_ins_id', 'ASC')->get();
        $view = \View::make('reportes.reporte_salida_general', compact('username','date','title','storage','detorprod','per','storage','planta','orprod'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content)->setPaper('Letter')->setOrientation('landscape')->setOption('margin-bottom', 0);
        return $pdf->inline();
    }

    public function orden_de_produccion_rorp($id_orp)
    {
        //dd("BOLETA DE RECEPCION ORP");
        $username = Auth::user()->usr_usuario;
        $title = "ORDEN DE PRODUCCIÓN";
        $date =Carbon::now();



        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();

        $receta = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                ->join('insumo.sub_linea as subl','rece.rece_sublinea_id','=','subl.sublin_id')
                ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                ->join('insumo.unidad_medida as uni','rece.rece_uni_id','=','uni.umed_id')
                ->join('insumo.mercado as mer','insumo.orden_produccion.orprod_mercado_id','=','mer.mer_id')
                ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')->where('orprod_id',$id_orp)->first();

        $storage = 'LINEA PRODUCCIÓN '. $this->nombreLinea($receta->rece_lineaprod_id);

        $datos_json = null;
        if ($receta->rece_lineaprod_id == 1) {
            $datos_json = json_decode($receta->rece_datos_json);
        }

        $code = null;

        $view = \View::make('reportes.orden_de_produccion_rorp', compact('username','date','title','storage','receta','datos_json'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }

    public function orden_de_produccion_solalorp($id_solalorp)
    {
        //dd($id_solalorp);
        $username = Auth::user()->usr_usuario;
        $title = "ORDEN DE PRODUCCIÓN";
        $date =Carbon::now();

        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();

        $receta = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                ->join('insumo.sub_linea as subl','rece.rece_sublinea_id','=','subl.sublin_id')
                ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                ->join('insumo.unidad_medida as uni','rece.rece_uni_id','=','uni.umed_id')
                ->join('insumo.mercado as mer','insumo.orden_produccion.orprod_mercado_id','=','mer.mer_id')
                ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')->where('orprod_id',$id_solalorp)->first();

        $storage = 'LINEA PRODUCCIÓN '. $this->nombreLinea($receta->rece_lineaprod_id);

        $datos_json = null;
        if ($receta->rece_lineaprod_id == 1) {
            $datos_json = json_decode($receta->rece_datos_json);
        }

        $code = null;

        $view = \View::make('reportes.orden_de_produccion_solalorp', compact('username','date','title','storage','receta','datos_json'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }

    //REPORTES COMRECIAL
    public function imprimirSolpvComercial($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "BOLETA DE SOLICITUD PUNTO DE VENTA";
        $date =Carbon::now();
        $punto_venta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                              ->join('comercial.punto_venta_comercial as pvc', 'planta.id_planta','=','pvc.pv_id_planta')
                              ->select('pvc.pv_nombre','pvc.pv_id','planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $storage = 'PUNTO DE VENTA : '.$punto_venta->pv_nombre;
        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $solpv = SolicitudPv::join('public._bp_usuarios as usr','comercial.solicitud_pv_comercial.solpv_usr_id','=','usr.usr_id')
                            ->join('public._bp_personas as prs','usr.usr_prs_id','=','prs.prs_id')
                            ->where('solpv_id',$id)->first();

        $code = null;

        $view = \View::make('reportes.boleta_solicitudpv_comercial', compact('username','date','title','storage','solpv'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }
    public function imprimirSolprodComercial($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "BOLETA DE SOLICITUD DE PRODUCTOS A PRODUCCION";
        $date =Carbon::now();
        $punto_venta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                              ->join('comercial.punto_venta_comercial as pvc', 'planta.id_planta','=','pvc.pv_id_planta')
                              ->select('pvc.pv_nombre','pvc.pv_id','planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $solprod = SolicitudProd::join('public._bp_usuarios as usr','comercial.solicitud_produccion_comercial.solprod_usr_id','=','usr.usr_id')
                            ->join('public._bp_personas as prs','usr.usr_prs_id','=','prs.prs_id')
                            ->where('solprod_id',$id)->first();
        $storage = $this->traeLinea($solprod->solprod_lineaprod_id);
        $code = null;

        $view = \View::make('reportes.boleta_solicitudprod_comercial', compact('username','date','title','storage','solprod'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();    
    }
    function traeLinea($id)
    {
        if ($id == 1) {
            return "LACTEOS";
        }elseif($id == 2){
            return "ALMENDRA";
        }elseif($id == 3){
            return "MIEL";
        }elseif($id == 4){
            return "FRUTOS";
        }elseif($id == 5){
            return "DERIVADOS";
        }
    }

    public function boletaIngresoPvComercial($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "NOTA INGRESO PRODUCTOS";

        $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                        ->join('comercial.punto_venta_comercial as pv','pl.id_planta','=','pv.pv_id_planta')
                        ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                        ->first();

        $storage = 'PUNTO DE VENTA: '.$planta->pv_nombre;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
        $ingresopv = IngresoPv::where('ingpv_id',$id)->first();
        $detingresopv = DetalleIngresoPv::join('comercial.producto_comercial as prod','comercial.detalle_ingreso_punto_venta_comercial.detingpv_prod_id','=','prod.prod_id')
                                        ->join('insumo.receta as rece','prod.prod_rece_id','=','rece.rece_id')
                                        ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                        ->where('detingpv_ingpv_id',$id)->get();
        $fecha = date('d-m-Y',strtotime($ingresopv->ingpv_registrado));
        $code = $ingresopv->ingpv_nro_ingreso;
        $date =date('d/m/Y', strtotime($ingresopv->ingpv_registrado));

        $view = \View::make('reportes.boleta_ingresopv_comercial', compact('username','ingresopv','detingresopv','date','title','storage','usuario','code','per'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }

    /**********************************************REPORTES PRODUCTO TERMINADO****************************************************/
    public function reporteBoletaIngresoPt($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "NOTA INGRESO PRODUCTOS";

        $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                        ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                        ->first();

        $storage = 'PLANTA: '.$planta->nombre_planta;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
        $detingresopv = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
            ->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
            ->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id', 'ipt_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_usr_id')
            ->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
            ->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
            ->orderBy('orprod_id', 'DESC')
            ->where('orprod_tiporprod_id', 1)
            ->Where('inp.ipt_estado', 'A')
            ->where('orprod_estado_pt', 'I')
            ->where('inp.ipt_id',$id)
            ->first();
           // dd($detingresopv);
        $fecha = date('d-m-Y',strtotime($detingresopv->ipt_registrado));
        $code = $detingresopv->orprod_nro_orden;
        $date =date('d/m/Y', strtotime($detingresopv->ipt_registrado));

        $view = \View::make('reportes.boleta_ingreso_producto_terminado', compact('username','ingresopv','detingresopv','date','title','storage','usuario','code','per'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
        //dd($id);
    }
    public function reporteBoletaIngresoCanasPt($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "NOTA INGRESO CANASTILLOS";
        $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                        ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                        ->first();
        $storage = 'PLANTA: '.$planta->nombre_planta;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
        $detingresocanaspv = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta')
                ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                //->where('iac_estado', 'A')
                ->where('iac_estado_baja', 'A')
                ->where('iac_id',$id)
                ->orderBy('iac_id', 'desc')->first();
        $fecha = date('d-m-Y',strtotime($detingresocanaspv->iac_registrado));
        $code = $detingresocanaspv->iac_nro_ingreso;
        $date =date('d/m/Y', strtotime($detingresocanaspv->iac_registrado));
        $view = \View::make('reportes.boleta_ingreso_canastillo_producto_terminado', compact('username','ingresopv','detingresocanaspv','date','title','storage','usuario','code','per'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }
    public function reporteBoletaDespachoOrpPt($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "NOTA SALIDA ORP";
        $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                        ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                        ->first();
        $storage = 'PLANTA: '.$planta->nombre_planta;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
        $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
            ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
            ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
            ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
            ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
            ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
            ->where('dao_estado', 'A')
            ->where('dao_tipo_orp', 1)
            ->where('dao_id',$id)
            ->first();
        $fecha = date('d-m-Y',strtotime($despachoORP->dao_fecha_despacho));
        $code = $despachoORP->dao_codigo_salida;
        $date =date('d/m/Y', strtotime($despachoORP->dao_fecha_despacho));

        $view = \View::make('reportes.boleta_despacho_orp_producto_terminado', compact('username','ingresopv','despachoORP','date','title','storage','usuario','code','per'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }
    public function reporteBoletaDespachoPtPt($id)
    {
       $username = Auth::user()->usr_usuario;
        $title = "NOTA SALIDA PRODUCTO TERMINADO";
        $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                        ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                        ->first();
        $storage = 'PLANTA: '.$planta->nombre_planta;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
        $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
            ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
            ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
            ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
            ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
            ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
            ->where('dao_estado', 'A')
            ->where('dao_tipo_orp', 2)
            ->where('dao_id',$id)
            ->first();
        $fecha = date('d-m-Y',strtotime($despachoORP->dao_fecha_despacho));
        $code = $despachoORP->dao_codigo_salida;
        $date =date('d/m/Y', strtotime($despachoORP->dao_fecha_despacho));

        $view = \View::make('reportes.boleta_despacho_orp_producto_terminado', compact('username','ingresopv','despachoORP','date','title','storage','usuario','code','per'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }
    public function reporteBoletaDespachoCanasPt($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "NOTA SALIDA CANASTILLOS";
        $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                        ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                        ->first();
        $storage = 'PLANTA: '.$planta->nombre_planta;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
        $datosCanastilla = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta', 'iac_usr_id', 'iac_origen', 'iac_fecha_salida', 'iac_codigo_salida')
            ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
            ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
            ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
            ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
            ->where('iac_estado', 'D')
            ->where('iac_estado_baja', 'A')
            ->where('iac_id',$id)
            ->orderBy('iac_id', 'desc')
            ->first();    
        $fecha = date('d-m-Y',strtotime($datosCanastilla->iac_fecha_salida));
        $code = $datosCanastilla->iac_codigo_salida;
        $date =date('d/m/Y', strtotime($datosCanastilla->iac_fecha_salida));

        $view = \View::make('reportes.boleta_despacho_canastillo_producto_terminado', compact('username','ingresopv','datosCanastilla','date','title','storage','usuario','code','per'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }
    public function reporteInventarioMesAlamacenMesPt($mes, $anio)
    {
        $username = Auth::user()->usr_usuario;
        $title = "INVENTARIO ALMACEN";
        $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                        ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                        ->first();
        $storage = 'PLANTA: '.$planta->nombre_planta;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
        $anio1 = $anio;
        $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
        $fechainicial = $anio1 . "-" . $mes . "-01";
        $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
        $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                        ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                        ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                        ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                        ->where('spth_registrado', '>=', $fechainicial)->where('spth_registrado', '<=', $fechafinal)
                        ->where('spth_planta_id',$planta->id_planta)
                        ->get();  
        $fecha = 'Del '.$fechainicial.' al '.$fechafinal;
        $code = '-';
        $date =date('d/m/Y');

        $view = \View::make('reportes.inventario_mes_almacen_producto_terminado', compact('username','ingresopv','stockptMes','date','title','storage','usuario','code','per','fecha'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }
    public function reporteInventarioDiaAlamacenMesPt($dia,$mes,$anio)
    {
        //dd($dia.'-'.$mes.'-'.$anio);
        $username = Auth::user()->usr_usuario;
        $title = "INVENTARIO ALMACEN";
        $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                        ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                        ->first();
        $storage = 'PLANTA: '.$planta->nombre_planta;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
        $dia = $anio . "-" . $mes . "-" . $dia;
        $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                        ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                        ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                        ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                        //->where('spth_registrado', '>=', $dia)->where('spth_registrado', '<=', $dia)
                        ->where(DB::raw('cast(stock_producto_terminado_historial.spth_registrado as date)'),'=',$dia)
                        ->where('spth_planta_id',$planta->id_planta)
                        ->get();
        $fecha = $dia;
        $code = '-';
        $date =date('d/m/Y');

        $view = \View::make('reportes.inventario_mes_almacen_producto_terminado', compact('username','ingresopv','stockptMes','date','title','storage','usuario','code','per','fecha'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }
    public function reporteInventarioRangoAlmacenRangPt($dia_inicio, $mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin)
    {
        //dd($dia_inicio.' '.$mes_inicio.' '.$anio_inicio.' FIN '.$dia_fin.' '.$mes_fin.' '.$anio_fin);
        $username = Auth::user()->usr_usuario;
        $title = "INVENTARIO ALMACEN";
        $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                        ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                        ->first();
        $storage = 'PLANTA: '.$planta->nombre_planta;
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
        $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
        $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
        $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                        ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                        ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                        ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                        ->where(DB::raw('cast(stock_producto_terminado_historial.spth_registrado as date)'), '>=', $fechainicial)
                        ->where(DB::raw('cast(stock_producto_terminado_historial.spth_registrado as date)'), '<=', $fechafinal)
                        ->where('spth_planta_id',$planta->id_planta)
                        ->get();
        $fecha = 'Desde: '.$dia_inicio.'/'.$mes_inicio.'/'.$anio_inicio.' Hasta: '.$dia_fin.'/'.$mes_fin.'/'.$anio_inicio;
        $code = '-';
        $date =date('d/m/Y');

        $view = \View::make('reportes.inventario_mes_almacen_producto_terminado', compact('username','ingresopv','stockptMes','date','title','storage','usuario','code','per','fecha'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }
    public function reporteIngresoMesGeneralPt($mes,$anio,$planta)
    {
        //dd($mes.' '.$anio.' '.$planta);
        if($planta == 0){
            //dd($planta);
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;        
            $ingresoOrp = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
                    ->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
                    ->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id', 'ipt_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_usr_id')
                    ->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
                    ->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
                    ->orderBy('orprod_id', 'DESC')
                    ->where('orprod_tiporprod_id', 1)
                    ->Where('inp.ipt_estado', 'A')
                    ->where('orprod_estado_pt', 'I')
                    ->where('ipt_registrado', '>=', $fechainicial)->where('ipt_registrado', '<=', $fechafinal)
                    ->orderBy('ipt_id','desc')
                    ->get();
            $fecha = 'Desde: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.reporte_ingreso_general_producto_terminado', compact('username','ingresoOrp','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            //dd($planta);
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;        
            $ingresoOrp = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
                ->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
                ->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id', 'ipt_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_usr_id')
                ->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
                ->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
                ->orderBy('orprod_id', 'DESC')
                ->where('orprod_tiporprod_id', 1)
                ->Where('inp.ipt_estado', 'A')
                ->where('orprod_estado_pt', 'I')
                ->where('orprod_planta_id',$planta1)
                ->where('ipt_registrado', '>=', $fechainicial)->where('ipt_registrado', '<=', $fechafinal)
                ->orderBy('ipt_id','desc')
                ->get();
            $fecha = 'Desde: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.reporte_ingreso_general_producto_terminado', compact('username','ingresoOrp','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }       
        
    }
    public function reporteIngresoDiaGeneralPt($dia,$mes,$anio,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO GENERAL DÍA";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $dia = $anio . "-" . $mes . "-" . $dia;
            $ingresoOrp = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
                    ->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
                    ->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id', 'ipt_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_usr_id')
                    ->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
                    ->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
                    ->orderBy('orprod_id', 'DESC')
                    ->where('orprod_tiporprod_id', 1)
                    ->Where('inp.ipt_estado', 'A')
                    ->where('orprod_estado_pt', 'I')
                    ->where(DB::raw('cast(inp.ipt_registrado as date)'),'=',$dia)
                    ->orderBy('ipt_id','desc')
                    ->get();
            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.reporte_ingreso_general_producto_terminado', compact('username','ingresoOrp','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta; 
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO GENERAL DÍA";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $dia = $anio . "-" . $mes . "-" . $dia;
            $ingresoOrp = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
                    ->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
                    ->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id', 'ipt_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_usr_id')
                    ->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
                    ->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
                    ->orderBy('orprod_id', 'DESC')
                    ->where('orprod_tiporprod_id', 1)
                    ->Where('inp.ipt_estado', 'A')
                    ->where('orprod_estado_pt', 'I')
                    ->where('orprod_planta_id',$planta1)
                    ->where(DB::raw('cast(inp.ipt_registrado as date)'),'=',$dia)
                    ->orderBy('ipt_id','desc')
                    ->get();
            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.reporte_ingreso_general_producto_terminado', compact('username','ingresoOrp','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }        
    }
    public function imprimirPdfIngresoRangoAlmacenPt($dia_inicio, $mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin, $planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO GENERAL DÍA";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $ingresoOrp = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
                    ->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
                    ->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id', 'ipt_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_usr_id')
                    ->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
                    ->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
                    ->orderBy('orprod_id', 'DESC')
                    ->where('orprod_tiporprod_id', 1)
                    ->Where('inp.ipt_estado', 'A')
                    ->where('orprod_estado_pt', 'I')
                    ->where(DB::raw('cast(inp.ipt_registrado as date)'), '>=', $fechainicial)
                    ->where(DB::raw('cast(inp.ipt_registrado as date)'), '<=', $fechafinal)
                    ->orderBy('ipt_id','desc')
                    ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.reporte_ingreso_general_producto_terminado', compact('username','ingresoOrp','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta; 
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO GENERAL DÍA";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $ingresoOrp = OrdenProduccion::join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
                    ->join('public._bp_planta as planta', 'insumo.orden_produccion.orprod_planta_id', '=', 'planta.id_planta')
                    ->leftjoin('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id', 'ipt_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_usr_id')
                    ->leftjoin('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')
                    ->join('producto_terminado.ingreso_almacen_orp as inp', 'inp.ipt_orprod_id', '=', 'orprod_id')
                    ->orderBy('orprod_id', 'DESC')
                    ->where('orprod_tiporprod_id', 1)
                    ->Where('inp.ipt_estado', 'A')
                    ->where('orprod_estado_pt', 'I')
                    ->where('orprod_planta_id',$planta1)
                    ->where(DB::raw('cast(inp.ipt_registrado as date)'), '>=', $fechainicial)
                    ->where(DB::raw('cast(inp.ipt_registrado as date)'), '<=', $fechafinal)
                    ->orderBy('ipt_id','desc')
                    ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.reporte_ingreso_general_producto_terminado', compact('username','ingresoOrp','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }   
    }
    public function imprimirPdfIngresosCanasMesAlmacenPt($mes,$anio,$planta)
    {
        //dd($mes.' '.$anio.' '.$planta);
        if($planta == 0){
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $ingresoCanastillos = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta')
                    ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                    ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                    ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                    ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                    //->where('iac_estado', 'A')
                    ->where('iac_registrado', '>=', $fechainicial)->where('iac_registrado', '<=', $fechafinal)
                    ->where('iac_estado_baja', 'A')
                    ->orderBy('iac_id', 'desc')->get();
            //dd($ingresoCanastillos);
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_ingreso_canastillo_general_producto_terminado', compact('username','ingresoCanastillos','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $ingresoCanastillos = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta')
                    ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                    ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                    ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                    ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                    //->where('iac_estado', 'A')
                    ->where('iac_registrado', '>=', $fechainicial)->where('iac_registrado', '<=', $fechafinal)
                    ->where('iac_origen',$planta1)
                    ->where('iac_estado_baja', 'A')
                    ->orderBy('iac_id', 'desc')->get();
            //dd($ingresoCanastillos);
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_ingreso_canastillo_general_producto_terminado', compact('username','ingresoCanastillos','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }        
    }
    public function imprimirPdfIngresosCanasDiaAlmacenPt($dia,$mes,$anio,$planta)
    {
        if($planta == 0){
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $dia = $anio . "-" . $mes . "-" . $dia;
            $ingresoCanastillos = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta')
                ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                //->where('iac_estado', 'A')
                ->where(DB::raw('cast(iac_registrado as date)'),'=',$dia)
                ->where('iac_estado_baja', 'A')
                ->orderBy('iac_id', 'desc')->get();
            //dd($ingresoCanastillos);
            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_ingreso_canastillo_general_producto_terminado', compact('username','ingresoCanastillos','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $dia = $anio . "-" . $mes . "-" . $dia;
            $ingresoCanastillos = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta')
                ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                //->where('iac_estado', 'A')
                ->where(DB::raw('cast(iac_registrado as date)'),'=',$dia)
                ->where('iac_origen',$planta1)
                ->where('iac_estado_baja', 'A')
                ->orderBy('iac_id', 'desc')->get();
            //dd($ingresoCanastillos);
            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_ingreso_canastillo_general_producto_terminado', compact('username','ingresoCanastillos','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        } 
    }
    public function imprimirPdfIngresosCanasRangoAlmacenPt($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin,$planta)
    {
        if($planta == 0){
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $ingresoCanastillos = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta')
                ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                //->where('iac_estado', 'A')
                ->where(DB::raw('cast(iac_registrado as date)'), '>=', $fechainicial)
                ->where(DB::raw('cast(iac_registrado as date)'), '<=', $fechafinal)
                ->where('iac_estado_baja', 'A')
                ->orderBy('iac_id', 'desc')->get();
            //dd($ingresoCanastillos);
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_ingreso_canastillo_general_producto_terminado', compact('username','ingresoCanastillos','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE INGRESO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $ingresoCanastillos = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta')
                ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                //->where('iac_estado', 'A')
                ->where(DB::raw('cast(iac_registrado as date)'), '>=', $fechainicial)
                ->where(DB::raw('cast(iac_registrado as date)'), '<=', $fechafinal)
                ->where('iac_origen',$planta1)
                ->where('iac_estado_baja', 'A')
                ->orderBy('iac_id', 'desc')->get();
            //dd($ingresoCanastillos);
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_ingreso_canastillo_general_producto_terminado', compact('username','ingresoCanastillos','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }
    }
    public function imprimirPdfDespachosOrpMesGeneralPt($mes,$anio,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO ORP GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 1)
                ->where('dao_registrado', '>=', $fechainicial)->where('dao_registrado', '<=', $fechafinal)
                ->orderBy('dao_id','asc')
                ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO ORP GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 1)
                ->where('dao_registrado', '>=', $fechainicial)->where('dao_registrado', '<=', $fechafinal)
                ->where('orprod_planta_id',$planta1)
                ->orderBy('dao_id','asc')
                ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }            
    }
    public function imprimirPdfDespachosOrpDiaGeneralPt($dia,$mes,$anio,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO ORP GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $dia = $anio . "-" . $mes . "-" . $dia;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 1)
                ->where(DB::raw('cast(dao_registrado as date)'),'=',$dia)
                ->orderBy('dao_id','asc')
                ->get();
            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO ORP GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $dia = $anio . "-" . $mes . "-" . $dia;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 1)
                ->where(DB::raw('cast(dao_registrado as date)'),'=',$dia)
                ->where('orprod_planta_id',$planta1)
                ->orderBy('dao_id','asc')
                ->get();
            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        } 
    }
    public function imprimirPdfDespachosOrpRangoGeneralPt($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO ORP GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 1)
                ->where(DB::raw('cast(dao_registrado as date)'), '>=', $fechainicial)
                ->where(DB::raw('cast(dao_registrado as date)'), '<=', $fechafinal)
                ->orderBy('dao_id','asc')
                ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO ORP GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 1)
                ->where(DB::raw('cast(dao_registrado as date)'), '>=', $fechainicial)
                ->where(DB::raw('cast(dao_registrado as date)'), '<=', $fechafinal)
                ->where('orprod_planta_id',$planta1)
                ->orderBy('dao_id','asc')
                ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }
    }
    public function imprimirPdfDespachosPtMesGeneralPt($mes,$anio,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO PRODUCTO TERMINADO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 2)
                ->where('dao_registrado', '>=', $fechainicial)->where('dao_registrado', '<=', $fechafinal)
                //->where('orprod_planta_id',$planta->id_planta)
                ->orderBy('dao_id','desc')
                ->get();

            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO PRODUCTO TERMINADO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 2)
                ->where('dao_registrado', '>=', $fechainicial)->where('dao_registrado', '<=', $fechafinal)
                ->where('orprod_planta_id',$planta1)
                ->orderBy('dao_id','desc')
                ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }
    }
    public function imprimirPdfDespachosPtDiaGeneralPt($dia,$mes,$anio,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO PRODUCTO TERMINADO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $dia = $anio . "-" . $mes . "-" . $dia;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 2)
                ->where(DB::raw('cast(dao_registrado as date)'),'=',$dia)
                //->where('orprod_planta_id',$planta->id_planta)
                ->orderBy('dao_id','desc')
                ->get();

            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO PRODUCTO TERMINADO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $dia = $anio . "-" . $mes . "-" . $dia;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 2)
                ->where(DB::raw('cast(dao_registrado as date)'),'=',$dia)
                ->where('orprod_planta_id',$planta1)
                ->orderBy('dao_id','desc')
                ->get();
            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }
    }
    public function imprimirPdfDespachosPtRangoGeneralPt($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin,$planta)
    {
         if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO PRODUCTO TERMINADO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 2)
                ->where(DB::raw('cast(dao_registrado as date)'), '>=', $fechainicial)
                ->where(DB::raw('cast(dao_registrado as date)'), '<=', $fechafinal)
                ->orderBy('dao_id','desc')
                ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO PRODUCTO TERMINADO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $despachoORP = despachoORP::select('dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_fecha_despacho', 'dao_cantidad', 'dao_usr_id', 'dao_codigo_salida', 'rece_nombre', 'rece_presentacion', 'planta.id_planta as id_origen', 'planta.nombre_planta as origen', 'desti.de_nombre as destino', 'rece.rece_lineaprod_id', 'orp.orprod_codigo','rece_codigo')
                ->join('producto_terminado.ingreso_almacen_orp as din', 'din.ipt_id', '=', 'dao_ipt_id')
                ->join('insumo.orden_produccion as orp', 'orp.orprod_id', '=', 'din.ipt_orprod_id')
                ->join('public._bp_planta as planta', 'orp.orprod_planta_id', '=', 'planta.id_planta')
                ->join('insumo.receta as rece', 'orp.orprod_rece_id', '=', 'rece.rece_id')
                ->join('producto_terminado.destino as desti', 'desti.de_id', '=', 'dao_de_id')
                ->where('dao_estado', 'A')
                ->where('dao_tipo_orp', 2)
                ->where(DB::raw('cast(dao_registrado as date)'), '>=', $fechainicial)
                ->where(DB::raw('cast(dao_registrado as date)'), '<=', $fechafinal)
                ->where('orprod_planta_id',$planta1)
                ->orderBy('dao_id','desc')
                ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_general_producto_terminado', compact('username','despachoORP','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }
    }
    public function imprimirPdfDespachosCanastilloMesGeneralPt($mes,$anio,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $datosCanastillas = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta', 'iac_usr_id', 'iac_origen', 'iac_fecha_salida', 'iac_codigo_salida')
                ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                ->where('iac_estado', 'D')
                ->where('iac_estado_baja', 'A')
                ->where('iac_fecha_salida', '>=', $fechainicial)->where('iac_fecha_salida', '<=', $fechafinal)
                ->orderBy('iac_id', 'desc')
                ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_canastillo_general_producto_terminado', compact('username','datosCanastillas','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $datosCanastillas = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta', 'iac_usr_id', 'iac_origen', 'iac_fecha_salida', 'iac_codigo_salida')
                ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                ->where('iac_estado', 'D')
                ->where('iac_estado_baja', 'A')
                ->where('iac_origen',$planta1)
                ->where('iac_fecha_salida', '>=', $fechainicial)->where('iac_fecha_salida', '<=', $fechafinal)
                ->orderBy('iac_id', 'desc')
                ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_canastillo_general_producto_terminado', compact('username','datosCanastillas','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }            
    }
    public function imprimirPdfDespachosCanastilloDiaGeneralPt($dia,$mes,$anio,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $dia = $anio . "-" . $mes . "-" . $dia;
            $datosCanastillas = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta', 'iac_usr_id', 'iac_origen', 'iac_fecha_salida', 'iac_codigo_salida')
                ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                ->where('iac_estado', 'D')
                ->where('iac_estado_baja', 'A')
                ->where(DB::raw('cast(iac_fecha_salida as date)'),'=',$dia)
                ->orderBy('iac_id', 'desc')
                ->get();
            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_canastillo_general_producto_terminado', compact('username','datosCanastillas','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $dia = $anio . "-" . $mes . "-" . $dia;
            $datosCanastillas = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta', 'iac_usr_id', 'iac_origen', 'iac_fecha_salida', 'iac_codigo_salida')
                ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                ->where('iac_estado', 'D')
                ->where('iac_estado_baja', 'A')
                ->where('iac_origen',$planta1)
                ->where(DB::raw('cast(iac_fecha_salida as date)'),'=',$dia)
                ->orderBy('iac_id', 'desc')
                ->get();
            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_canastillo_general_producto_terminado', compact('username','datosCanastillas','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        } 
    }
    public function imprimirPdfDespachosCanastilloRangoGeneralPt($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $datosCanastillas = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta', 'iac_usr_id', 'iac_origen', 'iac_fecha_salida', 'iac_codigo_salida')
                ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                ->where('iac_estado', 'D')
                ->where('iac_estado_baja', 'A')
                ->where(DB::raw('cast(iac_fecha_salida as date)'), '>=', $fechainicial)
                ->where(DB::raw('cast(iac_fecha_salida as date)'), '<=', $fechafinal)
                ->orderBy('iac_id', 'desc')
                ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_canastillo_general_producto_terminado', compact('username','datosCanastillas','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "REPORTE DESPACHO CANASTILLOS GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                                ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                                ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $datosCanastillas = IngresoCanastilla::select('iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_observacion', 'nombre_planta', DB::raw("CONCAT(rr.rece_nombre,' ',rr.rece_presentacion,' - ',rr.rece_codigo) AS producto"), 'ca.ctl_descripcion', 'ca.ctl_material', 'ca.ctl_foto_canastillo', DB::raw("CONCAT(co.pcd_nombres,' ',co.pcd_paterno,' ',co.pcd_materno) AS conductor"), 'planta.nombre_planta', 'iac_usr_id', 'iac_origen', 'iac_fecha_salida', 'iac_codigo_salida')
                ->join('producto_terminado.canastillos as ca', 'ca.ctl_id', '=', 'iac_ctl_id')
                ->join('insumo.receta as rr', 'rr.rece_id', '=', 'ca.ctl_rece_id')
                ->join('public._bp_planta as planta', 'planta.id_planta', '=', 'iac_origen')
                ->join('producto_terminado.conductor as co', 'co.pcd_id', '=', 'iac_chofer')
                ->where('iac_estado', 'D')
                ->where('iac_estado_baja', 'A')
                ->where('iac_origen',$planta1)
                ->where(DB::raw('cast(iac_fecha_salida as date)'), '>=', $fechainicial)
                ->where(DB::raw('cast(iac_fecha_salida as date)'), '<=', $fechafinal)
                ->orderBy('iac_id', 'desc')
                ->get();
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');
            $view = \View::make('reportes.reporte_despacho_canastillo_general_producto_terminado', compact('username','datosCanastillas','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        } 
    }
    public function imprimirPdfInventarioGralMesAlmacenPt($mes,$anio,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "INVENTARIO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where('spth_registrado', '>=', $fechainicial)->where('spth_registrado', '<=', $fechafinal)
                            ->get();  
            $fecha = 'Del '.$fechainicial.' al '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.inventario_gral_mes_almacen_producto_terminado', compact('username','ingresopv','stockptMes','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "INVENTARIO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where('spth_registrado', '>=', $fechainicial)->where('spth_registrado', '<=', $fechafinal)
                            ->where('spth_planta_id',$planta1)
                            ->get();  
            $fecha = 'Del '.$fechainicial.' al '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.inventario_gral_mes_almacen_producto_terminado', compact('username','ingresopv','stockptMes','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }        
    }
    public function imprimirPdfInventarioGralDiaAlmacenPt($dia,$mes,$anio,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "INVENTARIO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $dia = $anio . "-" . $mes . "-" . $dia;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where(DB::raw('cast(spth_registrado as date)'),'=',$dia)
                            ->get();  
            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.inventario_gral_mes_almacen_producto_terminado', compact('username','ingresopv','stockptMes','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "INVENTARIO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where(DB::raw('cast(spth_registrado as date)'),'=',$dia)
                            ->where('spth_planta_id',$planta1)
                            ->get();  
            $fecha = $dia;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.inventario_gral_mes_almacen_producto_terminado', compact('username','ingresopv','stockptMes','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        } 
    }
    public function imprimirPdfInventarioGralRangoAlmacenPt($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin,$planta)
    {
        if ($planta == 0) {
            $username = Auth::user()->usr_usuario;
            $title = "INVENTARIO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where(DB::raw('cast(spth_registrado as date)'), '>=', $fechainicial)
                            ->where(DB::raw('cast(spth_registrado as date)'), '<=', $fechafinal)
                            ->get();  
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.inventario_gral_mes_almacen_producto_terminado', compact('username','ingresopv','stockptMes','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        }else{
            $planta1 = $planta;
            $username = Auth::user()->usr_usuario;
            $title = "INVENTARIO GENERAL";
            $planta = Usuario::join('public._bp_planta as pl', 'public._bp_usuarios.usr_planta_id', '=', 'pl.id_planta')
                            ->where('_bp_usuarios.usr_id', Auth::user()->usr_id)
                            ->first();
            $storage = 'PLANTA: '.$planta->nombre_planta;
            $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                    ->where('usr_id',Auth::user()->usr_id)->first();
            $per= $usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno;
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where(DB::raw('cast(spth_registrado as date)'), '>=', $fechainicial)
                            ->where(DB::raw('cast(spth_registrado as date)'), '<=', $fechafinal)
                            ->where('spth_planta_id',$planta1)
                            ->get();  
            $fecha = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
            $code = '-';
            $date =date('d/m/Y');

            $view = \View::make('reportes.inventario_gral_mes_almacen_producto_terminado', compact('username','ingresopv','stockptMes','date','title','storage','usuario','code','per','fecha'));
            $html_content = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($html_content);
            return $pdf->inline();
        } 
    }
    //REPORTE KARDEX
    public function RpKardexValoradoPt($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "KARDEX VALORADO PRODUCTO TERMINADO";
        $date =Carbon::now();
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)
                        ->first();
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id',Auth::user()->usr_id)
                        ->first();
        $storage = $planta->nombre_planta;
        /*$insumo = InsumoHistorial::join('insumo.insumo as ins', 'insumo.insumo_historial.inshis_ins_id', '=', 'ins.ins_id')
                        ->join('insumo.unidad_medida as umed', 'ins.ins_id_uni', '=', 'umed.umed_id')
                        ->where('inshis_planta_id', '=', $planta->id_planta)
                        ->where('inshis_ins_id', $rep)
                        ->orderby('inshis_id', 'ASC')
                        ->first();
        $tabkarde = InsumoHistorial::leftJoin('insumo.detalle_ingreso','insumo.detalle_ingreso.deting_id','=','insumo.insumo_historial.inshis_deting_id')
                                    ->leftJoin('insumo.detalle_orden_produccion','insumo.detalle_orden_produccion.detorprod_id','=','insumo.insumo_historial.inshis_detorprod_id')
                                    ->leftJoin('insumo.ingreso','insumo.ingreso.ing_id','=','insumo.detalle_ingreso.deting_ing_id')
                                    ->leftJoin('insumo.orden_produccion','insumo.orden_produccion.orprod_id','=','detalle_orden_produccion.detorprod_orprod_id')
                                    ->where('insumo.insumo_historial.inshis_planta_id', '=', $planta->id_planta)
                                    ->where('insumo.insumo_historial.inshis_ins_id', $rep)
                                    ->orderBy('insumo.insumo_historial.inshis_id')
                                    ->get();
        $detallesIngresos = DetalleIngreso::where('deting_ins_id',$rep)->get();
        $stocks = Stock::join('insumo.detalle_ingreso as deting', 'insumo.stock.stock_deting_id', '=', 'deting.deting_id')
            ->where('stock_planta_id', $planta->id_planta)
            ->where('stock_cantidad', '>', 0)
            ->where('stock_ins_id', $rep)
            ->orderby('deting_ing_id')
            ->get();*/
        $code = '001';
        $view = \View::make('reportes.kardex_valorado_pt', compact('username','date','title','storage','insumo','tabkarde','code','detallesIngresos','stocks'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }
    public function RpKardexFisicoPt($id)
    {
        $username = Auth::user()->usr_usuario;
        $title = "KARDEX FISICO PRODUCTO TERMINADO";
        $date =Carbon::now();
        $usuario = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)
                        ->first();
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                        ->where('usr_id',Auth::user()->usr_id)
                        ->first();
        $storage = $planta->nombre_planta;
        /*$insumo = InsumoHistorial::join('insumo.insumo as ins', 'insumo.insumo_historial.inshis_ins_id', '=', 'ins.ins_id')
                        ->join('insumo.unidad_medida as umed', 'ins.ins_id_uni', '=', 'umed.umed_id')
                        ->where('inshis_planta_id', '=', $planta->id_planta)
                        ->where('inshis_ins_id', $rep)
                        ->orderby('inshis_id', 'ASC')
                        ->first();
        $tabkarde = InsumoHistorial::leftJoin('insumo.detalle_ingreso','insumo.detalle_ingreso.deting_id','=','insumo.insumo_historial.inshis_deting_id')
                                    ->leftJoin('insumo.detalle_orden_produccion','insumo.detalle_orden_produccion.detorprod_id','=','insumo.insumo_historial.inshis_detorprod_id')
                                    ->leftJoin('insumo.ingreso','insumo.ingreso.ing_id','=','insumo.detalle_ingreso.deting_ing_id')
                                    ->leftJoin('insumo.orden_produccion','insumo.orden_produccion.orprod_id','=','detalle_orden_produccion.detorprod_orprod_id')
                                    ->where('insumo.insumo_historial.inshis_planta_id', '=', $planta->id_planta)
                                    ->where('insumo.insumo_historial.inshis_ins_id', $rep)
                                    ->orderBy('insumo.insumo_historial.inshis_id')
                                    ->get();
        $detallesIngresos = DetalleIngreso::where('deting_ins_id',$rep)->get();
        $stocks = Stock::join('insumo.detalle_ingreso as deting', 'insumo.stock.stock_deting_id', '=', 'deting.deting_id')
            ->where('stock_planta_id', $planta->id_planta)
            ->where('stock_cantidad', '>', 0)
            ->where('stock_ins_id', $rep)
            ->orderby('deting_ing_id')
            ->get();*/
        $code = '001';
        $view = \View::make('reportes.kardex_fisico_pt', compact('username','date','title','storage','insumo','tabkarde','code','detallesIngresos','stocks'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();
    }
}
