<?php

namespace siga\Http\Controllers\estadisticas\acopio;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_almendra\Acopio;
use siga\Modelo\acopio\acopio_almendra\Proveedor;
use siga\Modelo\admin\Usuario;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;

class EstadisticaAlmendraController extends Controller
{
    public function estadisticaDia()
    {
    	
    	return view('backend.administracion.estadistica.indexAlmendra');
    }

    public function estadisticaFecha()
    {
    	$fecha = Input::get('fecha');
    	if (!$fecha) {
    		$now = new \DateTime();		
    		$fecha = $now->format('Y-m-d');
    	}
    	else{
    		$fecha = $fecha;
    	}    	
    	$compradores = Usuario::join('public._bp_usuarios_roles as roles','public._bp_usuarios.usr_id','roles.usrls_usr_id')
    						  ->select(DB::raw('count(*)'))->where('usrls_rls_id',2)	
    						  ->where('usr_linea_trabajo',1)
    						  ->where('usr_estado','A')
    						  ->first();
    	$proveedores = Proveedor::select(DB::raw('count(*)'))->where('prov_id_linea',1)->where('prov_estado','A')->first();    	
    	
    	$totales_acopio = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            // ->where('acopio.aco_fecha_reg','>=','2018-11-01')
                            // ->where('acopio.aco_fecha_reg','<=','2019-05-30')
                            ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->first();

        $totales_zonaA = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            // ->where('acopio.aco_fecha_reg','>=','2018-11-01')
                            // ->where('acopio.aco_fecha_reg','<=','2019-05-30')
                            ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->where('usr_zona_id',1)
                            ->first();
        $totales_zonaB = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            // ->where('acopio.aco_fecha_reg','>=','2018-11-01')
                            // ->where('acopio.aco_fecha_reg','<=','2019-05-30')
                            ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->where('usr_zona_id',2)
                            ->first();
        $totales_zonaC = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            // ->where('acopio.aco_fecha_reg','>=','2018-11-01')
                            // ->where('acopio.aco_fecha_reg','<=','2019-05-30')
                            ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->where('usr_zona_id',3)
                            ->first();

    	$total_compradores = $totales_acopio->total_comprador;
    	$total_proveedores = $totales_acopio->total_proveedor;
    	$total_cantidad_kilos = number_format($totales_acopio->total_cantidad_kilos,2,'.',',');
    	$total_monto = number_format($totales_acopio->total_costo_bs,2,'.',',');
    	if (is_null($totales_zonaA->total_cantidad_kilos) && is_null($totales_zonaA->total_costo_bs)) {
    		$total_cantidad_zonaA = 0;
    		$total_monto_zonaA = 0;
    	}else{
			$total_cantidad_zonaA = $totales_zonaA->total_cantidad_kilos;
			$total_monto_zonaA = $totales_zonaA->total_costo_bs;  
    	}
    	if (is_null($totales_zonaB->total_cantidad_kilos) && is_null($totales_zonaB->total_costo_bs)) {
    		$total_cantidad_zonaB = 0;
    		$total_monto_zonaB = 0;
    	}else{
    		$total_cantidad_zonaB = $totales_zonaB->total_cantidad_kilos;
    		$total_monto_zonaB = $totales_zonaB->total_costo_bs; 
    	}
    	if (is_null($totales_zonaC->total_cantidad_kilos) && is_null($totales_zonaC->total_costo_bs)) {
    		$total_cantidad_zonaC = 0;
    		$total_monto_zonaC = 0;
    	}else{
    		$total_cantidad_zonaC = $totales_zonaC->total_cantidad_kilos;
    		$total_monto_zonaC = $totales_zonaC->total_costo_bs;  
    	} 
    	
    	$array_datos = array('fecha'=>$fecha,'total_comprador'=>$total_compradores,'total_proveedor'=> $total_proveedores,'total_cantidad_kilos' => $total_cantidad_kilos,'total_costo_bs' => $total_monto,'cantidad_total_zonaA'=>$total_cantidad_zonaA,'cantidad_total_zonaB'=>$total_cantidad_zonaB,'cantidad_total_zonaC'=>$total_cantidad_zonaC,'monto_total_zonaA'=>$total_monto_zonaA,'monto_total_zonaB'=>$total_monto_zonaB,'monto_total_zonaC'=>$total_monto_zonaC);

    	return \Response::json($array_datos);
    }


