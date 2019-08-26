<?php

namespace siga\Http\Controllers\insumo\insumo_recetas;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_registros\Insumo;
use siga\Modelo\insumo\insumo_registros\Datos;
use siga\Modelo\insumo\insumo_registros\Mercado;
use siga\Modelo\insumo\insumo_registros\UnidadMedida;
use siga\Modelo\insumo\insumo_recetas\Receta;
use siga\Modelo\insumo\insumo_recetas\DetalleReceta;
use siga\Modelo\insumo\insumo_registros\Sabor;
use siga\Modelo\insumo\insumo_registros\SubLinea;
use siga\Modelo\admin\Usuario;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use PDF;
use TCPDF;

class gbRecetasController extends Controller
{
    public function index()
    {
    	$listarInsumo = Insumo::getListarInsumo();
    	$listarUnidades = UnidadMedida::where('umed_estado','A')->get();
        $listarMercados = Mercado::where('mer_estado','A')->get();
        //$recetas = Receta::getListar();
        //dd($recetas);
    	$plantas = DB::table('public._bp_planta')->get();
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_linea_trabajo = Usuario::where('usr_id','=',Auth::user()->usr_id)->first();
        $ls_plantas = DB::table('public._bp_planta')->where('id_linea_trabajo','=',$id_linea_trabajo->usr_linea_trabajo)->get();
        //dd($ls_plantas);
    	$lineaTrabajo = DB::table('acopio.linea_trab')->get();
        return view('backend.administracion.insumo.insumo_recetas.index',compact('listarInsumo','listarUnidades','plantas','planta','lineaTrabajo','listarMercados','ls_plantas'));
    }

