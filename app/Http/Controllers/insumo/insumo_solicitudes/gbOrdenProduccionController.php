<?php

namespace siga\Http\Controllers\insumo\insumo_solicitudes;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_recetas\Receta;
use siga\Modelo\insumo\insumo_recetas\DetalleReceta;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion;
use siga\Modelo\insumo\Stock;
use siga\Modelo\admin\Usuario;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Auth;
use DB;
use PDF;
use TCPDF;
class gbOrdenProduccionController extends Controller
{
    public function index()
    {
        $orden_produccion = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                            ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')
                                            ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                            ->leftjoin('insumo.unidad_medida as umed','rece.rece_uni_id','=','umed.umed_id')
                                            //->where('orprod_planta_id',$planta->id_planta)
                                            ->orderBy('orprod_id','DESC')
                                            ->where('orprod_tiporprod_id',1)
                                            ->get();
    	return view('backend.administracion.insumo.insumo_solicitud.insumo_ordenprod.index',compact('orden_produccion'));
    }

    public function create()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $orden_produccion = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                            ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')
                                            ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                            ->leftjoin('insumo.unidad_medida as umed','rece.rece_uni_id','=','umed.umed_id')
                                            //->where('orprod_planta_id',$planta->id_planta)
                                            ->orderBy('orprod_id','DESC')
                                            ->where('orprod_tiporprod_id',1)
                                            ->get();

        return Datatables::of($orden_produccion)->addColumn('acciones', function ($orden_produccion) {
                return '<div class="text-center"><a href="BoletaOrdenProduccion/' . $orden_produccion->orprod_id . '" class="btn btn-md btn-primary" target="_blank">'.$orden_produccion->orprod_nro_orden.'</a></div>';
        })->addColumn('nombreReceta', function ($nombreReceta) {
                return $nombreReceta->rece_nombre.' '.$nombreReceta->sab_nombre.' '.$nombreReceta->rece_presentacion;
        })->addColumn('lineaProduccion', function ($lineaProduccion) {
            if ($lineaProduccion->rece_lineaprod_id == 1) {
                return 'LACTEOS';
            }elseif($lineaProduccion->rece_lineaprod_id == 2){
                return 'ALMENDRA';
            }elseif($lineaProduccion->rece_lineaprod_id == 3) {
                return 'MIEL';
            }elseif($lineaProduccion->rece_lineaprod_id == 4) {
                return 'FRUTOS';
            }elseif($lineaProduccion->rece_lineaprod_id == 5) {
                return 'DERIVADOS';
            }
        })->addColumn('estadoAprobacion', function ($estadoAprobacion) {
            if ($estadoAprobacion->orprod_estado_orp == 'A') {
                return $this->traeUser($estadoAprobacion->orprod_usr_id);
            }elseif($estadoAprobacion->orprod_estado_orp == 'B'){
                return $this->traeUser($estadoAprobacion->orprod_usr_vo);
            }elseif($estadoAprobacion->orprod_estado_orp == 'C') {
                return $this->traeUser($estadoAprobacion->orprod_usr_vodos);
            }elseif($estadoAprobacion->orprod_estado_orp == 'D') {
                return $this->traeUser($estadoAprobacion->orprod_usr_aprob);
            }
        })
            ->editColumn('id', 'ID: {{$orprod_id}}')

