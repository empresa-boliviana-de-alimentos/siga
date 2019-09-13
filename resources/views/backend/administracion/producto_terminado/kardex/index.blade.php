@extends('backend.template.app')
@include('backend.administracion.producto_terminado.kardex.partials.modalPTFechas')

<style type="text/css" media="screen">
      .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td{
        padding: 1px;
    }
    table.dataTable tbody th, table.dataTable tbody td {
        padding: 8px 10px;
        color: dimgrey;
        font-size: 12px;
    }

    thead th {
      background-color:#428bca;
      color: white;
      font-size: 12px;
      border:1px;
        border: 1px solid white;
    }
    tbody td {
      background-color: #EEEEEE;
      font-size: 12px;
    }
    .panel-tabs {
        position: relative;
        bottom: 30px;
        clear:both;
        border-bottom: 1px solid transparent;
    }

    .panel-tabs > li {
        float: left;
        margin-bottom: -1px;
    }

    .panel-tabs > li > a {
        margin-right: 2px;
        margin-top: 4px;
        line-height: .85;
        border: 1px solid transparent;
        border-radius: 4px 4px 0 0;
        color: #ffffff;
    }

    .panel-tabs > li > a:hover {
        border-color: transparent;
        color: #ffffff;
        background-color: transparent;
    }

    .panel-tabs > li.active > a,
    .panel-tabs > li.active > a:hover,
    .panel-tabs > li.active > a:focus {
        color: #fff;
        cursor: default;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        background-color: rgba(255,255,255, .23);
        border-bottom-color: transparent;
    }
</style>

@section('main-content')
<div class="panel panel-primary">
    <div class="panel-heading">
    <h3 class="panel-title">KARDEX ALMACEN PRODUCTO TERMINADO / CANASTILLOS</h3>
    <span class="pull-right">
        <!-- Tabs -->
        <ul class="nav panel-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-shopping-cart"></i>PRODUCTO TERMINADO</a></li>
            <li><a href="#tab2" data-toggle="tab"><i class="fa fa-shopping-cart"></i>CANASTILLOS</a></li>
        </ul>
    </span>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                LISTADO PRODUCTO TERMINADO KARDEX
                            </div>
                            <div class="box-body">
                                <table class="table table-hover table-striped table-condensed" id = "lts-kardex">
                                    <thead>
                                        <tr>
                                            <th>Nro</th>
                                            <th>Codigo del Producto</th>
                                            <th>Nombre del Producto</th>
                                            <th>Linea</th>
                                            <th>Cantidad</th>
                                            <th>Kardex</th>
                                            <th>Fecha Vencimiento</th>
                                            <th>Lotes</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab2">

            </div>
        </div>
    </div>
</div>


@endsection
@push('scripts')

<script>
$('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    language: "es",
    autoclose: true
});

var fecha= new Date();
var vDia;
var vMes;

if ((fecha.getMonth()+1) < 10) { vMes = "0" + (fecha.getMonth()+1); }
else { vMes = (fecha.getMonth()+1); }

if (fecha.getDate() < 10) { vDia = "0" + fecha.getDate(); }
else{ vDia = fecha.getDate(); }

var t1 = $('#lts-kardex').DataTable( {
 "processing": true,
    "serverSide": true,
    "responsive":true,
    "ajax": "listarPTKardex",
    "columns":[
        {data: 'xspt_rece_id'},
        {data:'xrece_codigo'},
        {data: 'nombreReceta'},
        {data: 'lineaProduccion'},
        {data: 'xtotal'},
        {data: 'kardex'},
        {data: 'fechavencimiento'},
        {data: 'lotes'},
    ],
    "columnDefs": [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
    } ],
    "order": [[ 1, 'asc' ]],
    "language": {
         "url": "/lenguaje"
    },
     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
     t1.on( 'order.dt search.dt', function () {
            t1.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
    } ).draw();

     function obtenerFechaVencimiento(id_rece,planta){
        console.log("algo",id_rece,planta);
        var t1 = $('#lts-fecha-vencimiento').DataTable( {
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

             var friTotal = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
            // Update footer by showing the total with the reference of the column index
            $( api.column( 0 ).footer() ).html('Cantidad Total:');
                $( api.column( 7 ).footer() ).html(friTotal);
            },
            "processing": true,
            "serverSide": true,
            "responsive":true,
            "destroy":true,

            "ajax": "listarFechaVencimiento/"+id_rece.value+"/"+planta,
            "columns":[
                {data: 'orprod_id'},
                {data:'rece_nombre'},
                {data: 'rece_codigo'},
                {data: 'nombre_planta'},
                {data: 'lineaProduccion'},
                {data: 'ipt_fecha_vencimiento'},
                {data: 'ipt_lote'},
                {data: 'ipt_cantidad'},
            ],

            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],

            "order": [[ 0, 'asc' ]],
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            });
             t1.on( 'order.dt search.dt', function () {
                    t1.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
            } ).draw();
     }
</script>
@endpush

