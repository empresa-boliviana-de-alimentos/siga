<?php

namespace siga\Http\Controllers\insumo\insumo_registros;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_registros\Ufv;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use siga\Modelo\admin\Usuario;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class gbUfvController extends Controller
{
    public function index()
    {
        $fech= Ufv::getfecha();   
        $fecha= $fech['ufv_registrado'];
    	return view('backend.administracion.insumo.insumo_registro.ufv.index', compact('fecha'));
    }

    public function create()
    {
        $ufv = Ufv::getListar();
        return Datatables::of($ufv)->addColumn('acciones', function ($ufv) {
            return '<button value="' . $ufv->ufv_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarUfv(this);" data-toggle="modal" data-target="#myUpdateUfv"><i class="fa fa-pencil-square"></i></button>';
        })
            ->editColumn('id', 'ID: {{$ufv_id}}')
            ->make(true);
    }
    public function store(Request $request)
    {
        $this->validate(request(), [
            'ufv' => 'required|regex:/[\d]{5}/',               
        ]); 
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                          ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $fecha1=date('d/m/Y');
        Ufv::create([
            'ufv_cant'        => $request['ufv'],
            'ufv_registrado'  => $fecha1,
            'ufv_estado'      => 'A',
            'ufv_id_planta'   => $planta->id_planta,
            'ufv_usr_id'      => Auth::user()->usr_id,
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function edit($id)
    {
        $ufv = Ufv::setBuscar($id);
        return response()->json($ufv);
    }

    public function update(Request $request, $id)
    {
        $ufv = Ufv::setBuscar($id);
        $ufv->fill($request->all());
        $ufv->save();
        return response()->json($ufv->toArray());
    }

    public function destroy($id)
    {
        $ufv = Ufv::getDestroy($id);
        return response()->json($ufv);

    }

    public function reporteUfvExcel()
    {
        $ufvs = Ufv::get();
                //dd($ufvs);
        \Excel::create('UFVRegistro', function($excel) use ($ufvs) {
             $excel->sheet('Excel sheet', function($sheet) use ($ufvs) {
                $sheet->loadView('backend.administracion.insumo.insumo_reportes_excel.reporteUfv', array('ufvs'=>$ufvs));
            });
        })->export('xlsx');
    }

}
