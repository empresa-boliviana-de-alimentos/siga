<?php

namespace siga\Http\Controllers\insumo\insumo_registros;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Usuario;
use siga\Modelo\insumo\InsumoHistorial;
use siga\Modelo\insumo\insumo_registros\Carrito;
use siga\Modelo\insumo\insumo_registros\CarroIngreso;
use siga\Modelo\insumo\insumo_registros\Categoria;
use siga\Modelo\insumo\insumo_registros\DetalleIngreso;
use siga\Modelo\insumo\insumo_registros\DetalleIngresoPreliminar;
use siga\Modelo\insumo\insumo_registros\Ingreso;
use siga\Modelo\insumo\insumo_registros\IngresoPreliminar;
use siga\Modelo\insumo\insumo_registros\Insumo;
use siga\Modelo\insumo\insumo_registros\Proveedor;
use siga\Modelo\insumo\insumo_registros\TipoIngreso;
use siga\Modelo\insumo\insumo_solicitud\OrdenProduccion;
use siga\Modelo\insumo\Stock;
use TCPDF;
use Yajra\Datatables\Datatables;

class gbIngresoAlmacenController extends Controller {
	public function index() {
		/*$id=Auth::user()->usr_id;
			        $result = \DB::select('select * from insumo.sp_sum_carrito(?)', array($id));
			        $asig=Collect($result);
			        $array = json_decode($asig);
			        if(empty($array[0]->xtot)){
			            $tot=0;
			        }else{
			            $tot=round($array[0]->xtot, 2);
		*/
		/*$ingreso = Insumo::getListarSinMP();
			        $comboProv=Proveedor::combo();
			        $comboIng=Datos::comboIngreso();
		*/
		$ingreso = Insumo::getListarSinMP();
		$comboProv = Proveedor::where('prov_id', '<>', 1)->get();
		//dd($comboProv);
		$comboIng = TipoIngreso::where('ting_nombre', 'INGRESO')->get();
		$dataCat = Categoria::get();

		return view('backend.administracion.insumo.insumo_registro.ingreso_almacen.index', compact('comboProv', 'comboIng', 'dataCat', 'ingreso'));
	}

	public function create() {
		//$ingreso = Insumo::getListarSinMP();
		$ingreso = Insumo::getListar();
		return Datatables::of($ingreso)
			->make(true);
	}

	public function show() {
		return view('backend.administracion.insumo.insumo_registro.ingreso_almacen.index');
	}

	public function listCarrito() {
		//$carr = CarritoSolicitud::getListar();
		$carr = Carrito::getListar();
		return Datatables::of($carr)->addColumn('acciones', function ($carr) {
			return '<button value="' . $carr->carr_id . '" class="btncirculo btn-xs btn-danger glyphicon glyphicon-trash" onClick="EliminarItem(this);" data-toggle="modal" data-target="#myCreateRCA"></button>';
		})->addColumn('subtotal', function ($carr) {
			return number_format($carr->carr_cantidad * $carr->carr_costo, 2, '.', ',');
		})
			->editColumn('id', 'ID: {{$carr_id}}')
			->make(true);
	}

	public function listCarrConf() {
		//$carr = CarritoSolicitud::getListar();
		$carr = Carrito::getListar();
		return Datatables::of($carr)->addColumn('totaluni', function ($totaluni) {
			return number_format($totaluni->carr_cantidad * $totaluni->carr_costo, 2, '.', ',');
		})
		//->editColumn('id', 'ID: {{$carr_sol_id}}')
			->make(true);
	}

