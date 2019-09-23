<?php

namespace siga\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use siga\Modelo\insumo\insumo_registros\Ufv;
use siga\Modelo\insumo\insumo_registros\Ingreso;
use siga\Modelo\insumo\insumo_registros\DetalleIngreso;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion;
use siga\Http\Modelo\ProductoTerminado\IngresoCanastilla;
use siga\Http\Modelo\ProductoTerminado\despachoORP;
use Auth;
use siga\Modelo\admin\Usuario;
use DB;

class ReportExcelController extends Controller
{
    public function RpMensualExcel()
    {
    	$id_usuario = Auth::user()->usr_id;
		$usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
			->where('usr_id', $id_usuario)->first();
		$per = Collect($usr);
		$id = Auth::user()->usr_id;
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->where('usr_id', $id)->first();
		$insumo_ingreso = DetalleIngreso::select(DB::raw('SUM(deting_cantidad) as deting_cantidad'),'deting_ins_id','deting_costo')->join('insumo.ingreso as ing','insumo.detalle_ingreso.deting_ing_id','=','ing.ing_id')->where('ing_planta_id', '=', $planta->id_planta)->groupBy('deting_costo','deting_ins_id')->orderby('deting_ins_id', 'ASC')->get();
    	$ufvs = Ufv::get();
        \Excel::create('Reporte_Mensual', function($excel) use ($insumo_ingreso, $planta) {
             $excel->sheet('Excel sheet', function($sheet) use ($insumo_ingreso, $planta) {
                $sheet->loadView('reportes_excel.reporte_mensual', array('insumo_ingreso'=>$insumo_ingreso,'planta'=>$planta));
            });
        })->export('xlsx');
    }

    public function RptIngresoGeneralExcel()
    {
        $id_usuario = Auth::user()->usr_id;
        $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
            ->where('usr_id', $id_usuario)->first();
        $per = Collect($usr);
        $id = Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
            ->where('usr_id', $id)->first();
        $insumo_ingreso = DetalleIngreso::join('insumo.ingreso as ing','insumo.detalle_ingreso.deting_ing_id','=','ing.ing_id')->where('ing_planta_id', '=', $planta->id_planta)->orderby('deting_ins_id', 'ASC')->get();
        $ufvs = Ufv::get();
        \Excel::create('Reporte_General_Ingreso', function($excel) use ($insumo_ingreso, $planta) {
             $excel->sheet('Excel sheet', function($sheet) use ($insumo_ingreso, $planta) {
                $sheet->loadView('reportes_excel.reporte_ingreso_general', array('insumo_ingreso'=>$insumo_ingreso,'planta'=>$planta));
            });
        })->export('xlsx');
    }

    public function RptSolicitudGeneralExcel()
    {
        //dd("EXCEL SOLICITUD GENERAL");
        $id_usuario = Auth::user()->usr_id;
        $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
            ->where('usr_id', $id_usuario)->first();
        $per = Collect($usr);
        $id = Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
            ->where('usr_id', $id)->first();
        //$insumo_ingreso = DetalleIngreso::join('insumo.ingreso as ing','insumo.detalle_ingreso.deting_ing_id','=','ing.ing_id')->where('ing_planta_id', '=', $planta->id_planta)->orderby('deting_ins_id', 'ASC')->get();
        $orprod = OrdenProduccion::where('orprod_planta_id',$planta->id_planta)->get();
        $detorprod = DetalleOrdenProduccion::join('insumo.orden_produccion as orp','insumo.detalle_orden_produccion.detorprod_orprod_id','=','orp.orprod_id')->where('orprod_planta_id', '=', $planta->id_planta)->orderby('detorprod_ins_id', 'ASC')->get();
        $ufvs = Ufv::get();
        \Excel::create('Reporte_General_Ingreso', function($excel) use ($detorprod, $planta) {
             $excel->sheet('Excel sheet', function($sheet) use ($detorprod, $planta) {
                $sheet->loadView('reportes_excel.reporte_solicitud_general', array('detorprod'=>$detorprod,'planta'=>$planta));
            });
        })->export('xlsx');
    }

