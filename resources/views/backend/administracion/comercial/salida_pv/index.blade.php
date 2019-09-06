@extends('backend.template.app')
<style type="text/css" media="screen">
        table {
    border-collapse: separate;
    border-spacing: 0 5px;
    }
    thead th {
      background-color:#428bca;
      color: white;
    }
    tbody td {
      background-color: #EEEEEE;
    }
</style>
@section('main-content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">SALIDAS POR VENTA</p>
            </div>
            <div class="col-md-3 text-right">
                <a href="{{url('NuevoPuntoVenta')}}" class="btn btn-default btn-xs" style="background: #616A6B;">
                        <h6 style="color: white;"><i class="fa fa-plus">
                    </i>&nbsp;CREAR NUEVO PUNTO DE VENTA</h6>
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                    <div class="box-body">
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-solPediPv">
                            <thead class="cf">
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th class="text-center">
                                        BOLETA
                                    </th>
                                    <th class="text-center">
                                        NRO FACTURA
                                    </th>
                                    <th class="text-center">
                                        FECHA VENTA
                                    </th>
                                    <th class="text-center">
                                        CI/NIT
                                    </th>
                                    <th class="text-center">
                                        CLIENTE
                                    </th>
                                    <th class="text-center">
                                        OBSERVACIONES
                                    </th>
                                    <th class="text-center">
                                        COSTO TOTAL
                                    </th>
                                    <th class="text-center">
                                        VER FACTURA
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        1
                                    </td>
                                    <td class="text-center">
                                        <div class="btn btn-primary"><span class="fa fa-file-o"></span></div>
                                    </td>
                                    <td class="text-center">
                                        1
                                    </td>
                                    <td class="text-center">
                                        19/09/2019
                                    </td>
                                    <td class="text-center">
                                        5488454
                                    </td>
                                    <td class="text-center">
                                        CARDENAS
                                    </td>
                                    <td class="text-center">
                                        VENTAS AL POR MENOR
                                    </td>
                                    <td class="text-center">
                                        150.00
                                    </td>
                                    <td class="text-center">
                                        <div class="btn btn-primary"><span class="fa fa-file-o"></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        2
                                    </td>
                                    <td class="text-center">
                                        <div class="btn btn-primary"><span class="fa fa-file-o"></span></div>
                                    </td>
                                    <td class="text-center">
                                        2
                                    </td>
                                    <td class="text-center">
                                        19/09/2019
                                    </td>
                                    <td class="text-center">
                                        65488454
                                    </td>
                                    <td class="text-center">
                                        CALLEJAS
                                    </td>
                                    <td class="text-center">
                                        VENTAS AL POR MENOR
                                    </td>
                                    <td class="text-center">
                                        120.00
                                    </td>
                                    <td class="text-center">
                                        <div class="btn btn-primary"><span class="fa fa-file-o"></span></div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th class="text-center">
                                        BOLETA
                                    </th>
                                    <th class="text-center">
                                        NRO FACTURA
                                    </th>
                                    <th class="text-center">
                                        FECHA VENTA
                                    </th>
                                    <th class="text-center">
                                        CI/NIT
                                    </th>
                                    <th class="text-center">
                                        CLIENTE
                                    </th>
                                    <th class="text-center">
                                        OBSERVACIONES
                                    </th>
                                    <th class="text-center">
                                        COSTO TOTAL
                                    </th>
                                    <th class="text-center">
                                        VER FACTURA
                                    </th>
                                </tr>
                            </tfoot>
                            <tr>
                            </tr>
                    </table>
                </div>
            </div>
    </div>
</div>
    </div>
</div>

@endsection
@push('scripts')
<script>
var t = $('#lts-orprod').DataTable( {

         "processing": true,
            "serverSide": true,
            "ajax": "/OrdenProduccion/create/",
            "columns":[
                {data: 'orprod_id'},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'orprod_registrado'},
                {data: 'nombre_planta'},
                {data: 'nombreReceta'},
                {data: 'umed_nombre'},
                {data: 'lineaProduccion'},
                {data: 'orprod_cantidad'},
                {data: 'orprod_estado_recep'},
                {data: 'estadoAprobacion'},
                // {data: 'sol_id'},
        ],
        "order": [[ 0, "desc" ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });

    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
</script>
@endpush

