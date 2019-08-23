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
use siga\Modelo\acopio\acopio_lacteos\AcopioCA;
use siga\Modelo\acopio\acopio_lacteos\AcopioGR;
use siga\Modelo\acopio\acopio_lacteos\ProveedorL;
use Auth;
use PDF;
use TCPDF;
//use Elibyy\TCPDF\Facades\TCPDF;

class gbAcopioControllerENV extends Controller
{
    public function index()
    {
        //$acopio=Proveedor::orderBy('id_proveedor','DESC')->paginate(10);
        $proveedor=ProveedorL::orderBy('prov_id','DESC')->paginate(10);
        $usuario = Usuario::OrderBy('usr_id', 'desc');
        $data  = ProveedorL::combo();
       // $data2  = AcopioCA::mostrarusr();
      //  $data2  = Proveedor::MostrarRegistro();
        return view('backend.administracion.acopio.acopio_lacteos.acopio.index',compact('data','proveedor', 'usuario'));
    }

   public function create()
    {
        $proveedor = ProveedorL::getListarModulo();
        return Datatables::of($proveedor)->addColumn('acciones', function ($proveedor) {
            return '<button value="' . $proveedor->prov_id . '" class="btn btn-primary" style="background:#F5B041" onClick="MostrarProveedor2(this);" data-toggle="modal" data-target="#myCreateRCA">REGISTRAR</button> <button value="' . $proveedor->prov_id . '" class="btn btn-primary" style="background:#5499C7" onClick="lstacopiolact(this);" data-toggle="modal" data-target="#myListar">LISTAR</button>  ';
        })
           ->editColumn('id', 'ID: {{$prov_id}}')
           -> addColumn('nombreCompleto', function ($nombres) {
            return $nombres->prov_nombre . ' ' . $nombres->prov_ap . ' ' . $nombres->prov_am;
        })
            ->editColumn('id', 'ID: {{$prov_id}}')
            ->make(true);
    }
  
    //listar acopios por proveedor
    public function lstAcopiosProvlact($id)
    {
        $regacopio = AcopioCA::select( 'dac_id', 'dac_id_prov', 'dac_fecha_acop', 'dac_hora', 'dac_cant_uni', 'dac_tem', 'dac_sng','dac_palc','dac_aspecto','dac_color','dac_olor','dac_sabor')
            ->where('dac_estado','1')  
            ->where('dac_id_prov',$id)
            ->orderBy('dac_id','ASC')
            ->get();  
        return Datatables::of($regacopio)
      
            ->make(true);      



    }
    
