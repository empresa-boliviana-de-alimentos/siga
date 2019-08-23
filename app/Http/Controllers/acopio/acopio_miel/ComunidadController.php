<?php

namespace siga\Http\Controllers\acopio\acopio_miel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use siga\Modelo\acopio\acopio_miel\Comunidad;
use siga\Http\Requests;
use siga\Http\Controllers\Controller;

class ComunidadController extends Controller
{
    public function index()
    {
    	$comunidad = Comunidad::getListar();

    	return view();
    }

    public function store(Request $request)
    {	
        $this->validate(request(), [
                'nombre_comunidad' => 'required',
                'com_municipio' => 'required',                
        ]);
        $comunidad = Comunidad::where('com_nombre','=',$request['nombre_comunidad'])->where('com_id_mun','=',$request['com_municipio'])->first();
        if ($comunidad == null) {
            Comunidad::create([
                'com_nombre'  => $request['nombre_comunidad'],
                'com_id_mun'  => $request['com_municipio'],
                'com_estado'  => 'A'
            ]);
            return response()->json(['Mensaje' => 'Se registro correctamente']);
        } else {
            return "existe";
        }    
    }

    // BUSCADOR
    public function obtenerComu(Request $request)
    {
        $term = $request->term ?: '';
        $tags = Comunidad::join('acopio.municipio as mun','acopio.comunidad.com_id_mun','=','mun.mun_id')
                    ->select('acopio.comunidad.com_id','acopio.comunidad.com_nombre','mun.mun_nombre')
                    ->where('com_nombre', 'like', $term.'%')->orWhere('mun_nombre','like','%'.$term.'%')->take(15)->get();
        $valid_tags = [];
        foreach ($tags as $tag) {
            $valid_tags[] = ['id' => $tag->com_id, 'text' => $tag->mun_nombre.'-'.$tag->com_nombre];
        }
        return \Response::json($valid_tags);
    }
}
