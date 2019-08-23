<?php

namespace siga\Http\Controllers\acopio\acopio_lacteos;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_lacteos\ProveedorL;
use siga\Modelo\admin\Persona;
use siga\Modelo\admin\Usuario;
use siga\Modelo\acopio\acopio_lacteos\Modulo;
use siga\Modelo\acopio\acopio_lacteos\ModRecepcion;
use siga\Modelo\acopio\acopio_lacteos\AcopioGR;
use Illuminate\Support\Facades\DB;

use Yajra\Datatables\Datatables;
use Auth;
use PDF;
use Session;

class gbRecepcionPl extends Controller
{
    public function index()
    {   

        //     $turno = Usuario::where('usr_id','=',Auth::user()->usr_id)->first();
        // $tur = $turno['usr_id_turno'];
        // if(is_null($tur)){
        //     echo 'esss true';
        // }else{
        //     echo 'no es true';
        // }
         // $usr=Auth::user()->usr_id;
         // $fecha=date('d/m/Y');
         // $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 

         //   $result=ModRecepcion::join('acopio.modulo as mod','acopio.recepcion_modulo.recmod_id_mod','=','mod.modulo_id')
         //                    ->join('public._bp_planta as planta','mod.modulo_id_planta','=','planta.id_planta')
         //                    ->select(DB::raw('SUM(recepcion_modulo.recmod_cant_recep) as cantidad_total'))
         //                    ->where('modulo_id_planta','=',$planta->id_planta)
         //                    // ->where('recepcion_modulo.recmod_id_turno',0)
         //                    //->where('recepcion_modulo.recmod_id_usr',$usr)
         //                    ->where('recepcion_modulo.recmod_fecha','=',$fecha)->first();
         //    echo $result;

        $persona = Usuario::join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        // dd($persona);
        $fech= AcopioGR::getfecha();   
        $fecha= $fech['detlac_fecha_reg'];
        // echo $fecha;
        $tur= $fech['detlac_id_turno'];
       // echo $tur;

        $turno = Usuario::where('usr_id','=',Auth::user()->usr_id)->first();
        return view('backend.administracion.acopio.acopio_lacteos.recepcionPl.index', compact('fecha', 'persona', 'turno', 'tur'));  
    }

