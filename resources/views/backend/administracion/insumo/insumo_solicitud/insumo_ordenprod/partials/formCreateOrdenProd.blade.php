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
<div class="row">
    <div class="col-md-12">
        <div class="container col-lg-12" style="background: white;">
            <?php $now = new DateTime('America/La_Paz');?>
            <div class="text-center">
                <h3 style="color:#2067b4"><strong>REALIZAR NUEVO PEDIDO</strong></h3>
            </div>
            <form action="{{ url('OrdenProduccionCreate') }}" class="form-horizontal" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="nro_acopio" id="nro_acopio" value="">
                    <div class="col-md-4">
                    <pedido-orp :plantas="{{$plantas}}" :mercados="{{$mercados}}"></pedido-orp>
                    <!--<div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Producto:
                                    </label>
                                    <select name="receta_id" id="receta_id" style="width: 100%" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Planta a Producir:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        <select class="form-control" name="planta_produccion_id" id="planta_produccion_id">
                                        	@foreach($plantas as $plan)
                                            	<option value="{{$plan->id_planta}}">{{$plan->nombre_planta}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Mercado:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        <select class="form-control" id="mercado_id" name="mercado_id">
                                            @foreach($mercados as $mer)
                                                <option value="{{$mer->mer_id}}">{{$mer->mer_nombre}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Rendimiento Base:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('rendimiento_base', null, array('placeholder' => 'Rendimiento Base','class' => 'form-control','id'=>'rendimiento_base','readonly'=>'true')) !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Cantidad a Producir:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                    	{!! Form::text('cantidad_producir', null, array('placeholder' => 'Cantidad a Producir','class' => 'form-control','id'=>'cantidad_producir')) !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Cantidad a Esperada:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('cantidad_esperada', null, array('placeholder' => 'Cantidad a Producir','class' => 'form-control','id'=>'cantidad_esperada')) !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Tiempo a Producir:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::number('tiempo_producir', null, array('placeholder' => 'Cantidad a Producir','class' => 'form-control','id'=>'tiempo_producir')) !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label style="color:white">
                                    .
                        	        </label>
                        	        <span class="block input-icon input-icon-right">
                                    	<a class="form-control btn btn-primary" id="botonCalculos">Calcular</a>
                                    	<input type="hidden" name="" id="id_recetaAux">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>-->
                <div id="OcultarMateriaPrima" style="display: none">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">MATERIA PRIMA</h3>
                            </div>
                            <div class="panel-body">
                                <insumo-orp></insumo-orp>
                                <!--<table  class="table table-hover table-condensed small-text" id="TableRecetasMatPrim">
                                    <thead>
                                        <tr>
                                            <th>Cod Insumo</th>
                                            <th>Insumo</th>
                                            <th>Unidad Medida</th>
                                            <th>Cant. Base</th>
                                            <th>Cantidad</th>

                                            <th>Stock Actual</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>-->
                            </div>
                        </div>
                    </div>
                </div>

                <div id="OcultarformulacionBase" style="display: none">
                    <div class="col-md-8">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">FORMULACION DE LA BASE</h3>
                            </div>
                            <div class="panel-body">
                                <insumo-orp></insumo-orp>
                                <!--<table  class="table table-hover table-condensed small-text" id="TableRecetasBase">
                                    <thead>
                                        <tr>
                                            <th>Cod Insumo</th>
                                            <th>Insumo</th>
                                            <th>Unidad Medida</th>
                                            <th>Cant. Base</th>
                                            <th>Cantidad</th>

                                            <th>Stock Actual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div id="OcultarSaborizacion" style="display: none">
                    <div class="col-md-8">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">SABORIZACIÓN</h3>
                            </div>
                            <div class="panel-body">
                                <table  class="table table-hover small-text" id="TableRecetasSab">
                                    <thead>
                                        <tr>
                                            <th>Cod Insumo</th>
                                            <th>Insumo</th>
                                            <th>Unidad Medida</th>
                                            <th>Cant. Base</th>
                                            <th>Cantidad</th>

                                            <th>Stock Actual</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="OcultarMatEnv" style="display: none">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">MATERIAL DE ENVASADO</h3>
                            </div>
                            <div class="panel-body">
                                <table  class="table table-hover small-text" id="TableRecetasEnv">
                                    <thead>
                                        <tr>
                                            <th>Cod Insumo</th>
                                            <th>Insumo</th>
                                            <th>Unidad Medida</th>
                                            <th>Cant. Base</th>
                                            <th>Cantidad</th>

                                            <th>Stock Actual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>
                            Observaciones:
                        </label>
                        <textarea class="form-control" name="observacion"></textarea>
                    </div>
                </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-right">
                            <a class="btn btn-danger btn-lg" href="{{ url('OrdenProduccion') }}" type="button">
                            Cerrar
                            </a>
                            <!-- {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-success'], $secure=null)!!} -->
                            <input type="submit"  value="Registrar" class="btn btn-success btn-lg">
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
// BUSQUEDAS ASINCRONAS
$('#receta_id').select2({
    placeholder: "Seleccione Producto",
    proveedor: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("getProducto") }}',
        delay: 250,
        data: function(params) {
            return {
                term: params.term
            }
        },
        processResults: function (data, page) {
        	console.log(data);
            return {
            results: data
            };
        },
    },
    language: "es",
});
var rece_id;
var itemAux=[];
$('#receta_id').on('change', function(e){
    var receta_id = e.target.value;
    rece_id = e.target.value;
    $("#id_recetaAux").val(receta_id);
    $.get('getDataReceta?rece_id='+receta_id, function(data){
      //console.log(data);
      $("#rendimiento_base").val(data.rece_rendimiento_base);
      var linea_tipo = data.rece_lineaprod_id;
      if (linea_tipo == 1 || linea_tipo == 4 || linea_tipo == 5) {
      	$("#OcultarMateriaPrima").hide();
      	$("#OcultarformulacionBase").show();
      	$( "#TableRecetasBase tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$( "#TableRecetasSab tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$( "#TableRecetasEnv tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$.get('getDataDetRecetaInsPrima?rece_id='+data.rece_id, function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		console.log(data_det[i].ins_codigo);
				$("#TableRecetasBase").append('<tr class="items_columsReceta3">' +
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detrece_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value=""></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value=""></input></td></tr>');
	        }
    	});
      	$("#OcultarSaborizacion").show();
      	$.get('getDataDetReceta?rece_id='+data.rece_id+'&tipo=4', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		console.log(data_det[i].ins_codigo);
				$("#TableRecetasSab").append('<tr class="items_columsRecetaSab">' +
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detrece_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value=""></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value=""></input></td></tr>');
	        }
    	});
      	$("#OcultarMatEnv").show();
      	$.get('getDataDetReceta?rece_id='+data.rece_id+'&tipo=2', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		console.log(data_det[i].ins_codigo);
				$("#TableRecetasEnv").append('<tr class="items_columsRecetaEnv">' +
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detrece_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value=""></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value=""></input></td></tr>');
	        }
    	});
      }else if(linea_tipo == 2 || linea_tipo == 3){
      	$( "#TableRecetasBase tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$( "#TableRecetasSab tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$( "#TableRecetasEnv tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$( "#TableRecetasMatPrim tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$("#OcultarMateriaPrima").show();
      	$.get('getDataDetReceta?rece_id='+data.rece_id+'&tipo=3', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		console.log(data_det[i].ins_codigo);
				$("#TableRecetasMatPrim").append('<tr class="items_columsReceta3">' +
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detrece_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value=""></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value=""></input></td></tr>');
	        }
    	});
      	$("#OcultarformulacionBase").hide();
      	$("#OcultarSaborizacion").hide();
      	$("#OcultarMatEnv").show();
      	$.get('getDataDetReceta?rece_id='+data.rece_id+'&tipo=2', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		console.log(data_det[i].ins_codigo);
				$("#TableRecetasEnv").append('<tr class="items_columsRecetaEnv">' +
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detrece_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value=""></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value=""></input></td></tr>');
	        }
    	});

      }


    });
});