	public function store(Request $request) {
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')->select('planta.id_planta')->where('usr_id', '=', Auth::user()->usr_id)->first();
		/*CarritoSolicitud::create([
			            'carr_insumo'     => $request['insumo'],
			            'carr_cantidad'   => $request['cantidad'],
			            'carr_costo'      => $request['costo'],
			            'carr_id_prov'    => $request['proveedor'],
			            'carr_id_insumo'  => $request['id_insumo'],
			            'carr_cod_insumo' => $request['cod_insumo'],
			            'carr_fech_venc'  => $request['ven_insumo'],
			            'carr_usr_id'     =>  Auth::user()->usr_id,
			            'carr_estado'     => 'A',

		*/
		//var_dump($request['datos_carrito']);
		$datos_carrito = $request['datos_carrito'];
		foreach ($datos_carrito as $dc) {
			if (!$dc['cantidad_insum'] == 0 AND !$dc['proveedor_insumo'] == 0) {
				Carrito::create([
					'carr_cantidad' => $dc['cantidad_insum'],
					'carr_costo' => $dc['costo_insumo'],
					'carr_prov_id' => $dc['proveedor_insumo'],
					'carr_ins_id' => $dc['id_insumo'],
					'carr_fecha_venc' => $dc['fechaven_insumo'],
					'carr_usr_id' => Auth::user()->usr_id,
					'carr_planta_id' => $planta->id_planta,
				]);
			}
		}
		/*Carrito::create([
			            //'carr_ins_id'     => $request['insumo'],
			            'carr_cantidad'   => $request['cantidad'],
			            'carr_costo'      => $request['costo'],
			            'carr_prov_id'    => $request['proveedor'],
			            'carr_ins_id'  => $request['id_insumo'],
			            //'carr_cod_insumo' => $request['cod_insumo'],
			            'carr_fecha_venc'  => $request['ven_insumo'],
			            'carr_usr_id'     =>  Auth::user()->usr_id,
			            'carr_planta_id'  => $planta->id_planta,
			            //'carr_estado'     => 'A',

		*/
		return response()->json(['Mensaje' => 'Se registro correctamente']);
	}
	public function storeIngreso(Request $request) {
		// return $request->input;
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')->select('planta.id_planta')->where('usr_id', '=', Auth::user()->usr_id)->first();

		$id_planta = $planta->id_planta;
		$num = Ingreso::join('public._bp_planta as plant', 'insumo.ingreso.ing_planta_id', '=', 'plant.id_planta')->select(DB::raw('MAX(ing_enumeracion) as nroing'))->where('plant.id_planta', $id_planta)->first();
		$cont = $num['nroing'];
		$nid = $cont + 1;
		$fecha = date('Y');
		//$cant=19.39;
		$file = $request->file('imgFactura');
		if ($file) {
			//obtenemos el nombre del archivo
			$nombreImagenFactura = 'Factura_insumo' . time() . '_' . $file->getClientOriginalName();
			//indicamos que queremos guardar un nuevo archivo en el disco local
			\Storage::disk('local01')->put($nombreImagenFactura, \File::get($file));
		} else {
			$nombreImagenFactura = 'sin_factura.png';
		}
		$carrito = Carrito::where('carr_usr_id', Auth::user()->usr_id)->where('carr_planta_id', $id_planta)->get();
		$ingreso_alm = Ingreso::create([
			'ing_remision' => $request['carr_ing_rem'],
			'ing_id_tiping' => $request['carr_ing_tiping'],
			'ing_fecha_remision' => $request['carr_ing_fech'],
			'ing_factura' => $nombreImagenFactura,
			'ing_nrofactura' => $request['carr_ing_nrofactura'],
			'ing_usr_id' => Auth::user()->usr_id,
			'ing_planta_id' => $planta->id_planta,
			'ing_enumeracion' => $nid,
			'ing_nrocontrato' => $request['carr_ing_nrocontrato'],
		]);
		$ingreso_id = $ingreso_alm->ing_id;
		//dd($ingreso_id);
		foreach ($carrito as $dat) {
			$det_ingreso = DetalleIngreso::create([
				'deting_ins_id' => $dat->carr_ins_id,
				'deting_prov_id' => $dat->carr_prov_id,
				'deting_cantidad' => $dat->carr_cantidad,
				'deting_costo' => $dat->carr_costo,
				'deting_fecha_venc' => $dat->carr_fecha_venc,
				'deting_ing_id' => $ingreso_id,
			]);
			Stock::create([
				'stock_ins_id' => $dat->carr_ins_id,
				'stock_deting_id' => $det_ingreso->deting_id,
				'stock_cantidad' => $dat->carr_cantidad,
				'stock_costo' => $dat->carr_costo,
				'stock_fecha_venc' => $dat->carr_fecha_venc,
				'stock_planta_id' => $id_planta,
			]);
			InsumoHistorial::create([
				'inshis_ins_id' => $dat->carr_ins_id,
				'inshis_planta_id' => $id_planta,
				'inshis_tipo' => 'Entrada',
				'inshis_deting_id' => $det_ingreso->deting_id,
				'inshis_cantidad' => $dat->carr_cantidad,
			]);
			/*HistoStock::create([
				                'hist_id_carring'     => $ingreso_id,
				                'hist_id_planta'      => $planta->id_planta,
				                'hist_detale'         => $nid,
				                'hist_cant_ent'       => $dat->carr_cantidad,
				                'hist_cost_ent'       => $dat->carr_costo,
				                'hist_tot_ent'        => $dat->id_insumo,
				                'hist_usr_id'         => Auth::user()->usr_id,
				                'hist_id_ins'         => $dat->carr_id_insumo,
			*/
		}
		$this->borrarCarrito();
		return response()->json($ingreso_alm);
	}

