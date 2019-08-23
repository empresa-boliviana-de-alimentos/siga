<?php

namespace siga\Http\Controllers\acopio\acopio_almendra;

use Illuminate\Http\Request;

use siga\Http\Requests;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_almendra\Solicitud;
use siga\Modelo\acopio\acopio_almendra\Asignacion;
use siga\Modelo\acopio\acopio_almendra\Municipio;
use siga\Modelo\acopio\acopio_almendra\Movimiento_Recursos;
use siga\Modelo\admin\Usuario;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Auth;
use Session;
use Carbon\Carbon;
use TCPDF;

class gbSolicitudController extends Controller
{
    public function index()
    {
        $Solicitud = Solicitud::getListar();
        $Solb = Solicitud::getListar2();
        // dd($Solb);
        $Asignacion= Asignacion::where('asig_estado', 'A');
        $dataMuni = Municipio::combo();
       //echo ($Solicitud);
        return view('backend.administracion.acopio.acopio_almendra.gbSolicitudes.index', compact('Solicitud','Asignacion','dataMuni','Solb'));
    }

   public function create()
    {   
        $idrol=Session::get('ID_ROL');
        // $Solicitud = Solicitud::getListar();
        if (Auth::user()->usr_id == 23) {
            $Solicitud = Solicitud::leftjoin('acopio.asignacion_presupuesto as asig','acopio.solicitud.sol_id', '=', 'asig.asig_id_sol')
                                  ->join('public._bp_usuarios as us','acopio.solicitud.sol_id_usr', '=', 'us.usr_id')
                               // ->join('public._bp_personas as per','public._bp_usuarios.usr_prs_id', '=', 'per.prs_id')
                                  -> select('us.usr_usuario','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto','asig.asig_estado')
                                  ->GROUPBY ('us.usr_usuario','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto','asig.asig_estado')
                                  ->where('us.usr_id','=',20)
                                  ->orWhere('us.usr_id','=',21)
                                  ->get();
        }else{
            $Solicitud = Solicitud::getListar();
        }
        $Solb = Solicitud::getListar2();
        if($idrol==3 or $idrol==1 or $idrol==9)
         {
            return Datatables::of($Solicitud)->addColumn('acciones', function ($Solicitud) {
                return '<button value="' . $Solicitud->sol_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarProveedor(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button><button value="' . $Solicitud->sol_id . '" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
            })
                ->editColumn('id', 'ID: {{$sol_id}}')->addColumn('estado', function ($Solicitud) {
                    $idrol=Session::get('ID_ROL');
                    if ($Solicitud->sol_estado == 'B' AND $idrol == 2) {
                        return '<h4 class="text-center"><span class="label label-success">ASIGNADO</span></h4>';
                    }
                    elseif ($Solicitud->sol_estado == 'A' AND $idrol == 2) {
                        return '<h4 class="text-center"><span class="label label-danger">PENDIENTE</span></h4>';
                    }

                    elseif ($idrol == 3 OR $idrol == 1){
                        if ($Solicitud->sol_estado == 'B' and $Solicitud->asig_estado == 'A') {
                               // return '<h4 class="text-center"><span class="label label-success">ASIGNADO</span></h4>';
                            return '<div class="text-center"><a href="Solicitud/boletaAsig/' . $Solicitud->sol_id . '" class="btn btn-success" target="_blank">Boleta de Asigancion <i class="fa fa-file"></i></a></div>';
                        }elseif ($Solicitud->sol_estado == 'A'){
                                return '<button type="button" value="' . $Solicitud->sol_id . '" class="btn btn-info" title="Editar Solicitud" data-target="#myUpdateSol" data-toggle="modal" onClick="MostrarRegistroAsig2(this)"><span class="glyphicon glyphicon-pencil"></span></button><button type="button" value="' . $Solicitud->sol_id . '" class="btn btn-success" title="Asignar Recursos" data-target="#myCreatePre" data-toggle="modal" onClick="MostrarRegistroAsig(this)"><span class="glyphicon glyphicon-usd"></span></button>';
                       }elseif ($Solicitud->sol_estado == 'C' or $Solicitud->asig_estado == 'B'){
                                return '<h4 class="text-center"><span class="label label-danger">ANULADO</span></h4>';
                       }
                    }
                   
                 })            ->editColumn('id', 'ID: {{$sol_id}}')
                ->addColumn('nombrecompleto', function ($nombrecompleto) {
                return $nombrecompleto->prs_nombres . ' ' . $nombrecompleto->prs_paterno.' '.$nombrecompleto->prs_materno;
            })
                ->make(true);
         }elseif($idrol==2 OR $idrol==13)
         {
            return Datatables::of($Solb)->addColumn('acciones', function ($Solb) {
                return '<button value="' . $Solb->sol_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarProveedor(this);" data-toggle="modal" data-target="#myUpdate"><i class="fa fa-pencil-square"></i></button><button value="' . $Solb->sol_id . '" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
            })
                ->editColumn('id', 'ID: {{$sol_id}}')->addColumn('estado', function ($Solb) {
                    $idrol=Session::get('ID_ROL');
                    if ($Solb->sol_estado == 'B' AND $Solb->asig_estado == 'A' AND $idrol == 2) {
                        return '<h4 class="text-center"><span class="label label-success">ASIGNADO</span></h4>';
                    }elseif($Solb->sol_estado == 'B' AND $Solb->asig_estado == 'A' AND $idrol == 13){
                        return '<h4 class="text-center"><span class="label label-success">ASIGNADO</span></h4>';
                    }elseif ($Solb->sol_estado == 'A' AND $idrol == 2) {
                        return '<div class="text-center"><a href="Solicitud/boleta/' . $Solb->sol_id . '" class="btn btn-primary" target="_blank"><i class="fa fa-file"></i></a></div>';
                    }elseif ($Solb->sol_estado == 'A' AND $idrol == 13) {
                        return '<div class="text-center"><a href="Solicitud/boleta/' . $Solb->sol_id . '" class="btn btn-primary" target="_blank"><i class="fa fa-file"></i></a></div>';
                    }elseif ($Solb->asig_estado == 'B' AND $idrol == 2){
                        return '<h4 class="text-center"><span class="label label-danger">ANULADO</span></h4>';
                    }elseif ($Solb->asig_estado == 'B' AND $idrol == 13){
                        return '<h4 class="text-center"><span class="label label-danger">ANULADO</span></h4>';
                    }

                    elseif ($idrol == 3 OR $idrol == 1){
                    return '<button type="button" value="' . $Solb->sol_id . '" class="btn btn-info" title="Editar Solicitud" data-target="#myUpdateSol" data-toggle="modal" onClick="MostrarRegistroAsig2(this)"><span class="glyphicon glyphicon-pencil"></span></button><button type="button" value="' . $Solb->sol_id . '" class="btn btn-success" title="Asignar Recursos" data-target="#myCreatePre" data-toggle="modal" onClick="MostrarRegistroAsig(this)"><span class="glyphicon glyphicon-usd"></span></button>';
                    }
                   
                 })            ->editColumn('id', 'ID: {{$sol_id}}')
                ->addColumn('nombrecompleto', function ($nombrecompleto) {
                return $nombrecompleto->prs_nombres . ' ' . $nombrecompleto->prs_paterno.' '.$nombrecompleto->prs_materno;
            })
                ->make(true);


         }

        
    }

public function store(Request $request)
    {
        $date = Carbon::now();//NUEVO
        Solicitud::create([
            'sol_detalle'         => $request['sol_detalle'],
            'sol_centr_acopio'    => $request['sol_centr_acopio'],
            'sol_id_mun'          => $request['sol_id_mun'],
            'sol_monto'           => $request['sol_monto'],
            'sol_estado'          => 'A',
            'sol_id_usr'          => Auth::user()->usr_id,
            'prov_direccion'      => "aaaa",
            'sol_fecha_reg'       => $date,  
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function update(Request $request, $id)
    {
        $date = Carbon::now();
        //$asig1 = Solicitud::getSolicitud($id);
        //$comp=$asig1['sol_id_usr'];

        $asig = Asignacion::create([
            'asig_id_sol'         => $request['asig_id_sol'],
            'asig_id_comp'        => $request['asig_id_comp'],
            'asig_monto'          => $request['asig_monto'],
            'asig_fecha'          => $request['asig_fecha'],
            'asig_obs'            => $request['asig_obs'],
            'asig_id_usr'         => Auth::user()->usr_id,
            'asig_estado'         => 'A',
            'asig_fecha_reg'      => $request['asig_fecha'],
        ]);
      $idAsig = $asig->asig_id; 
        $movsaldo = Movimiento_Recursos::where('movrec_id_usr','=',$request['asig_id_comp'])->select(DB::raw('MAX(movrec_id) as idmovrec'))->first();        
        //dd($movsaldoes->movrec_saldo);
        if ($movsaldo['idmovrec'] == null) {
            $montomovsaldo = $request['asig_monto'];
        } else{
            $movsaldoes = Movimiento_Recursos::where('movrec_id','=',$movsaldo['idmovrec'])->select('movrec_saldo')->first();
            $montomovsaldo = $request['asig_monto']+$movsaldoes->movrec_saldo;
        }
        Movimiento_Recursos::create([
            'movrec_ingreso' => $request['asig_monto'],
            'movrec_egreso'  => 0,
            'movrec_saldo'   => $montomovsaldo,
            'movrec_id_usr'  => $request['asig_id_comp'],
            'movrec_id_aco'  => 0,
            'movrec_estado'  => 'A',
            'movrec_id_asignacion' => $idAsig,
            'movrec_fecha_mov' => $date,
        ]);
	$asig1 = Solicitud::getSolicitud($id);
        $comp=$asig1['sol_id_usr'];

        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

     public function edit($id)
    {
        //dd($id);
        $solicitud = Solicitud::setBuscar($id);
        return response()->json($solicitud);
    }

     public function editSol($id)
    {
        //dd($id);
        $solicitud = Solicitud::setBuscar($id);
        return response()->json($solicitud);
       
    }

    public function updateSol(Request $request, $id)
    {
        $sol = Solicitud::setBuscar($id);
        $sol->fill($request->all());
        $sol->save();
        return response()->json($sol->toArray());
    }


public function boletaSolicitud($id)
    {  
        function numtoletras($xcifra)
        {
            $xarray = array(0 => "Cero",
                1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
                "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
                "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
                100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
            );
        //
            $xcifra = trim($xcifra);
            $xlength = strlen($xcifra);
            $xpos_punto = strpos($xcifra, ".");
            $xaux_int = $xcifra;
            $xdecimales = "00";
            if (!($xpos_punto === false)) {
                if ($xpos_punto == 0) {
                    $xcifra = "0" . $xcifra;
                    $xpos_punto = strpos($xcifra, ".");
                }
                $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
                $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
            }

            $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
            $xcadena = "";
            for ($xz = 0; $xz < 3; $xz++) {
                $xaux = substr($XAUX, $xz * 6, 6);
                $xi = 0;
                $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
                $xexit = true; // bandera para controlar el ciclo del While
                while ($xexit) {
                    if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                        break; // termina el ciclo
                    }

                    $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                    $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                    for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                        switch ($xy) {
                            case 1: // checa las centenas
                                if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                                } else {
                                    $key = (int)substr($xaux, 0, 3);
                                    if (TRUE === array_key_exists($key, $xarray)) {  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                        $xseek = $xarray[$key];
                                        $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                        if (substr($xaux, 0, 3) == 100)
                                            $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                        else
                                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                        $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                    } else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                        $key = (int)substr($xaux, 0, 1) * 100;
                                        $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    } // ENDIF ($xseek)
                                } // ENDIF (substr($xaux, 0, 3) < 100)
                                break;
                            case 2: // checa las decenas (con la misma lógica que las centenas)
                                if (substr($xaux, 1, 2) < 10) {

                                } else {
                                    $key = (int)substr($xaux, 1, 2);
                                    if (TRUE === array_key_exists($key, $xarray)) {
                                        $xseek = $xarray[$key];
                                        $xsub = subfijo($xaux);
                                        if (substr($xaux, 1, 2) == 20)
                                            $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                        else
                                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                        $xy = 3;
                                    } else {
                                        $key = (int)substr($xaux, 1, 1) * 10;
                                        $xseek = $xarray[$key];
                                        if (20 == substr($xaux, 1, 1) * 10)
                                            $xcadena = " " . $xcadena . " " . $xseek;
                                        else
                                            $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                    } // ENDIF ($xseek)
                                } // ENDIF (substr($xaux, 1, 2) < 10)
                                break;
                            case 3: // checa las unidades
                                if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                                } else {
                                    $key = (int)substr($xaux, 2, 1);
                                    $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                    $xsub = subfijo($xaux);
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                } // ENDIF (substr($xaux, 2, 1) < 1)
                                break;
                        } // END SWITCH
                    } // END FOR
                    $xi = $xi + 3;
                } // ENDDO

                if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                    $xcadena .= " DE";

                if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                    $xcadena .= " DE";

                // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
                if (trim($xaux) != "") {
                    switch ($xz) {
                        case 0:
                            if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                                $xcadena .= "UN BILLON ";
                            else
                                $xcadena .= " BILLONES ";
                            break;
                        case 1:
                            if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                                $xcadena .= "UN MILLON ";
                            else
                                $xcadena .= " MILLONES ";
                            break;
                        case 2:
                            if ($xcifra < 1) {
                                $xcadena = "CERO $xdecimales/100 Bolivianos";
                            }
                            if ($xcifra >= 1 && $xcifra < 2) {
                                $xcadena = "UN $xdecimales/100 Bolivianos ";
                            }
                            if ($xcifra >= 2) {
                                $xcadena .= " $xdecimales/100 Bolivianos "; //
                            }
                            break;
                    } // endswitch ($xz)
                } // ENDIF (trim($xaux) != "")
                // ------------------      en este caso, para México se usa esta leyenda     ----------------
                $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
                $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
                $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
                $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
                $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
                $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
                $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
            } // ENDFOR ($xz)
            return trim($xcadena);
        }

        // END FUNCTION

        function subfijo($xx)
        { // esta función regresa un subfijo para la cifra
            $xx = trim($xx);
            $xstrlen = strlen($xx);
            if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
                $xsub = "";
            //
            if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
                $xsub = "MIL";
            //
            return $xsub;
        }


         $solicitud = Solicitud::leftjoin('acopio.asignacion_presupuesto as asig','acopio.solicitud.sol_id', '=', 'asig.asig_id_sol')
                           ->leftjoin('public._bp_usuarios as us','acopio.solicitud.sol_id_usr', '=', 'us.usr_id')
                           ->leftjoin('acopio.municipio as muni','acopio.solicitud.sol_id_mun', '=', 'muni.mun_id')
                           ->leftjoin('public._bp_personas as per','us.usr_prs_id', '=', 'per.prs_id')
                           ->select('us.usr_usuario','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto','muni.mun_nombre','solicitud.sol_centr_acopio','per.prs_nombres','per.prs_paterno','per.prs_materno','per.prs_ci','per.prs_id_zona')
                              ->where('solicitud.sol_id',$id)
                              // ->GROUPBY ('us.usr_usuario','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto')
                            ->get();
        $zona = Usuario::join('public._bp_zonas as zona','public._bp_usuarios.usr_zona_id','=','zona.zona_id')
                ->where('usr_id','=',Auth::user()->usr_id)->first();
        // dd($zona);
         // dd($solicitud);
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('SOLICITUD');
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
        // setlocale(LC_TIME, 'es');
        // $datebus = new Carbon();
        // $dato= $datebus->formatLocalized($solicitud[0]->sol_fecha_reg);
        // $datoexacto = $datebus->format('d-m-Y'); 
        $fechaEntera = strtotime($solicitud[0]->sol_fecha_reg);
        $anio = date("Y", $fechaEntera);
        $mes = date("m", $fechaEntera);
        $dia = date("d", $fechaEntera);
 
        $html = '
                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th rowspan="2" align="center" width="130"><img src="/img/logopeqe.png" width="70" height="45"></th>
                            <th rowspan="2" align="center" width="275"><strong>FORMULARIO DE AUTORIZACI&Oacute;N DE RECURSOS PARA LA COMPRA  DE CASTA&Ntilde;A </strong></th>
                            <th align="center" width="130">                           
                                <strong>C&Oacute;DIGO: </strong>'.$solicitud[0]->sol_id.'
                            </th>
                        </tr>
                        <tr>
                        <th align="center" width="130">                               
                              <strong> ZONA: </strong>'.$zona->zona_serie.' - '.$zona->zona_nombre.'                             
                        </th>
                        </tr>
                        
                    </table>

                    <table>
                        <tr>
                            <th><strong>Nombre:</strong></th>
                            <th>'.$solicitud[0]->prs_nombres.' '.$solicitud[0]->prs_paterno.' '.$solicitud[0]->prs_materno.'</th>
                            <th align="right"><strong>CI.:</strong></th>
                            <th align="center">'.$solicitud[0]->prs_ci.'</th>
                        </tr>
                        <tr>
                            <th><strong>Municipio:</strong></th>
                            <th>'.$solicitud[0]->mun_nombre.'</th>
                        </tr>   
                        <tr>
                            <th><strong>Centro de Acopio:</strong></th>
                            <th>'.$solicitud[0]->sol_centr_acopio.'</th>
                        </tr>
                        <tr>
                            <th><strong>Fecha:</strong></th>
                            <th>'.$dia.'-'.$mes.'-'.$anio.'</th>
                        </tr>
                    </table>


                    <p bgcolor="#E8E8E8">OBJETO</p>
                    <p>'.$solicitud[0]->sol_detalle.'</p>

                    <table>
                        <tr>
                            <th><strong>Monto Numeral: </strong>'.number_format($solicitud[0]->sol_monto,2,'.',',').' Bs.</th>
                        </tr>
                        <tr>
                            <th><strong>Monto Literal: </strong>'.numtoletras($solicitud[0]->sol_monto).'.</th>
                        </tr>
                    </table>
                    <br><br><br>
                    <table border="1" cellspacing="0" cellpadding="0">
                        <tr>
                            <th height="55"></th>
                            <th height="55"></th>
                            <th height="55"></th>
                            <th height="55"></th>

                        </tr>
                        <tr>
                            <th  height="15" align="center">SOLICITANTE COMPRADOR</th>
                            <th  height="15" align="center">ENCARGADO DE ACOPIO</th>
                            <th  height="15" align="center">JEFA DE ACOPIO</th>
                            <th height="15" align="center">TESORERO</th>
                        </tr>
                    </table>

                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                                       

                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th rowspan="2" align="center" width="130"><img src="/img/logopeqe.png" width="70" height="45"></th>
                            <th rowspan="2" align="center" width="275"><strong>FORMULARIO DE AUTORIZACI&Oacute;N DE RECURSOS PARA LA COMPRA  DE CASTA&Ntilde;A </strong></th>
                            <th align="center" width="130">                           
                                <strong>C&Oacute;DIGO: </strong>'.$solicitud[0]->sol_id.'
                            </th>
                        </tr>
                        <tr>
                        <th align="center" width="130">                               
                              <strong> ZONA: </strong>'.$zona->zona_serie.' - '.$zona->zona_nombre.'                             
                        </th>
                        </tr>
                        
                    </table>

                    <table>
                        <tr>
                            <th><strong>Nombre:</strong></th>
                            <th>'.$solicitud[0]->prs_nombres.' '.$solicitud[0]->prs_paterno.' '.$solicitud[0]->prs_materno.'</th>
                            <th align="right"><strong>CI.:</strong></th>
                            <th align="center">'.$solicitud[0]->prs_ci.'</th>
                        </tr>
                        <tr>
                            <th><strong>Municipio:</strong></th>
                            <th>'.$solicitud[0]->mun_nombre.'</th>
                        </tr>   
                        <tr>
                            <th><strong>Centro de Acopio:</strong></th>
                            <th>'.$solicitud[0]->sol_centr_acopio.'</th>
                        </tr>
                        <tr>
                            <th><strong>Fecha:</strong></th>
                            <th>'.$dia.'-'.$mes.'-'.$anio.'</th>
                        </tr>
                    </table>


                    <p bgcolor="#E8E8E8">OBJETO</p>
                    <p>'.$solicitud[0]->sol_detalle.'</p>

                    <table>
                        <tr>
                            <th><strong>Monto Numeral: </strong>'.number_format($solicitud[0]->sol_monto,2,'.',',').' Bs.</th>
                        </tr>
                        <tr>
                            <th><strong>Monto Literal: </strong>'.numtoletras($solicitud[0]->sol_monto).'.</th>
                        </tr>
                    </table>
                    <br><br><br>
                    <table border="1" cellspacing="0" cellpadding="0">
                        <tr>
                            <th height="55"></th>
                            <th height="55"></th>
                            <th height="55"></th>
                            <th height="55"></th>

                        </tr>
                        <tr>
                            <th  height="15" align="center">SOLICITANTE COMPRADOR</th>
                            <th  height="15" align="center">ENCARGADO DE ACOPIO</th>
                            <th  height="15" align="center">JEFA DE ACOPIO</th>
                            <th height="15" align="center">TESORERO</th>
                        </tr>
                    </table>
                    ';





    
        $pdf->writeHTML($html, true, 0, true, true);
        $pdf->Output('example_002.pdf', 'I');
    }


