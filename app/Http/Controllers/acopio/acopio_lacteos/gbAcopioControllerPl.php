<?php
namespace siga\Http\Controllers\acopio\acopio_lacteos;

use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Persona;
use siga\Modelo\admin\Usuario;
//use gamlp\Modelo\admin\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\EstadoCivil;
use siga\Modelo\acopio\acopio_lacteos\Acopio;
use siga\Modelo\acopio\acopio_lacteos\Recepcionista;
use siga\Modelo\acopio\acopio_lacteos\AcopioGR;
use siga\Modelo\acopio\acopio_lacteos\AcopioCA;
use siga\Modelo\acopio\acopio_lacteos\ProveedorL;
use Illuminate\Support\Facades\Storage;
use siga\Modelo\acopio\acopio_lacteos\Precio;
use siga\Modelo\acopio\acopio_lacteos\ModRecepcion;
use siga\Modelo\acopio\acopio_lacteos\Modulo;
use Auth;
use PDF;
use Fpdf;
use TCPDF;

class gbAcopioControllerPl extends Controller
{
    public function index()
    {
        // $fecha=date('d/m/Y');
        $recepcionista=AcopioGR::orderBy('detlac_id_rec','DESC')->paginate(10);
    
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $plan = $planta['id_planta'];
        $usuario = Persona::join('public._bp_usuarios as usr', 'public._bp_personas.prs_id','=','usr.usr_prs_id')
                          ->where('usr_id','=',Auth::user()->usr_id)
                          ->where('usr_planta_id','=',$plan)
                          ->first();

        $modulo = Modulo::join('public._bp_planta as planta','acopio.modulo.modulo_id_planta','=','planta.id_planta')
                        ->leftjoin('acopio.acopio as aco','acopio.modulo.modulo_id','=','aco.aco_id_modulo')    
                        ->where('modulo_id_planta','=',$planta->id_planta)
                        ->get();
        //dd($modulo); 
        return view('backend.administracion.acopio.acopio_lacteos.acopioPl.index',compact('recepcionista', 'usuario'));
    }

    public function show($id)
    {
       
    }

   public function create()
    {
        $recepcionista = AcopioGR::getListar();
        //$cert = Acopio::getListar();
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();

         return Datatables::of($recepcionista)->addColumn('acciones', function ($recepcionista) {
            if($recepcionista->detlac_acept_aco==0)
            {
             return '<button value="'.$recepcionista->detlac_id.'" class="btn btn-success btn-sm" style="width:115px"  data-toggle="modal" data-target="#myCreatePl" onClick="Mostrardat(this);">REGISTRAR LAB</button>';
            }
            elseif($recepcionista->detlac_acept_aco==1)
                { 
                    return '<a class="btn btn-info btn-sm" style="width:100px">ACEPTADO</a> <button value="'.$recepcionista->detlac_id.'" class="btn btn-primary btn-sm glyphicon glyphicon-eye-open" data-target="#myVerCreate" style="background:#ff9d56; width:80px" data-toggle="modal" onclick="MostrardatosLab(this);" > VER</button>'; 
                }
            elseif($recepcionista->detlac_acept_aco==2)
                { 
                    return '<a class="btn btn-danger btn-sm" style="width:100px">RECHAZADO</a>  <button value="'.$recepcionista->detlac_id.'" class="btn btn-primary btn-sm glyphicon glyphicon-eye-open" style="background:#ff9d56; width:80px" data-target="#myVerCreate" onclick="MostrardatosLab(this);"> VER</button>'; 
                }
            })
            //->editColumn('id', 'ID: {{$modulo_id}}')->
            ->addColumn('nombreCompleto', function ($nombres) {
                return $nombres->prs_nombres.' '.$nombres->prs_paterno.' '.$nombres->prs_materno;
            })
            //editColumn('id', 'ID: {{$id_planta}}')->
            ->addColumn('planta', function ($planta) {
                return $planta->nombre_planta;
            })
        ->make(true);
    }

