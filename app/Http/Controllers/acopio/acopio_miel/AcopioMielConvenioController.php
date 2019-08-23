<?php

namespace siga\Http\Controllers\acopio\acopio_miel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use siga\Http\Requests;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_miel\Acopio;
use siga\Modelo\acopio\acopio_miel\Proveedor;
use siga\Modelo\acopio\acopio_miel\Propiedades_Miel;
use siga\Modelo\acopio\acopio_miel\Contrato;
use siga\Modelo\acopio\acopio_miel\Pagos;
use siga\Modelo\admin\Usuario;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Auth;
use TCPDF;
USE PDF;

class AcopioMielConvenioController extends Controller
{
    public function index(){
        $acopio = Acopio::getListarConvenio();
        $unidad = DB::table('acopio.unidad')->OrderBy('uni_id', 'desc')->pluck('uni_nombre','uni_id');
        $destino = DB::table('acopio.destino')->OrderBy('des_id','desc')->pluck('des_descripcion', 'des_id');
        $proveedor = Proveedor::OrderBy('prov_id', 'desc')->pluck('prov_nombre', 'prov_id');
        $resp_recep = DB::table('acopio.resp_recep')->OrderBy('rec_id','desc')->pluck('rec_nombre','rec_id');
        return view('backend.administracion.acopio.acopio_miel.acopio.indexConvenio', compact('acopio', 'proveedor','unidad','destino','resp_recep'));
    }

    public function create()
    {
        $acopio = Acopio::getListarConvenio();
        return Datatables::of($acopio)->addColumn('acciones', function ($acopio) {
            return '<div class="text-center"><a href="/AcopioMielConvenio/boleta/' . $acopio->aco_id . '" class="btn btn-md btn-primary" target="_blank">Boleta <i class="fa fa-file"></i></a></div>';
        })
            ->editColumn('id', 'ID: {{$aco_id}}')->
            addColumn('nombreCompleto', function ($nombres) {
                return $nombres->prov_nombre.' '.$nombres->prov_ap.' '.$nombres->prov_am;
        })
            ->editColumn('id', 'ID: {{$aco_id}}')
            ->make(true);
    }