     public function create()
    {   
        $turno = Usuario::where('usr_id','=',Auth::user()->usr_id)->first();
        $tur = $turno['usr_id_turno'];
        $modulo = Modulo::getListarModulo();
        // if($tur==1){
        return Datatables::of($modulo)->addColumn('acciones', function ($modulo) {
            // if($modulo->modulo_turno1==null and $modulo->modulo_fecha1 == null)
            // {
            // return '<button value="' . $modulo->modulo_id . '" class="btn btn-success btn-sm" style="width:100px" onClick="MostrarModulo(this);" data-toggle="modal" data-target="#myCreateRecepcion">REGISTRAR</button> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarModuloDetalle/' . $modulo->modulo_id . '">LISTAR</a> '; 
            // }
            if($modulo->modulo_fecha1 == date('Y-m-d'))
            {
            return '<a type="button" class="btn btn-primary fa fa-file-pdf-o" href="/BoletaRecepAco/' . $modulo->modulo_id . '" style="width:100px" target="_blank"> BOLETA</a> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarModuloDetalle/' . $modulo->modulo_id . '">LISTAR</a> '; 
            }
            if($modulo->modulo_fecha2 == date('Y-m-d'))
            {
            return '<a type="button" class="btn btn-primary fa fa-file-pdf-o" href="/BoletaRecepAco/' . $modulo->modulo_id . '" style="width:100px" target="_blank"> BOLETA</a> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarModuloDetalle/' . $modulo->modulo_id . '">LISTAR</a> '; 
            }
            if($modulo->modulo_fecha3 == date('Y-m-d'))
            {
            return '<a type="button" class="btn btn-primary fa fa-file-pdf-o" href="/BoletaRecepAco/' . $modulo->modulo_id . '" style="width:100px" target="_blank"> BOLETA</a> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarModuloDetalle/' . $modulo->modulo_id . '">LISTAR</a> '; 
            }
            else
            {
            return '<button value="' . $modulo->modulo_id . '" class="btn btn-success btn-sm" style="width:100px" onClick="MostrarModulo(this);" data-toggle="modal" data-target="#myCreateRecepcion">REGISTRAR</button> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarModuloDetalle/' . $modulo->modulo_id . '">LISTAR</a> '; 
            }
        })

           ->editColumn('id', 'ID: {{$modulo_id}}')
           -> addColumn('nombreCompleto', function ($nombres) {
            return $nombres->modulo_nombre . ' ' . $nombres->modulo_paterno . ' ' . $nombres->modulo_materno;
        })
            ->make(true);
        // }
        // if($tur==2)
        // {
        //     return Datatables::of($modulo)->addColumn('acciones', function ($modulo) {
        //     if($modulo->modulo_turno2==null and $modulo->modulo_fecha2 == null)
        //     {
        //     return '<button value="' . $modulo->modulo_id . '" class="btn btn-success btn-sm" style="width:100px" onClick="MostrarModulo(this);" data-toggle="modal" data-target="#myCreateRecepcion">REGISTRAR</button> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarModuloDetalle/' . $modulo->modulo_id . '">LISTAR</a> '; 
        //     }
        //     if($modulo->modulo_turno2==2 and $modulo->modulo_fecha2 == date('Y-m-d'))
        //     {
        //     return '<a value="' . $modulo->modulo_id . '" type="button" class="btn btn-primary fa fa-file-pdf-o" target="_blank" href="/BoletaRecepAco/' . $modulo->modulo_id . '" style="width:100px"> BOLETA</a> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarModuloDetalle/' . $modulo->modulo_id . '">LISTAR</a> '; 
        //     }
        //      else
        //     {
        //     return '<button value="' . $modulo->modulo_id . '" class="btn btn-success btn-sm" style="width:100px" onClick="MostrarModulo(this);" data-toggle="modal" data-target="#myCreateRecepcion">REGISTRAR</button> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarModuloDetalle/' . $modulo->modulo_id . '">LISTAR</a> '; 
        //     }
        // })

        //    ->editColumn('id', 'ID: {{$modulo_id}}')
        //    -> addColumn('nombreCompleto', function ($nombres) {
        //     return $nombres->modulo_nombre . ' ' . $nombres->modulo_paterno . ' ' . $nombres->modulo_materno;
        // })
        //     ->make(true);
        // }
        //  if($tur==null)
        // {
        //     return Datatables::of($modulo)->addColumn('acciones', function ($modulo) {
        //     if($modulo->modulo_turno3==null and $modulo->modulo_fecha3 == null)
        //     {
        //     return '<button value="' . $modulo->modulo_id . '" class="btn btn-success btn-sm" style="width:100px" onClick="MostrarModulo(this);" data-toggle="modal" data-target="#myCreateRecepcion">REGISTRAR</button> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarModuloDetalle/' . $modulo->modulo_id . '">LISTAR</a> '; 
        //     }
        //     if($modulo->modulo_turno3==0 and $modulo->modulo_fecha3 == date('Y-m-d'))
        //     {
        //     return '<a value="' . $modulo->modulo_id . '" type="button" class="btn btn-primary fa fa-file-pdf-o" target="_blank" href="/BoletaRecepAco/' . $modulo->modulo_id . '" style="width:100px"> BOLETA</a> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarModuloDetalle/' . $modulo->modulo_id . '">LISTAR</a> '; 
        //     }
        //      else
        //     {
        //     return '<button value="' . $modulo->modulo_id . '" class="btn btn-success btn-sm" style="width:100px" onClick="MostrarModulo(this);" data-toggle="modal" data-target="#myCreateRecepcion">REGISTRAR</button> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#512E5F; width:100px;" href="listarModuloDetalle/' . $modulo->modulo_id . '">LISTAR</a> '; 
        //     }
        // })

        //    ->editColumn('id', 'ID: {{$modulo_id}}')
        //    -> addColumn('nombreCompleto', function ($nombres) {
        //     return $nombres->modulo_nombre . ' ' . $nombres->modulo_paterno . ' ' . $nombres->modulo_materno;
        // })
        //     ->make(true);
        // }
    }

    public function listarModuloDetalle($id)
    {
        $recmod_id = $id;
        $modell_mod =Modulo::where('modulo_id',$id)->first();
        
        return view('backend.administracion.acopio.acopio_lacteos.modeloDetalle.index',compact('recmod_id','modell_mod'));
    }

    public function listarModulosDetalle($id)
    {
        $idrol = Session::get('ID_ROL');
        // if($idrol==){
            $modulodetalle = ModRecepcion::getListarMod($id);
            // return Datatables::of($modulodetalle)->make(true);
            return Datatables::of($modulodetalle)->addColumn('turno', function ($modulodetalle) {
            if($modulodetalle->recmod_id_turno==1)
                {
                return '<h7>MAÑANA</h7>'; 
                }
            if($modulodetalle->recmod_id_turno==2)
                {
                return '<h7>TARDE</h7>'; 
                }
             })
            -> addColumn('aceptacion', function ($modulodetalle) {

             if($modulodetalle->recmod_acepta==1)
                {
                return '<a class="btn btn-success btn-sm" style="width:110px">ACEPTADO</a>'; 
                }
            if($modulodetalle->recmod_acepta==2)
                {
                return '<a class="btn btn-danger btn-sm" style="width:110px">RECHAZADO</a>'; 
                }
             })
             -> addColumn('acciones', function ($modulodetalle) {
              return '<a value="" target="_blank" type="button" class="btn btn-primary fa fa-file-pdf-o"  href="/BoletaRecepAcoDell/' . $modulodetalle->recmod_id . '" style="width:100px"> BOLETA</a>';

             })
                ->make(true);
    }
                            
