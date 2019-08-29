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
            <?php $now = new DateTime('America/La_Paz'); ?>
            <div class="text-center">
                <h3 style="color:#2067b4"><strong>SOLICITUD DEVOLUCIÓN POR INSUMOS SOBRANTES</strong></h3> 
            </div>
            <form action="{{ url('RegistroDevolucionSobranteInsert') }}" class="form-horizontal" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="nro_de_orden" id="nro_de_orden" value="">
                <input type="hidden" name="id_receta" id="id_receta" value="">
                <div class="col-md-6">
                    <div class="row"> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        SELEC. ORDEN PRODUCCION:
                                    </label>                                   
                                    <select name="orprod_id" id="orprod_id" style="width: 100%" class="form-control">
                                    	<option value="">Seleccione un nro de orden</option>
                                    	@foreach($ordenes_produccion as $orden)
                                    		<option value="{{$orden->orprod_id}}">{{$orden->orprod_nro_salida}}</option>
                                    	@endforeach
                                    </select>     
                                </div>
                            </div>
                        </div>                                
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Producto:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                       {!! Form::text('nombre_producto', null, array('placeholder' => 'Nombre del Producto','class' => 'form-control','id'=>'nombre_producto','readonly'=>'true')) !!}    
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
                                    	{!! Form::text('cantidad_producir', null, array('placeholder' => 'Cantidad a Producir','class' => 'form-control','id'=>'cantidad_producir','readonly'=>'true')) !!}                                          
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
                    </div>
                </div>
                <div id="OcultarMateriaPrima" style="display: none">
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">MATERIA PRIMA</h3>
                            </div>
                            <div class="panel-body">
                            
                                    
                                        <table  class="table table-hover small-text" id="TableRecetasMatPrim">
	                                        <thead>
	                                            <tr>
	                                                <th>Cod Insumo</th>
	                                                <th>Insumo</th>
	                                                <th>Unidad Medida</th>
	                                                <th>Cant. Ent</th>
	                                                <th>Stock Actual</th> 
	                                                <th>Cant. Devol.</th>
	                                                                              
	                                            </tr>
	                                        </thead>
	                                        <tbody>
	                                            
	                                        </tbody>
	                                    </table>


                                    </div>
                        </div>
                    </div>
                </div>
                
                <div id="OcultarformulacionBase" style="display: none">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">FORMULACIÓN DE LA BASE</h3>
                            </div>
                            <div class="panel-body">
                                        <table  class="table table-hover small-text" id="TableRecetasBase">
	                                        <thead>
	                                            <tr>
	                                                <th>Cod Insumo</th>
	                                                <th>Insumo</th>
	                                                <th>Unidad Medida</th>
	                                                <th>Cant. Ent</th>
	                                                <th>Stock Actual</th> 
	                                                <th>Cant. Devol.</th>
	                                                                               
	                                            </tr>
	                                        </thead>
	                                        <tbody>
	                                            
	                                        </tbody>
	                                    </table>


                                    </div>
                        </div>
                    </div>
                </div>
                <div id="OcultarSaborizacion" style="display: none">
                    <div class="col-md-12">
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
	                                                <th>Cant. Ent</th>
	                                                <th>Stock Actual</th> 
	                                                <th>Cant. Devol.</th>
	                                                                           
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
                                <h3 class="panel-title">MATERIAL ENVASADO</h3>
                            </div>
                            <div class="panel-body">
                                        <table  class="table table-hover small-text" id="TableRecetasEnv">
	                                        <thead>
	                                            <tr>
	                                                <th>Cod Insumo</th>
	                                                <th>Insumo</th>
	                                                <th>Unidad Medida</th>
	                                                <th>Cant. Ent</th>
	                                                <th>Stock Actual</th> 
	                                                <th>Cant. Devol.</th>
	                                                                                           
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
                            <a class="btn btn-danger btn-lg" href="{{ url('DevolucionDefectuoso') }}" type="button">
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
$(document).ready(function() {
    $('#orprod_id').select2();
});

