<?php

namespace siga\Http\Controllers\acopio\acopio_miel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use siga\Http\Requests;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Usuario;
use siga\Modelo\acopio\acopio_miel\Acopio;
use siga\Modelo\acopio\acopio_miel\Proveedor;
use siga\Modelo\acopio\acopio_miel\Propiedades_Miel;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Auth;
use TCPDF;

class AcopioMielProduccionController extends Controller
{
    public function index(){
        $acopio = Acopio::getListarProd();
        // dd($acopio);
        $unidad = DB::table('acopio.unidad')->OrderBy('uni_id', 'desc')->pluck('uni_nombre','uni_id');
        $destino = DB::table('acopio.destino')->OrderBy('des_id','desc')->pluck('des_descripcion', 'des_id');
        $proveedor = Proveedor::OrderBy('prov_id', 'desc')->pluck('prov_nombre', 'prov_id');
        $resp_recep = DB::table('acopio.resp_recep')->OrderBy('rec_id','desc')->pluck('rec_nombre','rec_id');
        return view('backend.administracion.acopio.acopio_miel.acopio.indexProduccion', compact('acopio', 'proveedor','unidad','destino','resp_recep'));
    }

    public function create()
    {
        $acopio = Acopio::getListarProd();
        // dd($acopio);
        return Datatables::of($acopio)->addColumn('acciones', function ($acopio) {
            return '<button value="' . $acopio->aco_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarAcopio(this);" data-toggle="modal" data-target="#UpdateFondosAvance"><i class="fa fa-pencil-square"></i></button><button value="' . $acopio->aco_id . '" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
        })
            ->editColumn('id', 'ID: {{$aco_id}}')->
            addColumn('nombreCompleto', function ($nombres) {
                return $nombres->prov_nombre.' '.$nombres->prov_ap.' '.$nombres->prov_am;
        })
            ->editColumn('id', 'ID: {{$aco_id}}')->
            addColumn('materiPrima', function ($materiPrima) {
                if ($materiPrima->aco_mat_prim == 1) {
                    return '<h4 class="text-center"><span class="label label-success">Aceptado</span></h4>';
                }
                return '<h4 class="text-center"><span class="label label-danger">Rechazado</span></h4>';
        })
            ->editColumn('id', 'ID: {{$aco_id}}')
            ->make(true);
    }

    public function store(Request $request)
    {   
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        if ($request['aco_total_colm'] == 0) {
            return "Vacio";
        }else {
            $this->validate(request(), [
                'peso_neto_produccion_propia' => 'required',
                'numero_baldes' => 'required',//REALIZADO
                'nro_marcos_centrifigados' => 'required',//REALIZADO
                'peso_bruto_baldes_centrifrifugados' => 'required',//REALIZADO
                'peso_bruto_baldes_filtrados' => 'required',//REALIZADO
                'peso_bruto_baldes_impuresas' => 'required',//REALIZADO
                'aco_total_colm' => 'required',
                'codigos_colmenas' => 'required',//REALIZADO
                'id_proveedor' => 'required',
                'aco_numaco' => 'required',
                'acta_entrega' => 'required',
                'fecha_acopio' => 'required',
                'responsable_recepcion_produccion' => 'required',
                'destino_produccion' => 'required',
                'acopio_materia_prima_produccion' => 'required',//REALIZADO
                'produccion_latitud' => 'required',//REALIZADO
                'produccion_longitud' => 'required',//REALIZADO
            ]);
            $prom = Propiedades_Miel::create([
                'prom_peso_bruto'           =>0,
                'prom_peso_tara'            =>1.2,
                'prom_peso_neto'            =>$request['peso_neto_produccion_propia'],//REALIZADO
                'prom_cantidad_baldes'      =>$request['numero_baldes'],//REALIZADO
                'prom_total'                =>0,
                'prom_cod_colmenas'         =>0,
                'prom_centrifugado'         =>$request['nro_marcos_centrifigados'],//REALIZADO
                'prom_peso_bruto_centrif'   =>$request['peso_bruto_baldes_centrifrifugados'],//REALIZADO
                'prom_peso_bruto_filt'      =>$request['peso_bruto_baldes_filtrados'],//REALIZADO
                'prom_peso_bruto_imp'       =>$request['peso_bruto_baldes_impuresas'],//REALIZADO
                'prom_humedad'              =>0,
                'prom_cos_un'               =>0,
                'prom_total_marcos'         =>$request['aco_total_colm'],
                'prom_colmenas'             =>$request['codigos_colmenas'],//REALIZADO   
            ]);
            $prom_id = $prom->prom_id;
            Acopio::create([
                'aco_id_prov'       => $request['id_proveedor'],//MIEL//
                'aco_id_proc'       => 1,//MIEL//
                'aco_centro'        => null,//MIEL//
                'aco_peso_neto'     => null,//          
                'aco_id_tipo_cas'   => 1,//
                'aco_numaco'        => $request['aco_numaco'],//
                'aco_num_act'       => $request['acta_entrega'],//MIEL//
                'aco_unidad'        => 1,//
                'aco_cantidad'      => null,//MIEL//
                'aco_cos_un'        => null,//MIEL//
                'aco_cos_total'     => null,//MIEL//
                'aco_con_hig'       => null,//
                'aco_fecha_acop'    => $request['fecha_acopio'],//
                'aco_fecha_reg'     => "2018-10-01 16:00:00",//MIEL//
                'aco_obs'           => $request['observacion'],//MIEL//
                'aco_estado'        => 'A',//MIEL//
                'aco_tram'          => "2018-10-01 16:00:00",//
                'aco_num_rec'       => 1,//MIEL//
                'aco_id_comunidad'  => 1,//
                'aco_id_recep'      => $request['responsable_recepcion_produccion'],//MIEL//
                'aco_id_linea'      => 3,//MIEL//
                'aco_pago'          => 1,//MIEL//
                'aco_fecha_rec'     => "2018-10-01 16:00:00",//MIEL//
                'aco_id_destino'    => $request['destino_produccion'],//MIEL//
                'aco_id_prom'       => $prom_id,//MIEL//
                'aco_id_usr'        => Auth::user()->usr_id,//MIEL//
                'aco_lac_tem'       => null,
                'aco_lac_aci'       => null,
                'aco_lac_ph'        => null,
                'aco_lac_sng'       => null,
                'aco_lac_den'       => null,
                'aco_lac_mgra'      => null,
                'aco_lac_palc'      => null,
                'aco_lac_pant'      => null,
                'aco_lac_asp'       => null,
                'aco_lac_col'       => null,
                'aco_lac_olo'       => null,
                'aco_lac_sab'       => null,
                'aco_id_comp'       => null,
                'aco_cert'          => null,
                'aco_tipo'          => 2,
                'aco_mat_prim'      => $request['acopio_materia_prima_produccion'],
                'aco_latitud'       => $request['produccion_latitud'],//REALIZADO
                'aco_longitud'      => $request['produccion_longitud'],//REALIZADO
                'aco_id_planta'     => $planta->id_planta
            ]); 
            return response()->json(['Mensaje' => 'Se registro correctamente']);
        }
        
    }

