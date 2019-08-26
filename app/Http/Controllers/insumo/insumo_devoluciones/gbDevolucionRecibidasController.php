<?php

namespace siga\Http\Controllers\insumo\insumo_devoluciones;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_devolucion\Devolucion_Recibidas;
use siga\Modelo\insumo\Stock_Almacen;
//NUEVOS
use siga\Modelo\insumo\insumo_devolucion\Devolucion;
use siga\Modelo\insumo\insumo_devolucion\DetalleDevolucion;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion;
use siga\Modelo\insumo\insumo_registros\Insumo;
use siga\Modelo\insumo\Stock;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\Usuario;
use siga\Modelo\insumo\insumo_registros\Ingreso;
use siga\Modelo\insumo\insumo_registros\DetalleIngreso;
use siga\Modelo\insumo\InsumoHistorial;  
use Auth;
use DB;
use PDF;
use TCPDF;

class gbDevolucionRecibidasController extends Controller
{
    public function index()
    {
    	return view('backend.administracion.insumo.insumo_devolucion.devolucion_recibidas.index');
    }

    public function create()
    {
        $devolucion = Devolucion::join('insumo.orden_produccion as orp','insumo.devolucion.devo_nro_orden','=','orp.orprod_id')
                                ->join('insumo.receta as rece','orp.orprod_rece_id','=','rece.rece_id')
                                ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                ->join('public._bp_usuarios as usr','insumo.devolucion.devo_usr_id','=','usr_id')
                                ->join('public._bp_personas as per','usr.usr_prs_id','=','prs_id')
                                ->where('devo_tipodevo_id',1)->get();
        return Datatables::of($devolucion)->addColumn('acciones', function ($devolucion) {
          if ($devolucion->devo_estado_dev == 'A') {
            return '<a href="FormMostrarDevoSobrante/' . $devolucion->devo_id . '" class="btn btn-success">Ver</a>';
          }elseif($devolucion->devo_estado_dev == 'B'){
            return '<a href="BoletaAprobDevoSobrante/'.$devolucion->devo_id.'" class="btn btn-primary"><span class="fa fa-file-o"></span></a>';
          }
            
        })
        ->addColumn('estadoDevoSobrante', function ($devolucion) {
            if ($devolucion->devo_estado_dev == 'A') {
              return 'PENDIENTE';
            }elseif($devolucion->devo_estado_dev == 'B'){
              return 'ACEPTADO';
            }elseif($devolucion->devo_estado_dev == 'C'){
              return 'RECAHZADO';
            }
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
    public function listarDevoDefectuosoCreate()
    {
        $devolucion_defec = Devolucion::join('insumo.orden_produccion as orp','insumo.devolucion.devo_nro_orden','=','orp.orprod_id')
                                ->join('insumo.receta as rece','orp.orprod_rece_id','=','rece.rece_id')
                                ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                ->join('public._bp_usuarios as usr','insumo.devolucion.devo_usr_id','=','usr_id')
                                ->join('public._bp_personas as per','usr.usr_prs_id','=','prs_id')
                                ->where('devo_tipodevo_id',2)->get();
        return Datatables::of($devolucion_defec)->addColumn('acciones', function ($devolucion_defec) {
          if ($devolucion_defec->devo_estado_dev == 'A') {
            return '<a href="FormMostrarDevoDefectuoso/' . $devolucion_defec->devo_id . '" class="btn btn-success">Ver</a>';
          }elseif($devolucion_defec->devo_estado_dev == 'B'){
            return '<a href="BoletaAprobDevoDefectuoso/'.$devolucion_defec->devo_id.'" class="btn btn-primary"><span class="fa fa-file-o"></span></a>';
          }
        })
        ->addColumn('estadoDevoDefectuoso', function ($devolucion_defec) {
            if ($devolucion_defec->devo_estado_dev == 'A') {
              return 'PENDIENTE';
            }elseif($devolucion_defec->devo_estado_dev == 'B'){
              return 'ACEPTADO';
            }elseif($devolucion_defec->devo_estado_dev == 'C'){
              return 'RECAHZADO';
            }
        })->addColumn('nombreReceta', function ($nombreReceta) {
            return $nombreReceta->rece_nombre.' '.$nombreReceta->sab_nombre.' '.$nombreReceta->rece_presentacion;
        })
        ->addColumn('nombreSol', function ($nombreSol) {
            return $nombreSol->prs_nombres.' '.$nombreSol->prs_materno.' '.$nombreSol->psr_materno;
        })
            ->editColumn('id', 'ID: {{$devo_id}}')
            ->make(true);
    }

    public function formMostrarDevoSobrante($id_devo)
    {
      //dd($id_devo);
        $sol_devo_sobrante = Devolucion::where('devo_id',$id_devo)->first();
        $detalle_devo_sobrante = DetalleDevolucion::join('insumo.insumo as ins','insumo.detalle_devolucion.detdevo_ins_id','=','ins.ins_id')->join('insumo.unidad_medida as umed','ins.ins_id_uni','=','umed_id')->where('detdevo_devo_id',$sol_devo_sobrante->devo_id)->get();
        return view('backend.administracion.insumo.insumo_devolucion.devolucion_recibidas.partials.formMostrarDevoSobrante',compact('sol_devo_sobrante','detalle_devo_sobrante'));
    }

    public function aprobacionDevolcuionSobrante(Request $request)
    {
      $ins_id = $request['id_insumo_devo'];
      $cantidad_ins = $request['cantidad_devo'];
      $costo_ins = $request['costo_devo'];
        //dd(sizeof($ins_id));
      for ($i=0; $i <sizeof($ins_id) ; $i++) { 
        if ($costo_ins[$i] != null) {
          $ins_datos[] = array("id_insumo"=>$ins_id[$i], "cantidad"=>$cantidad_ins[$i], "costo"=>$costo_ins[$i]);
        }                 
      }
      $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',Auth::user()->usr_id)->first();

      $numsal = Devolucion::join('public._bp_planta as plant', 'insumo.devolucion.devo_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(devo_nro_salida) as nro_op'))->where('plant.id_planta', $planta->id_planta)->first();
      $contsal=$numsal['nro_op'];
      $nopsal = $contsal + 1;
      $devolucion_sobrante = Devolucion::find($request['id_devo']);
      $devolucion_sobrante->devo_nro_salida = $nopsal;
      $devolucion_sobrante->devo_usr_aprob = Auth::user()->usr_id;
      $devolucion_sobrante->devo_obs_aprob = $request['obs_usr_aprob'];
      $devolucion_sobrante->devo_estado_dev = 'B';
      $devolucion_sobrante->save();
      //REVISAR A DETALLE
      $num = Ingreso::join('public._bp_planta as plant', 'insumo.ingreso.ing_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(ing_enumeracion) as nroing'))->where('plant.id_planta', $planta->id_planta)->first();
      $cont=$num['nroing'];
      $nid = $cont + 1;
      $ingreso_alm=Ingreso::create([
                'ing_remision'          => 1,
                'ing_id_tiping'         => 3,
                'ing_fecha_remision'    => "2019-08-16",
                'ing_usr_id'            => Auth::user()->usr_id,
                'ing_planta_id'         => $planta->id_planta,
                'ing_enumeracion'       => $nid,
            ]);
      $ingreso_id = $ingreso_alm->ing_id;
      $detdevo = DetalleDevolucion::where('detdevo_devo_id',$devolucion_sobrante->devo_id)->get();
      foreach ($ins_datos as $det) {
          $det_ingreso = DetalleIngreso::create([
                'deting_ins_id'     => $det['id_insumo'],
                'deting_prov_id'    => 1,
                'deting_cantidad'   => $det['cantidad'],
                'deting_costo'      => $det['costo'],
                'deting_fecha_venc' => "2019-08-16",
                'deting_ing_id'     => $ingreso_id,
            ]);
            Stock::create([
                'stock_ins_id' => $det['id_insumo'],
                'stock_deting_id' => $det_ingreso->deting_id,
                'stock_cantidad' => $det['cantidad'],
                'stock_costo' => $det['costo'],
                'stock_fecha_venc' => '2019-08-14',
                'stock_planta_id' => $devolucion_sobrante->devo_planta_id,
            ]);
            InsumoHistorial::create([
                'inshis_ins_id'     => $det['id_insumo'],
                'inshis_planta_id'  => $planta->id_planta,
                'inshis_tipo'       => 'Entrada',
                'inshis_deting_id'  => $det_ingreso->deting_id,
                'inshis_cantidad'   => $det['cantidad']
            ]);
      }
      //END REVISAR A DETALLE
      return view('backend.administracion.insumo.insumo_devolucion.devolucion_recibidas.index');
    }
    public function formMostrarDevoDefectuoso($id_devo)
    {
        $sol_devo_sobrante = Devolucion::where('devo_id',$id_devo)->first();
        $detalle_devo_sobrante = DetalleDevolucion::join('insumo.insumo as ins','insumo.detalle_devolucion.detdevo_ins_id','=','ins.ins_id')->join('insumo.unidad_medida as umed','ins.ins_id_uni','=','umed_id')->where('detdevo_devo_id',$sol_devo_sobrante->devo_id)->get();
        return view('backend.administracion.insumo.insumo_devolucion.devolucion_recibidas.partials.formMostrarDevoDefectuoso',compact('sol_devo_sobrante','detalle_devo_sobrante'));
    }

    public function aprobacionDevolcuionDefectuoso(Request $request)
    {
      //dd("ACEPTAR DEVOLUCION DEFECTUOSO");
      $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',Auth::user()->usr_id)->first();
      $numsal = Devolucion::join('public._bp_planta as plant', 'insumo.devolucion.devo_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(devo_nro_salida) as nro_op'))->where('plant.id_planta', $planta->id_planta)->first();
      $contsal=$numsal['nro_op'];
      $nopsal = $contsal + 1;
      $devolucion_sobrante = Devolucion::find($request['id_devo']);
      $devolucion_sobrante->devo_nro_salida = $nopsal;
      $devolucion_sobrante->devo_usr_aprob = Auth::user()->usr_id;
      $devolucion_sobrante->devo_obs_aprob = $request['obs_usr_aprob'];
      $devolucion_sobrante->devo_estado_dev = 'B';
      $devolucion_sobrante->save();      
      return view('backend.administracion.insumo.insumo_devolucion.devolucion_recibidas.index');
    }

