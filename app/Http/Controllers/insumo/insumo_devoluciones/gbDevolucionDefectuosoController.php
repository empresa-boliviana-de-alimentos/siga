<?php

namespace siga\Http\Controllers\insumo\insumo_devoluciones;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_devolucion\Devolucion;
use siga\Modelo\insumo\insumo_devolucion\DetalleDevolucion;
use siga\Modelo\admin\Usuario;
use Yajra\Datatables\Datatables;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion;
use siga\Modelo\insumo\insumo_registros\Insumo;
use Auth;
use DB;
use PDF;
use TCPDF;

class gbDevolucionDefectuosoController extends Controller
{
    public function index()
    {
    	return view('backend.administracion.insumo.insumo_devolucion.devolucion_defectuoso.index');
    }
   	
   	public function create()
    {
    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $soldev = Devolucion::join('insumo.orden_produccion as orp','insumo.devolucion.devo_nro_orden','=','orp.orprod_id')
                            ->join('insumo.receta as rece','orp.orprod_rece_id','=','rece.rece_id')
                            ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                            ->join('public._bp_usuarios as usr','insumo.devolucion.devo_usr_id','=','usr_id')
                            ->join('public._bp_personas as per','usr.usr_prs_id','=','prs_id')
                            ->where('devo_planta_id','=',$planta->id_planta)
                            ->where('devo_tipodevo_id',2)
            				->get();
        return Datatables::of($soldev)->addColumn('acciones', function ($soldev) {
            return '<a href="BoletaDevolucion/' . $soldev->devo_id . '" class="btn btn-primary"><span class="fa fa-file-pdf-o"></span> VER</a>';
        })
        ->addColumn('nombreReceta', function ($nombreReceta) {
            return $nombreReceta->rece_nombre.' '.$nombreReceta->sab_nombre.' '.$nombreReceta->rece_presentacion;
        })
        ->addColumn('nombreSol', function ($nombreSol) {
            return $nombreSol->prs_nombres.' '.$nombreSol->prs_materno.' '.$nombreSol->psr_materno;
        })
            ->editColumn('id', 'ID: {{$devo_id}}')
            ->make(true);
    }

    public function formDevolucionDefec()
    {
    	$ordenes_produccion = OrdenProduccion::where('orprod_nro_salida','<>',null)->get();
        $listarInsumo = Insumo::where('ins_estado','A')->get();
    	return view('backend.administracion.insumo.insumo_devolucion.devolucion_defectuoso.partials.formCreateDevolucionDefec',compact('ordenes_produccion','listarInsumo'));
    }

    public function registroDevolucionDefectuosa(Request $request)
    {
    	$ins_id = $request['id_ins'];
        $cantidad_devo = $request['cantidad_devo'];
        $obs_devo = $request['obs_devo'];
        //dd($obs_devo);
        for ($i=0; $i <sizeof($ins_id) ; $i++) { 
            if ($cantidad_devo[$i] != null) {
                $ins_datos[] = array("id_insumo"=>$ins_id[$i], "cantidad"=>$cantidad_devo[$i], "obs_devo"=>$obs_devo[$i]);
            }                 
        }
        //dd($ins_datos);
        //$id_receta = $request['id_receta'];
        //dd($id_receta);
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();   
        $num = Devolucion::join('public._bp_planta as plant', 'insumo.devolucion.devo_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(devo_nro_dev) as nro_op'))->where('plant.id_planta', $planta->id_planta)->first();
        $cont=$num['nro_op'];
        $nop = $cont + 1;
        $devo = Devolucion::create([
            'devo_tipodevo_id'  => 2,
            'devo_nro_dev'	=> $nop,
            'devo_nro_orden'   => $request['nro_de_orden'],
            'devo_planta_id'  => $planta->id_planta,
            'devo_usr_id'     => Auth::user()->usr_id,
            'devo_obs'    => $request['observacion'],
        ]);
        //dd($dato_calculo);
        //$detalle_receta = DetalleReceta::where('detrece_rece_id',$id_receta)->get();
        foreach ($ins_datos as $detrece) {
            DetalleDevolucion::create([
                'detdevo_devo_id'   => $devo->devo_id,
                'detdevo_ins_id'    => $detrece['id_insumo'],
                'detdevo_cantidad'  => $detrece['cantidad'],
            ]);
        }
        
