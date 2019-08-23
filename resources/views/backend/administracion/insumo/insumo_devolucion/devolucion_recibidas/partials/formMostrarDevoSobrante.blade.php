@extends('backend.template.app')
@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="container col-lg-12" style="background: white;">        
            <?php $now = new DateTime('America/La_Paz'); ?>
            <div class="text-center">
                <h3 style="color:#2067b4"><strong>ENTREGA DEVOLUCION SOBRANTE</strong></h3> 
            </div>
            <div class="text-center">
            	<h3>Código: ORP-{{$sol_devo_sobrante->devo_nro_orden}}</h3>
            </div>
            <form action="{{ url('AprobacionDevolcuionSobrante') }}" class="form-horizontal" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="id_devo" id="id_devo" value="{{ $sol_devo_sobrante->devo_id}}">
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
                
                    <div class="text">
                        <h4 style="color:#2067b4"><strong>INSUMOS PARA LA DEVOLUCION</strong></h4> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12">
                                <div class="form-group">
                                        <table  class="table table-hover small-text" id="TableRecetasEnv">
                                            <thead>
                                                <tr>
                                                    <th>Cod Insumo</th>
                                                    <th>Insumo</th>
                                                    <th>Unidad Medida</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo</th>                                                       
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($detalle_devo_sobrante as $dorp)                                       
                                                <tr>
                                                    <td>{{$dorp->ins_codigo}}</td>
                                                    <td>{{$dorp->ins_desc}}</td>
                                                    <td>{{$dorp->umed_nombre}}</td>
                                                    <td>{{$dorp->detdevo_cantidad}}</td>
                                                    <td><input type="text" name="costo_devo[]" class="form-control"></td>
                                                    <td><input type="hidden" name="id_insumo_devo[]" class="form-control" value="{{$dorp->ins_id}}"></td>
                                                    <td><input type="hidden" name="cantidad_devo[]" class="form-control" value="{{$dorp->detdevo_cantidad}}"></td>                                   
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