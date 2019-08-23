<?php

namespace siga\Http\Controllers\insumo\insumo_registros;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_registros\Proveedor;
use siga\Modelo\insumo\insumo_registros\EvaluacionProveedor;
use siga\Modelo\admin\Usuario;//NEW
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Auth;
use PDF;
use TCPDF;

class gbProveedorController extends Controller
{
    public function index()
    {
    	return view('backend.administracion.insumo.insumo_registro.proveedores.index');
    }

     public function create()
    {
        $prov = Proveedor::getListar();
        return Datatables::of($prov)->addColumn('acciones', function ($prov) {
            return '<button value="' . $prov->prov_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarProv(this);" data-toggle="modal" data-target="#myUpdateProv"><i class="fa fa-pencil-square"></i></button><button value="' . $prov->prov_id . '" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
        })->addColumn('evaluacion_prov', function ($eval_prov) {
            return '<button value="' . $eval_prov->prov_id . '" class="btn-warning btn-md" onClick="FormEval(this);" data-toggle="modal" data-target="#formEvaluacion"><i class="fa fa-file"></i></button><button value="' . $eval_prov->prov_id . '" class="btn-danger btn-md" data-toggle="modal" data-target="#myListEvaluacion" onClick="MostrarEvaluacion(this);"><i class="fa fa-list-alt"></i></button>';
        })
            ->editColumn('id', 'ID: {{$prov_id}}')
            ->make(true);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
                'nombre_proveedor' => 'required',
                'nombre_responsable' => 'required',
        ]);
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                          ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        Proveedor::create([
            'prov_nom'        => $request['nombre_proveedor'],
            'prov_dir'        => $request['prov_dir'],
            'prov_tel'        => $request['prov_tel'],
            'prov_nom_res'    => $request['nombre_responsable'],
            'prov_ap_res'     => $request['prov_ap_res'],
            'prov_am_res'     => $request['prov_am_res'],
            'prov_tel_res'    => $request['prov_tel_res'],
            'prov_obs'        => $request['prov_obs'],
            'prov_estado'     => 'A',
            'prov_usr_id'     => Auth::user()->usr_id,
            'prov_id_planta'  => $planta->id_planta,
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function edit($id)
    {
        $prov = Proveedor::setBuscar($id);
        return response()->json($prov);
    }

    public function update(Request $request, $id)
    {
        $prov = Proveedor::setBuscar($id);
        $prov->fill($request->all());
        $prov->save();
        return response()->json($prov->toArray());
    }

    public function destroy($id)
    {
        $prov = Proveedor::getDestroy($id);
        return response()->json($prov);

    }

    public function storeEvalProv(Request $request)
    {
        EvaluacionProveedor::create([
            'eval_prov_id' => $request['eval_prov_id'],
            'eval_evaluacion' => 1,
            'eval_costo_apro'=> $request['eval_costo_apro'],
            'eval_fiabilidad'=> $request['eval_fiabilidad'],
            'eval_imagen'=> $request['eval_imagen'],
            'eval_calidad'=> $request['eval_calidad'],
            'eval_cumplimientos_plazos'=> $request['eval_cumplimientos_plazos'],
            'eval_condiciones_pago'=>$request['eval_condiciones_pago'],
            'eval_capacidad_cooperacion'=>$request['eval_capacidad_cooperacion'],
            'eval_flexibilidad'=>$request['eval_flexibilidad'],
        ]);
        return response()->json(['Mensaje'=>'Se rregistro correctamente']);
    }

    public function listarEvaluaciones($id_proveedor)
    {
        $eval_prov = EvaluacionProveedor::join('insumo.proveedor as prov','insumo.evaluacion_proveedor.eval_prov_id','=','prov.prov_id')
                    ->where('prov_id','=',$id_proveedor)->get();
        return \Response::json($eval_prov);
    }

    public function exportarEvalucionProveedores()
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('EBA');
        $pdf->SetSubject('INSUMOS');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        PDF::SetXY(125, 199);
        $pdf->Cell(70, 6, utf8_decode('Responsable de Acopio - EBA'), 0, 1, 'C', 0);
        PDF::SetXY(120, 204);
        PDF::Cell(15, 6, utf8_decode('Nombre:'), 0, 0, 'C', 0);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once dirname(__FILE__) . '/lang/eng.php';
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('helvetica', '', 9);
        $pdf->AddPage('P', 'Carta');
        $id_usuario = Auth::user()->usr_id;
        $usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
            ->where('usr_id', $id_usuario)->first();
        $per = Collect($usr);
        $id = Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
            ->where('usr_id', $id)->first();
        $evaluacion = EvaluacionProveedor::join('insumo.proveedor as prov','insumo.evaluacion_proveedor.eval_prov_id','=','prov.prov_id')->get();
        //dd($evaluacion);
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><br><br><img src="img/logopeqe.png" width="140" height="65"></th>
                             <th  width="525"><h3 align="center"><br>EVALUACIÓN PROVEEDORES<br>Fecha Emisión: ' . date('d/m/Y') . '<br></h3>
                             </th>
                        </tr>
                    </table>
                    <br><br>

                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="35">No.</th>
                            <th align="center" bgcolor="#3498DB" width="150">Proveedor</th>
                            <th align="center" bgcolor="#3498DB" width="60"><strong>Fecha</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>Total</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150"><strong>Puntos</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150"><strong>Porcentaje %</strong></th>
                        </tr>';
        $nro = 0;
        $cant = 0;

        foreach ($evaluacion as $eval) {
            $nro = $nro + 1;
            $total_puntaje = $eval->eval_costo_apro+$eval->eval_fiabilidad+$eval->eval_imagen+$eval->eval_calidad+$eval->eval_cumplimientos_plazos+$eval->eval_condiciones_pago+$eval->eval_capacidad_cooperacion+$eval->eval_flexibilidad;
            $total_puntos = $total_puntaje/100;
            $total_porcentaje = ($total_puntos/5)*100;
            $html = $html . '<tr>
                                <td align="center">'.$nro.'</td>
                                <td align="center">'.$eval->prov_nom.'</td>
                                <td align="center">'.date('d/m/Y',strtotime($eval->eval_registrado)).'</td>
                                <td align="center">'.$total_puntaje.'</td>
                                <td align="center">'.$total_puntos.'</td>
                                <th align="center">'.$total_porcentaje.'</th>';
            $html = $html . '</tr>';
        }

        $htmltable = $html . '</table>
                    <br><br><br><br><br><br><br><br><br><br><br><br>';
        $pdf->writeHTML($htmltable, true, 0, true, 0);
        $pdf->lastPage();
        $pdf->Output('Reporte_Kardex_Fisico_Insumo_Almacen.pdf', 'I');
    }
}