            ->make(true);

    }
    function traeUser($id_user)
    {
        $user_datos = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                             ->where('usr_id',$id_user)
                             ->first();
        //dd($id_user);
        return $user_datos->prs_nombres.' '.$user_datos->prs_paterno.' '.$user_datos->prs_materno;
    }
    public function viewRegistroProd()
    {
    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta','id_linea_trabajo')->where('usr_id','=',Auth::user()->usr_id)->first();
    	$plantas = DB::table('public._bp_planta')->where('id_linea_trabajo',$planta->id_linea_trabajo)->get();
    	$mercados = DB::table('insumo.mercado')->get();
    	return view('backend.administracion.insumo.insumo_solicitud.insumo_ordenprod.partials.formCreateOrdenProd', compact('plantas','mercados'));
    }
    public function getProducto(Request $request)
    {
    	$term = $request->term ?: '';
        $receta = Receta::join('insumo.sub_linea as subl','insumo.receta.rece_sublinea_id','=','subl.sublin_id')
        				->join('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')
        				->join('insumo.unidad_medida as uni','insumo.receta.rece_uni_id','=','uni.umed_id')
        				->where('rece_estado','A')->where('rece_nombre','LIKE','%'.$term.'%')->take(35)->get();
        $recetas = [];
        foreach ($receta as $rec) {
            if ($rec->sab_id == 1) {
                $recetas[] = ['id' => $rec->rece_id, 'text' => $rec->rece_nombre.' '.$rec->rece_presentacion];
            }else{
                $recetas[] = ['id' => $rec->rece_id, 'text' => $rec->rece_nombre.' '.$rec->sab_nombre.' '.$rec->rece_presentacion];
            }
        }
        return \Response::json($recetas);
    }

    public function stock_actualOP($id_insumo, $id_planta)
    {
    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $stock_actual = Stock::select(DB::raw('SUM(stock_cantidad) as stock_cantidad'))->where('stock_planta_id','=',$id_planta)
                                    ->where('stock_ins_id','=',$id_insumo)->first();
        if($stock_actual->stock_cantidad == null)
        {
            $stock_actual->stock_cantidad = 0;
        }
        $stock_actual->ins_id = $id_insumo;
        return response()->json($stock_actual);
    }
    public function StockActualOPMaq($id_insumo)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $stock_actual = Stock::select(DB::raw('SUM(stock_cantidad) as stock_cantidad'))->where('stock_planta_id','=',$planta->id_planta)->where('stock_ins_id','=',$id_insumo)->first();
        return response()->json($stock_actual);
    }
    public function ordenProduccionCreate(Request $request)
    {
        //return $table_formbase = json_decode($request->formulaciones_base);
        //dd($request);    
        //roddwy estan son las 3 tablas con la informacion que te manda de lo que se hizo en e l formuclario
        //return compact('tabla_materia_prima','tabla_saborizaciones','tabla_envasados','table_formbase');
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_receta = $request['receta_id'];
        $planta_producion = $request['planta_id'];
        $cantidad_orden = $request['cantidad_producir'];
        $mercado_id = $request['mercado_id'];
        $rendimiento_base =$request['rece_rendimiento_base'];
        $observacion = $request['observacion'];
        //dd('Receta: '.$id_receta.', Planta: '.$planta_producion.', Cantidad: '.$cantidad_orden.', mercado: '.$mercado_id);
        $num = OrdenProduccion::join('public._bp_planta as plant', 'insumo.orden_produccion.orprod_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(orprod_nro_orden) as nro_op'))->where('plant.id_planta', $planta_producion)->first();
        $cont=$num['nro_op'];
        $nop = $cont + 1;
        $orden_produccion = OrdenProduccion::create([
            'orprod_rece_id'    => $id_receta,
            'orprod_codigo'     => '0001',
            'orprod_nro_orden'  => $nop,
            //'orprod_nro_salida' => 1,
            'orprod_tiempo_prod' => $request['tiempo_producir'],
            'orprod_cant_esp' => $request['cantidad_esperada'],
            'orprod_cantidad'   => $cantidad_orden,
            'orprod_mercado_id'    => $mercado_id,
            'orprod_planta_id'  => $planta_producion,
            'orprod_usr_id'     => Auth::user()->usr_id,
            'orprod_tiporprod_id'   => 1,
            'orprod_obs_usr'    => $observacion,
            'orprod_estado_recep'=>'PENDIENTE',
        ]);
        $dato_calculo = $cantidad_orden/$rendimiento_base;
        //dd($dato_calculo);
        //$detalle_receta = DetalleReceta::where('detrece_rece_id',$id_receta)->get();

        /*foreach ($detalle_receta as $detrece) {
            DetalleOrdenProduccion::create([
                'detorprod_orprod_id'   => $orden_produccion->orprod_id,
                'detorprod_ins_id'      => $detrece->detrece_ins_id,
                'detorprod_cantidad'    => $detrece->detrece_cantidad*$dato_calculo,
            ]);
        }*/
        $receta = Receta::find($request['receta_id']);
        if ($receta->rece_lineaprod_id == 1 OR $receta->rece_lineaprod_id == 4 OR $receta->rece_lineaprod_id == 5) {
            $tabla_saborizaciones = json_decode($request->saborizaciones);
            foreach ($tabla_saborizaciones as $tsab) {
                //return $tsab;
                //dd($tsab->ins_id);
                DetalleOrdenProduccion::create([
                    'detorprod_orprod_id'   => $orden_produccion->orprod_id,
                    'detorprod_ins_id'      => $tsab->ins_id,
                    'detorprod_cantidad'    => $tsab->cant_ent,
                    'detorprod_fc'          => $tsab->cant_por,
                    'detorprod_cantidad_cal'=> $tsab->cant_cal,
                ]);
            }
            $tabla_envasados = json_decode($request->envasados);
            foreach ($tabla_envasados as $tenv) {
                //return $tsab;
                //dd($tsab->ins_id);
                DetalleOrdenProduccion::create([
                    'detorprod_orprod_id'   => $orden_produccion->orprod_id,
                    'detorprod_ins_id'      => $tenv->ins_id,
                    'detorprod_cantidad'    => $tenv->cant_ent,
                    'detorprod_fc'          => $tenv->cant_por,
                    'detorprod_cantidad_cal'=> $tenv->cant_cal,
                ]);
            }
            $table_formbase = json_decode($request->formulaciones_base);
            foreach ($table_formbase as $tformb) {
                //return $tsab;
                //dd($tsab->ins_id);
                DetalleOrdenProduccion::create([
                    'detorprod_orprod_id'   => $orden_produccion->orprod_id,
                    'detorprod_ins_id'      => $tformb->ins_id,
                    'detorprod_cantidad'    => $tformb->cant_ent,
                    'detorprod_fc'          => $tformb->cant_por,
                    'detorprod_cantidad_cal'=> $tformb->cant_cal,
                ]);
            }
        }elseif($receta->rece_lineaprod_id == 2 OR $receta->rece_lineaprod_id == 3)
        {
            $tabla_materia_prima = json_decode($request->materias_prima);
            foreach ($tabla_materia_prima as $tmap) {
                DetalleOrdenProduccion::create([
                    'detorprod_orprod_id'   => $orden_produccion->orprod_id,
                    'detorprod_ins_id'      => $tmap->ins_id,
                    'detorprod_cantidad'    => $tmap->cant_ent,
                    'detorprod_fc'          => $tmap->cant_por,
                    'detorprod_cantidad_cal'=> $tmap->cant_cal,
                ]);
            }
            $tabla_envasados = json_decode($request->envasados);
            foreach ($tabla_envasados as $tenv) {
                //return $tsab;
                //dd($tsab->ins_id);
                DetalleOrdenProduccion::create([
                    'detorprod_orprod_id'   => $orden_produccion->orprod_id,
                    'detorprod_ins_id'      => $tenv->ins_id,
                    'detorprod_cantidad'    => $tenv->cant_ent,
                    'detorprod_fc'          => $tenv->cant_por,
                    'detorprod_cantidad_cal'=> $tenv->cant_cal,
                ]);
            }
        }

        return redirect('OrdenProduccion')->with('success','Registro creado satisfactoriamente');

    }

    public function boletaOrdenProduccion($id_orprod)
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
        $pdf->SetSubject('ORDEN PRODUCCION INSUMOS');
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

        $receta = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                        ->join('insumo.sub_linea as subl','rece.rece_sublinea_id','=','subl.sublin_id')
                        ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                        ->join('insumo.unidad_medida as uni','rece.rece_uni_id','=','uni.umed_id')
                        ->join('insumo.mercado as mer','insumo.orden_produccion.orprod_mercado_id','=','mer.mer_id')
                        ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')->where('orprod_id',$id_orprod)->first();
        //dd($receta);
        if ($receta->rece_lineaprod_id == 1) {
            $datos_json = json_decode($receta->rece_datos_json);
        }

        $html = '
                    <table border="0" cellspacing="0" cellpadding="1">
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
                                        <th align="center">'.$receta->orprod_nro_orden.'</th>
                                    </tr>
                                </table>
                             </th>
                        </tr>
                    </table>

                    <br><br><br><br>
                    <table border="1">
                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="135"><strong color="white">NOMBRE PRODUCTO:</strong></th>
                            <th width="315"> '.$receta->rece_nombre.' '.$receta->sab_nombre.' '.$receta->rece_presentacion.' '.$receta->umed_nombre.'</th>
                            <th align="center" bgcolor="#5c6875" width="135"><strong color="white">No. Orden Producción:</strong></th>
                            <th width="70"> '.$receta->orprod_nro_orden.'</th>
                        </tr>
                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="135"><strong color="white">Cantidad a Producir:</strong></th>
                            <th width="80"> '.$receta->orprod_cantidad.'</th>
                            <th align="center" bgcolor="#5c6875" width="65"><strong color="white">Planta:</strong></th>
                            <th width="170"> '.$receta->nombre_planta.'</th>
                            <th align="center" bgcolor="#5c6875" width="65"><strong color="white">Mercado:</strong></th>
                            <th width="140"> '.$receta->mer_nombre.'</th>
                        </tr>
                    </table>
                    <br>
                    ';
                if ($receta->rece_lineaprod_id==2 OR $receta->rece_lineaprod_id==3) {
                    $html = $html.'<br><br>
                    <table>
                        <tr>
                            <th align="center" style="color:black;font-size:11"><strong>MATERIA PRIMA</strong></th>
                        </tr>
                    </table>
                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr BGCOLOR="#f3f0ff">
                            <th align="center" bgcolor="#5c6875" width="30"><strong color="white">N°</strong></th>
                            <th align="center" bgcolor="#5c6875" width="280"><strong color="white">Insumo</strong></th>
                            <th align="center" bgcolor="#5c6875" width="200"><strong color="white">Unidad Medida</strong></th>
                            <th align="center" bgcolor="#5c6875" width="150"><strong color="white">Cantidad</strong></th>
                        </tr> ';
                    $detalle_formulacion = DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',3)
                                                        ->where('detorprod_orprod_id',$receta->orprod_id)->get();
                    //dd($detalle_formulacion);
                    $nro = 0;
                    foreach ($detalle_formulacion as $detform){
                        $nro = $nro + 1;
                        $html = $html .'<tr BGCOLOR="#f3f0ff">
                            <td align="center">'.$nro.'</td>
                            <td align="center">'.$detform->ins_desc.'</td>
                            <td align="center">'.$detform->umed_nombre.'</td>
                            <td align="center">'.$detform->detorprod_cantidad.'</td>
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
                    $insumo_insumo = DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',1)
                                                        ->where('detorprod_orprod_id',$receta->orprod_id)->get();
                    $insumo_matprima = DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',3)
                                                        ->where('detorprod_orprod_id',$receta->orprod_id)->get();
                    //dd($insumo_matprima);
                    foreach ($insumo_insumo as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detorprod_cantidad"=>$ins->detorprod_cantidad);
                    }
                    foreach ($insumo_matprima as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detorprod_cantidad"=>$ins->detorprod_cantidad);
                    }
                    //dd($detalle_formulacion);
                    $nro = 0;
                    foreach ($detalle_formulacion as $detform){
                        $nro = $nro + 1;
                        $html = $html .'<tr BGCOLOR="#f3f0ff">
                            <td align="center">'.$nro.'</td>
                            <td align="center">'.$detform['ins_desc'].'</td>
                            <td align="center">'.$detform['umed_nombre'].'</td>
                            <td align="center">'.$detform['detorprod_cantidad'].'</td>
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

                        <tr>
                            <th align="center" bgcolor="#5c6875" width="30"><strong color="white">N°</strong></th>
                            <th align="center" bgcolor="#5c6875" width="280"><strong color="white">Insumo</strong></th>
                            <th align="center" bgcolor="#5c6875" width="200"><strong color="white">Unidad Medida</strong></th>
                            <th align="center" bgcolor="#5c6875" width="150"><strong color="white">Cantidad</strong></th>
                        </tr> ';
                    $detalle_formulacion = DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('detorprod_orprod_id',$receta->orprod_id)
                                                        ->where('ins_id_tip_ins',4)->get();
                    //dd($detalle_formulacion);
                    $nro = 0;
                    foreach ($detalle_formulacion as $detform){
                        $nro = $nro + 1;
                        $html = $html .'<tr BGCOLOR="#f3f0ff">
                            <td align="center">'.$nro.'</td>
                            <td align="center">'.$detform->ins_desc.'</td>
                            <td align="center">'.$detform->umed_nombre.'</td>
                            <td align="center">'.$detform->detorprod_cantidad.'</td>
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
                    $detalle_formulacion = DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('detorprod_orprod_id',$receta->orprod_id)
                                                        ->where('ins_id_tip_ins',2)->get();
                    //dd($detalle_formulacion);
                    $nro = 0;
                    foreach ($detalle_formulacion as $detform){
                        $nro = $nro + 1;
                        $html = $html .'<tr BGCOLOR="#f3f0ff">
                            <td align="center">'.$nro.'</td>
                            <td align="center">'.$detform->ins_desc.'</td>
                            <td align="center">'.$detform->umed_nombre.'</td>
                            <td align="center">'.$detform->detorprod_cantidad.'</td>
                        </tr>';
                    }
                    $html = $html . '</table>';


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
    //RECEPCION DE ORDEN PRODUCCION
    public function menuRecepcionORP()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        //$orden_produccion = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
        //                                    ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')->where('orprod_planta_id',$planta->id_planta)->get();
        $orden_produccion = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                            ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')
                                            ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                            ->leftjoin('insumo.unidad_medida as umed','rece.rece_uni_id','=','umed.umed_id')
                                            ->where('orprod_planta_id',$planta->id_planta)
                                            ->orderBy('orprod_id','DESC')
                                            ->where('orprod_tiporprod_id',1)
                                            ->get();
        return view('backend.administracion.insumo.insumo_solicitud.insumo_recepcion_orp.index',compact('orden_produccion'));
    }

    public function createRecepcionOrp()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        //$orden_produccion = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
        //                                    ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')->where('orprod_planta_id',$planta->id_planta)->get();
        $orden_produccion = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                            ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')
                                            ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                            ->leftjoin('insumo.unidad_medida as umed','rece.rece_uni_id','=','umed.umed_id')
                                            ->where('orprod_planta_id',$planta->id_planta)
                                            ->orderBy('orprod_id','DESC')
                                            ->where('orprod_tiporprod_id',1)
                                            ->get();
        return Datatables::of($orden_produccion)->addColumn('nombreReceta', function ($nombreReceta) {
                return $nombreReceta->rece_nombre.' '.$nombreReceta->sab_nombre.' '.$nombreReceta->rece_presentacion;
        })->addColumn('lineaProduccion', function ($lineaProduccion) {
            if ($lineaProduccion->rece_lineaprod_id == 1) {
                return 'LACTEOS';
            }elseif($lineaProduccion->rece_lineaprod_id == 2){
                return 'ALMENDRA';
            }elseif($lineaProduccion->rece_lineaprod_id == 3) {
                return 'MIEL';
            }elseif($lineaProduccion->rece_lineaprod_id == 4) {
                return 'FRUTOS';
            }elseif($lineaProduccion->rece_lineaprod_id == 5) {
                return 'DERIVADOS';
            }
        })->addColumn('estadoAprobacion', function ($estadoAprobacion) {
            if ($estadoAprobacion->orprod_estado_orp == 'A') {
                return $this->traeUser($estadoAprobacion->orprod_usr_id);
            }elseif($estadoAprobacion->orprod_estado_orp == 'B'){
                return $this->traeUser($estadoAprobacion->orprod_usr_vo);
            }elseif($estadoAprobacion->orprod_estado_orp == 'C') {
                return $this->traeUser($estadoAprobacion->orprod_usr_vodos);
            }elseif($estadoAprobacion->orprod_estado_orp == 'D') {
            return $this->traeUser($estadoAprobacion->orprod_usr_aprob);
            }
        })
        ->addColumn('acciones', function ($orden_produccion) {
            if($orden_produccion->orprod_estado_orp == 'B'){
                return '<div class="text-center"><a href="BoletaOrdenProduccionRorp/' . $orden_produccion->orprod_id . '" class="btn btn-md btn-primary" target="_blank">'.$orden_produccion->orprod_nro_orden.'</a></div>';
            }elseif($orden_produccion->orprod_estado_orp == 'A'){
                return '<div class="text-center"><a  onClick="CambiarEstado('.$orden_produccion->orprod_id.');" href="frmRecepORP/' . $orden_produccion->orprod_id . '" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> VER</a><div>';
            }elseif($orden_produccion->orprod_estado_orp == 'C'){
                //return 'PEDIDO ENVIADO A ALMACEN';
                return '<div class="text-center"><a href="BoletaOrdenProduccionRorp/' . $orden_produccion->orprod_id . '" class="btn btn-md btn-primary" target="_blank">'.$orden_produccion->orprod_nro_orden.'</a></div>';
            }elseif($orden_produccion->orprod_estado_orp == 'D'){
                //return 'RECEPCIONADO EN ALMACEN';
                return '<div class="text-center"><a href="BoletaOrdenProduccionRorp/' . $orden_produccion->orprod_id . '" class="btn btn-md btn-primary" target="_blank">'.$orden_produccion->orprod_nro_orden.'</a></div>';
            }

        })
            ->editColumn('id', 'ID: {{$orprod_id}}')

            ->make(true);
    }

    public function showFrmRecepORP($id_ordenOrp)
    {
        $sol_orden_produccion = OrdenProduccion::where('orprod_id',$id_ordenOrp)->first();
        $receta = Receta::join('insumo.sub_linea as sub','insumo.receta.rece_sublinea_id','=','sub.sublin_id')
                        ->join('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')
                        ->join('insumo.unidad_medida as umed','insumo.receta.rece_uni_id','=','umed.umed_id')
                        ->where('rece_id',$sol_orden_produccion->orprod_rece_id)->first();
        $detalle_sol_orp = DetalleOrdenProduccion::where('detorprod_orprod_id',$sol_orden_produccion->orprod_id)->get();
        //dd($sol_orden_produccion);
        return view('backend.administracion.insumo.insumo_solicitud.insumo_recepcion_orp.partials.formRecepcionORP', compact('sol_orden_produccion','detalle_sol_orp','receta'));
    }

    public function receOrdenProduccionCreate(Request $request)
    {
        //dd($request['obs_usr_vo']);
        $orden_produccion_update = OrdenProduccion::find($request['id_orp']);
        $orden_produccion_update->orprod_obs_vo = $request['obs_usr_vo'];
        $orden_produccion_update->orprod_usr_vo = Auth::user()->usr_id;
        $orden_produccion_update->orprod_estado_orp = 'B';
        $orden_produccion_update->orprod_estado_recep = 'RECEPCION JEFE PLANTA';
        $orden_produccion_update->save();
        //dd($orden_produccion_update);
        return redirect('RecepcionORP')->with('success','Registro creado satisfactoriamente');
    }

    //SOLICITUD ORP RECETA
    public function menuSolOrpReceta()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        //$orden_produccion = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                            //->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')->where('orprod_planta_id',$planta->id_planta)
                                            //->where('orprod_usr_vo','<>',null)->get();
        $orden_produccion = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                            ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')
                                            ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                            ->leftjoin('insumo.unidad_medida as umed','rece.rece_uni_id','=','umed.umed_id')
                                            ->where('orprod_planta_id',$planta->id_planta)
                                            ->where('orprod_usr_vo','<>',null)
                                            ->where('orprod_tiporprod_id',1)
                                            ->orderBy('orprod_id','DESC')
                                            ->get();
        return view('backend.administracion.insumo.insumo_solicitud.insumo_solicitud_orp.index',compact('orden_produccion'));
    }
    public function createSolcitudOrp()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        //$orden_produccion = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                            //->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')->where('orprod_planta_id',$planta->id_planta)
                                            //->where('orprod_usr_vo','<>',null)->get();
        $orden_produccion = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                            ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')
                                            ->leftjoin('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                                            ->leftjoin('insumo.unidad_medida as umed','rece.rece_uni_id','=','umed.umed_id')
                                            ->where('orprod_planta_id',$planta->id_planta)
                                            ->where('orprod_usr_vo','<>',null)
                                            ->where('orprod_tiporprod_id',1)
                                            ->orderBy('orprod_id','DESC')
                                            ->get();
        return Datatables::of($orden_produccion)->addColumn('nombreReceta', function ($nombreReceta) {
                return $nombreReceta->rece_nombre.' '.$nombreReceta->sab_nombre.' '.$nombreReceta->rece_presentacion;
        })->addColumn('lineaProduccion', function ($lineaProduccion) {
            if ($lineaProduccion->rece_lineaprod_id == 1) {
                return 'LACTEOS';
            }elseif($lineaProduccion->rece_lineaprod_id == 2){
                return 'ALMENDRA';
            }elseif($lineaProduccion->rece_lineaprod_id == 3) {
                return 'MIEL';
            }elseif($lineaProduccion->rece_lineaprod_id == 4) {
                return 'FRUTOS';
            }elseif($lineaProduccion->rece_lineaprod_id == 5) {
                return 'DERIVADOS';
            }
        })->addColumn('estadoAprobacion', function ($estadoAprobacion) {
            if ($estadoAprobacion->orprod_estado_orp == 'A') {
                return $this->traeUser($estadoAprobacion->orprod_usr_id);
            }elseif($estadoAprobacion->orprod_estado_orp == 'B'){
                return $this->traeUser($estadoAprobacion->orprod_usr_vo);
            }elseif($estadoAprobacion->orprod_estado_orp == 'C') {
                return $this->traeUser($estadoAprobacion->orprod_usr_vodos);
            }elseif($estadoAprobacion->orprod_estado_orp == 'D') {
            return $this->traeUser($estadoAprobacion->orprod_usr_aprob);
            }
        })->addColumn('acciones', function ($orden_produccion) {
            if ($orden_produccion->orprod_estado_orp=='C') {
                return '<div class="text-center"><a href="BoletaOrdenProduccionSolalorp/' . $orden_produccion->orprod_id . '" class="btn btn-md btn-primary" target="_blank">'.$orden_produccion->orprod_nro_orden.'</a></div>';
            }elseif($orden_produccion->orprod_estado_orp=='B'){
                return '<div class="text-center"><a href="frmSoliORP/' . $orden_produccion->orprod_id . '" class="btn btn-success"><i class="fa fa-eye"></i></a><div>';
            }elseif($orden_produccion->orprod_estado_orp == 'D'){
                //return 'RECEPCIONADO EN ALMACEN';
                return '<div class="text-center"><a href="BoletaOrdenProduccionSolalorp/' . $orden_produccion->orprod_id . '" class="btn btn-md btn-primary" target="_blank">'.$orden_produccion->orprod_nro_orden.'</a></div>';
            }
            //return $orden_produccion->orprod_estado_orp;
        })
            ->editColumn('id', 'ID: {{$orprod_id}}')

            ->make(true);
    }
    public function showFrmSoliORP($id_ordenOrp)
    {
        $sol_orden_produccion = OrdenProduccion::where('orprod_id',$id_ordenOrp)->first();
        $receta = Receta::join('insumo.sub_linea as sub','insumo.receta.rece_sublinea_id','=','sub.sublin_id')
                        ->join('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')
                        ->join('insumo.unidad_medida as umed','insumo.receta.rece_uni_id','=','umed.umed_id')
                        ->where('rece_id',$sol_orden_produccion->orprod_rece_id)->first();
        $detalle_sol_orp = DetalleOrdenProduccion::where('detorprod_orprod_id',$sol_orden_produccion->orprod_id)->get();
        //dd($sol_orden_produccion);
        return view('backend.administracion.insumo.insumo_solicitud.insumo_solicitud_orp.partials.formSolicitudORP', compact('sol_orden_produccion','detalle_sol_orp','receta'));
    }
    public function soliOrdenProduccionCreate(Request $request)
    {
        //dd($request['obs_usr_vo']);
        $orden_produccion_update = OrdenProduccion::find($request['id_orp']);
        $orden_produccion_update->orprod_obs_vodos = $request['obs_usr_vodos'];
        $orden_produccion_update->orprod_usr_vodos = Auth::user()->usr_id;
        $orden_produccion_update->orprod_estado_orp = 'C';
        $orden_produccion_update->orprod_estado_recep = 'PENDIENTE ENTREGAR INSUMOS';
        $orden_produccion_update->orprod_fecha_vodos = Carbon::now();
        $orden_produccion_update->save();
        //dd($orden_produccion_update);
        return redirect('SolOrpReceta')->with('success','Registro creado satisfactoriamente');
    }

    public function cambioEstadoRecepOrp($id)
    {
        $orp_recep = OrdenProduccion::find($id);
        $orp_recep->orprod_estado_recep = 'VISTO';
        $orp_recep->orprod_fecha_vo = Carbon::now();
        $orp_recep->save();
    }
}