	public function storePreliminar(Request $request) {
		$this->validate(request(), [
			'nota_de_remision' => 'required',
			'tipo_de_ingreso' => 'required',
			'fecha_de_remision' => 'required',
		]);
		// if ($request->ajax()) {
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')->select('planta.id_planta')->where('usr_id', '=', Auth::user()->usr_id)->first();

		$id_planta = $planta->id_planta;
		//$num = CarroIngreso::join('public._bp_planta as plant', 'insumo.carro_ingreso.carr_ing_id_planta', '=', 'plant.id_planta')->select(DB::raw('MAX(carr_ing_num) as nroing'))->where('plant.id_planta', $id)->first();
		//$cont=$num['nroing'];
		//$nid = $cont + 1;
		$fecha = date('Y');

		$ingreso_preliminar = IngresoPreliminar::create([
			// 'tmpp_id_prov'    => $request['tmpp_id_prov'],
			'ingpre_remision' => $request['nota_de_remision'],
			'ingpre_id_tiping' => $request['tipo_de_ingreso'],
			'ingpre_fecha_remision' => $request['fecha_de_remision'],
			//'tmpp_lote'    => $request['tmpp_lote'],
			'ingpre_usr_id' => Auth::user()->usr_id,
			'ingpre_enumeracion' => 1,
			'ingpre_planta_id' => $id_planta,
			'ingpre_nrocontrato' => $request['nro_contrato'],
			'ingpre_nrofactura' => $request['nro_factura'],
		]);
		$carrito = Carrito::where('carr_usr_id', Auth::user()->usr_id)->where('carr_planta_id', $id_planta)->get();
		//     return response()->json(['Mensaje' => 'Prelimar creado']);
		// } else {
		//     return response()->json(['Mensaje' => 'Preliminar no fue registrado']);
		// }
		foreach ($carrito as $dato) {
			DetalleIngresoPreliminar::create([
				'detingpre_ins_id' => $dato->carr_ins_id,
				'detingpre_prov_id' => $dato->carr_prov_id,
				'detingpre_cantidad' => $dato->carr_cantidad,
				'detingpre_costo' => $dato->carr_costo,
				'detingpre_fecha_venc' => $dato->carr_fecha_venc,
				'detingpre_ingpre_id' => $ingreso_preliminar->ingpre_id,
			]);
		}
		return response()->json($ingreso_preliminar);
	}
	public function edit($id) {
		$insumo = Insumo::setBuscar($id);
		return response()->json($insumo);
	}

	//  public function editingreso()
	// {
	//     $carrsol = CarritoSolicitud::getlistar();
	//    // echo $carrsol;
	//     return response()->json($carrsol);
	// }

	public function borrarItem($id) {
		//$borrarItemcarrito = CarritoSolicitud::getBorrarItem($id);
		$borrarItemcarrito = Carrito::destroy($id);
		return response()->json("Se elimino todo");
	}

	public function borrarCarrito() {
		$id = Auth::user()->usr_id;
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')->select('planta.id_planta')->where('usr_id', '=', Auth::user()->usr_id)->first();
		$deletcarr = Carrito::where('carr_usr_id', $id)->where('carr_planta_id', $planta->id_planta)->delete();
		return response()->json($deletcarr);
	}

	public function borrarPreliminar() {
		$id = Auth::user()->usr_id;
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')->select('planta.id_planta')->where('usr_id', '=', Auth::user()->usr_id)->first();
		$id_detaingpre = IngresoPreliminar::where('ingpre_usr_id', $id)->where('ingpre_planta_id', $planta->id_planta)->first();
		$deletedetpre = DetalleIngresoPreliminar::where('detingpre_ingpre_id', $id_detaingpre->ingpre_id)->delete();
		$deletpre = IngresoPreliminar::where('ingpre_usr_id', $id)->where('ingpre_planta_id', $planta->id_planta)->delete();
		return response()->json($deletpre);
	}

