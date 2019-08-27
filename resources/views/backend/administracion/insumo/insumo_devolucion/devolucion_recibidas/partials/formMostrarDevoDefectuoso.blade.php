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
                <h3 style="color:#2067b4"><strong>ENTREGA DEVOLUCION DEFECTUOSO</strong></h3> 
            </div>
            <div class="text-center">
            	<h3>Código: ORP-{{$sol_devo_sobrante->devo_nro_orden}}</h3>
            </div>
            <form action="{{ url('AprobacionDevolcuionDefectuoso') }}" class="form-horizontal" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="id_devo" id="id_devo" value="{{ $sol_devo_sobrante->devo_id}}">
                <div class="col-md-12">
                    <div class="row">                
                       
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Observacion Pedido:
                                    </label>
                                    <textarea type="text" value="" class="form-control" name="" readonly="true">{{$sol_devo_sobrante->devo_obs}}</textarea>
                                </div>
                            </div>
                        </div>                   
                                                                                    
                    </div>
                </div>
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">INSUMOS PARA LA DEVOLUCIÓN</h3>
                            </div>
                            <div class="panel-body">
                                
                                        <table  class="table table-hover small-text" id="TableRecetasEnv">
                                            <thead>
                                                <tr>
                                                    <th>Cod Insumo</th>
                                                    <th>Insumo</th>
                                                    <th>Unidad Medida</th>
                                                    <th>Cantidad</th>                                                       
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($detalle_devo_sobrante as $dorp)                                       
                                                <tr>
                                                    <td>{{$dorp->ins_codigo}}</td>
                                                    <td>{{$dorp->ins_desc}}</td>
                                                    <td>{{$dorp->umed_nombre}}</td>
                                                    <td>{{$dorp->detdevo_cantidad}}</td>                                   
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
                            <a class="btn btn-danger btn-lg" href="{{ url('DevolucionRecibida') }}" type="button">
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
    //verficaStock();
});
</script>
@endpush