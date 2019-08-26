<?php

namespace siga\Http\Controllers\insumo\insumo_registros;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_registros\Insumo;
use siga\Modelo\insumo\insumo_registros\Datos;
use siga\Modelo\insumo\insumo_registros\Partida;
use siga\Modelo\insumo\insumo_registros\Categoria;
use siga\Modelo\insumo\insumo_registros\TipoInsumo;
use siga\Modelo\insumo\insumo_registros\TipoEnvase;
use siga\Modelo\insumo\insumo_registros\UnidadMedida;
use siga\Modelo\insumo\insumo_registros\Color;
use siga\Modelo\insumo\insumo_registros\Sabor;
use siga\Modelo\insumo\insumo_registros\LineaProduccion;
use siga\Modelo\insumo\insumo_registros\ProductoEspecifico;
use siga\Modelo\insumo\insumo_registros\Mercado;
use siga\Modelo\insumo\insumo_registros\Municipio;
use siga\Modelo\admin\Usuario;//NEW
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Auth;

class gbInsumoController extends Controller
{
    public function index()
    {
        $dataIns = TipoInsumo::where('tins_estado','A')->get();
        $dataPart = Partida::where('part_estado','A')->get();        
        $dataCat = Categoria::where('cat_estado','A')->get();
        $dataUni = UnidadMedida::where('umed_estado','A')->get();
        $dataTipEnv = TipoEnvase::where('tenv_estado','A')->get();
        $dataColor = Color::where('col_estado','A')->get();
        $dataSabor = Sabor::where('sab_estado','A')->get();
        $dataLineaProd = LineaProduccion::where('linea_prod_estado','A')->get();
        $dataProdEspe = ProductoEspecifico::where('prod_esp_estado','A')->get();
        $dataMunicipio = Municipio::where('muni_estado','A')->get();
        $dataMercado = Mercado::where('mer_estado','A')->get(); 
        //dd($dataTipEnv);
    	return view('backend.administracion.insumo.insumo_registro.insumo.index',compact('dataIns','dataPart','dataCat','dataUni','dataTipEnv','dataColor','dataSabor','dataLineaProd','dataProdEspe','dataMunicipio','dataMercado'));
    }

    public function create()
    {
        $insumo = Insumo::getListar();
        return Datatables::of($insumo)->addColumn('acciones', function ($insumo) {
            return '<button value="' . $insumo->ins_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarInsumo(this);" data-toggle="modal" data-target="#myUpdateIns"><i class="fa fa-pencil-square"></i></button><button value="' . $insumo->ins_id . '" class="btncirculo btn-xs btn-danger" onClick="Eliminar(this);"><i class="fa fa-trash-o"></i></button>';
        })->addColumn('peso_formato', function ($peso_formato) {
            if ($peso_formato->ins_peso_presen) {
                return $peso_formato->ins_peso_presen;
            }else{
                return $peso_formato->ins_formato;
            }
        })->addColumn('nombre_generico', function ($nombre_generico) {
            if ($nombre_generico->ins_peso_presen) {
                if ($nombre_generico->sab_id == 1) {
                    return $nombre_generico->ins_desc.' '.$nombre_generico->ins_peso_presen;
                }else{
                    return $nombre_generico->ins_desc.' '.$nombre_generico->sab_nombre.' '.$nombre_generico->ins_peso_presen;
                }
                
            }else{
                if ($nombre_generico->sab_id == 1) {
                    return $nombre_generico->ins_desc.' '.$nombre_generico->ins_formato;
                }else{
                    return $nombre_generico->ins_desc.' '.$nombre_generico->sab_nombre.' '.$nombre_generico->ins_formato;
                }
                
            }            
        })
            ->editColumn('id', 'ID: {{$ins_id}}')
            ->make(true);
    }

