<?php

namespace siga\Http\Controllers\insumo\insumo_solicitudes;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_solicitud\Solicitud;
use siga\Modelo\insumo\insumo_solicitud\Solicitud_Maquila;
use siga\Modelo\insumo\insumo_registros\Insumo;
use siga\Modelo\admin\Usuario;
//ORDEN PRODUCCION
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion;
use DB;
use Auth;
use Yajra\Datatables\Datatables;
use PDF;
use TCPDF;

class gbSolTraspasoController extends Controller
{
     public function index()
    {
    	//$solMaquila = Solicitud::getlistarTraspaso();
    	//$insumos = Insumo::getListarInsumo();
        $linea = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                        ->where('usr_id',Auth::user()->usr_id)->first();
    	$plantas = DB::table('public._bp_planta')->where('id_linea_trabajo','=',$linea->id_linea_trabajo)->get();
    	// dd($plantas);
    	return view('backend.administracion.insumo.insumo_solicitud.solicitud_traspaso.index', compact('solMaquila','insumos','plantas'));
    }

    public function create()
    {
    	//$solMaquila = Solicitud::getlistarTraspaso();
        /*$solTraspaso = OrdenProduccion::join('public._bp_usuarios as usu','insumo.orden_produccion.orprod_usr_id','=','usu.usr_id')->where('orprod_tiporprod_id',3)->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')->join('public._bp_planta as pl','insumo.orden_produccion.orprod_planta_traspaso','=','pl.id_planta')->orderBy('orprod_id','desc')->get();*/
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();  
        $solTraspaso = OrdenProduccion::join('public._bp_usuarios as usu','insumo.orden_produccion.orprod_usr_id','=','usu.usr_id')->where('orprod_tiporprod_id',3)->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')->join('public._bp_planta as pl','insumo.orden_produccion.orprod_planta_traspaso','=','pl.id_planta')->where('orprod_planta_id',$planta->id_planta)->orderBy('orprod_id','desc')->get();

    	return Datatables::of($solTraspaso)->addColumn('acciones', function ($solTraspaso) {
            if ($solTraspaso->orprod_estado_orp == 'B') {
                return '<div class="text-center"><h4 class="text"><span class="label label-info">RECIBIDO</span></h4></div>';
            }
            return '<div class="text-center"><a href="BoletaSolTraspaso/' . $solTraspaso->orprod_id . '" class="btn btn-md btn-primary" target="_blank">Boleta <i class="fa fa-file"></i></a></div>';
        })
            ->editColumn('id', 'ID: {{$orprod_id}}')
            -> addColumn('sol_estado', function ($solTraspaso) {
                if($solTraspaso->orprod_estado_orp=='A')
                {
                    return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>'; 
                }elseif($solTraspaso->orprod_estado_orp == 'A')
                {
                    return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
                }elseif($solTraspaso->orprod_estado_orp == 'B')
                { 
                    return '<h4 class="text"><span class="label label-danger">RECHAZADO</span></h4>'; 
                }
            
        })-> addColumn('nombreSolicitante', function ($solTraspaso) {
               return $solTraspaso->prs_nombres.' '.$solTraspaso->prs_paterno.' '.$solTraspaso->prs_materno;            
        })
            ->make(true);

    }
    //CARRITO SOLICITUD TRASPASO
    public function carritoSolTras()
    {
        $linea = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                        ->where('usr_id',Auth::user()->usr_id)->first();
        $plantas = DB::table('public._bp_planta')->where('id_linea_trabajo','=',$linea->id_linea_trabajo)->get();
        return view('backend.administracion.insumo.insumo_solicitud.solicitud_traspaso.carritosoltras',compact('plantas'));
    }
    public function listarInsumosPlanta($id_planta)
    {
        $stock_insumo = Insumo::join('insumo.stock as stock','insumo.insumo.ins_id','=','stock.stock_ins_id')
                              ->join('insumo.unidad_medida as umed','insumo.insumo.ins_id_uni','=','umed.umed_id')
                              ->where('stock_planta_id',$id_planta)->get();
        return Datatables::of($stock_insumo)   
            ->editColumn('id', 'ID: {{$ins_id}}')
            ->addColumn('acciones', function ($stock_insumo) {
                return '<div><button value="'.$stock_insumo->ins_id.'" id="buttonsol" class="btn btn-success insumo-get" onClick="MostrarCarrito()" data-toggle="modal" data-target="#myCreateRCA">+</button></div>';
            })->addColumn('solicitud_cantidad', function($stock_insumo){
                return '<input class="form-control" type="number"></input>';
            })
            ->addColumn('id_insumo', function($stock_insumo){
                return '<input class="id_insumo form-control" type="hidden" value="'.$stock_insumo->ins_id.'"></input>';
            })
            ->make(true);
    }
    //END CARRITO SOLICITUD TRASPASO

