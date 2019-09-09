@extends('backend.template.app')
{{-- <style type="text/css" media="screen">
  .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td{
    padding: 1px;
}
table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px 10px;
    color: dimgrey;
    font-size: 8px;
}


</style> --}}
@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="container col-lg-12" style="background: white;">
            <?php $now = new DateTime('America/La_Paz');?>
            <div class="text-center">
                <h3 style="color:#2067b4"><strong>CREACIÓN DE PUNTO DE VENTA</strong></h3>
            </div>
            <form action="{{url('RegistrarNuevoPuntoVenta')}}" class="form-horizontal" method="post">
                {{ csrf_field() }}               
                <input id="fecha_resgistro" name="fecha_registro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="nro_acopio" id="nro_acopio" value="">                    
                <div class="col-md-12">
                    <div class="col-md-6">
                        <label>
                            Nombre:
                        </label>
                        <input type="text" name="nombre_pv" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>
                            Dirección:
                        </label>
                        <input type="" name="direccion_pv" class="form-control" value="" required>
                    </div>
                </div>                
                <div class="col-md-12">
                    <div class="col-md-12">
                        <label>
                            Descripción:
                        </label>
                        <input class="form-control" name="descripcion_pv" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4">
                        <label>
                            Teléfono:
                        </label>
                        <input type="text" name="telefono_pv" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>
                            Reponsable:
                        </label>
                        <select class="form-control" name="responsable_pv" id="responsable">
                            @foreach($usuarios as $usuario)
                                <option value="{{$usuario->usr_id}}">{{$usuario->prs_nombres}} {{$usuario->prs_paterno}} {{$usuario->prs_materno}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>
                            Departamento:
                        </label>
                        <select class="form-control" name="departamento_pv">
                            @foreach($departamentos as $depto)
                                <option value="{{$depto->depto_id}}">{{$depto->depto_nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <label>
                            Actividad Económica:
                        </label>
                        <input type="" name="actividad_economica_pv" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4">
                        <label>
                            Tipo:
                        </label>
                        <select class="form-control" id="tipoPv" name="tipo_pv">
                            @foreach($tipo_pv as $tipv)
                                <option value="{{$tipv->tipopv_id}}">{{$tipv->tipopv_nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ocultarPv" style="display:none;">
                        <div class="col-md-4">
                            <label>
                                Fecha Inicio:
                            </label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control" name="fecha_inicio_pv">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>
                                Fecha Fin:
                            </label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control" name="fecha_fin_pv">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="col-md-12">
                    <div class="col-md-12">
                        <label>
                            Observaciones:
                        </label>
                        <textarea class="form-control" name="observacion_pv"></textarea>
                    </div>
                </div>    
                <div class="col-md-12">
                    <div class="col-lg-12">
                        <div class="text-right">
                           <a class="btn btn-danger btn-lg" href="{{ url('PuntoVentaComercial') }}" type="button">Cerrar</a>
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
$('.datepicker').datepicker();

$('#tipoPv').change(function(){
    if($(this).val()==1){
        $('.ocultarPv').hide();
    } else if($(this).val()==2){
        $('.ocultarPv').show();
    } 
});

$('#responsable').select2();
</script>
@endpush
