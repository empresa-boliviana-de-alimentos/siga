@extends('backend.template.app')
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
@include('backend.administracion.producto_terminado.ingresos.partials.modalRegistroProducto')

<div class="panel panel-primary">
    <div class="panel-heading">
    <h3 class="panel-title">INGRESO ALMACEN </h3>
    <span class="pull-right">
        <!-- Tabs -->
        <ul class="nav panel-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-shopping-cart"></i>  PRODUCTO TERMINADO</a></li>
            <li><a href="#tab2" data-toggle="tab"><i class="fa fa-shopping-basket"></i>  CANASTILLOS</a></li>
        </ul>
    </span>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header with-border">
                                LISTADO PRODUCTO TERMINADO
                            </div>
                            <div class="box-body">
                                <table class="table table-hover table-striped table-condensed" id = "lts-orp">
                                    <thead class="cf">
                                        <tr>
                                            <th>#</th>
                                            <th>id</th>
                                            <th>Planta</th>
                                            <th>L. Producción</th>
                                            <th>Receta</th>
                                            <th>Codigo ORP</th>
                                            <th>Nro Orden</th>
                                            <th>Cantidad</th>
                                            <th>Tiempo ORP</th>
                                            <th>Aprobación</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="box">
                            <div class="box-header with-border">
                                LISTADO INGRESOS ALMACEN PRODUCTO TERMINADO
                            </div>
                            <div class="box-body">
                                <table class="table table-hover table-striped table-condensed" id = "lts-ingreso_almacen">
                                    <thead>
                                        <tr>
                                            <th>Receta</th>
                                            <th>Codigo</th>
                                            <th>Nro Orden</th>
                                            <th>Cantidad Producida</th>
                                            <th>Lote</th>
                                            <th>Fecha Vencimiento</th>
                                            <th>Costo Unitario</th>
                                            <th>Observacion</th>
                                            <th>Usuario</th>
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
                <ingreso-canastillo :planta="{{ $planta }}" :conductor="{{ $conductor }}"></ingreso-canastillo>
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
    var anio;

    if ((fecha.getMonth()+1) < 10) { vMes = "0" + (fecha.getMonth()+1); }
    else { vMes = (fecha.getMonth()+1); }

    if (fecha.getDate() < 10) { vDia = "0" + fecha.getDate(); }
    else{ vDia = fecha.getDate(); }
    var fechaFinal=vDia+"-"+vMes+"-"+fecha.getFullYear();

    var t = $('#lts-orp').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive":true,
        "ajax": "listar_ORP",
        "columns":[
            {data: 'opciones',orderable: false, searchable: false},
            {data: 'orprod_id'},
            {data: 'nombre_planta'},
            {data: 'lineaProduccion'},
            {data: 'nombreReceta'},
            {data: 'orprod_codigo'},
            {data: 'orprod_nro_orden'},
            {data: 'orprod_cantidad'},
            {data: 'orprod_tiempo_prod'},
            {data: 'estadoAprobacion'},
        ],
        "ordering": false,
        "order": [[ 1, 'asc' ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
   var t1 = $('#lts-ingreso_almacen').DataTable( {

         "processing": true,
            "serverSide": true,
            "responsive":true,
            "ajax": "listarIngresoORP",
            "columns":[
                {data: 'nombreReceta'},
                {data: 'orprod_codigo'},
                {data: 'orprod_nro_orden'},
                {data: 'ipt_cantidad'},
                {data: 'ipt_lote'},
                {data: 'ipt_fecha_vencimiento'},
                {data: 'ipt_costo_unitario'},
                {data: 'ipt_observacion'},
                {data: 'usuario'},
                // {data: 'soladi_id'},
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

   function obtenerORP(id){
         var route = "/obtenerORP/"+id.value;
        $.get(route, function(res){
            if (res.horaTope=="true") {
                $("#orprod_id").val(res.data.orprod_id );
                $("#planta_id").val(res.data.orprod_planta_id);
                $("#rece_id").val(res.data.rece_id);
                $("#ctl_codigo").val(res.data.orprod_codigo);
                $("#ctl_producto").val(res.data.rece_nombre+" "+res.data.rece_presentacion+" "+res.data.sab_nombre);
                $("#ctl_cantidad_min").val(res.data.orprod_cantidad);
                $("#ctl_cantindad_max").val(res.data.orprod_cant_esp);
                $("#ctl_tiempo_hora").val(res.data.orprod_tiempo_prod);
                $("#ctl_tiempo_falta").val(res.numeral);
                $("#ctl_tiempo_literal").val(res.literal);
                $("#ctl_cantidad_producida").val(res.data.orprod_cant_esp);
                $("#ctl_lote").val(0);
                $("#ctl_fecha_vencimiento").val(fechaFinal);
                $("#ctl_costo_unitario").val("0.00");
                $("#ctl_observaciones").val('EL TIEMPO DE PRODUCCIÓN SOBRE PASO LAS HORAS REGISTRE LOS DATOS');
                document.getElementById("ctl_observaciones").readOnly = true;
                document.getElementById("ctl_cantidad_producida").readOnly = true;
                document.getElementById("ctl_lote").readOnly = true;
                document.getElementById("ctl_fecha_vencimiento").readOnly = true;
                document.getElementById("ctl_costo_unitario").readOnly = true;
            }
            else{
                $("#orprod_id").val(res.data.orprod_id );
                $("#planta_id").val(res.data.orprod_planta_id);
                $("#rece_id").val(res.data.rece_id);
                $("#ctl_codigo").val(res.data.orprod_codigo);
                $("#ctl_producto").val(res.data.rece_nombre+" "+res.data.rece_presentacion+" "+res.data.sab_nombre);
                $("#ctl_cantidad_min").val(res.data.orprod_cantidad);
                $("#ctl_cantindad_max").val(res.data.orprod_cant_esp);
                $("#ctl_tiempo_hora").val(res.data.orprod_tiempo_prod);
                $("#ctl_tiempo_falta").val(res.numeral);
                $("#ctl_tiempo_literal").val(res.literal);
                $("#ctl_observaciones").val('');
            }
            console.log("aaa",res);




        });
   }

   function limpiarDatos(){
         document.getElementById("ctl_observaciones").readOnly = false;
         document.getElementById("ctl_cantidad_producida").readOnly = false;
         document.getElementById("ctl_lote").readOnly = false;
         document.getElementById("ctl_fecha_vencimiento").readOnly = false;
         document.getElementById("ctl_costo_unitario").readOnly = false;
         $("#ctl_cantidad_producida").val(0);
         $("#ctl_fecha_vencimiento").val("");
         $("#ctl_lote").val(0);
         $("#ctl_costo_unitario").val("0.00");
         $("#ctl_observaciones").val("");
   }

    function registrarIngreso(){
        var token =$("#token").val();
        var route = "/registrarIngreso";
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'ctl_orprod_id':$("#orprod_id").val(),'ctl_cantidad_producida':$("#ctl_cantidad_producida").val(),'ctl_lote':$("#ctl_lote").val(),'ctl_fecha_vencimiento':$("#ctl_fecha_vencimiento").val(),'ctl_costo_unitario':$("#ctl_costo_unitario").val(),'ctl_tiempo_falta':$("#ctl_tiempo_falta").val(),'ctl_observaciones':$("#ctl_observaciones").val(),'planta_id':$("#planta_id").val(),'rece_id':$("#rece_id").val()},
                success: function(data){
                    if (data.success=="true") {
                        $("#myCreateAlmacen").modal('toggle');
                        swal("El Ingreso!", "Fue registrado correctamente!", "success");
                        $('#lts-orp').DataTable().ajax.reload();
                        $('#lts-ingreso_almacen').DataTable().ajax.reload();
                        limpiarDatos();
                    }else{
                        swal("Error..!",data.mensaje , "error");
                    }

                },
                error: function(result) {
                        swal("Error..!", result, "error");
                }
        });
   }
</script>
@endpush

