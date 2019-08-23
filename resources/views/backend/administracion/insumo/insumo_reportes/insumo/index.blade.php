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
@include('backend.administracion.insumo.insumo_registro..proveedores.partials.modalCreate')
@include('backend.administracion.insumo.insumo_registro..proveedores.partials.modalUpdate')
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">INSUMOS KARDEX</h3>
    </div>
    <div class="panel-body">
        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-inskardex">
                            <thead>
                                <tr>
                                    <th style="width: 100px;">
                                       #
                                    </th>
                                    <th style="width: 100px;">
                                        kardex Valorado
                                    </th>
                                    <th style="width: 100px;">
                                        Kardex Físico
                                    </th>

                                    <th style="width: 450px;">
                                        Insumo
                                    </th>
                                    <th style="width: 250px;">
                                        Unidad Medida
                                    </th>
                                    <th>
                                        Stock Actual
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                            </tr>
                    </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
    var t = $('#lts-inskardex').DataTable( {

         "processing": true,
            "serverSide": true,
            "ajax": "/ListKardex/create/",
            "columns":[
                {data: 'ins_id'},
                {data: 'kardexValorado',orderable: false, searchable: false},
                {data: 'kardexFisico',orderable: false, searchable: false},
                {data: 'NombreInsumo'},
                {data: 'umed_nombre'},
                {data: 'stocks_cantidad'}
        ],

        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         "order": [[ 0, "desc" ]],


    });
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
</script>
@endpush