	public function reportePreliminar($id_ingpre) {
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

		$carr = DetalleIngresoPreliminar::join('insumo.proveedor as prov', 'insumo.detalle_ingreso_preliminar.detingpre_prov_id', '=', 'prov.prov_id')
			->join('insumo.insumo as ins', 'insumo.detalle_ingreso_preliminar.detingpre_ins_id', '=', 'ins.ins_id')
			->leftjoin('insumo.unidad_medida as uni', 'ins.ins_id_uni', '=', 'uni.umed_id')
			->where('detingpre_ingpre_id', $id_ingpre)->get();
		$id = Auth::user()->usr_id;

		$registro = Usuario::join('public._bp_personas as per', 'public._bp_usuarios.usr_prs_id', '=', 'per.prs_id')
			->where('usr_id', '=', $id)->first();
		$per = Collect($registro);
		//  echo $id;
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->where('usr_id', $id)->first();

		$reg = IngresoPreliminar::join('insumo.tipo_ingreso as tiping', 'insumo.ingreso_preliminar.ingpre_id_tiping', '=', 'tiping.ting_id')
			->where('insumo.ingreso_preliminar.ingpre_id', $id_ingpre)->first();

		$mesesLiteral = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$fecha = Carbon::parse($reg['ingpre_fecha_remision']);
		$mfecha = $fecha->month;
		$mes = $mesesLiteral[($mfecha) - 1];
		$dfecha = $fecha->day;
		$afecha = $fecha->year;

		$html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="img/logopeqe.png" width="160" height="65"></th>
                             <th  width="390"><h3 align="center"><br>ALMACEN ' . $planta['nombre_planta'] . '<br>NOTA DE INGRESO</h3></th>
                             <th  width="135"><h3 align="center"><br>Fecha: ' . date('d/m/Y') . '<br>' . $reg['ingpre_enumeracion'] . '/' . date('Y', strtotime($reg['ingpre_registrado'])) . '</h3></th>
                        </tr>
                    </table>
                    <br><br><br>
                        <label><strong>Responsable de Almacen:</strong> ' . $per['prs_nombres'] . ' ' . $per['prs_paterno'] . ' ' . $per['prs_materno'] . '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Nro. Contrato:</strong> ' . $reg['ingpre_nrocontrato'] . '</label>
                        <br><br>
                        <label><strong>Dependencia:</strong> ' . $planta['nombre_planta'] . '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Tipo:</strong> ' . $reg['ting_nombre'] . '</label>
                        <br><br>
                        <label><strong>Fecha Nota Rem:</strong> ' . $dfecha . ' de ' . $mes . ' de ' . $afecha . '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Nota Remisión:</strong> ' . $reg['ingpre_remision'] . '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Nro Factura:</strong> ' . $reg['ingpre_nrofactura'] . '</label>
                        <br><br>

                    <br><br><br>

                    <table border="1" cellspacing="0" cellpadding="1">

                        <tr>
                            <th align="center" bgcolor="#3498DB" width="35"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB" width="90"><strong>Unidad</strong></th>
                            <th align="center" bgcolor="#3498DB" width="110"><strong>Descripcion</strong></th>

                            <th align="center" bgcolor="#3498DB" width="110"><strong>Proveedor</strong></th>
                            <th align="center" bgcolor="#3998DB" width="80"><strong>Fecha venc.</strong></th>
                            <th align="center" bgcolor="#3498DB" width="80"><strong>Cantidad</strong></th>
                            <th align="center" bgcolor="#3498DB" width="80"><strong>Costo U.</strong></th>
                            <th align="center" bgcolor="#3498DB" width="80"><strong>Costo Tot.</strong></th>
                        </tr> ';
		$nro = 0;
		$tot1 = 0;
		foreach ($carr as $key => $c) {
			$nro = $nro + 1;
			$tot = $c->detingpre_cantidad * $c->detingpre_costo;
			$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center" style="font-size:7">' . $nro . '</td>
                                    <td align="center" style="font-size:7">' . $c->umed_nombre . '</td>
                                    <td align="center" style="font-size:7">' . $c->ins_desc . '</td>
                                    <td align="center" style="font-size:7">' . $c->prov_nom . '</td>
                                    <td aling="center" style="font-size:7">' . $c->detingpre_fecha_venc . '</td>
                                    <td align="center" style="font-size:7">' . number_format($c->detingpre_cantidad, 2, '.', ',') . '</td>
                                    <td align="center" style="font-size:7">' . number_format($c->detingpre_costo, 2, '.', ',') . '</td>
                                    <td align="center" style="font-size:7">' . number_format($tot, 2, '.', ',') . '</td>
                                  </tr>';
			$tot1 = $tot1 + $tot;

		}

		$html = $html . '<tr>
                                <th colspan="7" align="center"><strong>TOTAL:</strong></th>
                                <th align="center"><strong>' . number_format($tot1, 2, '.', ',') . '</strong></th>
                                </tr>
                                </table>
                                <br><br><br><br><br><br>
                                _________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_________________________
                                <br>
                                <label>' . $per['prs_nombres'] . ' ' . $per['prs_paterno'] . ' ' . $per['prs_materno'] . '</label>
                                <br>
                                <label><strong>Responsable de Almacen</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Responsable Administrativo</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Jefe de Planta</strong></label>
                            ';

		$htmltable = $html;
		$pdf->writeHTML($htmltable, true, 0, true, 0);

		// reset pointer to the last page

		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('Reporte_preliminar_Almacen.pdf', 'I');

	}

	public function reporteAlmacen($id_ingreso) {
		function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-15);
			// Set font
			$this->SetFont('Helvetica', '', 8);
			// Page number
			$this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(true);
		$pdf->SetAuthor('EBA');
		$pdf->SetTitle('EBA');
		$pdf->SetSubject('INSUMOS');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
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
		//$usr = Usuario::setNombreRegistro();
		$usr = Usuario::join('public._bp_personas as per', 'public._bp_usuarios.usr_prs_id', '=', 'per.prs_id')
			->where('usr_id', Auth::user()->usr_id)->first();
		$per = Collect($usr);
		//echo $per;
		$id = Auth::user()->usr_id;
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->where('usr_id', $id)->first();
		$reg = Ingreso::join('insumo.tipo_ingreso as tip', 'insumo.ingreso.ing_id_tiping', '=', 'tip.ting_id')
			->where('ing_id', $id_ingreso)->first();
		//$data = $reg['carr_ing_data'];

		//$array = json_decode($data);

		$mesesLiteral = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$fecha = Carbon::parse($reg['ing_fecha_remision']);
		$mfecha = $fecha->month;
		$mes = $mesesLiteral[($mfecha) - 1];
		$dfecha = $fecha->day;
		$afecha = $fecha->year;

