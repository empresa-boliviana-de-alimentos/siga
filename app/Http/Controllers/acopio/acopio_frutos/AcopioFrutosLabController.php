<?php
namespace siga\Http\Controllers\acopio\acopio_frutos;

use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Persona;
use siga\Modelo\admin\Usuario;
//use gamlp\Modelo\admin\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\EstadoCivil;
use siga\Modelo\acopio\acopio_frutos\Acopio;
use siga\Modelo\acopio\acopio_lacteos\Recepcionista;
use siga\Modelo\acopio\acopio_frutos\AcopioLAB;
use siga\Modelo\acopio\acopio_frutos\AcopioRF;
use siga\Modelo\acopio\acopio_lacteos\ProveedorL;
use siga\Modelo\acopio\acopio_frutos\Calibre;
use siga\Modelo\acopio\acopio_frutos\ProveedorF;
use siga\Modelo\acopio\acopio_frutos\TipoFruta;
use Auth;
use PDF;

class AcopioFrutosLabController extends Controller
{
    public function index()
    {
        $id=Auth::user()->usr_prs_id;
       // echo $id;
        $per=Persona::where('prs_id',$id)->first();
        // echo $per;
        $fruta = TipoFruta::combo();

        $calibre=Calibre::combo();
        $recepcionista=AcopioLAB::orderBy('detlac_id_rec','DESC')->paginate(10);
        $usuario = Usuario::OrderBy('usr_id', 'desc');
        $data  = Recepcionista::combo();
        return view('backend.administracion.acopio.acopio_frutos.acopioLab.index',compact('data','recepcionista', 'usuario','calibre', 'fruta', 'per'));
    }

