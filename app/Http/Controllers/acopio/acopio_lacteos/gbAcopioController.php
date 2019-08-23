<?php
namespace siga\Http\Controllers\acopio\acopio_lacteos;

use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Persona;
use siga\Modelo\admin\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\EstadoCivil;
use siga\Modelo\acopio\acopio_lacteos\Acopio;
use siga\Modelo\acopio\acopio_lacteos\AcopioCA;
use siga\Modelo\acopio\acopio_lacteos\AcopioGR;
use siga\Modelo\acopio\acopio_lacteos\ProveedorL;
use siga\Modelo\acopio\acopio_lacteos\Modulo;
use siga\Modelo\acopio\acopio_lacteos\ModRecepcion;
use Auth;
use PDF;
use TCPDF;
//use Elibyy\TCPDF\Facades\TCPDF;

class gbAcopioController extends Controller
{
    public function index()
    {
        $persona = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_id','=','per.prs_usr_id')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $fech= AcopioGR::getfecha();   
        $fecha= $fech['detlac_fecha_reg'];
        $proveedor=ProveedorL::orderBy('prov_id','DESC')->paginate(10);
        $usuario = Usuario::OrderBy('usr_id', 'desc');
        $data  = ProveedorL::combo();
        //MODULOS O CENTROS DE ACOPIO
        $modulo = Modulo::getListarModulo();
        // dd($modulo);      
        return view('backend.administracion.acopio.acopio_lacteos.acopio.index',compact('data','proveedor', 'usuario', 'fecha', 'persona','modulo'));
    }

     public function show($id)
    {
         $regacopio = AcopioCA::select( 'dac_id', 'dac_id_prov', 'dac_fecha_acop', 'dac_hora', 'dac_cant_uni', 'dac_tem', 'dac_sng','dac_palc','dac_aspecto','dac_color','dac_olor','dac_sabor')
            ->where('dac_estado','1')  
            ->where('dac_id_prov',$id)
            ->orderBy('dac_id','desc')
            ->paginate(8); 
         $proveedor = ProveedorL::setBuscar($id);
         return view ('backend.administracion.acopio.acopio_lacteos.acopio.listadoacopio',compact('regacopio', 'proveedor'));
        // return view ('backend.administracion.acopio.acopio_lacteos.acopio.listadomod');
    }

    public function list()
    {
        // return view ('backend.administracion.acopio.acopio_lacteos.acopio.listadomod');
    }