    public function store(Request $request)
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)
                            ->first();  
         $plant=$planta['id_planta'];   
         $turno = Usuario::where('usr_id','=',Auth::user()->usr_id)->first();
         $tur = $turno['usr_id_turno'];

        if($tur==1){
        ModRecepcion::create([
            'recmod_id_mod'         => $request['recmod_id_mod'],
            'recmod_acepta'         => $request['recmod_acepta'],
            'recmod_cantidad'       => 0,
            'recmod_cant_recep'     => $request['recmod_cant_recep'],
            'recmod_cant_bal_recep' => $request['recmod_cant_bal_recep'],
            'recmod_obs'            => $request['recmod_obs'],
            'recmod_id_usr'         => Auth::user()->usr_id,
            'recmod_id_planta'      => $plant,
            'recmod_id_turno'       => $tur,
            'recmod_hora'           => $request['recmod_hora'],
        ]);

        $truno = Modulo::where('modulo_id','=',$request['recmod_id_mod'])->first();
        $truno->modulo_turno1 = $tur;
        $truno->modulo_fecha1 = date('Y-m-d');
        $truno->save();
        }
        else if($tur==2)
        {
            ModRecepcion::create([
            'recmod_id_mod'         => $request['recmod_id_mod'],
            'recmod_acepta'         => $request['recmod_acepta'],
            'recmod_cantidad'       => 0,
            'recmod_cant_recep'     => $request['recmod_cant_recep'],
            'recmod_cant_bal_recep' => $request['recmod_cant_bal_recep'],
            'recmod_obs'            => $request['recmod_obs'],
            'recmod_id_usr'         => Auth::user()->usr_id,
            'recmod_id_planta'      => $plant,
            'recmod_id_turno'       => $tur,
            'recmod_hora'           => $request['recmod_hora'],
        ]);

        $truno = Modulo::where('modulo_id','=',$request['recmod_id_mod'])->first();
        $truno->modulo_turno2 = $tur;
        $truno->modulo_fecha2 = date('Y-m-d');
        $truno->save();
        }
        else if($tur==null)
        {
            ModRecepcion::create([
            'recmod_id_mod'         => $request['recmod_id_mod'],
            'recmod_acepta'         => $request['recmod_acepta'],
            'recmod_cantidad'       => 0,
            'recmod_cant_recep'     => $request['recmod_cant_recep'],
            'recmod_cant_bal_recep' => $request['recmod_cant_bal_recep'],
            'recmod_obs'            => $request['recmod_obs'],
            'recmod_id_usr'         => Auth::user()->usr_id,
            'recmod_id_planta'      => $plant,
            'recmod_id_turno'       => 0,
            'recmod_hora'           => $request['recmod_hora'],
        ]);

        $truno = Modulo::where('modulo_id','=',$request['recmod_id_mod'])->first();
        $truno->modulo_turno3 = 0;
        $truno->modulo_fecha3 = date('Y-m-d');
        $truno->save();
        }

        return response()->json(['Mensaje' => 'El acopio no fueron registrado']);
    }

    public function edit($id)
    {

     $mod = Modulo::setBuscar($id);
        return response()->json($mod);

    }

    public function boletAcopio($id)
    {  
        $modulo = ModRecepcion::join('acopio.modulo as mod', 'acopio.recepcion_modulo.recmod_id_mod','=','mod.modulo_id')
                        ->join('public._bp_usuarios as usr', 'acopio.recepcion_modulo.recmod_id_usr','=','usr.usr_id')
                        ->join('public._bp_personas as per', 'usr.usr_prs_id','=','per.prs_id')
                        ->join('public._bp_planta as pla', 'usr.usr_planta_id','=','pla.id_planta')
                        ->where('modulo_id',$id)
                        ->first();
        // echo $modulo;
           PDF::AddPage();

           PDF::SetFont('helvetica','B',12);
           PDF::Ln(5); 
           PDF::Cell(45,0,'',0,1,'C');
           PDF::Cell(45,20,PDF::Image('img/logopeqe.png',13,18,'R',25),1,0,'C');

           PDF::MultiCell(95, 20, '', 1, 0, 0, 'L');
           PDF::SetXY(60, 20);
           PDF::Cell(95,10,utf8_decode('BOLETA DE ACOPIO LACTEOS'),0,1,'C',0);
           PDF::SetXY(60, 30);
           PDF::Cell(95,10,utf8_decode('PLANTA'.' '.$modulo['nombre_planta']),0,1,'C',0);

           PDF::SetFont('helvetica','B',9);
           PDF::SetXY(150, 20);
           PDF::Cell(45,20, utf8_decode('COPIA PLANTA'),1,1,'C',0);
           PDF::SetXY(150, 30);

           if ($modulo['modulo_modulo']==null)
           {
             PDF::SetXY(15, 50);
             PDF::Cell(49,7,'Nombre Responsable:',0,0,'L',0);
             PDF::SetXY(50, 50);
             PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');


           }else{

            PDF::SetXY(15, 50);
            PDF::Cell(49,7,'Modulo y/o Centro Acopio:',0,0,'L',0);
            PDF::SetXY(55, 50);
            PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_modulo'],0,1,'L',0), true, true, false, '');
           }

            PDF::SetXY(15, 60);
            PDF::Cell(49,7,'Fecha Acopio:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(38, 60);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_fecha'],0,1,'L',0), true, true, false, '');
            

            if($modulo['recmod_id_turno']==1){

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 70);
            PDF::Cell(49,7,'Turno:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(31, 70);
            PDF::writeHTML('',PDF::Cell(131,7,'Mañana',0,1,'L',0), true, true, false, '');
            }else{
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 70);
            PDF::Cell(49,7,'Turno:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(31, 70);
            PDF::writeHTML('',PDF::Cell(131,7,'Tarde',0,1,'L',0), true, true, false, '');
            }

            if($modulo['recmod_acepta']==1){
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 70);
            PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(105, 70);
            PDF::writeHTML('',PDF::Cell(131,7,'Aceptado',0,1,'L',0), true, true, false, '');
            }else{
            PDF::SetXY(80, 70);
            PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(105, 70);
            PDF::writeHTML('',PDF::Cell(131,7,'Rechazado',0,1,'L',0), true, true, false, '');
            }


            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 80);
            PDF::Cell(40,8,'Cantidad de baldes:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(49 , 80);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_bal_recep'],0,1,'L',0), true, true, false, '');

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 80);
            PDF::Cell(49,7,'Cantidad Recepcionada:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(115 , 80);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_recep'].' '.'Litros',0,1,'L',0), true, true, false, '');
            

            PDF::Ln(30);
            PDF::SetFont('helvetica','B',7);
            PDF::SetXY(25, 130);
            PDF::Cell(70,6,utf8_decode('Entregue Conforme (Proveedor)'),0,1,'C',0);
            PDF::SetXY(10, 135);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(15,6,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');
          
            PDF::SetXY(15, 140);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(45,6,$modulo['modulo_ci'],0,1,'L',0), true, true, false, '');
            //$pdf->Cell(45,6,'',0,1,'L',0);

            PDF::SetXY(125, 130);
            PDF::Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            PDF::SetXY(120, 135);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(15,6,$modulo['prs_nombres'].' '.$modulo['prs_paterno'].' '.$modulo['prs_materno'],0,1,'L',0), true, true, false, '');
          
            PDF::SetXY(120, 140);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(45,6,$modulo['prs_ci'],0,1,'L',0), true, true, false, '');

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
           PDF::Cell(10,10,utf8_decode('BOLETA DE ACOPIO LACTEOS'),0,1,'C',0);
           PDF::SetXY(100, 163);
           PDF::Cell(10,10,utf8_decode('PLANTA'.' '.$modulo['nombre_planta']),0,1,'C',0);

           PDF::SetFont('helvetica','B',9);
           PDF::SetXY(150,155);
           PDF::Cell(45,20, utf8_decode('COPIA PROVEEDOR'),1,1,'C',0);
           PDF::SetXY(150,95);



            if ($modulo['modulo_modulo']==null)
           {
             PDF::SetXY(15, 185);
             PDF::Cell(49,7,'Nombre Responsable:',0,0,'L',0);
             PDF::SetXY(50, 185);
             PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');


           }else{

            PDF::SetXY(15, 185);
            PDF::Cell(49,7,'Modulo y/o Centro Acopio:',0,0,'L',0);
            PDF::SetXY(55, 185);
            PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_modulo'],0,1,'L',0), true, true, false, '');
           }
          

            PDF::SetXY(15, 195);
            PDF::Cell(49,7,'Fecha Acopio:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(38, 195);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_fecha'],0,1,'L',0), true, true, false, '');

            if($modulo['recmod_id_turno']==1){
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 205);
            PDF::Cell(49,7,'Turno:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(31, 205);
            PDF::writeHTML('',PDF::Cell(131,7,'Mañana',0,1,'L',0), true, true, false, '');
            }else{
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 205);
            PDF::Cell(49,7,'Turno:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(31, 205);
            PDF::writeHTML('',PDF::Cell(131,7,'Tarde',0,1,'L',0), true, true, false, '');
            }

            if($modulo['recmod_acepta']==1){
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 205);
            PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(110, 205);
            PDF::writeHTML('',PDF::Cell(131,7,'Aceptado',0,1,'L',0), true, true, false, '');
            }else{
            PDF::SetXY(80, 205);
            PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(110, 205);
            PDF::writeHTML('',PDF::Cell(131,7,'Rechazado',0,1,'L',0), true, true, false, '');
            }

            
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 215);
            PDF::Cell(40,8,'Cantidad de baldes:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(49 , 215);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_bal_recep'],0,1,'L',0), true, true, false, '');

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 215);
            PDF::Cell(49,7,'Cantidad Recepcionada:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(115 , 215);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_recep'].' '.'Litros',0,1,'L',0), true, true, false, '');


            PDF::Ln(60);
            PDF::SetFont('helvetica','B',7);
            PDF::SetXY(25, 255);
            PDF::Cell(70,6,utf8_decode('Entregue Conforme (Proveedor)'),0,1,'C',0);
            PDF::SetXY(10, 260);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(15,6,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');


            PDF::SetXY(15, 265);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(45,6,$modulo['modulo_ci'],0,1,'L',0), true, true, false, '');

            PDF::SetXY(125, 255);
            PDF::Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            PDF::SetXY(120, 260);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
            PDF::SetXY(135, 260);
            PDF::writeHTML('',PDF::Cell(15,6,$modulo['prs_nombres'].' '.$modulo['prs_paterno'].' '.$modulo['prs_materno'],0,1,'L',0), true, true, false, '');
            PDF::SetXY(120, 265);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
            PDF::SetXY(135, 265);
            PDF::writeHTML('',PDF::Cell(45,6,$modulo['prs_ci'],0,1,'L',0), true, true, false, '');

            PDF::Line(35, 252, 85, 252); 
            PDF::Line(135, 252,186, 252); 

            PDF::Output();

   
        PDF::SetTitle('Boleta de Acopio');
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

     public function boletAcopioDetalle($id)
    {  
        $modulo = ModRecepcion::join('acopio.modulo as mod', 'acopio.recepcion_modulo.recmod_id_mod','=','mod.modulo_id')
                        ->join('public._bp_usuarios as usr', 'acopio.recepcion_modulo.recmod_id_usr','=','usr.usr_id')
                        ->join('public._bp_personas as per', 'usr.usr_prs_id','=','per.prs_id')
                        ->join('public._bp_planta as pla', 'usr.usr_planta_id','=','pla.id_planta')
                        ->where('recmod_id',$id)
                        ->first();
         // echo $modulo;
           PDF::AddPage();

           PDF::SetFont('helvetica','B',12);
           PDF::Ln(5); 
           PDF::Cell(45,0,'',0,1,'C');
           PDF::Cell(45,20,PDF::Image('img/logopeqe.png',13,18,'R',25),1,0,'C');

           PDF::MultiCell(95, 20, '', 1, 0, 0, 'L');
           PDF::SetXY(60, 20);
           PDF::Cell(95,10,utf8_decode('BOLETA DE ACOPIO LACTEOS'),0,1,'C',0);
           PDF::SetXY(60, 30);
           PDF::Cell(95,10,utf8_decode('PLANTA'.' '.$modulo['modulo_id_planta']),0,1,'C',0);

           PDF::SetFont('helvetica','B',9);
           PDF::SetXY(150, 20);
           PDF::Cell(45,20, utf8_decode('COPIA PLANTA'),1,1,'C',0);
           PDF::SetXY(150, 30);

           if ($modulo['modulo_modulo']==null)
           {
             PDF::SetXY(15, 50);
             PDF::Cell(49,7,'Nombre Responsable:',0,0,'L',0);
             PDF::SetXY(50, 50);
             PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');


           }else{

            PDF::SetXY(15, 50);
            PDF::Cell(49,7,'Modulo y/o Centro Acopio:',0,0,'L',0);
            PDF::SetXY(55, 50);
            PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_modulo'],0,1,'L',0), true, true, false, '');
           }

            PDF::SetXY(15, 60);
            PDF::Cell(49,7,'Fecha Acopio:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(38, 60);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_fecha'],0,1,'L',0), true, true, false, '');
            

            if($modulo['recmod_id_turno']==1){

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 70);
            PDF::Cell(49,7,'Turno:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(31, 70);
            PDF::writeHTML('',PDF::Cell(131,7,'Mañana',0,1,'L',0), true, true, false, '');
            }else{
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 70);
            PDF::Cell(49,7,'Turno:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(31, 70);
            PDF::writeHTML('',PDF::Cell(131,7,'Tarde',0,1,'L',0), true, true, false, '');
            }

            if($modulo['recmod_acepta']==1){
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 70);
            PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(105, 70);
            PDF::writeHTML('',PDF::Cell(131,7,'Aceptado',0,1,'L',0), true, true, false, '');
            }else{
            PDF::SetXY(80, 70);
            PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(105, 70);
            PDF::writeHTML('',PDF::Cell(131,7,'Rechazado',0,1,'L',0), true, true, false, '');
            }


            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 80);
            PDF::Cell(40,8,'Cantidad de baldes:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(49 , 80);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_bal_recep'],0,1,'L',0), true, true, false, '');

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 80);
            PDF::Cell(49,7,'Cantidad Recepcionada:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(115 , 80);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_recep'].' '.'Litros',0,1,'L',0), true, true, false, '');
            

            PDF::Ln(30);
            PDF::SetFont('helvetica','B',7);
            PDF::SetXY(25, 130);
            PDF::Cell(70,6,utf8_decode('Entregue Conforme (Proveedor)'),0,1,'C',0);
            PDF::SetXY(10, 135);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(15,6,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');
          
            PDF::SetXY(15, 140);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(45,6,$modulo['modulo_ci'],0,1,'L',0), true, true, false, '');
            //$pdf->Cell(45,6,'',0,1,'L',0);

            PDF::SetXY(125, 130);
            PDF::Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            PDF::SetXY(120, 135);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(15,6,$modulo['prs_nombres'].' '.$modulo['prs_paterno'].' '.$modulo['prs_materno'],0,1,'L',0), true, true, false, '');
          
            PDF::SetXY(120, 140);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
            PDF::writeHTML('',PDF::Cell(45,6,$modulo['prs_ci'],0,1,'L',0), true, true, false, '');

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
           PDF::Cell(10,10,utf8_decode('BOLETA DE ACOPIO LACTEOS'),0,1,'C',0);
           PDF::SetXY(100, 163);
           PDF::Cell(10,10,utf8_decode('PLANTA'.' '.$modulo['nombre_planta']),0,1,'C',0);

           PDF::SetFont('helvetica','B',9);
           PDF::SetXY(150,155);
           PDF::Cell(45,20, utf8_decode('COPIA PROVEEDOR'),1,1,'C',0);
           PDF::SetXY(150,95);



            if ($modulo['modulo_modulo']==null)
           {
             PDF::SetXY(15, 185);
             PDF::Cell(49,7,'Nombre Responsable:',0,0,'L',0);
             PDF::SetXY(50, 185);
             PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');


           }else{

            PDF::SetXY(15, 185);
            PDF::Cell(49,7,'Modulo y/o Centro Acopio:',0,0,'L',0);
            PDF::SetXY(55, 185);
            PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_modulo'],0,1,'L',0), true, true, false, '');
           }
          

            PDF::SetXY(15, 195);
            PDF::Cell(49,7,'Fecha Acopio:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(38, 195);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_fecha'],0,1,'L',0), true, true, false, '');

            if($modulo['recmod_id_turno']==1){
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 205);
            PDF::Cell(49,7,'Turno:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(31, 205);
            PDF::writeHTML('',PDF::Cell(131,7,'Mañana',0,1,'L',0), true, true, false, '');
            }else{
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 205);
            PDF::Cell(49,7,'Turno:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(31, 205);
            PDF::writeHTML('',PDF::Cell(131,7,'Tarde',0,1,'L',0), true, true, false, '');
            }

            if($modulo['recmod_acepta']==1){
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 205);
            PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(110, 205);
            PDF::writeHTML('',PDF::Cell(131,7,'Aceptado',0,1,'L',0), true, true, false, '');
            }else{
            PDF::SetXY(80, 205);
            PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(110, 205);
            PDF::writeHTML('',PDF::Cell(131,7,'Rechazado',0,1,'L',0), true, true, false, '');
            }

            
            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(15, 215);
            PDF::Cell(40,8,'Cantidad de baldes:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(49 , 215);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_bal_recep'],0,1,'L',0), true, true, false, '');

            PDF::SetFont('helvetica','B',8);
            PDF::SetXY(80, 215);
            PDF::Cell(49,7,'Cantidad Recepcionada:',0,0,'L',0);
            PDF::SetFont('helvetica','',8);
            PDF::SetXY(115 , 215);
            PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_recep'].' '.'Litros',0,1,'L',0), true, true, false, '');


            PDF::Ln(60);
            PDF::SetFont('helvetica','B',7);
            PDF::SetXY(25, 255);
            PDF::Cell(70,6,utf8_decode('Entregue Conforme (Proveedor)'),0,1,'C',0);
            PDF::SetXY(10, 260);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(15,6,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');


            PDF::SetXY(15, 265);
            PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
            PDF::writeHTML('',PDF::Cell(45,6,$modulo['modulo_ci'],0,1,'L',0), true, true, false, '');

            PDF::SetXY(125, 255);
            PDF::Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
            PDF::SetXY(120, 260);
            PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
            PDF::SetXY(135, 260);
            PDF::writeHTML('',PDF::Cell(15,6,$modulo['prs_nombres'].' '.$modulo['prs_paterno'].' '.$modulo['prs_materno'],0,1,'L',0), true, true, false, '');
            PDF::SetXY(120, 265);
            PDF::Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
            PDF::SetXY(135, 265);
            PDF::writeHTML('',PDF::Cell(45,6,$modulo['prs_ci'],0,1,'L',0), true, true, false, '');

            PDF::Line(35, 252, 85, 252); 
            PDF::Line(135, 252,186, 252); 

            PDF::Output();

   
        PDF::SetTitle('Boleta de Acopio');
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
     //    $turno = Usuario::where('usr_id','=',Auth::user()->usr_id)->first();
     //    $tur = $turno['usr_id_turno'];

     //    $persona = Persona::join('public._bp_usuarios as usr', 'public._bp_personas.prs_id','=','usr.usr_prs_id')
     //                      ->where('usr_id','=',Auth::user()->usr_id)
     //                      ->first();

     //    $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
     //                        ->where('usr_id','=',Auth::user()->usr_id)
     //                        ->first();  
     //    $modulo = Modulo::join('acopio.recepcion_modulo as recep', 'acopio.modulo.modulo_id','=','recep.recmod_id_mod')
     //                     ->where('recep.recmod_id',$id)
     //                     ->first();
     //       PDF::AddPage();

     //       PDF::SetFont('helvetica','B',12);
     //       PDF::Ln(5); 
     //       PDF::Cell(45,0,'',0,1,'C');
     //       PDF::Cell(45,20,PDF::Image('img/logopeqe.png',13,18,'R',25),1,0,'C');

     //       PDF::MultiCell(95, 20, '', 1, 0, 0, 'L');
     //       PDF::SetXY(60, 20);
     //       PDF::Cell(95,10,utf8_decode('BOLETA DE ACOPIO LACTEOS'),0,1,'C',0);
     //       PDF::SetXY(60, 30);
     //       PDF::Cell(95,10,utf8_decode('PLANTA'.' '.$planta['nombre_planta']),0,1,'C',0);

     //       PDF::SetFont('helvetica','B',9);
     //       PDF::SetXY(150, 20);
     //       PDF::Cell(45,20, utf8_decode('COPIA PLANTA'),1,1,'C',0);
     //       PDF::SetXY(150, 30);

     //       if ($modulo['modulo_modulo']==null)
     //       {
     //         PDF::SetXY(15, 50);
     //         PDF::Cell(49,7,'Nombre Responsable:',0,0,'L',0);
     //         PDF::SetXY(50, 50);
     //         PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');


     //       }else{

     //        PDF::SetXY(15, 50);
     //        PDF::Cell(49,7,'Modulo y/o Centro Acopio:',0,0,'L',0);
     //        PDF::SetXY(55, 50);
     //        PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_modulo'],0,1,'L',0), true, true, false, '');
     //       }

     //        PDF::SetXY(15, 60);
     //        PDF::Cell(49,7,'Fecha Acopio:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(38, 60);
     //        PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_fecha'],0,1,'L',0), true, true, false, '');
            

     //        if($modulo['recmod_id_turno']==1){

     //        PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(15, 70);
     //        PDF::Cell(49,7,'Turno:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(31, 70);
     //        PDF::writeHTML('',PDF::Cell(131,7,'Mañana',0,1,'L',0), true, true, false, '');
     //        }elseif($modulo['recmod_id_turno']==2){
     //        PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(15, 70);
     //        PDF::Cell(49,7,'Turno:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(31, 70);
     //        PDF::writeHTML('',PDF::Cell(131,7,'Tarde',0,1,'L',0), true, true, false, '');
     //        }else{
     //        PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(15, 70);
     //        PDF::Cell(49,7,'Turno:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(31, 70);
     //        PDF::writeHTML('',PDF::Cell(131,7,'No corresponde',0,1,'L',0), true, true, false, ''); 
     //        }

     //        if($modulo['recmod_acepta']==1){
     //        PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(80, 70);
     //        PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(105, 70);
     //        PDF::writeHTML('',PDF::Cell(131,7,'Aceptado',0,1,'L',0), true, true, false, '');
     //        }else{
     //        PDF::SetXY(80, 70);
     //        PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(105, 70);
     //        PDF::writeHTML('',PDF::Cell(131,7,'Rechazado',0,1,'L',0), true, true, false, '');
     //        }


     //        PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(15, 80);
     //        PDF::Cell(40,8,'Cantidad de baldes:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(49 , 80);
     //        PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_bal_recep'],0,1,'L',0), true, true, false, '');

     //        PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(80, 80);
     //        PDF::Cell(49,7,'Cantidad Recepcionada:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(115 , 80);
     //        PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_recep'].' '.'Litros',0,1,'L',0), true, true, false, '');
            

     //        PDF::Ln(30);
     //        PDF::SetFont('helvetica','B',7);
     //        PDF::SetXY(25, 130);
     //        PDF::Cell(70,6,utf8_decode('Entregue Conforme (Proveedor)'),0,1,'C',0);
     //        PDF::SetXY(10, 135);
     //        PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
     //        PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
     //        PDF::writeHTML('',PDF::Cell(15,6,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');
          
     //        PDF::SetXY(15, 140);
     //        PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
     //        PDF::Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
     //        PDF::writeHTML('',PDF::Cell(45,6,$modulo['modulo_ci'],0,1,'L',0), true, true, false, '');
     //        //$pdf->Cell(45,6,'',0,1,'L',0);

     //        PDF::SetXY(125, 130);
     //        PDF::Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
     //        PDF::SetXY(120, 135);
     //        PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
     //        PDF::writeHTML('',PDF::Cell(15,6,$persona['prs_nombres'].' '.$persona['prs_paterno'].' '.$persona['prs_materno'],0,1,'L',0), true, true, false, '');
          
     //        PDF::SetXY(120, 140);
     //        PDF::Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
     //        PDF::writeHTML('',PDF::Cell(45,6,$persona['prs_ci'],0,1,'L',0), true, true, false, '');

     //        PDF::Line(35, 128, 85, 128); 
     //        PDF::Line(135, 128,186, 128); 
            

     //    ///////////// BOLETA PROVEEDOR ////////////////////

     //       PDF::SetFont('helvetica','B',12);
     //       PDF::Ln(4); 
     //       PDF::Cell(45,0,'',0,1,'C');
     //       PDF::Cell(45,20,PDF::Image('img/logopeqe1.png',13,152,'',25),1,0,'C');
     //       // PDF::Cell(45,20,PDF::Image('img/email/logosedem1.png',23,157,'',15),1,0,'C');

     //       PDF::MultiCell(95, 20, '', 1, 0, 0, 'L');
     //       PDF::SetXY(100, 155);
     //       PDF::Cell(10,10,utf8_decode('BOLETA DE ACOPIO LACTEOS'),0,1,'C',0);
     //       PDF::SetXY(100, 163);
     //       PDF::Cell(10,10,utf8_decode('PLANTA'.' '.$planta['nombre_planta']),0,1,'C',0);

     //       PDF::SetFont('helvetica','B',9);
     //       PDF::SetXY(150,155);
     //       PDF::Cell(45,20, utf8_decode('COPIA PROVEEDOR'),1,1,'C',0);
     //       PDF::SetXY(150,95);



     //        if ($modulo['modulo_modulo']==null)
     //       {
     //         PDF::SetXY(15, 185);
     //         PDF::Cell(49,7,'Nombre Responsable:',0,0,'L',0);
     //         PDF::SetXY(50, 185);
     //         PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');


     //       }else{

     //        PDF::SetXY(15, 185);
     //        PDF::Cell(49,7,'Modulo y/o Centro Acopio:',0,0,'L',0);
     //        PDF::SetXY(55, 185);
     //        PDF::writeHTML('',PDF::Cell(0,7,$modulo['modulo_modulo'],0,1,'L',0), true, true, false, '');
     //       }
          

     //        PDF::SetXY(15, 195);
     //        PDF::Cell(49,7,'Fecha Acopio:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(38, 195);
     //        PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_fecha'],0,1,'L',0), true, true, false, '');

     //        if($modulo['recmod_id_turno']==1){
     //        PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(15, 205);
     //        PDF::Cell(49,7,'Turno:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(31, 205);
     //        PDF::writeHTML('',PDF::Cell(131,7,'Mañana',0,1,'L',0), true, true, false, '');
     //        }elseif($modulo['recmod_id_turno']==2){
     //        PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(15, 205);
     //        PDF::Cell(49,7,'Turno:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(31, 205);
     //        PDF::writeHTML('',PDF::Cell(131,7,'Tarde',0,1,'L',0), true, true, false, '');
     //        }else{
     //         PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(15, 205);
     //        PDF::Cell(49,7,'Turno:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(31, 205);
     //        PDF::writeHTML('',PDF::Cell(131,7,'No corresponde',0,1,'L',0), true, true, false, '');
     //        }

     //        if($modulo['recmod_acepta']==1){
     //        PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(80, 205);
     //        PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(110, 205);
     //        PDF::writeHTML('',PDF::Cell(131,7,'Aceptado',0,1,'L',0), true, true, false, '');
     //        }else{
     //        PDF::SetXY(80, 205);
     //        PDF::Cell(49,7,'Cert. Aceptacion:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(110, 205);
     //        PDF::writeHTML('',PDF::Cell(131,7,'Rechazado',0,1,'L',0), true, true, false, '');
     //        }

            
     //        PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(15, 215);
     //        PDF::Cell(40,8,'Cantidad de baldes:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(49 , 215);
     //        PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_bal_recep'],0,1,'L',0), true, true, false, '');

     //        PDF::SetFont('helvetica','B',8);
     //        PDF::SetXY(80, 215);
     //        PDF::Cell(49,7,'Cantidad Recepcionada:',0,0,'L',0);
     //        PDF::SetFont('helvetica','',8);
     //        PDF::SetXY(115 , 215);
     //        PDF::writeHTML('',PDF::Cell(131,7,$modulo['recmod_cant_recep'].' '.'Litros',0,1,'L',0), true, true, false, '');


     //        PDF::Ln(60);
     //        PDF::SetFont('helvetica','B',7);
     //        PDF::SetXY(25, 255);
     //        PDF::Cell(70,6,utf8_decode('Entregue Conforme (Proveedor)'),0,1,'C',0);
     //        PDF::SetXY(10, 260);
     //        PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
     //        PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'L',0);
     //        PDF::writeHTML('',PDF::Cell(15,6,$modulo['modulo_nombre'].' '.$modulo['modulo_paterno'].' '.$modulo['modulo_materno'],0,1,'L',0), true, true, false, '');


     //        PDF::SetXY(15, 265);
     //        PDF::Cell(15,6,utf8_decode(''),0,0,'L',0);
     //        PDF::Cell(15,6,utf8_decode('CI:'),0,0,'L',0);
     //        PDF::writeHTML('',PDF::Cell(45,6,$modulo['modulo_ci'],0,1,'L',0), true, true, false, '');

     //        PDF::SetXY(125, 255);
     //        PDF::Cell(70,6,utf8_decode('Responsable de Acopio - EBA'),0,1,'C',0);
     //        PDF::SetXY(120, 260);
     //        PDF::Cell(15,6,utf8_decode('Nombre:'),0,0,'C',0);
     //        PDF::SetXY(135, 260);
     //        PDF::writeHTML('',PDF::Cell(15,6,$persona['prs_nombres'].' '.$persona['prs_paterno'].' '.$persona['prs_materno'],0,1,'L',0), true, true, false, '');
     //        PDF::SetXY(120, 265);
     //        PDF::Cell(15,6,utf8_decode('CI:'),0,0,'C',0);
     //        PDF::SetXY(135, 265);
     //        PDF::writeHTML('',PDF::Cell(45,6,$persona['prs_ci'],0,1,'L',0), true, true, false, '');

     //        PDF::Line(35, 252, 85, 252); 
     //        PDF::Line(135, 252,186, 252); 

     //        PDF::Output();

   
     //    PDF::SetTitle('Boleta de Acopio');
     //    PDF::SetFont('helvetica', '', 10);
     //    //CUERPO
     //    $style = array(
     //        'border'  => false,
     //        'padding' => 0,
     //        'fgcolor' => array(128, 0, 0),
     //        'bgcolor' => false,
     //    );
     // //   PDF::writeHTML($html, true, false, true, false, '');

     //    PDF::Output('hello_world.pdf');   
    }

}
