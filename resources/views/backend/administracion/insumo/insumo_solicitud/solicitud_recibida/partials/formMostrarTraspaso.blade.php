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
                <h3 style="color:#2067b4"><strong>ENTREGA PEDIDO TRASPASO</strong></h3> 
            </div>
            <div class="text-center">
            	<h3>Código: ORP-{{$sol_orden_produccion->orprod_nro_orden}}</h3>
            </div>
            <form action="{{ url('AprobacionTraspaso') }}" class="form-horizontal" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="id_orp" id="nro_acopio" value="{{ $sol_orden_produccion->orprod_id}}">
                <div class="col-md-12">
                    <div class="row">                
                       <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Planta Solicitante:
                                    </label>
                                    <input type="text" value="{{$sol_orden_produccion->nombre_planta}}" class="form-control" name="" readonly="true">
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
                                                                                    
                    </div>
                </div>
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">INSUMOS SOLICITADOS</h3>
                            </div>
                            <div class="panel-body">
                                        <table  class="table table-hover small-text" id="TableRecetasEnv">
                                            <thead>
                                                <tr>
                                                    <th>Cod Insumo</th>
                                                    <th>Insumo</th>
                                                    <th>Unidad Medida</th>
                                                    <th>Cantidad</th>
                                                    <!--<th>Costo</th>th>-->
                                                    <th>Stock Actual</th>                               
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($detalle_sol_orp as $dorp)                                       
                                                <tr>
                                                    <td>{{$dorp->ins_codigo}}</td>
                                                    <td>{{$dorp->ins_desc}}</td>
                                                    <td>{{$dorp->umed_nombre}}</td>
                                                    <td>{{$dorp->detorprod_cantidad}}</td>
                                                    <!--<td><input type="text" name="costo_tras[]" value="" class="form-control"></td>-->                         
                                                    @if($dorp->detorprod_cantidad > stock_actualOP($dorp->ins_id))

                                                    	<td style="background: #E99786">{{stock_actualOP($dorp->ins_id)}}</td>
                                                    @else
                                                    	<td style="background: #84E53C">{{stock_actualOP($dorp->ins_id)}}</td>
                                                    	<input type="hidden" value="verficaStock($dorp->detorprod_cantidad,stock_actualOP($dorp->ins_id));" name=""> 
                                                    @endif
                                                    <td><input type="hidden" name="id_insumo_tras[]" value="{{$dorp->ins_id}}"></td>
                                                    <td><input type="hidden" name="cantidad_tras[]" value="{{$dorp->detorprod_cantidad}}"></td>
                                                    @php
                                                    	$datos_stock[] = array('cantidadSol'=>$dorp->detorprod_cantidad,'cantidadStock'=>stock_actualOP($dorp->ins_id));
                                                    @endphp
                                                </tr>                                               
                                                @endforeach 
                                            </tbody>
                                        </table>
  

                                    </div>
                        </div>
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
    console.log(arrayJS);
	for (var i = arrayJS.length - 1; i >= 0; i--) {
        var cantidadStock = parseInt(arrayJS[i].cantidadStock);
        var cantidadSol = parseInt(arrayJS[i].cantidadSol);
        console.log(cantidadSol);
		if (cantidadStock>=cantidadSol) {
			//console.log(arrayJS[i].cantidadStock);
		}else{
			console.log("No hay stock");
			swal("STOCK BAJO","En uno o mas de los insumos no existe la cantidad de stock disponible, por lo cual no podra aprobar esta solicitud","warning");
			$('input[type="submit"]').attr('disabled','disabled');
		}
	}
	
}
</script>
@endpush