<?php

namespace siga\Http\Controllers\acopio\acopio_miel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use siga\Modelo\acopio\acopio_miel\Destino;
use siga\Http\Requests;
use siga\Http\Controllers\Controller;

class DestinoController extends Controller
{
    public function index()
    {
    	$destino = Destino::getListar();

    	return view();
    }

    public function store(Request $request)
    {	
        Destino::create([
            'des_descripcion' => $request['des_descripcion'],
            'des_estado'  	  => 'A',
            'des_fecha_reg'   => '2018-10-29 16:00:00'
        ]);

        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    // BUSCADOR
    public function obtenerDesti(Request $request)
    {
        $term = $request->term ?: '';
        $tags = Destino::where('des_descripcion', 'like', '%'.$term.'%')->take(6)->get();
        $valid_tags = [];
        foreach ($tags as $tag) {
            $valid_tags[] = ['id' => $tag->des_id, 'text' => $tag->des_descripcion ];
        }
        return \Response::json($valid_tags);
    }
}