    public function boletaAsignacion($id)
    {  
        function numtoletras($xcifra)
        {
            $xarray = array(0 => "Cero",
                1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
                "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
                "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
                100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
            );
        //
            $xcifra = trim($xcifra);
            $xlength = strlen($xcifra);
            $xpos_punto = strpos($xcifra, ".");
            $xaux_int = $xcifra;
            $xdecimales = "00";
            if (!($xpos_punto === false)) {
                if ($xpos_punto == 0) {
                    $xcifra = "0" . $xcifra;
                    $xpos_punto = strpos($xcifra, ".");
                }
                $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
                $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
            }

            $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
            $xcadena = "";
            for ($xz = 0; $xz < 3; $xz++) {
                $xaux = substr($XAUX, $xz * 6, 6);
                $xi = 0;
                $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
                $xexit = true; // bandera para controlar el ciclo del While
                while ($xexit) {
                    if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                        break; // termina el ciclo
                    }

                    $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                    $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                    for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                        switch ($xy) {
                            case 1: // checa las centenas
                                if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                                } else {
                                    $key = (int)substr($xaux, 0, 3);
                                    if (TRUE === array_key_exists($key, $xarray)) {  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                        $xseek = $xarray[$key];
                                        $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                        if (substr($xaux, 0, 3) == 100)
                                            $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                        else
                                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                        $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                    } else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                        $key = (int)substr($xaux, 0, 1) * 100;
                                        $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    } // ENDIF ($xseek)
                                } // ENDIF (substr($xaux, 0, 3) < 100)
                                break;
                            case 2: // checa las decenas (con la misma lógica que las centenas)
                                if (substr($xaux, 1, 2) < 10) {

                                } else {
                                    $key = (int)substr($xaux, 1, 2);
                                    if (TRUE === array_key_exists($key, $xarray)) {
                                        $xseek = $xarray[$key];
                                        $xsub = subfijo($xaux);
                                        if (substr($xaux, 1, 2) == 20)
                                            $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                        else
                                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                        $xy = 3;
                                    } else {
                                        $key = (int)substr($xaux, 1, 1) * 10;
                                        $xseek = $xarray[$key];
                                        if (20 == substr($xaux, 1, 1) * 10)
                                            $xcadena = " " . $xcadena . " " . $xseek;
                                        else
                                            $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                    } // ENDIF ($xseek)
                                } // ENDIF (substr($xaux, 1, 2) < 10)
                                break;
                            case 3: // checa las unidades
                                if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                                } else {
                                    $key = (int)substr($xaux, 2, 1);
                                    $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                    $xsub = subfijo($xaux);
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                } // ENDIF (substr($xaux, 2, 1) < 1)
                                break;
                        } // END SWITCH
                    } // END FOR
                    $xi = $xi + 3;
                } // ENDDO

                if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                    $xcadena .= " DE";

                if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                    $xcadena .= " DE";

                // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
                if (trim($xaux) != "") {
                    switch ($xz) {
                        case 0:
                            if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                                $xcadena .= "UN BILLON ";
                            else
                                $xcadena .= " BILLONES ";
                            break;
                        case 1:
                            if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                                $xcadena .= "UN MILLON ";
                            else
                                $xcadena .= " MILLONES ";
                            break;
                        case 2:
                            if ($xcifra < 1) {
                                $xcadena = "CERO $xdecimales/100 Bolivianos";
                            }
                            if ($xcifra >= 1 && $xcifra < 2) {
                                $xcadena = "UN $xdecimales/100 Bolivianos ";
                            }
                            if ($xcifra >= 2) {
                                $xcadena .= " $xdecimales/100 Bolivianos "; //
                            }
                            break;
                    } // endswitch ($xz)
                } // ENDIF (trim($xaux) != "")
                // ------------------      en este caso, para México se usa esta leyenda     ----------------
                $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
                $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
                $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
                $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
                $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
                $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
                $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
            } // ENDFOR ($xz)
            return trim($xcadena);
        }

        // END FUNCTION

        function subfijo($xx)
        { // esta función regresa un subfijo para la cifra
            $xx = trim($xx);
            $xstrlen = strlen($xx);
            if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
                $xsub = "";
            //
            if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
                $xsub = "MIL";
            //
            return $xsub;
        }

        function meses($mes)
{
    if ($mes == '01') {
        $m = "de Enero de";
    }
    if ($mes == '02') {
        $m = "de Febrero de";
    }
    if ($mes == '03') {
        $m = "de Marzo de";
    }
    if ($mes == '04') {
        $m = "de Abril de";
    }
    if ($mes == '05') {
        $m = "de Mayo de";
    }
    if ($mes == '06') {
        $m = "de Junio de";
    }
    if ($mes == '07') {
        $m = "de Julio de";
    }
    if ($mes == '08') {
        $m = "de Agosto de";
    }
    if ($mes == '09') {
        $m = "de Septiembre de";
    }
    if ($mes == '10') {
        $m = "de Octubre de";
    }
    if ($mes == '11') {
        $m = "de Noviembre de";
    }
    if ($mes == '12') {
        $m = "de Diciembre de";
    }
    return $m;
}

         $solicitud = Solicitud::leftjoin('acopio.asignacion_presupuesto as asig','acopio.solicitud.sol_id', '=', 'asig.asig_id_sol')
                           ->leftjoin('public._bp_usuarios as us','acopio.solicitud.sol_id_usr', '=', 'us.usr_id')
                           ->leftjoin('public._bp_zonas as zona','us.usr_zona_id','=','zona.zona_id')
                           ->leftjoin('acopio.municipio as muni','acopio.solicitud.sol_id_mun', '=', 'muni.mun_id')
                           ->leftjoin('public._bp_personas as per','us.usr_prs_id', '=', 'per.prs_id')
                           ->select('us.usr_usuario','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto','asig.asig_fecha','asig.asig_obs','muni.mun_nombre','solicitud.sol_centr_acopio','per.prs_nombres','per.prs_paterno','per.prs_materno','per.prs_ci','per.prs_id_zona','zona.zona_nombre')
                              ->where('solicitud.sol_id',$id)
                              // ->GROUPBY ('us.usr_usuario','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto')
                            ->get();

        $zona = Usuario::join('public._bp_zonas as zona','public._bp_usuarios.usr_zona_id','=','zona.zona_id')
                ->where('usr_id','=',Auth::user()->usr_id)->first();
        // dd($zona);
        $zonasola = ucfirst(mb_substr($solicitud[0]->prs_id_zona, 4, null, 'UTF-8'));
        // dd($zonasola);
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('SOLICITUD');
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
        // setlocale(LC_TIME, 'es');
        // $datebus = new Carbon();
        // $dato= $datebus->formatLocalized($solicitud[0]->sol_fecha_reg);
        // $datoexacto = $datebus->format('d-m-Y'); 
        $fechaEntera = strtotime($solicitud[0]->asig_fecha_reg);
        $anio = date("Y", $fechaEntera);
        $mes = date("m", $fechaEntera);
        $dia = date("d", $fechaEntera);
 
        $html = '
                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th rowspan="2" align="center" width="130"><img src="/img/logopeqe.png" width="70" height="45"></th>
                            <th rowspan="2" align="center" width="275"><strong>RECIBO DE CAJA (EGRESO) ENTREGA DE RECURSOS PARA LA COMPRA DE CASTA&Ntilde;A </strong></th>
                            <th align="center" width="130">                           
                                <strong>C&Oacute;DIGO: </strong>
                            </th>
                        </tr>
                        <tr>
                        <th align="center" width="130">                               
                                      '.$solicitud[0]->sol_id.'                    
                        </th>
                        </tr>
                        
                    </table>

                    <br><br><br>
                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th height="25" align="right"><strong>  Importe Total: </strong>'.number_format($solicitud[0]->asig_monto,2,'.',',').'</th>
                            
                        </tr>
                        <tr>
                            <th height="25"><strong>  Importe entregado al se&ntilde;or: </strong>'.$solicitud[0]->prs_nombres.' '.$solicitud[0]->prs_paterno.' '.$solicitud[0]->prs_materno.'</th>
                            </tr>   
                        <tr>
                            <th height="25"><strong>  La Suma de: </strong>'.numtoletras($solicitud[0]->asig_monto).'</th>
                            
                        </tr>
                        <tr>
                            <th height="25"><strong>  Por concepto de: </strong>'.$solicitud[0]->asig_obs.'</th>
                           
                        </tr>
                    </table>


                    <p align="right">'.$solicitud[0]->zona_nombre.', '.$dia.' '.meses($mes).' '.$anio.'.</p>
                   
                    
                    <br><br><br>
                    <table border="1" cellspacing="0" cellpadding="0">
                        <tr>
                            <th height="55"></th>
                            <th height="55"></th>
                            <th height="55"></th>
                        </tr>
                        <tr>
                            <th  height="15" align="center">ENTREGUE CONFORME</th>
                            <th  height="15" align="center">ENCARGADO DE ACOPIO</th>
                            <th  height="15" align="center">RECIBI CONFORME<br><strong> Nombre: </strong>'.$solicitud[0]->prs_nombres.' '.$solicitud[0]->prs_paterno.' '.$solicitud[0]->prs_materno.'<br><strong>CI: </strong>'.$solicitud[0]->prs_ci.'</th>
                        </tr>
                    </table>

                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                                      

                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th rowspan="2" align="center" width="130"><img src="/img/logopeqe.png" width="70" height="45"></th>
                            <th rowspan="2" align="center" width="275"><strong>RECIBO DE CAJA (EGRESO) ENTREGA DE RECURSOS PARA LA COMPRA DE CASTA&Ntilde;A </strong></th>
                            <th align="center" width="130">                           
                                <strong>C&Oacute;DIGO: </strong>
                            </th>
                        </tr>
                        <tr>
                        <th align="center" width="130">                               
                                         '.$solicitud[0]->sol_id.'                 
                        </th>
                        </tr>
                        
                    </table>

                    <br><br><br>
                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th height="25" align="right"><strong>  Importe Total: </strong>'.number_format($solicitud[0]->asig_monto,2,'.',',').'</th>
                            
                        </tr>
                        <tr>
                            <th height="25"><strong>  Importe entregado al se&ntilde;or: </strong>'.$solicitud[0]->prs_nombres.' '.$solicitud[0]->prs_paterno.' '.$solicitud[0]->prs_materno.'</th>
                            </tr>   
                        <tr>
                            <th height="25"><strong>  La Suma de: </strong>'.numtoletras($solicitud[0]->asig_monto).'</th>
                            
                        </tr>
                        <tr>
                            <th height="25"><strong>  Por concepto de: </strong>'.$solicitud[0]->asig_obs.'</th>
                           
                        </tr>
                    </table>


                    <p align="right">'.$solicitud[0]->zona_nombre.', '.$dia.' '.meses($mes).' '.$anio.'.</p>
                   

                    
                    <br><br><br>
                    <table border="1" cellspacing="0" cellpadding="0">
                        <tr>
                            <th height="55"></th>
                            <th height="55"></th>
                            <th height="55"></th>
                        </tr>
                        <tr>
                            <th  height="15" align="center">ENTREGUE CONFORME</th>
                            <th  height="15" align="center">ENCARGADO DE ACOPIO</th>
                            <th  height="15" align="center">RECIBI CONFORME<br><strong> Nombre: </strong>'.$solicitud[0]->prs_nombres.' '.$solicitud[0]->prs_paterno.' '.$solicitud[0]->prs_materno.'<br><strong>CI: </strong>'.$solicitud[0]->prs_ci.'</th>
                        </tr>
                    </table>
                    ';





    
        $pdf->writeHTML($html, true, 0, true, true);
        $pdf->Output('example_002.pdf', 'I');
    }
}
