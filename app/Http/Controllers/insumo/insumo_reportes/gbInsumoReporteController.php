<?php

namespace siga\Http\Controllers\insumo\insumo_reportes;

use Auth;
use Carbon\Carbon;
use DB;
use PDF;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Usuario;
use siga\Modelo\insumo\InsumoHistorial;
use siga\Modelo\insumo\insumo_registros\CarroIngreso;
use siga\Modelo\insumo\insumo_registros\DetalleIngresoData;
use siga\Modelo\insumo\insumo_registros\Insumo;
//NUEVOS
use siga\Modelo\insumo\insumo_solicitud\Aprobacion_Solicitud;
use siga\Modelo\insumo\insumo_solicitud\DetalleAprobSol;
use siga\Modelo\insumo\insumo_solicitud\Solicitud;
use siga\Modelo\insumo\Stock;
use siga\Modelo\insumo\Stock_Almacen;
use siga\Modelo\insumo\Stock_Historial;
use siga\Modelo\insumo\insumo_registros\Ingreso;
use siga\Modelo\insumo\insumo_registros\DetalleIngreso;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion;
use TCPDF;
use Yajra\Datatables\Datatables;

class gbInsumoReporteController extends Controller {
	public function index() {
		//$ins = Insumo::get();
		//dd($ins);
		// $dia = 1;
		//$time = time();
		//$dia = date("H:i:s", $time);
		// dd($dia);
		//if ($dia == "21:41:00") {
			//dd($dia);
		//} else {
			$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
				->where('usr_id', Auth::user()->usr_id)->first();
			$ins = Insumo::join('insumo.unidad_medida as umed', 'insumo.insumo.ins_id_uni', '=', 'umed.umed_id')
				->join('insumo.stock as stock', 'insumo.insumo.ins_id', '=', 'stock.stock_ins_id')
				->leftjoin('insumo.sabor as sab','insumo.insumo.ins_id_sabor','=','sab.sab_id')
	            ->leftjoin('insumo.partida as part','insumo.insumo.ins_id_part','=','part.part_id')
				->select(DB::raw('sum(stock_cantidad) as stocks_cantidad'), 'insumo.ins_id', 'insumo.ins_codigo', 'insumo.ins_desc', 'umed.umed_nombre','sab.sab_nombre','insumo.ins_peso_presen','part.part_nombre')->groupBy('insumo.ins_id', 'insumo.ins_codigo', 'insumo.ins_desc', 'umed.umed_nombre','sab.sab_nombre','insumo.ins_peso_presen','part.part_nombre')
				->where('stock_planta_id',$planta->id_planta)->get();
			//dd($ins);
			return view('backend.administracion.insumo.insumo_reportes.insumo.index',compact('ins'));
		//}
	}

	public function create() {
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->where('usr_id', Auth::user()->usr_id)->first();
		$ins = Insumo::join('insumo.unidad_medida as umed', 'insumo.insumo.ins_id_uni', '=', 'umed.umed_id')
			->join('insumo.stock as stock', 'insumo.insumo.ins_id', '=', 'stock.stock_ins_id')
			->leftjoin('insumo.sabor as sab','insumo.insumo.ins_id_sabor','=','sab.sab_id')
            ->leftjoin('insumo.partida as part','insumo.insumo.ins_id_part','=','part.part_id')
			->select(DB::raw('sum(stock_cantidad) as stocks_cantidad'), 'insumo.ins_id', 'insumo.ins_codigo', 'insumo.ins_desc', 'umed.umed_nombre','sab.sab_nombre','insumo.ins_peso_presen','part.part_nombre')->groupBy('insumo.ins_id', 'insumo.ins_codigo', 'insumo.ins_desc', 'umed.umed_nombre','sab.sab_nombre','insumo.ins_peso_presen','part.part_nombre')
			->where('stock_planta_id',$planta->id_planta)->get();
		return Datatables::of($ins)->addColumn('kardexValorado', function ($ins) {

			return '<div class="text-center"><a style="background-color: #d4b729;border: none;color: white;padding: 5px;text-align: center;text-decoration: none;display: inline-block;font-size: 10px;margin: 4px 2px;border-radius: 50%;" href="RpKardexValoradoInsumo/' . $ins->ins_id . '" type="button" target="_blank"><span class="glyphicon glyphicon-usd fa-2x"></span></a></div>';
		})
			->addColumn('kardexFisico', function ($ins) {
				return '<div class="text-center"><a style="background-color:#999;border: none;color: white;padding: 5px;text-align: center;text-decoration: none;display: inline-block;font-size: 10px;margin: 4px 2px;border-radius: 50%;" href="/RpKardexFisicoInsumo/' . $ins->ins_id . '" type="button" target="_blank"><span class="fa fa-file-o fa-2x"></span></a></div>';
			})
			->addColumn('NombreInsumo', function ($ins) {
				return $ins->ins_desc.' '.$ins->sab_nombre.' '.$ins->ins_peso_presen;
			})
			->editColumn('id', 'ID: {{$ins_id}}')
			->make(true);
	}

	public function menuInventarioGeneral() {
		$stockalhist = Stock_Historial::join('insumo.insumo as ins', 'insumo.stock_historial.his_stock_ins_id', '=', 'ins.ins_id')
			->join('insumo.unidad_medida as unidad', 'ins.ins_id_uni', '=', 'unidad.umed_id')
		//->join('insumo.categoria as cat','ins.ins_id_cat','=','cat.cat_id')
			->join('insumo.partida as part', 'ins.ins_id_part', '=', 'part.part_id')
			->join('public._bp_planta as plan', 'insumo.stock_historial.his_stock_planta_id', '=', 'plan.id_planta')
		/*->select('ins.ins_codigo','ins.ins_desc','unidad.umed_nombre as unidad','part.part_nombre','stock_historial.his_stock_registrado','plan.nombre_planta', DB::raw('sum(stock_historial.his_stock_cant) as quantity'))*/
		// ->where('his_stock_registrado','=',$anio."-".$mes."-".$dia)
			->where('his_stock_registrado', '2019-07-30')
		//  ->groupBy('ins.ins_codigo', 'ins.ins_desc', 'unidad', 'part.part_nombre', 'stock_historial.his_stock_registrado', 'plan.nombre_planta')
			->get();
		//echo $stockalhist;
		return view('backend.administracion.insumo.insumo_reportes.inventario_general.index');
	}
	public function ListarInventarioGeneral() {
		$stockalhist = Stock_Historial::join('insumo.insumo as ins', 'insumo.stock_historial.his_stock_ins_id', '=', 'ins.ins_id')
			->join('insumo.unidad_medida as unidad', 'ins.ins_id_uni', '=', 'unidad.umed_id')
			->join('insumo.categoria as cat', 'ins.ins_id_cat', '=', 'cat.cat_id')
			->join('insumo.partida as part', 'ins.ins_id_part', '=', 'part.part_id')
			->join('public._bp_planta as plan', 'insumo.stock_historial.his_stock_planta_id', '=', 'plan.id_planta')
			->select('ins.ins_codigo', 'ins.ins_desc', 'unidad.umed_nombre as unidad', 'stock_historial.his_stock_cant', 'cat.cat_nombre as categoria', 'part.part_nombre', 'stock_historial.his_stock_registrado', 'stock_historial.his_stock_planta_id')
			->get();
		return Datatables::of($stockalhist)

		//->editColumn('id', 'ID: {{$carr_sol_id}}')
			->make(true);
	}
	// BUSQUEDA POR MES
	public function ReporteInvMes($mes, $anio) {
		ini_set('memory_limit','512M');
      	set_time_limit(640);
		$anio1 = $anio;
		$diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
		$fechainicial = $anio1 . "-" . $mes . "-01";
		$fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
		$stockalhist = Stock_Historial::join('insumo.insumo as ins', 'insumo.stock_historial.his_stock_ins_id', '=', 'ins.ins_id')
			->join('insumo.unidad_medida as unidad', 'ins.ins_id_uni', '=', 'unidad.umed_id')
		// ->join('insumo.categoria as cat','ins.ins_id_cat','=','cat.cat_id')
			->join('insumo.partida as part', 'ins.ins_id_part', '=', 'part.part_id')
			->join('public._bp_planta as plan', 'insumo.stock_historial.his_stock_planta_id', '=', 'plan.id_planta')
			->select('stock_historial.his_stock_id','ins.ins_codigo', 'ins.ins_desc', 'unidad.umed_nombre as unidad', 'part.part_nombre', 'stock_historial.his_stock_registrado', 'plan.nombre_planta', DB::raw('sum(stock_historial.his_stock_cant) as quantity'))
			->where('his_stock_registrado', '>=', $fechainicial)->where('his_stock_registrado', '<=', $fechafinal)
			->groupBy('stock_historial.his_stock_id','ins.ins_codigo', 'ins.ins_desc', 'unidad', 'part.part_nombre', 'stock_historial.his_stock_registrado', 'plan.nombre_planta')
			->get();
		return Datatables::of($stockalhist)
			->make(true);
	}
	// BUSQUEDA POR dia
	public function ReporteInvDia($dia, $mes, $anio) {
		$dia = $anio . "-" . $mes . "-" . $dia;
		$stockalhist = Stock_Historial::join('insumo.insumo as ins', 'insumo.stock_historial.his_stock_ins_id', '=', 'ins.ins_id')
			->join('insumo.unidad_medida as unidad', 'ins.ins_id_uni', '=', 'unidad.umed_id')
		//->join('insumo.categoria as cat','ins.ins_id_cat','=','cat.cat_id')
			->join('insumo.partida as part', 'ins.ins_id_part', '=', 'part.part_id')
			->join('public._bp_planta as plan', 'insumo.stock_historial.his_stock_planta_id', '=', 'plan.id_planta')
			->select('ins.ins_codigo', 'ins.ins_desc', 'unidad.umed_nombre as unidad', 'part.part_nombre', 'stock_historial.his_stock_registrado', 'plan.nombre_planta', DB::raw('sum(stock_historial.his_stock_cant) as quantity'))
			->where(DB::raw('cast(stock_historial.his_stock_registrado as date)'), '=', $dia)
			->groupBy('ins.ins_codigo', 'ins.ins_desc', 'unidad', 'part.part_nombre', 'stock_historial.his_stock_registrado', 'plan.nombre_planta')
			->get();
		// ->where(DB::raw('cast(stocks.created_at as date)'),'=',$dia)
		// dd($stockalhist3);
		return Datatables::of($stockalhist)
			->make(true);
	}
	// BUSQUEDA POR RANGO
	public function ReporteInvRango($dia_inicio, $mes_inicio, $anio_inicio, $dia_fin, $mes_fin, $anio_fin) {
		// dd($anio."-".$mes."-".$dia);
		$fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
		$fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
		$stockalhist = Stock_Historial::join('insumo.insumo as ins', 'insumo.stock_historial.his_stock_ins_id', '=', 'ins.ins_id')
			->leftjoin('insumo.unidad_medida as unidad', 'ins.ins_id_uni', '=', 'unidad.umed_id')
			->join('insumo.partida as part', 'ins.ins_id_part', '=', 'part.part_id')
			->join('public._bp_planta as plan', 'insumo.stock_historial.his_stock_planta_id', '=', 'plan.id_planta')
			->select('ins.ins_codigo', 'ins.ins_desc', 'unidad.umed_nombre as unidad', 'part.part_nombre', 'stock_historial.his_stock_registrado', 'plan.nombre_planta', DB::raw('sum(stock_historial.his_stock_cant) as quantity'))
			->where(DB::raw('cast(stock_historial.his_stock_registrado as date)'), '>=', $fechainicial)
			->where(DB::raw('cast(stock_historial.his_stock_registrado as date)'), '<=', $fechafinal)
			->groupBy('ins.ins_codigo', 'ins.ins_desc', 'unidad', 'part.part_nombre', 'stock_historial.his_stock_registrado', 'plan.nombre_planta')
			->get();
		// dd($stockalhist3);
		return Datatables::of($stockalhist)
			->make(true);
	}
	public function rptInventarioGeneral() {
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
		$pdf->Cell(70, 6, utf8_decode('Responsable de Acopio - EBA'), 0, 1, 'C', 0);
		PDF::SetXY(120, 204);
		PDF::Cell(15, 6, utf8_decode('Nombre:'), 0, 0, 'C', 0);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once dirname(__FILE__) . '/lang/eng.php';
			$pdf->setLanguageArray($l);
		}

