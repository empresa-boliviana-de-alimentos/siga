<?php

namespace siga\Http\Controllers\insumo\insumo_solicitudes;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_solicitud\Solicitud;
use siga\Modelo\insumo\insumo_solicitud\Solicitud_Adicional;
use siga\Modelo\insumo\insumo_recetas\Receta;
use siga\Modelo\insumo\insumo_recetas\Mercado;
use siga\Modelo\insumo\insumo_solicitud\Aprobacion_Solicitud;
//ORDEN DE PRODUCCION
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion;
use siga\Modelo\insumo\insumo_registros\Insumo;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\Usuario;
use DB;
use Auth;
use PDF;
use TCPDF;
class gbSolInsumoAdController extends Controller
{
    public function index()
    {
    	//$solAdicional = Solicitud::getlistarAdiInsumo();
    	//$mercado = Mercado::getlistar();
    	// dd($solAdicional);
        $solAdicional = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                        ->where('orprod_nro_salida','<>',null)->orderBy('orprod_id','desc')->get();
        //dd($solAdicional);
    	return view('backend.administracion.insumo.insumo_solicitud.solicitud_insumo.index', compact('solAdicional','mercado'));
    }

    public function create()
    {
        $solAdicional = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                        ->where('orprod_tiporprod_id','=',2)->orderBy('orprod_id','desc')->get();
        return Datatables::of($solAdicional)->addColumn('orprod_accion', function ($solAdicional) {
            if($solAdicional->orprod_estado_id == 'B'){
                return '<div class="text-center"><h4 class="text"><span class="label label-info">RECIBIDO</span></h4></div>';
            }else {
                return '<div class="text-center"><a href="boletaSolAdicional/' . $solAdicional->orprod_id . '" class="btn btn-md btn-primary" target="_blank">Boleta <i class="fa fa-file"></i></a></div>';
            }
        })
            ->editColumn('id', 'ID: {{$orprod_id}}')
            
            ->make(true);
    }
    //NUEVAS FUNCIONES

