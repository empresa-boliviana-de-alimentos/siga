<?php

namespace siga\Http\Controllers\acopio\acopio_frutos;

use Illuminate\Http\Request;
use siga\Http\Requests;
use siga\Modelo\admin\Persona;
use siga\Modelo\admin\Usuario;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_frutos\ProveedorF;
use siga\Modelo\acopio\acopio_frutos\AcopioRF;
use siga\Modelo\acopio\acopio_frutos\TipoFruta;
use siga\Modelo\acopio\acopio_frutos\Acopio;

use Auth;
use PDF;

class AcopioFrutosController extends Controller
{
    public function index()
    {
        $fruta = TipoFruta::combo();
    	$proveedor=ProveedorF::orderBy('prov_id','DESC')->paginate(10);
        $usuario = Usuario::OrderBy('usr_id', 'desc');
        $data  = ProveedorF::combo();
        $user =  Auth::user()->usr_id;

    	return view('backend.administracion.acopio.acopio_frutos.acopio.index',compact('data','proveedor', 'usuario', 'fruta', 'user'));
    }
    public function create()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)
                            ->first(); 
        $proveedor= AcopioRF::join('acopio.proveedor as prov', 'acopio.det_acop_ca.dac_id_prov','=','prov.prov_id')
                          ->join('public._bp_planta as pla', 'acopio.det_acop_ca.dac_id_planta', '=', 'pla.id_planta')
                          ->where('dac_id_planta', $planta['id_planta'])->orderBydesc('dac_id')->get();
     // $proveedor = ProveedorF::getListar();
        // $proveedor = ProveedorF::where('prov_estado', 'A')
        //                        ->where('prov_id_linea',4)
        //                        // ->where('prov_id_usr',$usr = Auth::user()->usr_id)
        //                        ->OrderBy('prov_id', 'desc')
        //                        ->get();
        return Datatables::of($proveedor)->addColumn('acciones', function ($proveedor) {
          //dac_estado A = Para registrar, B = De baja, C = registrado y mostrar 
          if($proveedor->dac_estado == 'A')
          {
            return '<button value="' . $proveedor->dac_id . '" class="btn btn-success" onClick="MostrarProveedor2(this);" data-toggle="modal" data-target="#myCreateRepFruto" style="width:120px;">REGISTRAR</button>';
          }
          if($proveedor->dac_estado == 'C')
          {
            return '<button value="' . $proveedor->dac_id . '" class="btn btn-primary btn-sm glyphicon glyphicon-eye-open" style="background:#ff9d56; width:80px" onClick="MostrarProveedor2(this);" data-toggle="modal" data-target="#myCreateRepFruto" style="width:120px;">VER</button>';
          }

            /*<button value="' . $proveedor->dac_id. '" class="btn btn-primary" style="background:#512E5F; width:120px;" onClick="lstacopiofru(this);" data-toggle="modal" data-target="#myListar">LISTAR</button>*/
        })
           ->editColumn('id', 'ID: {{$prov_id}}')
           -> addColumn('nombreCompleto', function ($nombres) {
            return $nombres->prov_nombre . ' ' . $nombres->prov_ap . ' ' . $nombres->prov_am;
        })
            ->make(true);
       }
       public function lstAcopiosProvfrut($id)
        {
         // return $id;
        $usr = Auth::user()->usr_id;
        $regacopio = AcopioRF::where('dac_estado','A')  
            ->where('dac_id_linea',4)
            ->where('dac_id_prov',$id)
         //   ->where('dac_id_rec', $usr)
            ->orderBy('dac_id','ASC')
            ->get();  
        return Datatables::of($regacopio)
        ->editColumn('id', 'ID: {{$dac_id}}')
        ->addColumn('total', function ($total) {
            return $total->dac_cantaprob * $total->dac_preciofru;

        })
        ->addColumn('acciones', function ($acciones) {
            return '<a type="button"  class="btn btn-danger" href="/BoletaFruta/' . $acciones->dac_id . '"><span class="fa fa-file-pdf-o" ></span></a>';

        })
            ->make(true);      
    }


    public function store(Request $request)
    {
        $fecha1=date('d/m/Y');
        AcopioRF::create([
       /*     'dac_id_prov'          => $request['cod_prov'],
            'dac_id_tipofru'       => $request['aco_id_tipofru'],
            'dac_fecha_acop'       => $fecha1,
            'dac_tot_descartefru'  => $request['aco_descartefru'],
            'dac_calibrefru'       => $request['aco_calibrefru'],
            'dac_ramhojafru'       => $request['aco_ramhojafru'],
            'dac_infestfru'        => $request['aco_infestfru'],
            'dac_dañadosfru'       => $request['aco_dañadosfru'],
            'dac_extrañosfru'      => $request['aco_extrañosfru'], 
            'dac_estado'           => 1, 
            'dac_fecha_reg'        => $fecha1, 
            'dac_cant_uni'         => $request['aco_cant_uni'],
            'dac_id_linea'         => 4,
            'dac_lotefru'          => $request['aco_lotefru'],
            'dac_preciofru'        => $request['aco_preciofru'],
            'dac_nomchofer'        => $request['aco_nomchofer'],
            'dac_placa'            => $request['aco_placa'],
            'dac_cantaprob'        => $request['aco_cantaprob'],
            'dac_olor'             => $request['aco_olor'],
            'dac_id_rec'           => Auth::user()->usr_id, 
            'dac_id_acopio'        => $request['idaco'],
            'dac_id_planta'        => $request['planta'],*/
        ]);
        return response()->json(['Mensaje' => 'El acopio no fueron registrado']);
    }


    public function storeFruta(Request $request)
    {
       /* $fruta= strtoupper(urldecode(stripslashes($request['tipfr_nombre']))); 
        $comparar = TipoFruta::where('tipfr_nombre','=',$fruta)->first();*/
        $fecha1=date('d/m/Y');

     //   if (empty($comparar['tipfr_nombre'])){ 
             TipoFruta::create([
            'tipfr_nombre'          => $request['tipfr_nombre'],
            'tipfr_estado'          => 'A',
            'tipfr_fecha_reg'       => $fecha1,           
        ]);
       // } 
        /*else {
         return "La fruta que ha intentado ingresar ya se encuentra en la base de datos"; 
            $this->validate(request(), [
                'tipfr_nombre' => 's',    
            ]); 
        }*/
        return response()->json(['Mensaje' => 'El acopio no fueron registrado']);
    }

    public function edit($id)
    {
        // $proveedor = ProveedorF::setBuscar($id);
        // return response()->json($proveedor);
        $aco = AcopioRF::setBuscar1($id);
        return response()->json($aco);
    }

     public function update(Request $request, $id)
    {
        $aco = AcopioRF::setBuscarmod($id);
        $aco->fill($request->all());
        $aco->save();
        return response() -> json($aco -> toArray());
       // return response()->json(['mensaje' => 'Se actualizo el proveedor']);
    }

    public function boleta($id)
    {
       $boleta = AcopioRF::setBuscar($id);
       $nombre = Usuario::setNombreFru($id);
       $asig=Collect($nombre);

           PDF::AddPage();

           PDF::SetFont('helvetica','B',12);
           PDF::Ln(5); 
           PDF::Cell(45,0,'',0,1,'C');
           PDF::Cell(45,20,PDF::Image('img/logopeqe.png',13,18,'R',25),1,0,'C');

           PDF::MultiCell(95, 20, '', 1, 0, 0, 'L');
           PDF::SetXY(60, 20);
           PDF::Cell(95,10,utf8_decode('BOLETA DE ACOPIO'),0,1,'C',0);
           PDF::SetXY(60, 30);
           PDF::Cell(95,10,utf8_decode('POR COMPRA DE FRUTO'),0,1,'C',0);

           PDF::SetFont('helvetica','B',9);
           PDF::SetXY(150, 20);
           PDF::Cell(45,20, utf8_decode('COPIA PLANTA'),1,1,'C',0);
           PDF::SetXY(150, 30);

            PDF::SetXY(15, 50);
            PDF::Cell(49,7,'Nombre Proveedor:',0,0,'L',0);
            PDF::SetXY(47, 50);
            PDF::writeHTML('',PDF::Cell(0,7,$boleta['prov_nombre'].' '.$boleta['prov_ap'].' '.$boleta['prov_am'],0,1,'L',0), true, true, false, '');
           

            PDF::SetXY(15, 60);
            PDF::Cell(49,7,'Fecha Acopio:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(38, 60);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['dac_fecha_acop'],0,1,'L',0), true, true, false, '');
            

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 70);
            PDF::Cell(49,7,'Tipo Fruta:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(31, 70);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['tipfr_nombre'],0,1,'L',0), true, true, false, '');

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 70);
            PDF::Cell(49,7,'Lote:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(90, 70);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['dac_lotefru'],0,1,'L',0), true, true, false, '');


            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 80);
            PDF::Cell(40,8,'Cantidad Recepcionada:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(49 , 80);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['dac_cant_uni'],0,1,'L',0), true, true, false, '');
            

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 80);
            PDF::Cell(49,7,'Total Descarte:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(102 , 80);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['dac_tot_descartefru'],0,1,'L',0), true, true, false, '');

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(140, 80);
            PDF::Cell(49,7,'Cant. Total Acopio:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(170 , 80);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['dac_cantaprob'],0,1,'L',0), true, true, false, '');


            PDF::Ln(30);
            PDF::SetFont('helvetica','B',7);
            PDF::SetXY(25, 130);
            PDF::Cell(70,6,utf8_decode('Recibi Conforme (Proveedor)'),0,1,'C',0);
            PDF::SetXY(10, 135);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
           PDF::writeHTML('',PDF::Cell(15,6,$boleta['prov_nombre'].' '.$boleta['prov_ap'].' '.$boleta['prov_am'],0,1,'L',0), true, true, false, '');
          
            PDF::SetXY(15, 140);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(45,6,$boleta['prov_ci'],0,1,'L',0), true, true, false, '');
            //$pdf->Cell(45,6,'',0,1,'L',0);

            PDF::SetXY(125, 130);
            PDF::Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            PDF::SetXY(120, 135);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(15,6,$asig['prs_nombres'].' '.$asig['prs_paterno'].' '.$asig['prs_materno'],0,1,'L',0), true, true, false, '');
          
            PDF::SetXY(120, 140);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(45,6,$asig['prs_ci'],0,1,'L',0), true, true, false, '');

            PDF::Line(35, 128, 85, 128); 
            PDF::Line(135, 128,186, 128); 
            

        ///////////// BOLETA PROVEEDOR ////////////////////

           PDF::SetFont('helvetica','B',12);
           PDF::Ln(4); 
           PDF::Cell(45,0,'',0,1,'C');
           PDF::Cell(45,20,PDF::Image('img/logopeqe1.png',13,152,'',25),1,0,'C');
           // PDF::Cell(45,20,PDF::Image('img/email/logosedem1.png',23,157,'',15),1,0,'C');

           PDF::MultiCell(95, 20, '', 1, 0, 0, 'L');
           PDF::SetXY(100, 155);
           PDF::Cell(10,10,utf8_decode('BOLETA DE ACOPIO'),0,1,'C',0);
           PDF::SetXY(100, 163);
           PDF::Cell(10,10,utf8_decode('POR COMPRA DE FRUTO'),0,1,'C',0);

           PDF::SetFont('helvetica','B',9);
           PDF::SetXY(150,155);
           PDF::Cell(45,20, utf8_decode('COPIA PROVEEDOR'),1,1,'C',0);
           PDF::SetXY(150,95);
          

            PDF::SetXY(15, 185);
            PDF::Cell(49,7,'Nombre Proveedor:',0,0,'L',0);
            PDF::SetXY(47, 185);
            PDF::writeHTML('',PDF::Cell(0,7,$boleta['prov_nombre'].' '.$boleta['prov_ap'].' '.$boleta['prov_am'],0,1,'L',0), true, true, false, '');

            PDF::SetXY(15, 195);
            PDF::Cell(49,7,'Fecha Acopio:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(38, 195);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['dac_fecha_acop'],0,1,'L',0), true, true, false, '');

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 205);
            PDF::Cell(49,7,'Tipo Fruta:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(31, 205);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['tipfr_nombre'],0,1,'L',0), true, true, false, '');

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 205);
            PDF::Cell(49,7,'Lote:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(90, 205);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['dac_lotefru'],0,1,'L',0), true, true, false, '');


            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 215);
            PDF::Cell(40,8,'Cantidad Recepcionada:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(49 , 215);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['dac_cant_uni'],0,1,'L',0), true, true, false, '');

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 215);
            PDF::Cell(49,7,'Total Descarte:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(102 , 215);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['dac_tot_descartefru'],0,1,'L',0), true, true, false, '');


            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(140, 215);
            PDF::Cell(49,7,'Cant. Total Acopio:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(170 , 215);
            PDF::writeHTML('',PDF::Cell(131,7,$boleta['dac_cantaprob'],0,1,'L',0), true, true, false, '');


            PDF::Ln(60);
            PDF::SetFont('helvetica','B',7);
            /*$pdf->SetXY(75, 199);
            $pdf->Cell(68,6,utf8_decode('Entregue Conforme'),0,1,'C',0);*/
            PDF::SetXY(25, 255);
            PDF::Cell(70,6,utf8_decode('Recibi Conforme (Proveedor)'),0,1,'C',0);
            PDF::SetXY(10, 260);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(15,6,$boleta['prov_nombre'].' '.$boleta['prov_ap'].' '.$boleta['prov_am'],0,1,'L',0), true, true, false, '');


            PDF::SetXY(15, 265);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(45,6,$boleta['prov_ci'],0,1,'L',0), true, true, false, '');

            PDF::SetXY(125, 255);
            PDF::Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            PDF::SetXY(120, 260);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
            PDF::SetXY(135, 260);
            PDF::writeHTML('',PDF::Cell(15,6,$asig['prs_nombres'].' '.$asig['prs_paterno'].' '.$asig['prs_materno'],0,1,'L',0), true, true, false, '');
            PDF::SetXY(120, 265);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
             PDF::SetXY(135, 265);
            PDF::writeHTML('',PDF::Cell(45,6,$asig['prs_ci'],0,1,'L',0), true, true, false, '');

            PDF::Line(35, 252, 85, 252); 
            //$pdf->Line(87, 198.5,130, 198.5); 
            PDF::Line(135, 252,186, 252); 

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
}
