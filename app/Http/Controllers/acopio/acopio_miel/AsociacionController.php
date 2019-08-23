<?php

namespace siga\Http\Controllers\acopio\acopio_miel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use siga\Modelo\acopio\acopio_miel\Asociacion;
use siga\Http\Requests;
use siga\Http\Controllers\Controller;
use Auth;

class AsociacionController extends Controller
{
    public function index()
    {
    	$asociacion = Asociacion::getListar();

    	return view();
    }

    public function store(Request $request)
    {	
        $this->validate(request(), [
                'nombre_asociacion' => 'required',
                'sigla' => 'required',
                'aso_municipio' => 'required',                
        ]);
        $asociacion = Asociacion::where('aso_nombre','=',$request['nombre_asociacion'])->where('aso_id_mun','=',$request['aso_municipio'])->first();
        if ($asociacion == null) {
            Asociacion::create([
                'aso_nombre'   	=> $request['nombre_asociacion'],
                'aso_sigla'   	=> $request['sigla'],
                'aso_id_mun'	=> $request['aso_municipio'],
                'aso_estado'	=> 'A',
                'aso_fecha_reg'	=> '2018-10-23 17:30:30',
                'aso_id_usr'	=> Auth::user()->usr_id,
                'aso_id_linea'  => 3,
            ]);
            return response()->json(['Mensaje' => 'Se registro correctamente']);
        } else {
            return "existe";
        }
        
    }

    // BUSCADOR
    public function obtenerAso(Request $request)
    {
        $term = $request->term ?: '';
        $tags = Asociacion::join('acopio.municipio as mun','acopio.asociacion.aso_id_mun','=','mun.mun_id')
                    ->select('acopio.asociacion.aso_id','acopio.asociacion.aso_nombre','mun.mun_nombre')
                    ->where('aso_nombre', 'like', $term.'%')->orWhere('mun_nombre','like','%'.$term.'%')->take(15)->get();
        $valid_tags = [];
        foreach ($tags as $tag) {
            $valid_tags[] = ['id' => $tag->aso_id, 'text' => $tag->mun_nombre.'-'.$tag->aso_nombre];
        }
        return \Response::json($valid_tags);
    }
}