    public function estadisticaMes()
    {
    	$fecha = Input::get('fecha');
    	$separador = explode("/",$fecha);

    	$mes = $separador[0] ;
		$anio = $separador[1];
	
		$diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio));
		$fechainicial = $anio. "-" . $mes . "-" . "01";
		$fechafinal =  $anio. "-" . $mes . "-" . $diafinal;
		  	
    	$compradores = Usuario::join('public._bp_usuarios_roles as roles','public._bp_usuarios.usr_id','roles.usrls_usr_id')
    						  ->select(DB::raw('count(*)'))->where('usrls_rls_id',2)	
    						  ->where('usr_linea_trabajo',1)
    						  ->where('usr_estado','A')
    						  ->first();
    	$proveedores = Proveedor::select(DB::raw('count(*)'))->where('prov_id_linea',1)->where('prov_estado','A')->first();    	
    	
    	$totales_acopio = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            ->where('acopio.aco_fecha_reg','>=',$fechainicial)
                            ->where('acopio.aco_fecha_reg','<=',$fechafinal)
                            // ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->first();

        $totales_zonaA = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            ->where('acopio.aco_fecha_reg','>=',$fechainicial)
                            ->where('acopio.aco_fecha_reg','<=',$fechafinal)
                            // ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->where('usr_zona_id',1)
                            ->first();
        $totales_zonaB = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            ->where('acopio.aco_fecha_reg','>=',$fechainicial)
                            ->where('acopio.aco_fecha_reg','<=',$fechafinal)
                            // ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->where('usr_zona_id',2)
                            ->first();
        $totales_zonaC = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            ->where('acopio.aco_fecha_reg','>=',$fechainicial)
                            ->where('acopio.aco_fecha_reg','<=',$fechafinal)
                            // ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->where('usr_zona_id',3)
                            ->first();

    	$total_compradores = $totales_acopio->total_comprador;
    	$total_proveedores = $totales_acopio->total_proveedor;
    	$total_cantidad_kilos = number_format($totales_acopio->total_cantidad_kilos,2,'.',',');
    	$total_monto = number_format($totales_acopio->total_costo_bs,2,'.',',');
    	if (is_null($totales_zonaA->total_cantidad_kilos) && is_null($totales_zonaA->total_costo_bs)) {
    		$total_cantidad_zonaA = 0;
    		$total_monto_zonaA = 0;
    	}else{
			$total_cantidad_zonaA = $totales_zonaA->total_cantidad_kilos;
			$total_monto_zonaA = $totales_zonaA->total_costo_bs;  
    	}
    	if (is_null($totales_zonaB->total_cantidad_kilos) && is_null($totales_zonaB->total_costo_bs)) {
    		$total_cantidad_zonaB = 0;
    		$total_monto_zonaB = 0;
    	}else{
    		$total_cantidad_zonaB = $totales_zonaB->total_cantidad_kilos;
    		$total_monto_zonaB = $totales_zonaB->total_costo_bs; 
    	}
    	if (is_null($totales_zonaC->total_cantidad_kilos) && is_null($totales_zonaC->total_costo_bs)) {
    		$total_cantidad_zonaC = 0;
    		$total_monto_zonaC = 0;
    	}else{
    		$total_cantidad_zonaC = $totales_zonaC->total_cantidad_kilos;
    		$total_monto_zonaC = $totales_zonaC->total_costo_bs;  
    	} 
    	
    	$array_datos = array('fecha'=>$fecha,'total_comprador'=>$total_compradores,'total_proveedor'=> $total_proveedores,'total_cantidad_kilos' => $total_cantidad_kilos,'total_costo_bs' => $total_monto,'cantidad_total_zonaA'=>$total_cantidad_zonaA,'cantidad_total_zonaB'=>$total_cantidad_zonaB,'cantidad_total_zonaC'=>$total_cantidad_zonaC,'monto_total_zonaA'=>$total_monto_zonaA,'monto_total_zonaB'=>$total_monto_zonaB,'monto_total_zonaC'=>$total_monto_zonaC);

    	return \Response::json($array_datos);
    }
    // ESTADISTICA POR ANIO
    public function estadisticaAnio()
    {
    	$fecha = Input::get('fecha');
		$anio = $fecha;
		$fechainicial = $anio. "-" . "01" . "-" . "01";
		$fechafinal =  $anio. "-" . "12" . "-" . "31";
		  	
    	$compradores = Usuario::join('public._bp_usuarios_roles as roles','public._bp_usuarios.usr_id','roles.usrls_usr_id')
    						  ->select(DB::raw('count(*)'))->where('usrls_rls_id',2)	
    						  ->where('usr_linea_trabajo',1)
    						  ->where('usr_estado','A')
    						  ->first();
    	$proveedores = Proveedor::select(DB::raw('count(*)'))->where('prov_id_linea',1)->where('prov_estado','A')->first();    	
    	
    	$totales_acopio = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            ->where('acopio.aco_fecha_reg','>=',$fechainicial)
                            ->where('acopio.aco_fecha_reg','<=',$fechafinal)
                            // ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->first();

        $totales_zonaA = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            ->where('acopio.aco_fecha_reg','>=',$fechainicial)
                            ->where('acopio.aco_fecha_reg','<=',$fechafinal)
                            // ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->where('usr_zona_id',1)
                            ->first();
        $totales_zonaB = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            ->where('acopio.aco_fecha_reg','>=',$fechainicial)
                            ->where('acopio.aco_fecha_reg','<=',$fechafinal)
                            // ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->where('usr_zona_id',2)
                            ->first();
        $totales_zonaC = Acopio::select(DB::raw('COUNT(usr_id) as total_comprador, COUNT(prov_id) as total_proveedor,  SUM(aco_cantidad) as total_cantidad_kilos, SUM(aco_cos_total) as total_costo_bs'))
    						->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')
                            ->where('acopio.aco_fecha_reg','>=',$fechainicial)
                            ->where('acopio.aco_fecha_reg','<=',$fechafinal)
                            // ->where('acopio.aco_fecha_reg','like','%'.$fecha.'%')
                            ->where('usr_zona_id',3)
                            ->first();

    	$total_compradores = $totales_acopio->total_comprador;
    	$total_proveedores = $totales_acopio->total_proveedor;
    	$total_cantidad_kilos = number_format($totales_acopio->total_cantidad_kilos,2,'.',',');
    	$total_monto = number_format($totales_acopio->total_costo_bs,2,'.',',');
    	if (is_null($totales_zonaA->total_cantidad_kilos) && is_null($totales_zonaA->total_costo_bs)) {
    		$total_cantidad_zonaA = 0;
    		$total_monto_zonaA = 0;
    	}else{
			$total_cantidad_zonaA = $totales_zonaA->total_cantidad_kilos;
			$total_monto_zonaA = $totales_zonaA->total_costo_bs;  
    	}
    	if (is_null($totales_zonaB->total_cantidad_kilos) && is_null($totales_zonaB->total_costo_bs)) {
    		$total_cantidad_zonaB = 0;
    		$total_monto_zonaB = 0;
    	}else{
    		$total_cantidad_zonaB = $totales_zonaB->total_cantidad_kilos;
    		$total_monto_zonaB = $totales_zonaB->total_costo_bs; 
    	}
    	if (is_null($totales_zonaC->total_cantidad_kilos) && is_null($totales_zonaC->total_costo_bs)) {
    		$total_cantidad_zonaC = 0;
    		$total_monto_zonaC = 0;
    	}else{
    		$total_cantidad_zonaC = $totales_zonaC->total_cantidad_kilos;
    		$total_monto_zonaC = $totales_zonaC->total_costo_bs;  
    	} 
    	
    	$array_datos = array('fecha'=>$fecha,'total_comprador'=>$total_compradores,'total_proveedor'=> $total_proveedores,'total_cantidad_kilos' => $total_cantidad_kilos,'total_costo_bs' => $total_monto,'cantidad_total_zonaA'=>$total_cantidad_zonaA,'cantidad_total_zonaB'=>$total_cantidad_zonaB,'cantidad_total_zonaC'=>$total_cantidad_zonaC,'monto_total_zonaA'=>$total_monto_zonaA,'monto_total_zonaB'=>$total_monto_zonaB,'monto_total_zonaC'=>$total_monto_zonaC);

    	return \Response::json($array_datos);
    }
}