    public function RptSalidasGeneralExcel()
    {
        $id_usuario = Auth::user()->usr_id;
        $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
            ->where('usr_id', $id_usuario)->first();
        $per = Collect($usr);
        $id = Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
            ->where('usr_id', $id)->first();
        $orprod = OrdenProduccion::where('orprod_planta_id',$planta->id_planta)->get();
        $detorprod = DetalleOrdenProduccion::join('insumo.orden_produccion as orp','insumo.detalle_orden_produccion.detorprod_orprod_id','=','orp.orprod_id')->where('orprod_planta_id', '=', $planta->id_planta)->where('orprod_estado_orp','D')->orderby('detorprod_ins_id', 'ASC')->get();
        $ufvs = Ufv::get();
        \Excel::create('Reporte_General_Salida', function($excel) use ($detorprod, $planta) {
             $excel->sheet('Excel sheet', function($sheet) use ($detorprod, $planta) {
                $sheet->loadView('reportes_excel.reporte_salida_general', array('detorprod'=>$detorprod,'planta'=>$planta));
            });
        })->export('xlsx');
    }
    /***********************************************REPORTES PRODUCTO TERMINADO*****************************************************************/
    public function reporteMesExcelInventarioAlmacenPt($mes,$anio)
    {
        //dd($mes.'-'.$anio);
        $id_usuario = Auth::user()->usr_id;
        $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
            ->where('usr_id', $id_usuario)->first();
        $per = Collect($usr);
        $id = Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
            ->where('usr_id', $id)->first();
        $anio1 = $anio;
        $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
        $fechainicial = $anio1 . "-" . $mes . "-01";
        $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
        $fecha_inventario = 'Del: '.$fechainicial.' Al: '.$fechafinal;
        $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                        ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                        ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                        ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                        ->where('spth_registrado', '>=', $fechainicial)->where('spth_registrado', '<=', $fechafinal)
                        ->where('spth_planta_id',$planta->id_planta)
                        ->get();  
        $ufvs = Ufv::get();
        \Excel::create('Reporte_General_Salida', function($excel) use ($stockptMes, $planta, $fecha_inventario) {
             $excel->sheet('Excel sheet', function($sheet) use ($stockptMes, $planta, $fecha_inventario) {
                $sheet->loadView('reportes_excel.reporte_inventario_mes_producto_terminado', array('stockptMes'=>$stockptMes,'planta'=>$planta,'fecha_inventario'=>$fecha_inventario));
            });
        })->export('xlsx');
    }
    public function reporteDiaExcelInventarioAlmacenPt($dia,$mes,$anio)
    {
        $id_usuario = Auth::user()->usr_id;
        $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
            ->where('usr_id', $id_usuario)->first();
        $per = Collect($usr);
        $id = Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
            ->where('usr_id', $id)->first();
        $dia = $anio . "-" . $mes . "-" . $dia;
        $fecha_inventario = $dia;
        $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                        ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                        ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                        ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                        //->where('spth_registrado', '>=', $dia)->where('spth_registrado', '<=', $dia)
                        ->where(DB::raw('cast(stock_producto_terminado_historial.spth_registrado as date)'),'=',$dia)
                        ->where('spth_planta_id',$planta->id_planta)
                        ->get();  
        $ufvs = Ufv::get();
        \Excel::create('Reporte_General_Salida', function($excel) use ($stockptMes, $planta, $fecha_inventario) {
             $excel->sheet('Excel sheet', function($sheet) use ($stockptMes, $planta, $fecha_inventario) {
                $sheet->loadView('reportes_excel.reporte_inventario_mes_producto_terminado', array('stockptMes'=>$stockptMes,'planta'=>$planta,'fecha_inventario'=>$fecha_inventario));
            });
        })->export('xlsx');
    }
    public function reporteRangoExcelInventarioAlmacenPt($dia_inicio, $mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin)
    {
        $id_usuario = Auth::user()->usr_id;
        $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
            ->where('usr_id', $id_usuario)->first();
        $per = Collect($usr);
        $id = Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
            ->where('usr_id', $id)->first();
        $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
        $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
        $fecha_inventario = 'Del: '.$fechainicial.' Hasta: '.$fechafinal;
        $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                        ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                        ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                        ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                        ->where(DB::raw('cast(stock_producto_terminado_historial.spth_registrado as date)'), '>=', $fechainicial)
                        ->where(DB::raw('cast(stock_producto_terminado_historial.spth_registrado as date)'), '<=', $fechafinal)
                        ->where('spth_planta_id',$planta->id_planta)
                        ->get();
        $ufvs = Ufv::get();
        \Excel::create('Reporte_General_Salida', function($excel) use ($stockptMes, $planta, $fecha_inventario) {
             $excel->sheet('Excel sheet', function($sheet) use ($stockptMes, $planta, $fecha_inventario) {
                $sheet->loadView('reportes_excel.reporte_inventario_mes_producto_terminado', array('stockptMes'=>$stockptMes,'planta'=>$planta,'fecha_inventario'=>$fecha_inventario));
            });
        })->export('xlsx');
    }
    public function reporteIngresoMesExcelGeneralPt($mes,$anio,$planta)
    {
        if($planta == 0){
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoOrp, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoOrp, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_general_mes_producto_terminado', array('ingresoOrp'=>$ingresoOrp,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoOrp, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoOrp, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_general_mes_producto_terminado', array('ingresoOrp'=>$ingresoOrp,'planta'=>$planta));
                });
            })->export('xlsx');
        }        
    }
    public function reporteIngresoDiaExcelGeneralPt($dia,$mes,$anio,$planta)
    {
        if($planta == 0){
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoOrp, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoOrp, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_general_mes_producto_terminado', array('ingresoOrp'=>$ingresoOrp,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoOrp, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoOrp, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_general_mes_producto_terminado', array('ingresoOrp'=>$ingresoOrp,'planta'=>$planta));
                });
            })->export('xlsx');
        } 
    }
    public function imprimirExcelIngresoRangoAlmacenPt($dia_inicio, $mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin, $planta)
    {
        if($planta == 0){
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoOrp, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoOrp, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_general_mes_producto_terminado', array('ingresoOrp'=>$ingresoOrp,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoOrp, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoOrp, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_general_mes_producto_terminado', array('ingresoOrp'=>$ingresoOrp,'planta'=>$planta));
                });
            })->export('xlsx');
        } 
    }
    public function imprimirExcelIngresosCanasMesAlmacenPt($mes,$anio,$planta)
    {
        if($planta == 0){
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
                //->where('iac_origen',$planta)
                ->where('iac_estado_baja', 'A')
                ->orderBy('iac_id', 'desc')->get();
                //dd($ingresoCanastillos);
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoCanastillos, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoCanastillos, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_canastillo_general_mes_producto_terminado', array('ingresoCanastillos'=>$ingresoCanastillos,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoCanastillos, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoCanastillos, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_canastillo_general_mes_producto_terminado', array('ingresoCanastillos'=>$ingresoCanastillos,'planta'=>$planta));
                });
            })->export('xlsx');
        } 
    }
    public function imprimirExcelIngresosCanasDiaAlmacenPt($dia,$mes,$anio,$planta)
    {
        if($planta == 0){
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoCanastillos, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoCanastillos, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_canastillo_general_mes_producto_terminado', array('ingresoCanastillos'=>$ingresoCanastillos,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoCanastillos, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoCanastillos, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_canastillo_general_mes_producto_terminado', array('ingresoCanastillos'=>$ingresoCanastillos,'planta'=>$planta));
                });
            })->export('xlsx');
        }
    }
    public function imprimirExcelIngresosCanasRangoAlmacenPt($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin,$planta)
    {
        if($planta == 0){
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoCanastillos, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoCanastillos, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_canastillo_general_mes_producto_terminado', array('ingresoCanastillos'=>$ingresoCanastillos,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($ingresoCanastillos, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($ingresoCanastillos, $planta) {
                    $sheet->loadView('reportes_excel.reporte_ingreso_canastillo_general_mes_producto_terminado', array('ingresoCanastillos'=>$ingresoCanastillos,'planta'=>$planta));
                });
            })->export('xlsx');
        }
    }
    public function imprimirExcelDespachosOrpMesGeneralPt($mes,$anio,$planta)
    {
        if ($planta == 0) {
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_orp_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_orp_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        }            
    }
    public function imprimirExcelDespachosOrpDiaGeneralPt($dia,$mes,$anio,$planta)
    {
         if ($planta == 0) {
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_orp_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_orp_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        }   
    }
    public function imprimirExcelDespachosOrpRangoGeneralPt($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin,$planta)
    {
         if ($planta == 0) {
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_orp_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_orp_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        }  
    }
    public function imprimirExcelDespachosPtMesGeneralPt($mes,$anio,$planta)
    {
        if ($planta == 0) {
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
                ->orderBy('dao_id','desc')
                ->get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_pt_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_pt_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        } 
    }
    public function imprimirExcelDespachosPtDiaGeneralPt($dia,$mes,$anio,$planta)
    {
        if ($planta == 0) {
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_pt_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_pt_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        } 
    }
    public function imprimirExcelDespachosPtRangoGeneralPt($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin,$planta)
    {
        if ($planta == 0) {
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_pt_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta; 
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($despachoORP, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($despachoORP, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_pt_general_producto_terminado', array('despachoORP'=>$despachoORP,'planta'=>$planta));
                });
            })->export('xlsx');
        } 
    }
    public function imprimirExcelDespachosCanastilloMesGeneralPt($mes,$anio,$planta)
    {
        if($planta == 0){
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
                //->where('iac_origen',$planta1)
                ->where('iac_fecha_salida', '>=', $fechainicial)->where('iac_fecha_salida', '<=', $fechafinal)
                ->orderBy('iac_id', 'desc')
                ->get();
            //dd($datosCanastillas);
            \Excel::create('Reporte_General_Salida', function($excel) use ($datosCanastillas, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($datosCanastillas, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_canastillo_general_producto_terminado', array('datosCanastillas'=>$datosCanastillas,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta;
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($datosCanastillas, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($datosCanastillas, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_canastillo_general_producto_terminado', array('datosCanastillas'=>$datosCanastillas,'planta'=>$planta));
                });
            })->export('xlsx');
        }            
    }
    public function imprimirExcelDespachosCanastilloDiaGeneralPt($dia,$mes,$anio,$planta)
    {
        if($planta == 0){
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            //dd($datosCanastillas);
            \Excel::create('Reporte_General_Salida', function($excel) use ($datosCanastillas, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($datosCanastillas, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_canastillo_general_producto_terminado', array('datosCanastillas'=>$datosCanastillas,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta;
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($datosCanastillas, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($datosCanastillas, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_canastillo_general_producto_terminado', array('datosCanastillas'=>$datosCanastillas,'planta'=>$planta));
                });
            })->export('xlsx');
        }  
    }
    public function imprimirExcelDespachosCanastilloRangoGeneralPt($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin,$planta)
    {
        if($planta == 0){
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            //dd($datosCanastillas);
            \Excel::create('Reporte_General_Salida', function($excel) use ($datosCanastillas, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($datosCanastillas, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_canastillo_general_producto_terminado', array('datosCanastillas'=>$datosCanastillas,'planta'=>$planta));
                });
            })->export('xlsx');
        }else{
            $planta1 = $planta;
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
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
            \Excel::create('Reporte_General_Salida', function($excel) use ($datosCanastillas, $planta) {
                 $excel->sheet('Excel sheet', function($sheet) use ($datosCanastillas, $planta) {
                    $sheet->loadView('reportes_excel.reporte_despacho_canastillo_general_producto_terminado', array('datosCanastillas'=>$datosCanastillas,'planta'=>$planta));
                });
            })->export('xlsx');
        } 
    }
    public function imprimirExcelInventarioGralMesAlmacenPt($mes,$anio,$planta)
    {
        if ($planta == 0) {
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $fecha_inventario = 'Del: '.$fechainicial.' Al: '.$fechafinal;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where('spth_registrado', '>=', $fechainicial)->where('spth_registrado', '<=', $fechafinal)
                            ->get();  
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($stockptMes, $planta, $fecha_inventario) {
                 $excel->sheet('Excel sheet', function($sheet) use ($stockptMes, $planta, $fecha_inventario) {
                    $sheet->loadView('reportes_excel.reporte_inventario_gral_mes_producto_terminado', array('stockptMes'=>$stockptMes,'planta'=>$planta,'fecha_inventario'=>$fecha_inventario));
                });
            })->export('xlsx');    
        }else{
            $planta1 = $planta;
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
            $anio1 = $anio;
            $diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
            $fechainicial = $anio1 . "-" . $mes . "-01";
            $fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
            $fecha_inventario = 'Del: '.$fechainicial.' Al: '.$fechafinal;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where('spth_registrado', '>=', $fechainicial)->where('spth_registrado', '<=', $fechafinal)
                            ->where('spth_planta_id',$planta1)
                            ->get();  
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($stockptMes, $planta, $fecha_inventario) {
                 $excel->sheet('Excel sheet', function($sheet) use ($stockptMes, $planta, $fecha_inventario) {
                    $sheet->loadView('reportes_excel.reporte_inventario_gral_mes_producto_terminado', array('stockptMes'=>$stockptMes,'planta'=>$planta,'fecha_inventario'=>$fecha_inventario));
                });
            })->export('xlsx');
        }        
    }
    public function imprimirExcelInventarioGralDiaAlmacenPt($dia,$mes,$anio,$planta)
    {
        if ($planta == 0) {
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
            $dia = $anio . "-" . $mes . "-" . $dia;
            $fecha_inventario = $dia;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where(DB::raw('cast(spth_registrado as date)'),'=',$dia)
                            ->get();  
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($stockptMes, $planta, $fecha_inventario) {
                 $excel->sheet('Excel sheet', function($sheet) use ($stockptMes, $planta, $fecha_inventario) {
                    $sheet->loadView('reportes_excel.reporte_inventario_gral_mes_producto_terminado', array('stockptMes'=>$stockptMes,'planta'=>$planta,'fecha_inventario'=>$fecha_inventario));
                });
            })->export('xlsx');    
        }else{
            $planta1 = $planta;
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
            $dia = $anio . "-" . $mes . "-" . $dia;
            $fecha_inventario = $dia;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where(DB::raw('cast(spth_registrado as date)'),'=',$dia)
                            ->where('spth_planta_id',$planta1)
                            ->get();  
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($stockptMes, $planta, $fecha_inventario) {
                 $excel->sheet('Excel sheet', function($sheet) use ($stockptMes, $planta, $fecha_inventario) {
                    $sheet->loadView('reportes_excel.reporte_inventario_gral_mes_producto_terminado', array('stockptMes'=>$stockptMes,'planta'=>$planta,'fecha_inventario'=>$fecha_inventario));
                });
            })->export('xlsx');
        }  
    }
    public function imprimirExcelInventarioGralRangoAlmacenPt($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin,$planta)
    {
        if ($planta == 0) {
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $fecha_inventario = $fechainicial;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where(DB::raw('cast(spth_registrado as date)'), '>=', $fechainicial)
                            ->where(DB::raw('cast(spth_registrado as date)'), '<=', $fechafinal)
                            ->get();  
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($stockptMes, $planta, $fecha_inventario) {
                 $excel->sheet('Excel sheet', function($sheet) use ($stockptMes, $planta, $fecha_inventario) {
                    $sheet->loadView('reportes_excel.reporte_inventario_gral_mes_producto_terminado', array('stockptMes'=>$stockptMes,'planta'=>$planta,'fecha_inventario'=>$fecha_inventario));
                });
            })->export('xlsx');    
        }else{
            $planta1 = $planta;
            $id_usuario = Auth::user()->usr_id;
            $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
                ->where('usr_id', $id_usuario)->first();
            $per = Collect($usr);
            $id = Auth::user()->usr_id;
            $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                ->where('usr_id', $id)->first();
            $fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
            $fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
            $fecha_inventario = $fechafinal;
            $stockptMes = DB::table('producto_terminado.stock_producto_terminado_historial')
                            ->join('insumo.receta as rece','producto_terminado.stock_producto_terminado_historial.spth_rece_id','=','rece.rece_id')
                            ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_planta as pl','stock_producto_terminado_historial.spth_planta_id','=','pl.id_planta')
                            ->where(DB::raw('cast(spth_registrado as date)'), '>=', $fechainicial)
                            ->where(DB::raw('cast(spth_registrado as date)'), '<=', $fechafinal)
                            ->where('spth_planta_id',$planta1)
                            ->get();  
            $ufvs = Ufv::get();
            \Excel::create('Reporte_General_Salida', function($excel) use ($stockptMes, $planta, $fecha_inventario) {
                 $excel->sheet('Excel sheet', function($sheet) use ($stockptMes, $planta, $fecha_inventario) {
                    $sheet->loadView('reportes_excel.reporte_inventario_gral_mes_producto_terminado', array('stockptMes'=>$stockptMes,'planta'=>$planta,'fecha_inventario'=>$fecha_inventario));
                });
            })->export('xlsx');
        }  
    }
}