		$html = '<br><br> <table border="0" cellspacing="0" cellpadding="1" class="bottomBorder">
                        <tr>
                             <th rowspan="3" align="center" width="150"><img src="img/logopeqe.png" width="150" height="105"></th>
                             <th rowspan="3" width="375"><h3 align="center"><br>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS<br>ALMACEN - ' . $planta->nombre_planta . '</h3><br><h1 align="center">NOTA INGRESO</h1>
                             </th>
                             <th rowspan="3" align="center" width="150">
                             <br><br>
                                <table border="0.5" bordercolor="#000">
                                    <tr BGCOLOR="#f3f0ff">
                                        <th align="center" bgcolor="#5c6875" border="0"><strong color="white">Fecha Emision:</strong></th>
                                        <th align="center">' . date('d/m/Y', strtotime($reg['ing_registrado'])) . '</th>
                                    </tr>
                                    <tr BGCOLOR="#f3f0ff">
                                        <th align="center" bgcolor="#5c6875"><strong color="white">Usuario:</strong></th>
                                        <th align="center" >' . $usr->prs_nombres . ' ' . $usr->prs_paterno . '</th>
                                    </tr>
                                    <tr BGCOLOR="#f3f0ff">
                                        <th align="center" bgcolor="#5c6875"><strong color="white">Codigo:</strong></th>
                                        <th align="center">' . $reg['ing_enumeracion'] . '/' . date('Y', strtotime($reg['ing_registrado'])) . '</th>
                                    </tr>
                                </table>
                             </th>
                        </tr>
                    </table>

                    <br><br><br>
                        <table border="1">
                            <tr BGCOLOR="#f3f0ff">
                                <th colspan="2" align="center" bgcolor="#5c6875" width="150"><strong color="white">Responsable de Almacén:</strong></th>
                                <th colspan="4" width="515"> ' . $per['prs_nombres'] . ' ' . $per['prs_paterno'] . ' ' . $per['prs_materno'] . '</th>
                            </tr>
                            <tr BGCOLOR="#f3f0ff">
                                <th align="center" bgcolor="#5c6875" width="80"><strong color="white">Dependencia:</strong></th>
                                <th width="180"> ' . $planta['nombre_planta'] . '</th>
                                <th align="center" bgcolor="#5c6875" width="80"><strong color="white">Tipo Ingreso:</strong></th>
                                <th width="160"> ' . $reg['ting_nombre'] . '</th>
                                <th align="center" bgcolor="#5c6875" width="80"><strong color="white">No. Contrato:</strong></th>
                                <th width="85"> ' . $reg['ing_nrocontrato'] . '</th>
                            </tr>
                            <tr BGCOLOR="#f3f0ff">
                                <th align="center" bgcolor="#5c6875" width="110"><strong color="white">Fecha Nota Rem:</strong></th>
                                <th width="110"> ' . $reg['ing_fecha_remision'] . '</th>
                                <th align="center" bgcolor="#5c6875" width="120"><strong color="white">Nota Remision:</strong></th>
                                <th> ' . $reg['ing_remision'] . '</th>
                                <th align="center" bgcolor="#5c6875"><strong color="white">Nro. Factura:</strong></th>
                                <th> ' . $reg['ing_nrofactura'] . '</th>
                            </tr>

                        </table>
                        <br><br><br>
                    <table border="1" cellspacing="0" cellpadding="1" style="font-size:8px;">

                        <tr>
                            <th align="center" bgcolor="#5c6875" width="35"><strong color="white">Nro</strong></th>
                            <th align="center" bgcolor="#5c6875" width="90"><strong color="white">Unidad</strong></th>
                            <th align="center" bgcolor="#5c6875" width="110"><strong color="white">Descripcion</strong></th>

                            <th align="center" bgcolor="#5c6875" width="110"><strong color="white">Proveedor</strong></th>
                            <th align="center" bgcolor="#5c6875" width="80"><strong color="white">Fecha venc.</strong></th>
                            <th align="center" bgcolor="#5c6875" width="80"><strong color="white">Cantidad</strong></th>
                            <th align="center" bgcolor="#5c6875" width="80"><strong color="white">Costo U.</strong></th>
                            <th align="center" bgcolor="#5c6875" width="80"><strong color="white">Costo Tot.</strong></th>
                        </tr> ';
		$nro = 0;
		$tot1 = 0;
		//    echo $data;
		$deta_ingreso = DetalleIngreso::join('insumo.insumo as ins', 'insumo.detalle_ingreso.deting_ins_id', '=', 'ins.ins_id')
			->leftjoin('insumo.unidad_medida as uni', 'ins.ins_id_uni', '=', 'uni.umed_id')
			->join('insumo.proveedor as prov', 'insumo.detalle_ingreso.deting_prov_id', '=', 'prov.prov_id')
			->where('deting_ing_id', $id_ingreso)->get();
		//dd($deta_ingreso);
		foreach ($deta_ingreso as $d) {
			$nro = $nro + 1;
			$tot = $d->deting_cantidad * $d->deting_costo;
			$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center" style="font-size:7">' . $nro . '</td>
                                    <td align="center" style="font-size:7">' . $d->umed_nombre . '</td>
                                    <td align="center" style="font-size:7">' . $d->ins_desc . '</td>

                                    <td align="center" style="font-size:7">' . $d->prov_nom . '</td>
                                    <td align="center" style="font-size:7">' . $d->deting_fecha_venc . '</td>
                                    <td align="center" style="font-size:7">' . number_format($d->deting_cantidad, 2, '.', ',') . '</td>
                                    <td align="center" style="font-size:7">' . number_format($d->deting_costo, 2, '.', ',') . '</td>
                                    <td align="center" style="font-size:7">' . number_format($tot, 2, '.', ',') . '</td>
                                  </tr>';
			$tot1 = $tot1 + $tot;
			// echo $tot1;

		}

