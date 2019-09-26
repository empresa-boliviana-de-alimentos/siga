<?php

namespace siga\Http\Controllers\insumo\insumo_registros;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\Envio_Almacen;
use siga\Modelo\admin\Usuario;
use siga\Modelo\insumo\insumo_registros\Insumo;
use siga\Modelo\insumo\insumo_registros\Ingreso;
use siga\Modelo\insumo\insumo_registros\DetalleIngreso;
use siga\Modelo\insumo\Stock;
use siga\Modelo\insumo\Stock_Almacen;
use siga\Modelo\HistoStock;
use siga\Modelo\insumo\insumo_registros\MatPrimAprobado;
use siga\Modelo\insumo\InsumoHistorial;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Auth;
use PDF;
use TCPDF;

class gbIngresoPrimaController extends Controller
{
    public function index()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $combo = Insumo::join('insumo.tipo_insumo as tipins','insumo.insumo.ins_id_tip_ins','=','tins_id')->select('ins_id', 'ins_desc', 'ins_codigo')->where('tipins.tins_id',3)->where('ins_id_linea_prod',$planta->id_linea_trabajo)->get();
        $id=$planta->id_planta;
        $envio = \DB::table('acopio.envio_almacen')
               ->join('public._bp_usuarios', 'acopio.envio_almacen.enval_usr_id', '=', 'usr_id')
               ->join('public._bp_personas', '_bp_usuarios.usr_prs_id', '=', 'public._bp_personas.prs_id')
               ->leftjoin('insumo.ingreso as ing','acopio.envio_almacen.enval_id','ing.ing_env_acop_id')
               ->where('enval_id_planta',$id)
               // ->where('enval_estado', 'A')
               ->get();
    	return view('backend.administracion.insumo.insumo_registro.ingreso_prima.index', compact('combo','envio'));
    }

     public function create()
    {
    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id=$planta->id_planta;
    	$envio = \DB::table('acopio.envio_almacen')
               ->join('public._bp_usuarios', 'acopio.envio_almacen.enval_usr_id', '=', 'usr_id')
               ->join('public._bp_personas', '_bp_usuarios.usr_prs_id', '=', 'public._bp_personas.prs_id')
               ->leftjoin('insumo.ingreso as ing','acopio.envio_almacen.enval_id','ing.ing_env_acop_id')
               ->where('enval_id_planta',$id)
               // ->where('enval_estado', 'A')
               ->get();
        return Datatables::of($envio)->addColumn('acciones', function ($envio) {
            if ($envio->enval_estado=='A') {
                return '<div class="text-center"><button value="' . $envio->enval_id . '" id="button" class="btn btn-success insumo-get" onClick="MostrarEnvio(this)" data-toggle="modal" data-target="#myCreatePrima"><i class="fa fa-eye"></i> Detalle</button></div>';
            }elseif($envio->enval_estado=='B'){
                //return '<button value="' . $envio->enval_id . '" id="button" class="btn btn-primary btn-xs insumo-get" onClick="MostrarEnvio(this)" data-toggle="modal" data-target="#myCreatePrima">REPORTE <i class="fa fa-file"><i></button>';
               return '<div class="text-center"><a href="ReportePrimaEnval/' . $envio->enval_id . '" class="btn btn-md btn-primary" target="_blank">Boleta <i class="fa fa-file"></i></a></div>';
            }
            
        })->addColumn('codigo', function ($envio) {
            if ($envio->ing_id) {
               return $this->traeCodigo($envio->ing_id);
            }else{
                return "-";
            }
            
        })
         ->addColumn('nombre', function ($nombre) {
            return $nombre->prs_nombres . ' ' . $nombre->prs_paterno. ' ' . $nombre->prs_materno;
        })
         ->addColumn('cantidad_recep', function ($cantidad_recep) {
            if ($cantidad_recep->ing_id) {
                return $this->traeCantidadRecep($cantidad_recep->ing_id);
            }else{
                return '-';
            }
        })         
            ->editColumn('id', 'ID: {{$enval_id}}')
            ->make(true);
    }
    function traeCodigo($id_ing)
    {
        $det = \DB::table('insumo.detalle_ingreso')->join('insumo.insumo as ins','insumo.detalle_ingreso.deting_ins_id','=','ins.ins_id')
                    ->where('deting_ing_id',$id_ing)->first();

        return $det->ins_codigo;
    }
    function traeCantidadRecep($id_recep)
    {
        $deting_mat = DetalleIngreso::where('deting_ing_id',$id_recep)->first();
        return $deting_mat->deting_cantidad;
    }
     public function store(Request $request)
    {
        $this->validate(request(), [
            'obs'       => 'required',
            //'unidad'    => 'required',
            'insumo'    => 'required',
            'cantidad'  => 'required',
            'costo'     => 'required',
        ]); 

    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_planta=$planta->id_planta;
        $num = Ingreso::join('public._bp_planta as plant', 'insumo.ingreso.ing_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(ing_enumeracion) as nroprim'))->where('plant.id_planta', $id_planta)->first();
        $cont=$num['nroprim'];
        $nid = $cont + 1;
        $fecha=date('Y');
        $materia_prima = Ingreso::create([
            'ing_id_tiping'   => 2,
            'ing_enumeracion' => $nid,
            'ing_usr_id'      => Auth::user()->usr_id,
            'ing_planta_id'   => $id_planta,
            'ing_env_acop_id' => $request['id_enval'],
            'ing_obs'         => $request['obs'],           
        ]);

        $detingreso = DetalleIngreso::create([
            'deting_ins_id'     => $request['insumo'],
            'deting_prov_id'    => 1,
            'deting_cantidad'   => $request['cantidad'],
            'deting_costo'      => $request['costo'],
            'deting_ing_id'     => $materia_prima->ing_id,
        ]);

        Stock::create([
            'stock_ins_id'      => $request['insumo'],
            'stock_deting_id'   => $detingreso->deting_id,
            'stock_cantidad'    => $request['cantidad'],
            'stock_costo'       => $request['costo'],
            'stock_fecha_venc'  => '2019-07-26',
            'stock_planta_id' => $id_planta,
        ]);
        InsumoHistorial::create([
                'inshis_ins_id'     => $request['insumo'],
                'inshis_planta_id'  => $id_planta,
                'inshis_tipo'       => 'Entrada',
                'inshis_deting_id'  => $detingreso->deting_id,
                'inshis_cantidad'   => $request['cantidad'],
        ]);
        /*$prima = MatPrimAprobado::orderby('prim_id','DESC')->take(1)->get();
        foreach ($prima as $prim) {
        
           $stock1 = Stock_Almacen::where('stockal_ins_id','=' ,$prim->prim_tipo_ins)->where('stockal_planta_id','=',$planta->id_planta)->first();
                if($stock1==null)
                {
                    $fecha1=date('d/m/Y');
                        $cant_ingreso = $prim->prim_cant;
                        $id_insumo = $prim->prim_tipo_ins;
                        $id_plant = $planta->id_planta;
                     Stock_Almacen::create([
                        'stockal_ins_id'    => $id_insumo,
                        'stockal_planta_id' => $id_plant,
                        'stockal_cantidad'  => $cant_ingreso,
                        'stockal_fecha'     => $fecha1,
                        'stockal_estado'    => 'A',
                        'stockal_usr_id'    => Auth::user()->usr_id,
                    ]);
                     $total_ent = $cant_ingreso*$request['costo'];
                     HistoStock::create([
                        'hist_id_carring'     => $materia_prima->prim_id,
                        'hist_id_planta'      => $id_plant,
                        'hist_detale'         => $nid,
                        'hist_cant_ent'       => $cant_ingreso,
                        'hist_cost_ent'       => $request['costo'],
                        'hist_tot_ent'        => $total_ent,
                        'hist_usr_id'         => Auth::user()->usr_id,
                        'hist_id_ins'         => $id_insumo,
                    ]);
                }
                else{

                      $id_ins = $stock1->stockal_ins_id;
                      $id_insumo = $prim->prim_tipo_ins;
                      $id_plant = $planta->id_planta;
                      $cant_ingreso = $prim->prim_cant;
                      $stock_cantidad_ingreso = $stock1->stockal_cantidad + $cant_ingreso;
                      $stock1->stockal_cantidad = $stock_cantidad_ingreso;
                      $stock1->stockal_usr_id = Auth::user()->usr_id;
                      $stock1->save(); 
                      $total_ent = $cant_ingreso*$request['costo'];
                      HistoStock::create([
                        'hist_id_carring'     => $materia_prima->prim_id,
                        'hist_id_planta'      => $id_plant,
                        'hist_detale'         => $nid,
                        'hist_cant_ent'       => $cant_ingreso,
                        'hist_cost_ent'       => $request['costo'],
                        'hist_tot_ent'        => $total_ent,
                        'hist_usr_id'         => Auth::user()->usr_id,
                        'hist_id_ins'         => $id_insumo,
                    ]);                   
                }
        }*/    

        $envioal_matprim = Envio_Almacen::where('enval_id','=',$request['id_enval'])->first();
        $envioal_matprim->enval_estado = 'B';
        $envioal_matprim->save();

        return response()->json($materia_prima);
    }

    public function edit($id)
    {
        $envio = \DB::table('acopio.envio_almacen')
               ->join('public._bp_usuarios', 'acopio.envio_almacen.enval_usr_id', '=', 'usr_id')
               ->join('public._bp_personas', '_bp_usuarios.usr_prs_id', '=', 'public._bp_personas.prs_id')
        	   ->where('enval_id', $id)->first();
        return response()->json($envio);
    }

    public function reportePrima($id_ingreso)
    {
        //dd($id_ingreso);
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
        //PDF::AddPage();

        // create some HTML content
   //     $carr = CarritoSolicitud::getListar();
        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per=Collect($usr);
        //echo $per;
        $id =  Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id)->first();
        $reg = Ingreso::join('acopio.envio_almacen as env','insumo.ingreso.ing_env_acop_id','=','env.enval_id')
                      ->where('ing_id',$id_ingreso)->first();
        //$detalle_ingreso = DetalleIngreso::where('deting_ing_id',$id_ingreso)->first();
        $detalle_ingreso = DetalleIngreso::join('insumo.insumo as ins','insumo.detalle_ingreso.deting_ins_id','=','ins.ins_id')->where('deting_ing_id',$reg->ing_id)->first();
        // echo $reg['carr_ing_usr_id'];
    
        $html = '   
                    <br><br>
                    <table border="0" cellspacing="0" cellpadding="1">
                                                <tr>
                        <th rowspan="3" align="center" width="150"><img src="img/logopeqe.png" width="150" height="105"></th>
                             <th rowspan="3" width="375"><h3 align="center"><br>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS<br>PLANTA '.$planta['nombre_planta'].'</h3><br><h1 align="center">NOTA DE INGRESO DE MATERIA PRIMA</h1>
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
                                        <th align="center" >'. $usr->prs_nombres .' '.$usr->prs_paterno.'</th>
                                    </tr>
                                    <tr BGCOLOR="#f3f0ff">
                                        <th align="center" bgcolor="#5c6875"><strong color="white">Codigo:</strong></th>
                                        <th align="center">'.$reg['ing_enumeracion'].'/'.date('Y',strtotime($reg['ing_registrado'])).'</th>
                                    </tr>
                                </table>
                             </th>                     
                        </tr>
                    </table>

                    <br><br><br>
                        

                    <br>
                        <table border="1">
                            <tr BGCOLOR="#f3f0ff">
                                <th align="center" bgcolor="#5c6875" width="135"><strong color="white">Responsable Almacén:</strong></th>
                                <th width="210"> '. $per['prs_nombres'].' '.$per['prs_paterno'].' '.$per['prs_materno'].'</th>
                                <th align="center" bgcolor="#5c6875" width="100"><strong color="white">Dependencia:</strong></th>
                                <th width="220"> '.$planta['nombre_planta'].'</th>
                            </tr>
                            <tr BGCOLOR="#f3f0ff">
                                <th align="center" bgcolor="#5c6875" width="55"><strong color="white">Insumo:</strong></th>
                                <th width="130"> '.$detalle_ingreso->ins_desc.'</th>
                                <th align="center" bgcolor="#5c6875" width="110"><strong color="white">Cantidad Enviado:</strong></th>
                                <th width="75"> '.$reg['enval_cant_total'].'</th>
                                <th align="center" bgcolor="#5c6875" width="120"><strong color="white">Cantidad Recibido:</strong></th>
                                <th width="75"> '. $detalle_ingreso['deting_cantidad'] .'</th>
                                <th align="center" bgcolor="#5c6875" width="60"><strong color="white">Costo U.:</strong></th>
                                <th width="40"> '.$detalle_ingreso['deting_costo'].'</th>
                            </tr>
                        </table>
                    <br><br><br>


                    <table border="1" cellspacing="2" cellpadding="20">';
                        
                      $html = $html . '<tr>
                                <th align="left"><strong>Observaciones (Justificantes):</strong> '.$reg['ing_obs'].'</th>
                               
                                </tr>
                            ';   
                    $htmltable = $html . '</table><br><br><br><br><br><br><br><br><br><br>';
                    $htmltable = $htmltable . '
                                <table><tr>
                                    <th align="center">..................................................</th>   
                                    <th align="center">..................................................</th>   
                                    <th align="center">..................................................</th>                               
                                </tr>
                                <tr>
                                    <th align="center">Responsable de Almacén</th>   
                                    <th align="center">Responsable Administrativo</th>   
                                    <th align="center">Jefe de Planta</th>                               
                                </tr>
                            ';   

                    $htmltable = $htmltable . '</table>';

        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Reporte_almacen.pdf', 'I');

    }

    // REPORTE DE INGRESO MATERIA PRIMA
    public function reportePrimaReporte($id_envio)
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
        //PDF::AddPage();

        // create some HTML content
   //     $carr = CarritoSolicitud::getListar();
        //$usr=Usuario::setNombreRegistro();
        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('usr_id',Auth::user()->usr_id)->first();
        $per=Collect($usr);
        //echo $per;
        $id=Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id)->first();
        $reg = Ingreso::join('acopio.envio_almacen as env','insumo.ingreso.ing_env_acop_id','=','env.enval_id')
                      ->where('ing_env_acop_id',$id_envio)->first();
        $detalle_ingreso = DetalleIngreso::join('insumo.insumo as ins','insumo.detalle_ingreso.deting_ins_id','=','ins.ins_id')->where('deting_ing_id',$reg->ing_id)->first();
        //dd($detalle_ingreso);
        // echo $reg['carr_ing_usr_id'];
    
        $html = '<br><br>
                    <table border="0" cellspacing="0" cellpadding="1">
                                                <tr>
                        <th rowspan="3" align="center" width="150"><img src="img/logopeqe.png" width="150" height="105"></th>
                             <th rowspan="3" width="375"><h3 align="center"><br>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS<br>PLANTA '.$planta['nombre_planta'].'</h3><br><h1 align="center">NOTA DE INGRESO DE MATERIA PRIMA</h1>
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
                                        <th align="center" >'. $usr->prs_nombres .' '.$usr->prs_paterno.'</th>
                                    </tr>
                                    <tr BGCOLOR="#f3f0ff">
                                        <th align="center" bgcolor="#5c6875"><strong color="white">Codigo:</strong></th>
                                        <th align="center">'.$reg['ing_enumeracion'].'/'.date('Y',strtotime($reg['ing_registrado'])).'</th>
                                    </tr>
                                </table>
                             </th>                     
                        </tr>
                    </table>

                    <br><br><br>                        
                        <br><br>                        
                        <table border="1">
                            <tr BGCOLOR="#f3f0ff">
                                <th align="center" bgcolor="#5c6875" width="135"><strong color="white">Responsable Almacén:</strong></th>
                                <th width="210"> '. $per['prs_nombres'].' '.$per['prs_paterno'].' '.$per['prs_materno'].'</th>
                                <th align="center" bgcolor="#5c6875" width="100"><strong color="white">Dependencia:</strong></th>
                                <th width="220"> '.$planta['nombre_planta'].'</th>
                            </tr>
                            <tr BGCOLOR="#f3f0ff">
                                <th align="center" bgcolor="#5c6875" width="55"><strong color="white">Insumo:</strong></th>
                                <th width="130"> '.$detalle_ingreso->ins_desc.'</th>
                                <th align="center" bgcolor="#5c6875" width="110"><strong color="white">Cantidad Enviado:</strong></th>
                                <th width="75"> '.$reg['enval_cant_total'].'</th>
                                <th align="center" bgcolor="#5c6875" width="120"><strong color="white">Cantidad Recibido:</strong></th>
                                <th width="75"> '. $detalle_ingreso['deting_cantidad'] .'</th>
                                <th align="center" bgcolor="#5c6875" width="60"><strong color="white">Costo U.:</strong></th>
                                <th width="40"> '.$detalle_ingreso['deting_costo'].'</th>
                            </tr>
                        </table>
                    <br><br><br>

                    <table border="1" cellspacing="2" cellpadding="20">';
                        
                      $html = $html . '<tr>
                                <th align="left"><strong>Observaciones (Justificantes):</strong> '.$reg['ing_obs'].'</th>
                               
                                </tr>
                            ';   

                    $htmltable = $html . '</table><br><br><br><br><br><br><br><br><br><br><br>';
                    $htmltable = $htmltable . '
                                <table><tr>
                                    <th align="center">..................................................</th>   
                                    <th align="center">..................................................</th>   
                                    <th align="center">..................................................</th>                               
                                </tr>
                                <tr>
                                    <th align="center">Responsable de Almacén</th>   
                                    <th align="center">Responsable Administrativo</th>   
                                    <th align="center">Jefe de Planta</th>                               
                                </tr>
                            ';   

                    $htmltable = $htmltable . '</table>';
        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Reporte_almacen.pdf', 'I');

    }    
}
