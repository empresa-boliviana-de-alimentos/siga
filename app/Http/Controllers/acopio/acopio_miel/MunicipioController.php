<?php

namespace siga\Http\Controllers\acopio\acopio_miel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use siga\Modelo\acopio\acopio_miel\Municipio;
use siga\Http\Requests;
use siga\Http\Controllers\Controller;

class MunicipioController extends Controller
{   
    public function index(Request $request)
    {
     
    }

    public function store(Request $request)
    {	
        $this->validate(request(), [
                'nombre_municipio' => 'required',
                'municipio_departamento' => 'required',                
        ]);
        $municipio = Municipio::where('mun_nombre','=',$request['nombre_municipio'])->where('mun_id_dep','=',$request['municipio_departamento'])->first();
        if ($municipio == null) {
            Municipio::create([
                'mun_nombre'     => $request['nombre_municipio'],
                'mun_id_dep'     => $request['municipio_departamento'],
            ]);
            return response()->json(['Mensaje' => 'Se registro correctamente']);
        }else{
            
            return "existe";
        }
        
    }

    public function buscar(Request $request)
    {
        $search = $request->get('search');
        $data = Municipio::select(['id_municipio', 'municipio'])->where('municipio', 'like', '%' . $search . '%')->orderBy('municipio')->paginate(5);
        return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
    }
    // BUSCADORES
    public function obtenerMuni(Request $request)
    {
        $term = $request->term ?: '';
        $tags = Municipio::join('acopio.departamento as dep','acopio.municipio.mun_id_dep','=','dep.dep_id')
                        ->select('acopio.municipio.mun_id','acopio.municipio.mun_nombre','dep.dep_nombre')
                        ->where('mun_nombre', 'like', '%'.$term.'%')->orWhere('dep_nombre','like','%'.$term.'%')->take(15)->get();
        $valid_tags = [];
        foreach ($tags as $tag) {
            $valid_tags[] = ['id' => $tag->mun_id, 'text' => $tag->dep_nombre.'-'.$tag->mun_nombre];
        }
        return \Response::json($valid_tags);
    }
}
