<?php

namespace siga\Http\Controllers\insumo\insumo_solicitudes;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_solicitud\Solicitud_Receta;
use siga\Modelo\insumo\insumo_solicitud\Solicitud;
use siga\Modelo\insumo\insumo_recetas\Receta;
use siga\Modelo\insumo\insumo_recetas\Mercado;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\Usuario;
use siga\Modelo\insumo\Stock_Almacen;
use siga\Modelo\insumo\insumo_registros\Datos;
use DB;
use Auth;
use PDF;
use TCPDF;
class gbSolRecetaController extends Controller
{
     public function index()
    {
        $solRecetas = Solicitud::getlistar();
        $mercado = Mercado::getlistar();
        // dd($solRecetas);
        return view('backend.administracion.insumo.insumo_solicitud.solicitud_receta.index', compact('solRecetas','mercado'));
    }

    public function create()
    {
        $solRecetas = Solicitud::getlistar();
        return Datatables::of($solRecetas)->addColumn('acciones', function ($solRecetas) {
            if($solRecetas->sol_estado == 'B')
            {
                return '<div class="text-center"><h4 class="text"><span class="label label-info">RECIBIDO</span></h4></div>';
            }else{
                return '<div class="text-center"><a href="boletaSolReceta/' . $solRecetas->sol_id . '" class="btn btn-md btn-primary" target="_blank">Boleta <i class="fa fa-file"></i></a></div>';
            }
        })
            ->editColumn('id', 'ID: {{$sol_id}}')
            -> addColumn('sol_estado', function ($solReceta) {
                if($solReceta->sol_estado=='A')
                { 
                    return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>'; 
                }elseif($solReceta->aprsol_estado == 'A')
                {
                    return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
                }elseif($solReceta->aprsol_estado=='B')
                { 
                    return '<h4 class="text"><span class="label label-danger">RECHAZADO</span></h4>'; 
                }
                            
             }) 
            ->make(true);
    }

