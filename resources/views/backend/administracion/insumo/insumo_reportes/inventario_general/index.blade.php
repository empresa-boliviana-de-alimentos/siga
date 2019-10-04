@extends('backend.template.app')
@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <div class="col-md-12">
                    <div class="col-md-1">
                        <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('ReporteGralInsumo') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                    </div>
                        <div class="col-md-4">
                             <h4><label for="box-title">INVENTARIO GENERAL</label></h4>
                        </div>
                </div>
                
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group">
                                <input type="text" class="form-control datepickerMonths" id="id_mes" name="id_mes" placeholder="Introduzca mes"> 
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="busca_mes" onclick="Buscarfechas();">Buscar por Mes</button>
                            </span>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group">
                                <input type="text" class="form-control datepickerDays" id="id_dia" name="id_dia" placeholder="Introduzca dia"> 
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarfechaDia();">Buscar por dia</button>
                            </span>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group">
                                <div class="col-md-6">
                                <input type="text" class="form-control datepickerDays" id="id_dia_inicio" name="id_dia_inicio" placeholder="Introduzca dia">
                                </div>
                                <div class="col-md-6">
                                <input type="text" class="form-control datepickerDays" id="id_dia_fin" name="id_dia_fin" placeholder="Introduzca dia">  
                                </div>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarfechaRango();">Buscar rango fechas</button>
                            </span>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                    <div class="box-body">
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-listaInventario">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        Codigo Insumo
                                    </th>
                                    <th>
                                        Detalle Articulo
                                    </th>
                                    <th>
                                        Unidad
                                    </th>
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Partida
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        
                                    </th>                                     
                                </tr>
                            </thead>
                            <tr>
                            </tr>
                    </table>
                </div>    
            </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    Buscarfechas();
});

function Buscarfechas() {
        console.log($("#id_mes").val());
        $('#lts-listaInventario').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "RptInvMes/"+ $("#id_mes").val(),
               type: "GET",
               data: {"mes": $("#id_mes").val()}
             },
            "columns":[
                {data: 'ins_codigo'},
                {data: 'ins_desc'}, 
                {data: 'unidad'},
                {data: 'quantity'},
                {data: 'part_nombre'},
                {data: 'his_stock_registrado'},
                {data: 'nombre_planta'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
        initComplete: function () {
            this.api().columns(6).every( function () {
                var column = this;
                var select = $('<select><option value="">Planta</option></select>')
                    .appendTo( $(column.header()).text('') )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         "order": [[ 0, "desc" ]],
        /*"paging":   true,
        "ordering": true,
        "info":     true,
        "dom" : 'Bfrtip',
        "buttons" : [

            {
                extend: 'excelHtml5',
                title: 'EXCEL INVENTARIO GENERAL'
            },
            {
                extend: 'pdfHtml5',
                download: 'open',
                title: 'PDF INVENTARIO GENERAL'
            }
        ]*/
       
    });

}
function BuscarfechaDia() {
        console.log($("#id_dia").val());
        $('#lts-listaInventario').DataTable( {
        "destroy": true,
        "processing": true,
            "serverSide": true,
            "ajax":{
               url : "RptInvDia/"+ $("#id_dia").val(),
               type: "GET",
               data: {"mes": $("#id_dia").val()}
             },
            "columns":[
               {data: 'ins_codigo'},
                {data: 'ins_desc'}, 
                {data: 'unidad'},
                {data: 'quantity'},
                {data: 'part_nombre'},
                {data: 'his_stock_registrado'},
                {data: 'nombre_planta'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
        initComplete: function () {
            this.api().columns(6).every( function () {
                var column = this;
                var select = $('<select><option value="">Planta</option></select>')
                    .appendTo( $(column.header()).text('') )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },
         // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // "order": [[ 0, "desc" ]],
        "dom" : 'Bfrtip',
        "paging":   false,
        "ordering": false,
        "info":     false,
        "buttons" : [

            {
                extend: 'excelHtml5',
                title: 'EXCEL INVENTARIO GENERAL'
            },
            {
                extend: 'pdfHtml5',
                download: 'open',
                title: 'PDF INVENTARIO GENERAL'
            }
        ]
       
    });

}

function BuscarfechaRango() {
        console.log($("#id_dia_inicio").val()+'/'+$("#id_dia_fin").val());
        $('#lts-listaInventario').DataTable( {
        "destroy": true,
        "processing": true,
            "serverSide": true,
            "ajax":{
               url : "RptInvRango/"+$("#id_dia_inicio").val()+"/"+$("#id_dia_fin").val(),
               type: "GET",
               data: {"dia_inicio": $("#id_dia_inicio").val()},
               data: {"dia_fin": $("#id_dia_fin").val()}
             },
            "columns":[
                {data: 'ins_codigo'},
                {data: 'ins_desc'}, 
                {data: 'unidad'},
                {data: 'quantity'},
                {data: 'part_nombre'},
                {data: 'his_stock_registrado'},
                {data: 'nombre_planta'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
        initComplete: function () {
            this.api().columns(6).every( function () {
                var column = this;
                var select = $('<select><option value="">Planta</option></select>')
                    .appendTo( $(column.header()).text('') )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },
         // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // "order": [[ 0, "desc" ]],
        "dom" : 'Bfrtip',
        "paging":   false,
        "ordering": false,
        "info":     false,
        "buttons" : [

            {
                extend: 'excelHtml5',
                title: 'EXCEL INVENTARIO GENERAL'
            },
            {
                extend: 'pdfHtml5',
                download: 'open',
                title: 'PDF INVENTARIO GENERAL',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
       
    });

}


    $('.datepickerMonths').datepicker({
        format: "mm/yyyy",
        viewMode: "months", 
        minViewMode: "months",
        language: "es",
    }).datepicker("setDate", new Date()); 

    $('.datepickerDays').datepicker({
        format: "dd/mm/yyyy",        
        language: "es",
    }).datepicker("setDate", new Date());  

</script>
@endpush