        return redirect('DevolucionDefectuoso')->with('success','Registro creado satisfactoriamente');
    }

    public function boletaDevolucion($id_devolucion)
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
            $pdf->Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            PDF::SetXY(120, 204);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('helvetica', '', 9);
        $pdf->AddPage('Carta');
        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_user =  Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id_user)->first();
        $reg = Devolucion::join('public._bp_planta as planta','insumo.devolucion.devo_planta_id','=','planta.id_planta')
                              ->join('public._bp_usuarios as usu','insumo.devolucion.devo_usr_id','=','usu.usr_id')
                              ->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
                              ->where('devo_id',$id_devolucion)
            ->first();
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="img/logopeqe.png" width="160" height="65"></th>
                             <th  width="370"><h3 align="center"><br>ALMACEN '.$planta['nombre_planta'].'<br>NOTA DE DEVOLUCION DEFECTUOSO</h3></th>
                             <th  width="150"><h3 align="center"><br>Fecha: '.date('Y-m-d',strtotime($reg['devo_registrado'])).'<br>Codigo No: '.$reg['devo_nro_dev'].'/'.date('Y',strtotime($reg['devo_registrado'])).'</h3></th>
                        </tr>
                    </table>
                    <br><br><br>
                        <label><strong>Solicitante:</strong> '.$reg['prs_nombres'].' '.$reg['prs_paterno'].' '.$reg['prs_materno'].'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <br><br>
                        <label><strong>Planta:</strong> '.$reg['nombre_planta'].'</label>
                        <br><br>
                        <label><strong>Nro de Orden:</strong> '.$reg['devo_nro_orden'].'</label>
                        <h3 align="center"></h3>
                    <br>

                    <table border="1" cellspacing="0">
                     
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB" width="270"><strong>INSUMO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="170"><strong>UNIDAD</strong></th>
                            <th align="center" bgcolor="#3498DB" width="170"><strong>Cantidad</strong></th>                            
                        </tr> ';
                        $detorp = DetalleDevolucion::join('insumo.insumo as ins','insumo.detalle_devolucion.detdevo_ins_id','=','ins.ins_id')->join('insumo.unidad_medida as umed','ins.ins_id_uni','=','umed.umed_id')->where('detdevo_devo_id',$id_devolucion)->get();
                        $nro = 1;
                        foreach ($detorp as $det) {                        
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">'.$nro.'</td>
                                    <td align="center">'.$det['ins_desc'].'</td>
                                    <td align="center">'.$det['umed_nombre'].'</td>
                                    <td align="center">'.$det['detdevo_cantidad'].'</td>
                                  </tr>';  
                            $nro = $nro + 1;
                        }
                     $html = $html . '</table>

                     <br><br>
                            <table border="1">
                                <tr>
                                    <th height="50"><strong> Observaciones:</strong> '.$reg['devo_obs'].'</th>
                                </tr>
                            </table>
                     <br><br><br><br><br><br>';
                      $html = $html . '
                                <table>
                            <tr>
                                <td align="left">Solicitado por: __________________________________</td>
                                
                                <td align="left">Autorizado por: __________________________________</td>
                            </tr>
                            <tr>
                                <td align="left">Firma</td>
                                
                                <td align="left">Firma</td>
                            </tr>
                            <tr>
                                <td align="left">Nombre:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</td>
                                <td align="left">Nombre:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________________</td>
                            </tr>
                            
                            
                            </table>
                            ';   
                    $htmltable = $html;
        $pdf->writeHTML($htmltable, true, 0, true, 0);          
        $pdf->lastPage();
        $pdf->Output('boletaSolMaquila-'.$reg['solmaq_id'].'.pdf', 'I');
    }
}