   public function create()
    {
        // $proveedor = ProveedorL::getListar();
        $modulo = Modulo::getListarModulo();
        // return Datatables::of($proveedor)->addColumn('acciones', function ($proveedor) {
        //     return '<a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#5499C7; width:160px;" href="AcopioLacteosList">LISTAR PROVEEDORES</a> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#5499C7; width:130px;" href="AcopioLacteos/listar/' . $proveedor->prov_id . '">LISTAR ACOPIO</a> '; 
        // })
        return Datatables::of($modulo)->addColumn('acciones', function ($modulo) {
            return '<a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#5499C7; width:160px;" href="AcopioLacteosList">LISTAR PROVEEDORES</a> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#5499C7; width:130px;" href="AcopioLacteos/listar/' . $modulo->modulo_id . '">LISTAR ACOPIO</a> '; 
        })
           ->editColumn('id', 'ID: {{$modulo_id}}')
           ->addColumn('nombreCompleto', function ($nombres) {
            return $nombres->modulo_nombre . ' ' . $nombres->modulo_paterno . ' ' . $nombres->modulo_materno;
        })
            ->editColumn('id', 'ID: {{$modulo_id}}')
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
        ->editColumn('id', 'ID: {{$dac_id}}')
        -> addColumn('pruebaalco', function ($pal) {
                if($pal->dac_palc==1)
                { return '<h5 class="text-center">+</h5>'; }
                return '<h5 class="text-center">-</h5>'; 
        })  

        -> addColumn('aspecto', function ($pal) {
                if($pal->dac_aspecto==1)
                { return '<h5 class="text-center">Liquido</h5>'; }
                return '<h5 class="text-center">Homogeneo</h5>'; 
        })  
        -> addColumn('color', function ($pal) {
                if($pal->dac_color==1)
                { return '<h5 class="text-center">Blanco Opaco</h5>'; }
                return '<h5 class="text-center">Blanco Cremoso</h5>'; 
        })  
        -> addColumn('aspecto', function ($pal) {
                if($pal->dac_aspecto==1)
                { return '<h5 class="text-center">Liquido</h5>'; }
                return '<h5 class="text-center">Homogeneo</h5>'; 
        })  
        -> addColumn('olor', function ($pal) {
                if($pal->dac_olor==1)
                { return '<h5 class="text-center">SI</h5>'; }
                return '<h5 class="text-center">NO</h5>'; 
        })  
        -> addColumn('sabor', function ($pal) {
                if($pal->dac_sabor==1)
                { return '<h5 class="text-center">Poco Dulce</h5>'; }
                return '<h5 class="text-center">Agradable</h5>'; 
        })  

            ->make(true);      

    }
    
//listado y creacion de datos de la tabla detalle acopio por proveedor
     public function store(Request $request)
    {
        $this->validate(request(), [ 
            'certificado_aceptacion' => 'required|min:1',
            'hora' => 'required', 
            'cantidad' => 'required',   
            'tipo_envase' => 'required|min:1', 
            'condiciones_higiene' => 'required|min:1',
            'temperatura' => 'required', 
            'sng' => 'required',   
            'prueba_alcohol' => 'required|min:1',  
            'aspecto' => 'required|min:1', 
            'color' => 'required|min:1', 
            'olor' => 'required|min:1',  
            'sabor' => 'required|min:1',    
        ]); 
        $fecha1=date('Y-m-d');
        AcopioCA::create([
            'dac_id_prov'     => $request['cod_prov'],
            'dac_cert'        => $request['certificado_aceptacion'],
            'dac_fecha_acop'  => $fecha1,
            'dac_hora'        => $request['hora'],
            'dac_cant_uni'    => $request['cantidad'],
            'dac_obs'         => $request['aco_obs'],
            'dac_cond'        => $request['condiciones_higiene'],
            'dac_tem'         => $request['temperatura'],
            'dac_sng'         => $request['sng'],
            'dac_palc'        => $request['prueba_alcohol'],
            'dac_aspecto'     => $request['aspecto'],
            'dac_color'       => $request['color'],
            'dac_olor'        => $request['olor'],
            'dac_sabor'       => $request['sabor'],      
            'dac_tenv'        => $request['tipo_envase'], 
            'dac_estado'      => '1', 
            'dac_fecha_reg'   => $fecha1, 
            'dac_id_linea'    => '2',
            'dac_id_rec'      => Auth::user()->usr_id,
        ]);
        return response()->json(['Mensaje' => 'El acopio no fueron registrado']);
    }
    //inserta datos en la tabla detalle generico detalle generico acopio lacteos
 public function store2(Request $request)
    {
        // $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
        //                     ->select('planta.id_planta')
        //                     ->where('usr_id','=',Auth::user()->usr_id)->first();  
        // $plant=$planta['id_planta'];   
        // $fecha1=date('d/m/Y');
        // $turno = Usuario::where('usr_id','=',Auth::user()->usr_id)->first();
        // $tur = $turno['usr_id_turno'];
        // if(is_null($tur)){
        //     AcopioGR::create([
        //         'detlac_id_rec'   => Auth::user()->usr_id,
        //         'detlac_fecha'    => $fecha1,
        //         'detlac_cant'     => $request['cant_lech1'],
        //         'detlac_obs'      => $request['acog_obs'],
        //         'detlac_tem'      => $request['acog_tem'],
        //         'detlac_sng'      => $request['acog_sng'],
        //         'detlac_palc'     => $request['acog_palc'],
        //         'detlac_aspecto'  => $request['acog_asp'],
        //         'detlac_color'    => $request['acog_col'],
        //         'detlac_olor'     => $request['acog_olo'],
        //         'detlac_sabor'    => $request['acog_sab'],
        //         'detlac_estado'   => 'A',
        //         'detlac_fecha_reg'=> $fecha1,
        //         'detlac_cant_prov'=> $request['cant_prov1'],
        //         'detlac_est_reg'  => '1',
        //         'detlac_id_planta'=> $plant,
        //         'detlac_id_turno' => '0',
        //     ]);
        // }else{
        //     AcopioGR::create([
        //         'detlac_id_rec'   => Auth::user()->usr_id,
        //         'detlac_fecha'    => $fecha1,
        //         'detlac_cant'     => $request['cant_lech1'],
        //         'detlac_obs'      => $request['acog_obs'],
        //         'detlac_tem'      => $request['acog_tem'],
        //         'detlac_sng'      => $request['acog_sng'],
        //         'detlac_palc'     => $request['acog_palc'],
        //         'detlac_aspecto'  => $request['acog_asp'],
        //         'detlac_color'    => $request['acog_col'],
        //         'detlac_olor'     => $request['acog_olo'],
        //         'detlac_sabor'    => $request['acog_sab'],
        //         'detlac_estado'   => 'A',
        //         'detlac_fecha_reg'=> $fecha1,
        //         'detlac_cant_prov'=> $request['cant_prov1'],
        //         'detlac_est_reg'  => '1',
        //         'detlac_id_planta'=> $plant,
        //         'detlac_id_turno' => $tur,

        //     ]);
        // }
        //  return response()->json(['Mensaje' => 'El acopio general no fueron registrado']);
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
    public function sumacantleche()
    {
        $fecha=date('d/m/Y');
        $usr=Auth::user()->usr_id;
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
        // // opc2
        // $result=\DB::select('select * from acopio.sp_sum_lact2(?,?)',array($ids,$fecha));
        // $data2 = Collect($result);  
        // return response()->json($data2);
        $fecha=date('d/m/Y');
        $turno = Usuario::where('usr_id','=',Auth::user()->usr_id)->first();

        if($turno['usr_id_turno']==1){
        $result=ModRecepcion::join('acopio.modulo as mod','acopio.recepcion_modulo.recmod_id_mod','=','mod.modulo_id')
                            ->join('public._bp_planta as planta','mod.modulo_id_planta','=','planta.id_planta')
                            ->select(DB::raw('SUM(recepcion_modulo.recmod_cant_recep) as cantidad_total'))
                            ->where('modulo_id_planta','=',$planta->id_planta)
                            ->where('recepcion_modulo.recmod_id_turno',1)
                            ->where('recepcion_modulo.recmod_id_usr',$usr)
                            ->where('recepcion_modulo.recmod_fecha','=',$fecha)->first();
        // dd($result);
        return response()->json($result);
        }
        if($turno['usr_id_turno']==2){
        $result=ModRecepcion::join('acopio.modulo as mod','acopio.recepcion_modulo.recmod_id_mod','=','mod.modulo_id')
                            ->join('public._bp_planta as planta','mod.modulo_id_planta','=','planta.id_planta')
                            ->select(DB::raw('SUM(recepcion_modulo.recmod_cant_recep) as cantidad_total'))
                            ->where('modulo_id_planta','=',$planta->id_planta)
                            ->where('recepcion_modulo.recmod_id_turno',2)
                            ->where('recepcion_modulo.recmod_id_usr',$usr)
                            ->where('recepcion_modulo.recmod_fecha','=',$fecha)->first();
        // dd($result);
        return response()->json($result);
        }
         if($turno['usr_id_turno']==null){
        $result=ModRecepcion::join('acopio.modulo as mod','acopio.recepcion_modulo.recmod_id_mod','=','mod.modulo_id')
                            ->join('public._bp_planta as planta','mod.modulo_id_planta','=','planta.id_planta')
                            ->select(DB::raw('SUM(recepcion_modulo.recmod_cant_recep) as cantidad_total'))
                            ->where('modulo_id_planta','=',$planta->id_planta)
                            // ->where('recepcion_modulo.recmod_id_turno',0)
                            // ->where('recepcion_modulo.recmod_id_usr',$usr)
                            ->where('recepcion_modulo.recmod_fecha','=',$fecha)->first();
        // dd($result);
        return response()->json($result);
        }
    }
    //verifica si se envio el registro 
    public function verificaenvio()
    {
        $fecha=date('d/m/Y');
        $ids=Auth::user()->usr_id;
        // opc2
        //select * from acopio.det_acoreslac where detlac_fecha='2018/11/12'
        //$result=\DB::select('select * from acopio.sp_sum_lact2(?,?)',array($ids,$fecha));
        $result=\DB::select('select * from acopio.det_acoreslac where detlac_fecha='.$fecha.'');

        $data2 = Collect($result);  
        return response()->json($data2);
    }
    public function update(Request $request, $id)
    {
       /* $proveedor = Acopio::setBuscar($id);
        $proveedor->fill($request->all());
        $proveedor->save();
        return response() -> json($proveedor -> toArray());*/
       // return response()->json(['mensaje' => 'Se actualizo el proveedor']);

     

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
        // $ids=Auth::user()->usr_id;
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta', 'planta.nombre_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
       

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
        $pdf->SetXY(90, 10);
        $pdf->Cell(90,40,utf8_decode( 'PLANTA').' '.$planta['nombre_planta'],0,0,'C');
        $pdf->SetXY(200, 10);
        $pdf->Cell(105, 15, 'Al: '.date('d/m/Y').'', 0,0,'C');
        $pdf->Ln(30);
        //ENCABEZADO DE TABLA
        $pdf->SetFont('helvetica','B',8);
         // PDF::writeHTML($htmltable, true, false, true, false, '');

        //CONTENIDO DE LA TABLA
        // $acopioLact = AcopioCA::imprimir_acopioCA($fecha);
        $acopioLact = ModRecepcion::join('acopio.modulo as mod','acopio.recepcion_modulo.recmod_id_mod','=','mod.modulo_id')
                            ->join('public._bp_planta as planta','mod.modulo_id_planta','=','planta.id_planta')
                            ->where('modulo_id_planta','=',$planta->id_planta)
                            ->where('recepcion_modulo.recmod_fecha','=',$fecha)->orderBy('recmod_id','DESC')->get();
        // dd($acopioLact);
        //echo $acopioLact;
        $html   = '<table border="1">
                        <tr ALIGN=center border="1" bordercolor="#ffffff">
                        <th width="40"  bgcolor="#8b7bc8" border="1" align="center"><h4>No</h4></th>
                        <th width="190" bgcolor="#8b7bc8" border="1" align="center"><h4>MODULO</h4></th>
                        <th width="70" bgcolor="#8b7bc8"  border=1 align="center"><h4>HORA</h4></th>
                        <th width="90"  bgcolor="#8b7bc8" border=1 align="center"><h4>CERT. ACEPTACION</h4></th>
                        <th width="150"  bgcolor="#8b7bc8" border=1 align="center"><h4>OBSERVACIONES</h4></th>
                        <th width="100"  bgcolor="#8b7bc8" border=1 align="center"><h4>CANTIDAD LITROS</h4></th>
                        <th width="100"  bgcolor="#8b7bc8" border=1 align="center"><h4>CANTIDAD EN BALDES</h4></th>
                    </tr>';
        $nro_mod = 0;
        $total_cantidad = 0;
        $total_baldes = 0;
       foreach ($acopioLact as $key => $m) {
     //  foreach ($acopioLact as $m) {
         // if($m->dac_palc==1) { $palc="+"; } else { $palc="-";  }
         // if($m->dac_aspecto==1) { $asp="Liquido"; } else { $asp="Homogeneo";  }
         // if($m->dac_color==1) { $col="Blanco Opaco"; } else { $col="Blanco Cremoso";  }
         // if($m->dac_olor==1) { $olo="SI"; } else { $olo="NO";  }
            if($m->recmod_acepta==1) { $acept="ACEPTADO"; } else { $acept="RECHAZADO";  }
            $nro_mod = $nro_mod +1;
            $total_cantidad = $total_cantidad+$m->recmod_cant_recep;
            $total_baldes = $total_baldes+$m->recmod_cant_bal_recep;
            $html = $html . '<tr align="center" border=1>
                    <td align="center" border="1">' .$nro_mod. '</td>
                    <td align="center" border="1">' . $m->modulo_modulo .'</td>
                    <td align="center" border="1">' . $m->recmod_hora . '</td>
                    <td align="center" border="1">' . $acept . '</td>
                    <td align="center" border="1">' . $m->recmod_obs . '</td>
                    <td align="center" border="1">' . number_format($m->recmod_cant_recep,2,'.',',') . '</td>
                    <td align="center" border="1">' . number_format($m->recmod_cant_bal_recep,2,'.',',') . '</td>                    
                  </tr>';
        }
        $html = $html . '<tr>
                            <td align="center" colspan="5">TOTALES</td>
                            <td align="center">'.number_format($total_cantidad,2,'.',',').'</td>
                            <td align="center">'.number_format($total_baldes,2,'.',',').'</td>
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