     public function create()
    {
        //$receta = Receta::getListar();
        $receta = Receta::join('insumo.unidad_medida as uni','insumo.receta.rece_uni_id','uni.umed_id')
                        ->leftjoin('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')
                        ->where('rece_estado','A')->orderBy('rece_id','DESC')->get();
        // dd($recetas);
        return Datatables::of($receta)->addColumn('acciones', function ($receta) {
            return '<a class="btn btn-primary" target="_blank" href="ImprimirReceta/'.$receta->rece_id.'"><i class="fa fa-file"></i> VER RECETA</a>';
        })->addColumn('linea_prod', function ($linea_prod) {
            if ($linea_prod->rece_lineaprod_id == 1) {
                return 'LACTEOS';
            }elseif($linea_prod->rece_lineaprod_id == 2){
                return 'ALMENDRA';
            }elseif($linea_prod->rece_lineaprod_id == 3) {
                return 'MIEL';
            }elseif($linea_prod->rece_lineaprod_id == 4) {
                return 'FRUTOS';
            }elseif($linea_prod->rece_lineaprod_id == 5) {
                return 'DERIVADOS';
            }
        })->addColumn('nombreReceta', function ($nombreReceta) {
            if ($nombreReceta->sab_id == 1) {
                return $nombreReceta->rece_nombre.' '.$nombreReceta->rece_presentacion;
            }else{
                return $nombreReceta->rece_nombre.' '.$nombreReceta->sab_nombre.' '.$nombreReceta->rece_presentacion;
            }
        })
            ->editColumn('id', 'ID: {{$rece_id}}')
            ->make(true);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'nombre_receta'             => 'required',
            'cantidad_minima_receta'    => 'required',
            'unidad_base'               => 'required',
            'planta_receta'             => 'required',
            'produccion_receta'         => 'required|min:1',
            'mercado_receta'            => 'required|min:1',
            'rec_data'                  => 'required'
        ]);
        $arraycount = json_decode($request['rec_data']);
        if(count($arraycount)==0){
            dd("DATOS VACIOS");
        }
        Receta::create([
            'rec_nombre'        => $request['nombre_receta'],
            'rec_cant_min'      => $request['cantidad_minima_receta'],
            'rec_uni_base'      => $request['unidad_base'],
            'rec_id_planta'     => $request['planta_receta'],
            'rec_id_lineatrab'  => $request['produccion_receta'],
            'rec_id_mercado'    => $request['mercado_receta'],
            'rec_data'          => $request['rec_data'],
            'rec_usr_id'        => Auth::user()->usr_id,
            'rec_registrado'    => '2018-12-18',
            'rec_modificado'    => '2018-12-18',
            'rec_estado'        => 'A'
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function destroy($id)
    {
        $receta = Receta::getDestroy($id);
        return response()->json($receta);
    }

    public function nuevaReceta()
    {
        $sabor = Sabor::where('sab_estado','A')->get();
        $listarInsumo = Insumo::leftjoin('insumo.sabor as sab','insumo.insumo.ins_id_sabor','=','sab.sab_id')
                                ->where('ins_id_tip_ins',1)->orWhere('ins_id_tip_ins',3)->get();
        $listarMateriaPrima = Insumo::leftjoin('insumo.sabor as sab','insumo.insumo.ins_id_sabor','=','sab.sab_id')
                                    ->where('ins_id_tip_ins',3)->get();
        $listarEnvase = Insumo::with('unidad_medida')->leftjoin('insumo.sabor as sab','insumo.insumo.ins_id_sabor','=','sab.sab_id')
                              ->where('ins_id_tip_ins',2)->get();
        $listarSaborizantes = Insumo::leftjoin('insumo.sabor as sab','insumo.insumo.ins_id_sabor','=','sab.sab_id')
                                    ->where('ins_id_tip_ins',4)->get();
        $listarUnidades = UnidadMedida::where('umed_estado','A')->get();
        $sublinea = SubLinea::where('sublin_estado','A')->get();
        //dd($listarInsumo);
        return view('backend.administracion.insumo.insumo_recetas.partials.formCreateReceta',compact('listarInsumo','listarUnidades','sabor','sublinea','listarMateriaPrima','listarEnvase','listarSaborizantes'));
    }

    public function registrarReceta(Request $request)
    {
        if ($request['lineaProduccion'] == 1) {
            //CODIGO LACTEOS
            $num = Receta::select(DB::raw('MAX(rece_enumeracion) as nrocod'))->where('rece_lineaprod_id',$request['lineaProduccion'])->first();
            $cont=$num['nrocod'];
            $nroCod = $cont + 1;
            $nroCodCadena = 'PRO-LAC-'.$nroCod;
            //END CODIGO LACTEOS
            $detrec_id_ins_base = $request['descripcion_base'];
            $detrec_cantidad_base = $request['cantidad_base'];

            $detrec_id_ins_sab = $request['descripcion_saborizacion'];
            $detrec_cantidad_sab = $request['cantidad_saborizacion'];

            $detrec_id_ins_env = $request['descripcion_envase'];
            $detrec_cantidad_env = $request['cantidad_envase'];

            for ($i=0; $i <sizeof($detrec_id_ins_base) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_base[$i], "cantidad"=>$detrec_cantidad_base[$i]);
            }

            for ($i=0; $i <sizeof($detrec_id_ins_sab) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_sab[$i], "cantidad"=>$detrec_cantidad_sab[$i]);
            }

            for ($i=0; $i <sizeof($detrec_id_ins_env) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_env[$i], "cantidad"=>$detrec_cantidad_env[$i]);
            }

        }elseif($request['lineaProduccion'] == 2){
            //CODIGO ALMENDRA
            $num = Receta::select(DB::raw('MAX(rece_enumeracion) as nrocod'))->where('rece_lineaprod_id',$request['lineaProduccion'])->first();
            $cont=$num['nrocod'];
            $nroCod = $cont + 1;
            $nroCodCadena = 'PRO-AMZ-'.$nroCod;
            //END CODIGO ALMENDRA
            $detrec_id_ins_materia = $request['descripcion_materia'];
            $detrec_cantidad_materia = $request['cantidad_materia'];

            $detrec_id_ins_env = $request['descripcion_envase'];
            $detrec_cantidad_env = $request['cantidad_envase'];

            for ($i=0; $i <sizeof($detrec_id_ins_materia) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_materia[$i], "cantidad"=>$detrec_cantidad_materia[$i]);
            }

            for ($i=0; $i <sizeof($detrec_id_ins_env) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_env[$i], "cantidad"=>$detrec_cantidad_env[$i]);
            }
        }elseif($request['lineaProduccion'] == 3){
            //CODIGO MIEL
            $num = Receta::select(DB::raw('MAX(rece_enumeracion) as nrocod'))->where('rece_lineaprod_id',$request['lineaProduccion'])->first();
            $cont=$num['nrocod'];
            $nroCod = $cont + 1;
            $nroCodCadena = 'PRO-ENM-'.$nroCod;
            //END CODIGO MIEL
            $detrec_id_ins_materia = $request['descripcion_materia'];
            $detrec_cantidad_materia = $request['cantidad_materia'];

            $detrec_id_ins_env = $request['descripcion_envase'];
            $detrec_cantidad_env = $request['cantidad_envase'];
            for ($i=0; $i <sizeof($detrec_id_ins_materia) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_materia[$i], "cantidad"=>$detrec_cantidad_materia[$i]);
            }

            for ($i=0; $i <sizeof($detrec_id_ins_env) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_env[$i], "cantidad"=>$detrec_cantidad_env[$i]);
            }
        }elseif($request['lineaProduccion'] == 4){
            //CODIGO FRUTOS
            $num = Receta::select(DB::raw('MAX(rece_enumeracion) as nrocod'))->where('rece_lineaprod_id',$request['lineaProduccion'])->first();
            $cont=$num['nrocod'];
            $nroCod = $cont + 1;
            $nroCodCadena = 'PRO-ENF-'.$nroCod;
            //END CODIGO FRUTOS
            $detrec_id_ins_base = $request['descripcion_base'];
            $detrec_cantidad_base = $request['cantidad_base'];

            $detrec_id_ins_sab = $request['descripcion_saborizacion'];
            $detrec_cantidad_sab = $request['cantidad_saborizacion'];

            $detrec_id_ins_env = $request['descripcion_envase'];
            $detrec_cantidad_env = $request['cantidad_envase'];
            for ($i=0; $i <sizeof($detrec_id_ins_base) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_base[$i], "cantidad"=>$detrec_cantidad_base[$i]);
            }

            for ($i=0; $i <sizeof($detrec_id_ins_sab) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_sab[$i], "cantidad"=>$detrec_cantidad_sab[$i]);
            }

            for ($i=0; $i <sizeof($detrec_id_ins_env) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_env[$i], "cantidad"=>$detrec_cantidad_env[$i]);
            }
        }elseif($request['lineaProduccion'] == 5){
            //CODIGO DERIVADOS
            $num = Receta::select(DB::raw('MAX(rece_enumeracion) as nrocod'))->where('rece_lineaprod_id',$request['lineaProduccion'])->first();
            $cont=$num['nrocod'];
            $nroCod = $cont + 1;
            $nroCodCadena = 'PRO-DER-'.$nroCod;
            //END CODIGO DERIVADOS
            $detrec_id_ins_base = $request['descripcion_base'];
            $detrec_cantidad_base = $request['cantidad_base'];

            $detrec_id_ins_sab = $request['descripcion_saborizacion'];
            $detrec_cantidad_sab = $request['cantidad_saborizacion'];

            $detrec_id_ins_env = $request['descripcion_envase'];
            $detrec_cantidad_env = $request['cantidad_envase'];
            for ($i=0; $i <sizeof($detrec_id_ins_base) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_base[$i], "cantidad"=>$detrec_cantidad_base[$i]);
            }

            for ($i=0; $i <sizeof($detrec_id_ins_sab) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_sab[$i], "cantidad"=>$detrec_cantidad_sab[$i]);
            }

            for ($i=0; $i <sizeof($detrec_id_ins_env) ; $i++) {
                $detrecesta_datos[] = array("id_insumo"=>$detrec_id_ins_env[$i], "cantidad"=>$detrec_cantidad_env[$i]);
            }
        }
        //dd($detrecesta_datos);
        if($request['lineaProduccion'] == 1 or $request['lineaProduccion'] == 4 or $request['lineaProduccion'] == 5){
            $array_receta = array(
                'densidad'          => $request['densidad'],
                'vol_recipiente'    => $request['vol_recipiente'],
                'peso_mezcla'       => $request['peso_mezcla'],
                'peso_botella'      => $request['peso_botella'],
                'peso_tapa'         => $request['peso_tapa'],
                'solides_lie'       => $request['solides_lie'],
                'solides_lse'       => $request['solides_lse'],
                'acidez_lie'        => $request['acidez_lie'],
                'acidez_lse'        => $request['acidez_lse'],
                'ph_lie'            => $request['ph_lie'],
                'ph_lse'            => $request['ph_lse'],
                'viscosidad_lie'    => $request['viscosidad_lie'],
                'viscosidad_lse'    => $request['viscosidad_lse'],
                'densidad_lie'      => $request['densidad_lie'],
                'densidad_lse'      => $request['densidad_lse']
            );
        }else{
            $array_receta = array('no hay datos');
        }
        $datosjson = json_encode($array_receta);
        $receta = Receta::create([
            'rece_codigo'           => $nroCodCadena,
            'rece_enumeracion'      => $nroCod,
            'rece_nombre'           => $request['nombre_receta'],
            'rece_lineaprod_id'     => $request['lineaProduccion'],
            'rece_sublinea_id'      => $request['sublinea'],
            'rece_sabor_id'         => $request['sabor'],
            'rece_presentacion'     => $request['presentacion'],
            'rece_uni_id'           => $request['unidad_medida'],
            'rece_prod_total'       => $request['peso_prod_total'],
            'rece_rendimiento_base' => $request['rendimiento_base'],
            'rece_datos_json'       => $datosjson,
            'rece_usr_id'           => Auth::user()->usr_id,
            'rece_umed_repre'=> $request['unidad_presentacion'],
            'rece_obs'              => $request['observaciones'],

        ]);
        foreach ($detrecesta_datos as $det) {
            DetalleReceta::create([
                'detrece_rece_id'   => $receta->rece_id,
                'detrece_ins_id'    => $det['id_insumo'],
                'detrece_cantidad'  => $det['cantidad']
            ]);
        }

        return redirect('InsumoRecetas')->with('success','Registro creado satisfactoriamente');
    }

    public function imprimirReceta($id_receta){
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
        $pdf->SetSubject('RECETAS INSUMOS');
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
        $pdf->AddPage('P', 'Carta');
        //PDF::AddPage();
        // create some HTML content
        $usr = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                        ->where('usr_id',Auth::user()->usr_id)->first();
        //  echo $id;
        $receta = Receta::join('insumo.sub_linea as subl','insumo.receta.rece_sublinea_id','=','subl.sublin_id')
                        ->join('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')
                        ->join('insumo.unidad_medida as uni','insumo.receta.rece_uni_id','=','uni.umed_id')->where('rece_id',$id_receta)->first();
        //dd($datos_json);
        if ($receta->rece_lineaprod_id == 1) {
            $datos_json = json_decode($receta->rece_datos_json);
        }
        $html = '   <table border="0" cellspacing="0" cellpadding="1">
                                                <tr>
                        <th rowspan="3" align="center" width="150"><img src="img/logopeqe.png" width="150" height="105"></th>
                             <th rowspan="3" width="375"><h3 align="center"><br>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS<br>LINEA PRODUCCIÓN: '.$this->nombreLinea($receta->rece_lineaprod_id).'</h3><br><h1 align="center">ORDEN DE PRODUCCIÓN</h1>
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
                                        <th align="center">'.$receta->rece_codigo.'</th>
                                    </tr>
                                </table>
                             </th>
                        </tr>
                    </table>
                    <br><br><br>
                    <table border="1">
                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="135"><strong color="white">Nombre Producto:</strong></th>
                            <th width="280"> '.$receta->rece_nombre.'</th>
                            <th align="center" bgcolor="#5c6875" width="80"><strong color="white">Sublinea:</strong></th>
                            <th width="170"> '.$receta->sublin_nombre.'</th>
                        </tr>
                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="75"><strong color="white">Sabor:</strong></th>
                            <th width="280"> '.$receta->sab_nombre.'</th>
                            <th align="center" bgcolor="#5c6875" width="120"><strong color="white">Unidad de medida:</strong></th>
                            <th width="190"> '.$receta->umed_nombre.'</th>
                        </tr>
                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="85"><strong color="white">Presentación:</strong></th>
                            <th width="180"> '.$receta->rece_presentacion.'</th>
                            <th align="center" bgcolor="#5c6875" width="120"><strong color="white">Peso Producto total:</strong></th>
                            <th width="120"> '.$receta->rece_prod_total.'</th>
                            <th align="center" bgcolor="#5c6875" width="120"><strong color="white">Peso Producto total:</strong></th>
                            <th width="40"> '.$receta->rece_prod_total.'</th>
                        </tr>
                    </table>
                    <br>
                    ';
                if($receta->rece_lineaprod_id==1){
                    $html = $html.'
                        <br>
                    <table>
                        <tr><th align="center" style="color:black;font-size:11"><strong>CARACTERÍSTICAS ENVASADO</strong></th></tr>
                    </table>
                    <table border="1">
                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="80"><strong color="white">Densidad: </strong></th>
                            <th width="120"> '.$datos_json->densidad.'</th>
                            <th align="center" bgcolor="#5c6875" width="140"><strong color="white">Volumen Recipiente:</strong></th>
                            <th width="120"> '.$datos_json->vol_recipiente.'</th>
                            <th align="center" bgcolor="#5c6875" width="110"><strong color="white">Peso Mezcla:</strong> </th>
                            <th width="95"> '.$datos_json->peso_mezcla.'</th>
                        </tr>
                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="110"><strong color="white">Peso Botella:</strong> </th>
                            <th width="200"> '.$datos_json->peso_botella.'</th>
                            <th align="center" bgcolor="#5c6875" width="90"><strong color="white">Peso Tapa:</strong> </th>
                            <th width="265"> '.$datos_json->peso_tapa.'</th>
                        </tr>
                    </table>';
                }
                if ($receta->rece_lineaprod_id==2 OR $receta->rece_lineaprod_id==3) {
                    $html = $html.'<br><br>
                    <table>
                        <tr><th align="center" style="color:black;font-size:11"><strong>MATERIA PRIMA</strong></th></tr>
                    </table>
                    <table border="1" cellspacing="0" cellpadding="1">

                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="30"><strong color="white">N°</strong></th>
                            <th align="center" bgcolor="#5c6875" width="280"><strong color="white">Insumo</strong></th>
                            <th align="center" bgcolor="#5c6875" width="200"><strong color="white">Unidad Medida</strong></th>
                            <th align="center" bgcolor="#5c6875" width="150"><strong color="white">Cantidad</strong></th>
                        </tr> ';
                    $detalle_formulacion = DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',3)
                                                        ->where('detrece_rece_id',$receta->rece_id)->get();
                    //dd($detalle_formulacion);
                    $nro = 0;
                    foreach ($detalle_formulacion as $detform){
                        $nro = $nro + 1;
                        $html = $html .'<tr BGCOLOR="#f3f0ff">
                            <td align="center">'.$nro.'</td>
                            <td align="center">'.$detform->ins_desc.'</td>
                            <td align="center">'.$detform->umed_nombre.'</td>
                            <td align="center">'.$detform->detrece_cantidad.'</td>
                        </tr>';
                    }
                    $html = $html . '</table>';
                }
                if ($receta->rece_lineaprod_id==1 OR $receta->rece_lineaprod_id == 4 OR $receta->rece_lineaprod_id == 5) {
                    $html = $html.'<br><br>
                    <table>
                        <tr><th align="center" style="color:black;font-size:11"><strong>FORMULACIÓN DE LA BASE</strong></th></tr>
                    </table>
                    <table border="1" cellspacing="0" cellpadding="1">

                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="30"><strong color="white">N°</strong></th>
                            <th align="center" bgcolor="#5c6875" width="280"><strong color="white">Insumo</strong></th>
                            <th align="center" bgcolor="#5c6875" width="200"><strong color="white">Unidad Medida</strong></th>
                            <th align="center" bgcolor="#5c6875" width="150"><strong color="white">Cantidad</strong></th>
                        </tr> ';
                    $insumo_insumo = DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',1)
                                                        ->where('detrece_rece_id',$receta->rece_id)->get();
                    $insumo_matprima = DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',3)
                                                        ->where('detrece_rece_id',$receta->rece_id)->get();
                    foreach ($insumo_insumo as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detrece_cantidad"=>$ins->detrece_cantidad);
                    }
                    foreach ($insumo_matprima as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detrece_cantidad"=>$ins->detrece_cantidad);
                    }
                    //dd($detalle_formulacion);
                    $nro = 0;
                    foreach ($detalle_formulacion as $detform){
                        $nro = $nro + 1;
                        $html = $html .'<tr BGCOLOR="#f3f0ff">
                            <td align="center">'.$nro.'</td>
                            <td align="center">'.$detform['ins_desc'].'</td>
                            <td align="center">'.$detform['umed_nombre'].'</td>
                            <td align="center">'.$detform['detrece_cantidad'].'</td>
                        </tr>';
                    }
                    $html = $html . '</table>';
                }
                if ($receta->rece_lineaprod_id == 1 OR $receta->rece_lineaprod_id == 4 OR $receta->rece_lineaprod_id == 5) {


                    $html = $html.'<br><br>
                    <table>
                        <tr><th align="center" style="color:black;font-size:11"><strong>SABORIZACIÓN</strong></th></tr>
                    </table>
                    <table border="1" cellspacing="0" cellpadding="1">

                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="30"><strong color="white">N°</strong></th>
                            <th align="center" bgcolor="#5c6875" width="280"><strong color="white">Insumo</strong></th>
                            <th align="center" bgcolor="#5c6875" width="200"><strong color="white">Unidad Medida</strong></th>
                            <th align="center" bgcolor="#5c6875" width="150"><strong color="white">Cantidad</strong></th>
                        </tr> ';
                    $detalle_formulacion = DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('detrece_rece_id',$receta->rece_id)
                                                        ->where('ins_id_tip_ins',4)->get();
                    //dd($detalle_formulacion);
                    $nro = 0;
                    foreach ($detalle_formulacion as $detform){
                        $nro = $nro + 1;
                        $html = $html .'<tr BGCOLOR="#f3f0ff">
                            <td align="center">'.$nro.'</td>
                            <td align="center">'.$detform->ins_desc.'</td>
                            <td align="center">'.$detform->umed_nombre.'</td>
                            <td align="center">'.$detform->detrece_cantidad.'</td>
                        </tr>';
                    }
                    $html = $html . '</table>';
                }
                    $html = $html.'<br><br>
                    <table>
                        <tr><th align="center" style="color:black;font-size:11"><strong>MATERIAL ENVASADO</strong></th></tr>
                    </table>
                    <table border="1" cellspacing="0" cellpadding="1">

                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="30"><strong color="white">N°</strong></th>
                            <th align="center" bgcolor="#5c6875" width="280"><strong color="white">Insumo</strong></th>
                            <th align="center" bgcolor="#5c6875" width="200"><strong color="white">Unidad Medida</strong></th>
                            <th align="center" bgcolor="#5c6875" width="150"><strong color="white">Cantidad</strong></th>
                        </tr> ';
                    $detalle_formulacion = DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('detrece_rece_id',$receta->rece_id)
                                                        ->where('ins_id_tip_ins',2)->get();
                    //dd($detalle_formulacion);
                    $nro = 0;
                    foreach ($detalle_formulacion as $detform){
                        $nro = $nro + 1;
                        $html = $html .'<tr BGCOLOR="#f3f0ff">
                            <td align="center">'.$nro.'</td>
                            <td align="center">'.$detform->ins_desc.'</td>
                            <td align="center">'.$detform->umed_nombre.'</td>
                            <td align="center">'.$detform->detrece_cantidad.'</td>
                        </tr>';
                    }
                    $html = $html . '</table>';
                if ($receta->rece_lineaprod_id == 1) {
                    $html = $html.'<br><br>
                    <table>
                        <tr><th align="center" style="color:black;font-size:11"><strong>PARAMETRO FISICO QUIMICO</strong></th></tr>
                    </table>
                    <table border="1" cellspacing="0" cellpadding="1">

                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875"><strong color="white"></strong></th>
                            <th align="center" bgcolor="#5c6875"><strong color="white">Lie</strong></th>
                            <th align="center" bgcolor="#5c6875"><strong color="white">Lse</strong></th>
                        </tr> ';

                       $html = $html .
                        '<tr BGCOLOR="#f3f0ff">
                            <td align="right" bgcolor="#5c6875"><strong color="white">Solidez:</strong></td>
                            <td align="center">'.$datos_json->solides_lie.'</td>
                            <td align="center">'.$datos_json->solides_lse.'</td>
                        </tr>
                        <tr BGCOLOR="#f3f0ff">
                            <td align="right" bgcolor="#5c6875"><strong color="white">Acidez (%AI.):</strong></td>
                            <td align="center">'.$datos_json->acidez_lie.'</td>
                            <td align="center">'.$datos_json->acidez_lse.'</td>
                        </tr>
                        <tr BGCOLOR="#f3f0ff">
                            <td align="right" bgcolor="#5c6875"><strong color="white">Ph (-):</strong></td>
                            <td align="center">'.$datos_json->ph_lie.'</td>
                            <td align="center">'.$datos_json->ph_lse.'</td>
                        </tr>
                        <tr BGCOLOR="#f3f0ff">
                            <td align="right" bgcolor="#5c6875"><strong color="white">Viscosidad (seg) a 10°C:</strong></td>
                            <td align="center">'.$datos_json->viscosidad_lie.'</td>
                            <td align="center">'.$datos_json->viscosidad_lse.'</td>
                        </tr>
                        <tr BGCOLOR="#f3f0ff">
                            <td align="right" bgcolor="#5c6875"><strong color="white">Densidad:</strong></td>
                            <td align="center">'.$datos_json->densidad_lie.'</td>
                            <td align="center">'.$datos_json->densidad_lse.'</td>
                        </tr>';
                        //$html = $html . '</table>';
                        $html = $html . '</table>';
                }

                $htmltable = $html;
        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page

        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Orden_produccion.pdf', 'I');
    }

    function nombreLinea($id){
        if ($id == 1) {
            return 'LACTEOS';
        }elseif($id == 2){
            return 'ALMENDRA';
        }elseif($id == 3){
            return 'MIEL';
        }elseif($id == 4){
            return 'FRUTOS';
        }elseif($id == 5){
            return 'DERIVADOS';
        }
    }
}
