<?php

namespace siga\Http\Controllers\comercial;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Http\Modelo\comercial\PuntoVenta;
use siga\Http\Modelo\comercial\TipoPv;
use siga\Modelo\admin\Usuario;
use siga\Http\Modelo\admin\Planta;
use DB;
use Auth;
class PuntoVentaController extends Controller
{
    public function index()
    {
    	$puntos_ventas = PuntoVenta::join('comercial.departamento_comercial as depto','comercial.punto_venta_comercial.pv_depto_id','=','depto.depto_id')
        ->join('comercial.tipo_pv_comercial as tipopv','comercial.punto_venta_comercial.pv_tipopv_id','=','tipopv.tipopv_id')
    								->where('pv_estado','A')->get();
    	return view('backend.administracion.comercial.punto_venta.index', compact('puntos_ventas'));
    }
    public function nuevoPuntoVenta()
    {
    	$tipo_pv = TipoPv::where('tipopv_estado','A')->get();
    	$departamentos = DB::table('comercial.departamento_comercial')->get();
    	$usuarios = Usuario::join('public._bp_personas as prs','public._bp_usuarios.usr_prs_id','=','prs.prs_id')->get();
    	return view('backend.administracion.comercial.punto_venta.nuevoFormPuntoVenta', compact('tipo_pv','usuarios','departamentos'));
    }
    public function registrarNuevoPuntoVenta(Request $request)
    {   
        $planta = Planta::create([
            'nombre_planta'         => $request['nombre_pv'],
            'tipo'                  => 2
        ]);
    	$punto_venta = PuntoVenta::create([
    		'pv_nombre' 			=> $request['nombre_pv'],
    		'pv_direccion' 			=> $request['direccion_pv'],
    		'pv_descripcion'		=> $request['descripcion_pv'],
    		'pv_telefono'			=> $request['telefono_pv'],
    		'pv_usr_responsable'	=> $request['responsable_pv'],
    		'pv_tipopv_id'			=> $request['tipo_pv'],
    		'pv_codigo'				=> '',
    		'pv_depto_id'			=> $request['departamento_pv'],
    		'pv_actividad_economica'=> $request['actividad_economica_pv'],
    		'pv_fecha_inicio'		=> date('Y-m-d',strtotime($request['fecha_inicio_pv'])),
    		'pv_fecha_fin'			=> date('Y-m-d',strtotime($request['fecha_fin_pv'])),
    		'pv_usr_id'				=> Auth::user()->usr_id,
            'pv_id_planta'          => $planta->id_planta
    	]);
        $punto_venta->pv_codigo = 'SUC-'.$punto_venta->pv_id;
        $punto_venta->save();
    	return redirect('PuntoVentaComercial')->with('success','Registro creado satisfactoriamente');
    }
}
