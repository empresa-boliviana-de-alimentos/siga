<?php

namespace siga\Http\Controllers\acopio\acopio_almendra;

use Illuminate\Http\Request;

use siga\Http\Requests;
use siga\Http\Controllers\Controller;
use siga\Modelo\acopio\acopio_almendra\Solicitud;
use siga\Modelo\acopio\acopio_almendra\Asignacion;

class gbAsignacion extends Controller
{
   /*public function registroAsig(Request $request, $id)
    {
        $asig = Solicitud::setBuscar($id)
        Asignacion::create([
            'asig_id_sol'         => $request['asig_id_sol'],
            'asig_id_comp'        => 1,
            'asig_monto'          => $request['asig_monto'],
            'asig_fecha'          => $request['asig_fecha'],
            'asig_obs'            => $request['asig_obs'],
            'asig_id_usr'         => 1,
            'asig_estado'         => 'A',$request['asig_estado'],
            'asig_fecha_reg'      => $request['asig_fecha_reg'],,
           // 'prs_usr_id'             => Auth::user()->usr_id,
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

     public function edit($id)
    {
        $solicitud = Solicitud::setBuscar($id);
        return response()->json($solicitud);
    }*/
}