		$pdf->SetFont('helvetica', '', 9);

		// add a page
		$pdf->AddPage('L', 'Carta');
		//PDF::AddPage();

		// create some HTML content
		$usr = Usuario::setNombreRegistro();
		$per = Collect($usr);
		$id = Auth::user()->usr_id;
		//  echo $id;
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->where('usr_id', $id)->first();

		$reg = Stock_Almacen::join('insumo.insumo as insu', 'insumo.stock_almacen.stockal_ins_id', '=', 'insu.ins_id')
			->join('insumo.dato as um', 'insu.ins_id_uni', '=', 'um.dat_id')
			->join('insumo.partida as part', 'insu.ins_id_part', '=', 'part.part_id')
			->join('insumo.dato as cat', 'insu.ins_id_cat', '=', 'cat.dat_id')
			->select('ins_codigo', 'stockal_cantidad', 'ins_desc', 'um.dat_nom as nom_unidad', 'part.part_nom', 'cat.dat_nom as nom_categoria')
			->where('stockal_planta_id', '=', $planta->id_planta)
			->orderby('stockal_id', 'ASC')->get();
		// dd($reg);
		// echo $reg;
		$html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><br><br><img src="/img/logopeqe.png" width="140" height="65"></th>
                             <th  width="830"><h3 align="center"><br>REPORTE INVENTARIO GENERAL<br>ALMACEN INSUMOS <br>Fecha de Emision: ' . date('d/m/Y') . '<br></h3></th>
                        </tr>
                    </table>
                    <br><br>
                        <label>GENERADO POR: ' . $per['prs_nombres'] . ' ' . $per['prs_paterno'] . ' ' . $per['prs_materno'] . '</label>
                        <br><br>
                    <table border="1" cellspacing="0" cellpadding="1">

                        <tr>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>CODIGO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="260"><strong>DETALLE ARTICULO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>UNIDAD</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>CANTIDAD</strong></th>
                            <th align="center" bgcolor="#3498DB" width="175"><strong>CATEGORIA</strong></th>
                            <th align="center" bgcolor="#3498DB" width="180"><strong>PARTIDA</strong></th>
                        </tr>';
		$nro = 0;
		$totalCantidad = 0;
		foreach ($reg as $key => $r) {
			$totalCantidad = $totalCantidad + $r->stockal_cantidad;
			$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                        		        	<td align="center">' . $r->ins_codigo . '</td>
                                			<td align="center">' . $r->ins_desc . '</td>
                                			<td align="center">' . $r->nom_unidad . '</td>
                                			<td align="center">' . number_format($r->stockal_cantidad, 2, '.', ',') . '</td>
                                			<td align="center">' . $r->nom_categoria . '</td>
                                			<td align="center">' . $r->part_nom . '</td>
                                		</tr>';
		}
		$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                        		        	<td align="center" colspan="3">TOTALES</td>
                                			<td align="center">' . number_format($totalCantidad, 2, '.', ',') . '</td>
                                			<td align="center"></td>
                                			<td align="center"></td>
                                	</tr>';

		$htmltable = $html . '</table>';
		$pdf->writeHTML($htmltable, true, 0, true, 0);

