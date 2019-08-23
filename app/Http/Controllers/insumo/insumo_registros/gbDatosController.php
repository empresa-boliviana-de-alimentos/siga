<?php

namespace siga\Http\Controllers\insumo\insumo_registros;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use siga\Modelo\insumo\insumo_registros\Datos;
use siga\Modelo\insumo\insumo_registros\Partida;
use siga\Modelo\insumo\insumo_registros\Categoria;
use siga\Modelo\insumo\insumo_registros\UnidadMedida;
use siga\Modelo\insumo\insumo_registros\TipoIngreso;
use siga\Modelo\insumo\insumo_registros\TipoInsumo;
use siga\Modelo\insumo\insumo_registros\TipoEnvase;
use siga\Modelo\insumo\insumo_registros\Mercado;
use siga\Modelo\insumo\insumo_registros\Color;
use siga\Modelo\insumo\insumo_registros\Sabor;
use siga\Modelo\insumo\insumo_registros\LineaProduccion;
use siga\Modelo\insumo\insumo_registros\ProductoEspecifico;
use siga\Modelo\insumo\insumo_registros\Municipio;
use siga\Modelo\insumo\insumo_registros\SubLinea;
use siga\Modelo\insumo\insumo_registros\PlantaMaquila;
use siga\Modelo\admin\Usuario;//NEW
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Auth;

class gbDatosController extends Controller
{
    public function index()
    {
    	$dataPartida=Partida::combo();
        $datalinprod=LineaProduccion::where('linea_prod_estado','A')->get();
    	return view('backend.administracion.insumo.insumo_registro.datos.index',compact('dataPartida','datalinprod'));
    }

    public function create()
    {
        $categoria = Categoria::where('cat_estado','A')
                              ->orderbydesc('cat_id')
                              ->get();
        return Datatables::of($categoria)->addColumn('acciones', function ($categoria) {
            return '<button value="' . $categoria->cat_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarCategoria(this);" data-toggle="modal" data-target="#myUpdateCat"><i class="fa fa-pencil-square"></i></button><button value="' . $categoria->cat_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarCategoria(this);"><i class="fa fa-trash-o"></i></button>';
        })
            ->editColumn('id', 'ID: {{$cat_id}}')
            ->make(true);
    }