     public function reporteProduccion()
    {   
        setlocale(LC_TIME, 'es');
        $datebus = new Carbon();
        $dato= $datebus->formatLocalized('%B de %Y');
        $datoexacto = $datebus->format('y-m');
        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')
            ->join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
        $acopios = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
                         ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id')
                         // ->select('acopio.acopio.aco_id','p.prov_id','p.prov_nombre', 'p.prov_ap','p.prov_am', 'acopio.acopio.aco_num_act', 'acopio.acopio.aco_fecha_acop','prom.prom_total','prom.prom_peso_bruto','prom.prom_peso_neto','acopio.acopio.aco_mat_prim')
                        ->select('acopio.acopio.aco_id','p.prov_id','p.prov_nombre', 'p.prov_ap','p.prov_am', 'acopio.acopio.aco_num_act', 'acopio.acopio.aco_fecha_acop','prom.prom_total_marcos','prom.prom_cantidad_baldes','prom.prom_peso_neto','prom.prom_centrifugado','prom.prom_peso_bruto_filt','prom_peso_bruto_centrif','prom.prom_peso_bruto_imp','prom.prom_colmenas','acopio.acopio.aco_mat_prim','acopio.acopio.aco_id_usr')
                        ->where('acopio.acopio.aco_id_linea','=',3 )
                        ->where('acopio.acopio.aco_estado', '=','A')
                        ->where('acopio.acopio.aco_tipo', '=' , 2)
                        ->where('p.prov_id_tipo','=',9)
                        ->where('acopio.acopio.aco_mat_prim','=',1)
                        ->where('acopio.acopio.aco_id_usr','=',Auth::user()->usr_id)
                        ->where('acopio.acopio.aco_fecha_acop','LIKE','%'.$datoexacto.'%')
                        ->OrderBy('acopio.acopio.aco_id', 'DESC')
                ->get();
        // dd($acopios);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        // $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('EBA');
        $pdf->SetSubject('ACOPIO MIEL');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData('logopeqe.png', PDF_HEADER_LOGO_WIDTH, "EBA - ACOPIO", "REPORTE DE ACOPIO MIEL - PRODUCCION PROPIA");

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 9);

        // add a page
        $pdf->AddPage('L', 'Carta');

        $tituloTabla = 'ACOPIO MIEL - PRODUCCION PROPIA';
        // create some HTML content        

        

        $html = '<h3>'.$tituloTabla.' DEL MES DE '.strtoupper($dato).' - PLANTA '.$usuario->nombre_planta.'</h3>
                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th align="center" bgcolor="#3498DB"><strong>#</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>PROVEEDOR</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>FECHA/HORA ACOPIO</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>N° ACOPIO</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>N° MARCOS CENTRIF.</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>P. BRUTO BALDES FILT.</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>P. BRUTO BALDES CENTRIF.</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>P. BRUTO BALDES IMP..</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>N° BALDES.</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>P. NETO.</strong></th>
                        </tr>';
                $num = 1;
                $totalcentrifugado = 0;
                $totalbrutofilt = 0;
                $totalbrutocentrif = 0;
                $totalbrutoimp = 0;
                $totalcantbaldes = 0;
                $totalpesoneto = 0;
                foreach ($acopios as $acopio){
                    $totalcentrifugado = $totalcentrifugado + $acopio->prom_centrifugado;
                    $totalbrutofilt = $totalbrutofilt + $acopio->prom_peso_bruto_filt;
                    $totalbrutocentrif = $totalbrutocentrif + $acopio->prom_peso_bruto_centrif;
                    $totalbrutoimp = $totalbrutoimp + $acopio->prom_peso_bruto_imp;
                    $totalcantbaldes = $totalcantbaldes + $acopio->prom_cantidad_baldes;
                    $totalpesoneto = $totalpesoneto + $acopio->prom_peso_neto;

                    $html = $html.'<tr>
                            <td align="center">'.$num.'</td>
                            <td align="center">'.$acopio->prov_nombre.' '.$acopio->prov_ap.' '.$acopio->prov_am.'</td>
                            <td align="center">'.$acopio->aco_fecha_acop.'</td>
                            <td align="center">'.$acopio->aco_num_act.'</td>
                            <td align="center">'.number_format($acopio->prom_centrifugado,2,'.',',').'</td>
                            <td align="center">'.number_format($acopio->prom_peso_bruto_filt,2,'.',',').' Kg.</td>
                            <td align="center">'.number_format($acopio->prom_peso_bruto_centrif,2,'.',',').' Kg.</td>
                            <td align="center">'.number_format($acopio->prom_peso_bruto_imp,2,'.',',').' Kg.</td>
                            <td align="center">'.number_format($acopio->prom_cantidad_baldes,2,'.',',').'</td>
                            <td align="center">'.number_format($acopio->prom_peso_neto,2,'.',',').' Kg.</td>
                        </tr>';
                    $num= $num+1;
                }                       
                $html = $html.'<tr>
                        <td colspan="4" align="center" bgcolor="#3498DB">TOTALES</td>
                        <td align="center"><strong>'.number_format($totalcentrifugado,2,'.',',').'</strong></td>
                        <td align="center"><strong>'.number_format($totalbrutofilt,2,'.',',').' Kg.</strong></td>
                        <td align="center"><strong>'.number_format($totalbrutocentrif,2,'.',',').' Kg.</strong></td>
                        <td align="center"><strong>'.number_format($totalbrutoimp,2,'.',',').' Kg.</strong></td>
                        <td align="center"><strong>'.number_format($totalcantbaldes,2,'.',',').'</strong></td>
                        <td align="center"><strong>'.number_format($totalpesoneto,2,'.',',').' Kg.</strong></td>
                    </tr>';        
                             