$( "#botonCalculos" ).click(function() {
    if ($('#cantidad_producir').val()>0) {
        var cantidadPed = $('#cantidad_producir').val()/$('#rendimiento_base').val();
        var id_receta = $("#id_recetaAux").val();
        console.log(id_receta);
    $.get('getDataReceta?rece_id='+id_receta, function(data){
      //console.log(data);
      $("#rendimiento_base").val(data.rece_rendimiento_base);
      var linea_tipo = data.rece_lineaprod_id;
      if (linea_tipo == 1 || linea_tipo == 4 || linea_tipo == 5) {
      	$("#OcultarMateriaPrima").hide();
      	$("#OcultarformulacionBase").show();
      	$( "#TableRecetasBase tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$( "#TableRecetasSab tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$( "#TableRecetasEnv tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$.get('getDataDetRecetaInsPrima?rece_id='+data.rece_id, function(data_det){

	      	for (i = 0; i < data_det.length; i++){
	      		function getstockActual(id,id_planta)
                {
                    var res = JSON.parse($.ajax({
                        type: 'get',
                        url: "StockActualOP/"+id+"/"+id_planta,
                        dataType: 'json',
                        async:false,
                        success: function(data_stock)
                        {
                        	/*console.log(data_stock);
                            if (data_stock.stock_cantidad >! 0) {}
                            swal("STOCK BAJO","En uno o mas de los insumos no existe la cantidad de stock disponible, por lo cual no podra aprobar esta solicitud","warning");
                            $('input[type="submit"]').attr('disabled','disabled');*/
                            return data;
                        }
                    }).responseText);

                    return res.stock_cantidad;
                }
	      		console.log(data_det[i]);
				$("#TableRecetasBase").append('<tr class="items_columsReceta3">' +
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detrece_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ (data_det[i].detrece_cantidad*$('#cantidad_producir').val()/$('#rendimiento_base').val()).toFixed(2)+ '"></input></td>'+
	                '<td align="center" style="dislay: none; background: red;"><input type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(data_det[i].ins_id,$("#planta_produccion_id").val())+'" style="background: #ffb4da;"></input></td></tr>');
                verficaStock(getstockActual(data_det[i].ins_id,$("#planta_produccion_id").val()),data_det[i].detrece_cantidad*$('#cantidad_producir').val()/$('#rendimiento_base').val());
	        }
    	});
      	$("#OcultarSaborizacion").show();
      	$.get('getDataDetReceta?rece_id='+data.rece_id+'&tipo=4', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		function getstockActual(id,id_planta)
                {
                    var res = JSON.parse($.ajax({
                        type: 'get',
                        url: "StockActualOP/"+id+"/"+id_planta,
                        dataType: 'json',
                        async:false,
                        success: function(data_stock)
                        {
                        	//console.log(data_stock);
                            return data;
                        }
                    }).responseText);

                    return res.stock_cantidad;
                }
	      		//console.log(data_det[i].ins_codigo);
				$("#TableRecetasSab").append('<tr class="items_columsRecetaSab">' +
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detrece_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ (data_det[i].detrece_cantidad*$('#cantidad_producir').val()/$('#rendimiento_base').val()).toFixed(2)+ '"></input></td>'+
	                '<td align="center" style="dislay: none; background: red;"><input type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(data_det[i].ins_id,$("#planta_produccion_id").val())+'" style="background: #ffb4da;"></input></td></tr>');
                verficaStock(getstockActual(data_det[i].ins_id,$("#planta_produccion_id").val()),data_det[i].detrece_cantidad*$('#cantidad_producir').val()/$('#rendimiento_base').val());
	        }
    	});
      	$("#OcultarMatEnv").show();
      	$.get('getDataDetReceta?rece_id='+data.rece_id+'&tipo=2', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		function getstockActual(id,id_planta)
                {
                    var res = JSON.parse($.ajax({
                        type: 'get',
                        url: "StockActualOP/"+id+"/"+id_planta,
                        dataType: 'json',
                        async:false,
                        success: function(data_stock)
                        {
                        	//console.log(data_stock);
                            return data;
                        }
                    }).responseText);

                    return res.stock_cantidad;
                }
	      		//console.log(data_det[i].ins_codigo);
				$("#TableRecetasEnv").append('<tr class="items_columsRecetaEnv">' +
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detrece_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ (data_det[i].detrece_cantidad*$('#cantidad_producir').val()/$('#rendimiento_base').val()).toFixed(2)+ '"></input></td>'+
	                '<td align="center" style="dislay: none; background: red;"><input type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(data_det[i].ins_id,$("#planta_produccion_id").val())+'" style="background: #ffb4da;"></input></td></tr>');
                verficaStock(getstockActual(data_det[i].ins_id,$("#planta_produccion_id").val()),data_det[i].detrece_cantidad*$('#cantidad_producir').val()/$('#rendimiento_base').val());
	        }
    	});
      }else if(linea_tipo == 2 || linea_tipo == 3){
      	$( "#TableRecetasBase tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$( "#TableRecetasSab tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$( "#TableRecetasEnv tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$( "#TableRecetasMatPrim tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
      	$("#OcultarMateriaPrima").show();
      	$.get('getDataDetReceta?rece_id='+data.rece_id+'&tipo=3', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		function getstockActual(id,id_planta)
                {
                    var res = JSON.parse($.ajax({
                        type: 'get',
                        url: "StockActualOP/"+id+"/"+id_planta,
                        dataType: 'json',
                        async:false,
                        success: function(data_stock)
                        {
                        	//console.log(data_stock);
                            return data;
                        }
                    }).responseText);

                    return res.stock_cantidad;
                }
	      		//console.log(data_det[i].ins_codigo);
				$("#TableRecetasMatPrim").append('<tr class="items_columsReceta3">' +
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detrece_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ (data_det[i].detrece_cantidad*$('#cantidad_producir').val()/$('#rendimiento_base').val()).toFixed(2)+ '"></input></td>'+
	                '<td align="center" style="dislay: none; background: red;"><input type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(data_det[i].ins_id,$("#planta_produccion_id").val())+'" style="background: #ffb4da;"></input></td></tr>');
                verficaStock(getstockActual(data_det[i].ins_id,$("#planta_produccion_id").val()),data_det[i].detrece_cantidad*$('#cantidad_producir').val()/$('#rendimiento_base').val());
	        }
    	});
      	$("#OcultarformulacionBase").hide();
      	$("#OcultarSaborizacion").hide();
      	$("#OcultarMatEnv").show();
      	$.get('getDataDetReceta?rece_id='+data.rece_id+'&tipo=2', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		function getstockActual(id,id_planta)
                {
                    var res = JSON.parse($.ajax({
                        type: 'get',
                        url: "StockActualOP/"+id+"/"+id_planta,
                        dataType: 'json',
                        async:false,
                        success: function(data_stock)
                        {
                        	//console.log(data_stock);
                            return data;
                        }
                    }).responseText);

                    return res.stock_cantidad;
                }
	      		console.log(data_det[i].ins_codigo);
				$("#TableRecetasEnv").append('<tr class="items_columsRecetaEnv">' +
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detrece_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ (data_det[i].detrece_cantidad*$('#cantidad_producir').val()/$('#rendimiento_base').val()).toFixed(2)+ '"></input></td>'+
	                '<td align="center" style="dislay: none; background:red;"><input type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(data_det[i].ins_id,$("#planta_produccion_id").val())+'" style="background: #ffb4da;"></input></td></tr>');
                verficaStock(getstockActual(data_det[i].ins_id,$("#planta_produccion_id").val()),data_det[i].detrece_cantidad*$('#cantidad_producir').val()/$('#rendimiento_base').val());
	        }
    	});

      }


    });

    }else{
        swal('Lo siento', 'La cantidad minima debe ser mayor a 0');
    }

});


function verficaStock(cantidadStock, cantidadSol)
{
    console.log("cant. Sol: "+cantidadSol+", cant.stock: "+cantidadStock);
    if (cantidadStock>=cantidadSol) {
        //$('input[type="submit"]').removeAttr('disabled');
    }else{
        console.log("No hay stock");
        swal("STOCK BAJO","En uno o mas de los insumos no existe la cantidad de stock disponible, por lo cual no podra aprobar esta solicitud","warning");
        $('input[type="submit"]').attr('disabled','disabled');
    }    
    
}
</script>
@endpush