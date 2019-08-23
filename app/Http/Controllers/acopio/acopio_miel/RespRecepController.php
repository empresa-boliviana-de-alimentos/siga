<?php

namespace siga\Http\Controllers\acopio\acopio_miel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use siga\Modelo\acopio\acopio_miel\Resp_Recep;
use siga\Http\Requests;
use siga\Http\Controllers\Controller;

class RespRecepController extends Controller
{
    public function index()
    {
    	$resp_recep = Resp_Recep::getListar();

    	return view();
    }

    public function store(Request $request)
    {	
        Resp_Recep::create([
            'rec_nombre' 	=> $request['rec_nombre'],
            'rec_ap'		=> $request['rec_ap'],
            'rec_am'		=> $request['rec_am'],
            'rec_ci'		=> $request['rec_ci'],
            'rec_tipo'		=> 1,
            'rec_id_linea' 	=> 3,
            'rec_estado'    => 'A'
        ]);

        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    // BUSCADOR
    public function obtenerRespRece(Request $request)
    {
        $term = $request->term ?: '';
        $tags = Resp_Recep::where('rec_nombre', 'like', '%'.$term.'%')->orWhere('rec_ap','like','%'.$term.'%')->orWhere('rec_am','like','%'.$term.'%')->take(6)->get();
        $valid_tags = [];
        foreach ($tags as $tag) {
            $valid_tags[] = ['id' => $tag->rec_id, 'text' => $tag->rec_nombre.' '.$tag->rec_ap.' '.$tag->rec_am];
        }
        return \Response::json($valid_tags);
    }
}
