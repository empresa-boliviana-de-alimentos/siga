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
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\InsumoHistorial;
use siga\Modelo\insumo\Stock;
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
        $code = $receta->rece_codigo;
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
                              ->join('public._bp_planta as pl','insumo.orden_produccion.orprod_planta_traspaso','=','pl.id_planta')
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
    // public function ingreso_materia_prima($id_envio)
    // {
    //     $username = Auth::user()->usr_usuario;
    //     $title = "NOTA DE INGRESO DE MATERIA PRIMA";
    //     $date =Carbon::now();
    //     $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
    //                     ->where('usr_id', Auth::user()->usr_id)
    //                     ->first();

    //     $storage = $planta->nombre_planta;
    //     $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
    //             ->where('usr_id',Auth::user()->usr_id)->first();
    //     $per=Collect($usr);

    //     $reg = Ingreso::join('acopio.envio_almacen as env','insumo.ingreso.ing_env_acop_id','=','env.enval_id')
    //                     ->where('ing_env_acop_id',$id_envio)
    //                     ->first();
        
    //     $detalle_ingreso = DetalleIngreso::join('insumo.insumo as ins','insumo.detalle_ingreso.deting_ins_id','=','ins.ins_id')
    //                     ->where('deting_ing_id',$reg->ing_id)
    //                     ->first();

    //     $code = $reg['ing_enumeracion'].'/'.date('Y',strtotime($reg['ing_registrado']));
        
    //     $view = \View::make('reportes.ingreso_materia_prima', compact('username','date','title','storage','receta','reg','detalle_ingreso','per','planta'));

    //     $html_content = $view->render();
    //     // return $html_content;
    //     $pdf = App::make('snappy.pdf.wrapper');
    //     $pdf->loadHTML($html_content);
    //     return $pdf->inline();

    // }
    
}
