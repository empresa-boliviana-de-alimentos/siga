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
                        ->where('ing_env_acop_id',$id_envio)
                        ->first();
        
        $detalle_ingreso = DetalleIngreso::join('insumo.insumo as ins','insumo.detalle_ingreso.deting_ins_id','=','ins.ins_id')
                        ->where('deting_ing_id',$reg->ing_id)
                        ->first();

        $code = $reg['ing_enumeracion'].'/'.date('Y',strtotime($reg['ing_registrado']));
        
        $view = \View::make('reportes.ingreso_materia_prima', compact('username','date','title','storage','receta','reg','detalle_ingreso','per','planta'));

        $html_content = $view->render();
        // return $html_content;
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html_content);
        return $pdf->inline();

    }
    
}