                $html = $html.'</table>';

                $html=$html.'
                            <br>  <br>  <br>  <br> <br> <br>
                            <table>
                            <tr>
                                <td align="center">______________________</td>
                                <td align="center">______________________</td>
                                <td align="center">______________________</td>
                            </tr>
                            <tr>
                                <td align="center">Encargado de Acopio</td>
                                <td align="center">Responsable de Almacen</td>
                                <td align="center">Responsable de Planta</td>
                            </tr>
                            <tr>
                                <td align="center"></td>
                                <td align="center"></td>
                                <td align="center"></td>
                            </tr>
                            <tr>
                                <td align="center"></td>
                                <td align="center"></td>
                                <td align="center"></td>
                            </tr>
                            
                            
                            </table>

                            <br>  <br>  <br>  <br> <br> <br>
                            <table>
                            <tr>
                                <td align="center">______________________</td>
                                
                                <td align="center">______________________</td>
                            </tr>
                            <tr>
                                <td align="center">Responsable de Acopio Nacional</td>
                                
                                <td align="center">Acopiador</td>
                            </tr>
                            <tr>
                                <td align="center"></td>
                                
                                <td align="center">'.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</td>
                            </tr>
                            
                            
                            </table>
                            
                        ';
        // output the HTML content
        $pdf->writeHTML($html, true, 0, true, 0);



        $pdf->AddPage();

        ////////////////////////////////////////////////////////////////////////////////////////////
        //                               REPORTES POR PROVEEDOR
        ////////////////////////////////////////////////////////////////////////////////////////////
        $proveedores = Proveedor::where('prov_id_linea','=',3)->where('prov_id_tipo','=',9)->where('prov_estado','=','A')
                                ->where('prov_id_usr','=',Auth::user()->usr_id)->get();

        // dd($proveedores);

        $tituloTabla = 'ACOPIO MIEL -  POR PROVEEDOR - PRODUCCION PROPIA';
        // create some HTML content        
     

        $html = '<h3>'.$tituloTabla.' DEL MES DE '.strtoupper($dato).' - PLANTA '.$usuario->nombre_planta.'</h3>
                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th align="center" bgcolor="#3498DB"><strong>#</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>PROVEEDOR</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>N° MARCOS CENTRIF.</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>P. BRUTO BALDES FILT.</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>P. BRUTO BALDES CENTRIF.</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>P. BRUTO BALDES IMP..</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>N° BALDES.</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>P. NETO.</strong></th>
                        </tr>';
                 $numprov = 1;
                // $totalprecioAco = 0;
                // $totalbruto = 0;
                // $totalneto = 0;

                $totalcentrifugado = 0;
                $totalbrutofilt = 0;
                $totalbrutocentrif = 0;
                $totalbrutoimp = 0;
                $totalcantbaldes = 0;
                $totalpesoneto = 0;
                foreach ($proveedores as $proveedor){
                    $html = $html.'<tr>
                            <td align="center">'.$numprov.'</td>
                            <td align="center">'.$proveedor->prov_nombre.' '.$proveedor->prov_ap.' '.$proveedor->prov_am.'</td>';
                            $totalcentrifugado = $totalcentrifugado + $centrifugado= $this->tCentrifugado($proveedor->prov_id,$datoexacto);
                            $totalbrutofilt = $totalbrutofilt + $brutofilt = $this->tBrutoFilt($proveedor->prov_id, $datoexacto);
                            $totalbrutocentrif = $totalbrutocentrif + $brutocentrif = $this->tBrutoCentrif($proveedor->prov_id, $datoexacto);
                            $totalbrutoimp = $totalbrutoimp + $brutoimp = $this->tBrutoImp($proveedor->prov_id, $datoexacto);
                            $totalcantbaldes = $totalcantbaldes + $cantbaldes = $this->tNroBaldes($proveedor->prov_id, $datoexacto);
                            $totalpesoneto = $totalpesoneto + $pesoneto = $this->tPesoNeto($proveedor->prov_id, $datoexacto);
                    $html= $html.'<td align="center">'.number_format($centrifugado,2,'.',',').'</td>
                                 <td align="center">'.number_format($brutofilt,2,'.',',').' Kg.</td>
                                 <td align="center">'.number_format($brutocentrif,2,'.',',').' Kg.</td>
                                 <td align="center">'.number_format($brutoimp,2,'.',',').' Kg.</td>
                                 <td align="center">'.number_format($cantbaldes,2,'.',',').'</td>
                                 <td align="center">'.number_format($pesoneto,2,'.',',').' Kg.</td>  
                                                                   
                        </tr>';
                    $numprov= $numprov+1;
                }                       
                $html = $html.'<tr>
                        <td colspan="2" align="center" bgcolor="#3498DB">TOTALES</td>
                        <td align="center"><strong>'.number_format($totalcentrifugado,2,'.',',').'</strong></td>
                        <td align="center"><strong>'.number_format($totalbrutofilt,2,'.',',').' Kg.</strong></td>
                        <td align="center"><strong>'.number_format($totalbrutocentrif,2,'.',',').' Kg.</strong></td>
                        <td align="center"><strong>'.number_format($totalbrutoimp,2,'.',',').' Kg.</strong></td>
                        <td align="center"><strong>'.number_format($totalcantbaldes,2,'.',',').'</strong></td>
                        <td align="center"><strong>'.number_format($totalpesoneto,2,'.',',').' Kg.</strong></td>
                        
                    </tr>';        
                             
                $html = $html.'</table>';

                $html=$html.'
                            <br>  <br>  <br>  <br> <br> <br>
                            <table>
                            <tr>
                                <td align="center">______________________</td>
                                <td align="center">______________________</td>
                                <td align="center">______________________</td>
                            </tr>
                            <tr>
                                <td align="center">Encargado de Acopio</td>
                                <td align="center">Responsable de Almacen</td>
                                <td align="center">Responsable de Planta</td>
                            </tr>
                            <tr>
                                <td align="center"></td>
                                <td align="center"></td>
                                <td align="center"></td>
                            </tr>
                            <tr>
                                <td align="center"></td>
                                <td align="center"></td>
                                <td align="center"></td>
                            </tr>
                            
                            
                            </table>

