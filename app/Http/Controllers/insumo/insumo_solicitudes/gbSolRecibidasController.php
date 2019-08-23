<?php

namespace siga\Http\Controllers\insumo\insumo_solicitudes;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_solicitud\Solicitud;
use siga\Modelo\insumo\insumo_solicitud\Solicitud_Adicional;
use siga\Modelo\insumo\insumo_solicitud\Solicitud_Maquila;
use siga\Modelo\insumo\insumo_solicitud\Solicitud_Receta;
use siga\Modelo\insumo\insumo_solicitud\Aprobacion_Solicitud;
use siga\Modelo\insumo\insumo_solicitud\DetalleAprobSol;
use siga\Modelo\insumo\insumo_registros\DetalleIngresoData;
use siga\Modelo\insumo\Stock_Almacen;
use siga\Modelo\HistoStock;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\Usuario;
//ORDEN PRODUCCION
use siga\Modelo\insumo\insumo_recetas\Receta;
use siga\Modelo\insumo\insumo_recetas\DetalleReceta;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion;
use siga\Modelo\insumo\Stock;
use siga\Modelo\insumo\InsumoHistorial;
use siga\Modelo\insumo\insumo_registros\Ingreso;
use siga\Modelo\insumo\insumo_registros\DetalleIngreso;
use DB;
use Auth;
use Carbon\Carbon;
use PDF;
use TCPDF;

class gbSolRecibidasController extends Controller
{
     public function index()
    {	
    	$solReceta = OrdenProduccion::where('orprod_estado_orp','C')->get();
    	return view('backend.administracion.insumo.insumo_solicitud.solicitud_recibida.index');
    }

    public function create()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
    	$solReceta = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                    ->join('public._bp_usuarios as usr','insumo.orden_produccion.orprod_usr_id','=','usr.usr_id')
                                    ->join('public._bp_personas as per','usr.usr_prs_id','=','per.prs_id')
                                    ->where('orprod_estado_orp','<>','A')
                                    ->where('orprod_estado_orp','<>','B')
                                    ->where('orprod_tiporprod_id',1)
                                    ->where('orprod_planta_id',$planta->id_planta)->get();