    //inserta datos en la tabla detalle generico detalle generico acopio lacteos
 public function store(Request $request)
    {
        // $this->validate(request(), [ 
        //     'temperatura' => 'required',
        //     'sng' => 'required',  
        //     'prueba_alcohol' => 'required|min:1',  
        //     'aspecto' => 'required|min:1', 
        //     'color' => 'required|min:1', 
        //     'olor' => 'required|min:1',  
        //     'sabor' => 'required|min:1',    
        // ]);     

         $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();  
        $plant=$planta['id_planta'];   
        $fecha1=date('d/m/Y');
        $turno = Usuario::where('usr_id','=',Auth::user()->usr_id)->first();
        $tur = $turno['usr_id_turno'];
        if(is_null($tur)){
            AcopioGR::create([
                'detlac_id_rec'   => Auth::user()->usr_id,
                'detlac_fecha'    => $fecha1,
                'detlac_cant'     => $request['cant_lech1'],
                'detlac_obs'      => $request['acog_obs'],
                'detlac_tem'      => $request['temperatura'],
                'detlac_sng'      => $request['sng'],
                'detlac_palc'     => $request['prueba_alcohol'],
                'detlac_aspecto'  => $request['aspecto'],
                'detlac_color'    => $request['color'],
                'detlac_olor'     => $request['olor'],
                'detlac_sabor'    => $request['sabor'],
                'detlac_estado'   => 'A',
                'detlac_fecha_reg'=> $fecha1,
                'detlac_cant_prov'=> $request['cant_prov1'],
                'detlac_est_reg'  => '1',
                'detlac_nom_rec'  => Auth::user()->usr_usuario,
                'detlac_envio'    => 'S',
                'detlac_acept_aco' => 0,
                'detlac_id_planta'=> $plant,
                'detlac_id_turno' => 0,
            ]);
        }else
        {
            AcopioGR::create([
                'detlac_id_rec'   => Auth::user()->usr_id,
                'detlac_fecha'    => $fecha1,
                'detlac_cant'     => $request['cant_lech1'],
                'detlac_obs'      => $request['acog_obs'],
                'detlac_tem'      => $request['temperatura'],
                'detlac_sng'      => $request['sng'],
                'detlac_palc'     => $request['prueba_alcohol'],
                'detlac_aspecto'  => $request['aspecto'],
                'detlac_color'    => $request['color'],
                'detlac_olor'     => $request['olor'],
                'detlac_sabor'    => $request['sabor'],
                'detlac_estado'   => 'A',
                'detlac_fecha_reg'=> $fecha1,
                'detlac_cant_prov'=> $request['cant_prov1'],
                'detlac_est_reg'  => '1',
                'detlac_nom_rec'  => Auth::user()->usr_usuario,
                'detlac_envio'    => 'S',
                'detlac_acept_aco' => 0,
                'detlac_id_planta'=> $plant,
                'detlac_id_turno' => $tur,
            ]); 
        }

        // $estado = ModRecepcion::where('recmod_id','=',$request['id_modulo'])->first();
        // $estado->recmod_estado_recep = $request['certificacion_aceptacion'];
        // $estado->save();
        return response()->json(['Mensaje' => 'El acopio general no fueron registrado']);
    }
 
