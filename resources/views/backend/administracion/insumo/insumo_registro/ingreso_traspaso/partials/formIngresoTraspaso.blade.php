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
thead th{
    font-size: 12px;
    color: white;
    background-color: #202040;
}
tbody td{
    font-size: 10px;
    background-color: #EEEEEE;
}
</style>
@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="container col-lg-12" style="background: white;">        
            <?php $now = new DateTime('America/La_Paz'); ?>
            <div class="text-center">
                <h3 style="color:#202040"><strong>INGRESO PEDIDO TRASPASO</strong></h3> 
            </div>
            <div class="text-center">
            	<h3></h3>
            </div>
            <form action="{{ url('GuardarIngresotraspaso') }}" class="form-horizontal" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="id_ingreso" id="id_ingreso" value="{{$ingreso->ing_id}}">
                <div class="col-md-12">
                    <div class="row">                
                       
                     
                                                                                    
                    </div>
                </div>
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading" style="background-color: #202040">
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
                                                    <th>Costo</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>                         
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($detalle_ingreso as $dorp)                                       
                                                <tr>
                                                    <td>{{$dorp->ins_codigo}}</td>
                                                    <td>{{$dorp->ins_desc}}</td>
                                                    <td>{{$dorp->umed_nombre}}</td>
                                                    <td>{{$dorp->deting_cantidad}}</td>
                                                    <td><input type="text" name="costo_tras[]" value="" class="form-control"></td>                         
                                                    <td><input type="hidden" name="id_insumo_tras[]" value="{{$dorp->ins_id}}"></td>
                                                    <td><input type="hidden" name="cantidad_tras[]" value="{{$dorp->deting_cantidad}}"></td>
                                                    <td><input type="hidden" name="deting_id[]" value="{{$dorp->deting_id}}"></td>
                                                    
                                                </tr>                                               
                                                @endforeach 
                                            </tbody>
                                        </table>
  

                                    </div>
                        </div>
                    </div>
                                             
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-right">
                            <a class="btn btn-danger btn-lg" href="{{ url('IngresoTraspaso') }}" type="button">
                            Cerrar
                            </a>
                            <!-- {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-success'], $secure=null)!!} -->
                            <input type="submit"  value="Ingresar" class="btn btn-success btn-lg">
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

</script>
@endpush