    public function listUnidadMedida()
    {
        $unidad = UnidadMedida::where('umed_estado','A')->orderbydesc('umed_id')->get();
        return Datatables::of($unidad)->addColumn('acciones', function ($unidad) {
            return '<button value="' . $unidad->umed_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarUnidadMedida(this);" data-toggle="modal" data-target="#myUpdateUni"><i class="fa fa-pencil-square"></i></button><button value="' . $unidad->umed_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarUnidadMedida(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$umed_id}}')
        ->make(true);
    }

    public function listPartida()
    {
        $partida = Partida::where('part_estado','A')->where('part_id','<>',1)->orderbydesc('part_id')->get();
        return Datatables::of($partida)->addColumn('acciones', function ($partida) {
            return '<button value="' . $partida->part_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarPartida(this);" data-toggle="modal" data-target="#myUpdatePart"><i class="fa fa-pencil-square"></i></button><button value="' . $partida->part_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarPartida(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$part_id}}')
        ->make(true);
    }

    public function listTipoIngreso()
    {
        $ingreso = TipoIngreso::where('ting_estado','A')->orderbydesc('ting_id')->get();
        return Datatables::of($ingreso)->addColumn('acciones', function ($ingreso) {
            return '<button value="' . $ingreso->ting_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarTipoIngreso(this);" data-toggle="modal" data-target="#myUpdateIng"><i class="fa fa-pencil-square"></i></button><button value="' . $ingreso->ting_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarTipoIngreso(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$ting_id}}')
        ->make(true);
    }

    public function listTipoInsumo()
    {
        $tipoins = TipoInsumo::where('tins_estado','A')->orderbydesc('tins_id')->get();
        return Datatables::of($tipoins)->addColumn('acciones', function ($tipoins) {
            return '<button value="' . $tipoins->tins_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarTipoInsumo(this);" data-toggle="modal" data-target="#myUpdateIns"><i class="fa fa-pencil-square"></i></button><button value="' . $tipoins->tins_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarTipoInsumo(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$tins_id}}')
        ->make(true);
    }

    public function listTipoEnvase()
    {
        $tipoenv = TipoEnvase::where('tenv_estado','A')->orderbydesc('tenv_id')->get();
        return Datatables::of($tipoenv)->addColumn('acciones', function ($tipoenv) {
            return '<button value="' . $tipoenv->tenv_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarTipoEnvase(this);" data-toggle="modal" data-target="#myUpdateTipEnv"><i class="fa fa-pencil-square"></i></button><button value="' . $tipoenv->tenv_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarTipoEnvase(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$tenv_id}}')
        ->make(true);
    }

    public function listMercado()
    {
        $mercado = Mercado::where('mer_estado','A')->orderbydesc('mer_id')->get();
        return Datatables::of($mercado)->addColumn('acciones', function ($mercado) {
            return '<button value="' . $mercado->mer_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarMercado(this);" data-toggle="modal" data-target="#myUpdateMercado"><i class="fa fa-pencil-square"></i></button><button value="' . $mercado->mer_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarMercado(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$mer_id}}')
        ->make(true);
    }

    public function listColor()
    {
        $color = Color::where('col_estado','A')->orderbydesc('col_id')->get();
        return Datatables::of($color)->addColumn('acciones', function ($color) {
            return '<button value="' . $color->col_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarColor(this);" data-toggle="modal" data-target="#myUpdateColor"><i class="fa fa-pencil-square"></i></button><button value="' . $color->col_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarColor(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$col_id}}')
        ->make(true);
    }

    public function listSabor()
    {
        $sabor = Sabor::where('sab_estado','A')->orderbydesc('sab_id')->get();
        return Datatables::of($sabor)->addColumn('acciones', function ($sabor) {
            return '<button value="' . $sabor->sab_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarSabor(this);" data-toggle="modal" data-target="#myUpdateSabor"><i class="fa fa-pencil-square"></i></button><button value="' . $sabor->sab_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarSabor(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$sab_id}}')
        ->make(true);
    }

    public function listLineaProd()
    {
        $linea = LineaProduccion::where('linea_prod_estado','A')->orderbydesc('linea_prod_id')->get();
        return Datatables::of($linea)->addColumn('acciones', function ($linea) {
            return '<button value="' . $linea->linea_prod_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarLinProd(this);" data-toggle="modal" data-target="#myUpdateLineaProd"><i class="fa fa-pencil-square"></i></button><button value="' . $linea->linea_prod_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarLinProd(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$linea_prod_id}}')
        ->make(true);
    }

    public function listProdEspe()
    {
        $prod = ProductoEspecifico::where('prod_esp_estado','A')->orderbydesc('prod_esp_id')->get();
        return Datatables::of($prod)->addColumn('acciones', function ($prod) {
            return '<button value="' . $prod->prod_esp_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarProdEsp(this);" data-toggle="modal" data-target="#myUpdateProdEsp"><i class="fa fa-pencil-square"></i></button><button value="' . $prod->prod_esp_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarProdEsp(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$prod_esp_id}}')
        ->make(true);
    }

    public function listMunicipio()
    {
        $municipio = Municipio::where('muni_estado','A')->orderbydesc('muni_id')->get();
        return Datatables::of($municipio)->addColumn('acciones', function ($municipio) {
            return '<button value="' . $municipio->muni_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarMunicipio(this);" data-toggle="modal" data-target="#myUpdateMunicipio"><i class="fa fa-pencil-square"></i></button><button value="' . $municipio->muni_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarMunicipio(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$muni_id}}')
        ->make(true);
    }

    public function listSubLinea()
    {
        $sub = SubLinea::where('sublin_estado','A')->orderbydesc('sublin_id')->get();
        return Datatables::of($sub)->addColumn('acciones', function ($sub) {
            return '<button value="' . $sub->sublin_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarSubLin(this);" data-toggle="modal" data-target="#myUpdateSubLinea"><i class="fa fa-pencil-square"></i></button><button value="' . $sub->sublin_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarSubLinea(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$sublin_id}}')
        -> addColumn('produccion', function ($produccion) {
                if($produccion->sublin_prod_id==1)
                { 
                    return '<h5 class="">LACTEOS</h5>'; 
                }
                if($produccion->sublin_prod_id==2)
                { 
                    return '<h5 class="">ALMENDRA</h5>'; 
                }
                if($produccion->sublin_prod_id==3)
                { 
                    return '<h5 class="">MIEL</h5>'; 
                }
                if($produccion->sublin_prod_id==4)
                { 
                    return '<h5 class="">FRUTOS</h5>'; 
                }
                if($produccion->sublin_prod_id==5)
                { 
                    return '<h5 class="">DERIVADOS</h5>'; 
                }
        })  
        ->make(true);
    }

     public function listPlantaMaquila()
    {
        $maquila = PlantaMaquila::where('maquila_estado','A')->orderbydesc('maquila_id')->get();
        return Datatables::of($maquila)->addColumn('acciones', function ($maquila) {
            return '<button value="' . $maquila->maquila_id . '" class="btncirculo btn-xs btn-warning" onClick="MostrarPlantaMaquila(this);" data-toggle="modal" data-target="#myUpdatePlanMaquila"><i class="fa fa-pencil-square"></i></button><button value="' . $maquila->maquila_id . '" class="btncirculo btn-xs btn-danger" onClick="EliminarPlantaMaquila(this);"><i class="fa fa-trash-o"></i></button>';
        })
        ->editColumn('id', 'ID: {{$maquila_id}}')
        ->make(true);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'nombre_categoria'    => 'required',
            //'partida_categoria'   => 'required|min:1',
        ]); 
        $fecha=date('Y-m-d');
        Categoria::create([
            'cat_nombre'          => $request['nombre_categoria'],
            //'cat_id_partida'      => $request['partida_categoria'],
            'cat_usr_id'		  => Auth::user()->usr_id,
            'cat_registrado'      => $fecha,
            'cat_modificado'      => $fecha,  
            'cat_estado'          => 'A',
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function storeUni(Request $request)
    {   
        $this->validate(request(), [
            'nombre_unidad_medida'  => 'required',
            'sigla_unidad_medida'   => 'required',
        ]); 
        $fecha=date('Y-m-d');
        UnidadMedida::create([
            'umed_nombre'         => $request['nombre_unidad_medida'],
            'umed_sigla'          => $request['sigla_unidad_medida'],
            'umed_estado'		  => 'A',
            'umed_usr_id'         => Auth::user()->usr_id,
            'umed_registrado'     => $fecha,
            'umed_modificado'     => $fecha,  
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function storePartida(Request $request)
    {
        $this->validate(request(), [
            'nombre_de_partida'  => 'required',
        ]); 
        $fecha=date('Y-m-d');
        Partida::create([
            'part_codigo'          => $request['codigo_de_partida'],
            'part_nombre'          => $request['nombre_de_partida'],
            'part_estado'		   => 'A',
            'part_usr_id'          => Auth::user()->usr_id,
            'part_registrado'      => $fecha,
            'part_modificado'      => $fecha,
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function storeTipoIng(Request $request)
    {
        $this->validate(request(), [
            'nombre_ingreso'  => 'required',
        ]); 
        $fecha=date('Y-m-d');
        TipoIngreso::create([
            'ting_nombre'           => $request['nombre_ingreso'],
            'ting_estado'		   => 'A',
            'ting_usr_id'           => Auth::user()->usr_id,
            'ting_registrado'       => $fecha,
            'ting_modificado'       => $fecha,
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function storeIns(Request $request)
    {
        $this->validate(request(), [
            'nombre_tipo_insumo'  => 'required',
        ]); 
        $fecha=date('Y-m-d');
        TipoInsumo::create([
            'tins_nombre'         => $request['nombre_tipo_insumo'],
            'tins_estado'		  => 'A',
            'tins_usr_id'         => Auth::user()->usr_id,
            'tins_registrado'     => $fecha,
            'tins_modificado'     => $fecha,
        ]);
        return response()->json(['Mensaje' => 'Se registro correctamente']);
    }

    public function storeTipEnv(Request $request)
    {
        $this->validate(request(),[
            'nombre_tipo_envase'=>'required',
        ]);
        $fecha=date('Y-m-d');
        TipoEnvase::create([
            'tenv_nombre'       => $request['nombre_tipo_envase'],
            'tenv_estado'       => 'A',
            'tenv_usr_id'       => Auth::user()->usr_id,
            'tenv_registrado'   => $fecha,
            'tenv_modificado'   => $fecha,
        ]);
        return response()->json(['Mensaje'=>'Se registro correctamente']);
    }

    public function storeMercado(Request $request)
    {
        $this->validate(request(),[
            'mer_nombre'=>'required',
        ]);
        $fecha=date('Y-m-d');
        Mercado::create([
            'mer_nombre'       => $request['mer_nombre'],
            'mer_estado'       => 'A',
            'mer_usr_id'       => Auth::user()->usr_id,
            'mer_registrado'   => $fecha,
            'mer_modificado'   => $fecha,
        ]);
        return response()->json(['Mensaje'=>'Se registro correctamente']);
    }

    public function storeColor(Request $request)
    {
        $this->validate(request(),[
            'col_nombre'=>'required',
        ]);
        $fecha=date('Y-m-d');
        Color::create([
            'col_nombre'       => $request['col_nombre'],
            'col_estado'       => 'A',
            'col_usr_id'       => Auth::user()->usr_id,
            'col_registrado'   => $fecha,
            'col_modificado'   => $fecha,
        ]);
        return response()->json(['Mensaje'=>'Se registro correctamente']);
    }

    public function storeSabor(Request $request)
    {
        $this->validate(request(),[
            'sab_nombre'=>'required',
        ]);
        $fecha=date('Y-m-d');
        Sabor::create([
            'sab_nombre'       => $request['sab_nombre'],
            'sab_estado'       => 'A',
            'sab_usr_id'       => Auth::user()->usr_id,
            'sab_registrado'   => $fecha,
            'sab_modificado'   => $fecha,
        ]);
        return response()->json(['Mensaje'=>'Se registro correctamente']);
    }

    public function storeLinProd(Request $request)
    {
        $this->validate(request(),[
            'linea_prod_nombre'=>'required',
        ]);
        $fecha=date('Y-m-d');
        LineaProduccion::create([
            'linea_prod_nombre'       => $request['linea_prod_nombre'],
            'linea_prod_estado'       => 'A',
            'linea_prod_usr_id'       => Auth::user()->usr_id,
            'linea_prod_registrado'   => $fecha,
            'linea_prod_modificado'   => $fecha,
        ]);
        return response()->json(['Mensaje'=>'Se registro correctamente']);
    }

    public function storeProdEsp(Request $request)
    {
        $this->validate(request(),[
            'prod_esp_nombre'=>'required',
        ]);
        $fecha=date('Y-m-d');
        ProductoEspecifico::create([
            'prod_esp_nombre'       => $request['prod_esp_nombre'],
            'prod_esp_estado'       => 'A',
            'prod_esp_usr_id'       => Auth::user()->usr_id,
            'prod_esp_registrado'   => $fecha,
            'prod_esp_modificado'   => $fecha,
        ]);
        return response()->json(['Mensaje'=>'Se registro correctamente']);
    }

    public function storeMunicipio(Request $request)
    {
        $this->validate(request(),[
            'muni_nombre'=>'required',
        ]);
        $fecha=date('Y-m-d');
        Municipio::create([
            'muni_nombre'       => $request['muni_nombre'],
            'muni_estado'       => 'A',
            'muni_usr_id'       => Auth::user()->usr_id,
            'muni_registrado'   => $fecha,
            'muni_modificado'   => $fecha,
        ]);
        return response()->json(['Mensaje'=>'Se registro correctamente']);
    }

    public function storeSubLinea(Request $request)
    {
        $this->validate(request(),[
            'sublin_nombre'=>'required',
        ]);
        $fecha=date('Y-m-d');
        SubLinea::create([
            'sublin_nombre'       => $request['sublin_nombre'],
            'sublin_prod_id'      => $request['sublin_prod_id'],
            'sublin_estado'       => 'A',
            'sublin_usr_id'       => Auth::user()->usr_id,
            'sublin_registrado'   => $fecha,
            'sublin_modificado'   => $fecha,
        ]);
        return response()->json(['Mensaje'=>'Se registro correctamente']);
    }

    public function storePlantaMaquila(Request $request)
    {
        $this->validate(request(),[
            'maquila_nombre'=>'required',
        ]);
        $fecha=date('Y-m-d');
        PlantaMaquila::create([
            'maquila_nombre'       => $request['maquila_nombre'],
            'maquila_estado'       => 'A',
            'maquila_usr_id'       => Auth::user()->usr_id,
            'maquila_registrado'   => $fecha,
            'maquila_modificado'   => $fecha,
        ]);
        return response()->json(['Mensaje'=>'Se registro correctamente']);
    }

    public function edit($id)
    {
        $categoria = Categoria::setBuscar($id);
        return response()->json($categoria);
    }

    public function editUnidadMedida($id)
    {
        $medida = UnidadMedida::setBuscar($id);
        return response()->json($medida);
    }

    public function editPartida($id)
    {
        $partida = Partida::setBuscar($id);
        return response()->json($partida);
    }

    public function editTipoIngreso($id)
    {
        $ingreso = TipoIngreso::setBuscar($id);
        return response()->json($ingreso);
    }

    public function editTipoInsumo($id)
    {
        $insumo = TipoInsumo::setBuscar($id);
        return response()->json($insumo);
    }

    public function editTipoEnvase($id)
    {
        $envase = TipoEnvase::setBuscar($id);
        return response()->json($envase);
    }

    public function editMercado($id)
    {
        $mercado = Mercado::setBuscar($id);
        return response()->json($mercado);
    }

    public function editColor($id)
    {
        $color = Color::setBuscar($id);
        return response()->json($color);
    }

    public function editSabor($id)
    {
        $sabor = Sabor::setBuscar($id);
        return response()->json($sabor);
    }

    public function editLinProd($id)
    {
        $linea = LineaProduccion::setBuscar($id);
        return response()->json($linea);
    }

    public function editSubLinea($id)
    {
        $sub = SubLinea::setBuscar($id);
        return response()->json($sub);
    }

    public function editProdEsp($id)
    {
        $especifico = ProductoEspecifico::setBuscar($id);
        return response()->json($especifico);
    }

    public function editMunicipio($id)
    {
        $municipio = Municipio::setBuscar($id);
        return response()->json($municipio);
    }

    public function editPlantaMaquila($id)
    {
        $maquila = PlantaMaquila::setBuscar($id);
        return response()->json($maquila);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);
        $categoria->fill($request->all());
        $categoria->save();
        return response()->json(['mensaje' => 'Se actualizo el categoria']);
    }

    public function updateUniMedida(Request $request, $id)
    {
        $medida = UnidadMedida::find($id);
        $medida->fill($request->all());
        $medida->save();
        return response()->json(['mensaje' => 'Se actualizo el medida']);
    }


    public function updatePartida(Request $request, $id)
    {
        $partida = Partida::find($id);
        $partida->fill($request->all());
        $partida->save();
        return response()->json(['mensaje' => 'Se actualizo el partida']);
    }

    public function updateTipoIngreso(Request $request, $id)
    {
        $ingreso = TipoIngreso::find($id);
        $ingreso->fill($request->all());
        $ingreso->save();
        return response()->json(['mensaje' => 'Se actualizo el ingreso']);
    }

    public function updateTipoInsumo(Request $request, $id)
    {
        $insumo = TipoInsumo::find($id);
        $insumo->fill($request->all());
        $insumo->save();
        return response()->json(['mensaje' => 'Se actualizo el insumo']);
    }


    public function updateTipoEnvase(Request $request, $id)
    {
        $envase = TipoEnvase::find($id);
        $envase->fill($request->all());
        $envase->save();
        return response()->json(['mensaje' => 'Se actualizo el envase']);
    }

    public function updateMercado(Request $request, $id)
    {
        $mercado = Mercado::find($id);
        $mercado->fill($request->all());
        $mercado->save();
        return response()->json(['mensaje' => 'Se actualizo el mercado']);
    }

    public function updateColor(Request $request, $id)
    {
        $color = Color::find($id);
        $color->fill($request->all());
        $color->save();
        return response()->json(['mensaje' => 'Se actualizo el color']);
    }

    public function updateSabor(Request $request, $id)
    {
        $sabor = Sabor::find($id);
        $sabor->fill($request->all());
        $sabor->save();
        return response()->json(['mensaje' => 'Se actualizo el color']);
    }

    public function updateLinProd(Request $request, $id)
    {
        $linea = LineaProduccion::find($id);
        $linea->fill($request->all());
        $linea->save();
        return response()->json(['mensaje' => 'Se actualizo el linea']);
    }

    public function updateSubLin(Request $request, $id)
    {
        $sub = SubLinea::find($id);
        $sub->fill($request->all());
        $sub->save();
        return response()->json(['mensaje' => 'Se actualizo el sub-linea']);
    }

    public function updateProdEsp(Request $request, $id)
    {
        $especifico = ProductoEspecifico::find($id);
        $especifico->fill($request->all());
        $especifico->save();
        return response()->json(['mensaje' => 'Se actualizo el sub-linea']);
    }

    public function updateMunicipio(Request $request, $id)
    {
        $municipio = Municipio::find($id);
        $municipio->fill($request->all());
        $municipio->save();
        return response()->json(['mensaje' => 'Se actualizo el sub-linea']);
    }

    public function updatePlantaMaquila(Request $request, $id)
    {
        $maquila = PlantaMaquila::find($id);
        $maquila->fill($request->all());
        $maquila->save();
        return response()->json(['mensaje' => 'Se actualizo el sub-linea']);
    }

    public function destroy($id)
    {
        $categoria = Categoria::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroyUnidadMedida($id)
    {
        $medida = UnidadMedida::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroyPartida($id)
    {
        $partida = Partida::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroyTipoIngreso($id)
    {
        $ingreso = TipoIngreso::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroyTipoInsumo($id)
    {
        $insumo = TipoInsumo::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroyTipoEnvase($id)
    {
        $envase = TipoEnvase::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroyMercado($id)
    {
        $mercado = Mercado::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroyColor($id)
    {
        $color = Color::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroySabor($id)
    {
        $sabor = Sabor::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroyLinProd($id)
    {
        $linea = LineaProduccion::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroySubLinea($id)
    {
        $sub = SubLinea::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroyProdEsp($id)
    {
        $especifico = ProductoEspecifico::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroyMunicipio($id)
    {
        $municipio = Municipio::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }

    public function destroyPlantaMaquila($id)
    {
        $maquila = PlantaMaquila::getDestroy($id);
        return response()->json(['mensaje' => 'Se elimino correctamente']);
    }
}