      public function edit($id)
    {

        $proveedor = ProveedorL::setBuscar($id);
        return response()->json($proveedor);

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
   /* public function sumacantleche()
    {
        $fecha=date('d/m/Y');
        $ids=Auth::user()->usr_id;
        // opc2
        $result=\DB::select('select * from acopio.sp_sum_lact2(?,?)',array($ids,$fecha));
        $data2 = Collect($result);  
        return response()->json($data2);
    }*/
    public function update(Request $request, $id)
    {
       /* $proveedor = Acopio::setBuscar($id);
        $proveedor->fill($request->all());
        $proveedor->save();
        return response() -> json($proveedor -> toArray());*/
       // return response()->json(['mensaje' => 'Se actualizo el proveedor']);

     

    }

    public function show($id)
    {

    }

    public function destroy($id)
    {
       /* $proveedor = Proveedor::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);*/
    }

    //boleta impresion diaria
    Public function boletAcopioProvL()
    {
        $fecha=date('d/m/Y');
      //   $fecha1=date('d/m/Y');
       
       

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->AddPage('L', 'Carta');
        $pdf->Image('img/logoeba.png', 15, 10, 25);
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
     
       /* $pdf->Cell(10,5,utf8_decode( ''),0,0,'C');
        $pdf->Cell(50,5,utf8_decode( ''),0,0,'C');
        $pdf->Cell(10,5,utf8_decode( ''),0,0,'C');
        $pdf->Cell(15,5,utf8_decode( ''),0,0,'C');
        $pdf->Cell(15,5,utf8_decode( ''),0,0,'C');
        $pdf->Cell(60,5,utf8_decode( 'PARAMETROS FISICO QUIMICO'),1,0,'C');
        $pdf->Cell(80,5,utf8_decode( 'PARAMETROS ORGANOLEPTICOS'),1,0,'C');
        $pdf->Cell(35,5,utf8_decode( ''),0,0,'C');
        
        $pdf->Ln(5);
        $pdf->Cell(10,5,utf8_decode( 'No'),1,0,'C');
        $pdf->Cell(50,5,utf8_decode( 'Acopiador'),1,0,'C');
        $pdf->Cell(10,5,utf8_decode( 'Hora'),1,0,'C');
        $pdf->Cell(15,5,utf8_decode( 'Cant. (Kg)'),1,0,'C');
        $pdf->Cell(15,5,utf8_decode( 'Cant. (Lt)'),1,0,'C');
        $pdf->Cell(15,5,utf8_decode( 'Temp.'),1,0,'C');
        $pdf->Cell(15,5,utf8_decode( 'Densidad'),1,0,'C');
        $pdf->Cell(15,5,utf8_decode( 'Prueba Alcohol'),1,0,'C');
        $pdf->Cell(15,5,utf8_decode( 'SNG'),1,0,'C');
        $pdf->Cell(20,5,utf8_decode( 'Aspecto'),1,0,'C');
        $pdf->Cell(20,5,utf8_decode( 'Color'),1,0,'C');
        $pdf->Cell(20,5,utf8_decode( 'Olor'),1,0,'C');
        $pdf->Cell(20,5,utf8_decode( 'Sabor'),1,0,'C');
        $pdf->Cell(35,5,utf8_decode( 'Observaciones'),1,0,'C');*/

        //CONTENIDO DE LA TABLA
        $acopioLact = AcopioCA::imprimir_acopioCA($fecha);
        $html   = '<table>
                        <tr ALIGN=center border="1" bordercolor="#ffffff">
                        <th width="40"  bgcolor="#8b7bc8" border="1" align="center"><h4>No</h4></th>
                        <th width="115" bgcolor="#8b7bc8" align="center"><h4>Acopiador</h4></th>
                        <th width="40" bgcolor="#8b7bc8" align="center"><h4>Hora</h4></th>
                        <th width="45"  bgcolor="#8b7bc8" align="center"><h4>Cant. (Kg)</h4></th>
                        <th width="45"  bgcolor="#8b7bc8" align="center"><h4>Cant. (Lt)</h4></th>
                        <th width="50"  bgcolor="#8b7bc8" align="center"><h4>Temp</h4></th>
                        <th width="50"  bgcolor="#8b7bc8" align="center"><h4>Prueba Alcohol</h4></th>
                        <th width="50"  bgcolor="#8b7bc8" align="center"><h4>SNG</h4></th>
                        <th width="50"  bgcolor="#8b7bc8" align="center"><h4>Aspecto</h4></th>
                        <th width="50"  bgcolor="#8b7bc8" align="center"><h4>Color</h4></th>
                        <th width="50"  bgcolor="#8b7bc8" align="center"><h4>Olor</h4></th>
                        <th width="50"  bgcolor="#8b7bc8" align="center"><h4>Sabor</h4></th>
                        <th width="70"  bgcolor="#8b7bc8" align="center"><h4>Observaciones</h4></th>
                    </tr>';
       foreach ($acopioLact as $key => $m) {
     //  foreach ($acopioLact as $m) {
            $html = $html . '<tr align="center"">
                    <td align="center">' .$m->dac_id. '</td>
                    <td align="left">' . $m->dac_id_prov . '</td>
                    <td align="left">' . $m->dac_hora . '</td>
                    <td align="left">' . $m->dac_cant_uni . '</td>
                    <td align="left">' . $m->dac_cant_uni . '</td>
                    <td align="left">' . $m->dac_tem . '</td>
                    <td align="left">' . $m->dac_palc . '</td>
                    <td align="left">' . $m->dac_sng . '</td>
                    <td align="left">' . $m->dac_aspecto . '</td>
                    <td align="left">' . $m->dac_color . '</td>
                    <td align="left">' . $m->dac_olor . '</td>
                    <td align="left">' . $m->dac_sabor . '</td>
                    <td align="left">' . $m->dac_obs . '</td>
                  </tr>';
        }
     


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
