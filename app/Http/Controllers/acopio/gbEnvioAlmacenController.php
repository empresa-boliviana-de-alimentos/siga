<?php

namespace siga\Http\Controllers\acopio;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\Envio_Almacen;
use siga\Modelo\acopio\acopio_almendra\Acopio;
// use siga\Modelo\acopio\acopio_miel\Acopio;
use siga\Modelo\admin\Usuario;
use Yajra\Datatables\Datatables;
use Auth;
use DB;
use PDF;
use TCPDF;

class gbEnvioAlmacenController extends Controller
{
    public function index()
   	{
   		// $planta = DB::table('public._bp_planta')->get();
   		$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta', 'planta.nombre_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
   		$enval = Envio_Almacen::getListar();
   		$acopio = Acopio::select(DB::raw('SUM(aco_cantidad) as cantidad_total'),DB::raw('SUM(aco_cos_total) as costo_total'))
   						->where('aco_id_linea','=',1)
   						->where('aco_estado','=','A')
   						->where('aco_id_usr','=',Auth::user()->usr_id)->first();
   		$cantidad_acopio = number_format($acopio->cantidad_total*23,2,'.','');
   		$costo_total_acopio = number_format($acopio->costo_total,2,'.','');        
   		return view('backend.administracion.acopio.acopio_almendra.gbEnvioAlmacen.index', compact('enval','planta','cantidad_acopio','costo_total_acopio'));
   	}

    public function create()
    {
        $enval = Envio_Almacen::getListar();
        return Datatables::of($enval)->addColumn('acciones', function ($enval) {
            return '<div class="text-center"><a href="boletaEnvioAlm/' . $enval->enval_id . '" class="btn btn-md btn-primary" target="_blank">Boleta <i class="fa fa-file"></i></a></div>';
        })
            ->editColumn('id', 'ID: {{$enval_id}}')            
            ->make(true);
    }
    public function store(Request $request)
    {
    	// $this->validate(request(), [
     //        'planta_destino'    => 'required|min:1',
     //    ]);
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $cod_nro = Envio_Almacen::where('enval_id_planta','=',$planta->id_planta)->select(DB::raw('MAX(enval_nro_env) as codigo_nro_env'))->first();
        if ($cod_nro['codigo_nro_env'] == NULL) {
        	$nro_cod = 1;
        }
        $nro_cod = $cod_nro['codigo_nro_env'] + 1;
    	$envalAlm = Envio_Almacen::create([
            'enval_cant_total'  => $request['enval_cant_total'],
            'enval_cost_total'  => $request['enval_cost_total'],
            'enval_usr_id'      => Auth::user()->usr_id,
       		'enval_registrado'	=> $request['enval_registro'],
            'enval_estado'      => 'A',
            'enval_id_planta'	=> $planta->id_planta,
            'enval_nro_env'		=> $nro_cod,
            'enval_id_linea'    => 1,
        ]);
        return response()->json($envalAlm);
    }

    public function boletaEnvioAlm($id)
    {
    	 $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('EBA');
        $pdf->SetSubject('ACOPIO-INSUMOS');
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
        
    	$reg = Envio_Almacen::where('enval_id_planta','=',$planta->id_planta)
    						->where('enval_usr_id','=',$id_user)->where('enval_id','=',$id)->first();
        
        // dd($reg);
        $fechaEntera = strtotime($reg['enval_registrado']);
        $anio = date("Y", $fechaEntera);
        $mes = date("m", $fechaEntera);
        $dia = date("d", $fechaEntera);
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="/img/logosedem.jpg" width="160" height="65"></th>
                             <th  width="370"><h3 align="center"><br>ALMACEN '.$planta['nombre_planta'].'<br>NOTA DE ENVIO</h3></th>
                             <th  width="150"><h3 align="center"><br>Fecha: '.$dia.'-'.$mes.'-'.$anio.'<br>Codigo No: '.$reg['enval_nro_env'].'</h3></th>
                        </tr>
                    </table>
                    <br><br><br>
                        <label><strong>Comprador:</strong> '.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <br><br>
                        <label><strong>Dependencia:</strong> '.$planta['nombre_planta'].'</label>
                        <br><br>
                        
                        
                    <br><br><br>

                    <table border="1" cellspacing="0">
                     
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB" width="305"><strong>CANTIDAD TOTAL</strong></th>
                            <th align="center" bgcolor="#3498DB" width="305"><strong>PRECIO TOTAL</strong></th>
                            
                        </tr> ';
                     
                        $tot1=0;
                   
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">1</td>
                                    <td align="center">'.$reg['enval_cant_total'].'</td>
                                    <td align="center">'.$reg['enval_cost_total'].'</td>
                                    
                                  </tr>';  
                        
                       // echo $tot1;   
                     $html = $html . '</table>

                     <br><br>
                            
                     <br><br><br><br><br><br>';

                      $html = $html . '
                                <table>
                            <tr>
                                <td align="left">Enviado por: __________________________________</td>
                                
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
        $pdf->Output('boletaEnvioAlm-'.$reg['enval_id'].'.pdf', 'I');
    }