    public function store(Request $request)
    {   
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
        $this->validate(request(), [
                'proveedor' => 'required',
                'fecha_acopio' => 'required',
                'fecha_registro' => 'required',
                'peso_bruto_convenio' => 'required',
                'contrato' => 'required',
                'tipo_materia_prima' => 'required',               
        ]);         
        $prom = Propiedades_Miel::create([
            'prom_peso_bruto'           =>$request['peso_bruto_convenio'],
            'prom_peso_tara'            =>$request['peso_taraConv'],
            'prom_peso_neto'            =>$request['peso_netoConv'],
            'prom_cantidad_baldes'      =>0,
            'prom_total'                =>$request['valorTotalConv'],
            'prom_cod_colmenas'         =>0,
            'prom_centrifugado'         =>0,
            'prom_peso_bruto_centrif'   =>0,
            'prom_peso_bruto_filt'      =>0,
            'prom_peso_bruto_imp'       =>0,
            'prom_humedad'              =>0,
            'prom_cos_un'               =>$request['precio_matp'],
            'prom_total_marcos'         =>0,
            'prom_colmenas'             =>0,   
        ]);
        $prom_id = $prom->prom_id;
        $acopio = Acopio::create([
            'aco_id_prov'       => $request['proveedor'],//MIEL//
            'aco_id_proc'       => 1,//MIEL//
            'aco_centro'        => null,//MIEL//
            'aco_peso_neto'     => null,//          
            'aco_id_tipo_cas'   => 1,//
            'aco_numaco'        => $request['nroAcopioConv'],//
            'aco_num_act'       => 1,//MIEL//
            'aco_unidad'        => 1,//
            'aco_cantidad'      => null,//MIEL//
            'aco_cos_un'        => null,//MIEL//
            'aco_cos_total'     => null,//MIEL//
            'aco_con_hig'       => null,//
            'aco_fecha_acop'    => $request['fecha_acopio'],//
            'aco_fecha_reg'     => "2018-10-01 16:00:00",//MIEL//
            'aco_obs'           => null,//MIEL//
            'aco_estado'        => 'A',//MIEL//
            'aco_tram'          => "2018-10-01 16:00:00",//
            'aco_num_rec'       => null,//MIEL//
            'aco_id_comunidad'  => null,//
            'aco_id_recep'      => 1,//MIEL//
            'aco_id_linea'      => 3,//MIEL//
            'aco_pago'          => 1,//MIEL//
            'aco_fecha_rec'     => "2018-10-01 16:00:00",//MIEL//
            'aco_id_destino'    => 1,//MIEL//
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
            'aco_tipo'          => 1,
            'aco_mat_prim'      => null,
            'aco_latitud'       => null,
            'aco_longitud'      => null,
            'aco_nro_boleta'    => $request['nroBoletaConv'],
            'aco_tipo_matp'     => $request['tipo_materia_prima'],
            'aco_id_planta'     => $planta->id_planta
        ]); 
        $acopio_id = $acopio->aco_id;
        // $contrato = Contrato::find(1);
        $contrato = Contrato::where('contrato_id','=',$request['contrato'])->first();
        // $contrato->contrato_deuda= $request['deudaContratoActual'];
        $contrato->contrato_saldo= $request['saldoActual'];
        $contrato->save();
        $id_contrato = $contrato->contrato_id;
        Pagos::create([
            'pago_amortizacion'   => 0,
            'pago_amortizacionbs' => null,
            'pago_t_men_amort'    => null,
            'pago_rau_iue'        => $request['rau_iue'],
            'pago_rau_it'         => $request['rau_ti'],
            'pago_liquido_pag'    => $request['liq_pagable'],
            'pago_saldo_deuda'    => $request['deudaContratoActual'],
            'pago_id_contrato'    => $id_contrato,
            'pago_id_aco'         => $acopio_id,
            'pago_cuota'          => $request['cuota'],
            'pago_cuota_pago'     => $request['pago'],
            'pago_cuota_saldo'    => $request['saldo'],
        ]);

        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function boleta($id){
       $acopio = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
                        ->join('acopio.municipio as mun', 'p.prov_id_municipio','=','mun.mun_id')
                        ->join('acopio.comunidad as com', 'p.prov_id_comunidad','=','com.com_id')
                        ->join('acopio.asociacion as aso', 'p.prov_id_asociacion', '=', 'aso.aso_id')
                        ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id') 
                        ->join('acopio.pagos as pago','acopio.acopio.aco_id','pago.pago_id_aco')                        
                        ->select('mun.mun_nombre','com.com_nombre','aso.aso_nombre','acopio.acopio.aco_id','acopio.acopio.aco_id_prov','p.prov_id','p.prov_nombre', 'p.prov_ap','p.prov_am','p.prov_ci', 'acopio.acopio.aco_num_act', 'acopio.acopio.aco_fecha_acop','prom.prom_total_marcos','prom.prom_cantidad_baldes','prom.prom_peso_bruto','prom.prom_peso_neto','prom.prom_centrifugado','prom.prom_peso_bruto_filt','prom_peso_bruto_centrif','prom.prom_peso_bruto_imp','prom.prom_colmenas','acopio.acopio.aco_mat_prim','prom.prom_total','acopio.aco_nro_boleta','pago.pago_rau_iue','pago.pago_rau_it','pago.pago_liquido_pag','aco_tipo_matp','prom.prom_cos_un')
                        ->where('acopio.acopio.aco_id_linea','=',3 )
                        ->where('acopio.acopio.aco_estado', '=','A')
                        ->where('acopio.acopio.aco_tipo', '=' , 1)
                        ->where('acopio.acopio.aco_id','=',$id)
                        ->OrderBy('acopio.acopio.aco_id', 'DESC')
                ->first();
        // dd($acopio);       
        
        
        $contrato = Contrato::join('acopio.pagos as pag','acopio.contrato.contrato_id','=','pag.pago_id_contrato')->
                    where('pag.pago_id_aco','<=',$acopio->aco_id)->where('contrato_id_prov','=',$acopio->aco_id_prov)->OrderBy('pag.pago_id_aco','DESC')->get();
        // dd($contrato);
        $totaldeuda = Pagos::join('acopio.contrato as contra','acopio.pagos.pago_id_contrato','=','contra.contrato_id')
                        ->join('acopio.acopio as aco','acopio.pagos.pago_id_aco','=','aco.aco_id')
                        ->select('contra.contrato_id', DB::raw('SUM(pago_liquido_pag) as totalpago'))//SE CAMBIO pago_cuota_pago por pago_liquido_pag
                        ->where('contrato_id','=',$contrato[0]->contrato_id)
                        ->where('aco_estado','=','A')
                        ->where('pagos.pago_id_aco','<=',$acopio->aco_id)
                        ->groupBy('contra.contrato_id')->first();
        //dd($totaldeuda); 
        $contrato1 = Contrato::join('acopio.pagos as pag','acopio.contrato.contrato_id','=','pag.pago_id_contrato')
                    ->join('acopio.acopio as aco','pag.pago_id_aco','=','aco.aco_id')
                    ->where('aco.aco_estado','=','A')
                    ->where('pag.pago_id_aco','<=',$acopio->aco_id)
                    // ->where('contrato_id_prov','=',$acopio->aco_id_prov)
                    ->where('contrato_id','=',$contrato[0]->contrato_id)
                    ->OrderBy('pag.pago_id_aco','ASC')->get();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('BOLETA MIEL CONVENIO');
        $pdf->SetSubject('TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        $pdf->AddPage('P','carta');

        
        // create some HTML content        
        setlocale(LC_TIME, 'es');
        $datebus = new Carbon();
        // $dato= $datebus->formatLocalized($solicitud[0]->sol_fecha_reg);
        // $datoexacto = $datebus->format('d-m-Y'); 
        $deudaactual = $contrato[0]->contrato_precio - $totaldeuda->totalpago;
        // dd($deudaactual);
        // $rau_iue = $acopio->prom_total*5/100;
        // $rau_ti = $acopio->prom_total*3/100;
        // $liquido_paga = $acopio->prom_total - $rau_iue -$rau_ti;
        $html = '
                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th  align="center" width="130"><img src="/img/logopeqe.png" width="120" height="45"></th>
                            <th  align="center" width="275"><strong>BOLETA DEL PRODUCTOR <br>'.strtoupper($acopio->prov_nombre.' '.$acopio->prov_ap.' '.$acopio->prov_am).'</strong>
                            </th>
                            <th align="center" width="130"><strong>No. Boleta:<br>'.$acopio->aco_nro_boleta.'</strong></th>
                        </tr>
                        
                    </table>
                    <h3 align="center">INFORMACION DEL PAGO</h3> 
                 
                    <h4 align="center" bgcolor="#E8E8E8">DATOS DEL PRODUCTOR</h4>
                    <table>
                        <tr>
                            <th><strong>PRODUCTOR:</strong></th>
                            <th>'.strtoupper($acopio->prov_nombre.' '.$acopio->prov_ap.' '.$acopio->prov_am).'</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th><strong>CI:</strong></th>
                            <th>'.$acopio->prov_ci.'</th>
                        </tr>   
                        <tr>
                            <th><strong>Central:</strong></th>
                            <th>'.$acopio->com_nombre.'</th>
                        </tr>
                        <tr>
                            <th><strong>MUNICIPIO:</strong></th>
                            <th>'.$acopio->mun_nombre.'</th>
                        </tr>
                    </table>

                    <h4 align="center" bgcolor="#E8E8E8">DATOS DEL CONTRATO</h4>
                    <table>
                        <tr>
                            <th><strong>NRO. CONTRATO:</strong></th>
                            <th>'.$contrato[0]->contrato_nro.'</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th><strong>PRECIO CONTRATO:</strong></th>
                            <th>'.number_format($contrato[0]->contrato_precio,2,'.',',').'</th>
                            <th><strong>SALDO DEUDA:</strong> '.number_format($deudaactual,2,'.',',').'</th>
                        </tr>   
                    </table>
                    <h4 align="center" bgcolor="#E8E8E8">DATOS DEL ACOPIO</h4>
                    <table>
                        <tr>
                            <th><strong>MATERIA PRIMA:</strong></th>
                            <th>'.$this->materiaPrima($acopio->aco_tipo_matp).'</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th><strong>PRECIO UNITARIO:</strong></th>
                            <th>'.$acopio->prom_cos_un.' Bs.</th>
                        </tr>                        
                        <tr>
                            <th><strong>PESO NETO:</strong></th>
                            <th>'.$acopio->prom_peso_neto.'</th>
                        </tr>
                        <tr>
                            <th><strong>VALOR TOTAL:</strong></th>
                            <th>'.number_format($acopio->prom_total,2,'.',',').'</th>
                        </tr>
                        <tr>
                            <th><strong>RAU-IUE (5%):</strong></th>
                            <th>'.number_format($acopio->pago_rau_iue,2,'.',',').'</th>
                        </tr>
                        <tr>
                            <th><strong>RAU-TI (3%):</strong></th>
                            <th>'.number_format($acopio->pago_rau_it,2,'.',',').'</th>
                        </tr>
                        <tr>
                            <th><strong>LIQUIDO PAGABLE:</strong></th>
                            <th>'.number_format($acopio->pago_liquido_pag,2,'.',',').'</th>
                        </tr>              
                    </table>

                    <h4 align="center" bgcolor="#E8E8E8">DATOS DEL PAGO</h4>
                    <table border="1" cellspacing="0" cellpadding="1" style="font-size:8px">
                    ';

                    $html = $html.'<tr  bgcolor="#0067B4" color="white">
                                    <th align="center"><strong>FECHA</strong></th>
                                    <th align="center"><strong>MATERIA PRIMA</strong></th>
                                    <th align="center"><strong>No. CUOTA</strong></th>
                                    <th align="center"><strong>VALOR TOTAL</strong></th>
                                    <th align="center"><strong>RAU-IUE</strong></th>
                                    <th align="center"><strong>RAU-IT</strong></th>
                                    <th align="center"><strong>LIQUIDO AMORTIZABLE</strong></th>
                                    <th align="center"><strong>SALDO</strong></th>
                            </tr>';
                    $nro=0;
                    $cuota = $contrato[0]->contrato_deuda;
                    // $saldo = $contrato[0]->contrato_deuda - $contrato1[0]->pago_cuota_pago;
                    // $pagocuota = $contrato1[0]->pago_cuota_pago;
                    $saldo = $contrato[0]->contrato_deuda - $contrato1[0]->pago_liquido_pag;
                    $pagocuota = $contrato1[0]->pago_liquido_pag; 
                    foreach ($contrato1 as $pago1){ 
                        $nro = $nro + 1;
                        // $pagocuota = $pago1->pago_cuota_pago;
                        // $saldo = $cuota - $pago1->pago_cuota_pago;
                        $pagocuota = $pago1->pago_liquido_pag;
                        $saldo = $cuota - $pago1->pago_liquido_pag;

                        $fecha = Carbon::parse($pago1->aco_fecha_acop);
                        $mfecha = $fecha->month;
                        $dfecha = $fecha->day;
                        $afecha = $fecha->year; 
                        $html = $html . '
                        <tr>
                            <th align="center">'.$afecha.'-'.$mfecha.'-'.$dfecha.'</th>
                            <th align="center">'.$this->materiaPrima($pago1->aco_tipo_matp).'</th>                            
                            <th align="center">'.$nro.'</th>                            
                            <th align="center">'.number_format($pago1->pago_cuota_pago,2,'.',',').'</th>                   
                            <th align="center">'.number_format($pago1->pago_rau_iue,2,'.',',').'</th>                            
                            <th align="center">'.number_format($pago1->pago_rau_it,2,'.',',').'</th>                            
                            <th align="center">'.number_format($pago1->pago_liquido_pag,2,'.',',').'</th>                            
                            <th align="center">'.number_format($saldo,2,'.',',').'</th>                      
                        </tr>
                        
                        ';
                        $cuota = $saldo+$contrato[0]->contrato_deuda;
                    }
                    $html = $html . ' 
                                  
                    </table>
             
                    ';





    
        $pdf->writeHTML($html, true, 0, true, true);
        $pdf->Output('boleta_pagos.pdf', 'I');
    }
    function materiaPrima($materia_prima)
    {
        if ($materia_prima == 1) {
            return 'MIEL';
        }elseif($materia_prima == 2){
            return 'POLEN';
        }elseif($materia_prima == 3){
            return 'PROPOLEO';
        }elseif($materia_prima == 4){
            return 'CERA';
        }elseif($materia_prima == 5){
            return 'PANALES';
        }
    }
    public function boletaPDF($id)
    {
        PDF::AddPage();

           PDF::SetFont('helvetica','B',12);
           PDF::Ln(5); 
           PDF::Cell(45,0,'',0,1,'C');
           PDF::Cell(45,20,PDF::Image('img/logopeqe.png',23,22,'R',15),1,0,'C');

           PDF::MultiCell(95, 20, '', 1, 0, 0, 'L');
           PDF::SetXY(60, 20);
           PDF::Cell(95,10,utf8_decode('RECIBO DE CAJA EGRESO'),0,1,'C',0);
           PDF::SetXY(60, 30);
           PDF::Cell(95,10,utf8_decode('POR COMPRA DE ALMENDRA'),0,1,'C',0);

           PDF::SetFont('helvetica','B',9);
           PDF::SetXY(150, 20);
           PDF::Cell(45,10,utf8_decode('Serie: A - Riberalta'),1,1,'C',0);
           PDF::SetXY(150, 30);
           PDF::writeHTML('', PDF::Cell(45,10,'Nº 132',1,1,'C',0), true, true, false, '');

           PDF::SetFont('helvetica','B',10);

           PDF::Ln(5); 
           PDF::Cell(5,6,'',0,0,'C');
           PDF::Ln(10);
        
         //LUGAR DE COMPRA
            switch ('1') {
                case '1':
                  PDF::SetXY(45, 51);
                  PDF::Cell(15,8,'X',1,0,'C');
                    break;
                case '2':
                  PDF::SetXY(45, 61);
                  PDF::Cell(15,8,'X',1,0,'C');
                    break;
                case '3':
                 PDF::SetXY(45, 71);
                 PDF::Cell(15,8,'X',1,0,'C');
                    break;
                default:
                    # code...
                    break;
            }

            PDF::SetFont('helvetica','B',9);
            PDF::SetXY(15, 51);
            PDF::Cell(30,8,utf8_decode('Centro de Acopio'),1,1,'C',0);
            PDF::SetXY(45, 51);
            PDF::Cell(15,8,'',1,0,'C');

            PDF::SetXY(15, 61);
            PDF::Cell(30,8,utf8_decode('Payol'),1,1,'C',0);
            PDF::SetXY(45, 61);
            PDF::Cell(15,8,'',1,0,'C');

            PDF::SetXY(15, 71);
            PDF::Cell(30,8,utf8_decode('Fabrica'),1,1,'C',0);
            PDF::SetXY(45, 71);
            PDF::Cell(15,8,'',1,0,'C');
            
            PDF::SetXY(65, 51);
            PDF::Cell(25, 8, utf8_decode('C. Campesina'), 1,1,'C',0);
            PDF::SetXY(90, 51);
            PDF::Cell(15,8,'',1,0,'C');

            PDF::SetXY(65, 61);
            PDF::Cell(25, 8, utf8_decode('C. Indigena'), 1,1,'C',0);
            PDF::SetXY(90, 61);
            PDF::MultiCell(15, 8, '', 1, 'C');

            PDF::SetXY(65, 71);
            PDF::Cell(25, 8, utf8_decode('Asoc. AOECOM'), 1,1,'C',0);
            PDF::SetXY(90, 71);
            PDF::MultiCell(15, 8, '', 1, 'C');

            PDF::SetXY(110, 51);
            PDF::Cell(25, 8, utf8_decode('Asoc Barraq.'), 1,1,'C',0);
            PDF::SetXY(135, 51);
            PDF::Cell(15,8,'',1,0,'C');

            PDF::SetXY(110, 61);
            PDF::Cell(25, 8, utf8_decode('Rec. e Interna'), 1,1,'C',0);
            PDF::SetXY(135, 61);
            PDF::Cell(15,8,'',1,0,'C');

            PDF::SetXY(110, 71);
            PDF::Cell(25, 8, utf8_decode('Prop. Privada'), 1,1,'C',0);
            PDF::SetXY(135, 71);
            PDF::Cell(15,8,'',1,0,'C');

            switch ('1') {
                case '4':
                    PDF::SetXY(65, 51);
                    PDF::Cell(25,8,'',1,0,'C',0);
                    PDF::SetXY(90, 51);
                    PDF::Cell(15,8,'X',1,0,'C',0);
                    break;
                case '5':
                    PDF::SetXY(65, 61);
                    PDF::Cell(25,8,'',1,0,'C',0);
                    PDF::SetXY(90, 61);
                    PDF::Cell(15,8,'X',1,0,'C',0);
                    break;
                case '1':
                    PDF::SetXY(65, 71);
                    PDF::Cell(25,8,'',1,0,'C',0);
                    PDF::SetXY(90, 71);
                    PDF::Cell(15,8,'X',1,0,'C',0);
                break;
                case '3':
                    PDF::SetXY(110, 51);
                    PDF::Cell(25,8,'',1,0,'C',0);
                    PDF::SetXY(135, 51);
                    PDF::Cell(15,8,'X',1,0,'C',0);
                break;
                case '2':
                    PDF::SetXY(110, 61);
                    PDF::Cell(25,8,'',1,0,'C',0);
                    PDF::SetXY(135, 61);
                    PDF::Cell(15,8,'X',1,0,'C',0);
                break;
                case '6':
                    PDF::SetXY(110, 71);
                    PDF::Cell(25,8,'',1,0,'C',0);
                    PDF::SetXY(135, 71);
                    PDF::Cell(15,8,'X',1,0,'C',0);
                break;
                default:
                    # code...
                    break;
            }

            PDF::SetXY(155, 51);
            PDF::Cell(25, 8, utf8_decode('Total Recibido'), 1,1,'C',0);
            PDF::SetFont('helvetica','B',7);
            PDF::SetXY(180, 51);

            PDF::Cell(15,8,number_format('12',2,'.',','),1,0,'C');
            PDF::SetFont('helvetica','B',7);
            PDF::SetXY(155, 61);
            PDF::Cell(25, 8, utf8_decode('Menos Impto. 3,25%'), 1,1,'C',0);
            PDF::SetXY(180, 61);
            PDF::Cell(15,8,number_format('12',2,'.',','),1,0,'C'); 
            PDF::SetFont('helvetica','B',9);
            PDF::SetXY(155, 71);
            PDF::Cell(25, 8, utf8_decode('Importe Neto'), 1,1,'C',0);
            PDF::SetXY(180, 71);
            PDF::writeHTML('',PDF::Cell(15,8,'244',1,0,'C'), true, true, false, '');
           // $pdf->Cell(15,8,$totimp,1,0,'C'); 

            PDF::SetXY(15, 101);
            PDF::Cell(49,7,'Hemos cancelado al Sr. (a):',0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(131,7,'12315',0,1,'L',0), true, true, false, '');
           // $pdf->Cell(131,7,'',0,1,'L',0);

            PDF::SetXY(15, 111);
            PDF::Cell(30,8,'De la Comunidad:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::writeHTML('',PDF::Cell(131,7,'dffd',0,1,'L',0), true, true, false, '');
            //$pdf->MultiCell(55, 8, 'BUEN DESTINO',0,1, 0, 'J');
            PDF::SetFont('helvetica','B',8);

            PDF::SetXY(100, 111);
            PDF::Cell(15,8,'Convenio',1,1,'C',0);

            PDF::SetXY(115, 111);
            PDF::Cell(10,4,'SI',1,1,'C',0);
            PDF::SetXY(115, 115);
            PDF::Cell(10,4,'NO',1,1,'C',0);

            PDF::SetXY(135, 111);
            PDF::Cell(15,8,'Municipio',0,0,'C',0);
            PDF::SetFont('helvetica','',8);
            PDF::MultiCell(45, 8,'hola', 0, 1, 0, 'J');
            PDF::SetFont('helvetica','B',9);

             switch ('SI') {
                case 'NO':
                    PDF::SetXY(125, 111);
                    PDF::Cell(10,4,'',1,1,'C',0);
                    PDF::SetXY(125, 115);
                    PDF::Cell(10,4,'X',1,0,'C',0);
                    break;
                case 'SI':
                    PDF::SetXY(125, 111);
                    PDF::Cell(10,4,'X',1,1,'C',0);
                    PDF::SetXY(125, 115);
                    PDF::Cell(10,4,'',1,0,'C',0);
                    break;
                default:
                    # code...
                    break;
            }

            PDF::SetXY(15, 121);
            PDF::Cell(30,8,'La Suma de:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetFont('helvetica','B',8);
            PDF::MultiCell(130, 8,'prueba',0,1, 0, 'C');

            PDF::SetXY(175, 121);
            PDF::Cell(20,8,'',0,1,'R',0);

            PDF::SetXY(15, 131);
            PDF::Cell(40,8,'Por Concepto de Compra de:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::writeHTML('',PDF::Cell(131,7,'fsadf',0,1,'L',0), true, true, false, '');
            //$pdf->MultiCell(20, 8, '',0,1, 0, 'J');
            PDF::SetFont('helvetica','B',8);

            PDF::SetXY(75, 131);
            PDF::Cell(27,8,'Cajas de Almendra',0,0,'L',0);

            PDF::SetXY(102, 131);
            PDF::Cell(10,4,'C',1,1,'C',0);
            PDF::SetXY(102, 135);
            PDF::Cell(10,4,'O',1,1,'C',0);

            PDF::SetXY(122, 131);
            PDF::Cell(25,8,utf8_decode('en cascara, a Bs.'),0,0,'C',0);
            PDF::SetFont('helvetica','',8);
            PDF::writeHTML('',PDF::Cell(18,8,'fsad',0,1,'L',0), true, true, false, '');
            //PDF::MultiCell(18, 8,'2', 0, 1, 0, 'J');
            PDF::SetFont('helvetica','B',9);
            PDF::SetXY(162, 131);
            PDF::Cell(15,8,utf8_decode('c/caja de,'),0,0,'C',0);
            PDF::SetFont('helvetica','',7);
            PDF::SetXY(177, 131);
           //  $pdf->writeHTML('',$pdf->Cell(131,7,$boleta['aco_cos_un'],0,1,'L',0), true, true, false, '');
            PDF::Cell(18,8,'fsa'.' '.utf8_decode('kilos'),0,0,'C',0);

            switch ('1') {
                case '1':
                    PDF::SetXY(112, 131);
                    PDF::Cell(10,4,'',1,0,'C',0);
                    PDF::SetXY(112, 135);
                    PDF::Cell(10,4,'X',1,0,'C',0);
                    break;
                case '2':
                    PDF::SetXY(112, 131);
                    PDF::Cell(10,4,'X',1,0,'C',0);
                    PDF::SetXY(112, 135);
                    PDF::Cell(10,4,'',1,0,'C',0);
                    break;
                default:
                    # code...
                    break;
            }

            PDF::SetXY(112, 131);
            PDF::Cell(10,4,'',1,0,'C',0);
            PDF::SetXY(112, 135);
            PDF::Cell(10,4,'',1,0,'C',0);

            PDF::SetFont('helvetica','B',8);

            PDF::SetXY(90, 145);
            PDF::MultiCell(130,8,'2019-03-30',0,1,0,'C');

            PDF::Ln(60);
            PDF::SetFont('helvetica','B',7);
            /*$pdf->SetXY(75, 199);
            $pdf->Cell(68,6,utf8_decode('Entregue Conforme'),0,1,'C',0);*/
            PDF::SetXY(75, 204);
            PDF::Cell(68,6,'',0,1,'C',0);
            PDF::SetXY(25, 199);
            PDF::Cell(70,6,utf8_decode('Recibi Conforme (Proveedor)'),0,1,'C',0);
            PDF::SetXY(10, 204);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(15,6,'pepiro perez',0,1,'L',0), true, true, false, '');
           // $pdf->Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
           // $pdf->Cell(45,6,'',0,1,'L',0);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(45,6,'6120555',0,1,'L',0), true, true, false, '');
            //$pdf->Cell(45,6,'',0,1,'L',0);

            PDF::SetXY(125, 199);
            PDF::Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            PDF::SetXY(120, 204);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(15,6,'fsadfdsaf',0,1,'L',0), true, true, false, '');
            //PDF::Cell(45,6,'',0,1,'C',0);
            PDF::SetXY(120, 210);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(45,6,'dfas',0,1,'L',0), true, true, false, '');
            //PDF::Cell(60,6,''." ".'',0,1,'C',0);

            PDF::Line(35, 198.5,85, 198.5); 
            //$pdf->Line(87, 198.5,130, 198.5); 
            PDF::Line(135, 198.5,186, 198.5); 

            PDF::Output();

   
        PDF::SetTitle('Boleta de Acopio');
        //PDF::writeHTML($htmltable, true, false, true, false, '');
        // PDF::AddPage();
        PDF::SetFont('helvetica', '', 10);
        //CUERPO
        $style = array(
            'border'  => false,
            'padding' => 0,
            'fgcolor' => array(128, 0, 0),
            'bgcolor' => false,
        );
     //   PDF::writeHTML($html, true, false, true, false, '');

        PDF::Output('hello_world.pdf');
    }
    public function reporteConvenio()
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
        $pdf->SetFont('helvetica', '', 7);

        // add a page
        $pdf->AddPage('L', 'Carta');

        $tituloTabla = 'ACOPIO MIEL - CONVENIO';

        $html = '<h3>'.$tituloTabla.' - TODAS LAS PLANTAS</h3>
                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="40"><strong>#</strong></th>
                            <th align="center" bgcolor="#3498DB" width="90"><strong>PLANTA</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>No CONTRATO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="160"><strong>NOMBRE</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>CI</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>TOTAL DEUDA</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>CUOTA 1</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>CUOTA 2</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>CUOTA 3</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>CUOTA 4</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>CUOTA 5</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>CUOTA 6</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>CUOTA 7</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>TOTAL AMORT.</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>SALDO</strong></th> 
                        </tr>';
        
        $proveedores = Proveedor::join('acopio.contrato as cont','acopio.proveedor.prov_id','cont.contrato_id_prov')
                        ->join('acopio.departamento as dpto','acopio.proveedor.prov_exp','=','dep_id')
                        // ->join('public._bp_usuarios as usu','acopio.proveedor.prov_id_usr','=','usu.usr_id')
                        // ->join('public._bp_planta as planta','usu.usr_planta_id','=','planta.id_planta')
                        ->join('public._bp_planta as planta','acopio.proveedor.prov_id_planta','=','planta.id_planta')
                        ->where('prov_estado','=','A')->OrderBy('prov_id','ASC')->get();
        // dd($proveedores);
        $nro = 0;
        $totalcontrato_precio = 0;
        $totalamortizaciones = 0;
        $totalsaldos = 0;
        foreach ($proveedores as $proveedor) {
            $html = $html . '<tr>';
            $nro = $nro + 1;             
            $html = $html . '<td align="center">'.$nro.'</td>
                            <td align="center">'.$proveedor->nombre_planta.'</td>
                            <td align="center">'.$proveedor->contrato_nro.'</td>
                            <td align="center">'.$proveedor->prov_nombre.' '.$proveedor->prov_ap.' '.$proveedor->prov_am.'</td>
                            <td align="center">'.$proveedor->prov_ci.' '.$proveedor->dep_exp.'</td>
                            <td align="center">'.number_format($proveedor->contrato_precio,2,'.',',').'</td>';
                            $pagos = Pagos::join('acopio.contrato as contra','acopio.pagos.pago_id_contrato','=','contra.contrato_id')
                                ->join('acopio.acopio as aco','acopio.pagos.pago_id_aco','=','aco_id')
                                ->where('aco_estado','=','A')->where('contrato_id','=',$proveedor->contrato_id)->OrderBy('pago_id','ASC')->get();
                            //dd($pagos);
                            if($pagos->isEmpty()){
                                $html = $html . '<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>';
                                $totalamort = 0;
                                $html = $html.'<td align="center">'.number_format($totalamort,2,'.',',').'</td>'; 
                            } else {
                                $tamanopagos = count($pagos);
                                $tamano = 7 - $tamanopagos;
                                $totalamort = 0;
                                foreach ($pagos as $pago) {                                    
                                    $html = $html . '<td align="center">'.number_format($pago->pago_liquido_pag,2,'.',',').'</td>';//SE CAMBIO pago_cuota_pago por pago_liquido_pag
                                    $totalamort = $totalamort + $pago->pago_liquido_pag;//SE CAMBIO pago_cuota_pago por pago_liquido_pag
                                }
                                // $totalamorti = $totalamort; 
                                for($i=1;$i<=$tamano;$i++ ){
                                        $html = $html . '<td>-</td>';
                                }
                                $html = $html.'<td align="center">'.number_format($totalamort,2,'.',',').'</td>';    
                            }
                            $saldo = $proveedor->contrato_precio - $totalamort;
                            $html = $html.'<td align="center">'.number_format($saldo,2,'.',',').'</td>';
                    
            $html = $html.'</tr>';
            $totalcontrato_precio = $totalcontrato_precio + $proveedor->contrato_precio;
            $totalamortizaciones = $totalamortizaciones + $totalamort;
            $totalsaldos = $totalsaldos + $saldo;
        }
        $html = $html.'<tr>
                            <th align="center" bgcolor="#3498DB" colspan="5"><strong>TOTALES</strong></th>
                            
                            <th align="center" bgcolor="#3498DB"><strong>'.number_format($totalcontrato_precio,2,'.',',').'</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>-</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>-</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>-</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>-</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>-</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>-</strong></th>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>-</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>'.number_format($totalamortizaciones,2,'.',',').'</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>'.number_format($totalsaldos,2,'.',',').'</strong></th> 
                        </tr>';


        $html = $html.'</table>';
        // output the HTML content
        $pdf->writeHTML($html, true, 0, true, 0);

        // reset pointer to the last page
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Acopio_Miel_Convenio_general.pdf', 'I');
    }

}