    public function listaAcopioModulos($id)
    {
        $data  = Recepcionista::combo();
        $fecha_id = $id;
        $recep_fecha =ModRecepcion::where('recmod_fecha',$id)->first();
       //echo $recep_fecha;
        
        return view('backend.administracion.acopio.acopio_lacteos.acopioPl.listadolab',compact('fecha_id','recep_fecha', 'data'));
    }

    public function listaAcopioMod($id)
    {

        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $idplanta=$planta['id_planta'];

        $modulo = \DB::table('acopio.recepcion_modulo')
               ->join('acopio.modulo', 'acopio.recepcion_modulo.recmod_id_mod', '=', 'modulo_id')
               ->join('public._bp_planta', 'acopio.modulo.modulo_id_planta', '=', 'public._bp_planta.id_planta')
               //->where('recmod_id_usr','=',Auth::user()->usr_id)
               ->where('recmod_fecha',$id)
               ->where('recmod_id_planta',$idplanta)
               ->get();
       
        return Datatables::of($modulo)->addColumn('acciones', function ($modulo) {
            if($modulo->recmod_estado_recep==null)
             {
            return '<button value="' . $modulo->recmod_id . '" class="btn btn-primary btn-sm" style="background:#F5B041; width:115px"  data-toggle="modal" data-target="#myCreatePl" onClick="Mostrardat(this);">REGISTRAR LAB</button> <a class="btn btn-primary btn-sm" style="background:#5499C7; width:80px"  href="/vistaAcopioPlDetalle/' . $modulo->recmod_fecha . '">LISTAR</a>';
            }
             elseif($modulo->recmod_estado_recep==1)
                { 
                    return '<a class="btn btn-success btn-sm" style="width:110px">ACEPTADO</a> <a class="btn btn-primary btn-sm" style="width:80px"  href="/vistaAcopioPlDetalle/' . $modulo->recmod_fecha . '" data-toggle="modal" >LISTAR</a>'; 
                }
            elseif($modulo->recmod_estado_recep==2)
                { 
                    return '<a class="btn btn-danger btn-sm" style="width:110px">RECHAZADO</a>  <a class="btn btn-primary btn-sm" style="background:#5499C7; width:80px"  href="/vistaAcopioPlDetalle/' . $modulo->recmod_fecha. '">LISTAR</a>'; 
                }
        })
        ->editColumn('id', 'ID: {{$modulo_id}}')->
            addColumn('nombreCompleto', function ($nombres) {
                return $nombres->modulo_nombre.' '.$nombres->modulo_paterno.' '.$nombres->modulo_materno;
        })
        ->editColumn('id', 'ID: {{$id_planta}}')->
            addColumn('planta', function ($planta) {
                return $planta->nombre_planta;
        })
            ->make(true);
    }

    public function vistaAcopioPlDetalle($id)
    {
        $idfecha = $id;
        return view('backend.administracion.acopio.acopio_lacteos.acopioPl.listadolabdetalle', compact('idfecha'));
    }

    public function lstAcopioPlDetalle($id)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $idplanta=$planta['id_planta'];

        $detalle = Acopio::where('aco_id', $id) 
                         ->where('aco_id_linea', 2)
                         ->where('aco_id_planta', $idplanta)
                         ->get();
       