    public function listarEnvioMielAlm()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta', 'planta.nombre_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $envalmiel = Envio_Almacen::getListar();
        $acopioMiel = Acopio::join('acopio.propiedades_miel as promiel','acopio.acopio.aco_id_prom','=','promiel.prom_id')
                        ->select(DB::raw('SUM(prom_peso_neto) as cantidad_total_pesobruto'),DB::raw('SUM(prom_total) as costo_total'))
                        ->where('aco_id_linea','=',3)
                        ->where('aco_estado','=','A')
                        ->where('aco_estado_env','=',0)
                        ->where('aco_id_usr','=',Auth::user()->usr_id)->first();
        $cantidad_acopio_miel = $acopioMiel->cantidad_total_pesobruto;
        $costo_total_miel = $acopioMiel->costo_total;
        return view('backend.administracion.acopio.acopio_miel.envio_almacen.index', compact('envalmiel','planta','cantidad_acopio_miel','costo_total_miel'));
    }

    public function createEnvMiel()
    {
        $envalmiel = Envio_Almacen::getListarMiel();

        return Datatables::of($envalmiel)->addColumn('acciones', function ($envalmiel) {
            return '<div class="text-center"><a href="boletaEnvioMielAlm/' . $envalmiel->enval_id . '" class="btn btn-md btn-primary" target="_blank">Boleta <i class="fa fa-file"></i></a></div>';
        })
            ->editColumn('id', 'ID: {{$enval_id}}')            
            ->make(true); 
    }

    public function registroEnvioAlmMiel(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $cod_nro = Envio_Almacen::where('enval_id_planta','=',$planta->id_planta)->select(DB::raw('MAX(enval_nro_env) as codigo_nro_env'))->first();
        if ($cod_nro['codigo_nro_env'] == NULL) {
            $nro_cod = 1;
        }
        $nro_cod = $cod_nro['codigo_nro_env'] + 1;
        $envalAlm = Envio_Almacen::create([
            'enval_cant_total'  => $request['enval_cant_total'],
            'enval_cost_total'  => $request['enval_cost_total'],
            'enval_usr_id'      => Auth::user()->usr_id,
            'enval_registrado'  => $request['enval_registro'],
            'enval_estado'      => 'A',
            'enval_id_planta'   => $planta->id_planta,
            'enval_nro_env'     => $nro_cod,
            'enval_id_linea'    => 3,
        ]);
        DB::table('acopio.acopio')
                ->where('aco_id_linea','=',3)
                ->where('aco_estado','=','A')
                ->where('aco_id_usr','=',Auth::user()->usr_id)->update(['aco_estado_env'=>1]);
        return response()->json($envalAlm);
    }

    public function boletaEnvioMielAlm($id)
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('EBA');
        $pdf->SetSubject('ACOPIO-INSUMOS');
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
        
        $reg = Envio_Almacen::where('enval_id_planta','=',$planta->id_planta)
                            ->where('enval_usr_id','=',$id_user)->where('enval_id','=',$id)->first();
        
        // dd($reg);
        $fechaEntera = strtotime($reg['enval_registrado']);
        $anio = date("Y", $fechaEntera);
        $mes = date("m", $fechaEntera);
        $dia = date("d", $fechaEntera);
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="150"><img src="/img/logosedem.jpg" width="160" height="65"></th>
                             <th  width="370"><h3 align="center"><br>ALMACEN '.$planta['nombre_planta'].'<br>NOTA DE ENVIO</h3></th>
                             <th  width="150"><h3 align="center"><br>Fecha: '.$dia.'-'.$mes.'-'.$anio.'<br>Codigo No: '.$reg['enval_nro_env'].'</h3></th>
                        </tr>
                    </table>
                    <br><br><br>
                        <label><strong>Comprador:</strong> '.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <br><br>
                        <label><strong>Dependencia:</strong> '.$planta['nombre_planta'].'</label>
                        <br><br>
                        
                        
                    <br><br><br>

                    <table border="1" cellspacing="0">
                     
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB" width="305"><strong>CANTIDAD TOTAL</strong></th>
                            <th align="center" bgcolor="#3498DB" width="305"><strong>PRECIO TOTAL</strong></th>
                            
                        </tr> ';
                     
                        $tot1=0;
                   
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">1</td>
                                    <td align="center">'.$reg['enval_cant_total'].'</td>
                                    <td align="center">'.$reg['enval_cost_total'].'</td>
                                    
                                  </tr>';  
                        
                       // echo $tot1;   
                     $html = $html . '</table>

                     <br><br>
                            
                     <br><br><br><br><br><br>';

                      $html = $html . '
                                <table>
                            <tr>
                                <td align="left"> Comprador: __________________________________</td>
                                
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
        $pdf->Output('boletaEnvioMielAlm-'.$reg['enval_id'].'.pdf', 'I');
    }
}
