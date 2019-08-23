<?php

namespace siga\Http\Controllers\acopio\acopio_almendra;

use Illuminate\Http\Request;

use siga\Http\Requests;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_almendra\Acopio;
use siga\Modelo\acopio\acopio_almendra\Proveedor;
use siga\Modelo\acopio\acopio_almendra\TipoCastania;
use siga\Modelo\acopio\acopio_almendra\Unidad;
use siga\Modelo\acopio\acopio_almendra\Comunidad;
use siga\Modelo\acopio\acopio_almendra\LugarCompra;
use siga\Modelo\acopio\acopio_almendra\Municipio;
use siga\Modelo\acopio\acopio_almendra\Movimiento_Recursos;
use siga\Modelo\acopio\acopio_almendra\Asignacion;
use Illuminate\Support\Facades\DB;
use siga\Modelo\admin\Usuario;
use Session;
use Yajra\Datatables\Datatables;
use PDF;
use TCPDF;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Auth;

class gbAcopioController extends Controller
{
    public function Index()
    {
      
        $id=Auth::user()->usr_id;
        $dataTipo = TipoCastania::comboTipo();
        $dataUni = Unidad::comboUnidad();
        $dataComu = Comunidad::combo();
        $dataLugar = LugarCompra::comboLugar();
        $dataProv = Proveedor::combo();
        $dataMuni = Municipio::combo();
        $sumasig =\DB::select('select * from acopio.sp_sum_asignado(?)', array($id));
        $asig=Collect($sumasig);
        $array = json_decode($asig);
        if(empty($array[0]->asig_monto1)){
            $total=0;
        }else{
            $total=$array[0]->asig_monto1;
        }
        $sumauti =\DB::select('select * from acopio.sp_sum_utilizado(?)', array($id));
        $uti=Collect($sumauti);
        $array1 = json_decode($uti);
        if(empty($array1[0]->aco_cos_total1)){
            $total2=0;
        }else{
            $total2=$array1[0]->aco_cos_total1;
        }
        $total3=$total-$total2;
        return view ('backend.administracion.acopio.acopio_almendra.gbAcopios.index', compact('dataTipo','dataUni','dataComu','dataLugar','dataProv','dataMuni','total','total2','total3'));
    }

    public function show($id)
    {  
        $acopio = Acopio::join('acopio.tipo_castania as tip','acopio.acopio.aco_id_tipo_cas', '=', 'tip.tca_id')
                          ->join('acopio.lugar_proc as lug','acopio.acopio.aco_id_proc', '=', 'lug.proc_id')
                          ->select('tip.tca_nombre','lug.proc_nombre','acopio.acopio.aco_fecha_acop','acopio.acopio.aco_numaco','acopio.acopio.aco_peso_neto','acopio.acopio.aco_cantidad','acopio.acopio.aco_cos_total','acopio.acopio.aco_id','acopio.aco_num_rec','acopio.aco_cos_un')
                          ->where('aco_id_prov',$id)->where('aco_estado','=','A')->paginate(8);
        $buscar = Proveedor::setBuscar($id);
        // dd($buscar);
        return view ('backend.administracion.acopio.acopio_almendra.gbAcopios.indexDetalle',compact('acopio','buscar'));
    }

     public function create()
    {
        $idrol=Session::get('ID_ROL');
        if ($idrol == 13) {
            $sum = Acopio::rightJoin('acopio.proveedor as proveedor','acopio.acopio.aco_id_prov','proveedor.prov_id')
                         ->select(DB::raw('MAX(acopio.aco_numaco) as aco_numaco1, SUM(acopio.aco_cantidad) as aco_cantidad1, SUM(acopio.aco_peso_neto) as aco_peso_neto1, SUM(acopio.aco_cos_total) as aco_cos_total1'),'proveedor.prov_id as prov_id1','proveedor.prov_nombre as prov_nombre1','proveedor.prov_ap as prov_ap1','proveedor.prov_am as prov_am1','proveedor.prov_ci as prov_ci1')
                         ->where('proveedor.prov_estado','A')
                         ->where('proveedor.prov_id_linea',1)
                         ->where('proveedor.prov_id_tipo',3)
                         ->groupBy('proveedor.prov_id','proveedor.prov_nombre','proveedor.prov_ap','proveedor.prov_am','proveedor.prov_ci')->get();
            // dd($sum);
        }else{
            $id=Auth::user()->usr_id;
            $result = \DB::select('select * from acopio.sp_sum_group1(?)', array($id));
            $sum = Collect($result);
        }        
        return Datatables::of($sum)->addColumn('acciones', function ($sum) {
          return '<button value="' . $sum->prov_id1 . '" class="btn btn-primary" style="background:#F5B041" onClick="MostrarRegistro(this);" data-toggle="modal" data-target="#myCreate">REGISTRAR</button>
                   <a href="Acopio/listarDetalle/' . $sum->prov_id1 . '" class="btn btn-primary" style="background:#5499C7">LISTAR</i></a>';   
  	})
            ->editColumn('id', 'ID: {{$prov_id1}}')
            ->addColumn('nombrecompleto', function ($nombrecompleto) {
            return $nombrecompleto->prov_ap1 . ' ' . $nombrecompleto->prov_am1.' '.$nombrecompleto->prov_nombre1;
        })
            ->make(true);
    }