   public function create()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',$usr = Auth::user()->usr_id)
                            ->first(); 
        $proveedor = ProveedorF::leftjoin('public._bp_planta as plan','acopio.proveedor.prov_id_planta','=','plan.id_planta')
                               ->where('prov_estado', 'A')
                               ->where('prov_id_linea',4)
                               ->where('prov_id_usr',$usr = Auth::user()->usr_id)
                               ->where('prov_id_planta',$planta['id_planta'])
                               ->OrderBy('prov_id', 'desc')
                               ->get();
        return Datatables::of($proveedor)->addColumn('acciones', function ($proveedor) {
            return '<button value="' . $proveedor->prov_id . '" class="btn btn-success" onClick="Mostrardatlab(this);" data-toggle="modal" data-target="#myCreateLAB" style="width:120px;">REGISTRAR</button> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarLabDetalle/' .$proveedor->prov_id. '">LISTAR</a> ';
        })
           ->editColumn('id', 'ID: {{$prov_id}}')
           -> addColumn('nombreCompleto', function ($nombres) {
            return $nombres->prov_nombre . ' ' . $nombres->prov_ap . ' ' . $nombres->prov_am;
        })
            ->make(true);
    }

     public function listarLabDetalle($id)
    {
        $lab_id = $id;
        // $modell_mod =Modulo::where('modulo_id',$id)->first();
        
        return view('backend.administracion.acopio.acopio_frutos.acopioLab.detallelab',compact('lab_id'));
    }

     public function lstAcopiosRecfru($id)
    {
          $regacopio = Acopio:://join('acopio.proveedor as per', 'acopio.acopio.aco_id_prov', '=', 'per.prov_id')
                  join('acopio.tipo_fruta as fru', 'acopio.acopio.aco_tipo', '=', 'fru.tipfr_id')
                 ->where('aco_id_prov',$id)
                 ->where('aco_estado','A')
                 ->where('aco_id_linea','4')
                 ->orderBy('aco_id','ASC')
                 ->get();
          return Datatables::of($regacopio)
          ->editColumn('id', 'ID: {{$aco_id}}')
          -> addColumn('estado', function ($estado) {
                if($estado->aco_estadofru==1)
                { return '<h4 class="text-center"><span class="label label-success">ACEPTADO</span></h4>'; }
                return '<h4 class="text-center"><span class="label label-danger">RECHAZADO</span></h4>'; 
          }) 
          ->addColumn('nombrecompleto', function ($nombrecompleto) {
            return $nombrecompleto->prov_nombre. ' ' . $nombrecompleto->prov_ap.' '.$nombrecompleto->prov_am;
          })

            ->make(true);      
    }

                  
    public function store(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)
                            ->first();  
        $fecha1=date('d/m/Y');
        Acopio::create([
            'aco_id_prov'       => $request['aco_id_prov'],
            'aco_id_recep'      => 1,//$request['aco_id_recep'],
            'aco_obs'           => $request['aco_obs'],
            'aco_id_tipo_cas'   => '1',
            // 'aco_cantidad'      => $request['aco_cantidad'],
            'aco_unidad'        => '1',
            'aco_peso_neto'     => '0',
            'aco_fecha_acop'    => $fecha1,
            'aco_id_proc'       => '1',      
            'aco_id_comunidad'  => '1', 
            'aco_tipo'          => $request['aco_tipo'], 
         //   'aco_con_hig'       => $request['lab_cond'],
          //  'aco_tram'          => $request['lab_tra'],
            'aco_fecha_rec'     => $fecha1, 
            'aco_id_destino'    => '1', 
            'aco_id_prom'       => '1', 
            'aco_id_linea'      => '4', 
            'aco_id_usr'        =>  Auth::user()->usr_id, 
            'aco_fecha_reg'     => $fecha1, 
            'aco_estado'        => 'A', 
            'aco_estadofru'     => $request['aco_estadofru'], 
            'aco_variedad'      => $request['aco_variedad'], 
            'aco_lac_ph'        => $request['aco_lac_ph'], 
            'aco_lac_aci'       => $request['aco_lac_aci'], 
            'aco_fru_brix'      => $request['aco_fru_brix'], 
            'aco_lac_grma'      => $request['aco_lac_grma'], 
            'aco_fru_rel'       => $request['aco_fru_rel'], 
            'aco_lac_asp'       => $request['aco_lac_asp'], 
            'aco_lac_col'       => $request['aco_lac_col'], 
            'aco_lac_olo'       => $request['aco_lac_olo'], 
            'aco_lac_sab'       => $request['aco_lac_sab'], 
            //'aco_id_comp'       => $request['lab_id_rec'],
            'aco_fru_dm'        => $request['aco_fru_dm'], 
            'aco_fru_long'      => $request['aco_fru_long'], 
            'aco_fru_lote'      => $request['aco_fru_lote'],
            'aco_fru_mues'      => $request['aco_fru_mues'],
            'aco_resp_calidad'  => $request['aco_resp_calidad'],
            //'aco_cert'          => $request['lab_apr'],

            'aco_cant_rep'      => $request['aco_cant_rep'], 
            'aco_variedad'      => $request['aco_variedad'], 
            'aco_fru_calibre'   => $request['aco_fru_calibre'],
            'aco_fru_tam'       => $request['aco_fru_tam'],
            'aco_fru_categoria' => $request['aco_fru_categoria'],
            'aco_id_planta'     => $planta['id_planta'],
            'aco_fru_corona'    => $request['aco_fru_corona'],
            'aco_fru_sincorona' => $request['aco_fru_sincorona']
        ]);
            $acoid=DB::table('acopio.acopio')
                    ->select(DB::raw('MAX(aco_id) as id'))
                    ->first(); 
            $var=collect($acoid);
            $planta1 = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)
                            ->first();  
          AcopioRF::create([
            'dac_id_prov'          => $request['aco_id_prov'],
            'dac_id_tipofru'       => $request['aco_tipo'],
       //     'dac_fecha_acop'       => $fecha1,
        //    'dac_tot_descartefru'  => $request['aco_descartefru'],
        //    'dac_calibrefru'       => $request['aco_calibrefru'],
       //     'dac_ramhojafru'       => $request['aco_ramhojafru'],
            'dac_infestfru'        => $request['aco_infestfru'],
           // 'dac_dañadosfru'       => $request['aco_dañadosfru'],
            'dac_extrañosfru'      => $request['aco_extrañosfru'], 
            'dac_estado'           => 'A', 
         //   'dac_fecha_reg'        => $fecha1, 
          //  'dac_cant_uni'         => $request['aco_cant_uni'],
            'dac_id_linea'         => 4,
            'dac_lotefru'          => $request['aco_fru_lote'],
        //    'dac_preciofru'        => $request['aco_preciofru'],
            'dac_nomchofer'        => $request['aco_nomchofer'],
            'dac_placa'            => $request['aco_placa'],
        //    'dac_cantaprob'        => $request['aco_cantaprob'],
            'dac_olor'             => $request['aco_olor'],
            'dac_id_acopio'        => $var['id'],
            'dac_id_planta'        => $planta1['id_planta'],
           // 'dac_id_rec'            => Auth::user()->usr_id, 
        ]);
        return response()->json(['Mensaje' => 'El acopio no fueron registrado']);
    }

    //listado acopio por proveedor
  
      public function edit($id)
    {

        // $lab = AcopioRF::setBuscar($id);
        // return response()->json($lab);
         $proveedor = ProveedorF::setBuscar($id);
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

    public function editcalibre($id)
    {
     $cal = Calibre::setBuscar($id);
     return response()->json($cal);
    }
   
    public function update(Request $request, $id)
    {

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
       // $pdf = new TCPDF();
    PDF::setHeaderCallback(function ($pdf) {
            $pdf->SetFont('helvetica','B',12);
            $pdf->Ln(10); 
            $pdf->Cell(45,10,'',0,1,'C');
            $pdf->Cell(45,20,$pdf->Image('img/eba_1.png',23,22,'R',15),1,0,'C');

            $pdf->MultiCell(95, 20, '', 1, 0, 0, 'L');
            $pdf->SetXY(60, 20);
            $pdf->Cell(95,10,utf8_decode('LISTADO ACOPIO DIARIO '),0,1,'C',0);
            $pdf->SetXY(60, 30);
            $pdf->Cell(95,10,utf8_decode('POR COMPRA DE LECHE'),0,1,'C',0);

            $pdf->SetFont('helvetica','B',9);
            $pdf->SetXY(150, 20);
            $pdf->Cell(45,10,utf8_decode('Serie: '),1,1,'C',0);
            $pdf->SetXY(150, 30);
            $pdf->Cell(45,10,utf8_decode('Nº '),1,1,'C',0);

            $pdf->SetFont('helvetica','B',10);

            $pdf->Ln(5); 
            $pdf->Cell(5,6,'',0,0,'C');
            $pdf->Ln(10);


            //LUGAR DE COMPRA

            switch ('') {
                case '1':
                  $pdf->SetXY(45, 51);
                  $pdf->Cell(15,8,'X',1,0,'C');
                    break;
                case '2':
                  $pdf->SetXY(45, 61);
                  $pdf->Cell(15,8,'X',1,0,'C');
                    break;
                case '3':
                 $pdf->SetXY(45, 71);
                 $pdf->Cell(15,8,'X',1,0,'C');
                    break;
                default:
                    # code...
                    break;
            }

            $pdf->SetFont('helvetica','B',9);
            $pdf->SetXY(15, 51);
            $pdf->Cell(30,8,utf8_decode('Centro de Acopio'),1,0,'L',1);
            $pdf->SetXY(45, 51);
            $pdf->Cell(15,8,'',1,0,'C');

            $pdf->SetXY(15, 61);
            $pdf->Cell(30,8,utf8_decode('Payol'),1,0,'L',1);
            $pdf->SetXY(45, 61);
            $pdf->Cell(15,8,'',1,0,'C');

            $pdf->SetXY(15, 71);
            $pdf->Cell(30,8,utf8_decode('Fábrica'),1,0,'L',1);
            $pdf->SetXY(45, 71);
            $pdf->Cell(15,8,'',1,0,'C');


            $pdf->SetXY(65, 51);
            $pdf->Cell(25, 8, utf8_decode('C. Campesina'), 1, 0, 'L',1);
            $pdf->SetXY(90, 51);
            $pdf->Cell(15,8,'',1,0,'C');

            $pdf->SetXY(65, 61);
            $pdf->Cell(25, 8, utf8_decode('C. Indígena'), 1, 0, 'L',1);
            $pdf->SetXY(90, 61);
            $pdf->MultiCell(15, 8, '', 1, 'C');

            $pdf->SetXY(65, 71);
            $pdf->Cell(25, 8, utf8_decode('Asoc. AOECOM'), 1, 0, 'L',1);
            $pdf->SetXY(90, 71);
            $pdf->MultiCell(15, 8, '', 1, 'C');


            $pdf->SetXY(110, 51);
            $pdf->Cell(25, 8, utf8_decode('Asoc Barraq.'), 1, 0, 'L',1);
            $pdf->SetXY(135, 51);
            $pdf->Cell(15,8,'',1,0,'C');

            $pdf->SetXY(110, 61);
            $pdf->Cell(25, 8, utf8_decode('Rec. e Interna'), 1, 0, 'L',1);
            $pdf->SetXY(135, 61);
            $pdf->Cell(15,8,'',1,0,'C');

            $pdf->SetXY(110, 71);
            $pdf->Cell(25, 8, utf8_decode('Prop. Privada'), 1, 0, 'L',1);
            $pdf->SetXY(135, 71);
            $pdf->Cell(15,8,'',1,0,'C');


            switch ('') {
                case '1':
                    $pdf->SetXY(65, 51);
                    $pdf->Cell(25,8,' ',1,0,'L',0);
                    $pdf->SetXY(90, 51);
                    $pdf->Cell(15,8,'X',1,0,'C',0);
                    break;
                case '2':
                    $pdf->SetXY(65, 61);
                    $pdf->Cell(25,8,'',1,0,'C',0);
                    $pdf->SetXY(90, 61);
                    $pdf->Cell(15,8,'X',1,0,'C',0);
                    break;
                case '3':
                    $pdf->SetXY(65, 71);
                    $pdf->Cell(25,8,'',1,0,'C',0);
                    $pdf->SetXY(90, 71);
                    $pdf->Cell(15,8,'X',1,0,'C',0);
                break;
                case '4':
                    $pdf->SetXY(110, 51);
                    $pdf->Cell(25,8,'',1,0,'C',0);
                    $pdf->SetXY(135, 51);
                    $pdf->Cell(15,8,'X',1,0,'C',0);
                break;
                case '5':
                    $pdf->SetXY(110, 61);
                    $pdf->Cell(25,8,'',1,0,'C',0);
                    $pdf->SetXY(135, 61);
                    $pdf->Cell(15,8,'X',1,0,'C',0);
                break;
                case '6':
                    $pdf->SetXY(110, 71);
                    $pdf->Cell(25,8,'',1,0,'C',0);
                    $pdf->SetXY(135, 71);
                    $pdf->Cell(15,8,'X',1,0,'C',0);
                break;
                default:
                    # code...
                    break;
            }

            $pdf->SetXY(155, 51);
            $pdf->Cell(25, 8, utf8_decode('Importe Neto'), 1, 0, 'L',1);
            $pdf->SetFont('helvetica','B',7);
            $pdf->SetXY(180, 51);
            $pdf->Cell(15,8,'',1,0,'C');
            /*$pdf->SetFont('Arial','B',7);
            $pdf->SetXY(155, 61);
            $pdf->Cell(25, 8, utf8_decode('Menos Impto. 3,25%'), 1, 0, 'L',1);
            $pdf->SetXY(180, 61);
            $pdf->Cell(15,8,$imp_sup,1,0,'C'); 
            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY(155, 71);
            $pdf->Cell(25, 8, utf8_decode('Importe Neto'), 1, 0, 'L',1);
            $pdf->SetXY(180, 71);
            $pdf->Cell(15,8,$totimp,1,0,'C');*/ 


            $pdf->SetXY(15, 101);
            $pdf->Cell(49,7,'Hemos cancelado al Sr. (a):',0,0,'L',0);
            $pdf->Cell(131,7,'',0,1,'L',0);


            $pdf->SetXY(15, 111);
            $pdf->Cell(30,8,'De la Comunidad:',0,0,'L',0);
            $pdf->SetFont('helvetica','',8);
            $pdf->MultiCell(55, 8, '',0,1, 0, 'J');
            $pdf->SetFont('helvetica','B',8);

            $pdf->SetXY(100, 111);
            $pdf->Cell(15,8,'Convenio',0,0,'L',0);

            $pdf->SetXY(115, 111);
            $pdf->Cell(10,4,'SI',1,0,'C',1);
            $pdf->SetXY(115, 115);
            $pdf->Cell(10,4,'NO',1,0,'C',1);

            $pdf->SetXY(135, 111);
            $pdf->Cell(15,8,'Municipio',0,0,'C',0);
            $pdf->SetFont('helvetica','',8);
            $pdf->MultiCell(45, 8, '', 0, 1, 0, 'J');
            $pdf->SetFont('helvetica','B',9);


            switch ('') {
                case '1':
                    $pdf->SetXY(125, 111);
                    $pdf->Cell(10,4,'',1,0,'C',0);
                    $pdf->SetXY(125, 115);
                    $pdf->Cell(10,4,'X',1,0,'C',0);
                    break;
                case '2':
                    $pdf->SetXY(125, 111);
                    $pdf->Cell(10,4,'X',1,0,'C',0);
                    $pdf->SetXY(125, 115);
                    $pdf->Cell(10,4,'',1,0,'C',0);
                    break;
                default:
                    # code...
                    break;
            }

            $pdf->SetXY(15, 121);
            $pdf->Cell(30,8,'La Suma de:',0,0,'L',0);
            $pdf->SetFont('helvetica','',8);
            $pdf->SetFont('helvetica','B',8);
            $pdf->MultiCell(130, 8, '',0,1, 0, 'C');

            $pdf->SetXY(175, 121);
            $pdf->Cell(20,8,'',0,1,'R',0);

            $pdf->SetXY(15, 131);
            $pdf->Cell(40,8,'Por Concepto de Compra de:',0,0,'L',0);
            $pdf->SetFont('helvetica','',8);
            $pdf->MultiCell(20, 8, '',0,1, 0, 'J');
            $pdf->SetFont('helvetica','B',8);

            $pdf->SetXY(75, 131);
            $pdf->Cell(27,8,'Cajas de Almendra',0,0,'L',0);

            $pdf->SetXY(102, 131);
            $pdf->Cell(10,4,'C',1,0,'C',1);
            $pdf->SetXY(102, 135);
            $pdf->Cell(10,4,'O',1,0,'C',1);

            $pdf->SetXY(122, 131);
            $pdf->Cell(25,8,utf8_decode('en cáscara, a Bs.'),0,0,'C',0);
            $pdf->SetFont('helvetica','',8);
            $pdf->MultiCell(15, 8,'', 0, 1, 0, 'J');
            $pdf->SetFont('helvetica','B',9);
            $pdf->SetXY(162, 131);
            $pdf->Cell(15,8,utf8_decode('c/caja de,'),0,0,'C',0);
            $pdf->SetFont('helvetica','',7);
            $pdf->SetXY(177, 131);
            $pdf->Cell(18,8,''.' '.utf8_decode('kilos'),0,0,'C',0);

            switch ('') {
                case '1':
                    $pdf->SetXY(112, 131);
                    $pdf->Cell(10,4,'',1,0,'C',0);
                    $pdf->SetXY(112, 135);
                    $pdf->Cell(10,4,'X',1,0,'C',0);
                    break;
                case '2':
                    $pdf->SetXY(112, 131);
                    $pdf->Cell(10,4,'X',1,0,'C',0);
                    $pdf->SetXY(112, 135);
                    $pdf->Cell(10,4,'',1,0,'C',0);
                    break;
                default:
                    # code...
                    break;
            }

            $pdf->SetXY(112, 131);
            $pdf->Cell(10,4,'',1,0,'C',0);
            $pdf->SetXY(112, 135);
            $pdf->Cell(10,4,'',1,0,'C',0);

            $pdf->SetXY(15, 145);
            $pdf->Cell(40,8,'',0,0,'L',0);
            $pdf->SetFont('helvetica','',8);
            $pdf->Cell(30,8,'',0,0,'C',0);
            $pdf->SetFont('helvetica','B',8);

            $pdf->SetXY(85, 145);
            $pdf->Cell(5,8,'de',0,0,'L',0);

            $pdf->SetXY(90, 145);
            $pdf->Cell(35,8,'',0,0,'C',0);
            $pdf->SetXY(125, 145);
            $pdf->Cell(70,8,'de    '.'',0,0,'C',0);

          


            $pdf->Ln(60);
            $pdf->SetFont('helvetica','B',7);
            /*$pdf->SetXY(75, 199);
            $pdf->Cell(68,6,utf8_decode('Entregue Conforme'),0,1,'C',0);*/
            $pdf->SetXY(75, 204);
            $pdf->Cell(68,6,'',0,1,'C',0);
            $pdf->SetXY(25, 199);
            $pdf->Cell(70,6,utf8_decode('Recibí Conforme (Proveedor)'),0,1,'C',0);
            $pdf->SetXY(10, 204);
            $pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
            $pdf->Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
            $pdf->Cell(45,6,'',0,1,'L',0);
            $pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
            $pdf->Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
            $pdf->Cell(45,6,'',0,1,'L',0);

            $pdf->SetXY(125, 199);
            $pdf->Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            $pdf->SetXY(120, 204);
            $pdf->Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
            $pdf->Cell(45,6,'',0,1,'C',0);
            $pdf->SetXY(120, 210);
            $pdf->Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
            $pdf->Cell(60,6,''." ".'',0,1,'C',0);

            $pdf->Line(35, 198.5,85, 198.5); 
            //$pdf->Line(87, 198.5,130, 198.5); 
            $pdf->Line(135, 198.5,186, 198.5); 

            $pdf->Output();


        });
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
