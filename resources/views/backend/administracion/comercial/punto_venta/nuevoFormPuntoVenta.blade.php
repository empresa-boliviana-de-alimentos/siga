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
            <form action="#" class="form-horizontal" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="nro_acopio" id="nro_acopio" value="">                    
                <div class="col-md-12">
                    <div class="col-md-6">
                        <label>
                            Nombre:
                        </label>
                        <input type="text" name="" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>
                            Dirección:
                        </label>
                        <input type="" name="" class="form-control" value="">
                    </div>
                </div>                
                <div class="col-md-12">
                    <div class="col-md-12">
                        <label>
                            Descripción:
                        </label>
                        <input class="form-control" name="descripcion">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4">
                        <label>
                            Teléfono:
                        </label>
                        <input type="text" name="fecha" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>
                            Reponsable:
                        </label>
                        <select class="form-control">
                            <option value="1">RONALD VASQUEZ</option>
                            <option value="2">RENE VARGAS</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>
                            Departamento:
                        </label>
                        <select class="form-control">
                            <option value="1">LA PAZ</option>
                            <option value="2">COCHABAMBA</option>
                            <option value="3">SANTA CRUZ</option>
                            <option value="4">ORURO</option>
                            <option value="5">POTOSI</option>
                            <option value="6">CHUQUISACA</option>
                            <option value="7">TARIJA</option>
                            <option value="8">PANDO</option>
                            <option value="9">BENI</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <label>
                            Actividad Económica:
                        </label>
                        <input type="" name="" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4">
                        <label>
                            Tipo:
                        </label>
                        <select class="form-control" id="tipoPv">
                            <option value="1">PUNTO DE VENTA</option>
                            <option value="2">PUNTO DE VENTA TRANSITORIO</option>
                        </select>
                    </div>
                    <div class="ocultarPv" style="display:none;">
                        <div class="col-md-4">
                            <label>
                                Fecha Inicio:
                            </label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control">
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
                                <input type="text" class="form-control">
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
                        <textarea class="form-control" name="observacion"></textarea>
                    </div>
                </div>    
                <div class="col-md-12">
                    <div class="col-lg-12">
                        <div class="text-right">
                           <a class="btn btn-danger btn-lg" href="{{ url('SolPedidoPvComercial') }}" type="button">Cerrar</a>
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
</script>
@endpush