    public function store(Request $request)
    {
        //dd($request['datos_json']);
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();     
        $planta_tras_id = $request['id_planta_traspaso'];
        $observacion = $request['observacion'];
        $num = OrdenProduccion::join('public._bp_planta as plant', 'insumo.orden_produccion.orprod_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(orprod_nro_orden) as nro_op'))->where('plant.id_planta', $planta->id_planta)->first();
        $cont=$num['nro_op'];
        $nop = $cont + 1;
         $numsol = OrdenProduccion::join('public._bp_planta as plant', 'insumo.orden_produccion.orprod_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(orprod_nro_solicitud) as nro_sol'))->where('plant.id_planta', $planta->id_planta)->first();
        $contsol=$numsol['nro_sol'];
        $nopsol = $contsol + 1;
        $orden_produccion = OrdenProduccion::create([
            'orprod_rece_id'    => 1,
            'orprod_codigo'     => '0001',
            'orprod_nro_orden'  => $nop,
            'orprod_nro_solicitud' => $nopsol,
            'orprod_cantidad'   => 0,
            'orprod_mercado_id'    => 1,
            'orprod_planta_traspaso' => $planta_tras_id,
            'orprod_planta_id'  => $planta->id_planta,
            'orprod_usr_id'     => Auth::user()->usr_id,
            'orprod_tiporprod_id' => 3,
            'orprod_obs_usr'    => $observacion,
            'orprod_estado_orp' => 'C'
        ]);
        $detorp = json_decode($request['datos_json']);
        //dd($detorp);
        foreach ($detorp as $detrece) {
            DetalleOrdenProduccion::create([
                'detorprod_orprod_id'   => $orden_produccion->orprod_id,
                'detorprod_ins_id'      => $detrece->id_insumo_sol,
                'detorprod_cantidad'    => $detrece->cantidad_sol,
            ]);
        }        
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }
    public function boletaSolTraspaso($id_orp)
    {
        function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('Helvetica', '', 8);
            // Page number
            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetPrintHeader(false); $pdf->SetPrintFooter(true);
        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('EBA');
        $pdf->SetSubject('INSUMOS');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '',PDF_FONT_SIZE_DATA)); 
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

          PDF::SetXY(125, 199);
            $pdf->Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            PDF::SetXY(120, 204);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->SetFont('helvetica', '', 9);

        // add a page
        $pdf->AddPage('Carta');

        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_user =  Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id_user)->first();
        $reg = OrdenProduccion::join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_traspaso','=','planta.id_planta')
                              ->join('public._bp_planta as pl','insumo.orden_produccion.orprod_planta_traspaso','=','pl.id_planta')
                              ->join('public._bp_usuarios as usu','insumo.orden_produccion.orprod_usr_id','=','usu.usr_id')
                              ->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
                              ->where('orprod_tiporprod_id',3)->where('orprod_id',$id_orp)
            ->first();
    
        
        // dd($reg);
        $html = '   <br><br>
                    <table border="0" cellspacing="0" cellpadding="1">
                                                <tr>
                        <th rowspan="3" align="center" width="150"><img src="img/logopeqe.png" width="150" height="105"></th>
                             <th rowspan="3" width="375"><h3 align="center"><br>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS<br>PLANTA - '.$planta->nombre_planta.'</h3><br><h1 align="center">NOTA DE SOLICITUD POR TRAPASO</h1>
                                </th> 
                             <th rowspan="3" align="center" width="150">
                             <br><br>
                                <table border="0.5" bordercolor="#000">
                                    <tr BGCOLOR="#f3f0ff">
                                        <th align="center" bgcolor="#5c6875" border="0"><strong color="white">Fecha Emision:</strong></th>
                                        <th align="center">'.date("d/m/Y").'</th>
                                    </tr>
                                    <tr BGCOLOR="#f3f0ff">
                                        <th align="center" bgcolor="#5c6875"><strong color="white">Usuario:</strong></th>
                                        <th align="center" >'. $usuario->prs_nombres .' '.$usuario->prs_paterno.'</th>
                                    </tr>
                                    <tr BGCOLOR="#f3f0ff">
                                        <th align="center" bgcolor="#5c6875"><strong color="white">Codigo:</strong></th>
                                        <th align="center">'.$reg['orprod_nro_solicitud'].'</th>
                                    </tr>
                                </table>
                             </th>                     
                        </tr>
                    </table>
                    <br><br><br>
                        
                        
                        <h3 align="center"></h3>
                        <table border="1" cellspacing="0">
                            <tr BGCOLOR="#f3f0ff">
                                <th align="center" bgcolor="#5c6875" width="150"><strong color="white">Solicitante:</strong></th>
                                <th width="520"> '.$reg['prs_nombres'].' '.$reg['prs_paterno'].' '.$reg['prs_materno'].'</th>
                            </tr>
                            <tr BGCOLOR="#f3f0ff">
                                <th align="center" bgcolor="#5c6875" width="150"><strong color="white">Planta a Solcicitar:</strong></th>
                                <th width="520"> '.$reg['nombre_planta'].'</th>
                            </tr>
                        </table>
                    <br>
                    <br>
                    <br>
                    <br>
                    <table border="1" cellspacing="0">
                     
                        <tr>
                            <th align="center" bgcolor="#5c6875" width="50"><strong color="white">Nro</strong></th>
                            <th align="center" bgcolor="#5c6875" width="270"><strong color="white">INSUMO</strong></th>
                            <th align="center" bgcolor="#5c6875" width="170"><strong color="white">UNIDAD</strong></th>
                            <th align="center" bgcolor="#5c6875" width="170"><strong color="white">Cantidad</strong></th>                            
                        </tr> ';
                     
                        // $tot1=0;
                        $detorp = DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')->join('insumo.unidad_medida as umed','ins.ins_id_uni','=','umed.umed_id')->where('detorprod_orprod_id',$id_orp)->get();
                        $nro = 1;
                        foreach ($detorp as $det) {                        
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">'.$nro.'</td>
                                    <td align="center">'.$det['ins_desc'].'</td>
                                    <td align="center">'.$det['umed_nombre'].'</td>
                                    <td align="center">'.$det['detorprod_cantidad'].'</td>
                                  </tr>';  
                            $nro = $nro + 1;
                        }
                       // echo $tot1;   
                     $html = $html . '</table>

                     <br><br>
                            <table border="1">
                                <tr>
                                    <th height="50"><strong> Observaciones:</strong> '.$reg['orprod_obs_usr'].'</th>
                                </tr>
                            </table>
                     <br><br><br><br><br><br><br><br><br><br><br><br>';

                      $html = $html . '
                                <table>
                            <tr>
                                <td align="center">Solicitado por firma: ............................................</td>
                                
                                <td align="center">Autorizado por firma: ............................................</td>
                            </tr>
                            <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                            <tr>
                                <td align="center">Nombre: ......................................................</td>
                                
                                <td align="center">Nombre: ......................................................</td>
                            </tr>                           
                            
                            </table>
                            ';   

                    $htmltable = $html;
        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('boletaSolMaquila-'.$reg['solmaq_id'].'.pdf', 'I');
    }
    public function boletaSolMaquila($id)
    {
        
    }
}
