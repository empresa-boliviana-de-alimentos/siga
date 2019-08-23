<?php

namespace siga\Http\Controllers\insumo\insumo_registros;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_registros\Servicio;
use siga\Modelo\admin\Usuario;//NEW
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Auth;

class gbServiciosController extends Controller
{
     public function index()
    {
        $planta_id = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->first();
        
        $plantas = DB::table('public._bp_planta')->where('id_linea_trabajo',$planta_id->id_linea_trabajo)->get();
    	return view('backend.administracion.insumo.insumo_registro.servicios.index',compact('plantas'));
    }

    public function create()
    {
        $servicio = Servicio::where('serv_estado','A')->get();
        return Datatables::of($servicio)->addColumn('acciones', function ($servicio) {
            return '<button value="' . $servicio->serv_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarServ(this);" data-toggle="modal" data-target="#myUpdateServ"><i class="fa fa-pencil-square"></i></button><button value="' . $servicio->serv_id . '" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
        })
            ->editColumn('id', 'ID: {{$serv_id}}')
           -> addColumn('mes', function ($mes) {
                if($mes->serv_id_mes==1)
                { return '<h4 class="text"><span class="label label-success">ENERO</span></h4>'; }
                if($mes->serv_id_mes==2)
                { return '<h4 class="text"><span class="label label-success">FEBRERO</span></h4>'; }
                if($mes->serv_id_mes==3)
                { return '<h4 class="text-"><span class="label label-success">MARZO</span></h4>'; }
                if($mes->serv_id_mes==4)
                { return '<h4 class="text"><span class="label label-success">ABRIL</span></h4>'; }
                if($mes->serv_id_mes==5)
                { return '<h4 class="text"><span class="label label-success">MAYO</span></h4>'; }
                if($mes->serv_id_mes==6)
                { return '<h4 class="text"><span class="label label-success">JUNIO</span></h4>'; }
                if($mes->serv_id_mes==7)
                { return '<h4 class="text"><span class="label label-success">JULIO</span></h4>'; }
                if($mes->serv_id_mes==8)
                { return '<h4 class="text-"><span class="label label-success">AGOSTO</span></h4>'; }
                if($mes->serv_id_mes==9)
                { return '<h4 class="text"><span class="label label-success">SEPTIEMBRE</span></h4>'; }
                if($mes->serv_id_mes==10)
                { return '<h4 class="text"><span class="label label-success">OCTUBRE</span></h4>'; }
                if($mes->serv_id_mes==11)
                { return '<h4 class="text"><span class="label label-success">NOVIEMBRE</span></h4>'; }
                if($mes->serv_id_mes==12)
                { return '<h4 class="text"><span class="label label-success">DICIEMBRE</span></h4>'; }
             })  
            ->make(true);
    }

     public function store(Request $request)
    {
        $this->validate(request(), [
            'nombre_servicio'   =>  'required',
            'empresa_servicio'  =>  'required',
            'nit'               =>  'required',
            'nro_factura'       =>  'required',
            'costo_servicio'    =>  'required',
            'mes_servicio'      =>  'required'
        ]); 
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        Servicio::create([
            'serv_nom'        => $request['nombre_servicio'],
            'serv_emp'        => $request['empresa_servicio'],
            'serv_nit'        => $request['nit'],
            'serv_nfact'      => $request['nro_factura'],
            'serv_costo'      => $request['costo_servicio'],
            'serv_id_mes'     => $request['mes_servicio'],
            'serv_estado'     => 'A',
            'serv_fecha_pago' => $request['fecha_pago'],
            'serv_obs'        => $request['observacion'],
            'serv_usr_id'     => Auth::user()->usr_id,
            'serv_id_planta'  => $request['planta'],
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function edit($id)
    {
        $servicio = Servicio::setBuscar($id);
        return response()->json($servicio);
    }

    public function update(Request $request, $id)
    {
        $servicio = Servicio::setBuscar($id);
        $servicio->fill($request->all());
        $servicio->save();
        return response()->json($servicio->toArray());
    }

    public function destroy($id)
    {
        $servicio = Servicio::getDestroy($id);
        return response()->json($servicio);

    }

}