        return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
            if($solReceta->orprod_estado_orp == 'D')
            {
                return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" class="btn btn-md btn-primary" target="_blank">Boleta Salida <i class="fa fa-file"></i></a></div>';
            }elseif($solReceta->orprod_estado_orp =='C'){
                return '<div class="text-center"><a href="FormMostrarReceta/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
            }
        })
            ->editColumn('id', 'ID: {{$orprod_id}}')
            -> addColumn('estado_orprod', function ($solReceta) {
                if($solReceta->orprod_estado_orp =='C')
                { 
                    return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>'; 
                }elseif($solReceta->orprod_estado_orp == 'D')
                {
                    return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
                }elseif($solReceta->orprod_estado_orp=='E')
                { 
                    return '<h4 class="text"><span class="label label-danger">RECHAZADO</span></h4>'; 
                }
                            
             }) 
        
            -> addColumn('nombresCompletoRe', function ($solReceta) {
            return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
        })
            ->make(true);
    }
    public function formMostrarReceta($id_ordenOrp)
    {
        $sol_orden_produccion = OrdenProduccion::where('orprod_id',$id_ordenOrp)->first();
        $receta = Receta::join('insumo.sub_linea as sub','insumo.receta.rece_sublinea_id','=','sub.sublin_id')
                        ->join('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')
                        ->join('insumo.unidad_medida as umed','insumo.receta.rece_uni_id','=','umed.umed_id')
                        ->where('rece_id',$sol_orden_produccion->orprod_rece_id)->first();
        $detalle_sol_orp = DetalleOrdenProduccion::where('detorprod_orprod_id',$sol_orden_produccion->orprod_id)->get();
        return view('backend.administracion.insumo.insumo_solicitud.solicitud_recibida.partials.formMostrarReceta',compact('sol_orden_produccion','receta','detalle_sol_orp'));
    }
    public function aprobacionReceta(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();    
        $id_planta=$planta->id_planta;
        $num = OrdenProduccion::join('public._bp_planta as plant', 'insumo.orden_produccion.orprod_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(orprod_nro_salida) as nrosal'))->where('plant.id_planta', $id_planta)->first();
        $cont=$num['nrosal'];
        $nro_sal = $cont + 1;
        $orden_produccion_aprob = OrdenProduccion::find($request['id_orp']);
        //STOCK
        $detoprod = DetalleOrdenProduccion::where('detorprod_orprod_id',$orden_produccion_aprob->orprod_id)->get();
        foreach ($detoprod as $det) {
            $stocks = Stock::where('stock_ins_id','=',$det->detorprod_ins_id)
                          ->where('stock_planta_id',$id_planta)
                          ->where('stock_cantidad','>',0)
                          ->orderBy('stock_id','Asc')
                          ->get();
            $cantidad_aprobada = $det->detorprod_cantidad;
            foreach ($stocks as $stock) {
                if ($cantidad_aprobada>0) {
                    if ($cantidad_aprobada >= $stock->stock_cantidad) {
                        $cantidad_aprobada = $cantidad_aprobada - $stock->stock_cantidad;
                        $descuento = $stock->stock_cantidad;
                        $stock->stock_cantidad = 0;
                    }else
                    {
                        $stock->stock_cantidad = $stock->stock_cantidad - $cantidad_aprobada;
                        $descuento = $cantidad_aprobada;
                        $cantidad_aprobada = 0;
                    }
                    $stock->save();
                    //AQUI IRA PARA LA TABLA INSUMOS HISTORY
                    InsumoHistorial::create([
                            'inshis_ins_id'     => $det->detorprod_ins_id,
                            'inshis_planta_id'  => $id_planta,
                            'inshis_tipo'       => 'Salida',
                            'inshis_deting_id'  => $stock->stock_deting_id,//para el costo de ingreso
                            'inshis_detorprod_id'  => $det->detorprod_id,
                            'inshis_cantidad'   => $descuento,
                    ]);
                    //END INSUMOS HISTORY
                }
                
            }
        }
        //END SOCK
        $orden_produccion_aprob->orprod_nro_salida = $nro_sal;
        $orden_produccion_aprob->orprod_usr_aprob = Auth::user()->usr_id;
        $orden_produccion_aprob->orprod_obs_aprob = $request['obs_usr_aprob'];
        $orden_produccion_aprob->orprod_estado_orp = 'D';
        $orden_produccion_aprob->save();
        return redirect('solRecibidas')->with('success','Registro creado satisfactoriamente');
    }
    public function boletaAprovReceta($id_orp_aprob)
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
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
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

        $reg = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                    ->join('public._bp_planta as planta','insumo.orden_produccion.orprod_planta_id','=','planta.id_planta')
                                    ->join('insumo.mercado as merc','insumo.orden_produccion.orprod_mercado_id','=','merc.mer_id')
                                    ->where('orprod_id','=',$id_orp_aprob)->first();
        //$data = $reg['sol_data'];
    
        //$array = json_decode($data);
    
        $html = '<br><br> 
                    <table border="0" cellspacing="0" cellpadding="1" class="bottomBorder">
                        <tr>
                            <th rowspan="3" align="center" width="150"><img src="img/logopeqe.png" width="150" height="105"></th>
                            <th rowspan="3" width="375"><h3 align="center"><br>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS<br>ALMACEN - ' . $planta['nombre_planta']. '</h3><br><h2 align="center">NOTA DE SALIDA O APROBACIÓN SOLICITUD</h2>
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
                                        <th align="center">'.$reg['orprod_nro_salida'].'/'.date('Y',strtotime($reg['orprod_registrado'])).'</th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </table>
                    <br><br><br><br><br>
                        <table border="1">
                            <tr BGCOLOR="#f3f0ff">
                                <th align="center" width="70" bgcolor="#5c6875"><strong color="white">Solicitante:</strong></th>
                                <th width="185"> '.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</th>
                                <th align="center" width="85" bgcolor="#5c6875"><strong color="white">Dependencia:</strong></th>
                                <th width="165"> '.$reg['nombre_planta'].'</th>                                
                                <th align="center" width="95" bgcolor="#5c6875"><strong color="white">Fecha Solicitud:</strong></th>
                                <th width="65"> '.date('d/m/Y',strtotime($reg['orprod_registrado'])).'</th>
                            </tr>
                            <tr BGCOLOR="#f3f0ff">
                                <th align="center" width="130" bgcolor="#5c6875"><strong color="white">No. Orden Produccion:</strong></th>
                                <th width="80"> '.$reg['orprod_nro_orden'].'</th>
                                <th align="center" width="100" bgcolor="#5c6875"><strong color="white">Mercado:</strong></th>
                                <th width="195"> '.$reg['mer_nombre'].'</th>                                
                                <th align="center" width="95" bgcolor="#5c6875"><strong color="white">Fecha Entrega:</strong></th>
                                <th width="65"> '.date('d/m/Y',strtotime($reg['orprod_modificado'])).'</th>
                            </tr>
                        </table>
                        
                    <br><br><br>

                    <table border="1" cellspacing="0" style="font-size:8px;">                     
                        <tr>
                            <th align="center" bgcolor="#5c6875" width="50"><strong color="white">Nro</strong></th>
                            <th align="center" bgcolor="#5c6875" width="120"><strong color="white">Unidad</strong></th>
                            <th align="center" bgcolor="#5c6875" width="215"><strong color="white">Descripcion</strong></th>
                            <th align="center" bgcolor="#5c6875" width="70"><strong color="white">Cantidad</strong></th>
                            <th align="center" bgcolor="#5c6875" width="205"><strong color="white">Mercado</strong></th>
                        </tr> ';
                        $nro=0;
                    $detroprod = DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('detorprod_orprod_id',$reg->orprod_id)->get();
                    foreach ($detroprod as $d) {
                        $nro = $nro+1; 
                        
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">'.$nro.'</td>
                                    <td align="center">'.$d->umed_nombre.'</td>
                                    <td align="center">'.$d->ins_desc.'</td>
                                    <td align="center">'.$d->detorprod_cantidad.'</td>
                                    <td align="center">'.$reg['mer_nombre'].'</td>
                                  </tr>';  
                     }
                     $html = $html . '<tr BGCOLOR="#f3f0ff">
                                        <td align="center" colspan="3" bgcolor="#5c6875"><strong color="white">TOTAL TIPOS DE INSUMOS SOLICITADOS</strong></td>
                                        <td align="center"><strong>'.$nro.'</strong></td>
                                        <td></td>
                                      </tr>
                            </table><br><br><br><br><br><br><br><br><br><br><br><br>';

                      $html = $html . '
                                <table>
                            <tr>
                                <td align="center">.................................................</td>
                                
                                <td align="center">.................................................</td>

                                <td align="center">.................................................</td>
                                
                                <td align="center">.................................................</td>

                            </tr>
                            <tr>
                                <td align="center">Solicitante</td>
                                
                                <td align="center">Responsable de Almacen</td>

                                <td align="center">Responsable Administrativo</td>
                                
                                <td align="center">Jefe de Planta</td>
                            </tr>                           
                            
                            </table>
                            ';   

                    $htmltable = $html;
        $pdf->writeHTML($htmltable, true, 0, true, 0);
        $pdf->lastPage();

        $pdf->Output('boletaAprobacionReceta-'.$reg['aprsol_id'].'.pdf', 'I');

    }
    //SOLICITUD INSUMO ADICIONAL
    public function aprobacionSolAdicional(Request $request)
    {
        //dd($request['id_orp']);
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();    
        $id_planta=$planta->id_planta;
        $num = OrdenProduccion::join('public._bp_planta as plant', 'insumo.orden_produccion.orprod_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(orprod_nro_salida) as nrosal'))->where('plant.id_planta', $id_planta)->first();
        $cont=$num['nrosal'];
        $nro_sal = $cont + 1;
        $orden_produccion_aprob = OrdenProduccion::find($request['id_orp']);
        //STOCK
        $detoprod = DetalleOrdenProduccion::where('detorprod_orprod_id',$orden_produccion_aprob->orprod_id)->get();
        foreach ($detoprod as $det) {
            $stocks = Stock::where('stock_ins_id','=',$det->detorprod_ins_id)
                          ->where('stock_planta_id',$id_planta)
                          ->where('stock_cantidad','>',0)
                          ->orderBy('stock_id','Asc')
                          ->get();
            $cantidad_aprobada = $det->detorprod_cantidad;
            foreach ($stocks as $stock) {
                if ($cantidad_aprobada>0) {
                    if ($cantidad_aprobada >= $stock->stock_cantidad) {
                        $cantidad_aprobada = $cantidad_aprobada - $stock->stock_cantidad;
                        $descuento = $stock->stock_cantidad;
                        $stock->stock_cantidad = 0;
                    }else
                    {
                        $stock->stock_cantidad = $stock->stock_cantidad - $cantidad_aprobada;
                        $descuento = $cantidad_aprobada;
                        $cantidad_aprobada = 0;
                    }
                    $stock->save();
                    //AQUI IRA PARA LA TABLA INSUMOS HISTORY
                    InsumoHistorial::create([
                            'inshis_ins_id'     => $det->detorprod_ins_id,
                            'inshis_planta_id'  => $id_planta,
                            'inshis_tipo'       => 'Salida',
                            'inshis_deting_id'  => $stock->stock_deting_id,//para el costo de ingreso
                            'inshis_detorprod_id'  => $det->detorprod_id,
                            'inshis_cantidad'   => $descuento,
                    ]);
                    //END INSUMOS HISTORY
                }
                
            }
        }
        //END SOCK
        $orden_produccion_aprob->orprod_nro_salida = $nro_sal;
        $orden_produccion_aprob->orprod_usr_aprob = Auth::user()->usr_id;
        $orden_produccion_aprob->orprod_obs_aprob = $request['obs_usr_aprob'];
        $orden_produccion_aprob->orprod_estado_orp = 'D';
        $orden_produccion_aprob->save();
        return redirect('solRecibidas')->with('success','Registro creado satisfactoriamente');
    }
    //SOLCITUD MAQUILA
    public function listMaquila()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
        $solMaquila = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                    ->join('public._bp_usuarios as usr','insumo.orden_produccion.orprod_usr_id','=','usr.usr_id')
                                    ->join('public._bp_personas as per','usr.usr_prs_id','=','per.prs_id')
                                    ->join('insumo.planta_maquila as maq','insumo.orden_produccion.orprod_planta_maquila','=','maq.maquila_id')
                                    ->where('orprod_tiporprod_id',4)
                                    ->where('orprod_planta_id',$planta->id_planta)->get();
        return Datatables::of($solMaquila)->addColumn('acciones', function ($solMaquila) {
            if($solMaquila->orprod_estado_orp == 'D')
            {
                return '<div class="text-center"><a href="BoletaAprovReceta/' . $solMaquila->orprod_id . '" class="btn btn-md btn-primary" target="_blank">Boleta Salida <i class="fa fa-file"></i></a></div>';
            }elseif($solMaquila->orprod_estado_orp =='C'){
                return '<div class="text-center"><a href="FormMostrarMaquila/' . $solMaquila->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
            }
        })
            ->editColumn('id', 'ID: {{$orprod_id}}')
            -> addColumn('sol_maq_estado', function ($solMaquila) {
                if($solMaquila->orprod_estado_orp =='C')
                { 
                    return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>'; 
                }elseif($solMaquila->orprod_estado_orp == 'D')
                {
                    return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
                }elseif($solMaquila->orprod_estado_orp=='E')
                { 
                    return '<h4 class="text"><span class="label label-danger">RECHAZADO</span></h4>'; 
                }
                            
             }) 
            -> addColumn('nombresCompletoMa', function ($solMaquila) {
                return $solMaquila->prs_nombres . ' ' . $solMaquila->prs_paterno . ' ' . $solMaquila->prs_materno;
        })  
            ->make(true);
    }
    public function FormMostrarMaquila($id_ordenOrp)
    {
        $sol_orden_produccion = OrdenProduccion::where('orprod_id',$id_ordenOrp)->first();
        $receta = Receta::join('insumo.sub_linea as sub','insumo.receta.rece_sublinea_id','=','sub.sublin_id')
                        ->join('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')
                        ->join('insumo.unidad_medida as umed','insumo.receta.rece_uni_id','=','umed.umed_id')
                        ->where('rece_id',$sol_orden_produccion->orprod_rece_id)->first();
        $detalle_sol_orp = DetalleOrdenProduccion::where('detorprod_orprod_id',$sol_orden_produccion->orprod_id)->get();
        return view('backend.administracion.insumo.insumo_solicitud.solicitud_recibida.partials.formMostrarMaquila',compact('sol_orden_produccion','receta','detalle_sol_orp'));
    }
    //SOLICITUD ADICIONAL
     public function listAdicional()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
        $solAdicinal = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                    ->join('public._bp_usuarios as usr','insumo.orden_produccion.orprod_usr_id','=','usr.usr_id')
                                    ->join('public._bp_personas as per','usr.usr_prs_id','=','per.prs_id')
                                    ->where('orprod_tiporprod_id',2)
                                    ->where('orprod_planta_id',$planta->id_planta)->get();
        return Datatables::of($solAdicinal)->addColumn('acciones', function ($solAdicinal) {
            if($solAdicinal->orprod_estado_orp == 'D')
            {
                return '<div class="text-center"><a href="BoletaAprovReceta/' . $solAdicinal->orprod_id . '" class="btn btn-md btn-primary" target="_blank">Boleta Salida <i class="fa fa-file"></i></a></div>';
            }elseif($solAdicinal->orprod_estado_orp =='C'){
                return '<div class="text-center"><a href="FormMostrarSolAdicional/' . $solAdicinal->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
            }
        })
            ->editColumn('id', 'ID: {{$orprod_id}}')
            -> addColumn('sol_ins_estado', function ($solAdicinal) {
                if($solAdicinal->orprod_estado_orp =='C')
                { 
                    return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>'; 
                }elseif($solAdicinal->orprod_estado_orp == 'D')
                {
                    return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
                }elseif($solAdicinal->orprod_estado_orp=='E')
                { 
                    return '<h4 class="text"><span class="label label-danger">RECHAZADO</span></h4>'; 
                }
                            
             }) 
            -> addColumn('nombresCompletoAdi', function ($solAdicinal) {
                return $solAdicinal->prs_nombres . ' ' . $solAdicinal->prs_paterno . ' ' . $solAdicinal->prs_materno;
        })  
            ->make(true);
    }
    public function formMostrarSolAdicional($id_ordenOrp)
    {
        $sol_orden_produccion = OrdenProduccion::where('orprod_id',$id_ordenOrp)->first();
        $receta = Receta::join('insumo.sub_linea as sub','insumo.receta.rece_sublinea_id','=','sub.sublin_id')
                        ->join('insumo.sabor as sab','insumo.receta.rece_sabor_id','=','sab.sab_id')
                        ->join('insumo.unidad_medida as umed','insumo.receta.rece_uni_id','=','umed.umed_id')
                        ->where('rece_id',$sol_orden_produccion->orprod_rece_id)->first();
        $detalle_sol_orp = DetalleOrdenProduccion::where('detorprod_orprod_id',$sol_orden_produccion->orprod_id)->get();
        return view('backend.administracion.insumo.insumo_solicitud.solicitud_recibida.partials.formMostrarSolAdicional',compact('sol_orden_produccion','receta','detalle_sol_orp'));
    }
    //LISTAR SOLICITUDES TRASPASOS
    public function listTraspaso()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
        $solTraspaso = OrdenProduccion::join('insumo.receta as rece','insumo.orden_produccion.orprod_rece_id','=','rece.rece_id')
                                    ->join('public._bp_usuarios as usr','insumo.orden_produccion.orprod_usr_id','=','usr.usr_id')
                                    ->join('public._bp_personas as per','usr.usr_prs_id','=','per.prs_id')
                                    ->join('public._bp_planta as tras','insumo.orden_produccion.orprod_planta_traspaso','=','tras.id_planta')
                                    ->where('orprod_tiporprod_id',3)
                                    ->where('orprod_planta_traspaso',$planta->id_planta)->get();
        return Datatables::of($solTraspaso)->addColumn('acciones', function ($solTraspaso) {
            if($solTraspaso->orprod_estado_orp == 'D')
            {
                return '<div class="text-center"><a href="BoletaAprovReceta/' . $solTraspaso->orprod_id . '" class="btn btn-md btn-primary" target="_blank">Boleta Salida <i class="fa fa-file"></i></a></div>';
            }elseif($solTraspaso->orprod_estado_orp =='C'){
                return '<div class="text-center"><a href="FormMostrarTraspaso/' . $solTraspaso->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
            }
        })
            ->editColumn('id', 'ID: {{$orprod_id}}')
            -> addColumn('sol_tras_estado', function ($solTraspaso) {
                if($solTraspaso->orprod_estado_orp =='C')
                { 
                    return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>'; 
                }elseif($solTraspaso->orprod_estado_orp == 'D')
                {
                    return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
                }elseif($solTraspaso->orprod_estado_orp=='E')
                { 
                    return '<h4 class="text"><span class="label label-danger">RECHAZADO</span></h4>'; 
                }
                            
             }) 
            -> addColumn('nombresCompletoTras', function ($solMaquila) {
                return $solMaquila->prs_nombres . ' ' . $solMaquila->prs_paterno . ' ' . $solMaquila->prs_materno;
        })  
            ->make(true);
    }
    public function formMostrarTraspaso($id_tras)
    {
        $sol_orden_produccion = OrdenProduccion::where('orprod_id',$id_tras)->first();        
        $detalle_sol_orp = DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')->join('insumo.unidad_medida as umed','ins.ins_id_uni','=','umed.umed_id')->where('detorprod_orprod_id',$sol_orden_produccion->orprod_id)->get();
        return view('backend.administracion.insumo.insumo_solicitud.solicitud_recibida.partials.formMostrarTraspaso',compact('sol_orden_produccion','detalle_sol_orp'));
    }
    public function aprobacionMaquila(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();    
        $id_planta=$planta->id_planta;
        $num = OrdenProduccion::join('public._bp_planta as plant', 'insumo.orden_produccion.orprod_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(orprod_nro_salida) as nrosal'))->where('plant.id_planta', $id_planta)->first();
        $cont=$num['nrosal'];
        $nro_sal = $cont + 1;
        $orden_produccion_aprob = OrdenProduccion::find($request['id_orp']);
        //STOCK
        $detoprod = DetalleOrdenProduccion::where('detorprod_orprod_id',$orden_produccion_aprob->orprod_id)->get();
        foreach ($detoprod as $det) {
            $stocks = Stock::where('stock_ins_id','=',$det->detorprod_ins_id)
                          ->where('stock_planta_id',$id_planta)
                          ->where('stock_cantidad','>',0)
                          ->orderBy('stock_id','Asc')
                          ->get();
            $cantidad_aprobada = $det->detorprod_cantidad;
            foreach ($stocks as $stock) {
                if ($cantidad_aprobada>0) {
                    if ($cantidad_aprobada >= $stock->stock_cantidad) {
                        $cantidad_aprobada = $cantidad_aprobada - $stock->stock_cantidad;
                        $descuento = $stock->stock_cantidad;
                        $stock->stock_cantidad = 0;
                    }else
                    {
                        $stock->stock_cantidad = $stock->stock_cantidad - $cantidad_aprobada;
                        $descuento = $cantidad_aprobada;
                        $cantidad_aprobada = 0;
                    }
                    $stock->save();
                    //AQUI IRA PARA LA TABLA INSUMOS HISTORY
                    InsumoHistorial::create([
                            'inshis_ins_id'     => $det->detorprod_ins_id,
                            'inshis_planta_id'  => $id_planta,
                            'inshis_tipo'       => 'Salida',
                            'inshis_deting_id'  => $stock->stock_deting_id,//para el costo de ingreso
                            'inshis_detorprod_id'  => $det->detorprod_id,
                            'inshis_cantidad'   => $descuento,
                    ]);
                    //END INSUMOS HISTORY
                }
                
            }
        }
        //END SOCK
        $orden_produccion_aprob->orprod_nro_salida = $nro_sal;
        $orden_produccion_aprob->orprod_usr_aprob = Auth::user()->usr_id;
        $orden_produccion_aprob->orprod_obs_aprob = $request['obs_usr_aprob'];
        $orden_produccion_aprob->orprod_estado_orp = 'D';
        $orden_produccion_aprob->save();
        return redirect('solRecibidas')->with('success','Registro creado satisfactoriamente');
    }
    public function aprobacionTraspaso(Request $request)
    {
        //ARRAY ITEMS TRASPASO
        $ins_id = $request['id_insumo_tras'];
        $cantidad_ins = $request['cantidad_tras'];
        $costo_ins = $request['costo_tras'];
        //dd(sizeof($ins_id));
        for ($i=0; $i <sizeof($ins_id) ; $i++) { 
            if ($costo_ins[$i] != null) {
                $ins_datos[] = array("id_insumo"=>$ins_id[$i], "cantidad"=>$cantidad_ins[$i], "costo"=>$costo_ins[$i]);
            }                 
        }
        //END ARRAY ITEMS TRASPASO
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();    
        $id_planta=$planta->id_planta;
        $num = OrdenProduccion::join('public._bp_planta as plant', 'insumo.orden_produccion.orprod_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(orprod_nro_salida) as nrosal'))->where('plant.id_planta', $id_planta)->first();
        $cont=$num['nrosal'];
        $nro_sal = $cont + 1;
        $orden_produccion_aprob = OrdenProduccion::find($request['id_orp']);
        //STOCK
        $detoprod = DetalleOrdenProduccion::where('detorprod_orprod_id',$orden_produccion_aprob->orprod_id)->get();
        foreach ($detoprod as $det) {
            $stocks = Stock::where('stock_ins_id','=',$det->detorprod_ins_id)
                          ->where('stock_planta_id',$planta->id_planta)
                          ->where('stock_cantidad','>',0)
                          ->orderBy('stock_id','Asc')
                          ->get();
            $cantidad_aprobada = $det->detorprod_cantidad;
            foreach ($stocks as $stock) {
                if ($cantidad_aprobada>0) {
                    if ($cantidad_aprobada >= $stock->stock_cantidad) {
                        $cantidad_aprobada = $cantidad_aprobada - $stock->stock_cantidad;
                        $descuento = $stock->stock_cantidad;
                        $stock->stock_cantidad = 0;
                    }else
                    {
                        $stock->stock_cantidad = $stock->stock_cantidad - $cantidad_aprobada;
                        $descuento = $cantidad_aprobada;
                        $cantidad_aprobada = 0;
                    }
                    $stock->save();
                    //AQUI IRA PARA LA TABLA INSUMOS HISTORY
                    InsumoHistorial::create([
                            'inshis_ins_id'     => $det->detorprod_ins_id,
                            'inshis_planta_id'  => $id_planta,
                            'inshis_tipo'       => 'Salida',
                            'inshis_deting_id'  => $stock->stock_deting_id,//para el costo de ingreso
                            'inshis_detorprod_id'  => $det->detorprod_id,
                            'inshis_cantidad'   => $descuento,
                    ]);
                    //END INSUMOS HISTORY
                }
                
            }            
        }
        //INGRESO PLANTA SOLICITANTE
        $num = Ingreso::join('public._bp_planta as plant', 'insumo.ingreso.ing_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(ing_enumeracion) as nroing'))->where('plant.id_planta', $orden_produccion_aprob->orprod_planta_id)->first();
        $cont=$num['nroing'];
        $nid = $cont + 1;
        $ingreso_alm=Ingreso::create([
                'ing_remision'          => 1,
                'ing_id_tiping'         => 4,
                'ing_fecha_remision'    => "2019-08-26",
                //'ing_factura'           => $nombreImagenFactura,
                //'ing_nrofactura'        => $request['carr_ing_nrofactura'],
                'ing_usr_id'            => Auth::user()->usr_id,
                'ing_planta_id'         => $orden_produccion_aprob->orprod_planta_id,
                'ing_enumeracion'       => $nid,
                //'ing_nrocontrato'  => $request['carr_ing_nrocontrato'],
            ]);
        $ingreso_id = $ingreso_alm->ing_id;
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
                'stock_planta_id' => $orden_produccion_aprob->orprod_planta_id,
            ]);
            InsumoHistorial::create([
                'inshis_ins_id'     => $det['id_insumo'],
                'inshis_planta_id'  => $orden_produccion_aprob->orprod_planta_id,
                'inshis_tipo'       => 'Entrada',
                'inshis_deting_id'  => $det_ingreso->deting_id,
                'inshis_cantidad'   => $det['cantidad']
            ]);
        }
        //END INGRESO PLANTA SOLICITANTE
        //END SOCK
        $orden_produccion_aprob->orprod_nro_salida = $nro_sal;
        $orden_produccion_aprob->orprod_usr_aprob = Auth::user()->usr_id;
        $orden_produccion_aprob->orprod_obs_aprob = $request['obs_usr_aprob'];
        $orden_produccion_aprob->orprod_estado_orp = 'D';
        $orden_produccion_aprob->save();
        return redirect('solRecibidas')->with('success','Registro creado satisfactoriamente');
    }
    // MOSTRAR SOLICITUDES POR RECETAS
    public function mostrarSoliReceta($id_receta)
    {
        $sol_receta = Solicitud::join('insumo.receta as rec','insumo.solicitud.sol_id_rec','rec.rec_id')
                    ->join('insumo.mercado as merca','insumo.solicitud.sol_id_merc','merca.merc_id')
                    ->join('public._bp_usuarios as usu','insumo.solicitud.sol_usr_id','=','usu.usr_id')
                    ->join('public._bp_personas as persona','usu.usr_prs_id','=','prs_id')
                    ->where('sol_id','=',$id_receta)->where('sol_id_tipo','=',1)->first();
        return response()->json($sol_receta);
    }
    // MOSTRAR SOLICITUDES POR INSUMOS
    public function mostrarSoliInsumos($id_insumos)
    {
        $sol_insumos = Solicitud::join('insumo.receta as rec','insumo.solicitud.sol_id_rec','rec.rec_id')
                    ->join('insumo.mercado as merca','insumo.solicitud.sol_id_merc','merca.merc_id')
                    ->join('public._bp_usuarios as usu','insumo.solicitud.sol_usr_id','=','usu.usr_id')
                    ->join('public._bp_personas as persona','usu.usr_prs_id','=','prs_id')
                    ->where('sol_id','=',$id_insumos)->where('sol_id_tipo','=',2)->first();
        // dd($sol_insumos);
        return response()->json($sol_insumos);
    }
    // MOSTRAR SOLICITUDES POR TRASPASO/MAQUILA
    public function mostrarSoliTraspaso($id_traspaso)
    {
        $sol_traspaso = Solicitud::join('insumo.insumo as insu','insumo.solicitud.sol_id_insmaq','=','insu.ins_id')
                    ->join('public._bp_planta as planta','insumo.solicitud.sol_id_origen','=','planta.id_planta')
                    ->join('public._bp_planta as planta2','insumo.solicitud.sol_id_destino','=','planta2.id_planta')
                    ->join('public._bp_usuarios as usu','insumo.solicitud.sol_usr_id','=','usu.usr_id')
                    ->join('public._bp_personas as persona','usu.usr_prs_id','=','prs_id')
                    ->select('planta.nombre_planta as planta_origen','planta2.nombre_planta as planta_destino','insu.ins_desc','solicitud.sol_cantidad','solicitud.sol_um','sol_obs','sol_id','insu.ins_id','insu.ins_codigo','sol_codnum')
                    ->where('sol_id','=',$id_traspaso)->where('sol_id_tipo','=',3)->first();
        return response()->json($sol_traspaso);
    }
    //END MOSTRAR SOLICITUDES POR TRASPASOMAQUILA
    
    // APROVACIONES
    // APROVACION DE RECETA
    public function aprovSolreceta(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $cod_nro_rec = Aprobacion_Solicitud::where('aprsol_id_planta','=',$planta->id_planta)->select(DB::raw('MAX(aprsol_cod_solicitud) as codigo_nro_rece'))->first();
        // dd($cod_nro['codigo_nro']);
        $nro_cod_rec = $cod_nro_rec['codigo_nro_rece'] + 1;
        $aprobacion = Aprobacion_Solicitud::create([
            'aprsol_tipo_solicitud' => 1,
            'aprsol_solicitud'      => $request['aprsol_solreceta_id'],
            'aprsol_data'           => $request['aprsol_data'],
            'aprsol_usr_id'         => Auth::user()->usr_id,

            'aprsol_estado'         => 'A',
            'aprsol_cod_solicitud'  => $nro_cod_rec,
            'aprsol_id_planta'      => $planta->id_planta,
            'aprsol_gestion'        => date("Y")
        ]);

        $ingreso_id = $aprobacion->aprsol_id;
        $data =  json_decode($request['aprsol_data']);
        $fech=date('d/m/Y');
        foreach ($data as $dat) {
        DetalleAprobSol::create([
                'detaprob_id_aprobsol'  => $ingreso_id,
                'detaprob_id_ins'       => $dat->id_insumo,
                //'detaprob_id_planta'    => $dat->prov_id,
                'detaprob_cantidad'     => $dat->cantidad,
               // 'detaprob_costo'        => $dat->costo,
                'detaprob_usr_id'       => Auth::user()->usr_id,
                'detaprob_registrado'   => $fech,
            ]);
        }

        $solReceta = Solicitud::where('sol_id','=',$request['aprsol_solreceta_id'])->where('sol_id_tipo','=',1)->first();
        $solReceta->sol_estado = 'B';
        $solReceta->save();
        
        // dd($planta->id_planta);
        $ins_aprovRec =json_decode($request['aprsol_data']);
        // dd($ins_aprovRec);
        foreach ($ins_aprovRec as $insumo) {
            $stock = Stock_Almacen::where('stockal_ins_id','=',$insumo->id_insumo)->where('stockal_planta_id','=',$planta->id_planta)->first();          
                $cant_ingreso = $insumo->cantidad + $insumo->rango_adicional;
                $stock_cantidad_ingreso = $stock->stockal_cantidad - $cant_ingreso;
                $stock->stockal_cantidad = $stock_cantidad_ingreso;
                $stock->stockal_usr_id = Auth::user()->usr_id;
                $stock->save();
            
            // $insumo_precio = DetalleIngresoData::where('detcar_id_ins','=',$insumo->id_insumo)
            //                                    ->where('detcar_id_planta','=',$planta->id_planta)
            //                                    ->orderby('detcar_id', 'ASC')->where('detcar_cantidad','>=',$insumo->cantidad)->first();
            // if ($insumo->cantidad > $insumo_precio->detcar_cantidad) {
                
            // }
            $aux_cant = $insumo->cantidad;
            $cont = $aux_cant; 
            while($cont > 0)
            {
                $insumo_precio = DetalleIngresoData::where('detcar_id_ins','=',$insumo->id_insumo)
                                               ->where('detcar_id_planta','=',$planta->id_planta)
                                               ->where('detcar_cant_actual','>',0)->orderby('detcar_id','ASC')->first();
                $cant_hist = $insumo_precio->detcar_cant_actual - $cont;
                $cost_hist = $insumo_precio->detcar_costo_uni;
                if($cant_hist < 0){
                    $aux_cant1 = 0;
                    $cant_hist = -($cant_hist);
                    // dd($aux_cant);
                    HistoStock::create([
                    'hist_id_stock'     => $stock->stockal_id,
                    'hist_id_ins'       => $insumo->id_insumo,
                    'hist_id_carring'   => null,
                    'hist_id_aprobsol'  => $aprobacion->aprsol_id,
                    'hist_id_planta'    => $planta->id_planta,
                    // 'hist_fecha'        => $aprobacion->aprsol_registrado,
                    'hist_detale'      => 'Salida (NS-'.$aprobacion->aprsol_cod_solicitud.')',
                    'hist_cant_ent'     => 0,
                    'hist_cost_ent'     => 0,
                    'hist_tot_ent'      => 0,
                    'hist_cant_sal'     => $cont,
                    'hist_cost_sal'     => $cost_hist,
                    'hist_tot_sal'      => 1000,
                    'hist_cant_saldo'   => 5,
                    'hist_cost_saldo'   => 5,
                    'hist_tot_saldo'    => 5,
                    'hist_usr_id'       => Auth::user()->usr_id,
                ]);
                }else{
                    $aux_cant1 = $cant_hist;
                    $cant_hist = 0;

                    HistoStock::create([
                    'hist_id_stock'     => $stock->stockal_id,
                    'hist_id_ins'       => $insumo->id_insumo,
                    'hist_id_carring'   => null,
                    'hist_id_aprobsol'  => $aprobacion->aprsol_id,
                    'hist_id_planta'    => $planta->id_planta,
                    // 'hist_fecha'        => $aprobacion->aprsol_registrado,
                    'hist_detale'      => 'Salida (NS-'.$aprobacion->aprsol_cod_solicitud.')',
                    'hist_cant_ent'     => 0,
                    'hist_cost_ent'     => 0,
                    'hist_tot_ent'      => 0,
                    'hist_cant_sal'     => $cont,
                    'hist_cost_sal'     => $cost_hist,
                    'hist_tot_sal'      => 1000,
                    'hist_cant_saldo'   => 5,
                    'hist_cost_saldo'   => 5,
                    'hist_tot_saldo'    => 5,
                    'hist_usr_id'       => Auth::user()->usr_id,
                ]);
                }
                // $canti_insumo = $cant_hist;
                // var_dump($aux_cant);
                // $cost_hist = $insumo_precio->detcar_costo_uni;
                $insuDet = DetalleIngresoData::where('detcar_id','=',$insumo_precio->detcar_id)
                            ->where('detcar_id_planta',$planta->id_planta)->first();
                // var_dump($aux_cant1);
                $insuDet->detcar_cant_actual = $aux_cant1;
                $insuDet->save();

                
                
                $cont = $cant_hist;
                // var_dump($cont);
            }
            
        }
        // dd($array);
    
        return response()->json($aprobacion);
    }
    // APORVACION DE INSUMO ADICIONAL
    public function aprovSolInsAdicional(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $cod_nro_insa = Aprobacion_Solicitud::where('aprsol_id_planta','=',$planta->id_planta)->select(DB::raw('MAX(aprsol_cod_solicitud) as codigo_nro_insa'))->first();
        // dd($cod_nro['codigo_nro']);
        $nro_cod_insa = $cod_nro_insa['codigo_nro_insa'] + 1;
        $aprobacionAdi = Aprobacion_Solicitud::create([
            'aprsol_tipo_solicitud' => 2,
            'aprsol_solicitud'      => $request['aprsol_soladi_id'],
            'aprsol_data'           => $request['aprsol_data'],
            'aprsol_usr_id'         => Auth::user()->usr_id,
 
            'aprsol_estado'         => 'A',
            'aprsol_cod_solicitud'  => $nro_cod_insa,
            'aprsol_id_planta'      => $planta->id_planta,
            'aprsol_gestion'        => date("Y")
        ]);

        $ingreso_id = $aprobacionAdi->aprsol_id;
        $data =  json_decode($request['aprsol_data']);
        $fech=date('d/m/Y');
        foreach ($data as $dat) {
        DetalleAprobSol::create([
                'detaprob_id_aprobsol'  => $ingreso_id,
                'detaprob_id_ins'       => $dat->id_insumo,
                //'detaprob_id_planta'    => $dat->prov_id,
                'detaprob_cantidad'     => $dat->cantidad,
               // 'detaprob_costo'        => $dat->costo,
                'detaprob_usr_id'       => Auth::user()->usr_id,
                'detaprob_registrado'   => $fech,
            ]);
        }
        $solAdicional = Solicitud::where('sol_id','=',$request['aprsol_soladi_id'])->where('sol_id_tipo','=',2)->first();
        $solAdicional->sol_estado = 'B';
        $solAdicional->save();        
        
        // dd($planta->id_planta);
        $ins_aprovRec =json_decode($request['aprsol_data']);

        foreach ($ins_aprovRec as $insumo) {
            $stock = Stock_Almacen::where('stockal_ins_id','=',$insumo->id_insumo)->where('stockal_planta_id','=',$planta->id_planta)->first();
            // dd($insumo->cantidad_adicional);                
                $stock_cantidad_ingreso = $stock->stockal_cantidad - $insumo->solicitud_adicional;
                $stock->stockal_cantidad = $stock_cantidad_ingreso;
                $stock->stockal_usr_id = Auth::user()->usr_id;
                $stock->save();

                // STOCK HISTORIAL
                $aux_cant = $insumo->solicitud_adicional;
                $cont = $aux_cant; 
                while($cont > 0)
                {
                    $insumo_precio = DetalleIngresoData::where('detcar_id_ins','=',$insumo->id_insumo)
                                               ->where('detcar_id_planta','=',$planta->id_planta)
                                               ->where('detcar_cant_actual','>',0)->orderby('detcar_id','ASC')->first();
                    $cant_hist = $insumo_precio->detcar_cant_actual - $cont;
                    $cost_hist = $insumo_precio->detcar_costo_uni;
                    if($cant_hist < 0){
                        $aux_cant1 = 0;
                        $cant_hist = -($cant_hist);
                        // dd($aux_cant);
                        HistoStock::create([
                            'hist_id_stock'     => $stock->stockal_id,
                            'hist_id_ins'       => $insumo->id_insumo,
                            'hist_id_carring'   => null,
                            'hist_id_aprobsol'  => $aprobacionAdi->aprsol_id,
                            'hist_id_planta'    => $planta->id_planta,
                            // 'hist_fecha'        => $aprobacion->aprsol_registrado,
                            'hist_detale'      => 'Salida (NS-'.$aprobacionAdi->aprsol_cod_solicitud.')',
                            'hist_cant_ent'     => 0,
                            'hist_cost_ent'     => 0,
                            'hist_tot_ent'      => 0,
                            'hist_cant_sal'     => $cont,
                            'hist_cost_sal'     => $cost_hist,
                            'hist_tot_sal'      => 1000,
                            'hist_cant_saldo'   => 5,
                            'hist_cost_saldo'   => 5,
                            'hist_tot_saldo'    => 5,
                            'hist_usr_id'       => Auth::user()->usr_id,
                        ]);
                    }else{
                        $aux_cant1 = $cant_hist;
                        $cant_hist = 0;

                        HistoStock::create([
                        'hist_id_stock'     => $stock->stockal_id,
                        'hist_id_ins'       => $insumo->id_insumo,
                        'hist_id_carring'   => null,
                        'hist_id_aprobsol'  => $aprobacionAdi->aprsol_id,
                        'hist_id_planta'    => $planta->id_planta,
                        // 'hist_fecha'        => $aprobacion->aprsol_registrado,
                        'hist_detale'      => 'Salida (NS-'.$aprobacionAdi->aprsol_cod_solicitud.')',
                        'hist_cant_ent'     => 0,
                        'hist_cost_ent'     => 0,
                        'hist_tot_ent'      => 0,
                        'hist_cant_sal'     => $cont,
                        'hist_cost_sal'     => $cost_hist,
                        'hist_tot_sal'      => 1000,
                        'hist_cant_saldo'   => 5,
                        'hist_cost_saldo'   => 5,
                        'hist_tot_saldo'    => 5,
                        'hist_usr_id'       => Auth::user()->usr_id,
                    ]);
                }
                // $canti_insumo = $cant_hist;
                // var_dump($aux_cant);
                // $cost_hist = $insumo_precio->detcar_costo_uni;
                $insuDet = DetalleIngresoData::where('detcar_id','=',$insumo_precio->detcar_id)
                            ->where('detcar_id_planta',$planta->id_planta)->first();
                // var_dump($aux_cant1);
                $insuDet->detcar_cant_actual = $aux_cant1;
                $insuDet->save();

                
                
                $cont = $cant_hist;
                // var_dump($cont);
            }
        }

        return response()->json($aprobacionAdi);
    }
    // APROVACION POR TRASPASO MAQUILA
    public function aprovSolTraspaso(Request $request)
    {   
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $cod_nro_tras = Aprobacion_Solicitud::where('aprsol_id_planta','=',$planta->id_planta)->select(DB::raw('MAX(aprsol_cod_solicitud) as codigo_nro_tras'))->first();
        // dd($cod_nro['codigo_nro']);
        $nro_cod_tras = $cod_nro_tras['codigo_nro_tras'] + 1;
        $aprobacionMaquila = Aprobacion_Solicitud::create([
            'aprsol_tipo_solicitud' => 3,
            'aprsol_solicitud'      => $request['aprsol_solmaq_id'],
            'aprsol_data'           => $request['aprsol_data'],
            'aprsol_usr_id'         => Auth::user()->usr_id,

            'aprsol_estado'         => 'A',
            'aprsol_cod_solicitud'  => $nro_cod_tras,
            'aprsol_id_planta'      => $planta->id_planta,
            'aprsol_gestion'        => date("Y")
        ]);
        $ingreso_id = $aprobacionMaquila->aprsol_id;
        $data =  json_decode($request['aprsol_data']);
        $fech=date('d/m/Y');
        foreach ($data as $dat) {
        DetalleAprobSol::create([
                'detaprob_id_aprobsol'  => $ingreso_id,
                'detaprob_id_ins'       => $dat->id_insumo,
                //'detaprob_id_planta'    => $dat->prov_id,
                'detaprob_cantidad'     => $dat->cantidad,
               // 'detaprob_costo'        => $dat->costo,
                'detaprob_usr_id'       => Auth::user()->usr_id,
                'detaprob_registrado'   => $fech,
            ]);
        }
        
        $solMaquila = Solicitud::where('sol_id','=',$request['aprsol_solmaq_id'])->where('sol_id_tipo','=',3)->first();
        $solMaquila->sol_estado = 'B';
        $solMaquila->save();
        
        
        // dd($planta->id_planta);
        $ins_aprovRec =json_decode($request['aprsol_data']);

        foreach ($ins_aprovRec as $insumo) {
            $stock = Stock_Almacen::where('stockal_ins_id','=',$insumo->id_insumo)->where('stockal_planta_id','=',$planta->id_planta)->first();
            // dd($insumo->cantidad_adicional);                
                $stock_cantidad_ingreso = $stock->stockal_cantidad - $insumo->cantidad;
                $stock->stockal_cantidad = $stock_cantidad_ingreso;
                $stock->stockal_usr_id = Auth::user()->usr_id;
                $stock->save();

                // STOCK HISTORIAL
                $aux_cant = $insumo->cantidad;
                $cont = $aux_cant; 
                while($cont > 0)
                {
                    $insumo_precio = DetalleIngresoData::where('detcar_id_ins','=',$insumo->id_insumo)
                                               ->where('detcar_id_planta','=',$planta->id_planta)
                                               ->where('detcar_cant_actual','>',0)->orderby('detcar_id','ASC')->first();
                    $cant_hist = $insumo_precio->detcar_cant_actual - $cont;
                    $cost_hist = $insumo_precio->detcar_costo_uni;
                    if($cant_hist < 0){
                        $aux_cant1 = 0;
                        $cant_hist = -($cant_hist);
                        // dd($aux_cant);
                        HistoStock::create([
                            'hist_id_stock'     => $stock->stockal_id,
                            'hist_id_ins'       => $insumo->id_insumo,
                            'hist_id_carring'   => null,
                            'hist_id_aprobsol'  => $aprobacionMaquila->aprsol_id,
                            'hist_id_planta'    => $planta->id_planta,
                            // 'hist_fecha'        => $aprobacion->aprsol_registrado,
                            'hist_detale'      => 'Salida (NS-'.$aprobacionMaquila->aprsol_cod_solicitud.')',
                            'hist_cant_ent'     => 0,
                            'hist_cost_ent'     => 0,
                            'hist_tot_ent'      => 0,
                            'hist_cant_sal'     => $cont,
                            'hist_cost_sal'     => $cost_hist,
                            'hist_tot_sal'      => 1000,
                            'hist_cant_saldo'   => 5,
                            'hist_cost_saldo'   => 5,
                            'hist_tot_saldo'    => 5,
                            'hist_usr_id'       => Auth::user()->usr_id,
                        ]);
                    }else{
                        $aux_cant1 = $cant_hist;
                        $cant_hist = 0;

                        HistoStock::create([
                        'hist_id_stock'     => $stock->stockal_id,
                        'hist_id_ins'       => $insumo->id_insumo,
                        'hist_id_carring'   => null,
                        'hist_id_aprobsol'  => $aprobacionMaquila->aprsol_id,
                        'hist_id_planta'    => $planta->id_planta,
                        // 'hist_fecha'        => $aprobacion->aprsol_registrado,
                        'hist_detale'      => 'Salida (NS-'.$aprobacionMaquila->aprsol_cod_solicitud.')',
                        'hist_cant_ent'     => 0,
                        'hist_cost_ent'     => 0,
                        'hist_tot_ent'      => 0,
                        'hist_cant_sal'     => $cont,
                        'hist_cost_sal'     => $cost_hist,
                        'hist_tot_sal'      => 1000,
                        'hist_cant_saldo'   => 5,
                        'hist_cost_saldo'   => 5,
                        'hist_tot_saldo'    => 5,
                        'hist_usr_id'       => Auth::user()->usr_id,
                    ]);
                }
                // $canti_insumo = $cant_hist;
                // var_dump($aux_cant);
                // $cost_hist = $insumo_precio->detcar_costo_uni;
                $insuDet = DetalleIngresoData::where('detcar_id','=',$insumo_precio->detcar_id)
                            ->where('detcar_id_planta',$planta->id_planta)->first();
                // var_dump($aux_cant1);
                $insuDet->detcar_cant_actual = $aux_cant1;
                $insuDet->save();

                
                
                $cont = $cant_hist;
                // var_dump($cont);
            }
        }

        return response()->json($aprobacionMaquila);
    }
    // END APROVACIONES
     
    // BOLETAS
    // BOLETA DE APROBACION DE RECETA
     public function aprovBoletaSolRec($id)
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

        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_user =  Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id_user)->first();

        $reg = Aprobacion_Solicitud::join('insumo.solicitud as solreceta','insumo.aprobacion_solicitud.aprsol_solicitud','=','solreceta.sol_id')
                                    ->join('insumo.receta as rec','solreceta.sol_id_rec','=','rec.rec_id')
                                    ->join('insumo.mercado as merc','solreceta.sol_id_merc','=','merc.merc_id')
                                    ->where('aprsol_id','=',$id)->where('aprsol_tipo_solicitud','=',1)->first();
        $data = $reg['sol_data'];
    
        $array = json_decode($data);
    
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="/img/logopeqe.png" width="160" height="65"></th>
                             <th  width="370"><h3 align="center"><br>ALMACEN '.$planta['nombre_planta'].'<br>NOTA DE SALIDA O APROBACION SOLICITUD</h3></th>
                             <th  width="150"><h3 align="center"><br>Fecha: '.date('d/m/Y').'<br>Codigo No: '.$reg['aprsol_cod_solicitud'].'/'.$reg['aprsol_gestion'].'</h3></th>
                        </tr>
                    </table>
                    <br><br><br>
                        <label><strong>Solicitante:</strong> '.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label align="right"><strong>Mercado:</strong> '.$reg['merc_nombre'].'</label>
                        <br><br>
                        <label><strong>Dependencia:</strong> '.$planta['nombre_planta'].'</label>
                        <br><br>
                        <label><strong>No. Solicitud:</strong> '.$reg['sol_codnum'].'</label>
                        <br><br>
                        
                        <label><strong>Fecha Solictud:</strong> '.$reg['sol_registrado'].'</label>
                        <br><br>
                        
                        <label><strong>Fecha Entrega:</strong> '.$reg['aprsol_registrado'].'</label>
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
                     $html = $html . '<tr><td align="center" colspan="3"><strong>TOTAL TIPOS DE INSUMOS SOLICITADOS</strong></td><td align="center"><strong>'.$nro.'</strong></td></tr></table><br><br><br><br><br><br>';

                      $html = $html . '
                                <table>
                            <tr>
                                <td align="center">________________________</td>
                                
                                <td align="center">________________________</td>

                                <td align="center">________________________</td>
                                
                                <td align="center">________________________</td>

                            </tr>
                            <tr>
                                <td align="center">Solicitante</td>
                                
                                <td align="center">Responsable de Almacen</td>

                                <td align="center">Responsable Administrativo</td>
                                
                                <td align="center">Jefe de Planta</td>
                            </tr>
                            <tr>
                                <td align="center">'.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</td>
                                
                            </tr>
                            
                            
                            </table>
                            ';   

                    $htmltable = $html;
        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('boletaAprobacionReceta-'.$reg['aprsol_id'].'.pdf', 'I');

    }
    // BOLETA DE APROBACION DE INSUMOS ADICIONAL
     public function aprovBoletaSolInsumoAdi($id)
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
        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_user =  Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id_user)->first();
        
        $reg = Aprobacion_Solicitud::join('insumo.solicitud as soladici','insumo.aprobacion_solicitud.aprsol_solicitud','=','soladici.sol_id')
                                    ->join('insumo.receta as rec','soladici.sol_id_rec','=','rec.rec_id')
                                    ->join('insumo.mercado as merc','soladici.sol_id_merc','=','merc.merc_id')
                                    ->where('aprsol_id','=',$id)->where('aprsol_tipo_solicitud','=',2)->first();
        $data = $reg['sol_data'];
        // dd($data);
        $array = json_decode($data);
    
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="/img/logopeqe.png" width="160" height="65"></th>
                             <th  width="370"><h3 align="center"><br>ALMACEN '.$planta['nombre_planta'].'<br>NOTA DE SALIDA POR INSUMO ADICIONAL</h3></th>
                             <th  width="150"><h3 align="center"><br>Fecha: '.date('d/m/Y').'<br>Codigo No: '.$reg['aprsol_cod_solicitud'].'/'.$reg['aprsol_gestion'].'</h3></th>
                        </tr>
                    </table>
                    <br><br><br>
                        <label><strong>Solicitante:</strong> '.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label align="right"><strong>Mercado:</strong> '.$reg['merc_nombre'].'</label>
                        <br><br>
                        <label><strong>Dependencia:</strong> '.$planta['nombre_planta'].'</label>
                        <br><br>
                        <label><strong>No. solicitud:</strong> '.$reg['sol_codnum'].'</label>
                        <br><br>
                        <label><strong>Nota Salida:</strong> '.$reg['sol_nro_salida'].'</label>
                        <br><br>
                        <label><strong>Fecha Solicitud:</strong> '.$reg['sol_registrado'].'</label>
                        <br><br>
                        <label><strong>Fecha Entrega:</strong> '.$reg['aprsol_registrado'].'</label>
                        <br><br>
                        
                        <h3 align="center">'.$reg['rec_nombre'].'</h3>
                    <br><br><br>

                    <table border="1" cellspacing="0">
                     
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB" width="160"><strong>Insumo</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>Unidad</strong></th>
                            <th align="center" bgcolor="#3498DB" width="70"><strong>Cantidad</strong></th>
                            
                            <th align="center" bgcolor="#3498DB" width="100"><strong>Cant. adicional</strong></th>
                            <th align="center" bgcolor="#3498DB" width="160"><strong>Observacion</strong></th>
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
                                <td align="center">________________________</td>
                                
                                <td align="center">________________________</td>

                                <td align="center">________________________</td>
                                
                                <td align="center">________________________</td>

                            </tr>
                            <tr>
                                <td align="center">Solicitante</td>
                                
                                <td align="center">Responsable de Almacen</td>

                                <td align="center">Responsable Administrativo</td>
                                
                                <td align="center">Jefe de Planta</td>
                            </tr>
                            <tr>
                                <td align="center">'.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</td>
                                
                            </tr>
                            
                            
                            </table>
                            ';   

                    $htmltable = $html;
        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('boletaAprobaAdiInsumos-'.$reg['aprsol_id'].'.pdf', 'I');

    }

    // BOLETA APROBACION TRASPASO MAQUILA
    public function aprovBoletaSolTraspaso($id)
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

        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id_user =  Auth::user()->usr_id;
        $planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
                 ->where('usr_id',$id_user)->first();
        
        $reg = Aprobacion_Solicitud::join('insumo.solicitud as solmaq','insumo.aprobacion_solicitud.aprsol_solicitud','=','solmaq.sol_id')
                    ->join('public._bp_planta as planta','solmaq.sol_id_origen','=','planta.id_planta')
                    ->join('public._bp_planta as plant','solmaq.sol_id_destino','=','plant.id_planta')
                    ->join('insumo.insumo as ins','solmaq.sol_id_insmaq','=','ins.ins_id')
                    ->join('public._bp_usuarios as usu','solmaq.sol_usr_id','=','usu.usr_id')
                    ->join('public._bp_personas as persona','usu.usr_prs_id','=','persona.prs_id')
                    ->select('solmaq.sol_id','solmaq.sol_um','solmaq.sol_obs','solmaq.sol_cantidad','solmaq.sol_registrado','ins.ins_desc','planta.nombre_planta as planta_origen','plant.nombre_planta as planta_destino','persona.prs_nombres','persona.prs_paterno','persona.prs_materno', 'solmaq.sol_codnum','aprsol_cod_solicitud','aprsol_gestion','insumo.aprobacion_solicitud.aprsol_id', 'insumo.aprobacion_solicitud.aprsol_registrado')
                    ->where('aprsol_id','=',$id)->where('aprsol_tipo_solicitud','=',3)
            ->first();
        
         // dd($reg);
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="/img/logopeqe.png" width="160" height="65"></th>
                             <th  width="370"><h3 align="center"><br>ALMACEN '.$planta['nombre_planta'].'<br>NOTA DE APROBACION O SALIDA POR TRAPASO/MAQUILA</h3></th>
                             <th  width="150"><h3 align="center"><br>Fecha: '.date('d/m/Y').'<br>Codigo No: '.$reg['aprsol_cod_solicitud'].'/'.$reg['aprsol_gestion'].'</h3></th>
                        </tr>
                    </table>
                    <br><br><br>
                        <label><strong>Solicitante:</strong> '.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <br><br>
                        <label><strong>Dependencia:</strong> '.$reg['planta_origen'].'</label>
                        <br><br>
                        <label><strong>No. Solicitud:</strong> '.$reg['sol_codnum'].'</label>
                        <br><br>
                        <label><strong>Fecha Solicitud:</strong> '.$reg['sol_registrado'].'</label>
                        <br><br>
                        <label><strong>Fecha Entrega:</strong> '.$reg['aprsol_registrado'].'</label>
                        <br><br>
                        
                        <h3 align="center">'.$reg['rec_nombre'].'</h3>
                    <br><br><br>

                    <table border="1" cellspacing="0">
                     
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB" width="160"><strong>INSUMO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="70"><strong>UNIDAD</strong></th>
                            <th align="center" bgcolor="#3498DB" width="70"><strong>Cantidad</strong></th>
                            <th align="center" bgcolor="#3498DB" width="158"><strong>origen</strong></th>
                            <th align="center" bgcolor="#3498DB" width="158"><strong>Detino</strong></th>
                        </tr> ';
                     
                        // $tot1=0;
                   
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">1</td>
                                    <td align="center">'.$reg['ins_desc'].'</td>
                                    <td align="center">'.$reg['sol_um'].'</td>
                                    <td align="center">'.$reg['sol_cantidad'].'</td>
                                    <td align="center">'.$reg['planta_origen'].'</td>
                                    <td align="center">'.$reg['planta_destino'].'</td>
                                  </tr>';  
                        
                       // echo $tot1;   
                     $html = $html . '</table>

                     <br><br>
                            <table border="1">
                                <tr>
                                    <th height="50"><strong> Observaciones:</strong> '.$reg['solmaq_obs'].'</th>
                                </tr>
                            </table>
                     <br><br><br><br><br><br>';

                      $html = $html . '
                                <table>
                            <tr>
                                <td align="center">________________________</td>
                                
                                <td align="center">________________________</td>

                                <td align="center">________________________</td>
                                
                                <td align="center">________________________</td>

                            </tr>
                            <tr>
                                <td align="center">Solicitante</td>
                                
                                <td align="center">Responsable de Almacen</td>

                                <td align="center">Responsable Administrativo</td>
                                
                                <td align="center">Jefe de Planta</td>
                            </tr>
                            <tr>
                                <td align="center">'.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</td>
                                
                            </tr>
                            
                            
                            </table>
                            ';   

                    $htmltable = $html;
        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('boletaAprovaMaquila-'.$reg['aprsol_id'].'.pdf', 'I');
    }

    // RECHAZOS SOLICITUDES
    // RECHAZOS SOLICITUD RECETA
    public function rechazoSolReceta(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $cod_nro_recr = Aprobacion_Solicitud::where('aprsol_id_planta','=',$planta->id_planta)->select(DB::raw('MAX(aprsol_cod_solicitud) as codigo_nro_recr'))->first();
        // dd($cod_nro['codigo_nro']);
        $nro_cod_recr = $cod_nro_recr['codigo_nro_recr'] + 1;
        $rechazoSolReceta= Aprobacion_Solicitud::create([
            'aprsol_tipo_solicitud' => 1,
            'aprsol_solicitud'      => $request['aprsol_solreceta_id'],
            'aprsol_data'           => $request['aprsol_data'],
            'aprsol_usr_id'         => Auth::user()->usr_id,
            'aprsol_cod_solicitud'  => $nro_cod_recr,
            'aprsol_id_planta'      => $planta->id_planta,
            'aprsol_estado'         => 'B',
            'aprsol_gestion'        => date("Y")
        ]);
        $solReceta = Solicitud::where('sol_id','=',$request['aprsol_solreceta_id'])->where('sol_id_tipo','=',1)->first();
        $solReceta->sol_estado = 'B';
        $solReceta->save();
    
        // return response()->json($rechazo);
        return response()->json("SOLICITUD RECHAZADA");
    }
    // RECHAZO SOLICITUD INSUMO ADICIONAL
    public function rechazoSolInsumoAdi(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $cod_nro_air = Aprobacion_Solicitud::where('aprsol_id_planta','=',$planta->id_planta)->select(DB::raw('MAX(aprsol_cod_solicitud) as codigo_nro_air'))->first();
        // dd($cod_nro['codigo_nro']);
        $nro_cod_air = $cod_nro_air['codigo_nro_air'] + 1;
        $rechazoAdi = Aprobacion_Solicitud::create([
            'aprsol_tipo_solicitud' => 2,
            'aprsol_solicitud'      => $request['aprsol_soladi_id'],
            'aprsol_data'           => $request['aprsol_data'],
            'aprsol_usr_id'         => Auth::user()->usr_id,
            'aprsol_cod_solicitud'  => $nro_cod_air,
            'aprsol_id_planta'      => $planta->id_planta,
            'aprsol_estado'         => 'B',
            'aprsol_gestion'        => date("Y")
        ]);
        $solAdicional = Solicitud::where('sol_id','=',$request['aprsol_soladi_id'])->where('sol_id_tipo','=',2)->first();
        $solAdicional->sol_estado = 'B';
        $solAdicional->save();
    
        return response()->json("SOLICITUD RECHAZADA");
    }
    // RECHAZO SOLICITUD TRAPASO MAQUILA
    public function rechazoSolTrapaso(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $cod_nro_tr = Aprobacion_Solicitud::where('aprsol_id_planta','=',$planta->id_planta)->select(DB::raw('MAX(aprsol_cod_solicitud) as codigo_nro_tr'))->first();
        // dd($cod_nro['codigo_nro']);
        $nro_cod_tr = $cod_nro_tr['codigo_nro_tr'] + 1;
        $rechazoTras = Aprobacion_Solicitud::create([
            'aprsol_tipo_solicitud' => 3,
            'aprsol_solicitud'      => $request['aprsol_solmaq_id'],
            'aprsol_data'           => $request['aprsol_data'],
            'aprsol_usr_id'         => Auth::user()->usr_id,
            'aprsol_cod_solicitud'  => $nro_cod_tr,
            'aprsol_id_planta'      => $planta->id_planta,
            'aprsol_estado'         => 'B',
            'aprsol_gestion'        => date("Y")
        ]);
        $solMaquila = Solicitud::where('sol_id','=',$request['aprsol_solmaq_id'])->where('sol_id_tipo','=',3)->first();
        $solMaquila->sol_estado = 'B';
        $solMaquila->save();
    
        return response()->json("SOLICITUD RECHAZADA");
    }

    public function rptSalidasAlmacen()
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

        $reg = Aprobacion_Solicitud::where('aprsol_id_planta','=',$planta->id_planta)->orderby('aprsol_id','ASC')->get();
       // echo $reg;
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><br><br><img src="/img/logopeqe.png" width="140" height="65"></th>
                             <th  width="830"><h3 align="center"><br>REPORTE GENERAL DE SALIDAS<br>ALMACEN INSUMOS: '.$planta['nombre_planta'].'<br>Fecha de Emision: '.date('d/m/Y').'<br></h3></th>
                        </tr>
                    </table>
                    <br><br>
                        <label>GENERADO POR: '. $per['prs_nombres'].' '.$per['prs_paterno'].' '.$per['prs_materno'].'</label>
                        <br><br>
                    <table border="1" cellspacing="0" cellpadding="1">
                     
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="60"><strong>No.</strong></th>
                            <th align="center" bgcolor="#3498DB" width="60"><strong>No. SALIDA</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>CODIGO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="350"><strong>ARTICULO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="180"><strong>CANTIDAD</strong></th>
                            <th align="center" bgcolor="#3498DB" width="200"><strong>FECHA SALIDA.</strong></th>
                            
                        </tr>';
                        $nro=0;
                    foreach ($reg as $key => $r) {                                              
                        $data = $r->aprsol_data;
                        $array = json_decode($data);
                        foreach ($array as $dat) { 
                            $nro = $nro+1;
                            $cantidad = (float)$dat->cantidad;
                            $rango = (float)$dat->rango_adicional;
                            $solAdi = (float)$dat->solicitud_adicional;
                            $cantidadTotal = $cantidad+$rango+$solAdi;  
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                <td align="center">'.$nro.'</td>
                                <td align="center">'.$r->aprsol_cod_solicitud.'</td>
                                <td align="center">'.$dat->codigo_insumo.'</td>
                                <td align="center">'.$dat->descripcion_insumo.'</td>
                                <td align="center">'.number_format($cantidadTotal,2,'.',',').'</td>
                                <td align="center">'.$r->aprsol_registrado.'</td></tr>';                    
                        }
                     }

                       

                    $htmltable = $html . '</table>';
        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Reporte_salidas_Almacen.pdf', 'I');
    }
    public function rptSalidasGeneral()
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

        $reg = Aprobacion_Solicitud::join('public._bp_planta as planta','insumo.aprobacion_solicitud.aprsol_id_planta','=','planta.id_planta')
                                    ->orderby('aprsol_id','ASC')->get();
       // echo $reg;
        //dd($reg);
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><br><br><img src="/img/logopeqe.png" width="140" height="65"></th>
                             <th  width="830"><h3 align="center"><br>REPORTE GENERAL DE SALIDAS<br>ALMACEN INSUMOS <br>Fecha de Emision: '.date('d/m/Y').'<br></h3></th>
                        </tr>
                    </table>
                    <br><br>
                        <label><strong>GENERADO POR:</strong> '. $per['prs_nombres'].' '.$per['prs_paterno'].' '.$per['prs_materno'].'</label>
                        <br><br>
                    <table border="1" cellspacing="0" cellpadding="1">
                     
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="60"><strong>No.</strong></th>
                            <th align="center" bgcolor="#3498DB" width="60"><strong>No. SALIDA</strong></th>
                            <th align="center" bgcolor="#3498DB" width="200"><strong>PLANTA</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>CODIGO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="200"><strong>ARTICULO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="180"><strong>CANTIDAD</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150"><strong>FECHA SALIDA.</strong></th>
                            
                        </tr>';
                        $nro=0;
                        $total_cantidad_sal = 0;
                    foreach ($reg as $key => $r) {                                              
                        $data = $r->aprsol_data;
                        $array = json_decode($data);
                        foreach ($array as $dat) { 
                            $nro = $nro+1;
                            $cantidad = (float)$dat->cantidad;
                            $rango = (float)$dat->rango_adicional;
                            //$solAdi = (float)$dat->solicitud_adicional;
                            $solAdi = 0;
                            $cantidadTotal = $cantidad+$rango+$solAdi;  

                            $total_cantidad_sal = $total_cantidad_sal+$cantidadTotal;
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                <td align="center">'.$nro.'</td>
                                <td align="center">'.$r->aprsol_cod_solicitud.'</td>
                                <td align="center">'.$r->nombre_planta.'</td>
                                <td align="center">'.$dat->codigo_insumo.'</td>
                                <td align="center">'.$dat->descripcion_insumo.'</td>
                                <td align="center">'.number_format($cantidadTotal,2,'.',',').'</td>
                                <td align="center">'.date('d-m-Y',strtotime($r->aprsol_registrado)).'</td></tr>';                    
                        }
                     }
                     $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                <td align="center" colspan="5"><strong>TOTAL</strong></td>
                                <td align="center"><strong>'.number_format($total_cantidad_sal,2,'.',',').'</strong></td>
                                <td align="center"><strong>-</strong></td></tr>';                       

                    $htmltable = $html . '</table>';
        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Reporte_salidas_Almacen.pdf', 'I');
    }
}