     public function store(Request $request)
    {
        $this->validate(request(), [
            //'codigo_insumo'     => 'required|unique:pgsql.insumo.insumo,ins_codigo',
            //'categoria_insumo'  => 'required|min:1',
            'tipo_de_insumo'    => 'required|min:1',
            'partida_insumo'    => 'required|min:1',
            //'unidad_medida'     => 'required|min:1',
            'descripcion_insumo'=> 'required',

        ]);
        $tipo_insumo = TipoInsumo::where('tins_id',$request['tipo_de_insumo'])->first();
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                    ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        if ($tipo_insumo->tins_nombre == 'ENVASE') {            
            $num = Insumo::select(DB::raw('MAX(ins_enumeracion) as nrocod'))->where('ins_id_tip_ins',$tipo_insumo->tins_id)->first();
            $cont=$num['nrocod'];
            $nroCod = $cont + 1;
            $nroCodCadena = 'ENV-'.$nroCod;
        } elseif($tipo_insumo->tins_nombre == 'INSUMO'){
            $num = Insumo::select(DB::raw('MAX(ins_enumeracion) as nrocod'))->where('ins_id_tip_ins',$tipo_insumo->tins_id)->first();
            $cont=$num['nrocod'];
            $nroCod = $cont + 1;
            $nroCodCadena = 'INS-'.$nroCod;
        } elseif($tipo_insumo->tins_nombre == 'MATERIA PRIMA'){
            $num = Insumo::select(DB::raw('MAX(ins_enumeracion) as nrocod'))->where('ins_id_tip_ins',$tipo_insumo->tins_id)->first();
            $cont=$num['nrocod'];
            $nroCod = $cont + 1;
            $nroCodCadena = 'MAP-'.$nroCod;

        } elseif($tipo_insumo->tins_nombre == 'SABORIZANTE'){
            $num = Insumo::select(DB::raw('MAX(ins_enumeracion) as nrocod'))->where('ins_id_tip_ins',1)->first();
            $cont=$num['nrocod'];
            $nroCod = $cont + 1;
            $nroCodCadena = 'INS-'.$nroCod;
        }
        Insumo::create([
            'ins_codigo'            => $nroCodCadena,
            'ins_enumeracion'       => $nroCod,
            //'ins_id_cat'        => $request['categoria_insumo'],
            'ins_id_part'           => $request['partida_insumo'],
            'ins_id_uni'            => $request['unidad_medida'],
            'ins_desc'              => $request['descripcion_insumo'],
            'ins_id_tip_ins'        => $request['tipo_de_insumo'],
            'ins_id_tip_env'        => $request['tipo_envase'],
            //'ins_estado'            => 'A',
            'ins_usr_id'            => Auth::user()->usr_id,
            'ins_id_planta'         => $planta->id_planta,
            //NUEVOS DATOS
            'ins_id_mercado'        => $request['mercado'],
            'ins_id_sabor'          => $request['sabor'],
            'ins_id_color'          => $request['color'],
            'ins_id_municipio'      => $request['municipio'],
            'ins_id_linea_prod'     => $request['linea_produccion'],
            'ins_peso_presen'       => $request['presentacion'],
            'ins_formato'           => $request['formato'],
            'ins_id_prod_especi'    => $request['producto_especifico'],

            //'linea_produccion':$('#id_linea_prod').val(),
                //'mercado':$('#id_mercado').val(),
                //'formato':$('#formato').val(),
                //'municipio':$('#id_municipio').val(),
                //'producto_especifico':$('#id_prod_especifico').val(),
                //'sabor':$('#id_sabor').val(),
                //'color':$('#id_color').val(),
                //'presentacion':$('#presentacion').val(),
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }
    

    public function edit($id)
    {
        $insumo = Insumo::setBuscar($id);
        return response()->json($insumo);
    }

    public function update(Request $request, $id)
    {
        $insumo = Insumo::setBuscar($id);
        $insumo->fill($request->all());
        $insumo->save();
        return response()->json($insumo->toArray());
    }

    public function destroy($id)
    {
        $insumo = Insumo::getDestroy($id);
        return response()->json($insumo);

    }
}