    public function getReceta(Request $request)
    {   
        $term = $request->term ?: '';
        $receta = Receta::where('rec_estado','A')->where('rec_nombre','LIKE','%'.$term.'%')->take(35)->get();
        $recetas = [];
        foreach ($receta as $rec) {
            $recetas[] = ['id' => $rec->rec_id, 'text' => $rec->rec_nombre];
        }
        return \Response::json($recetas);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'receta_solicitud'          => 'required',
            'cantidad_solicitud'        => 'required',
            'mercado_solicitud'         => 'required|min:1',
        ]);
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        // $cod_nro = Solicitud_Receta::where('solrec_id_planta','=',$planta->id_planta)
        //                     ->select(DB::raw('MAX(solrec_cod_nro) as codigo_nro'))->first();
        $cod_nro = Solicitud::where('sol_id_planta','=',$planta->id_planta)->select(DB::raw('MAX(sol_codnum) as codigo_nro'))->first();
        // dd($cod_nro['codigo_nro']);
        $nro_cod = $cod_nro['codigo_nro'] + 1;
        $solReceta = Solicitud::create([
            'sol_id_rec'         => $request['receta_solicitud'],
            'sol_cantidad'       => $request['cantidad_solicitud'],
            'sol_id_merc'        => $request['mercado_solicitud'],
            'sol_data'           => $request['solrec_data'],
            'sol_usr_id'         => Auth::user()->usr_id,
            'sol_id_tipo'           =>  1,
            // 'sol_registrado'     => '2018-12-18',
            // 'sol_modificado'     => '2018-12-18',
            'sol_estado'         => 'A',
            'sol_id_planta'      => $planta->id_planta,
            'sol_codnum'        => $nro_cod,
            'sol_gestion'        => date("Y"),
        ]);
        return response()->json($solReceta);
    }


     public function reporteBoletaSolReceta($id)
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('EBA');
        $pdf->SetSubject('INSUMOS');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
        // $usr = Usuario::setNombreRegistro();
        // $per=Collect($usr);
        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_user =  Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id_user)->first();
        $reg = Solicitud::join('insumo.mercado as merc', 'insumo.solicitud.sol_id_merc', '=', 'merc.merc_id')
                            ->join('public._bp_planta as planta','insumo.solicitud.sol_id_planta','=','planta.id_planta')
                            ->join('insumo.receta as rec','insumo.solicitud.sol_id_rec','=','rec.rec_id')
                            ->where('insumo.solicitud.sol_usr_id','=',$id_user)->where('insumo.solicitud.sol_id','=',$id)
                            ->where('insumo.solicitud.sol_id_tipo','=',1)->first();
        $data = $reg['sol_data'];
    
        $array = json_decode($data);
    
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="/img/logopeqe.png" width="160" height="65"></th>
                             <th  width="370"><h3 align="center"><br>ALMACEN '.$reg['nombre_planta'].'<br>NOTA DE SOLICITUD</h3></th>
                             <th  width="150"><h3 align="center"><br>Fecha: '.date('d/m/Y').'<br>Codigo No: '.$reg['sol_codnum'].'/'.$reg['sol_gestion'].'</h3></th>
                        </tr>
                    </table>
                    <br><br><br>
                        <label><strong>Solicitante:</strong> '.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label align="right"><strong>Mercado:</strong> '.$reg['merc_nombre'].'</label>
                        <br><br>
                        <label><strong>Dependencia:</strong> '.$planta['nombre_planta'].'</label>
                        <br><br>
                        
                        <h3 align="center">'.$reg['rec_nombre'].'</h3>
                    <br><br><br>

                    <table border="1" cellspacing="0">
                     
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>Unidad</strong></th>
                            <th align="center" bgcolor="#3498DB" width="215"><strong>Descripcion</strong></th>
                            <th align="center" bgcolor="#3498DB" width="70"><strong>Cantidad</strong></th>
                            <th align="center" bgcolor="#3498DB" width="205"><strong>Mercado</strong></th>
                        </tr> ';
                        $nro=0;
                        // $tot1=0;
                    //    echo $data;
                    foreach ($array as $d) {
                        $nro = $nro+1; 
                        
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">'.$nro.'</td>
                                    <td align="center">'.$d->unidad.'</td>
                                    <td align="center">'.$d->descripcion_insumo.'</td>
                                    <td align="center">'.$d->cantidad.'</td>
                                    <td align="center">'.$reg['merc_nombre'].'</td>
                                  </tr>';  
                        
                       // echo $tot1;    

                     }
                     $html = $html . '</table><br><br><br><br><br><br>';

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


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('boletaSolReceta-'.$reg['sol_id'].'.pdf', 'I');

    }

    public function rptSolicitudAlmacen()
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('EBA');
        $pdf->SetSubject('INSUMOS');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
        $pdf->AddPage('L', 'Carta');
        //PDF::AddPage();

        // create some HTML content
        $usr = Usuario::setNombreRegistro();
        $per=Collect($usr);
        $id =  Auth::user()->usr_id;
      //  echo $id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id)->first();

        $reg = Solicitud::where('sol_id_planta','=',$planta->id_planta)->orderby('sol_id','ASC')->get();
       // echo $reg;
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><br><br><img src="/img/logopeqe.png" width="140" height="65"></th>
                             <th  width="830"><h3 align="center"><br>REPORTE GENERAL DE SOLICITUDES<br>ALMACEN INSUMOS: '.$planta['nombre_planta'].'<br>Fecha de Emision: '.date('d/m/Y').'<br></h3></th>
                        </tr>
                    </table>
                    <br><br>
                        <label>GENERADO POR: '. $per['prs_nombres'].' '.$per['prs_paterno'].' '.$per['prs_materno'].'</label>
                        <br><br>
                    <table border="1" cellspacing="0" cellpadding="1">
                     
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="60"><strong>No.</strong></th>
                            <th align="center" bgcolor="#3498DB" width="60"><strong>No. Solicitud</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>CODIGO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="350"><strong>ARTICULO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="180"><strong>CANTIDAD</strong></th>
                            <th align="center" bgcolor="#3498DB" width="200"><strong>FECHA SOLICITUD.</strong></th>
                            
                        </tr>';
                        $nro=0;
                    foreach ($reg as $key => $r) {                                              
                        $data = $r->sol_data;
                        $array = json_decode($data);
                        foreach ($array as $dat) { 
                            $nro = $nro+1;
                            $cantidad = (float)$dat->cantidad;
                            $rango = (float)$dat->rango_adicional;
                            $solAdi = (float)$dat->solicitud_adicional;
                            $cantidadTotal = $cantidad+$rango+$solAdi;  
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                <td align="center">'.$nro.'</td>
                                <td align="center">'.$r->sol_codnum.'</td>
                                <td align="center">'.$dat->codigo_insumo.'</td>
                                <td align="center">'.$dat->descripcion_insumo.'</td>
                                <td align="center">'.number_format($cantidadTotal,2,'.',',').'</td>
                                <td align="center">'.$r->sol_registrado.'</td></tr>';                    
                        }
                     }

                       

                    $htmltable = $html . '</table>';
        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Reporte_solicitud_Almacen.pdf', 'I');
    } 
    public function rptSolicitudGeneral()
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('EBA');
        $pdf->SetSubject('INSUMOS');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
        $pdf->AddPage('L', 'Carta');
        //PDF::AddPage();

        // create some HTML content
        $usr = Usuario::setNombreRegistro();
        $per=Collect($usr);
        $id =  Auth::user()->usr_id;
      //  echo $id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id)->first();

        $reg = Solicitud::join('public._bp_planta as planta','insumo.solicitud.sol_id_planta','=','planta.id_planta')->orderby('sol_id','ASC')->get();
       // echo $reg;
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><br><br><img src="/img/logopeqe.png" width="140" height="65"></th>
                             <th  width="830"><h3 align="center"><br>REPORTE GENERAL DE SOLICITUDES ALMACENES INSUMOS <br>Fecha de Emision: '.date('d/m/Y').'<br></h3></th>
                        </tr>
                    </table>
                    <br><br>
                        <label><strong>GENERADO POR:</strong> '. $per['prs_nombres'].' '.$per['prs_paterno'].' '.$per['prs_materno'].'</label>
                        <br><br>
                    <table border="1" cellspacing="0" cellpadding="1">
                     
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="60"><strong>No.</strong></th>
                            <th align="center" bgcolor="#3498DB" width="250"><strong>PLANTA</strong></th>
                            <th align="center" bgcolor="#3498DB" width="100"><strong>CODIGO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="250"><strong>ARTICULO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150"><strong>CANTIDAD</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150"><strong>FECHA SOLICITUD</strong></th>
                            
                        </tr>';
                        $nro=0;
                        $total_cantidad = 0;
                    foreach ($reg as $key => $r) {                                              
                        $data = $r->sol_data;
                        $array = json_decode($data);
                        foreach ($array as $dat) { 
                            $nro = $nro+1;                            
                            $cantidad = (float)$dat->cantidad;
                            $rango = (float)$dat->rango_adicional;
                            $solAdi = (float)$dat->solicitud_adicional;
                            $cantidadTotal = $cantidad+$rango+$solAdi;
                            $total_cantidad = $total_cantidad + $cantidadTotal;  
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                <td align="center">'.$nro.'</td>
                                <td align="center">'.$r->nombre_planta.'</td>
                                <td align="center">'.$dat->codigo_insumo.'</td>
                                <td align="center">'.$dat->descripcion_insumo.'</td>
                                <td align="center">'.number_format($cantidadTotal,2,'.',',').'</td>
                                <td align="center">'.$r->sol_registrado.'</td></tr>';                    
                        }
                     }

                     $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                <td align="center" colspan="4"><strong>TOTAL</strong></td>                                
                                <td align="center"><strong>'.number_format($total_cantidad,2,'.',',').'</strong></td>
                                <td align="center"><strong>-</strong></td></tr>';

                       

                    $htmltable = $html . '</table>';
        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Reporte_solicitud_General.pdf', 'I');
    } 

    public function stock_actual($id_insumo)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $stock_actual = Stock_Almacen::select('stockal_cantidad')->where('stockal_planta_id','=',$planta->id_planta)
                                    ->where('stockal_ins_id','=',$id_insumo)->first();
        return response()->json($stock_actual); 
    }  

    public function traeUnidadInsumo($id_insumo)
    {
        $unidad = Datos::join('insumo.insumo as ins','insumo.dato.dat_id','=','ins.ins_id_uni')
                        ->select('insumo.dato.dat_nom')
                        ->where('ins.ins_id',$id_insumo)
                        ->first();
        return response()->json($unidad);
    }
}