    public function store(Request $request)
    {
        $date = Carbon::now();
        $id=$request['aco_id_prov'];
        $acopio = Proveedor::setBuscarAco($id);
        $cont=$acopio['nroaco'];
        $nid = $cont + 1;

        $montoActual = $request['aco_montoactual'];
        // dd($montoActual);
        $acopio =Acopio::create([
            'aco_id_prov'   	=> $request['aco_id_prov'],
            'aco_id_proc'       => $request['aco_id_proc'],
            'aco_centro'        => $request['aco_centro'],
            'aco_peso_neto'     => $request['aco_peso_neto'],
            'aco_id_tipo_cas'   => $request['aco_id_tipo_cas'],
            'aco_numaco'        => $nid,
            'aco_unidad'        => $request['aco_unidad'],
            'aco_cantidad'      => $request['aco_cantidad'],
            'aco_cos_un'        => $request['aco_cos_un'],
            'aco_cos_total'     => $request['aco_cos_total'],
            'aco_fecha_acop'    => $request['aco_fecha_acop'],
            'aco_fecha_reg'	    => $date,
            'aco_obs'		    => $request['aco_obs'],
            'aco_id_usr'	    => Auth::user()->usr_id,
            'aco_estado'	    => 'A',
            'aco_num_rec'	    => $request['aco_num_rec'],
            //'aco_id_recep'	    => 1,
            'aco_id_linea'	    => 1,
            'aco_id_comunidad'  => $request['aco_id_comunidad'],
            //'aco_id_prom'       => 1,
            //'aco_id_destino'	=> 1,
	    'aco_plus'          => $request['aco_plus'],
        ]);
        $acoId = $acopio->aco_id;
        $saldo = $montoActual - $request['aco_cos_total'];
        Movimiento_Recursos::create([
            'movrec_ingreso' => 0,
            'movrec_egreso'  => $request['aco_cos_total'],
            'movrec_saldo'   => $saldo,
            'movrec_id_usr'  => Auth::user()->usr_id,
            'movrec_id_aco'  => $acoId,
            'movrec_estado'  => 'A',
            'movrec_id_asignacion' => 0,
            'movrec_fecha_mov' => $date,
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
        return view ('acopio.acopio_almendra.gbAcopios.index', compact('acopio'));
    }

    public function registraComunidad(Request $request)
    {
        Comunidad::create([
            'com_nombre'         => $request['com_nombre'],
            'com_id_mun'         => $request['com_id_mun'],
            'com_estado'         => 'A',
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function edit($id)

    {

       // dd('ooooooooooo',$id);
        //$result = \DB::select('select * from acopio.sp_max_num(?)', array($id));
        //$asig=Collect($result);
        //$array = json_decode($asig);
        //$sum = $array[0]->aco_numaco2;
        //return view ('backend.administracion.acopio.acopio_almendra.gbAcopios.index', compact('sum'));
        //$acopio = Proveedor::setBuscar($id);
	$acopio = Proveedor::setBuscarNumaco($id);
	if ($acopio == null) {
            $acopio = Proveedor::where('prov_id','=',$id)->where('prov_estado','=','A')->first();
        }
        //dd('ooooooooooo',$acopio);
        return response()->json($acopio);
    }


 
     public function boletAcopio($id)
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

	function obtenerFechaEnLetra($fecha){
       // $dia= conocerDiaSemanaFecha($fecha);
        $num = date("j", strtotime($fecha));
        $anno = date("Y", strtotime($fecha));
        $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        $mes = $mes[(date('m', strtotime($fecha))*1)-1];
        //return $dia.', '.$num.' de '.$mes.' del '.$anno;
        return $num.' de '.$mes.' del '.$anno;
        }
     
        function conocerDiaSemanaFecha($fecha) {
            $dias = array('Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'S�bado');
            $dia = $dias[date('w', strtotime($fecha))];
            return $dia;
        }
        
         $boleta = Acopio::getBoletaAcopio($id);
         // $municipio = Municipio::join('acopio.proveedor as prov','acopio.municipio.mun_id','=','prov.prov_id_municipio')->where('prov_id','=',$boleta['prov_id'])->first();
         $municipio = Municipio::join('acopio.comunidad as comu','acopio.municipio.mun_id','=','comu.com_id_mun')->where('comu.com_id','=',$boleta['com_id'])->first();
         // dd($municipio);
         $nombre = Usuario::setNombre($id);

         // $zona = Usuario::join('public._bp_personas as perso','public._bp_usuarios.usr_prs_id','=','perso.prs_id')->where('usr_id','=',$boleta['aco_id_usr'])->select('perso.prs_id_zona')->first();
         $zona = Usuario::join('public._bp_zonas as zona','public._bp_usuarios.usr_zona_id','=','zona.zona_id')
                ->where('usr_id','=',$boleta['aco_id_usr'])->select('zona.zona_serie','zona.zona_nombre')->first();
         // dd($zona);
         $asig=Collect($nombre);
         
         $var=$boleta['aco_cos_total'];
         $literal = numtoletras($var);
	     $varfe = $boleta['aco_fecha_acop'];
         $Fecha = obtenerFechaEnLetra($varfe);

         $id1=$boleta['aco_id_prov'];
         $acopio = Proveedor::setBuscar($id1);
         $total = $boleta['aco_cos_total']/0.9675;
         $var=(3.25/100);
         $calculo=$var * $total;
         

           PDF::AddPage();

           PDF::SetFont('helvetica','B',12);
           PDF::Ln(5); 
           PDF::Cell(45,0,'',0,1,'C');
           PDF::Cell(45,20,PDF::Image('img/logopeqe.png',12,18,'R',25),1,0,'C');

           PDF::MultiCell(95, 20, '', 1, 0, 0, 'L');
           PDF::SetXY(60, 20);
           PDF::Cell(95,10,utf8_decode('RECIBO DE CAJA EGRESO'),0,1,'C',0);
           PDF::SetXY(60, 30);
           PDF::Cell(95,10,utf8_decode('POR COMPRA DE ALMENDRA'),0,1,'C',0);

           PDF::SetFont('helvetica','B',9);
           PDF::SetXY(150, 20);
           PDF::Cell(45,10,utf8_decode('Serie: '.$zona->zona_serie.' - '.$zona->zona_nombre),1,1,'C',0);
           PDF::SetXY(150, 30);
           PDF::writeHTML('', PDF::Cell(45,10,'Nº'.$boleta['aco_num_rec'],1,1,'C',0), true, true, false, '');

           PDF::SetFont('helvetica','B',10);

           PDF::Ln(5); 
           PDF::Cell(5,6,'',0,0,'C');
           PDF::Ln(10);
        
         //LUGAR DE COMPRA
            switch ($boleta['aco_id_proc']) {
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

            switch ($boleta['prov_id_tipo']) {
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

            PDF::Cell(15,8,number_format($total,2,'.',','),1,0,'C');
            PDF::SetFont('helvetica','B',7);
            PDF::SetXY(155, 61);
            PDF::Cell(25, 8, utf8_decode('Menos Impto. 3,25%'), 1,1,'C',0);
            PDF::SetXY(180, 61);
            PDF::Cell(15,8,number_format($calculo,2,'.',','),1,0,'C'); 
            PDF::SetFont('helvetica','B',9);
            PDF::SetXY(155, 71);
            PDF::Cell(25, 8, utf8_decode('Importe Neto'), 1,1,'C',0);
            PDF::SetXY(180, 71);
            PDF::writeHTML('',PDF::Cell(15,8,$boleta['aco_cos_total'],1,0,'C'), true, true, false, '');
           // $pdf->Cell(15,8,$totimp,1,0,'C'); 

            PDF::SetXY(15, 101);
            PDF::Cell(49,7,'Hemos cancelado al Sr. (a):',0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(131,7,$acopio['prov_nombre'].' '.$acopio['prov_ap'].' '.$acopio['prov_am'],0,1,'L',0), true, true, false, '');
           // $pdf->Cell(131,7,'',0,1,'L',0);

            PDF::SetXY(15, 111);
            PDF::Cell(30,8,'De la Comunidad:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['com_nombre'],0,1,'L',0), true, true, false, '');
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
            PDF::MultiCell(45, 8,$municipio->mun_nombre, 0, 1, 0, 'J');
            PDF::SetFont('helvetica','B',9);

             switch ($boleta['prov_id_convenio']) {
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
            PDF::MultiCell(130, 8,$literal,0,1, 0, 'C');

            PDF::SetXY(175, 121);
            PDF::Cell(20,8,'',0,1,'R',0);

            PDF::SetXY(15, 131);
            PDF::Cell(40,8,'Por Concepto de Compra de:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['aco_cantidad'],0,1,'L',0), true, true, false, '');
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
            PDF::writeHTML('',PDF::Cell(18,8,$boleta['aco_cos_un'],0,1,'L',0), true, true, false, '');
            //PDF::MultiCell(18, 8,'2', 0, 1, 0, 'J');
            PDF::SetFont('helvetica','B',9);
            PDF::SetXY(162, 131);
            PDF::Cell(15,8,utf8_decode('c/caja de,'),0,0,'C',0);
            PDF::SetFont('helvetica','',7);
            PDF::SetXY(177, 131);
           //  $pdf->writeHTML('',$pdf->Cell(131,7,$boleta['aco_cos_un'],0,1,'L',0), true, true, false, '');
            PDF::Cell(18,8,$boleta['aco_peso_neto'].' '.utf8_decode('kilos'),0,0,'C',0);

            switch ($boleta['aco_id_tipo_cas']) {
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
            PDF::MultiCell(130,8,$Fecha,0,1,0,'C');

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
            PDF::writeHTML('',PDF::Cell(15,6,$acopio['prov_nombre'].' '.$acopio['prov_ap'].' '.$acopio['prov_am'],0,1,'L',0), true, true, false, '');
           // $pdf->Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
           // $pdf->Cell(45,6,'',0,1,'L',0);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(45,6,$acopio['prov_ci'],0,1,'L',0), true, true, false, '');
            //$pdf->Cell(45,6,'',0,1,'L',0);

            PDF::SetXY(125, 199);
            PDF::Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            PDF::SetXY(120, 204);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(15,6,$asig['prs_nombres'].' '.$asig['prs_paterno'].' '.$asig['prs_materno'],0,1,'L',0), true, true, false, '');
            //PDF::Cell(45,6,'',0,1,'C',0);
            PDF::SetXY(120, 210);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(45,6,$asig['prs_ci'],0,1,'L',0), true, true, false, '');
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

 



    Public function boletAcopioProv($id)
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

	 function obtenerFechaEnLetra($fecha){
       // $dia= conocerDiaSemanaFecha($fecha);
        $num = date("j", strtotime($fecha));
        $anno = date("Y", strtotime($fecha));
        $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        $mes = $mes[(date('m', strtotime($fecha))*1)-1];
        //return $dia.', '.$num.' de '.$mes.' del '.$anno;
        return $num.' de '.$mes.' del '.$anno;
        }
     
        function conocerDiaSemanaFecha($fecha) {
            $dias = array('Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'S�bado');
            $dia = $dias[date('w', strtotime($fecha))];
            return $dia;
        }


         $boleta = Acopio::getBoletaAcopio($id);
         //$municipio = Municipio::join('acopio.proveedor as prov','acopio.municipio.mun_id','=','prov.prov_id_municipio')->where('prov_id','=',$boleta['prov_id'])->first();
        $municipio = Municipio::join('acopio.comunidad as comu','acopio.municipio.mun_id','=','comu.com_id_mun')->where('comu.com_id','=',$boleta['com_id'])->first(); 
	$nombre = Usuario::setNombre($id);

         // $zona = Usuario::join('public._bp_personas as perso','public._bp_usuarios.usr_prs_id','=','perso.prs_id')->where('usr_id','=',$boleta['aco_id_usr'])->select('perso.prs_id_zona')->first();
         $zona = Usuario::join('public._bp_zonas as zona','public._bp_usuarios.usr_zona_id','=','zona.zona_id')
                ->where('usr_id','=',$boleta['aco_id_usr'])->select('zona.zona_serie','zona.zona_nombre')->first();
	 $asig=Collect($nombre);
         $var=$boleta['aco_cos_total'];
         $literal = numtoletras($var);
	     $varfe = $boleta['aco_fecha_acop'];
         $Fecha = obtenerFechaEnLetra($varfe);

         $id1=$boleta['aco_id_prov'];
         $acopio = Proveedor::setBuscar($id1);
         $var=(3.25/100);
         $calculo=$var * $boleta['aco_cos_total'];
         $total = $calculo + $boleta['aco_cos_total'];
         //$letras = NumeroALetras::convertir(765);     

           PDF::AddPage();

           PDF::SetFont('helvetica','B',12);
           PDF::Ln(5); 
           PDF::Cell(45,0,'',0,1,'C');
           PDF::Cell(45,20,PDF::Image('img/logopeqe.png',12,18,'R',25),1,0,'C');

           PDF::MultiCell(95, 20, '', 1, 0, 0, 'L');
           PDF::SetXY(60, 20);
           PDF::Cell(95,10,utf8_decode('RECIBO DE CAJA EGRESO'),0,1,'C',0);
           PDF::SetXY(60, 30);
           PDF::Cell(95,10,utf8_decode('POR COMPRA DE ALMENDRA'),0,1,'C',0);

           PDF::SetFont('helvetica','B',9);
           PDF::SetXY(150, 20);
           PDF::Cell(45,10,utf8_decode('Serie: '.$zona->zona_serie.' - '.$zona->zona_nombre),1,1,'C',0);
           PDF::SetXY(150, 30);
           PDF::writeHTML('', PDF::Cell(45,10,'Nº'.$boleta['aco_num_rec'],1,1,'C',0), true, true, false, '');

           PDF::SetFont('helvetica','B',10);

           PDF::Ln(5); 
           PDF::Cell(5,6,'',0,0,'C');
           PDF::Ln(10);


            //LUGAR DE COMPRA

            //LUGAR DE COMPRA
            switch ($boleta['aco_id_proc']) {
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


             switch ($boleta['prov_id_tipo']) {
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
            PDF::Cell(25, 8, utf8_decode('Importe Neto'), 1,1,'C',0);
            PDF::SetFont('helvetica','B',7);
            PDF::SetXY(180, 51);
            PDF::writeHTML('',PDF::Cell(15,8,$boleta['aco_cos_total'],1,0,'C'), true, true, false, '');

            PDF::SetXY(15, 101);
            PDF::Cell(49,7,'Hemos cancelado al Sr. (a):',0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(131,7,$acopio['prov_nombre'].' '.$acopio['prov_ap'].' '.$acopio['prov_am'],0,1,'L',0), true, true, false, '');
           // $pdf->Cell(131,7,'',0,1,'L',0);

            PDF::SetXY(15, 111);
            PDF::Cell(30,8,'De la Comunidad:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['com_nombre'],0,1,'L',0), true, true, false, '');
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
            PDF::MultiCell(45, 8,$municipio->mun_nombre, 0, 1, 0, 'J');
            PDF::SetFont('helvetica','B',9);

             switch ($boleta['prov_id_convenio']) {
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
            PDF::MultiCell(130, 8,$literal,0,1, 0, 'C');

            PDF::SetXY(175, 121);
            PDF::Cell(20,8,'',0,1,'R',0);

            PDF::SetXY(15, 131);
            PDF::Cell(40,8,'Por Concepto de Compra de:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['aco_cantidad'],0,1,'L',0), true, true, false, '');
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
            PDF::writeHTML('',PDF::Cell(18,8,$boleta['aco_cos_un'],0,1,'L',0), true, true, false, '');
            //PDF::MultiCell(18, 8,'2', 0, 1, 0, 'J');
            PDF::SetFont('helvetica','B',9);
            PDF::SetXY(162, 131);
            PDF::Cell(15,8,utf8_decode('c/caja de,'),0,0,'C',0);
            PDF::SetFont('helvetica','',7);
            PDF::SetXY(177, 131);
           //  $pdf->writeHTML('',$pdf->Cell(131,7,$boleta['aco_cos_un'],0,1,'L',0), true, true, false, '');
            PDF::Cell(18,8,$boleta['aco_peso_neto'].' '.utf8_decode('kilos'),0,0,'C',0);

            switch ($boleta['aco_id_tipo_cas']) {
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
            PDF::MultiCell(130,8,$Fecha,0,1,0,'C');

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
            PDF::writeHTML('',PDF::Cell(15,6,$acopio['prov_nombre'].' '.$acopio['prov_ap'].' '.$acopio['prov_am'],0,1,'L',0), true, true, false, '');
           // $pdf->Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
           // $pdf->Cell(45,6,'',0,1,'L',0);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(45,6,$acopio['prov_ci'],0,1,'L',0), true, true, false, '');
            //$pdf->Cell(45,6,'',0,1,'L',0);

            PDF::SetXY(125, 199);
            PDF::Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            PDF::SetXY(120, 204);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(15,6,$asig['prs_nombres'].' '.$asig['prs_paterno'].' '.$asig['prs_materno'],0,1,'L',0), true, true, false, '');
            //PDF::Cell(45,6,'',0,1,'C',0);
            PDF::SetXY(120, 210);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(45,6,$asig['prs_ci'],0,1,'L',0), true, true, false, '');
            //PDF::Cell(60,6,''." ".'',0,1,'C',0);

            PDF::Line(35, 198.5,85, 198.5); 
            //$pdf->Line(87, 198.5,130, 198.5); 
            PDF::Line(135, 198.5,186, 198.5); 

            PDF::Output();

   
        PDF::SetTitle('Boleta de Acopio Proveedor');
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

    public function reportes()
    {
        return view('backend.administracion.acopio.acopio_almendra.gbReportes.index');
    }

      public function reporteAcopio()
    {
        $idrol=Session::get('ID_ROL');

        if($idrol == 1 or $idrol == 3 or $idrol == 9)
        {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetAuthor('EBA');
            $pdf->SetTitle('EBA');
            $pdf->SetSubject('ACOPIO ALMENDRA');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
            // $id=Auth::user()->usr_id;
ini_set('memory_limit','512M');
set_time_limit(640);
            $sum = Acopio::join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')->orderBy('aco_fecha_acop','ASC')->get();
            //dd($sum);
            $cant=0;
            $cant1=0;
            $cant2=0;

            $acumcacaja2 = 0;
            $acuegreso = 0;

            $nro = 0;
            // set font
            $pdf->SetFont('helvetica', '', 9);

            // add a page
            $pdf->AddPage('L', 'Carta');
            //PDF::AddPage();

            // create some HTML content

            $html = '   <table border="1" cellspacing="0" cellpadding="1">
                            <tr>
                                 <th align="center" width="160"><img src="/img/logopeqe.png" width="120" height="65"></th>
                                <th  width="660"><h1 align="center">COMPRA CASTA&Ntilde;A<br> EN CASCARA</h1></th>
                                <th  width="160"><h3 align="center"><br>REVISION</h3></th>
                            </tr>
                        </table>
                        <br><br><br>
                        
                        <table border="1" cellspacing="0" cellpadding="1" style="font-size:8px">
                            <tr>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="25"><strong>Nro</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="50"><strong>Comprador</strong></th>
                                <th colspan="3" align="center" bgcolor="#3498DB" width="100"><strong>Nro Documento</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="45"><strong>Fecha</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="50"><strong>Comunidad</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="50"><strong>Municipio</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="50"><strong>Nombres</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="40"><strong>Tipo Casta&ntilde;a</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="60"><strong>Comun.</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="25"><strong>Conv.</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="50"><strong>Nro CI.</strong></th>
                                <th colspan="1" align="center" bgcolor="#3498DB" width="50"><strong>En cajas</strong></th>
                                <th colspan="1" align="center" bgcolor="#3498DB" width="50"><strong>C. Acum.</strong></th>
                                <th colspan="1" align="center" bgcolor="#3498DB" width="50"><strong>Peso KG</strong></th>
                                <th colspan="2" align="center" bgcolor="#3498DB" width="80"><strong>En Kilogramos</strong></th>
                                <th colspan="1" align="center" bgcolor="#3498DB" width="40"><strong>Precio</strong></th>
                                <th colspan="2" align="center" bgcolor="#3498DB" width="80"><strong>EN BOLIVIANOS</strong></th>
                                <th colspan="2" align="center" bgcolor="#3498DB" width="75"><strong>RETENCIONES</strong></th>
                            </tr>
                            <tr>                                
                                <th align="center" bgcolor="#3498DB">Serie A</th>
                                <th align="center" bgcolor="#3498DB">Serie B</th>
                                <th align="center" bgcolor="#3498DB">Serie C</th>
                                <th align="center" bgcolor="#3498DB">INGRESO</th>
                                <th align="center" bgcolor="#3498DB">SALDO</th>
                                <th align="center" bgcolor="#3498DB">CAJA</th>
                                <th align="center" bgcolor="#3498DB">INGRESO</th>
                                <th align="center" bgcolor="#3498DB">SALDO</th>
                                <th align="center" bgcolor="#3498DB">CAJA</th>
                                <th align="center" bgcolor="#3498DB">INGRESO</th>
                                <th align="center" bgcolor="#3498DB">SALDO</th>
                                <th align="center" bgcolor="#3498DB">Monto Imp.</th>
                                <th align="center" bgcolor="#3498DB">3.25 %</th>
                            </tr>';
                        foreach ($sum as $key => $m) {
                            
                            $fechaEntera = strtotime($m->aco_fecha_acop);
                            $anio = date("Y", $fechaEntera);
                            $mes = date("m", $fechaEntera);
                            $dia = date("d", $fechaEntera);

                            $nro = $nro+1; 
                            $neto=$m->aco_peso_neto;
                            $acum=$cant+$neto;

                            $num=$m->aco_cantidad;
                            $acumca=$cant1+$num;

                            $acumcacaja = $num*$m->aco_peso_neto;
                            $acumcacaja2 = $acumcacaja2 + $acumcacaja;

                            $tot=$m->aco_cos_total;
                            $acumtot=$cant2+$tot;


                            $egreso = $num*$m->aco_cos_un;
                            $acuegreso = $acuegreso + $egreso;

                            $imp = $egreso / 0.9675;

                            $reten = $imp * 3.25/100;
                           // echo($num);


                        $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                        <td align="center">'. $nro .'</td>
                        <td align="center">'.$m->prs_nombres.' '.$m->prs_paterno.'</td>';

                        if ($m->zona_id == 1) {
                            $html = $html.'<td align="center">'.$m->aco_num_rec.'</td>
                            <td align="center"></td>
                            <td align="center"></td>';
                        }elseif($m->zona_id == 2){
                            $html = $html . '<td align="center"></td>
                            <td align="center">'.$m->aco_num_rec.'</td>
                            <td align="center"></td>';
                        }elseif($m->zona_id == 3) {
                            $html = $html.'<td align="center"></td>
                        <td align="center"></td><td align="center">'.$m->aco_num_rec.'</td>';
                        }
                        $html = $html.'

                        <td align="center">' . $dia.'/'.$mes.'/'.$anio . '</td>
                        <td align="center">' . $m->com_nombre. '</td>
                        <td align="center">' . $m->mun_nombre . '</td>
                        <td align="center">' . $m->prov_nombre . ' '.$m->prov_ap.' '.$m->prov_am.'</td>';
                        if ($m->aco_id_tipo_cas == 1) {
                            $html = $html.'<td align="center">O</td>';
                        }else{
                            $html = $html.'<td align="center">C</td>';
                        }
                        $html = $html.'<td align="center">' .  $m->tprov_tipo . '</td>
                        <td align="center">' . $m->prov_id_convenio. '</td>
                        <td align="center">' . $m->prov_ci . ' '.$m->dep_exp.'</td>
                        <td align="center" color ="#337ab7">' . number_format($m->aco_cantidad,2,'.',','). '</td>
                        <td align="center">' . number_format($acumca,2,'.',',') . '</td>
                        <td align="center" color ="#337ab7">'.number_format($m->aco_peso_neto,2,'.',',').'</td>
                        <td align="center">' . number_format($acumcacaja,2,'.',',') . '</td>
                        <td align="center" color ="#337ab7">' . number_format($acumcacaja2,2,'.',',') . '</td>
                        <td align="center">' .  number_format($m->aco_cos_un,2,'.',',') . '</td>
                        <td align="center">'.number_format($egreso,2,'.',',').'</td>
                        <td align="center" color ="#337ab7">'.number_format($acuegreso,2,'.',',').'</td>
                        <td align="center">'.number_format($imp,2,'.',',').'</td>
                        <td align="center" color ="#337ab7">'.number_format($reten,2,'.',',').'</td>                       
                      </tr>';
                      $cant=$acum;
                      $cant1=$acumca;
                      $cant2=$acumtot;
            }
            $htmltable = $html . '</table>';

            // output the HTML content
             //PDF::writeHTML($htmltable, true, false, true, false, '');
           // $pdf->writeHTML($htmltable,true, false, true, false, '');
            $pdf->writeHTML($htmltable, true, false, true, false,'');


            // reset pointer to the last page
              
            $pdf->lastPage();

            // ---------------------------------------------------------

            //Close and output PDF document
            $pdf->Output('Acopio_Miel_Fondos_Avance.pdf', 'I');
        }
         
        elseif($idrol == 2 or $idrol == 13) {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetAuthor('EBA');
            $pdf->SetTitle('EBA');
            $pdf->SetSubject('ACOPIO ALMENDRA');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
            $id=Auth::user()->usr_id;
            // $result = \DB::select('select * from acopio.sp_sum_group(?)',array($id));
            // $sum = Collect($result);
            $zona = Usuario::join('public._bp_zonas as zona','public._bp_usuarios.usr_zona_id','=','zona.zona_id')
                    ->where('_bp_usuarios.usr_id','=',$id)->first();
            // dd($zona);
            ini_set('memory_limit','512M');
            set_time_limit(640);
            $sum = Acopio::join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('aco_id_usr','=',Auth::user()->usr_id)->where('acopio.aco_id_linea','=',1)
                            ->where('acopio.aco_estado','=','A')->get();
            // dd($sum);
            $cant=0;
            $cant1=0;
            $cant2=0;

            $nro = 0;
            // set font
            $pdf->SetFont('helvetica', '', 9);

            // add a page
            $pdf->AddPage('L', 'Carta');
            //PDF::AddPage();

            // create some HTML content

            $html = '   <table border="1" cellspacing="0" cellpadding="1">
                            <tr>
                                 <th align="center" width="160"><img src="/img/logopeqe.png" width="120" height="65"></th>
                                <th  width="660"><h1 align="center">REGISTROS DE ACOPIO <br>CASTA&Ntilde;A<br>COMPRADOR: '.$sum[0]->prs_nombres.' '.$sum[0]->prs_paterno.' '.$sum[0]->prs_materno.'</h1></th>
                                <th  width="160"><h3 align="center"><br>SERIE: <br>'.$zona->zona_serie.' - '.$zona->zona_nombre.'</h3></th>
                            </tr>
                        </table>
                        <br><br><br>
                        
                        <table border="1" cellspacing="0" cellpadding="1">
                            <tr>
                                <th align="center" bgcolor="#3498DB"><strong>Nro</strong></th>
                                <th align="center" bgcolor="#3498DB"><strong>Fecha</strong></th>
                                <th align="center" bgcolor="#3498DB"><strong>Nro Documento</strong></th>
                                <th align="center" bgcolor="#3498DB"><strong>Vendedor</strong></th>
                                <th align="center" bgcolor="#3498DB"><strong>Kg/Caja</strong></th>
                                <th align="center" bgcolor="#3498DB"><strong>Total Kg</strong></th>
                                <th align="center" bgcolor="#3498DB"><strong>Acumulado Kg</strong></th>
                                <th align="center" bgcolor="#3498DB"><strong>Total Cajas</strong></th>
                                <th align="center" bgcolor="#3498DB"><strong>Acumulado Cajas</strong></th>
                                <th align="center" bgcolor="#3498DB"><strong>Bs por Caja</strong></th>
                                <th align="center" bgcolor="#3498DB"><strong>Total Pagado Bs</strong></th>
                                <th align="center" bgcolor="#3498DB"><strong>Acumulado</strong></th>
                            </tr>';
                        foreach ($sum as $key => $m) {
                            $nro = $nro+1; 
                            $neto=$m->aco_peso_neto;
                            //$acum=$cant+$neto;
			    // $totalkilos = 23 * $m->aco_cantidad;
                            $totalkilos = $m->aco_peso_neto * $m->aco_cantidad; 
                            $acum=$cant+$totalkilos;

                            $num=$m->aco_cantidad;
                            $acumca=$cant1+$num;

                            $tot=$m->aco_cos_total;
                            $acumtot=$cant2+$tot;
                           // echo($num);

                $fecha = Carbon::parse($m->aco_fecha_acop);
                $mfecha = $fecha->month;
                $dfecha = $fecha->day;
                $afecha = $fecha->year;
                $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                        <td align="center">'. $nro .'</td>
                        <td align="center">'.$dfecha.'-'.$mfecha.'-'.$afecha.'</td>
                        <td align="center">'. $m->aco_num_rec .'</td>
                        <td align="center">' . $m->prov_ap .' '.$m->prov_am.' '.$m->prov_nombre.'</td>
                        <td align="center">' .$m->aco_peso_neto. '</td>
                        <td align="center">' . $totalkilos . '</td>
                        <td align="center" color ="#337ab7">' . $acum. '</td>
                        <td align="center">' . $m->aco_cantidad . '</td>
                        <td align="center" color ="#337ab7">' . $acumca . '</td>
                        <td align="center">' .  $m->aco_cos_un . '</td>
                        <td align="center">' .  number_format($m->aco_cos_total,2,'.',',') . '</td>
                        <td align="center" color ="#337ab7">' . number_format($acumtot,2,'.',',') . '</td>
                      </tr>';
                      $cant=$acum;
                      $cant1=$acumca;
                      $cant2=$acumtot;
            }
            $htmltable = $html . '</table>';

            $pdf->writeHTML($htmltable, true, 0, true, 0);


            // reset pointer to the last page
              
            $pdf->lastPage();

            // ---------------------------------------------------------

            //Close and output PDF document
            $pdf->Output('Acopio_Almendra.pdf', 'I');
        }

    }
    public function reporteAcopioZona()
    {
        $idrol=Session::get('ID_ROL');
        if($idrol == 13){

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetAuthor('EBA');
            $pdf->SetTitle('EBA');
            $pdf->SetSubject('ACOPIO ALMENDRA');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }


            ini_set('memory_limit','512M');
            set_time_limit(640);
            $zona = Usuario::join('public._bp_zonas as zona','public._bp_usuarios.usr_zona_id','=','zona.zona_id')
                            ->where('public._bp_usuarios.usr_id','=',Auth::user()->usr_id)
                            ->first();

            $sum = Acopio::join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->join('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)
                            ->where('acopio.aco_estado','=','A')
                            // ->where('per.prs_id_zona','=',$zona->prs_id_zona)
                            ->where('usu.usr_zona_id',$zona->zona_id)
                            ->where('prov_estado','=','A')->get();
            // dd($sum);
            $cant=0;
            $cant1=0;
            $cant2=0;

            $acumcacaja2 = 0;
            $acuegreso = 0;

            $nro = 0;

            $pdf->SetFont('helvetica', '', 9);

            $pdf->AddPage('L', 'Carta');
         

            $html = '   <table border="1" cellspacing="0" cellpadding="1">
                            <tr>
                                 <th align="center" width="160"><img src="/img/logopeqe.png" width="120" height="65"></th>
                                <th  width="660"><h1 align="center">COMPRA CASTA&Ntilde;A<br> EN CASCARA</h1></th>
                                <th  width="160"><h3 align="center"><br>REVISION</h3></th>
                            </tr>
                        </table>
                        <br><br><br>
                        
                        <table border="1" cellspacing="0" cellpadding="1" style="font-size:8px">
                            <tr>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="25"><strong>Nro</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="50"><strong>Comprador</strong></th>
                                <th colspan="3" align="center" bgcolor="#3498DB" width="100"><strong>Nro Documento</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="45"><strong>Fecha</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="50"><strong>Comunidad</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="50"><strong>Municipio</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="50"><strong>Nombres</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="40"><strong>Tipo Casta&ntilde;a</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="60"><strong>Comun.</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="25"><strong>Conv.</strong></th>
                                <th rowspan="2" align="center" bgcolor="#3498DB" width="50"><strong>Nro CI.</strong></th>
                                <th colspan="1" align="center" bgcolor="#3498DB" width="50"><strong>En cajas</strong></th>
                                <th colspan="1" align="center" bgcolor="#3498DB" width="50"><strong>C. Acum.</strong></th>
                                <th colspan="1" align="center" bgcolor="#3498DB" width="50"><strong>Peso KG</strong></th>
                                <th colspan="2" align="center" bgcolor="#3498DB" width="80"><strong>En Kilogramos</strong></th>
                                <th colspan="1" align="center" bgcolor="#3498DB" width="40"><strong>Precio</strong></th>
                                <th colspan="2" align="center" bgcolor="#3498DB" width="80"><strong>EN BOLIVIANOS</strong></th>
                                <th colspan="2" align="center" bgcolor="#3498DB" width="75"><strong>RETENCIONES</strong></th>
                            </tr>
                            <tr>                                
                                <th align="center" bgcolor="#3498DB">Serie A</th>
                                <th align="center" bgcolor="#3498DB">Serie B</th>
                                <th align="center" bgcolor="#3498DB">Serie C</th>
                                <th align="center" bgcolor="#3498DB">INGRESO</th>
                                <th align="center" bgcolor="#3498DB">SALDO</th>
                                <th align="center" bgcolor="#3498DB">CAJA</th>
                                <th align="center" bgcolor="#3498DB">INGRESO</th>
                                <th align="center" bgcolor="#3498DB">SALDO</th>
                                <th align="center" bgcolor="#3498DB">CAJA</th>
                                <th align="center" bgcolor="#3498DB">INGRESO</th>
                                <th align="center" bgcolor="#3498DB">SALDO</th>
                                <th align="center" bgcolor="#3498DB">Monto Imp.</th>
                                <th align="center" bgcolor="#3498DB">3.25 %</th>
                            </tr>';
                        foreach ($sum as $key => $m) {
                            
                            $fechaEntera = strtotime($m->aco_fecha_acop);
                            $anio = date("Y", $fechaEntera);
                            $mes = date("m", $fechaEntera);
                            $dia = date("d", $fechaEntera);

                            $nro = $nro+1; 
                            $neto=$m->aco_peso_neto;
                            $acum=$cant+$neto;

                            $num=$m->aco_cantidad;
                            $acumca=$cant1+$num;

                            $acumcacaja = $num*$m->aco_peso_neto;
                            $acumcacaja2 = $acumcacaja2 + $acumcacaja;

                            $tot=$m->aco_cos_total;
                            $acumtot=$cant2+$tot;


                            $egreso = $num*$m->aco_cos_un;
                            $acuegreso = $acuegreso + $egreso;

                            $imp = $egreso / 0.9675;

                            $reten = $imp * 3.25/100;
                           // echo($num);


                        $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                        <td align="center">'. $nro .'</td>
                        <td align="center">'.$m->prs_nombres.' '.$m->prs_paterno.'</td>';

                        if ($m->prs_id_zona == 'A - RIBERALTA') {
                            $html = $html.'<td align="center">'.$m->aco_num_rec.'</td>
                            <td align="center"></td>
                            <td align="center"></td>';
                        }elseif($m->prs_id_zona == 'B - EL SENA'){
                            $html = $html . '<td align="center"></td>
                            <td align="center">'.$m->aco_num_rec.'</td>
                            <td align="center"></td>';
                        }else {
                            $html = $html.'<td align="center"></td>
                        <td align="center"></td><td align="center">'.$m->aco_num_rec.'</td>';
                        }
                        $html = $html.'

                        <td align="center">' . $dia.'/'.$mes.'/'.$anio . '</td>
                        <td align="center">' . $m->com_nombre. '</td>
                        <td align="center">' . $m->mun_nombre . '</td>
                        <td align="center">' . $m->prov_nombre . ' '.$m->prov_ap.' '.$m->prov_am.'</td>';
                        if ($m->aco_id_tipo_cas == 1) {
                            $html = $html.'<td align="center">O</td>';
                        }else{
                            $html = $html.'<td align="center">C</td>';
                        }
                        $html = $html.'<td align="center">' .  $m->tprov_tipo . '</td>
                        <td align="center">' . $m->prov_id_convenio. '</td>
                        <td align="center">' . $m->prs_ci . '</td>
                        <td align="center" color ="#337ab7">' . number_format($m->aco_cantidad,2,'.',','). '</td>
                        <td align="center">' . number_format($acumca,2,'.',',') . '</td>
                        <td align="center" color ="#337ab7">'.number_format($m->aco_peso_neto,2,'.',',').'</td>
                        <td align="center">' . number_format($acumcacaja,2,'.',',') . '</td>
                        <td align="center" color ="#337ab7">' . number_format($acumcacaja2,2,'.',',') . '</td>
                        <td align="center">' .  number_format($m->aco_cos_un,2,'.',',') . '</td>
                        <td align="center">'.number_format($egreso,2,'.',',').'</td>
                        <td align="center" color ="#337ab7">'.number_format($acuegreso,2,'.',',').'</td>
                        <td align="center">'.number_format($imp,2,'.',',').'</td>
                        <td align="center" color ="#337ab7">'.number_format($reten,2,'.',',').'</td>                       
                      </tr>';
                      $cant=$acum;
                      $cant1=$acumca;
                      $cant2=$acumtot;
            }
            $htmltable = $html . '</table>';


            $pdf->writeHTML($htmltable, true, 0, true, 0);



              
            $pdf->lastPage();

            $pdf->Output('Acopio_Miel_Fondos_Avance2.pdf', 'I');
        }
    }


     public function reporteAcopioExcel()
    {
        $idrol=Session::get('ID_ROL');

        if($idrol == 1 or $idrol == 3 or $idrol == 9 or $idrol == 13)
        {
        ini_set('memory_limit','512M');
            set_time_limit(640);
        $sum = Acopio::join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')->orderBy('aco_fecha_acop','ASC')->get();
        Excel::create('Acopios Almendra', function($excel) use ($sum) {
            
            
            // dd($tamanoCelda); 
            // $excel->setTitle('Our new awesome title');       
            $excel->sheet('Acopio', function($sheet) use (&$sum) {
                $sheet->loadView('backend.administracion.acopio.acopio_almendra.gbReportes.acopioExcel');
                // $sheet->setMergeColumn(array(
                //     'columns' => array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W'),
                //     'rows' => array(
                //         array(1,5),
                //     )
                // ));

                // $tamanoCelda = count($sum) + 6 ;
                // $sheet->setBorder('A6:W'.$tamanoCelda, 'thin');
                // $sheet->setFontFamily('Comic Sans MS');
                
                // $sheet->setStyle(array(
                //     'font' => array(
                //         'name'      =>  'Arial',
                //         'size'      =>  12,
                //         'bold'      =>  true,
                //         'text-align'=> 'center',
                //     )
                // ));
                // $sheet->setWidth(array(
                //     'A'     =>  5,
                //     'B'     =>  20,
                //     'c'     =>  8,
                //     'D'     =>  8,
                //     'E'     =>  8,
                //     'F'     =>  8,
                //     'G'     =>  18,
                //     'H'     =>  18,
                //     'I'     =>  20,
                //     'J'     =>  3,
                //     'K'     =>  18,
                //     'L'     =>  3,
                //     'M'     =>  8,
                //     'N'     =>  10,
                //     'O'     =>  10,
                //     'P'     =>  10,
                //     'Q'     =>  10,
                //     'R'     =>  10,
                //     'S'     =>  10,
                //     'T'     =>  10,
                //     'V'     =>  10,
                //     'W'     =>  10                    
                // ));
            
                // $sheet->row(6, [
                //     'Nro', 'Comprador', 'Nro Doc. serie A', 'Nro Doc. serie B', 'Nro Doc. serie C', 'Fecha', 'Comunidad','Municipio','Nombres','Tipo Castania','Comun.','Conv','Nro CI','En cajas INGRESO','C. Acum. SALDO','Peso KG CAJA','En KG. INGRESO','En KG. SALDO','Precio CAJA','En Bs. INGRESO','En Bs. SALDO','RETENCIONES Monto Imp.','RETENCIONES 3.25 %'
                // ]);
                // $sheet->row(6, function($row) {
                //     $row->setBackground('#186BBA');    
                // });
                // $cant=0;
                // $cant1=0;
                // $cant2=0;
                // $acumcacaja2 = 0;
                // $acuegreso = 0;
                // $nro = 0;
                // foreach($sum as $m => $su):
                //     $nro = $nro+1;
                //     $fechaEntera = strtotime($su->aco_fecha_acop);
                //     $anio = date("Y", $fechaEntera);
                //     $mes = date("m", $fechaEntera);
                //     $dia = date("d", $fechaEntera);
                //     $neto=$su->aco_peso_neto;
                //     $acum=$cant+$neto;
                //     $num=$su->aco_cantidad;
                //     $acumca=$cant1+$num;
                //     $acumcacaja = $num*$su->aco_peso_neto;
                //     $acumcacaja2 = $acumcacaja2 + $acumcacaja;
                //     $tot=$su->aco_cos_total;
                //     $acumtot=$cant2+$tot;
                //     $egreso = $num*$su->aco_cos_un;
                //     $acuegreso = $acuegreso + $egreso;
                //     $imp = $egreso / 0.9675;
                //     $reten = $imp * 3.25/100; 
                //     $sheet->row($m+7, [ 
                //         $nro,
                //         $su->prs_nombres.' '.$su->prs_paterno,
                //         $su->zona_id == 1 ? $su->aco_num_rec : '',
                //         $su->zona_id == 2 ? $su->aco_num_rec : '',
                //         $su->zona_id == 3 ? $su->aco_num_rec : '',
                //         $dia.'/'.$mes.'/'.$anio,
                //         $su->com_nombre,
                //         $su->mun_nombre,
                //         $su->prov_nombre.' '.$su->prov_ap.' '.$su->prov_am,
                //         $su->aco_id_tipo_cas == 1 ? '0' : 'C',
                //         // if ($m->aco_id_tipo_cas == 1) {
                //         //     $html = $html.'<td align="center">O</td>';
                //         // }else{
                //         //     $html = $html.'<td align="center">C</td>';
                //         // }
                //         $su->tprov_tipo,
                //         $su->prov_id_convenio,
                //         $su->prov_ci.' '.$su->dep_exp,
                //         number_format($su->aco_cantidad,2,'.',','),
                //         number_format($acumca,2,'.',','),
                //         number_format($su->aco_peso_neto,2,'.',','),
                //         number_format($acumcacaja,2,'.',','),
                //         number_format($acumcacaja2,2,'.',','),
                //         number_format($su->aco_cos_un,2,'.',','),
                //         number_format($egreso,2,'.',','),
                //         number_format($acuegreso,2,'.',','),
                //         number_format($imp,2,'.',','),
                //         number_format($reten,2,'.',','),
                        
                        
                //     ]);
                //     $cant=$acum;
                //     $cant1=$acumca;
                //     $cant2=$acumtot;
                // endforeach;
         
        });
         
        })->export('xlsx');
      }
    }
   public function reporteRecursos()
    {
      $idrol=Session::get('ID_ROL');
      ini_set('memory_limit','512M');
      set_time_limit(640);
      if($idrol == 2 or $idrol == 13)
      {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('EBA');
        $pdf->SetSubject('ACOPIO ALMENDRA');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
        $id=Auth::user()->usr_id;
        $zona = Usuario::join('public._bp_zonas as zona','public._bp_usuarios.usr_zona_id','zona.zona_id')
                ->where('usr_id','=',$id)->first();
        // dd($zona);
        // $asig = Movimiento_Recursos::where('movrec_id_usr','=',Auth::user()->usr_id)->orderBy('movrec_id', 'asc')->get();
        $asig = Movimiento_Recursos::where('movrec_id_usr','=',Auth::user()->usr_id)->orderBy('movrec_id', 'asc')->where('movrec_estado','=','A')->get();
        // dd($asig);
        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')
                    ->join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        // dd($sum);
        

        $nro = 0;
        // set font
        $pdf->SetFont('helvetica', '', 9);

        // add a page
        $pdf->AddPage('L', 'Carta');
        //PDF::AddPage();

        // create some HTML content
        
        $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="160"><img src="/img/logopeqe.png" width="120" height="65"></th>
                            <th  width="660"><h1 align="center">REGISTRO DE RECURSOS (EFECTIVO)<br>PARA ACOPIO<br>COMPRADOR: '.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</h1></th>
                            <th  width="160"><h3 align="center"><br>SERIE: <br>'.$zona->zona_serie.' - '.$zona->zona_nombre.'<br></h3></th>
                        </tr>
                    </table>
                    <br><br><br>
                    
                    <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>Fecha</strong></th>
                            <th align="center" bgcolor="#3498DB" width="60"><strong>Nro Documento</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150"><strong>Detalle</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>Ingreso</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>Pagos</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>Saldo</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150"><strong>Funcionario Responsable de Control</strong></th>
                            <th align="center" bgcolor="#3498DB" width="130"><strong>Observaciones</strong></th>
                            
                        </tr>';
                    $saldo = 0;
                    foreach ($asig as $key => $m) {
                        $nro = $nro+1;
                       
                        if ($m->movrec_id_asignacion == 0) {
                             
                            $aco = Acopio::where('aco_id','=', $m->movrec_id_aco)->where('aco_estado','=','A')->get();
                            // dd($aco);
                            if ($aco->isEmpty()) {
                                
                            } else{
                                $saldo = $saldo - $aco[0]->aco_cos_total;
                                $fecha = Carbon::parse($aco[0]->aco_fecha_reg);
                                $mfecha = $fecha->month;
                                $dfecha = $fecha->day;
                                $afecha = $fecha->year;    
                                $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                        <td align="center">'. $nro .'</td>
                                        <td align="center">'.$dfecha.'-'.$mfecha.'-'.$afecha.'</td>
                                        <td align="center">'. $aco[0]->aco_num_rec .'</td>
                                        <td align="center">'.$aco[0]->aco_obs.'</td>
                                        <td align="right">'.number_format($m->movrec_ingreso,2,'.',',').'</td>
                                        <td align="right">' . number_format($aco[0]->aco_cos_total,2,'.',',') . '</td>
                                        <td align="right" color ="#337ab7">' . number_format($saldo,2,'.',','). '</td>
                                        <td align="center">'.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</td>
                                        <td align="center" color ="#337ab7">-</td>
                                      </tr>';
                            }

                        }else{
                            $saldo = $saldo + $m->movrec_ingreso;
                            $fecha = Carbon::parse($m->movrec_fecha_mov);
                            $mfecha = $fecha->month;
                            $dfecha = $fecha->day;
                            $afecha = $fecha->year;                                               
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">'. $nro .'</td>
                                    <td align="center">'.$dfecha.'-'.$mfecha.'-'.$afecha.'</td>
                                    <td align="center"></td>
                                    <td align="center">Asig</td>
                                    <td align="right">'.number_format($m->movrec_ingreso,2,'.',',').'</td>
                                    <td align="right">' . number_format($m->movrec_egreso,2,'.',',') . '</td>
                                    <td align="right" color ="#337ab7">' . number_format($saldo,2,'.',','). '</td>
                                    <td align="center">'.$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno.'</td>
                                    <td align="center" color ="#337ab7">-</td>
                                  </tr>';
                        }
                                  
                    }
                    $htmltable = $html . '</table>';

        // output the HTML content
         //PDF::writeHTML($htmltable, true, false, true, false, '');
       // $pdf->writeHTML($htmltable,true, false, true, false, '');
        $pdf->writeHTML($htmltable, true, 0, true, 0);


        // reset pointer to the last page
          
        $pdf->lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Acopio_Movimiento_recursos.pdf', 'I');

    } elseif($idrol == 1 or $idrol = 3 or $idrol == 9){
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetAuthor('EBA');
        $pdf->SetTitle('EBA');
        $pdf->SetSubject('ACOPIO ALMENDRA');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
        $id=Auth::user()->usr_id;
        $zona = Usuario::join('public._bp_zonas as zona','public._bp_usuarios.usr_zona_id','zona.zona_id')
                ->where('usr_id','=',$id)->first();
        // dd($zona);
        // $asig = Movimiento_Recursos::where('movrec_id_usr','=',Auth::user()->usr_id)->orderBy('movrec_id', 'asc')->get();
        $asig = Movimiento_Recursos::where('movrec_id_usr','=',Auth::user()->usr_id)->orderBy('movrec_id', 'asc')->where('movrec_estado','=','A')->get();
        // dd($asig);
        $usuario = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')
                    ->join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        // dd($sum);
        $usuarioComprador = Usuario::join('public._bp_personas as persona','public._bp_usuarios.usr_prs_id','=','persona.prs_id')
                            ->join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->join('public._bp_zonas as zona','public._bp_usuarios.usr_zona_id','=','zona_id')
                            ->join('public._bp_usuarios_roles  as roles','public._bp_usuarios.usr_id','roles.usrls_usr_id')
                            ->where('usr_estado','=','A')->where('usr_linea_trabajo','=',1)->where('roles.usrls_rls_id','=',2)->get();
         // dd($usuarioComprador);
        
        // set font
        $pdf->SetFont('helvetica', '', 9);

        // add a page
        $pdf->AddPage('L', 'Carta');
        //PDF::AddPage();
        $txt = 'REPORTE GENERAL TODOS LOS COMPRADORES';

        // print a block of text using Write()
        $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
        
        
        // create some HTML content
        foreach($usuarioComprador as $comprador){
            $asigComprador = Movimiento_Recursos::where('movrec_id_usr','=',$comprador->usr_id)->orderBy('movrec_id', 'asc')->where('movrec_estado','=','A')->get();

            $html = '   <table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                             <th align="center" width="160"><img src="/img/logopeqe.png" width="120" height="65"></th>
                            <th  width="660"><h1 align="center">REGISTRO DE RECURSOS (EFECTIVO)<br>PARA ACOPIO<br>COMPRADOR: '.$comprador->prs_nombres.' '.$comprador->prs_paterno.' '.$comprador->prs_materno.'</h1></th>
                            <th  width="160"><h3 align="center"><br>SERIE: <br>'.$comprador->zona_serie.' - '.$comprador->zona_nombre.'<br></h3></th>
                        </tr>
                    </table>
                    <br>';
                    
             $html = $html.'<table border="1" cellspacing="0" cellpadding="1">
                        <tr>
                            <th align="center" bgcolor="#3498DB" width="50"><strong>Nro</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>Fecha</strong></th>
                            <th align="center" bgcolor="#3498DB" width="60"><strong>Nro Documento</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150"><strong>Detalle</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>Ingreso</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>Pagos</strong></th>
                            <th align="center" bgcolor="#3498DB"><strong>Saldo</strong></th>
                            <th align="center" bgcolor="#3498DB" width="150"><strong>Funcionario Responsable de Control</strong></th>
                            <th align="center" bgcolor="#3498DB" width="130"><strong>Observaciones</strong></th>
                            
                        </tr>';
                    $saldo = 0;
                    $nro = 0;
                    foreach ($asigComprador as $key => $m) {
                        $nro = $nro+1;
                       
                        if ($m->movrec_id_asignacion == 0) {
                             
                            $aco = Acopio::where('aco_id','=', $m->movrec_id_aco)->get();
                             // dd($aco);
                            $saldo = $saldo - $aco[0]->aco_cos_total;
                            $fecha = Carbon::parse($aco[0]->aco_fecha_reg);
                            $mfecha = $fecha->month;
                            $dfecha = $fecha->day;
                            $afecha = $fecha->year;    
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">'. $nro .'</td>
                                    <td align="center">'.$dfecha.'-'.$mfecha.'-'.$afecha.'</td>
                                    <td align="center">'. $aco[0]->aco_num_rec .'</td>
                                    <td align="center">'.$aco[0]->aco_obs.'</td>
                                    <td align="right">'.number_format($m->movrec_ingreso,2,'.',',').'</td>
                                    <td align="right">' . number_format($aco[0]->aco_cos_total,2,'.',',') . '</td>
                                    <td align="right" color ="#337ab7">' . number_format($saldo,2,'.',','). '</td>
                                    <td align="center">'.$comprador->prs_nombres.' '.$comprador->prs_paterno.' '.$comprador->prs_materno.'</td>
                                    <td align="center" color ="#337ab7">-</td>
                                  </tr>';

                        }else{
                            $saldo = $saldo + $m->movrec_ingreso;
                            $fecha = Carbon::parse($m->movrec_fecha_mov);
                            $mfecha = $fecha->month;
                            $dfecha = $fecha->day;
                            $afecha = $fecha->year;                                               
                            $html = $html . '<tr align="center" BGCOLOR="#f3f0ff">
                                    <td align="center">'. $nro .'</td>
                                    <td align="center">'.$dfecha.'-'.$mfecha.'-'.$afecha.'</td>
                                    <td align="center"></td>
                                    <td align="center">Asig</td>
                                    <td align="right">'.number_format($m->movrec_ingreso,2,'.',',').'</td>
                                    <td align="right">' . number_format($m->movrec_egreso,2,'.',',') . '</td>
                                    <td align="right" color ="#337ab7">' . number_format($saldo,2,'.',','). '</td>
                                    <td align="center">'.$comprador->prs_nombres.' '.$comprador->prs_paterno.' '.$comprador->prs_materno.'</td>
                                    <td align="center" color ="#337ab7">-</td>
                                  </tr>';
                        }
                                 
                    }
                    
                    $htmltable = $html . '</table><br><br><br><br><br>';

                        // output the HTML content
                         //PDF::writeHTML($htmltable, true, false, true, false, '');
                       // $pdf->writeHTML($htmltable,true, false, true, false, '');
                    $pdf->writeHTML($htmltable, true, 0, true, 0);
                    // $pdf->lastPage();
                    $pdf->AddPage(); 
        
        }
        $pdf->Output('Acopio_Movimiento_recursos.pdf', 'I');
    }
  }      
}