		// reset pointer to the last page

		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('Reporte_salidas_Almacen.pdf', 'I');
	}

	public function rptKardexValoradoInsumo($rep) {
		//dd("KARDEX VALORADO");
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
		//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		PDF::SetXY(125, 199);
		$pdf->Cell(70, 6, utf8_decode('Responsable de Acopio - EBA'), 0, 1, 'C', 0);
		PDF::SetXY(120, 204);
		PDF::Cell(15, 6, utf8_decode('Nombre:'), 0, 0, 'C', 0);
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once dirname(__FILE__) . '/lang/eng.php';
			$pdf->setLanguageArray($l);
		}
		$pdf->SetFont('helvetica', '', 9);
		$pdf->AddPage('P', 'Carta');
		$id_usuario = Auth::user()->usr_id;
		$usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
			->where('usr_id', $id_usuario)->first();
		$per = Collect($usr);
		$id = Auth::user()->usr_id;
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->where('usr_id', $id)->first();
		// return $planta;
		$insumo = InsumoHistorial::join('insumo.insumo as ins', 'insumo.insumo_historial.inshis_ins_id', '=', 'ins.ins_id')
			->join('insumo.unidad_medida as umed', 'ins.ins_id_uni', '=', 'umed.umed_id')
			->where('inshis_planta_id', '=', $planta->id_planta)->where('inshis_ins_id', $rep)->orderby('inshis_id', 'ASC')->first();
		$tabkarde = InsumoHistorial::where('inshis_planta_id', '=', $planta->id_planta)->where('inshis_ins_id', $rep)->get();
		$detallesIngresos = DetalleIngreso::where('deting_ins_id',$rep)->get();
		//dd($tabkarde);
		$html = '<br><br> <table border="0" cellspacing="0" cellpadding="1" class="bottomBorder">
                        <tr>
                             <th rowspan="3" align="center" width="150"><img src="img/logopeqe.png" width="150" height="105"></th>
                             <th rowspan="3" width="375"><h3 align="center"><br>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS<br>ALMACEN - ' . $planta->nombre_planta . '</h3><br><h1 align="center">KARDEX VALORADO</h1>
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
                             			<th align="center">'.$insumo->ins_codigo.'</th>
                             		</tr>
                             	</table>
                             </th>                     
                        </tr>
                    </table>
                        <br><br>
                        <br><br>
                    <table border="0.5">
                    	<tr BGCOLOR="#f3f0ff">
                    		<th align="center" bgcolor="#5c6875" width="200"><strong color="white">Articulo:</strong></th>
                    		<th width="465"> '.$insumo->ins_desc.'</th>
                    	</tr>
                    	<tr BGCOLOR="#f3f0ff">
                    		<th align="center" bgcolor="#5c6875" width="200"><strong color="white">Unidad de Medida:</strong></th>
                    		<th> '.$insumo->umed_nombre.'</th>
                    	</tr>
                    </table>
                    <br><br>
                    <table border="0.5" cellspacing="0" cellpadding="1" style="font-size:8px">
                        <tr>
                            <th rowspan="2" align="center" bgcolor="#5c6875" width="35"><strong color="white">No.</strong></th>
                            <th rowspan="2" align="center" bgcolor="#5c6875" width="60"><strong color="white">Fecha</strong></th>
                            <th rowspan="2" align="center" bgcolor="#5c6875" width="120"><strong color="white">Detalle</strong></th>
                            <th colspan="3" align="center" bgcolor="#5c6875" width="150"><strong color="white">Entrada.</strong></th>
                            <th colspan="3" align="center" bgcolor="#5c6875" width="150"><strong color="white">Salida</strong></th>
                            <th colspan="3" align="center" bgcolor="#5c6875" width="150"><strong color="white">Saldo</strong></th>
                        </tr>
                        <tr>
                            <th align="center" bgcolor="#5c6875" width="50"><strong color="white">Cant.</strong></th>
                            <th align="center" bgcolor="#5c6875" width="50"><strong color="white">Cost. U.</strong></th>
                            <th align="center" bgcolor="#5c6875" width="50"><strong color="white">Total</strong></th>
                            <th align="center" bgcolor="#5c6875" width="50"><strong color="white">Cant.</strong></th>
                            <th align="center" bgcolor="#5c6875" width="50"><strong color="white">Cost. U.</strong></th>
                            <th align="center" bgcolor="#5c6875" width="50"><strong color="white">Total</strong></th>
                            <th align="center" bgcolor="#5c6875" width="50"><strong color="white">Cant.</strong></th>
                            <th align="center" bgcolor="#5c6875" width="50"><strong color="white">Cost. U.</strong></th>
                            <th align="center" bgcolor="#5c6875" width="50"><strong color="white">Total</strong></th>
                        </tr>';
		$nro = 0;
		$cant = 0;
		foreach ($tabkarde as $ig) {
			$nro = $nro + 1;
			$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
							<td align="center">' . $nro . '</td>
							<td align="center">' . date('d/m/Y', strtotime($ig->inshis_registrado)) . '</td>';
			if ($ig->inshis_tipo == 'Entrada') {
				$html = $html . '<td align="center">Ingreso (NI-' . $this->traeNroIngreso($ig->inshis_deting_id) . ')</td>';
			} else {
				$html = $html . '<td align="center">Salida (NS-' . $this->traeNroSalida($ig->inshis_detorprod_id) . ')</td>';
			}
			if ($ig->inshis_deting_id != null and $ig->inshis_tipo == 'Entrada') {
				$html = $html .
				'<td align="center">' . $ig->inshis_cantidad . '</td>
				<td align="center">' . $this->traeCosto($ig->inshis_deting_id) . '</td>
				<td align="center">' . number_format($ig->inshis_cantidad * $this->traeCosto($ig->inshis_deting_id), 2, '.', ',') . '</td>';
			} else {
				$html = $html .
					'<td align="center">-</td>
					<td align="center">-</td>
					<td align="center">-</td>';
			}
			if ($ig->inshis_detorprod_id != null) {
				$html = $html .
				'<td align="center">' . $ig->inshis_cantidad . '</td>
				<td align="center">' . $this->traeCosto($ig->inshis_deting_id) . '</td>
				<td align="center">' . number_format($ig->inshis_cantidad * $this->traeCosto($ig->inshis_deting_id), 2, '.', ',') . '</td>';
			} else {
				$html = $html .
					'<td align="center">-</td>
					<td align="center">-</td>
					<td align="center">-</td>';
			}
			if ($ig->inshis_tipo == 'Entrada') {
				$html = $html .
				'<td align="center">' . $ig->inshis_cantidad . '</td>
				<td align="center">' . $this->traeCosto($ig->inshis_deting_id) . '</td>
				<td align="center">' . number_format($ig->inshis_cantidad * $this->traeCosto($ig->inshis_deting_id), 2, '.', ',') . '</td>';
			} else {
				$detalle_ingreso = $detallesIngresos->where('deting_id',$ig->inshis_deting_id)->first();
				$detalle_orp = DB::table('insumo.detalle_orden_produccion')->where('detorprod_id', $ig->inshis_detorprod_id)->first();

				if ($detalle_orp->detorprod_cantidad > $detalle_ingreso->deting_cantidad) {
					$det_nro = 0;
				} else {
					$detalle_ingreso->deting_cantidad = $detalle_ingreso->deting_cantidad - $ig->inshis_cantidad;
					$det_nro = $detalle_ingreso->deting_cantidad;
				}
				$html = $html .
				'<td align="center">' . number_format($det_nro, 2, '.', ',') . '</td>
				<td align="center">' . number_format($this->traeCosto($ig->inshis_deting_id), 2, '.', ',') . '</td>
				<td align="center">' . number_format($det_nro * $this->traeCosto($ig->inshis_deting_id), 2, '.', ',') . '</td>';

			}

			$html = $html . '</tr>';
		}
		$htmltable = $html . '</table><table><tr><td></td></tr><tr><td></td></tr></table>';
		$htmltable = $htmltable . '<table border="0.5" cellspacing="0" cellpadding="1" style="font-size:8px;">
                        <tr>
                            <th rowspan="2" align="center" bgcolor="#5c6875" width="65"><strong color="white">No.</strong></th>
                            <th rowspan="2" align="center" bgcolor="#5c6875" width="300"><strong color="white">Fecha Ingreso/Movimiento</strong></th>
                            <th colspan="3" align="center" bgcolor="#5c6875" width="300"><strong color="white">Resumen Saldos</strong></th>
                        </tr>
                        <tr>
                            <th align="center" bgcolor="#5c6875" width="100"><strong color="white">Cant.</strong></th>
                            <th align="center" bgcolor="#5c6875" width="100"><strong color="white">Cost. U.</strong></th>
                            <th align="center" bgcolor="#5c6875" width="100"><strong color="white">Total</strong></th>
                        </tr>';
		$stocks = Stock::join('insumo.detalle_ingreso as deting', 'insumo.stock.stock_deting_id', '=', 'deting.deting_id')
			->where('stock_planta_id', $planta->id_planta)
			->where('stock_cantidad', '>', 0)
			->where('stock_ins_id', $rep)
			->orderby('deting_ing_id')
			->get();
		$total_quantity = 0;
		$total_cost = 0;
		$total_amount = 0;
		$count = 1;
		$nrosaldos = 0;
		foreach ($stocks as $stock) {
			$nrosaldos = $nrosaldos + 1;
			$htmltable = $htmltable .
			'<tr align="center" BGCOLOR="#f3f0ff">
                                        <td align="center">' . $nrosaldos . '</td>
                                        <td align="center">' . date('d/m/Y', strtotime($stock->stock_registrado)) . '</td>
                                        <td align="center">' . number_format($stock->stock_cantidad, 2, '.', '.') . '</td>
                                        <td align="center">' . number_format($stock->stock_costo, 2, '.', '.') . '</td>
                                        <td align="center">' . number_format($stock->stock_cantidad * $stock->stock_costo, 2, '.', '.') . '</td>
                                      </tr>';
			$total_quantity += $stock->stock_cantidad;
			$total_cost += $stock->stock_costo;
			$total_amount += $stock->stock_cantidad * $stock->stock_costo;
		}
		$htmltable = $htmltable .
		'<tr>
                                    <td align="center" colspan="2" BGCOLOR="#5c6875"><strong color="white">TOTAL</strong></td>
                                    <td align="center" BGCOLOR="#f3f0ff">' . number_format($total_quantity, 2, '.', ',') . '</td>
                                    <td align="center" BGCOLOR="#f3f0ff">-</td>
                                    <td align="center" BGCOLOR="#f3f0ff">' . number_format($total_amount, 2, '.', ',') . '</td>
                                  </tr>';
		$htmltable = $htmltable . '</table>';
		$htmltable = $htmltable . '<br><br><br><br><br><br><br><br><br><br><br><br>';
		$htmltable = $htmltable . '
                                <table>
                                    <tr>
                                        <td align="center">Revisado por firma: ..................................................</td>
                                        <td align="center">Verificado por firma: ..................................................</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">Nombre: ..................................................</td>
                                        <td align="center">Nombre: ..................................................</td>
                                    </tr>
                                    
                                </table>';
		$pdf->writeHTML($htmltable, true, 0, true, 0);
		$pdf->lastPage();
		$pdf->Output('Reporte_Kardex_Insumo_Almacen.pdf', 'I');
	}

	public function rptKardexFisicoInsumo($rep) {
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
		$pdf->Cell(70, 6, utf8_decode('Responsable de Acopio - EBA'), 0, 1, 'C', 0);
		PDF::SetXY(120, 204);
		PDF::Cell(15, 6, utf8_decode('Nombre:'), 0, 0, 'C', 0);
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once dirname(__FILE__) . '/lang/eng.php';
			$pdf->setLanguageArray($l);
		}
		$pdf->SetFont('helvetica', '', 9);
		$pdf->AddPage('P', 'Carta');
		$id_usuario = Auth::user()->usr_id;
		$usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
			->where('usr_id', $id_usuario)->first();
		$per = Collect($usr);
		$id = Auth::user()->usr_id;
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->where('usr_id', $id)->first();
		$insumo = InsumoHistorial::join('insumo.insumo as ins', 'insumo.insumo_historial.inshis_ins_id', '=', 'ins.ins_id')
			->join('insumo.unidad_medida as umed', 'ins.ins_id_uni', '=', 'umed.umed_id')
			->where('inshis_planta_id', '=', $planta->id_planta)->where('inshis_ins_id', $rep)->orderby('inshis_id', 'ASC')->first();
		$tabkarde = InsumoHistorial::where('inshis_planta_id', '=', $planta->id_planta)->where('inshis_ins_id', $rep)->get();
		$detallesIngresos = DetalleIngreso::where('deting_ins_id',$rep)->get();
		//dd($tabkarde);
		$html = '<br><br> <table border="0" cellspacing="0" cellpadding="1" class="bottomBorder">
                        <tr>
                             <th rowspan="3" align="center" width="150"><img src="img/logopeqe.png" width="150" height="105"></th>
                             <th rowspan="3" width="375"><h3 align="center"><br>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS<br>ALMACEN - ' . $planta->nombre_planta . '</h3><br><h1 align="center">KARDEX FISICO</h1>
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
                             			<th align="center">'.$insumo->ins_codigo.'</th>
                             		</tr>
                             	</table>
                             </th>                     
                        </tr>
                    </table>
                    <br><br>
                       <br><br>
   	                    <table border="0.5">
	                    	<tr BGCOLOR="#f3f0ff">
	                    		<th align="center" bgcolor="#5c6875" width="200"><strong color="white">Articulo:</strong></th>
	                    		<th width="465"> '.$insumo->ins_desc.'</th>
	                    	</tr>
	                    	<tr BGCOLOR="#f3f0ff">
	                    		<th align="center" bgcolor="#5c6875" width="200"><strong color="white">Unidad de Medida:</strong></th>
	                    		<th> '.$insumo->umed_nombre.'</th>
	                    	</tr>
	                    </table>
                        <br><br>
                    <table border="1" cellspacing="0" cellpadding="1" style="font-size:8px;">
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="35" bgcolor="#5c6875"><strong color="white">No.</strong></th>
                            <th align="center" bgcolor="#3498DB" width="60" bgcolor="#5c6875"><strong color="white">Fecha</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120" bgcolor="#5c6875"><strong color="white">Detalle</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150" bgcolor="#5c6875"><strong color="white">Entrada</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150" bgcolor="#5c6875"><strong color="white">Salida</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150" bgcolor="#5c6875"><strong color="white">Saldo</strong></th>
                        </tr>';
		$nro = 0;
		$cant = 0;

		foreach ($tabkarde as $ig) {
			$nro = $nro + 1;
			$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                        <td align="center">' . $nro . '</td>
                                        <td align="center">' . date('d/m/Y', strtotime($ig->inshis_registrado)) . '</td>';
			if ($ig->inshis_tipo == 'Entrada') {
				$html = $html . '<td align="center">Ingreso (NI-' . $this->traeNroIngreso($ig->inshis_deting_id) . ')</td>';
			} else {
				$html = $html . '<td align="center">Salida (NS-' . $this->traeNroSalida($ig->inshis_detorprod_id) . ')</td>';
			}
			if ($ig->inshis_deting_id != null and $ig->inshis_tipo == 'Entrada') {
				$html = $html .
				'<td align="center">' . $ig->inshis_cantidad . '</td>';
			} else {
				$html = $html .
					'<td align="center">-</td>';
			}
			if ($ig->inshis_detorprod_id != null) {
				$html = $html .
				'<td align="center">' . $ig->inshis_cantidad . '</td>';
			} else {
				$html = $html .
					'<td align="center">-</td>';
			}
			if ($ig->inshis_tipo == 'Entrada') {
				$html = $html .
				'<td align="center">' . $ig->inshis_cantidad . '</td>';
			} else {
				$detalle_ingreso = $detallesIngresos->where('deting_id',$ig->inshis_deting_id)->first();
				$detalle_orp = DB::table('insumo.detalle_orden_produccion')->where('detorprod_id', $ig->inshis_detorprod_id)->first();

				if ($detalle_orp->detorprod_cantidad > $detalle_ingreso->deting_cantidad) {
					$det_nro = 0;
				} else {
					$detalle_ingreso->deting_cantidad = $detalle_ingreso->deting_cantidad - $ig->inshis_cantidad;
					$det_nro = $detalle_ingreso->deting_cantidad;

				}
				$html = $html .
				'<td align="center">' . number_format($det_nro, 2, '.', ',') . '</td>';

			}

			$html = $html . '</tr>';
		}

		$htmltable = $html . '</table>
                    <br><br><br><br><br><br><br><br><br><br><br><br>';
		$htmltable = $htmltable . '
                                <table>
                                   <tr>
                                        <td align="center">Revisado por firma: ..................................................</td>
                                        <td align="center">Verificado por firma: ..................................................</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">Nombre: ..................................................</td>
                                        <td align="center">Nombre: ..................................................</td>
                                    </tr>
                                </table>';
		$pdf->writeHTML($htmltable, true, 0, true, 0);
		$pdf->lastPage();
		$pdf->Output('Reporte_Kardex_Fisico_Insumo_Almacen.pdf', 'I');
	}
	function traeNroIngreso($id) {
		$ingreso = InsumoHistorial::join('insumo.detalle_ingreso as deting', 'insumo.insumo_historial.inshis_deting_id', '=', 'deting.deting_id')
			->join('insumo.ingreso as ing', 'deting.deting_ing_id', '=', 'ing.ing_id')
			->where('inshis_deting_id', $id)
			->first();
		return $ingreso->ing_enumeracion;
	}
	function traeNroSalida($id) {
		$salida = InsumoHistorial::join('insumo.detalle_orden_produccion as detorp', 'insumo.insumo_historial.inshis_detorprod_id', '=', 'detorp.detorprod_id')
			->join('insumo.orden_produccion as orp', 'detorp.detorprod_orprod_id', 'orp.orprod_id')
			->where('inshis_detorprod_id', $id)->first();
		return $salida->orprod_nro_salida;
	}
	function traeCosto($id) {
		$ingreso = InsumoHistorial::join('insumo.detalle_ingreso as deting', 'insumo.insumo_historial.inshis_deting_id', '=', 'deting.deting_id')
		//->join('insumo.ingreso as ing','deting.deting_ing_id','=','ing.ing_id')
			->where('inshis_deting_id', $id)
			->first();
		return $ingreso->deting_costo;
	}
	public function rptMensual() {
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
		$pdf->Cell(70, 6, utf8_decode('Responsable de Acopio - EBA'), 0, 1, 'C', 0);
		PDF::SetXY(120, 204);
		PDF::Cell(15, 6, utf8_decode('Nombre:'), 0, 0, 'C', 0);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once dirname(__FILE__) . '/lang/eng.php';
			$pdf->setLanguageArray($l);
		}

		$pdf->SetFont('helvetica', '', 9);

		// add a page
		$pdf->AddPage('L', 'Carta');
		//PDF::AddPage();

		// create some HTML content
		//$usr = Usuario::setNombreRegistro();
		$id_usuario = Auth::user()->usr_id;
		$usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
			->where('usr_id', $id_usuario)->first();
		$per = Collect($usr);
		$id = Auth::user()->usr_id;
		//  echo $id;
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->where('usr_id', $id)->first();

		//$insumo_ingreso = DetalleIngreso::join('insumo.ingreso as ing','insumo.detalle_ingreso.deting_ing_id','=','ing.ing_id')->where('ing_planta_id', '=', $planta->id_planta)->orderby('deting_ins_id', 'ASC')->get();
		$insumo_ingreso = DetalleIngreso::select(DB::raw('SUM(deting_cantidad) as deting_cantidad'),'deting_ins_id','deting_costo')->join('insumo.ingreso as ing','insumo.detalle_ingreso.deting_ing_id','=','ing.ing_id')->where('ing_planta_id', '=', $planta->id_planta)->groupBy('deting_costo','deting_ins_id')->orderby('deting_ins_id', 'ASC')->get();
		//dd($insumo_ingreso);
		$html = '   <br><br> <table border="0" cellspacing="0" cellpadding="1" class="bottomBorder">
                        <tr>
                             <th rowspan="3" align="center" width="250"><img src="img/logopeqe.png" width="150" height="105"></th>
                             <th rowspan="3" width="475"><h2 align="center"><br>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS</h2><br><h3 align="center">ALMACEN - ' . $planta->nombre_planta . '</h3><br><h1 align="center">REPORTE MENSUAL</h1>
                             </th> 
                             <th rowspan="3" align="center" width="250">
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
                             			<th align="center"></th>
                             		</tr>
                             	</table>
                             </th>                     
                        </tr>
                    </table>
                    <br><br>
                    <br><br>
                    <br><br>
                    <table border="1" cellspacing="0" cellpadding="1" style="font-size:8px;">
                        <tr>
                            <th rowspan="2" align="center" bgcolor="#5c6875" width="40"><strong color="white">No.</strong></th>
                            <th rowspan="2" align="center" bgcolor="#5c6875" width="60"><strong color="white">Codigo</strong></th>
                            <th rowspan="2" align="center" bgcolor="#5c6875" width="220"><strong color="white">Detalle Articulo</strong></th>
                            <th rowspan="2" align="center" bgcolor="#5c6875" width="70"><strong color="white">Precio U.</strong></th>
                            <th rowspan="2" align="center" bgcolor="#5c6875" width="70"><strong color="white">Total</strong></th>
                            <th rowspan="2" align="center" bgcolor="#5c6875" width="90"><strong color="white">Unidad</strong></th>
                            <th colspan="3" align="center" bgcolor="#5c6875" width="210"><strong color="white">Cantidad Fisica</strong></th>
                            <th colspan="3" align="center" bgcolor="#5c6875" width="210"><strong color="white">Costo</strong></th>

                        </tr>
                        <tr>

                            <th align="center" bgcolor="#5c6875" width="70"><strong color="white">Entrada</strong></th>
                            <th align="center" bgcolor="#5c6875" width="70"><strong color="white">Salida</strong></th>
                            <th align="center" bgcolor="#5c6875" width="70"><strong color="white">Saldo</strong></th>
                            <th align="center" bgcolor="#5c6875" width="70"><strong color="white">Entrada</strong></th>
                            <th align="center" bgcolor="#5c6875" width="70"><strong color="white">Salida</strong></th>
                            <th align="center" bgcolor="#5c6875" width="70"><strong color="white">Saldo</strong></th>
                        </tr>';
		$nro = 0;
		$totalCantidad = 0;

		$totaCost = 0;
		$totaSalida = 0;
		$totaSaldo = 0;
		//dd($insumo_ingreso);
		foreach ($insumo_ingreso as $key => $ig) {
			
			$nro = $nro + 1;
			$salidas = $this->traeSalidas($ig->deting_ins_id,$planta->id_planta);
			$saldo_cantidad = $ig->deting_cantidad - $salidas;
			$costo_entrada = $ig->deting_cantidad * $ig->deting_costo;
			$costo_salida = $ig->deting_costo * $salidas;
			$saldo_costos = $costo_entrada - $costo_salida;

			$totaCost = $totaCost + $costo_entrada;
			$totaSalida = $totaSalida +$costo_salida;
			$totaSaldo = $totaSaldo + $saldo_costos;
			$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                                <td align="center">' . $nro . '</td>
                                                <td align="center">' . $this->traeCodigo($ig->deting_ins_id). '</td>
                                                <td align="center">' . $this->traeDetalle($ig->deting_ins_id).'</td>
                                                <td align="center">' . $ig->deting_costo. '</td>
                                                <td align="center">' . $ig->deting_cantidad .'</td>
                                                <td align="center">' . $this->traeUnidad($ig->deting_ins_id) . '</td>
                                                <td align="center">' . number_format($ig->deting_cantidad,2,'.',','). '</td>
                                                <td align="center">' . number_format($salidas,2,'.',','). '</td>
                                                <td align="center">' . number_format($saldo_cantidad,2,'.',','). '</td>
                                                <td align="center">' . number_format($costo_entrada,2,'.',','). '</td>
                                                <td align="center">' . number_format($costo_salida,2,'.',','). '</td>
                                                <td align="center">' . number_format($saldo_costos,2,'.',',').'</td>
                                            </tr>';
		}
		$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                            <td align="center" colspan="9" bgcolor="#5c6875"><strong color="white">TOTALES</strong></td>

                                            <td align="center"><strong>' . number_format($totaCost, 2, '.', ',') . '</strong></td>
                                            <td align="center"><strong>' . number_format($totaSalida, 2, '.', ',') . '</strong></td>
                                            <td align="center"><strong>' . number_format($totaSaldo, 2, '.', ',') . '</strong></td>
                                    </tr>';

		$htmltable = $html . '</table><br><br><br><br><br><br><br><br><br><br>';
		$htmltable = $htmltable . '
                                <table>
                                   <tr>
                                        <td align="center">Revisado por firma: ..................................................</td>
                                        <td align="center">Verificado por firma: ..................................................</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">Nombre: ..................................................</td>
                                        <td align="center">Nombre: ..................................................</td>
                                    </tr>
                                </table>';
		$pdf->writeHTML($htmltable, true, 0, true, 0);

		// reset pointer to the last page

		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('Reporte_Mensual_Almacen.pdf', 'I');

	}

	public function rptCostoAlmacen() {
		//dd("KARDEX VALORADO");
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
		$pdf->SetSubject('INSUMOS RESUMEN DEL MOVIMIENTO DE COSTOS DE ALMACEN');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '',PDF_FONT_SIZE_DATA)); 
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		PDF::SetXY(125, 199);
		$pdf->Cell(70, 6, utf8_decode('Responsable de Acopio - EBA'), 0, 1, 'C', 0);
		PDF::SetXY(120, 204);
		PDF::Cell(15, 6, utf8_decode('Nombre:'), 0, 0, 'C', 0);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once dirname(__FILE__) . '/lang/eng.php';
			$pdf->setLanguageArray($l);
		}

		$pdf->SetFont('helvetica', '', 9);

		// add a page
		$pdf->AddPage('P', 'Carta');
		//PDF::AddPage();

		// create some HTML content
		//$usr = Usuario::setNombreRegistro();
		//$per = Collect($usr);
		//$id = Auth::user()->usr_id;
		//  echo $id;
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
			->where('usr_id', Auth::user()->usr_id)->first();

		
		$htmltable = '<br><br> <table border="0" cellspacing="0" cellpadding="1" class="bottomBorder">
                        <tr>
                             <th rowspan="3" align="center" width="150"><img src="img/logopeqe.png" width="150" height="105"></th>
                             <th rowspan="3" width="375"><h3 align="center"><br>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS<br>ALMACEN - ' . $planta->nombre_planta . '</h3><br><h2 align="center">CUADRO DE RESUMEN DEL MOVIMIENTO DE COSTOS DE ALMACEN</h2>
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
                             			<th align="center" >'. $planta->prs_nombres .' '.$planta->prs_paterno.'</th>
                             		</tr>
                             		<tr BGCOLOR="#f3f0ff">
                             			<th align="center" bgcolor="#5c6875"><strong color="white">Codigo:</strong></th>
                             			<th align="center"></th>
                             		</tr>
                             	</table>
                             </th>                     
                        </tr>
                    </table>
                    <br><br><br><br><br>
                    ';
		$htmltable = $htmltable . '
                                <table>
                                    <tr>
                                        <td width="60"></td>
                                        <td width="170">INVENTARIO INICIAL</td>
                                        <td width="60" align="rigth">100000</td>
                                    </tr>
                                    <tr>
                                        <td width="60">mas</td>
                                        <td width="170">COMPRAS</td>
                                        <td width="60" align="rigth" style="border-bottom:1px solid black;">1000</td>
                                    </tr>
                                    <tr>
                                        <td width="60"></td>
                                        <td width="170">INVENTARIO DISP.</td>
                                        <td width="60" align="rigth">1000</td>
                                    </tr>
                                    <tr>
                                        <td width="60">menos</td>
                                        <td width="170">COSTOS CONSUMIDOS</td>
                                        <td width="60" align="rigth" style="border-bottom:1px solid black;">100</td>
                                    </tr>
                                    <tr>
                                        <td width="60"></td>
                                        <td width="170">COSTO MERCADERIA DISP.</td>
                                        <td width="60" align="rigth">100</td>
                                    </tr>
                                </table><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                ';
        $htmltable = $htmltable . '
                                <table>
                                    <tr>
                                        <td align="center">Revisado por firma: ..................................................</td>
                                        <td align="center">Verificado por firma: ..................................................</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">Nombre: ..................................................</td>
                                        <td align="center">Nombre: ..................................................</td>
                                    </tr>
                                    
                                </table>';

		$pdf->writeHTML($htmltable, true, 0, true, 0);

		// reset pointer to the last page

		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('Reporte_Costo_Almacen.pdf', 'I');
	}

	//FUNCIONES
	function calcularTotal($precio, $cantidad) {
		$result = $precio * $cantidad;
		return $result;
	}
	function obtenerSalidas($id_insumo) {
		$cantidad_insumo = 0;
		//$salida = Aprobacion_solicitud::where('aprsol_estado','=','A')->get();
		$salida = DetalleAprobSol::where('detaprob_id_ins', $id_insumo)->get();
		//dd($salida);
		foreach ($salida as $key => $sal) {
			//dd($sal);
			//$dato = json_decode($sal->aprsol_data);
			//$dato_insumo_id = $dato[0]->id_insumo;
			//if ($dato_insumo_id == $id_insumo) {
			//    $cantidad_insumo = $cantidad_insumo + ($dato[0]->cantidad+$dato[0]->rango_adicional+$dato[0]->solicitud_adicional);
			//}
			$cantidad_insumo = $cantidad_insumo + $sal->detaprob_cantidad;
		}
		return $cantidad_insumo;
	}
	function obtenerPrecio($id_insumo) {
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->where('usr_id', Auth::user()->usr_id)->first();
		$precio_insumo = CarroIngreso::where('carr_ing_id_planta', '=', $planta->id_planta)->get();
		$pri = 0;
		foreach ($precio_insumo as $key => $precioins) {
			$datains = json_decode($precioins->carr_ing_data);
			foreach ($datains as $key => $datin) {
				if ($id_insumo == $datin->carr_id_insumo) {
					$pri = $pri + $datin->carr_costo;
				}
			}
		}
		return $pri;

	}
	function traeCodigo($id_insumo) {
		$insumo = Insumo::where('ins_id', $id_insumo)->first();
		return $insumo->ins_codigo;
	}
	function traeDetalle($id_insumo) {
		$insumo = Insumo::where('ins_id', $id_insumo)->first();
		return $insumo->ins_desc;
	}
	function traeUnidad($id_insumo) {
		$insumo = Insumo::join('insumo.unidad_medida as umed', 'insumo.insumo.ins_id_uni', '=', 'umed.umed_id')
			->where('ins_id', $id_insumo)->first();
		return $insumo->umed_nombre;
	}
	function traeSalidas($id_insumo,$id_planta)
	{
		//dd("INS ID: ".$id_insumo.", ID DETING: ".$id_deting);
		$insumo = InsumoHistorial::select(DB::raw('SUM(inshis_cantidad) as cantidad'))->where('inshis_ins_id',$id_insumo)->where('inshis_detorprod_id','<>',null)->where('inshis_planta_id',$id_planta)->first();
		//dd($insumo);
		if ($insumo->cantidad) {
			return $insumo->cantidad;
		}else{
			return 0.00;
		}
	}

	// LISTAR INGRESO POR ALMACEN
	public function listarIngresoAlmacen() {
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$reg = Ingreso::join('insumo.detalle_ingreso as det','insumo.ingreso.ing_id','=','det.deting_ing_id')
					  ->join('insumo.insumo as ins','det.deting_ins_id','=','ins.ins_id')
					  ->join('insumo.tipo_ingreso as tip','insumo.ingreso.ing_id_tiping','=','tip.ting_id')
					  ->where('ing_planta_id',$planta->id_planta)->get();
		//dd($reg);
		return view('backend.administracion.insumo.insumo_reportes.ingresos_almacen.index');
	}

	public function createListarIngresoAlmacen($mes,$anio) {
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$anio1 = $anio;
		$diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
		$fechainicial = $anio1 . "-" . $mes . "-01";
		$fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
		$reg = Ingreso::join('insumo.detalle_ingreso as det','insumo.ingreso.ing_id','=','det.deting_ing_id')
					  ->join('insumo.insumo as ins','det.deting_ins_id','=','ins.ins_id')
					  ->join('insumo.tipo_ingreso as tip','insumo.ingreso.ing_id_tiping','=','tip.ting_id')
					  ->where('ing_registrado', '>=', $fechainicial)->where('ing_registrado', '<=', $fechafinal)
					  ->where('ing_planta_id',$planta->id_planta)->get();
		return Datatables::of($reg)
			->editColumn('id', 'ID: {{$ing_id}}')
			->make(true);
	}
	public function createListarIngresoAlmacenDia($dia,$mes,$anio)
	{
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$dia = $anio . "-" . $mes . "-" . $dia;
		$reg = Ingreso::join('insumo.detalle_ingreso as det','insumo.ingreso.ing_id','=','det.deting_ing_id')
					  ->join('insumo.insumo as ins','det.deting_ins_id','=','ins.ins_id')
					  ->join('insumo.tipo_ingreso as tip','insumo.ingreso.ing_id_tiping','=','tip.ting_id')
					  ->where(DB::raw('cast(insumo.ingreso.ing_registrado as date)'),'=',$dia)
					  ->where('ing_planta_id',$planta->id_planta)->get();
		return Datatables::of($reg)
			->editColumn('id', 'ID: {{$ing_id}}')
			->make(true);
	}
	public function createListarIngresoAlmacenRango($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin)
	{
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
		$fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
		$reg = Ingreso::join('insumo.detalle_ingreso as det','insumo.ingreso.ing_id','=','det.deting_ing_id')
					  ->join('insumo.insumo as ins','det.deting_ins_id','=','ins.ins_id')
					  ->join('insumo.tipo_ingreso as tip','insumo.ingreso.ing_id_tiping','=','tip.ting_id')
					  ->where(DB::raw('cast(insumo.ingreso.ing_registrado as date)'), '>=', $fechainicial)
					  ->where(DB::raw('cast(insumo.ingreso.ing_registrado as date)'), '<=', $fechafinal)
					  ->where('ing_planta_id',$planta->id_planta)->get();
		return Datatables::of($reg)
			->editColumn('id', 'ID: {{$ing_id}}')
			->make(true);
	}
	// LISTAR SOLICITUD POR ALMACEN
	public function listarSolicitudAlmacen() {

		return view('backend.administracion.insumo.insumo_reportes.solicitud_almacen.index');
	}

	public function listReceta() {
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			      ->where('usr_id', '=', Auth::user()->usr_id)->first();
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_planta_id',$planta->id_planta)->where('orprod_tiporprod_id',1)->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarReceta/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoRe', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listMaquila() {
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			      ->where('usr_id', '=', Auth::user()->usr_id)->first();
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_planta_id',$planta->id_planta)->where('orprod_tiporprod_id',4)->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarMaquila/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoMa', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}

	public function listAdicional() {
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			      ->where('usr_id', '=', Auth::user()->usr_id)->first();
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_planta_id',$planta->id_planta)->where('orprod_tiporprod_id',2)->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarReceta/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoAdi', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listTraspasoReport()
	{
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			      ->where('usr_id', '=', Auth::user()->usr_id)->first();
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_planta_traspaso',$planta->id_planta)->where('orprod_tiporprod_id',3)->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarTraspaso/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoMa', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	// LISTAR SALIDAS POR ALMACEN
	public function listarSalidasAlmacen() {
		//dd("AQUI VA LAS SALIDAS");
		return view('backend.administracion.insumo.insumo_reportes.salidas_almacen.index');
	}
	//NUEVOS FUNCIONNES DE SALIDAS
	public function listRecetaSalida()
	{
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			      ->where('usr_id', '=', Auth::user()->usr_id)->first();
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_planta_id',$planta->id_planta)->where('orprod_tiporprod_id',1)
									->where('orprod_estado_orp','D')->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarReceta/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoRe', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listAdicionalSalida()
	{
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			      ->where('usr_id', '=', Auth::user()->usr_id)->first();
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_planta_id',$planta->id_planta)->where('orprod_tiporprod_id',2)
									->where('orprod_estado_orp','D')->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarReceta/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoAdi', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);	
	}
	public function listMaquilaSalida()
	{
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			      ->where('usr_id', '=', Auth::user()->usr_id)->first();
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_planta_id',$planta->id_planta)->where('orprod_tiporprod_id',4)
									->where('orprod_estado_orp','D')->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarMaquila/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoMa', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listTraspasoSalida()
	{
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			      ->where('usr_id', '=', Auth::user()->usr_id)->first();
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_planta_traspaso',$planta->id_planta)->where('orprod_tiporprod_id',3)
									->where('orprod_estado_orp','D')->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarTraspaso/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoMa', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listRecetaSal() {
		//$solReceta = Solicitud::getlistarPlanta();
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$solReceta = Solicitud::join('insumo.receta as rec', 'insumo.solicitud.sol_id_rec', '=', 'rec.rec_id')
			->join('public._bp_usuarios as usu', 'insumo.solicitud.sol_usr_id', '=', 'usu.usr_id')
			->join('public._bp_personas as persona', 'usu.usr_prs_id', '=', 'persona.prs_id')
			->leftjoin('insumo.aprobacion_solicitud as aprsol', 'insumo.solicitud.sol_id', '=', 'aprsol.aprsol_solicitud')
			->where('sol_id_planta', '=', $planta->id_planta)->where('sol_id_tipo', '=', 1)
			->where('sol_estado', 'B')
			->where('aprsol_estado', 'A')
			->orderby('sol_id', 'DESC')->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->sol_estado == 'B') {
				// return '<h4 class="text"><span class="label label-info">RECIBIDO</span></h4>';
				return '<div class="text-center"><a href="BoletaAprovaReceta/' . $solReceta->aprsol_id . '" class="btn btn-md btn-primary" target="_blank">Boleta Salida <i class="fa fa-file"></i></a></div>';
			}
			// return '<div class="text-center"><button value="' . $solReceta->sol_id . '" class="btn btn-success btn-xs" onClick="mostrarSolReceta(this);" data-toggle="modal" data-target="#myCreateSolRecibidas"><i class="fa fa-file"></i> Ver</button></div>';

		})
			->editColumn('id', 'ID: {{$sol_id}}')
			->addColumn('sol_rec_estado', function ($solReceta) {
				if ($solReceta->sol_estado == 'A') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->aprsol_estado == 'A') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} elseif ($solReceta->aprsol_estado == 'B') {
					return '<h4 class="text"><span class="label label-danger">RECHAZADO</span></h4>';
				}

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->sol_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoRe', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listMaquilaSal() {
		//$solMaquila = Solicitud::getlistarTraspasoPlanta();
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$solMaquila = Solicitud::join('public._bp_planta as planta', 'insumo.solicitud.sol_id_origen', '=', 'planta.id_planta')
			->join('public._bp_planta as plant', 'insumo.solicitud.sol_id_destino', '=', 'plant.id_planta')
			->join('insumo.insumo as ins', 'insumo.solicitud.sol_id_insmaq', '=', 'ins.ins_id')
			->join('public._bp_usuarios as usu', 'insumo.solicitud.sol_usr_id', '=', 'usu.usr_id')
			->join('public._bp_personas as persona', 'usu.usr_prs_id', '=', 'persona.prs_id')
			->leftjoin('insumo.aprobacion_solicitud as aprsol', 'insumo.solicitud.sol_id', '=', 'aprsol.aprsol_solicitud')
			->select('insumo.solicitud.sol_id', 'insumo.solicitud.sol_estado', 'insumo.solicitud.sol_registrado', 'planta.nombre_planta as planta_origen', 'plant.nombre_planta as planta_destino', 'persona.prs_nombres', 'persona.prs_paterno', 'persona.prs_materno', 'insumo.solicitud.sol_codnum', 'aprsol.aprsol_estado', 'aprsol_id')
			->where('sol_id_planta', '=', $planta->id_planta)->where('sol_id_tipo', '=', 3)
			->where('sol_estado', 'B')
			->where('aprsol_estado', 'A')
			->get();
		return Datatables::of($solMaquila)->addColumn('acciones', function ($solMaquila) {

			// return '<div class="text-center"><button value="' . $solMaquila->sol_id . '" class="btn btn-success btn-xs" onClick="mostrarSolTraspaso(this);" data-toggle="modal" data-target="#myCreateSolTraspaso"><i class="fa fa-truck"></i> Ver</button><div>';
			if ($solMaquila->sol_estado == 'B') {
				// return '<h4 class="text"><span class="label label-info">RECIBIDO</span></h4>';
				return '<div class="text-center"><a href="BoletaAprovaTraspaso/' . $solMaquila->aprsol_id . '" class="btn btn-md btn-primary" target="_blank">Boleta Salida <i class="fa fa-file"></i></a></div>';
			}
		})
			->editColumn('id', 'ID: {{$sol_id}}')
			->addColumn('sol_maq_estado', function ($solMaquila) {
				if ($solMaquila->sol_estado == 'A') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solMaquila->aprsol_estado == 'A') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} elseif ($solMaquila->aprsol_estado == 'B') {
					return '<h4 class="text"><span class="label label-danger">RECHAZADO</span></h4>';
				}

			})
			->addColumn('nombresCompletoMa', function ($solMaquila) {
				return $solMaquila->prs_nombres . ' ' . $solMaquila->prs_paterno . ' ' . $solMaquila->prs_materno;
			})
			->make(true);
	}

	public function listAdicionalSal() {
		//$solAdicinal = Solicitud::getlistarAdiInsumoPlanta();
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$solAdicinal = Solicitud::join('insumo.receta as rec', 'insumo.solicitud.sol_id_rec', '=', 'rec.rec_id')
			->join('public._bp_usuarios as usu', 'insumo.solicitud.sol_usr_id', '=', 'usu.usr_id')
			->join('public._bp_personas as persona', 'usu.usr_prs_id', '=', 'persona.prs_id')
			->leftjoin('insumo.aprobacion_solicitud as aprsol', 'insumo.solicitud.sol_id', '=', 'aprsol.aprsol_solicitud')
			->where('sol_id_planta', '=', $planta->id_planta)->where('sol_id_tipo', '=', 2)
			->where('sol_estado', 'B')
			->where('aprsol_estado', 'A')
			->get();
		return Datatables::of($solAdicinal)->addColumn('acciones', function ($solAdicinal) {

			// return '<div class="text-center"><button value="' . $solAdicinal->sol_id . '" class="btn btn-success btn-xs" onClick="mostrarSolInsumos(this);" data-toggle="modal" data-target="#myCreateSolInsumos"><i class="fa fa-cube"></i> Ver</button></div>';
			if ($solAdicinal->sol_estado == 'B') {
				// return '<h4 class="text"><span class="label label-info">RECIBIDO</span></h4>';
				return '<div class="text-center"><a href="BoletaAprovaInsumoAdi/' . $solAdicinal->aprsol_id . '" class="btn btn-md btn-primary" target="_blank">Boleta Salida <i class="fa fa-file"></i></a></div>';
			}
		})
			->editColumn('id', 'ID: {{$sol_id}}')
			->addColumn('sol_ins_estado', function ($solAdicinal) {
				if ($solAdicinal->sol_estado == 'A') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solAdicinal->aprsol_estado == 'A') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} elseif ($solAdicinal->aprsol_estado == 'B') {
					return '<h4 class="text"><span class="label label-danger">RECHAZADO</span></h4>';
				}

			})
			->addColumn('nombresCompletoAdi', function ($solAdicinal) {
				return $solAdicinal->prs_nombres . ' ' . $solAdicinal->prs_paterno . ' ' . $solAdicinal->prs_materno;
			})
			->make(true);
	}

	//REPORTE INGRESO
	public function reporteIngreso($id_ingreso) {

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
		$pdf->Cell(70, 6, utf8_decode('Responsable de Acopio - EBA'), 0, 1, 'C', 0);
		PDF::SetXY(120, 204);
		PDF::Cell(15, 6, utf8_decode('Nombre:'), 0, 0, 'C', 0);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once dirname(__FILE__) . '/lang/eng.php';
			$pdf->setLanguageArray($l);
		}

		$pdf->SetFont('helvetica', '', 9);

		// add a page
		$pdf->AddPage('Carta');
		//PDF::AddPage();

		// create some HTML content
		//     $carr = CarritoSolicitud::getListar();
		$usr = Usuario::setNombreRegistro();
		$per = Collect($usr);
		//echo $per;
		$id = Auth::user()->usr_id;
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->where('usr_id', $id)->first();
		$reg = CarroIngreso:://join('insumo.proveedor as prov', 'carro_ingreso.carr_ing_prov', '=', 'prov.prov_id')
			join('insumo.dato', 'carro_ingreso.carr_ing_tiping', '=', 'insumo.dato.dat_id')
			->where('carr_ing_id', $id_ingreso)->orderby('carr_ing_id', 'DESC')->take(1)->first();
		// echo $reg['carr_ing_usr_id'];
		$data = $reg['carr_ing_data'];

		$array = json_decode($data);

		$mesesLiteral = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$fecha = Carbon::parse($reg['carr_ing_fech']);
		$mfecha = $fecha->month;
		$mes = $mesesLiteral[($mfecha) - 1];
		$dfecha = $fecha->day;
		$afecha = $fecha->year;

		$html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="img/logopeqe.png" width="160" height="65"></th>
                             <th  width="370"><h3 align="center"><br>ALMACEN ' . $planta['nombre_planta'] . '<br>NOTA DE INGRESO</h3></th>
                             <th  width="150"><h3 align="center"><br>Fecha: ' . date('d/m/Y') . '<br>Codigo No: ' . $reg['carr_ing_num'] . '/' . $reg['carr_ing_gestion'] . '</h3></th>
                        </tr>
                    </table>
                    <br><br><br>
                        <label><strong>Responsable de Almacen:</strong> ' . $per['prs_nombres'] . ' ' . $per['prs_paterno'] . ' ' . $per['prs_materno'] . '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Nro Contrato:</strong> ' . $reg['carr_ing_nrocontrato'] . '</label>
                        <br><br>
                        <label><strong>Dependencia:</strong> ' . $planta['nombre_planta'] . '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Tipo:</strong> ' . $reg['dat_nom'] . '</label>
                        <br><br>
                        <label><strong>Fecha Nota Rem:</strong> ' . $dfecha . ' de ' . $mes . ' de ' . $afecha . '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Nota Remisión:</strong> ' . $reg['carr_ing_rem'] . '</label>
                        <br><br>
                    <br><br><br>

                    <table border="1" cellspacing="0" cellpadding="1">

                        <tr>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB" width="80"><strong>Unidad</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150"><strong>Descripcion</strong></th>

                            <th align="center" bgcolor="#3498DB" width="100"><strong>Proveedor</strong></th>
                            <th align="center" bgcolor="#3498DB" width="90"><strong>Cantidad</strong></th>
                            <th align="center" bgcolor="#3498DB" width="90"><strong>Costo U.</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>Costo Tot.</strong></th>
                        </tr> ';
		$nro = 0;
		$tot1 = 0;
		//    echo $data;
		foreach ($array as $d) {
			$nro = $nro + 1;
			$tot = $d->carr_cantidad * $d->carr_costo;
			$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">' . $nro . '</td>
                                    <td align="center">' . $d->dat_nom . '</td>
                                    <td align="center">' . $d->carr_insumo . '</td>

                                    <td align="center">' . $d->prov_nom . '</td>
                                    <td align="center">' . number_format($d->carr_cantidad, 2, '.', ',') . '</td>
                                    <td align="center">' . number_format($d->carr_costo, 2, '.', ',') . '</td>
                                    <td align="center">' . number_format($tot, 2, '.', ',') . '</td>
                                  </tr>';
			$tot1 = $tot1 + $tot;
		}

		$html = $html . '<tr>
                                <th colspan="6" align="center"><strong>TOTAL:</strong></th>
                                <th align="center"><strong>' . number_format($tot1, 2, '.', ',') . '</strong></th>
                                </tr>
                                <br><br><br><br><br><br>
                                _________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_________________________
                                <br>
                                <label>' . $per['prs_nombres'] . ' ' . $per['prs_paterno'] . ' ' . $per['prs_materno'] . '</label>
                                <br>
                                <label><strong>Responsable de Almacen</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Responsable Administrativo</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Jefe de Planta</strong></label>
                            ';

		$htmltable = $html . '</table>';
		$pdf->writeHTML($htmltable, true, 0, true, 0);

		$pdf->lastPage();

		$pdf->Output('Reporte_almacen.pdf', 'I');

	}

	public function listarReporteGralIngreso()
	{
		$reg = Ingreso::get();
		return view('backend.administracion.insumo.insumo_reportes_gral.listarGralIngresos');
	}
	public function createListarReporteGralIngreso()
	{
		$reg = Ingreso::join('public._bp_usuarios as usu','insumo.ingreso.ing_usr_id','=','usu.usr_id')
						->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')->orderBy('ing_id','desc')->get();
		return Datatables::of($reg)->addColumn('acciones', function ($reg) {
			return '<a value="' . $reg->ing_id . '" target="_blank" class="btn btn-primary" href="/ReporteAlmacen/' . $reg->ing_id . '" type="button" ><i class="fa fa-eye"></i> REPORTE</a>';
		})->addColumn('nombre_usuario', function ($usuario) {
			return $usuario->prs_nombres . ' ' . $usuario->prs_paterno . ' ' . $usuario->prs_materno;
		})
		->addColumn('factura', function ($factura) {
			if ($factura->ing_factura == 'sin_factura.png') {
				return '<div style="background-color:red">NO TIENE FACTURA</div>';
			}else{
				return '<div style="background-color:greeen">TIENE FACTURA</div>';
			}			
		})
			->editColumn('id', 'ID: {{$ing_id}}')
			->make(true);
	}
	public function listarReporteGralSolicitudes()
	{
		return view('backend.administracion.insumo.insumo_reportes_gral.listarGralSolicitudes');	
	}
	public function listRecetaReportGral()
	{
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_tiporprod_id',1)->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarReceta/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoRe', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listAdicionalReportGral()
	{
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_tiporprod_id',2)->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarReceta/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoAdi', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listMaquilaReportGral()
	{
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_tiporprod_id',4)->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarMaquila/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoMa', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listTraspasoReportGral()
	{
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_tiporprod_id',3)->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarTraspaso/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoMa', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listarReporteGralSalidas()
	{
		return view('backend.administracion.insumo.insumo_reportes_gral.listarGralSalidas');
	}
	public function listRecetaSalidaGral()
	{

		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_tiporprod_id',1)
									->where('orprod_estado_orp','D')->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarReceta/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoRe', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listAdicionalSalidaGral()
	{
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_tiporprod_id',2)
									->where('orprod_estado_orp','D')->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarReceta/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoAdi', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);	
	}
	public function listMaquilaSalidaGral()
	{
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_tiporprod_id',4)
									->where('orprod_estado_orp','D')->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarMaquila/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoMa', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	public function listTraspasoSalidaGral()
	{
		$solReceta = OrdenProduccion::join('public._bp_usuarios as usu','orden_produccion.orprod_usr_id','=','usu.usr_id')
									->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
									->where('orprod_tiporprod_id',3)
									->where('orprod_estado_orp','D')->get();
		return Datatables::of($solReceta)->addColumn('acciones', function ($solReceta) {
			if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<div class="text-center"><a href="FormMostrarTraspaso/' . $solReceta->orprod_id . '" class="btn btn-success"><i class="fa fa-file"></i> Ver</a></div>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<div class="text-center"><a href="BoletaAprovReceta/' . $solReceta->orprod_id . '" target="_blank"class="btn btn-primary"><i class="fa fa-file"></i></a></div>';
				} 
			

		})
			->editColumn('id', 'ID: {{$orprod_id}}')
			->addColumn('orprod_estado_orp', function ($solReceta) {
				if ($solReceta->orprod_estado_orp == 'A' or $solReceta->orprod_estado_orp == 'B' or $solReceta->orprod_estado_orp == 'C') {
					return '<h4 class="text"><span class="label label-warning">PENDIENTE</span></h4>';
				} elseif ($solReceta->orprod_estado_orp == 'D') {
					return '<h4 class="text"><span class="label label-success">APROBADO</span></h4>';
				} 

			})
			->addColumn('fecha', function ($fecha) {
				$fechasolrec = Carbon::parse($fecha->orprod_registrado);
				$mfecha = $fechasolrec->month;
				$dfecha = $fechasolrec->day;
				$afecha = $fechasolrec->year;
				return $dfecha . '-' . $mfecha . '-' . $afecha;
			})
			->addColumn('nombresCompletoMa', function ($solReceta) {
				return $solReceta->prs_nombres . ' ' . $solReceta->prs_paterno . ' ' . $solReceta->prs_materno;
			})
			->make(true);
	}
	 public function reporteIngresoAlmacen()
	 {
	 	$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$reg = Ingreso::where('ing_planta_id',$planta->id_planta)->get();
		return view('backend.administracion.insumo.insumo_reportes.ingresos_almacen.reporteAlmacen');
	 }
	 public function createListarIngresoAlmacenInsumos($mes,$anio)
	 {
	 	$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$anio1 = $anio;
		$diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
		$fechainicial = $anio1 . "-" . $mes . "-01";
		$fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
		$reg = Ingreso::join('public._bp_usuarios as usu','insumo.ingreso.ing_usr_id','=','usu.usr_id')
						->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
						->select('ing_id','ing_registrado','ing_enumeracion','ing_remision','ing_factura',DB::raw("CONCAT(per.prs_nombres,' ',per.prs_paterno,' ',per.prs_materno) as nombreCompleto"))
						->where('ing_planta_id',$planta->id_planta)
						->where('ing_registrado', '>=', $fechainicial)->where('ing_registrado', '<=', $fechafinal)
						->orderBy('ing_id','desc')->get();
		
		return Datatables::of($reg)
			->editColumn('id', 'ID: {{$ing_id}}')
			->make(true);
	 }
	 public function createListarIngresoAlmacenInsumosDia($dia,$mes,$anio)
	 {
	 	$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$dia = $anio . "-" . $mes . "-" . $dia;
		$reg = Ingreso::join('public._bp_usuarios as usu','insumo.ingreso.ing_usr_id','=','usu.usr_id')
						->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
						->select('ing_id','ing_registrado','ing_enumeracion','ing_remision','ing_factura',DB::raw("CONCAT(per.prs_nombres,' ',per.prs_paterno,' ',per.prs_materno) as nombreCompleto"))
						->where('ing_planta_id',$planta->id_planta)
						->where(DB::raw('cast(insumo.ingreso.ing_registrado as date)'),'=',$dia)
						->orderBy('ing_id','desc')->get();
		
		return Datatables::of($reg)
			->editColumn('id', 'ID: {{$ing_id}}')
			->make(true);	
	 }
	 public function createListarIngresoAlmacenInsumosRango($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin)
	 {
	 	$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
		$fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
		$reg = Ingreso::join('public._bp_usuarios as usu','insumo.ingreso.ing_usr_id','=','usu.usr_id')
						->join('public._bp_personas as per','usu.usr_prs_id','=','per.prs_id')
						->select('ing_id','ing_registrado','ing_enumeracion','ing_remision','ing_factura',DB::raw("CONCAT(per.prs_nombres,' ',per.prs_paterno,' ',per.prs_materno) as nombreCompleto"))
						->where('ing_planta_id',$planta->id_planta)
						->where(DB::raw('cast(insumo.ingreso.ing_registrado as date)'), '>=', $fechainicial)
						->where(DB::raw('cast(insumo.ingreso.ing_registrado as date)'), '<=', $fechafinal)
						->orderBy('ing_id','desc')->get();
		
		return Datatables::of($reg)
			->editColumn('id', 'ID: {{$ing_id}}')
			->make(true);	
	 }
	 public function listarSalidasAlmacenInsumos()
	 {
	 	
	 	return view('backend.administracion.insumo.insumo_reportes.salidas_almacen.salidasInsumos');
	 }
	public function createListarSalidasAlmacenInsumos($mes,$anio)
	{
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$anio1 = $anio;
		$diafinal = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio1));
		$fechainicial = $anio1 . "-" . $mes . "-01";
		$fechafinal = $anio1 . "-" . $mes . "-" . $diafinal;
		$reg = OrdenProduccion::join('insumo.detalle_orden_produccion as det','insumo.orden_produccion.orprod_id','=','det.detorprod_orprod_id')
							  ->join('insumo.insumo as ins','det.detorprod_ins_id','=','ins.ins_id')
							  ->where('orprod_planta_id',$planta->id_planta)
							  ->where('orprod_fecha_vodos', '>=', $fechainicial)->where('orprod_fecha_vodos', '<=', $fechafinal)
							  ->orderBy('orprod_id','desc')->get();
		
		return Datatables::of($reg)
			->editColumn('id', 'ID: {{$orprod_id}}')
			->make(true);
	}
	public function createListarSalidasAlmacenInsumosDia($dia,$mes,$anio)
	{
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$dia = $anio . "-" . $mes . "-" . $dia;
		$reg = OrdenProduccion::join('insumo.detalle_orden_produccion as det','insumo.orden_produccion.orprod_id','=','det.detorprod_orprod_id')
							  ->join('insumo.insumo as ins','det.detorprod_ins_id','=','ins.ins_id')
							  ->where('orprod_planta_id',$planta->id_planta)
							  ->where(DB::raw('cast(insumo.orden_produccion.orprod_fecha_vodos as date)'),'=',$dia)
							  ->orderBy('orprod_id','desc')->get();		
		return Datatables::of($reg)
			->editColumn('id', 'ID: {{$orprod_id}}')
			->make(true);
	}
	public function createListarSalidasAlmacenInsumosRango($dia_inicio,$mes_inicio,$anio_inicio,$dia_fin,$mes_fin,$anio_fin)
	{
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		$fechainicial = $anio_inicio . "-" . $mes_inicio . "-" . $dia_inicio;
		$fechafinal = $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
		$reg = OrdenProduccion::join('insumo.detalle_orden_produccion as det','insumo.orden_produccion.orprod_id','=','det.detorprod_orprod_id')
							  ->join('insumo.insumo as ins','det.detorprod_ins_id','=','ins.ins_id')
							  ->where('orprod_planta_id',$planta->id_planta)
							  ->where(DB::raw('cast(insumo.orden_produccion.orprod_fecha_vodos as date)'), '>=', $fechainicial)
							  ->where(DB::raw('cast(insumo.orden_produccion.orprod_fecha_vodos as date)'), '<=', $fechafinal)
							  ->orderBy('orprod_id','desc')->get();		
		return Datatables::of($reg)
			->editColumn('id', 'ID: {{$orprod_id}}')
			->make(true);
	}
	public function ListaSolicitudAlmInsumos()
	{
		return view('backend.administracion.insumo.insumo_reportes.solicitud_almacen.solicitudInsumo');
	}
}
