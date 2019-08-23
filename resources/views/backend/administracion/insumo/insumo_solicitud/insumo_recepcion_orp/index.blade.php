@extends('backend.template.app')
@section('main-content')
<div class="panel panel-primary">
        <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left"  href="{{ url('InsumoSolicitudesMenu') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">RECEPCIÓN ORDEN DE PRODUCCIÓN</p>
            </div>
            <div class="col-md-3 text-right">

            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                    <div class="box-body">
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-orprod">
                            <thead class="cf">
                                <tr>
                                    <th class="text-center">
                                        No
                                    </th>
                                    <th class="text-center">
                                        No ORP
                                    </th>
                                    <th class="text-center">
                                        FECHA
                                    </th>
                                    <th class="text-center">
                                        PRODUCTO
                                    </th>
                                    <th class="text-center">
                                        CANTIDAD
                                    </th>
                                    <th class="text-center">
                                        ORIGEN
                                    </th>
                                    <th class="text-center">
                                        ESTADO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">
                                        No
                                    </th>
                                    <th class="text-center">
                                        No ORP
                                    </th>
                                    <th class="text-center">
                                        FECHA
                                    </th>
                                    <th class="text-center">
                                        PRODUCTO
                                    </th>
                                    <th class="text-center">
                                        CANTIDAD
                                    </th>
                                    <th class="text-center">
                                        ORIGEN
                                    </th>
                                    <th class="text-center">
                                        ESTADO
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
            "ajax": "/CreateRecepcionOrp",
            "columns":[
                {data: 'orprod_id'},
                {data: 'orprod_nro_orden'},
                {data: 'orprod_registrado'},
                {data: 'nombre_planta'},
                {data: 'rece_nombre'},
                {data: 'orprod_cantidad'},
                {data: 'acciones',orderable: false, searchable: false},
                // {data: 'sol_id'},
        ],

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

