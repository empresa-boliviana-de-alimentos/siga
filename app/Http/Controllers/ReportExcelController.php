<?php

namespace siga\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use siga\Modelo\insumo\insumo_registros\Ufv;
use siga\Modelo\insumo\insumo_registros\Ingreso;
use siga\Modelo\insumo\insumo_registros\DetalleIngreso;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion;
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
}
