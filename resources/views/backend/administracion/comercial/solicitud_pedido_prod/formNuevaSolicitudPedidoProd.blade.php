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
                <h3 style="color:#2067b4"><strong>SOLICITAR ORDEN DE PEDIDO</strong></h3>
            </div>
            <form action="#" class="form-horizontal" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="nro_acopio" id="nro_acopio" value="">                    
                <div class="col-md-12">
                    <div class="col-md-4">
                        <label>
                            Linea:
                        </label>
                        <select class="form-control">
                            <option value="1">Lacteos</option>
                            <option value="2">Miel</option>
                            <option value="3">Almendra</option>
                            <option value="4">Frutos</option>
                            <option value="5">Derivados</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>
                            Solicitante:
                        </label>
                        <input type="" name="" class="form-control" value="RENE VALVERDE" readonly>
                    </div>
                    <div class="col-md-4">
                        <label>
                            Fecha Posible Entrega:
                        </label>
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="col-md-12">
                    <h4><strong>DETALLE SOLICITUD</strong></h4>
                </div>
                <div class="col-md-12">
                    <producto-comercialpvlinea :lista="{{$listarProducto}}" nombre="productos" ></producto-comercialpvlinea>
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
                            <a class="btn btn-danger btn-lg" href="{{ url('SolPedidoProdComercial') }}" type="button">
                            Cerrar
                            </a>
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
</script>
@endpush
