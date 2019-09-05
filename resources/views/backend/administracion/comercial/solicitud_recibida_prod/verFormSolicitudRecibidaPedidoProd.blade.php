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
table {
  border-collapse: separate;
  border-spacing: 0 5px;
}

th {
  background-color:#2067b4;
  color: white;
}
tbody td {
  background-color: #EEEEEE;
}

</style>
@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="container col-lg-12" style="background: white;">
            <?php $now = new DateTime('America/La_Paz');?>
            <div class="text-center">
                <h3 style="color:#2067b4"><strong>VER ORDEN DE PEDIDO</strong></h3>
            </div>
            <form action="#" class="form-horizontal" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="nro_acopio" id="nro_acopio" value="">                    
                <div class="col-md-12">
                    <div class="col-md-4">
                        <label>
                            Solicitante:
                        </label>
                        <input type="" name="" class="form-control" value="RENE VALVERDE" readonly>
                    </div>
                    <div class="col-md-2">
                        <label>
                            Nro:
                        </label>
                        <input type="text" name="" class="form-control" value="1" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>
                            Fecha Solicitud:
                        </label>
                        <input type="text" name="" class="form-control" value="05/09/2019" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>
                            Fecha Posible Entrega:
                        </label>
                        <input type="text" name="" class="form-control" value="05/09/2019" readonly>
                    </div>
                </div>
                              
                <div class="col-md-12 text-center">
                    <h4><strong>DETALLE PEDIDO</strong></h4>
                </div>
                <div class="col-md-12">
                    <table class="table">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">COD PRODUCTO</th>
                            <th class="text-center">PRODUCTO</th>
                            <th class="text-center">UNIDAD MEDIDA</th>
                            <th class="text-center">CANTIDAD</th>
                            <th class="text-center">CANT. TONELADA</th>
                        </tr>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">PROLAC-1</td>
                            <td class="text-center">LECHE CHOCOLATADA</td>
                            <td class="text-center">LITROS</td>
                            <td class="text-center">1200.00</td>
                            <td class="text-center">12.00</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="text-center">PROLAC-2</td>
                            <td class="text-center">LECHE UHT</td>
                            <td class="text-center">LITROS</td>
                            <td class="text-center">1200.00</td>
                            <td class="text-center">12.00</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td class="text-center">PROLAC-3</td>
                            <td class="text-center">YOGURT PROBIOTICO</td>
                            <td class="text-center">LITROS</td>
                            <td class="text-center">1200.00</td>
                            <td class="text-center">12.00</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="5" style="background-color:#2067b4; color: white;"><strong>TOTAL TONELADAS APROX.</strong></td>
                            <td class="text-center">36.00</td>
                        </tr>
                    </table>
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
                            <a class="btn btn-danger btn-lg" href="{{ url('SolRecibidasProdComercial') }}" type="button">
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

</script>
@endpush
