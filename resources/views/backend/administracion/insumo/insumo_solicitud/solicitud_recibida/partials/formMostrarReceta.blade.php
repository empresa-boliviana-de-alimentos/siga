@extends('backend.template.app')
<style type="text/css" media="screen">
  .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td{
    padding: 1px;
}
table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px 10px;
    color: dimgrey;
    font-size: 8px;
}
</style>
@section('main-content')
<?php
    function stock_actualOP($id_insumo)
    {
        $planta = \DB::table('public._bp_usuarios')->join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                        ->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $stock_actual =DB::table('insumo.stock')->select(DB::raw('SUM(stock_cantidad) as stock_cantidad'))->where('stock_planta_id','=',$planta->id_planta)
                                ->where('stock_ins_id','=',$id_insumo)->first();
        return $stock_actual->stock_cantidad;
    }
 ?>
<div class="row">
    <div class="col-md-12">
        <div class="container col-lg-12" style="background: white;">
            <?php $now = new DateTime('America/La_Paz'); ?>
            <div class="text-center">
                <h3 style="color:#2067b4"><strong>ENTREGA PEDIDO RECETA</strong></h3>
            </div>
            <div class="text-center">
            	<h3>Código: ORP-{{$sol_orden_produccion->orprod_nro_orden}}</h3>
            </div>
            <form action="{{ url('AprobacionReceta') }}" class="form-horizontal" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="id_orp" id="nro_acopio" value="{{ $sol_orden_produccion->orprod_id}}">
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Producto:
                                    </label>
                                    <input type="text" name="" value="{{$receta->rece_nombre}} {{ $receta->sab_nombre}} {{ $receta->rece_presentacion }} {{$receta->umed_nombre}}" class="form-control" readonly="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Cantidad a Producir:
                                    </label>
                                    <input type="text" value="{{$sol_orden_produccion->orprod_cantidad}}" name="" class="form-control" readonly="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Cantidad Esperada:
                                    </label>
                                    <input type="text" value="{{$sol_orden_produccion->orprod_cant_esp}}" class="form-control" name="" readonly="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Rendimiento Base:
                                    </label>
                                    <input type="text" value="{{$receta->rece_rendimiento_base}}" class="form-control" name="" readonly="true">
                                </div>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Tiempo a Producir:
                                    </label>
                                    <input type="text" value="{{$sol_orden_produccion->orprod_tiempo_prod}}" class="form-control" name="" readonly="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Observacion Pedido:
                                    </label>
                                    <textarea type="text" value="" class="form-control" name="" readonly="true">{{$sol_orden_produccion->orprod_obs_usr}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Observacion Pedido 2:
                                    </label>
                                    <textarea type="text" value="" class="form-control" name="" readonly="true">{{$sol_orden_produccion->orprod_obs_vo}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Observacion Jefe de Planta:
                                    </label>
                                    <textarea type="text" value="" class="form-control" name="" readonly="true">{{$sol_orden_produccion->orprod_obs_vodos}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-9">
                @if($receta->rece_lineaprod_id == 2 OR $receta->rece_lineaprod_id == 3)
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">MATERIA PRIMA</h3>
                            </div>
                            <div class="panel-body">
                            		<?php
	                                    $detalle_formulacion_map = \DB::table('insumo.detalle_receta')->join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
	                                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
	                                                                        ->where('ins_id_tip_ins',3)
                                                                            ->where('detrece_rece_id',$receta->rece_id)
                                                                            ->get();

	                                    $calculos = $sol_orden_produccion->orprod_cantidad/$receta->rece_rendimiento_base;
                                    ?>
                                    
                                        <table  class="table table-hover small-text" id="TableRecetasMatPrim">
                                            <thead>
                                                <tr>
                                                    <th>Cod Insumo</th>
                                                    <th>Insumo</th>
                                                    <th>Unidad Medida</th>
                                                    <th>Cant. Base</th>
                                                    <th>Cantidad</th>
                                                    <th>Stock Actual</th>
                                                    <th>Deshabilitar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($detalle_formulacion_map as $dorp)
                                                <tr>
                                                    <td>{{$dorp->ins_codigo}}</td>
                                                    <td>{{$dorp->ins_desc}}</td>
                                                    <td>{{$dorp->umed_nombre}}</td>
                                                    <td>{{$dorp->detrece_cantidad}}</td>
                                                    <td>{{$dorp->detrece_cantidad*$calculos}}</td>
                                                    @if($dorp->detrece_cantidad*$calculos > stock_actualOP($dorp->ins_id))
                                                    	<td style="background: #E99786">{{stock_actualOP($dorp->ins_id)}}</td>
                                                    @else
                                                    	<td style="background: #84E53C">{{stock_actualOP($dorp->ins_id)}}</td>
                                                    @endif
                                                    @php
                                                    	$datos_stock[] = array('cantidadSol'=>$dorp->detrece_cantidad*$calculos,'cantidadStock'=>stock_actualOP($dorp->ins_id));
                                                    @endphp
                                                    <td class="text-center"><input type="checkbox" name="detorprod_estado[]"></td>
                                                    <td><input type="hidden" name="detorprod_id[]" value="{{$dorp->detorprod_id}}"></td>
                                                    <td><input type="hidden" name="detorprod_cantidad[]" value="{{$dorp->detorprod_cantidad}}"></td>
                                                    <td><input type="hidden" name="detorprod_ins_id[]" value="{{$dorp->detorprod_ins_id}}"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                </div>
                        </div>
                    </div>
                
                @endif

                @if ($receta->rece_lineaprod_id==1 OR $receta->rece_lineaprod_id == 4 OR $receta->rece_lineaprod_id == 5)
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">FORMULACIÓN DE LA BASE</h3>
                            </div>
                            <div class="panel-body">
                                    <?php

                                    $insumo_insumo = \DB::table('insumo.detalle_orden_produccion')->join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',1)
                                                        ->where('detorprod_orprod_id',$sol_orden_produccion->orprod_id)->get();
                                    $insumo_matprima = \DB::table('insumo.detalle_orden_produccion')->join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                                        ->where('ins_id_tip_ins',3)
                                                                        ->where('detorprod_orprod_id',$sol_orden_produccion->orprod_id)->get();
                                    foreach ($insumo_insumo as $ins) {
                                        $detalle_formulacion[] = array("ins_id"=>$ins->ins_id,"ins_codigo"=>$ins->ins_codigo,"ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detorprod_cantidad"=>$ins->detorprod_cantidad,"detorprod_cantidad_cal"=>$ins->detorprod_cantidad_cal,"detorprod_id"=>$ins->detorprod_id);
                                    }
                                    foreach ($insumo_matprima as $ins) {
                                        $detalle_formulacion[] = array("ins_id"=>$ins->ins_id,"ins_codigo"=>$ins->ins_codigo,"ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detorprod_cantidad"=>$ins->detorprod_cantidad,"detorprod_cantidad_cal"=>$ins->detorprod_cantidad_cal,"detorprod_id"=>$ins->detorprod_id);
                                    }
                                    $calculos = $sol_orden_produccion->orprod_cantidad/$receta->rece_rendimiento_base;
                                    ?>
                                    
                                        <table  class="table table-hover small-text" id="TableRecetasBase">
                                            <thead>
                                                <tr>
                                                    <th>Cod Insumo</th>
                                                    <th>Insumo</th>
                                                    <th>Unidad Medida</th>
                                                    <th>Cant. Base</th>
                                                    <th>Cantidad</th>
                                                    <th>Stock Actual</th>
                                                    <th>Deshabilitar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($detalle_formulacion as $dorp)
                                                <tr>
                                                    <td>{{$dorp['ins_codigo']}}</td>
                                                    <td>{{$dorp['ins_desc']}}</td>
                                                    <td>{{$dorp['umed_nombre']}}</td>
                                                    <td>{{$dorp['detorprod_cantidad_cal']}}</td>
                                                    <td>{{$dorp['detorprod_cantidad']}}</td>
                                                    @if($dorp['detorprod_cantidad'] > stock_actualOP($dorp['ins_id']))
                                                    	<td style="background: #E99786">{{stock_actualOP($dorp['ins_id'])}}</td>
                                                    @else
                                                    	<td style="background: #84E53C">{{stock_actualOP($dorp['ins_id'])}}</td>
                                                    @endif
                                                    @php
                                                    	$datos_stock[] = array('cantidadSol'=>$dorp['detorprod_cantidad'],'cantidadStock'=>stock_actualOP($dorp['ins_id']));
                                                    @endphp
                                                    <td class="text-center"><input type="checkbox" name="detorprod_estado[]"></td>
                                                    <td><input type="hidden" name="detorprod_id[]" value="{{$dorp['detorprod_id']}}"></td>
                                                    <td><input type="hidden" name="detorprod_cantidad[]" value="{{$dorp['detorprod_cantidad']}}"></td>
                                                    <td><input type="hidden" name="detorprod_ins_id[]" value="{{$dorp['ins_id']}}"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>


                                    </div>
                        </div>
                    </div>
                @endif
                @if ($receta->rece_lineaprod_id == 1 OR $receta->rece_lineaprod_id == 4 OR $receta->rece_lineaprod_id == 5)
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">SABORIZACIÓN</h3>
                            </div>
                            <div class="panel-body">
                                    <?php

                                    $detalle_formulacion = \DB::table('insumo.detalle_orden_produccion')->join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                                        ->where('ins_id_tip_ins',4)
                                                                        ->where('detorprod_orprod_id',$sol_orden_produccion->orprod_id)->get();
                                    $calculos = $sol_orden_produccion->orprod_cantidad/$receta->rece_rendimiento_base;
                                    ?>
                                    
                                        <table  class="table table-hover small-text" id="TableRecetasSab">
                                            <thead>
                                                <tr>
                                                    <th>Cod Insumo</th>
                                                    <th>Insumo</th>
                                                    <th>Unidad Medida</th>
                                                    <th>Cant. Base</th>
                                                    <th>Cantidad</th>
                                                    <th>Stock Actual</th>
                                                    <th>Deshabilitar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($detalle_formulacion as $dorp)
                                                <tr>
                                                    <td>{{$dorp->ins_codigo}}</td>
                                                    <td>{{$dorp->ins_desc}}</td>
                                                    <td>{{$dorp->umed_nombre}}</td>
                                                    <td>{{$dorp->detorprod_cantidad_cal}}</td>
                                                    <td>{{$dorp->detorprod_cantidad}}</td>
                                                    @if($dorp->detorprod_cantidad > stock_actualOP($dorp->ins_id))
                                                    	<td style="background: #E99786">{{stock_actualOP($dorp->ins_id)}}</td>
                                                    @else
                                                    	<td style="background: #84E53C">{{stock_actualOP($dorp->ins_id)}}</td>
                                                    @endif
                                                    @php
                                                    	$datos_stock[] = array('cantidadSol'=>$dorp->detorprod_cantidad,'cantidadStock'=>stock_actualOP($dorp->ins_id));
                                                    @endphp
                                                    <td class="text-center"><input type="checkbox" name="detorprod_estado[]"></td>
                                                    <td><input type="hidden" name="detorprod_id[]" value="{{$dorp->detorprod_id}}"></td>
                                                    <td><input type="hidden" name="detorprod_cantidad[]" value="{{$dorp->detorprod_cantidad}}"></td>
                                                    <td><input type="hidden" name="detorprod_ins_id[]" value="{{$dorp->detorprod_ins_id}}"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>


                                    </div>
                        </div>
                    </div>
                @endif

                   <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">MATERIAL DE ENVASADO</h3>
                            </div>
                            <div class="panel-body">
                                    <?php

                                    $detalle_formulacion = \DB::table('insumo.detalle_orden_produccion')->join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                                        ->where('ins_id_tip_ins',2)
                                                                        ->where('detorprod_orprod_id',$sol_orden_produccion->orprod_id)->get();

                                    $calculos = $sol_orden_produccion->orprod_cantidad/$receta->rece_rendimiento_base;
                                    ?>
                                    
                                        <table  class="table table-hover small-text" id="TableRecetasEnv">
                                            <thead>
                                                <tr>
                                                    <th>Cod Insumo</th>
                                                    <th>Insumo</th>
                                                    <th>Unidad Medida</th>
                                                    <th>Cant. Base</th>
                                                    <th>Cantidad</th>
                                                    <th>Stock Actual</th>
                                                    <th>Deshabilitar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($detalle_formulacion as $dorp)
                                                <tr>
                                                    <td>{{$dorp->ins_codigo}}</td>
                                                    <td>{{$dorp->ins_desc}}</td>
                                                    <td>{{$dorp->umed_nombre}}</td>
                                                    <td>{{$dorp->detorprod_cantidad}}</td>
                                                    <td>{{$dorp->detorprod_cantidad}}</td>
                                                    @if($dorp->detorprod_cantidad > stock_actualOP($dorp->ins_id))

                                                    	<td style="background: #E99786">{{stock_actualOP($dorp->ins_id)}}</td>
                                                    @else
                                                    	<td style="background: #84E53C">{{stock_actualOP($dorp->ins_id)}}</td>
                                                    	<input type="hidden" value="verficaStock($dorp->detorprod_cantidad,stock_actualOP($dorp->ins_id));" name="">
                                                    @endif
                                                    @php
                                                    	$datos_stock[] = array('cantidadSol'=>$dorp->detorprod_cantidad,'cantidadStock'=>stock_actualOP($dorp->ins_id));
                                                    @endphp
                                                    <td class="text-center"><input type="checkbox" name="detorprod_estado[]"></td>
                                                    <td><input type="hidden" name="detorprod_id[]" value="{{$dorp->detorprod_id}}"></td>
                                                    <td><input type="hidden" name="detorprod_cantidad[]" value="{{$dorp->detorprod_cantidad}}"></td>
                                                    <td><input type="hidden" name="detorprod_ins_id[]" value="{{$dorp->detorprod_ins_id}}"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>


                                    </div>
                        </div>
                    </div>
                    <!--INSUMO ADICIONAL-->
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">ADICCION INSUMO EXTRA</h3>
                            </div>
                                <div class="panel-body">
                                    <div class="">
                                        <div class="">
                                            <a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="Add More Person"><span class="btn btn-primary">Añadir Insumo</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <table  class="table table-hover small-text" id="tb">
                                            <tr class="tr-header">
                                                <th>Descripcion</th>
                                                <th>Unidad</th>
                                                <th>Cantidad</th>
                                                <th>Stock</th>
                                                <th>Opcion</th>
                                                <!-- <th>Rango Adicional</th>                                             -->
                                            <tr class="items_columsReceta2" id="tdformbase">
                                                <td><select name="descripcion_base[]" class="descripcion_base form-control">
                                                        <!--<option value="">Seleccione</option>-->
                                                        @foreach($listarInsumo as $insumo)
                                                            <option value="{{$insumo->ins_id}}">{{ $insumo->ins_codigo.' - '.$insumo->ins_desc.' '.$insumo->sab_nombre.' '.$insumo->ins_peso_presen}}</option>
                                                        @endforeach
                                                    </select>
                                                <td id="tdformbaseuni">
                                                    <input type="" name="" class="form-control" readonly>
                                                </td>
                                                <td><input type="text" name="detorprod_cantidad_adi[]" class="form-control"></td>
                                                <td id="tdformbasestock">
                                                    <input type="" name="" readonly="" class="stock form-control">
                                                </td>
                                                <td><div class="text-center"><a href='javascript:void(0);'  class='remove btncirculo btn-md btn-danger'><i class="glyphicon glyphicon-trash"></i></a></div>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="detorprod_ins_id_adi[]" value="">
                                                </td>
                                                <!-- <td><input type="text" name="rango[]" class="form-control"></td> -->
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!--END INSUMO ADICIONAL-->
            </div>
                               <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Observaciones:
                                    </label>
                                    <textarea type="text" value="" class="form-control" name="obs_usr_aprob"></textarea>
                                </div>
                            </div>
                        </div>
                </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-right">
                            <a class="btn btn-danger btn-lg" href="{{ url('solRecibidas') }}" type="button">
                            Cerrar
                            </a>
                            <!-- {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-success'], $secure=null)!!} -->
                            <input type="submit"  value="Enviar a Producción" class="btn btn-success btn-lg">
                            </div>
                        </div>
                    </div>

            </form>

        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>

$(document).ready(function() {
    verficaStock();
});
function verficaStock()
{
	var arrayJS=<?php echo json_encode($datos_stock);?>;
	for (var i = arrayJS.length - 1; i >= 0; i--) {
		var cantidadStock = parseInt(arrayJS[i].cantidadStock);
        var cantidadSol = parseInt(arrayJS[i].cantidadSol);
        //console.log(cantidadSol);
        if (cantidadStock>=cantidadSol) {
            //console.log(arrayJS[i].cantidadStock);
        }else{
            console.log("No hay stock");
            swal("STOCK BAJO","En uno o mas de los insumos no existe la cantidad de stock disponible, por lo cual no podra aprobar esta solicitud","warning");
            $('input[type="submit"]').attr('disabled','disabled');
        }
	}
}
//AÑADIR INSUMO
$('#addMore').on('click', function() {
              var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
              data.find("input").val('');
     });
$(document).on('click', '.remove', function() {
    var trIndex = $(this).closest("tr").index();
    if(trIndex>1) {
        $(this).closest("tr").remove();
    } else {
        swal('Lo siento','No puede borrar el unico item');
    }
});

$("#tdformbase td select").click(function(){
    //console.log($(this).parents("tr").find("td").find("select").eq(0).val());
    var ins_id2 = $(this).parents("tr").find("td").find("select").eq(0).val();
    //console.log(ins_id2);
    traeUnidad(ins_id2);
    $(this).parents("tr").find("td").find("input").eq(0).val(traeUnidad(ins_id2));
    $(this).parents("tr").find("td").find("input").eq(2).val(getstockActual(ins_id2));
    $(this).parents("tr").find("td").find("input").eq(3).val(ins_id2);
});
function traeUnidad(id_insumo){
    var route = '/trae_uni?ins_id='+id_insumo;
    console.log(route);
    var dataToReturn = "Error";
    $.ajax({
        url: route,
        type: "GET",
        async: false,
        success: function(data) {
            dataToReturn = data.umed_nombre;
        }
    });
    return dataToReturn;
}
function getstockActual(id)
{
    var res = JSON.parse($.ajax({
    type: 'get',
    url: "/StockActualOP/"+id+"/"+26,
    dataType: 'json',
    async:false,
        success: function(data_stock)
        {
            console.log(data_stock);
            return data_stock;
        }
    }).responseText);
    return res.stock_cantidad;
}
</script>
@endpush