    public function formInsumoAdicional()
    {
        //$ordenes_produccion = OrdenProduccion::where('orprod_nro_salida','<>',null)->get();
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();   
        $ordenes_produccion = OrdenProduccion::where('orprod_planta_id', '=', $planta->id_planta)
                                             //->where('orprod_nro_solicitud',null)
                                             ->where('orprod_tiporprod_id',1)
                                             //->where('orprod_')
                                             ->get();
        //dd($ordenes_produccion);
        $listarInsumo = Insumo::where('ins_estado','A')->get();
        return view('backend.administracion.insumo.insumo_solicitud.solicitud_insumo.partials.formCreateAdiInsumo', compact('ordenes_produccion','listarInsumo'));
    }
    public function solicitudAdicionalCreate(Request $request)
    {
        $ins_id = $request['id_ins'];
        $cantidad_ins = $request['cantidad_ins'];
        //dd(sizeof($ins_id));
        for ($i=0; $i <sizeof($ins_id) ; $i++) { 
            if ($cantidad_ins[$i] != null) {
                $ins_datos[] = array("id_insumo"=>$ins_id[$i], "cantidad"=>$cantidad_ins[$i]);
            }                 
        }
        //dd($ins_datos);
        $id_receta = $request['id_receta'];
        //dd($id_receta);
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();   
        $num = OrdenProduccion::join('public._bp_planta as plant', 'insumo.orden_produccion.orprod_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(orprod_nro_orden) as nro_op'))->where('plant.id_planta', $planta->id_planta)->first();
        $cont=$num['nro_op'];
        $nop = $cont + 1;
         $numsol = OrdenProduccion::join('public._bp_planta as plant', 'insumo.orden_produccion.orprod_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(orprod_nro_solicitud) as nro_sol'))->where('plant.id_planta', $planta->id_planta)->first();
        $contsol=$numsol['nro_sol'];
        $nopsol = $contsol + 1;

        $orden_produccion = OrdenProduccion::create([
            'orprod_rece_id'    => $id_receta,
            'orprod_codigo'     => '0001',
            'orprod_nro_orden'  => $request['nro_de_orden'],
            'orprod_nro_solicitud' => $nopsol,
            'orprod_cantidad'   => $request['cantidad_producir'],
            'orprod_mercado_id'    => 1,
            'orprod_planta_id'  => $planta->id_planta,
            'orprod_usr_id'     => Auth::user()->usr_id,
            'orprod_usr_vodos'     => Auth::user()->usr_id,
            'orprod_tiporprod_id'   => 2,
            'orprod_obs_vodos'    => $request['observacion'],
            'orprod_estado_orp' => 'C',
        ]);
        //dd($dato_calculo);
        //$detalle_receta = DetalleReceta::where('detrece_rece_id',$id_receta)->get();
        foreach ($ins_datos as $detrece) {
            DetalleOrdenProduccion::create([
                'detorprod_orprod_id'   => $orden_produccion->orprod_id,
                'detorprod_ins_id'      => $detrece['id_insumo'],
                'detorprod_cantidad'    => $detrece['cantidad'],
            ]);
        }
        
        return redirect('solInsumoAd')->with('success','Registro creado satisfactoriamente');
    }
    public function store(Request $request)
    {
        $this->validate(request(), [
            // 'nombre_receta'          => 'required',
            // 'cantidad_solicitud'     => 'required',
            // 'mercado_solicitud'      => 'required|min:1',
            'observacion_general'    => 'required'
        ]);
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $cod_nro = Solicitud::where('sol_id_planta','=',$planta->id_planta)
                            ->select(DB::raw('MAX(sol_codnum) as codigo_nro_adi'))->first();
        $nro_cod_adi = $cod_nro['codigo_nro_adi'] + 1;
    	$solAdic = Solicitud::create([
    		'sol_id_rec'        => $request['sol_rec_id'],
    		// 'soladi_num_lote'		=> $request['soladi_num_lote'],
            // 'sol_cantidad'      => $request['cantidad_solicitud'],
            'sol_id_merc'      	=> $request['sol_merc_id'],
            // 'soladi_num_salida'		=> $request['soladi_num_salida'],
            'sol_data'    		=> $request['soladi_data'],
            'sol_obs'			=> $request['observacion_general'],
            'sol_usr_id'     	=> Auth::user()->usr_id,
            'sol_id_tipo'		=> 2,
            // 'sol_registrado'    => '2018-12-18',
            // 'sol_modificado'    => '2018-12-18',
            'sol_estado'        => 'A',
            'sol_id_planta'     => $planta->id_planta,
            'sol_codnum'        => $nro_cod_adi,
            'sol_gestion'       => date("Y"),
            'sol_nro_salida'    => $request['soladi_num_salida'],
            'sol_aprsol_id'     => $request['soladi_id_notasal']
    	]);

    	return response()->json($solAdic);
    }
    public function boletaSolAdicional($id)
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
                            ->join('insumo.receta as rec','insumo.solicitud.sol_id_rec','=','rec.rec_id')
                            ->where('insumo.solicitud.sol_usr_id','=',$id_user)->where('insumo.solicitud.sol_id','=',$id)->where('insumo.solicitud.sol_id_tipo','=',2)->first();
        $data = $reg['sol_data'];
    	// dd($data);
         $array = json_decode($data);
    
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="/img/logopeqe.png" width="160" height="65"></th>
                             <th  width="370"><h3 align="center"><br>ALMACEN '.$planta['nombre_planta'].'<br>NOTA DE SOLICITUD POR INSUMO ADICIONAL</h3></th>
                             <th  width="150"><h3 align="center"><br>Fecha: '.date('d/m/Y').'<br>Codigo No: '.$reg['sol_codnum'].'/'.$reg['sol_gestion'].'</h3></th>
                        </tr>
                    </table>
                    <br><br><br>
                        <label><strong>Solicitante:</strong> '.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label align="right"><strong>Mercado:</strong> '.$reg['merc_nombre'].'</label>
                        <br><br>
                        <label><strong>Dependencia:</strong> '.$planta['nombre_planta'].'</label>
                        <br><br>
                        <label><strong>Nota Salida:</strong> '.$reg['sol_nro_salida'].'</label>
                        <br><br>
                        
                        <h3 align="center">'.$reg['rec_nombre'].'</h3>
                    <br><br><br>

                    <table border="1" cellspacing="0">
                     
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB" width="220"><strong>Insumo</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>Unidad</strong></th>
                            <th align="center" bgcolor="#3498DB" width="70"><strong>Cantidad</strong></th>
                            
                            <th align="center" bgcolor="#3498DB" width="100"><strong>Adicional</strong></th>
                            <th align="center" bgcolor="#3498DB" width="100"><strong>Observacion</strong></th>
                        </tr> ';
                        $nro=0;
                        // $tot1=0;
                    //    echo $data;
                    foreach ($array as $d) {
                        $nro = $nro+1; 
                        
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">'.$nro.'</td>
                                    <td align="center">'.$d->descripcion_insumo.'</td>
                                    <td align="center">'.$d->unidad.'</td>
                                    <td align="center">'.$d->cantidad.'</td>                                    
                                    <td align="center">'.$d->solicitud_adicional.'</td>
                                    <td align="center">'.$d->observaciones.'</td>
                                  </tr>';  
                        
                       // echo $tot1;    

                     }
                     $html = $html . '</table><br><br>
                            <table border="1">
                                <tr>
                                    <th height="50"><strong> Observaciones:</strong> '.$reg['sol_obs'].'</th>
                                </tr>
                            </table>
                     <br><br><br><br><br><br><br><br><br><br><br><br>';

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
        $pdf->Output('boletaSolAdiInsumos-'.$reg['sol_id'].'.pdf', 'I');
    }

    public function getNotaSal(Request $request)
    {   
        $term = $request->term ?: '';
        $receta = Aprobacion_Solicitud::where('aprsol_estado','A')->where('aprsol_cod_solicitud','LIKE','%'.$term.'%')->take(35)->get();
        $recetas = [];
        foreach ($receta as $rec) {
            $recetas[] = ['id' => $rec->aprsol_id, 'text' => $rec->aprsol_cod_solicitud];
        }
        return \Response::json($recetas);
    }
}