var itemAux=[];
$('#orprod_id').on('change', function(e){
    var orprod_id = e.target.value;
    //$("#id_recetaAux").val(receta_id);
    $.get('getDataOrdenProduccion?orprod_id='+orprod_id, function(data){
      console.log(data);
      $("#OcultarInsAdicional").show();
      $("#rendimiento_base").val(data.rece_rendimiento_base);
      $("#cantidad_producir").val(data.orprod_cantidad);
      $("#nombre_producto").val(data.rece_nombre+' '+data.sab_nombre+' '+data.rece_presentacion+' '+data.umed_nombre);
      $("#nro_de_orden").val(data.orprod_id);
      $("#id_receta").val(data.rece_id);
      var linea_tipo = data.rece_lineaprod_id;
      if (linea_tipo == 1 || linea_tipo == 4 || linea_tipo == 5) {
      	$("#OcultarMateriaPrima").hide();
      	$("#OcultarformulacionBase").show();
      	$( "#TableRecetasBase tbody tr" ).each( function(){ this.parentNode.removeChild( this ); }); 
      	$( "#TableRecetasSab tbody tr" ).each( function(){ this.parentNode.removeChild( this ); }); 
      	$( "#TableRecetasEnv tbody tr" ).each( function(){ this.parentNode.removeChild( this ); }); 
      	$.get('getDataDetOrprodInsPrima?orprod_id='+data.orprod_id, function(data_det){
      		console.log(data_det);
	      	for (i = 0; i < data_det.length; i++){
	      		//console.log(data_det[i].ins_codigo);
	      		function getstockActual(id)
				{
				    var res = JSON.parse($.ajax({
				    type: 'get',
				    url: "StockActualOP/"+id,
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
				$("#TableRecetasBase").append('<tr class="items_columsReceta3">' + 
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detorprod_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(data_det[i].ins_id)+'"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="cantidad_devo[]" class="form-control" value=""></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="hidden" name="id_ins[]" class="form-control" value="'+data_det[i].ins_id+'"></input></td></tr>');	            
	        }
    	});    	
      	$("#OcultarSaborizacion").show();
      	$.get('getDataDetOrprod?orprod_id='+data.orprod_id+'&tipo=4', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		//console.log(data_det[i].ins_codigo);
	      		function getstockActual(id)
				{
				    var res = JSON.parse($.ajax({
				    type: 'get',
				    url: "StockActualOP/"+id,
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
				$("#TableRecetasSab").append('<tr class="items_columsRecetaSab">' + 
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detorprod_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(data_det[i].ins_id)+'"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="cantidad_devo[]" class="form-control" value=""></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="hidden" name="id_ins[]" class="form-control" value="'+data_det[i].ins_id+'"></input></td></tr>');	            
	        }
    	});
      	$("#OcultarMatEnv").show();
      	$.get('getDataDetOrprod?orprod_id='+data.rece_id+'&tipo=2', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		//console.log(data_det[i].ins_codigo);
	      		function getstockActual(id)
				{
				    var res = JSON.parse($.ajax({
				    type: 'get',
				    url: "StockActualOP/"+id,
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
				$("#TableRecetasEnv").append('<tr class="items_columsRecetaEnv">' + 
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detorprod_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(data_det[i].ins_id)+'"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="cantidad_devo[]" class="form-control" value=""></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="hidden" name="id_ins[]" class="form-control" value="'+data_det[i].ins_id+'"></input></td></tr>');	            
	        }
    	});
      }else if(linea_tipo == 2 || linea_tipo == 3){
      	$( "#TableRecetasBase tbody tr" ).each( function(){ this.parentNode.removeChild( this ); }); 
      	$( "#TableRecetasSab tbody tr" ).each( function(){ this.parentNode.removeChild( this ); }); 
      	$( "#TableRecetasEnv tbody tr" ).each( function(){ this.parentNode.removeChild( this ); }); 
      	$( "#TableRecetasMatPrim tbody tr" ).each( function(){ this.parentNode.removeChild( this ); }); 
      	$("#OcultarMateriaPrima").show();
      	$.get('getDataDetOrprod?orprod_id='+data.rece_id+'&tipo=3', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		//console.log(data_det[i].ins_codigo);
	      		function getstockActual(id)
				{
				    var res = JSON.parse($.ajax({
				    type: 'get',
				    url: "StockActualOP/"+id,
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
				$("#TableRecetasMatPrim").append('<tr class="items_columsReceta3">' + 
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detorprod_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(data_det[i].ins_id)+'"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="cantidad_devo[]" class="form-control" value=""></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="hidden" name="id_ins[]" class="form-control" value="'+data_det[i].ins_id+'"></input></td></tr>');	            
	        }
    	});
      	$("#OcultarformulacionBase").hide();
      	$("#OcultarSaborizacion").hide();
      	$("#OcultarMatEnv").show();
      	$.get('getDataDetOrprod?orprod_id='+data.rece_id+'&tipo=2', function(data_det){
	      	for (i = 0; i < data_det.length; i++){
	      		//console.log(data_det[i].ins_codigo);
	      		function getstockActual(id)
				{
				    var res = JSON.parse($.ajax({
				    type: 'get',
				    url: "StockActualOP/"+id,
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
				$("#TableRecetasEnv").append('<tr class="items_columsRecetaEnv">' + 
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_codigo + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].ins_desc + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].umed_nombre + '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ data_det[i].detorprod_cantidad+ '"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(data[i].ins_id)+'"></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="text" name="cantidad_devo[]" class="form-control" value=""></input></td>'+
	                '<td align="center" style="dislay: none;"><input type="hidden" name="id_ins[]" class="form-control" value="'+data_det[i].ins_id+'"></input></td></tr>');	            
	        }
    	});
      	
      }
      

    });
});

//AÑADIR INSUMO NUEVO
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
//TRAE VALOR DE UNIDAD MEDIDA PARA FORMULACION DE LA BASE
$("#tdformbase td select").click(function(){
    console.log($(this).parents("tr").find("td").find("select").eq(0).val());
    var ins_id2 = $(this).parents("tr").find("td").find("select").eq(0).val();
    console.log(ins_id2);
    traeUnidad(ins_id2);
    $(this).parents("tr").find("td").find("input").eq(0).val(traeUnidad(ins_id2));
    $(this).parents("tr").find("td").find("input").eq(2).val(getstockActual(ins_id2));
    $(this).parents("tr").find("td").find("input").eq(3).val(ins_id2); 
});
function traeUnidad(id_insumo){
    var route = 'trae_uni?ins_id='+id_insumo;
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
    url: "StockActualOP/"+id,
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