                            <br>  <br>  <br>  <br> <br> <br>
                            <table>
                            <tr>
                                <td align="center">______________________</td>
                                
                                <td align="center">______________________</td>
                            </tr>
                            <tr>
                                <td align="center">Responsable de Acopio Nacional</td>
                                
                                <td align="center">Acopiador</td>
                            </tr>
                            <tr>
                                <td align="center"></td>
                                
                                <td align="center">'.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</td>
                            </tr>
                            
                            
                            </table>
                            
                        ';
        // output the HTML content
        $pdf->writeHTML($html, true, 0, true, 0);

        // reset pointer to the last page
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Acopio_Miel_Proveedor_Produccion_Propia.pdf', 'I');

    }

    public function tCentrifugado($idprov, $fecha){
        $acopiosproveedor = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
                                 ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id')
                                 ->select('prom.prom_centrifugado')
                                ->where('acopio.acopio.aco_id_linea','=',3 )
                                ->where('acopio.acopio.aco_estado', '=','A')
                                ->where('acopio.acopio.aco_tipo', '=' , 2)
                                ->where('p.prov_id','=',$idprov)
                                ->where('p.prov_id_tipo','=',9)
                                ->where('acopio.acopio.aco_mat_prim','=',1)
                                ->where('acopio.acopio.aco_fecha_acop','LIKE','%'.$fecha.'%')
                                ->OrderBy('acopio.acopio.aco_id', 'DESC')->get();
        $promCentrifugado=0;
        foreach($acopiosproveedor as $acopioprov){
            $promCentrifugado = $promCentrifugado + $acopioprov->prom_centrifugado;
        }
        return $promCentrifugado;
    }

    public function tBrutoFilt($idprov, $fecha){
        $acopiosproveedor = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
                                 ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id')
                                 ->select('prom.prom_peso_bruto_filt')
                                ->where('acopio.acopio.aco_id_linea','=',3 )
                                ->where('acopio.acopio.aco_estado', '=','A')
                                ->where('acopio.acopio.aco_tipo', '=' , 2)
                                ->where('p.prov_id','=',$idprov)
                                ->where('p.prov_id_tipo','=',9)
                                ->where('acopio.acopio.aco_mat_prim','=',1)
                                ->where('acopio.acopio.aco_fecha_acop','LIKE','%'.$fecha.'%')
                                ->OrderBy('acopio.acopio.aco_id', 'DESC')->get();
        $brutoFilt=0;
        foreach($acopiosproveedor as $acopioprov){
            $brutoFilt = $brutoFilt + $acopioprov->prom_peso_bruto_filt;
        }
        return $brutoFilt;
    }

    public function tBrutoCentrif($idprov, $fecha){
        $acopiosproveedor = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
                                 ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id')
                                 ->select('prom.prom_peso_bruto_centrif')
                                ->where('acopio.acopio.aco_id_linea','=',3 )
                                ->where('acopio.acopio.aco_estado', '=','A')
                                ->where('acopio.acopio.aco_tipo', '=' , 2)
                                ->where('p.prov_id','=',$idprov)
                                ->where('p.prov_id_tipo','=',9)
                                ->where('acopio.acopio.aco_mat_prim','=',1)
                                ->where('acopio.acopio.aco_fecha_acop','LIKE','%'.$fecha.'%')
                                ->OrderBy('acopio.acopio.aco_id', 'DESC')->get();
        $brutoCentrif=0;
        foreach($acopiosproveedor as $acopioprov){
            $brutoCentrif = $brutoCentrif + $acopioprov->prom_peso_bruto_centrif;
        }
        return $brutoCentrif;
    }

    public function tBrutoImp($idprov, $fecha){
        $acopiosproveedor = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
                                 ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id')
                                 ->select('prom.prom_peso_bruto_imp')
                                ->where('acopio.acopio.aco_id_linea','=',3 )
                                ->where('acopio.acopio.aco_estado', '=','A')
                                ->where('acopio.acopio.aco_tipo', '=' , 2)
                                ->where('p.prov_id','=',$idprov)
                                ->where('p.prov_id_tipo','=',9)
                                ->where('acopio.acopio.aco_mat_prim','=',1)
                                ->where('acopio.acopio.aco_fecha_acop','LIKE','%'.$fecha.'%')
                                ->OrderBy('acopio.acopio.aco_id', 'DESC')->get();
        $brutoImp=0;
        foreach($acopiosproveedor as $acopioprov){
            $brutoImp = $brutoImp + $acopioprov->prom_peso_bruto_imp;
        }
        return $brutoImp;
    }

    public function tNroBaldes($idprov, $fecha){
        $acopiosproveedor = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
                                 ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id')
                                 ->select('prom.prom_cantidad_baldes')
                                ->where('acopio.acopio.aco_id_linea','=',3 )
                                ->where('acopio.acopio.aco_estado', '=','A')
                                ->where('acopio.acopio.aco_tipo', '=' , 2)
                                ->where('p.prov_id','=',$idprov)
                                ->where('p.prov_id_tipo','=',9)
                                ->where('acopio.acopio.aco_mat_prim','=',1)
                                ->where('acopio.acopio.aco_fecha_acop','LIKE','%'.$fecha.'%')
                                ->OrderBy('acopio.acopio.aco_id', 'DESC')->get();
        $nroBaldes=0;
        foreach($acopiosproveedor as $acopioprov){
            $nroBaldes = $nroBaldes + $acopioprov->prom_cantidad_baldes;
        }
        return $nroBaldes;
    }

    public function tPesoNeto($idprov, $fecha){
        $acopiosproveedor = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
                                 ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id')
                                 ->select('prom.prom_peso_neto')
                                ->where('acopio.acopio.aco_id_linea','=',3 )
                                ->where('acopio.acopio.aco_estado', '=','A')
                                ->where('acopio.acopio.aco_tipo', '=' , 2)
                                ->where('p.prov_id','=',$idprov)
                                ->where('p.prov_id_tipo','=',9)
                                ->where('acopio.acopio.aco_mat_prim','=',1)
                                ->where('acopio.acopio.aco_fecha_acop','LIKE','%'.$fecha.'%')
                                ->OrderBy('acopio.acopio.aco_id', 'DESC')->get();
        $pesoNeto=0;
        foreach($acopiosproveedor as $acopioprov){
            $pesoNeto = $pesoNeto + $acopioprov->prom_peso_neto;
        }
        return $pesoNeto;
    }

    public function reporteProduccionPlantas()
    {
        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')->where('usr_id','=',Auth::user()->usr_id)->first();
        
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        // $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('EBA');
        $pdf->SetSubject('ACOPIO MIEL');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData('logopeqe.png', PDF_HEADER_LOGO_WIDTH, "EBA - ACOPIO", "REPORTE DE ACOPIO MIEL - FONDOS EN AVANCE");

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        setlocale(LC_TIME, 'es');
        $datebus2 = new Carbon();
        $datoanio = $datebus2->format('y'); 
        $datoaniocom= $datebus2->formatLocalized('%Y');
        // set font
        $pdf->SetFont('helvetica', '', 9);

        // add a page
        $pdf->AddPage('L', 'Carta');

        $tituloTabla = 'ACOPIO MIEL - FONDOS EN AVANCE';
        // create some HTML content
        $html = '<h3 align="center">'.$tituloTabla.' - CAMPAÑA '.$datoaniocom.'</h3>
                <table border="1" cellspacing="0" cellpadding="1">
                <tr>
                    <th align="center" bgcolor="#3498DB"><strong>MESES DE ACOPIO</strong></th>
                    <th align="center" bgcolor="#3498DB"><strong>SAMUZABETY</strong></th>
                    <th align="center" bgcolor="#3498DB"><strong>SHINAHOTA</strong></th>
                    <th align="center" bgcolor="#3498DB"><strong>MONTEAGUDO</strong></th>
                    <th align="center" bgcolor="#3498DB"><strong>VILLAR</strong></th>
                    <th align="center" bgcolor="#3498DB"><strong>CAMARGO</strong></th>
                    <th align="center" bgcolor="#3498DB"><strong>IRUPANA</strong></th>
                    <th align="center" bgcolor="#3498DB"><strong>TOTAL ACOPIADO</strong></th>
                    <th align="center" bgcolor="#3498DB"><strong>COCHABAMBA</strong></th>
                    <th align="center" bgcolor="#3498DB"><strong>CHUQUISACA</strong></th>
                    <th align="center" bgcolor="#3498DB"><strong>LA PAZ</strong></th>
                </tr>
                <tr>
                    <td align="center">ENERO</td>
                    <td align="center">'.number_format($enero1=$this->totalAcoPlantas(1,$datoanio.'-01'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($enero2=$this->totalAcoPlantas(2,$datoanio.'-01'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($enero3=$this->totalAcoPlantas(3,$datoanio.'-01'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($enero4=$this->totalAcoPlantas(4,$datoanio.'-01'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($enero5=$this->totalAcoPlantas(5,$datoanio.'-01'),2,'.',',').' Kg</td>
                    <td align="center">'.number_format($enero6=$this->totalAcoPlantas(6,$datoanio.'-01'),2,'.',',').' Kg.</td>';
                    $totalplantasenero = $enero1+$enero2+$enero3+$enero4+$enero5+$enero6;
                    $html=$html.'
                    <td align="center">'.number_format($totalplantasenero,2,'.',',').' Kg.</td>';
                    $cochabamba1 = $enero1+$enero2;
                    $html=$html.'<td align="center">'.number_format($cochabamba1,2,'.',',').' Kg.</td>';
                    $chuquisacaenero = $enero3+$enero4+$enero5;
                    $html=$html.'<td align="center">'.number_format($chuquisacaenero,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($enero6=$this->totalAcoPlantas(6,$datoanio.'-01'),2,'.',',').' Kg.</td>
                </tr>
                <tr>
                    <td align="center">FEBRERO</td>
                    <td align="center">'.number_format($febrero1=$this->totalAcoPlantas(1,$datoanio.'-02'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($febrero2=$this->totalAcoPlantas(2,$datoanio.'-02'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($febrero3=$this->totalAcoPlantas(3,$datoanio.'-02'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($febrero4=$this->totalAcoPlantas(4,$datoanio.'-02'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($febrero5=$this->totalAcoPlantas(5,$datoanio.'-02'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($febrero6=$this->totalAcoPlantas(6,$datoanio.'-02'),2,'.',',').' Kg.</td>';
                    $totalplantasfebrero = $febrero1+$febrero2+$febrero3+$febrero4+$febrero5+$febrero6;
                    $html=$html.'
                    <td align="center">'.number_format($totalplantasfebrero,2,'.',',').' Kg.</td>';
                    $cochabambafeb = $febrero1+$febrero2;
                    $html=$html.'<td align="center">'.number_format($cochabambafeb,2,'.',',').' Kg.</td>';
                    $chuquisacafebrero = $febrero3+$febrero4+$febrero5;
                    $html=$html.'<td align="center">'.number_format($chuquisacafebrero,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($febrero6=$this->totalAcoPlantas(6,$datoanio.'-02'),2,'.',',').' Kg.</td>
                </tr>
                <tr>
                    <td align="center">MARZO</td>
                    <td align="center">'.number_format($marzo1=$this->totalAcoPlantas(1,$datoanio.'-03'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($marzo2=$this->totalAcoPlantas(2,$datoanio.'-03'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($marzo3=$this->totalAcoPlantas(3,$datoanio.'-03'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($marzo4=$this->totalAcoPlantas(4,$datoanio.'-03'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($marzo5=$this->totalAcoPlantas(5,$datoanio.'-03'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($marzo6=$this->totalAcoPlantas(6,$datoanio.'-03'),2,'.',',').' Kg.</td>';
                    $totalplantasmarzo = $marzo1+$marzo2+$marzo3+$marzo4+$marzo5+$marzo6;
                    $html=$html.'
                    <td align="center">'.number_format($totalplantasmarzo,2,'.',',').' Kg.</td>';
                    $cochabambamar = $marzo1+$marzo2;
                    $html=$html.'<td align="center">'.number_format($cochabambamar,2,'.',',').' Kg.</td>';
                    $chuquisacamarzo = $marzo3+$marzo4+$marzo5;
                    $html=$html.'<td align="center">'.number_format($chuquisacamarzo,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($marzo6=$this->totalAcoPlantas(6,$datoanio.'-03'),2,'.',',').' Kg.</td>
                </tr>
                <tr>
                    <td align="center">ABRIL</td>
                    <td align="center">'.number_format($abril1=$this->totalAcoPlantas(1,$datoanio.'-04'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($abril2=$this->totalAcoPlantas(2,$datoanio.'-04'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($abril3=$this->totalAcoPlantas(3,$datoanio.'-04'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($abril4=$this->totalAcoPlantas(4,$datoanio.'-04'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($abril5=$this->totalAcoPlantas(5,$datoanio.'-04'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($abril6=$this->totalAcoPlantas(6,$datoanio.'-04'),2,'.',',').' Kg.</td>';
                    $totalplantasabril = $abril1+$abril2+$abril3+$abril4+$abril5+$abril6;
                    $html=$html.'
                    <td align="center">'.number_format($totalplantasabril,2,'.',',').' Kg.</td>';
                    $cochabambaabril = $abril1+$abril2;
                    $html=$html.'<td align="center">'.number_format($cochabambaabril,2,'.',',').' Kg.</td>';
                    $chuquisacaabril = $abril3+$abril4+$abril5;
                    $html=$html.'<td align="center">'.number_format($chuquisacaabril,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($abril6=$this->totalAcoPlantas(6,$datoanio.'-04'),2,'.',',').' Kg.</td>
                </tr>
                <tr>
                    <td align="center">MAYO</td>
                    <td align="center">'.number_format($mayo1=$this->totalAcoPlantas(1,$datoanio.'-05'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($mayo2=$this->totalAcoPlantas(2,$datoanio.'-05'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($mayo3=$this->totalAcoPlantas(3,$datoanio.'-05'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($mayo4=$this->totalAcoPlantas(4,$datoanio.'-05'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($mayo5=$this->totalAcoPlantas(5,$datoanio.'-05'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($mayo6=$this->totalAcoPlantas(6,$datoanio.'-05'),2,'.',',').' Kg.</td>';
                    $totalplantasmayo = $mayo1+$mayo2+$mayo3+$mayo4+$mayo5+$mayo6;
                    $html=$html.'
                    <td align="center">'.number_format($totalplantasmayo,2,'.',',').' Kg.</td>';
                    $cochabambamayo = $mayo1+$mayo2;
                    $html=$html.'<td align="center">'.number_format($cochabambamayo,2,'.',',').' Kg.</td>';
                    $chuquisacamayo = $mayo3+$mayo4+$mayo5;
                    $html=$html.'<td align="center">'.number_format($chuquisacamayo,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($mayo6=$this->totalAcoPlantas(6,$datoanio.'-05'),2,'.',',').' Kg.</td>
                </tr>  
                <tr>
                    <td align="center">JUNIO</td>
                    <td align="center">'.number_format($junio1=$this->totalAcoPlantas(1,$datoanio.'-06'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($junio2=$this->totalAcoPlantas(2,$datoanio.'-06'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($junio3=$this->totalAcoPlantas(3,$datoanio.'-06'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($junio4=$this->totalAcoPlantas(4,$datoanio.'-06'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($junio5=$this->totalAcoPlantas(5,$datoanio.'-06'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($junio6=$this->totalAcoPlantas(6,$datoanio.'-06'),2,'.',',').' Kg.</td>';
                    $totalplantasjunio = $junio1+$junio2+$junio3+$junio4+$junio5+$junio6;
                    $html=$html.'
                    <td align="center">'.number_format($totalplantasjunio,2,'.',',').' Kg.</td>';
                    $cochabambajunio = $junio1+$junio2;
                    $html=$html.'<td align="center">'.number_format($cochabambajunio,2,'.',',').' Kg.</td>';
                    $chuquisacajunio = $junio3+$junio4+$junio5;
                    $html=$html.'<td align="center">'.number_format($chuquisacajunio,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($junio6=$this->totalAcoPlantas(6,$datoanio.'-06'),2,'.',',').' Kg.</td>
                </tr>  
                <tr>
                    <td align="center">JULIO</td>
                    <td align="center">'.number_format($julio1=$this->totalAcoPlantas(1,$datoanio.'-07'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($julio2=$this->totalAcoPlantas(2,$datoanio.'-07'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($julio3=$this->totalAcoPlantas(3,$datoanio.'-07'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($julio4=$this->totalAcoPlantas(4,$datoanio.'-07'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($julio5=$this->totalAcoPlantas(5,$datoanio.'-07'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($julio6=$this->totalAcoPlantas(6,$datoanio.'-07'),2,'.',',').' Kg.</td>';
                    $totalplantasjulio = $julio1+$julio2+$julio3+$julio4+$julio5+$julio6;
                    $html=$html.'
                    <td align="center">'.number_format($totalplantasjulio,2,'.',',').' Kg.</td>';
                    $cochabambajulio = $julio1+$julio2;
                    $html=$html.'<td align="center">'.number_format($cochabambajulio,2,'.',',').' Kg.</td>';
                    $chuquisacajulio = $julio3+$julio4+$julio5;
                    $html=$html.'<td align="center">'.number_format($chuquisacajulio,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($julio6=$this->totalAcoPlantas(6,$datoanio.'-07'),2,'.',',').' Kg.</td>
                </tr>
                <tr>
                    <td align="center">AGOSTO</td>
                    <td align="center">'.number_format($agosto1=$this->totalAcoPlantas(1,$datoanio.'-08'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($agosto2=$this->totalAcoPlantas(2,$datoanio.'-08'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($agosto3=$this->totalAcoPlantas(3,$datoanio.'-08'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($agosto4=$this->totalAcoPlantas(4,$datoanio.'-08'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($agosto5=$this->totalAcoPlantas(5,$datoanio.'-08'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($agosto6=$this->totalAcoPlantas(6,$datoanio.'-08'),2,'.',',').' Kg.</td>';
                    $totalplantasagosto = $agosto1+$agosto2+$agosto3+$agosto4+$agosto5+$agosto6;
                    $html=$html.'
                    <td align="center">'.number_format($totalplantasagosto,2,'.',',').' Kg.</td>';
                    $cochabambaagosto = $agosto1+$agosto2;
                    $html=$html.'<td align="center">'.number_format($cochabambaagosto,2,'.',',').' Kg.</td>';
                    $chuquisacaagosto = $agosto3+$agosto4+$agosto5;
                    $html=$html.'<td align="center">'.number_format($chuquisacaagosto,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($agosto6=$this->totalAcoPlantas(6,$datoanio.'-08'),2,'.',',').' Kg.</td>
                </tr>
                <tr>
                    <td align="center">SEPTIEMBRE</td>
                    <td align="center">'.number_format($septiembre1=$this->totalAcoPlantas(1,$datoanio.'-09'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($septiembre2=$this->totalAcoPlantas(2,$datoanio.'-09'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($septiembre3=$this->totalAcoPlantas(3,$datoanio.'-09'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($septiembre4=$this->totalAcoPlantas(4,$datoanio.'-09'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($septiembre5=$this->totalAcoPlantas(5,$datoanio.'-09'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($septiembre6=$this->totalAcoPlantas(6,$datoanio.'-09'),2,'.',',').' Kg.</td>';
                    $totalplantasseptiembre = $septiembre1+$septiembre2+$septiembre3+$septiembre4+$septiembre5+$septiembre6;
                    $html=$html.'
                    <td align="center">'.number_format($totalplantasseptiembre,2,'.',',').' Kg.</td>';
                    $cochabambaseptiembre = $septiembre1+$septiembre2;
                    $html=$html.'<td align="center">'.number_format($cochabambaseptiembre,2,'.',',').' Kg.</td>';
                    $chuquisacaseptiembre = $septiembre3+$septiembre4+$septiembre5;
                    $html=$html.'<td align="center">'.number_format($chuquisacaseptiembre,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($septiembre6=$this->totalAcoPlantas(6,$datoanio.'-09'),2,'.',',').' Kg.</td>
                </tr>  
                <tr>
                    <td align="center">OCTUBRE</td>
                    <td align="center">'.number_format($octubre1=$this->totalAcoPlantas(1,$datoanio.'-10'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($octubre2=$this->totalAcoPlantas(2,$datoanio.'-10'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($octubre3=$this->totalAcoPlantas(3,$datoanio.'-10'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($octubre4=$this->totalAcoPlantas(4,$datoanio.'-10'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($octubre5=$this->totalAcoPlantas(5,$datoanio.'-10'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($octubre6=$this->totalAcoPlantas(6,$datoanio.'-10'),2,'.',',').' Kg.</td>';
                    $totalplantasoctubre = $octubre1+$octubre2+$octubre3+$octubre4+$octubre5+$octubre6;
                    $html=$html.
                    '<td align="center">'.number_format($totalplantasoctubre,2,'.',',').' Kg.</td>';
                    $cochabambaoctubre = $octubre1+$octubre2;
                    $html=$html.'<td align="center">'.number_format($cochabambaoctubre,2,'.',',').' Kg.</td>';
                    $chuquisacaoctubre = $octubre3+$octubre4+$octubre5;
                    $html=$html.'<td align="center">'.number_format($chuquisacaoctubre,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($octubre6=$this->totalAcoPlantas(6,$datoanio.'-10'),2,'.',',').' Kg.</td>
                </tr>  
                <tr>
                    <td align="center">NOVIEMBRE</td>
                    <td align="center">'.number_format($noviembre1=$this->totalAcoPlantas(1,$datoanio.'-11'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($noviembre2=$this->totalAcoPlantas(2,$datoanio.'-11'),2,'.',',').' Kg</td>
                    <td align="center">'.number_format($noviembre3=$this->totalAcoPlantas(3,$datoanio.'-11'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($noviembre4=$this->totalAcoPlantas(4,$datoanio.'-11'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($noviembre5=$this->totalAcoPlantas(5,$datoanio.'-11'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($noviembre6=$this->totalAcoPlantas(6,$datoanio.'-11'),2,'.',',').' Kg.</td>';
                    $totalplantasnoviembre = $noviembre1+$noviembre2+$noviembre3+$noviembre4+$noviembre5+$noviembre6;
                    $html=$html.
                    '<td align="center">'.number_format($totalplantasnoviembre,2,'.',',').' Kg.</td>';
                    $cochabambanoviembre = $noviembre1+$noviembre2;
                    $html=$html.'<td align="center">'.number_format($cochabambanoviembre,2,'.',',').' Kg.</td>';
                    $chuquisacanoviembre = $noviembre3+$noviembre4+$noviembre5;
                    $html=$html.'<td align="center">'.number_format($chuquisacanoviembre,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($noviembre6=$this->totalAcoPlantas(6,$datoanio.'-11'),2,'.',',').' Kg.</td>
                </tr>
                <tr>
                    <td align="center">DICIEMBRE</td>
                    <td align="center">'.number_format($diciembre1=$this->totalAcoPlantas(1,$datoanio.'-12'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($diciembre2=$this->totalAcoPlantas(2,$datoanio.'-12'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($diciembre3=$this->totalAcoPlantas(3,$datoanio.'-12'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($diciembre4=$this->totalAcoPlantas(4,$datoanio.'-12'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($diciembre5=$this->totalAcoPlantas(5,$datoanio.'-12'),2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($diciembre6=$this->totalAcoPlantas(6,$datoanio.'-12'),2,'.',',').' Kg.</td>';
                    $totalplantasdiciembre = $diciembre1+$diciembre2+$diciembre3+$diciembre4+$diciembre5+$diciembre6;
                    $html=$html.
                    '<td align="center">'.number_format($totalplantasdiciembre,2,'.',',').' Kg.</td>';
                    $cochabambadiciembre = $diciembre1+$diciembre2;
                    $html=$html.'<td align="center">'.number_format($cochabambadiciembre,2,'.',',').' Kg.</td>';
                    $chuquisacadiciembre = $diciembre3+$diciembre4+$diciembre5;
                    $html=$html.'<td align="center">'.number_format($chuquisacadiciembre,2,'.',',').' Kg.</td>
                    <td align="center">'.number_format($diciembre6=$this->totalAcoPlantas(6,$datoanio.'-12'),2,'.',',').' Kg.</td>
                </tr>

                <tr>
                    <td align="center"><strong>TOTAL (Kg.)</strong></td>';
                    $totalsamuzabety = $enero1+$febrero1+$marzo1+$abril1+$mayo1+$junio1+$julio1+$agosto1+$septiembre1+$octubre1+$noviembre1+$diciembre1;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totalsamuzabety,2,'.',',').' Kg.</strong></td>';
                    $totalshinahota = $enero2+$febrero2+$marzo2+$abril2+$mayo2+$junio2+$julio2+$agosto2+$septiembre2+$octubre2+$noviembre2+$diciembre2;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totalshinahota,2,'.',',').' Kg.</strong></td>';
                    $totalmoonteagudo = $enero3+$febrero3+$marzo3+$abril3+$mayo3+$junio3+$julio3+$agosto3+$septiembre3+$octubre3+$noviembre3+$diciembre3;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totalmoonteagudo,2,'.',',').' Kg.</strong></td>';
                    $totalvillar = $enero4+$febrero4+$marzo4+$abril4+$mayo4+$junio4+$julio4+$agosto4+$septiembre4+$octubre4+$noviembre4+$diciembre4;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totalvillar,2,'.',',').' Kg.</strong></td>';
                    $totalcamargo = $enero5+$febrero5+$marzo5+$abril5+$mayo5+$junio5+$julio5+$agosto5+$septiembre5+$octubre5+$noviembre5+$diciembre5;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totalcamargo,2,'.',',').' Kg.</strong></td>';
                    $totalirupana = $enero6+$febrero6+$marzo6+$abril6+$mayo6+$junio6+$julio6+$agosto6+$septiembre6+$octubre6+$noviembre6+$diciembre6;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totalirupana,2,'.',',').' Kg.</strong></td>';
                    $totalacopiado = $totalplantasenero+$totalplantasfebrero+$totalplantasmarzo+$totalplantasabril+$totalplantasmayo+$totalplantasjunio+$totalplantasjulio+$totalplantasagosto+$totalplantasseptiembre+$totalplantasoctubre+$totalplantasnoviembre+$totalplantasdiciembre;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totalacopiado,2,'.',',').' Kg.</strong></td>';
                    $totalacopiadocochabamba = $cochabamba1+$cochabambafeb+$cochabambamar+$cochabambaabril+$cochabambamayo+$cochabambajunio+$cochabambajulio+$cochabambaagosto+$cochabambaseptiembre+$cochabambaoctubre+$cochabambanoviembre+$cochabambadiciembre;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totalacopiadocochabamba,2,'.',',').' Kg.</strong></td>';
                    $totalacopiadochuquisaca = $chuquisacaenero+$chuquisacafebrero+$chuquisacamarzo+$chuquisacaabril+$chuquisacamayo+$chuquisacajunio+$chuquisacajulio+$chuquisacaagosto+$chuquisacaseptiembre+$chuquisacaoctubre+$chuquisacanoviembre+$chuquisacadiciembre;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totalacopiadochuquisaca,2,'.',',').' Kg.</strong></td>';
                    $totalacopiadolapaz = $enero6+$febrero6+$marzo6+$abril6+$mayo6+$junio6+$julio6+$agosto6+$septiembre6+$octubre6+$noviembre6+$diciembre6;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totalacopiadolapaz,2,'.',',').' Kg.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>TOTAL (Tn.)</strong></td>';
                    $totaltnsamuzabety = $totalsamuzabety/1000;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totaltnsamuzabety,2,'.',',').' Tn.</strong></td>';
                    $totaltnshinahota = $totalshinahota/1000;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totaltnshinahota,2,'.',',').' Tn.</strong></td>';
                    $totaltnmonteagudo = $totalmoonteagudo/1000;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totaltnmonteagudo,2,'.',',').' Tn.</strong></td>';
                    $totaltnvillar = $totalvillar/1000;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totaltnvillar,2,'.',',').' Tn.</strong></td>';
                    $totaltncamargo = $totalcamargo/1000;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totaltncamargo,2,'.',',').' Tn.</strong></td>';
                    $totaltnirupana = $totalirupana/1000;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totaltnirupana,2,'.',',').' Tn.</strong></td>';
                    $totaltnacopiado = $totalacopiado/1000;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totaltnacopiado,2,'.',',').' Tn.</strong></td>';
                    $totaltnacopiadocochabamba = $totalacopiadocochabamba/1000;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totaltnacopiadocochabamba,2,'.',',').' Tn.</strong></td>';
                    $totaltnacopiadochuquisaca = $totalacopiadochuquisaca/1000;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totaltnacopiadochuquisaca,2,'.',',').' Tn.</strong></td>';
                    $totaltnacopiadolapaz = $totalacopiadolapaz/1000;
                    $html=$html.'
                    <td align="center"><strong>'.number_format($totaltnacopiadolapaz,2,'.',',').' Tn.</strong></td>
                </tr>                           
            </table>';

                 $html=$html.'
                            

                            <br>  <br>  <br>  <br> <br> <br> <br> <br>
                            <table>
                            <tr>
                                <td align="center">___________________________</td>
                            </tr>
                            <tr>
                                <td align="center">Responsable de Acopio Nacional</td>
                            </tr>
                            <tr>
                                
                                
                                <td align="center">'.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</td>
                            </tr>
                            
                            
                            </table>
                            
                        ';
        // output the HTML content
        $pdf->writeHTML($html, true, 0, true, 0);

        // reset pointer to the last page
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Acopio_Miel_Fondos_Avance.pdf', 'I');

    }

    public function totalAcoPlantas($iddestino, $fecha){
        $acopiostotal = Acopio::join('acopio.destino as d','acopio.acopio.aco_id_destino', '=', 'd.des_id')
                                 ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id')
                                 ->select('acopio.acopio.aco_id','acopio.aco_fecha_acop','prom.prom_total','prom.prom_peso_bruto','prom.prom_peso_neto','acopio.acopio.aco_mat_prim')
                                ->where('acopio.acopio.aco_id_linea','=',3 )
                                ->where('acopio.acopio.aco_estado', '=','A')
                                ->where('acopio.acopio.aco_tipo', '=' , 2)
                                ->where('d.des_id','=',$iddestino)
                                ->where('acopio.acopio.aco_mat_prim','=',1)
                                ->where('acopio.acopio.aco_fecha_acop','LIKE','%'.$fecha.'%')
                                ->OrderBy('acopio.acopio.aco_id', 'DESC')->get();
        $pesoNeto=0;
        foreach($acopiostotal as $acopio){
            $pesoNeto = $pesoNeto + $acopio->prom_peso_neto;
        }
        return $pesoNeto;
    }
}