        return Datatables::of($detalle)->make(true);
    }
                               
    //listado y creacion de datos en tabla acopio analisis laboratorio
    public function store(Request $request)
    {
        $this->validate(request(), [ 
            'certificacion_aceptacion' => 'required|min:1',
            'prueba_alcohol' => 'required|min:1',  
            'condiciones_higiene' => 'required|min:1', 
            'tram' => 'required', 
            'temperatura' => 'required',
            'acidez' => 'required',
            'ph' => 'required',
            'sng' => 'required',
            'densidad' => 'required',   
            'materia_grasa' => 'required', 
            'prueba_alcohol' => 'required|min:1', 
            'prueba_antibiotico' => 'required|min:1', 
            'aspecto' => 'required|min:1', 
            'color' => 'required|min:1', 
            'olor' => 'required|min:1', 
            'sabor' => 'required|min:1', 
        ]);     

        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();  
        $plant=$planta['id_planta'];   

        $costo = Precio::join('public._bp_planta as planta', 'acopio.precio.precio_id_planta', '=', 'planta.id_planta')
                        ->where('precio_id_planta', $plant)->first();
        $cos=$costo['precio_costo'];
        $fecha1=date('d/m/Y');
        Acopio::create([
           // 'aco_id_prov'       => '5',
            'aco_resp_calidad'  => Auth::user()->usr_id,
            'aco_obs'           => $request['lab_obs'],
            'aco_id_tipo_cas'   => '1',
            'aco_cantidad'      => $request['lab_cant'],
            'aco_centro'        =>'no tiene',
            'aco_num_rec'       => '0',
            'aco_cos_un'        => $cos,
            'aco_cos_total'     => '0',
            'aco_numaco'        => '0',
            'aco_unidad'        => '1',
            'aco_peso_neto'     => '0',
            'aco_fecha_acop'    => $fecha1,
            'aco_id_proc'       => '1',      
            'aco_id_comunidad'  => '1', 
            //'aco_tipo_env'      => '1', 
            'aco_con_hig'       => $request['condiciones_higiene'],
            'aco_tram'          => $request['tram'],
            'aco_fecha_rec'     => $fecha1, 
            'aco_id_destino'    => '1', 
            'aco_id_prom'       =>'1', 
            'aco_id_linea'      => '2', 
            'aco_id_usr'        =>  Auth::user()->usr_id, 
            'aco_fecha_reg'     => $fecha1, 
            'aco_estado'        => 'A', 
            'aco_lac_tem'       => $request['temperatura'], 
            'aco_lac_aci'       => $request['acidez'], 
            'aco_lac_ph'        => $request['ph'], 
            'aco_lac_sng'       => $request['sng'], 
            'aco_lac_den'       => $request['densidad'], 
            'aco_lac_mgra'      => $request['materia_grasa'], 
            'aco_lac_palc'      => $request['prueba_alcohol'], 
            'aco_lac_pant'      => $request['prueba_entibiotico'], 
            'aco_lac_asp'       => $request['aspecto'], 
            'aco_lac_col'       => $request['color'], 
            'aco_lac_olo'       => $request['olor'], 
            'aco_lac_sab'       => $request['sabor'], 
            'aco_id_comp'       => $request['lab_id_rec'],
            'aco_cert'          => $request['certificacion_aceptacion'],
            'aco_cant_rep'      => $request['cantidad_recep'],
            'aco_detlac_id'     => $request['lab_detlac_id'],
            'aco_id_planta'     => $plant,
            'aco_id_modulo'     => $request['id_modulo'],
            'aco_id_recep'      => $request['idrec']
        ]);

        $estado = AcopioGR::where('detlac_id','=',$request['id_modulo'])->first();
        $estado->detlac_acept_aco = $request['certificacion_aceptacion'];
        $estado->save();
        return response()->json(['Mensaje' => 'El acopio no fueron registrado']);
    }

    //listado acopio por proveedor
  
      public function edit($id)
    {
         $acopio = AcopioGR::setBuscar($id);
        return response()->json($acopio);
        //  $recepcionista = ModRecepcion::join('acopio.modulo as mod','acopio.recepcion_modulo.recmod_id_mod','=','mod.modulo_id')->where('recmod_id','=',$id)->first();
       
        //  $array_datos = array('cantidad_total' => $recepcionista->recmod_cant_recep, 'recepcionista' => $recepcionista->modulo_nombre.' '.$recepcionista->modulo_paterno.' '.$recepcionista->modulo_materno,'id_modulo' => $id); 
        // return response()->json($array_datos);

    }
    public function edit2()
    {
    $ids=Auth::user()->usr_id;
    //$usuario = Usuario::setBuscarLac($ids);
      //  return response()->json($usuario);
    $usuario = Usuario::select('usr_id', 'usr_usuario')
            ->where('usr_id', $ids)
            ->get();
            return $usuario;
    }

     public function editver($id)
    {
        $acopio = Acopio::setBuscar($id);
        return response()->json($acopio);
    }
   
    public function update(Request $request, $id)
    {   
    }

    public function destroy($id)
    {   
    }

    //boleta impresion diaria
    Public function boletAcopioPlanta()
    {
        
        $pdf = app('FPDF');

        $pdf->AddPage('L', 'A4');
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln(2);
        $pdf->Cell(275, 10, 'EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS ', 0, 0, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(275, 10, 'ACOPIOS LACTEOS INGRESO PLANTA ', 0, 0, 'C');
        $pdf->Ln(4);
        $pdf->Cell(275, 12, 'Al', 0, 0, 'C');
       
        $a = 20;
        $b = 60;
        $c = 30;
        $d = 35;
        $e = 40;
        $f = 90;
        $g = 15;
        $h = 20;
        $i = 20;
        $j = 20;
        $k = 15;
        $pdf->Ln(4);

        $pdf->Ln(6);
        $pdf->SetFillColor(153, 255, 100);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell($a, 8, '', 1, 0, 'C');
        $pdf->Cell($b, 8, '', 1, 0, 'C');
        $pdf->Cell($c, 8, '', 1, 0, 'C');
        $pdf->Cell($d, 8, '', 1, 0, 'C');
        $pdf->Cell($e, 8, '', 1, 0, 'C');
        $pdf->Cell($f, 8, '', 1, 0, 'C');
       
        $pdf->Ln(-2);
        $pdf->Cell($a, 10, utf8_decode('N°'), 0, 0, 'C');
        $pdf->Cell($b, 10, nl2br('Nombre Completo'), 0, 0, 'C');
        $pdf->Cell($c, 10, utf8_decode('fecha'), 0, 0, 'C');
        $pdf->Cell($d, 10, utf8_decode('Cantidad Proveedor'), 0, 0, 'C');
        $pdf->Cell($e, 10, 'Cantidad de leche TOT.', 0, 0, 'C');
        $pdf->Cell($f, 10, 'Observaciones', 0, 0, 'C');

        $recepcionista = AcopioGR::getListar();
        foreach ($recepcionista as $rep) {
            $pdf->Cell($a, 5, $rep->detlac_id, 1, 0, 'R');
            $pdf->Cell($b, 10, nl2br($rep->detlac_fecha), 0, 0, 'C');
            $pdf->Cell($c, 10, utf8_decode('fecha'), 0, 0, 'C');
            $pdf->Cell($d, 10, utf8_decode('Cantidad Proveedor'), 0, 0, 'C');
            $pdf->Cell($e, 10, 'Cantidad de leche TOT.', 0, 0, 'C');
            $pdf->Cell($f, 10, 'Observaciones', 0, 0, 'C');
        }

        $pdf->Output();
        exit;
     }

     public function boletaAcopiodiaControlCalidad()
     {
        // return "Reporte de Control de CAlidad";
        $fecha=date('Y/m/d');
        // $ids=Auth::user()->usr_id;
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 

        $usr = Auth::user()->usr_id;

        $acopioLact = \DB::table('acopio.acopio')
               ->join('public._bp_usuarios', 'acopio.acopio.aco_id_usr', '=', 'usr_id')
               ->join('public._bp_personas', '_bp_usuarios.usr_prs_id', '=', 'public._bp_personas.prs_id')
               ->where('aco_fecha_acop','=',$fecha)
               ->where('aco_id_usr',$usr)
               ->get();
        $asig=Collect($acopioLact);
     //    echo $asig;
       

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->AddPage('L', 'Carta');
        $pdf->Image('img/logopeqe.png', 15, 11, 35);
        $pdf->SetFont('helvetica','B',12);

        $pdf->SetXY(90, 10);
        $pdf->Cell(90,10,utf8_decode( 'EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS'),0,0,'C');
        $pdf->SetXY(90, 10);
        $pdf->Cell(90,20,utf8_decode( 'REGISTRO RECEPCION DE LECHE'),0,0,'C');
        $pdf->SetXY(90, 10);
        $pdf->Cell(90,30,utf8_decode( 'CENTRO DE ACOPIO'),0,0,'C');
        $pdf->SetXY(200, 10);
        $pdf->Cell(105, 15, 'Al: '.date('d/m/Y').'', 0,0,'C');
        $pdf->Ln(30);
        //ENCABEZADO DE TABLA
        $pdf->SetFont('helvetica','B',8);
         // PDF::writeHTML($htmltable, true, false, true, false, '');

        //CONTENIDO DE LA TABLA

        // $acopioLact = AcopioCA::imprimir_acopioCA($fecha);
      //  $acopioLact = Acopio::join('acopio.modulo as mod','acopio.acopio.aco_id_modulo','=','mod.modulo_id')
                          //  ->join('public._bp_planta as planta','mod.modulo_id_planta','=','planta.id_planta')
                           // ->where('modulo_id_planta','=',$planta->id_planta)
                           // ->where('acopio.aco_fecha_acop','=',$fecha)
                          //  ->orderBy('aco_id','DESC')->get();
        // dd($acopioLact);
       // echo $acopioLact;
        $html   = '<table border="1">
                        <tr ALIGN=center border="1" bordercolor="#ffffff">
                        <th width="40"  bgcolor="#8b7bc8" border="1" align="center"><h4>No</h4></th>
                        <th width="205" bgcolor="#8b7bc8" border="1" align="center"><h4>RCEPCIONISTA</h4></th>                     
                        <th width="50"  bgcolor="#8b7bc8" border=1 align="center"><h4>PALC</h4></th>
                        <th width="50" bgcolor="#8b7bc8" border=1 align="center"><h4>ASPECTO</h4></th>
                        <th width="80" bgcolor="#8b7bc8" border=1 align="center"><h4>COLOR</h4></th>
                        <th width="50" bgcolor="#8b7bc8" border=1 align="center"><h4>OLOR</h4></th>
                        <th width="50" bgcolor="#8b7bc8" border=1 align="center"><h4>SABOR</h4></th>
                        <th width="150"  bgcolor="#8b7bc8" border=1 align="center"><h4>CANTIDAD LITROS</h4></th>
                    </tr>';
        $nro_mod = 0;
        $total_cantidad = 0;
       foreach ($asig as $key => $m) {
     //  foreach ($acopioLact as $m) {
         if($m->aco_lac_palc==1) { $palc="+"; } else { $palc="-";  }
         if($m->aco_lac_asp==1) { $asp="Liquido"; } else { $asp="Homogeneo";  }
         if($m->aco_lac_col==1) { $col="Blanco Opaco"; } else { $col="Blanco Cremoso";  }
         if($m->aco_lac_olo==1) { $olo="SI"; } else { $olo="NO";  }
         if($m->aco_lac_sab==1) { $sabo="Poco Dulce"; } else { $sabo="Agradable";  }
            $nro_mod = $nro_mod +1;
            $total_cantidad = $total_cantidad+$m->aco_cantidad;
            $html = $html . '<tr align="center" border=1>
                    <td align="center" border="1">' .$nro_mod. '</td>
                    <td align="center" border="1">' . $m->prs_nombres .' '.$m->prs_paterno.' '.$m->prs_materno. '</td>                 
                    <td align="center" border="1">' . $palc . '</td>
                    <td align="center" border="1">' . $asp . '</td>
                    <td align="center" border="1">' . $col . '</td>
                    <td align="center" border="1">' . $olo . '</td>
                    <td align="center" border="1">' . $sabo . '</td>
                    <td align="center" border="1">' . number_format($m->aco_cantidad,2,'.',',') . '</td>                  
                  </tr>';
        }
        $html = $html . '<tr>
                            <td align="center" colspan="7">TOTALES</td>
                            <td align="center">'.number_format($total_cantidad,2,'.',',').'</td>
                        </tr>';
        $htmltable = $html . '</table>';
        
        $pdf->writeHTML($htmltable, true, 0, true, 0);



            $pdf->Output();


        //});
        PDF::SetTitle('Hello World');
        PDF::AddPage();
        PDF::SetFont('helvetica', '', 10);
        //CUERPO
        $style = array(
            'border'  => false,
            'padding' => 0,
            'fgcolor' => array(128, 0, 0),
            'bgcolor' => false,
        );
     //   PDF::writeHTML($html, true, false, true, false, '');

        PDF::Output('repacopiolact.pdf');
     }

}
