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
}