		$html = $html . '<tr BGCOLOR="#f3f0ff">
                                <th colspan="7" bgcolor="#5c6875" align="center"><strong color="white">TOTAL:</strong></th>
                                <th align="center"><strong>' . number_format($tot1, 2, '.', ',') . '</strong></th>
                                </tr>
                                </table>
                                <br><br><br><br><br><br><br><br>
                                <table>
                                    <tr>
                                        <th align="center">..............................................</th>
                                        <th align="center">..............................................</th>
                                        <th align="center">..............................................</th>
                                    </tr>
                                    <tr>
                                        <th align="center">Responsable de Almacen</th>
                                        <th align="center">Responsable Administrativo</th>
                                        <th align="center">Jefe de Planta</th>
                                    </tr>
                                </table>
                            ';

		$htmltable = $html;
		$pdf->writeHTML($htmltable, true, 0, true, 0);

		// reset pointer to the last page

		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('Reporte_almacen.pdf', 'I');

	}

	public function rptIngresoAlmacen() {
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

		$reg = CarroIngreso::join('insumo.dato', 'carro_ingreso.carr_ing_tiping', '=', 'insumo.dato.dat_id')
			->where('carr_ing_usr_id', $id)->orderby('carr_ing_id', 'DESC')->get();
		// echo $reg;
		$html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><br><br><img src="/img/logopeqe.png" width="140" height="65"></th>
                             <th  width="830"><h3 align="center"><br>REPORTE GENERAL DE INGRESOS<br>ALMACEN INSUMOS' . $planta['nombre_planta'] . '<br>Fecha de Emision: ' . date('d/m/Y') . '<br></h3></th>
                        </tr>
                    </table>
                    <br><br>
                        <label>GENERADO POR: ' . $per['prs_nombres'] . ' ' . $per['prs_paterno'] . ' ' . $per['prs_materno'] . '</label>
                        <br><br>
                    <table border="1" cellspacing="0" cellpadding="1">

                        <tr>
                            <th align="center" bgcolor="#3498DB" width="30"><strong>N°</strong></th>
                            <th align="center" bgcolor="#3498DB" width="40"><strong>NUMERO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="70"><strong>CODIGO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="250"><strong>ARTICULO</strong></th>
                            <th align="center" bgcolor="#3498DB" width="100"><strong>CANTIDAD</strong></th>
                            <th align="center" bgcolor="#3498DB" width="100"><strong>COSTO UNIT.</strong></th>
                            <th align="center" bgcolor="#3498DB" width="70"><strong>F. INGRESO</strong></th>

                            <th align="center" bgcolor="#3498DB"><strong>F. VENCIMIENTO</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>TIPO ING.</strong></th>
                            <th align="center" bgcolor="#3498DB" width="70"><strong>N. REMISION</strong></th>
                        </tr> ';
		$nro = 0;
		foreach ($reg as $key => $r) {
			$data = $r->carr_ing_data;
			$array = json_decode($data);
			foreach ($array as $key => $dat) {
				$nro = $nro + 1;
				$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">' . $nro . '</td>
                                    <td align="center">' . $dat->carr_id_insumo . '</td>
                                    <td align="center">' . $dat->carr_cod_insumo . '</td>
                                    <td align="center">' . $dat->carr_insumo . '</td>
                                    <td align="center">' . $dat->carr_cantidad . '</td>
                                    <td align="center">' . $dat->carr_costo . '</td>
                                    <td align="center">' . $r->carr_ing_fech . '</td>

                                    <td align="center">' . $dat->carr_fech_venc . '</td>
                                    <td align="center">' . $r->dat_nom . '</td>
                                    <td align="center">' . $r->carr_ing_rem . '</td>
                                  </tr>';
			}
		}

		// $html = $html . '
		//           <br><br><br><br><br><br>
		//           _________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_________________________
		//           <br>
		//           <label>'. $per['prs_nombres'].' '.$per['prs_paterno'].' '.$per['prs_materno'].'</label>
		//           <br>
		//           <label>Responsable de Almacen</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Responsable Administrativo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Jefe de Planta</label>
		//       ';

		$htmltable = $html . '</table>';
		$pdf->writeHTML($htmltable, true, 0, true, 0);

		// reset pointer to the last page

		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('Reporte_Ingreso_Almacen.pdf', 'I');

	}

	public function rptIngresoGeneral() {
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
		//$usr = Usuario::setNombreRegistro();
		//$per=Collect($usr);
		//$id =  Auth::user()->usr_id;
		$id_usuario = Auth::user()->usr_id;
		$usr = Usuario::join('public._bp_personas as persona', 'public._bp_usuarios.usr_prs_id', '=', 'persona.prs_id')
			->where('usr_id', $id_usuario)->first();
		$per = Collect($usr);
		$id = Auth::user()->usr_id;

		//  echo $id;
		$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
			->where('usr_id', $id)->first();

		$id = Auth::user()->usr_id;
		$reg = CarroIngreso::join('insumo.dato', 'carro_ingreso.carr_ing_tiping', '=', 'insumo.dato.dat_id')
			->join('public._bp_planta', 'insumo.carro_ingreso.carr_ing_id_planta', '=', 'public._bp_planta.id_planta')->orderby('carr_ing_id', 'DESC')->get();
		//echo $reg;
		$html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><br><br><img src="img/logopeqe.png" width="140" height="65"></th>
                             <th  width="830"><h3 align="center"><br>REPORTE GENERAL DE INGRESO DE INSUMOS<br>Fecha de Emision: ' . date('d/m/Y') . '</h3></th>
                        </tr>
                    </table>
                    <br><br>
                        <label><strong>GENERADO POR:</strong> ' . $per['prs_nombres'] . ' ' . $per['prs_paterno'] . ' ' . $per['prs_materno'] . '</label>
                        <br><br>
                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB" width="180"><strong>Planta</strong></th>
                            <th align="center" bgcolor="#3498DB" width="100"><strong>Codigo</strong></th>
                            <th align="center" bgcolor="#3498DB" width="280"><strong>Articulo</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>Cantidad</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>Costo U.</strong></th>
                            <th align="center" bgcolor="#3498DB" width="120"><strong>Costo Total</strong></th>
                        </tr> ';
		$nro = 0;
		$total_cantidad = 0;
		$total_costo_uni = 0;
		$total_costo_total = 0;
		foreach ($reg as $key => $r) {
			$data = $r->carr_ing_data;
			$array = json_decode($data);
			foreach ($array as $key => $dat) {
				$nro = $nro + 1;
				$costo_total = $dat->carr_cantidad * $dat->carr_costo;
				$total_cantidad = $total_cantidad + $dat->carr_cantidad;
				$total_costo_uni = $total_costo_uni + $dat->carr_costo;
				$total_costo_total = $total_costo_total + $costo_total;
				$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">' . $nro . '</td>
                                    <td align="center">' . $r->nombre_planta . '</td>
                                    <td align="center">' . $dat->carr_cod_insumo . '</td>
                                    <td align="center">' . $dat->carr_insumo . '</td>
                                    <td align="center">' . $dat->carr_cantidad . '</td>
                                    <td align="center">' . number_format($dat->carr_costo, 2, '.', ',') . '</td>
                                    <td align="center">' . number_format($costo_total, 2, '.', ',') . '</td>
                                  </tr>';
			}
		}
		$html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center" colspan="4"><strong>TOTAL</strong></td>
                                    <td align="center"><strong>' . $total_cantidad . '</strong></td>
                                    <td align="center"><strong>' . number_format($total_costo_uni, 2, '.', ',') . '</strong></td>
                                    <td align="center"><strong>' . number_format($total_costo_total, 2, '.', ',') . '</strong></td>
                                  </tr>';

		$htmltable = $html . '</table>';
		$pdf->writeHTML($htmltable, true, 0, true, 0);

		// reset pointer to the last page

		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('Reporte_Ingreso_Almacen.pdf', 'I');
	}

	public function rptInventarioPlanta() {
		\Excel::create('RptInventarioGeneral', function ($excel) {
			$excel->sheet('Excel sheet', function ($sheet) {
				//otra opción -> $products = Product::select('name')->get();
				$usr = Usuario::setNombreRegistro();
				$per = Collect($usr);
				$id = Auth::user()->usr_id;
				$planta = Usuario::join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')->where('usr_id', $id)->first();

				$idplant = $planta['id_planta'];
				// $sheet->mergeCells('A1:F1');
				// $sheet->row(1, [
				//     'INVENTARIO PLANTA  '.$planta['nombre_planta'].' INSUMOS'
				//  ]);
				// $sheet->mergeCells('A2:F2');
				// $sheet->row(2, [
				//     'AL:  '.date('d/m/Y').' '
				//  ]);

				// $sheet->mergeCells('A3:F3');
				// $sheet->row(3, [
				//     'Generado por:  '.$per['prs_nombres'].' '.$per['prs_paterno'].' '.$per['prs_materno'].''
				// ]);

				$reg = CarroIngreso::join('insumo.dato', 'carro_ingreso.carr_ing_tiping', '=', 'insumo.dato.dat_id')
					->where('carr_ing_id_planta', $idplant)->orderby('carr_ing_id', 'DESC')->get();
				$sheet->fromArray($reg);
				// $sheet->row(4, [
				//     'Valor Ufv', 'Fecha'
				//  ]);

				$sheet->setOrientation('landscape');
			});
		})->export('xlsx');
	}
	//INGRESOS POR TRASPASOS
	public function ingresoTraspaso() {
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')->select('planta.id_planta')->where('usr_id', '=', Auth::user()->usr_id)->first();
		$ingreso_traspaso = OrdenProduccion::where('orprod_planta_id', $planta->id_planta)->where('orprod_tiporprod_id', 3)->where('orprod_estado_orp', 'D')->get();
		//dd($ingreso_traspaso);
		return view('backend.administracion.insumo.insumo_registro.ingreso_traspaso.index');
	}

	public function ingresoTraspasoCreate() {
		$planta = Usuario::join('public._bp_planta as planta', 'public._bp_usuarios.usr_planta_id', '=', 'planta.id_planta')
			->select('planta.id_planta')
			->where('usr_id', '=', Auth::user()->usr_id)->first();
		//$ingreso_traspaso = OrdenProduccion::where('orprod_planta_id',$planta->id_planta)->where('orprod_tiporprod_id',3)->where('orprod_estado_orp','D')->get();
		$ingreso_traspaso = Ingreso::where('ing_id_tiping', 4)->where('ing_planta_id', $planta->id_planta)->get();
		return Datatables::of($ingreso_traspaso)->addColumn('acciones', function ($ingreso_traspaso) {
			if ($ingreso_traspaso->ing_estado == 'B') {
				return '<div class="text-center"><a href="verIngresoTraspaso/' . $ingreso_traspaso->ing_id . '" class="btn btn-md btn-success"><i class="fa fa-eye"></i></a></div>';
			} else {
				return '<div class="text-center"><a href="ReporteAlmacen/' . $ingreso_traspaso->ing_id . '" target="_blank" class="btn btn-md btn-primary"><i class="fa fa-file-o"></i></a></div>';
			}
		})->addColumn('planta_traspaso', function ($planta_traspaso) {
			return $this->traePlanta($planta_traspaso->ing_planta_traspaso);
		})
			->addColumn('planta_recepcion', function ($planta_recepcion) {
				return $this->traePlanta($planta_recepcion->ing_planta_id);
			})
			->editColumn('id', 'ID: {{$ing_id}}')
			->make(true);
	}
	function traePlanta($id_planta) {
		$planta = \DB::table('public._bp_planta')->where('id_planta', '=', $id_planta)->first();
		return $planta->nombre_planta;
	}
	public function mostrarIngresoTraspaso($id) {
		$ingreso = Ingreso::where('ing_id', $id)->first();
		$detalle_ingreso = DetalleIngreso::join('insumo.insumo as ins', 'insumo.detalle_ingreso.deting_ins_id', '=', 'ins.ins_id')
			->leftjoin('insumo.unidad_medida as umed', 'ins.ins_id_uni', '=', 'umed.umed_id')
			->where('deting_ing_id', $ingreso->ing_id)->get();
		//dd($ingreso);
		return view('backend.administracion.insumo.insumo_registro.ingreso_traspaso.partials.formIngresoTraspaso', compact('ingreso', 'detalle_ingreso'));
	}
	public function guardarIngresotraspaso(Request $request) {
		//dd($request);
		$ins_id = $request['id_insumo_tras'];
		$cantidad_ins = $request['cantidad_tras'];
		$costo_ins = $request['costo_tras'];
		$deting_id = $request['deting_id'];
		//dd(sizeof($ins_id));
		for ($i = 0; $i < sizeof($ins_id); $i++) {
			if ($costo_ins[$i] != null) {
				$ins_datos[] = array("deting_id" => $deting_id[$i], "id_insumo_tras" => $ins_id[$i], "cantidad" => $cantidad_ins[$i], "costo" => $costo_ins[$i]);
			}
		}
		//dd($ins_datos);
		$ingreso_tras = Ingreso::where('ing_id', $request['id_ingreso'])->first();
		$ingreso_tras->ing_estado = 'A';
		$ingreso_tras->save();
		foreach ($ins_datos as $det) {
			$det_ingreso = DetalleIngreso::find($det['deting_id']);
			$det_ingreso->deting_costo = $det['costo'];
			$det_ingreso->save();
			Stock::create([
				'stock_ins_id' => $det['id_insumo_tras'],
				'stock_deting_id' => $det_ingreso->deting_id,
				'stock_cantidad' => $det['cantidad'],
				'stock_costo' => $det['costo'],
				'stock_fecha_venc' => '2019-08-14',
				'stock_planta_id' => $ingreso_tras->ing_planta_id,
			]);
			InsumoHistorial::create([
				'inshis_ins_id' => $det['id_insumo_tras'],
				'inshis_planta_id' => $ingreso_tras->ing_planta_id,
				'inshis_tipo' => 'Entrada',
				'inshis_deting_id' => $det_ingreso->deting_id,
				'inshis_cantidad' => $det['cantidad'],
			]);
		}
		//dd($ingreso_tras);
		return redirect('IngresoTraspaso')->with('success', 'Registro creado satisfactoriamente');
	}

}