    public function boletaAprobDevoSobrante($id_devo)
    {
      //dd("REPORTE APROBADO SOBRANTE");
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
                              ->where('devo_id',$id_devo)
            ->first();
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="img/logopeqe.png" width="160" height="65"></th>
                             <th  width="370"><h3 align="center"><br>ALMACEN '.$planta['nombre_planta'].'<br>NOTA DE ACEPTACIÓN DEVOLUCION SOBRANTE</h3></th>
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
                        $detorp = DetalleDevolucion::join('insumo.insumo as ins','insumo.detalle_devolucion.detdevo_ins_id','=','ins.ins_id')->join('insumo.unidad_medida as umed','ins.ins_id_uni','=','umed.umed_id')->where('detdevo_devo_id',$id_devo)->get();
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

    public function boletaAprobDevoDefectuoso($id_devo)
    {
      //dd("REPORTE APROBADO DEFECTUOSO");
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
                              ->where('devo_id',$id_devo)
            ->first();
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="img/logopeqe.png" width="160" height="65"></th>
                             <th  width="370"><h3 align="center"><br>ALMACEN '.$planta['nombre_planta'].'<br>NOTA DE ACEPTACIÓN DEVOLUCION DEFECTUOSO</h3></th>
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
                        $detorp = DetalleDevolucion::join('insumo.insumo as ins','insumo.detalle_devolucion.detdevo_ins_id','=','ins.ins_id')->join('insumo.unidad_medida as umed','ins.ins_id_uni','=','umed.umed_id')->where('detdevo_devo_id',$id_devo)->get();
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
    //ANTIGUO
    public function edit($id)
    {
        $devolucion = Devolucion::setBuscar($id);
        return response()->json($devolucion);
    }

    public function listDetalleRecibidas($id)
    { 
        //echo $id;
        $listdet = Devolucion::select('dev_data')->where('dev_id', $id)->where('dev_usr_id','=',Auth::user()->usr_id)->first();
        $datas = json_decode($listdet->dev_data);
        $data2 =collect($datas);
         return Datatables::of($data2)
            ->make(true);
    }

     public function store(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
    
        $id=$planta->id_planta;
        $num = Devolucion_Recibidas::join('public._bp_planta as plant', 'insumo.devolucion_recibidas.devrec_id_planta', '=', 'plant.id_planta')->select(DB::raw('MAX(devrec_cod_num) as nrodevrec'))->where('plant.id_planta', $id)->first();
        $cont=$num['nrodevrec'];
        $nid = $cont + 1;
        $fecha=date('Y');
        $ingreso_alm=Devolucion_Recibidas::create([
               // 'carr_ing_prov'    => $request['carr_ing_prov'],
                'devrec_id_dev'         => $request['devrec_id_dev'],
                'devrec_num_salida'     => $request['devrec_num_salida'],
                'devrec_nom_receta'     => $request['devrec_nom_receta'],
               // 'devrec_tipo_sol'       => $request['devrec_tipo_sol'],
                'devrec_data'           => $request['data'],
                'devrec_usr_id'         => Auth::user()->usr_id,
                'devrec_id_planta'      => $planta->id_planta,
                'devrec_cod_num'        => $nid,
                'devrec_gestion'        => $fecha,
                'devrec_estado'         => 'A',
            ]);
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $ins_devolucion =json_decode($request['data']);

        foreach ($ins_devolucion as $devolucion) {
        
           $stock1 = Stock_Almacen::where('stockal_ins_id','=' ,$devolucion->id1)->where('stockal_planta_id','=',$planta->id_planta)->first();
                      $id_ins = $stock1->stockal_ins_id;
                      $id_insumo = $devolucion->id1;
                      $id_plant = $planta->id_planta;
                      $cant_ingreso = $devolucion->devolucion1;
                      $stock_cantidad_ingreso = $stock1->stockal_cantidad + $cant_ingreso;
                      $stock1->stockal_cantidad = $stock_cantidad_ingreso;
                      $stock1->stockal_usr_id = Auth::user()->usr_id;
                      $stock1->save();                    
        }    
        return response()->json($ingreso_alm);
    }
}
