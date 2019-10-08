@extends('backend.template.app')
@include('backend.administracion.producto_terminado.despacho.partials.modalORPDespacho')
@include('backend.administracion.producto_terminado.despacho.partials.modalPTDespacho')
@include('backend.administracion.producto_terminado.despacho.partials.modalCanastilloDespacho')
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
    <h3 class="panel-title">DESPACHO ALMACEN ORDEN DE PRODUCCION ,PRODUCTO TERMINADO Y CANASTILLAS</h3>
    <span class="pull-right">
        <!-- Tabs -->
        <ul class="nav panel-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-shopping-cart"></i>  ORDEN DE PRODUCCION</a></li>
            <li><a href="#tab2" data-toggle="tab" onclick="listarProductoTerminado();"><i class="fa fa-shopping-cart"></i>  PRODUCTO TERMINADO</a></li>
            <li><a href="#tab3" data-toggle="tab" onclick="listarCanastilloGeneral();"><i class="fa fa-shopping-basket"></i>  CANASTILLO</a></li>
        </ul>
    </span>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <div class="row">
                    <div class="col-md-7">
                        <div class="box">
                            <div class="box-header with-border">
                                LISTADO ORDEN PRODUCCIÓN
                            </div>
                            <div class="box-body">
                                <table class="table table-hover table-striped table-condensed" id = "lts-ingreso_orp">
                                    <thead>
                            		<tr>
                            				<th>Opciones</th>
                                            <th>Nro</th>
                                            <th>Receta</th>
                                            <th>Codigo</th>
                                            <th>Nro Orden</th>
                                            <th>Hora Salida</th>
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
                    <div class="col-md-5">
                        <div class="box-header with-border">
                                LISTADO DESPACHO ORDEN PRODUCCIÓN
                            </div>
                            <div class="box-body">
                                <table class="table table-hover table-striped table-condensed" id = "lts-despacho_orp">
                                    <thead>
                                        <tr>
                                            <th>Nro</th>
                                            <th>Producto</th>
                                            <th>Cod. ORP</th>
                                            <th>Cod. Salida</th>
                                            <th>Cantidad</th>
                                            <th>Origen</th>
                                            <th>Destino</th>
                                            <th>Linea</th>
                                            <th>Fecha despacho</th>
                                            <th>Despacho</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                            </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab2">
                <div class="row">
                    <div class="col-md-7">
                        <div class="box">
                            <div class="box-header with-border">
                                LISTADO PRODUCTO TERMINADO SOBRANTES
                            </div>
                            <div class="box-body">
                                <table class="table table-hover table-striped table-condensed" id = "lts-producto-terminado">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>#</th>
                                            <th>Receta</th>
                                            <th>Codigo</th>
                                            <th>Nro. Orden</th>
                                            <th>Cantidad Sobrante</th>
                                            <th>Lote</th>
                                            <th>Fecha Vencimiento</th>
                                            <th>Costo Unitario</th>
                                            <th>Usuario</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="box-header with-border">
                                LISTADO PRODUCTO TERMINADO DESPACHADO
                            </div>
                            <div class="box-body">
                                <table class="table table-hover table-striped table-condensed" id="lts-despacho_pt">
                                    <thead>
                                        <tr>
                                            <th>Nro</th>
                                            <th>Producto</th>
                                            <th>Cod. ORP</th>
                                            <th>Cod. Salida</th>
                                            <th>Cantidad</th>
                                            <th>Origen</th>
                                            <th>Destino</th>
                                            <th>Linea</th>
                                            <th>Fecha despacho</th>
                                            <th>Despacho</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                            </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab3">
                <div class="row">
                    <div class="col-md-6">
                            <div class="box">
                                <div class="box-header with-border">
                                    LISTADO CANASTILLOS
                                </div>
                                <div class="box-body">
                                    <table class="table table-hover table-striped table-condensed" id="lts-canastilla-general">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>#</th>
                                                <th>Nro Ingreso</th>
                                                <th>Fecha Ingreso</th>
                                                <th>Producto</th>
                                                <th>Descripcion</th>
                                                <th>Material</th>
                                                <th>Foto</th>
                                                <th>Cantidad</th>
                                                <th>Conductor</th>
                                                <th>Usuario</th>
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
                                    LISTADO CANASTILLOS DESPACHADOS
                                </div>
                                <div class="box-body">
                                    <table class="table table-hover table-striped table-condensed" id="lts-canastilla-despacho">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nro Ingreso</th>
                                                <th>Fecha Ingreso</th>
                                                <th>Descripcion</th>
                                                <th>Material</th>
                                                <th>Foto</th>
                                                <th>Cantidad</th>
                                                <th>Fecha Salida</th>
                                                <th>Codigo Salida</th>
                                                <th>Conductor</th>
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

var t1 = $('#lts-ingreso_orp').DataTable( {
 "processing": true,
    "serverSide": true,
    "responsive":true,
    "ajax": "listarORPInicial",
    "columns":[
        {data: 'acciones'},
        {data: 'ipt_id'},
        {data: 'nombreReceta'},
        {data: 'orprod_codigo'},
        {data: 'orprod_nro_orden'},
        {data: 'ipt_hora_falta'},
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
 t1.on( 'order.dt search.dt', function () {
        t1.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();


 var t2 = $('#lts-despacho_orp').DataTable( {
 "processing": true,
    "serverSide": true,
    "responsive":true,
    "ajax": "listarDespachoORP",
    "columns":[
        {data: 'dao_id'},
        {data: 'rece_nombre'},
        {data: 'orprod_codigo'},
        {data: 'dao_codigo_salida'},
        {data: 'dao_cantidad'},
        {data: 'origen'},
        {data: 'destino'},
        {data: 'lineaProduccion'},
        {data: 'dao_fecha_despacho'},
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
 t2.on( 'order.dt search.dt', function () {
        t2.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

   function obtenerORP(id){
        var route = "/obtenerORPIngreso/"+id.value;
        $.get(route, function(res){
            console.log("aaa",res.tiempo);
            $("#ipt_id").val(res.data.ipt_id );
            $("#rece_id").val(res.data.rece_id);
            $("#ctl_codigo").val(res.data.orprod_codigo);
            $("#ctl_producto").val(res.data.rece_nombre+" "+res.data.rece_presentacion+" "+res.data.sab_nombre);
            $("#ctl_cantidad_min").val(res.data.orprod_cantidad);
            $("#ctl_cantindad_max").val(res.data.orprod_cant_esp);
            $("#ctl_tiempo_hora").val(res.data.orprod_tiempo_prod);
            $("#ctl_tiempo_falta").val(res.data.ipt_hora_falta+' Horas');
            $("#ctl_cantidad_producida").val(res.data.ipt_cantidad);
            $("#ctl_lote").val(res.data.ipt_lote);
            $("#ctl_fecha_vencimiento").val(res.data.ipt_fecha_vencimiento);
            $("#ipt_costo_unitario").val(res.data.ipt_costo_unitario);
            $("#ctl_observaciones").val(res.data.ipt_observacion);
            $("#ipt_fecha_despacho").val(res.fecha_despacho.date);
            $("#ipt_id_planta").val(res.data.id_planta);
            if (res.data.orprod_cantidad<res.data.orprod_cant_esp) {
                $("#ipt_cantidad_enviar").val(res.data.orprod_cantidad);
            }
            if (res.data.ipt_cantidad >=res.data.orprod_cantidad) {
                var total=res.data.ipt_cantidad-res.data.orprod_cantidad;
                console.log("pruebas",res.data.ipt_cantidad-res.data.orprod_cantidad,res.data.orprod_cantidad)
                $("#ipt_cantidad_stock").val(total);
            }else{
                $("#ipt_cantidad_stock").val(0);
            }
        });
   }

    function registrarDespacho(){
        var token =$("#token").val();
        var route = "/registrarDespachoORP";
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'ipt_id':$("#ipt_id").val(),'ipt_fecha_despacho':$("#ipt_fecha_despacho").val(),'ipt_cantidad_enviar':$("#ipt_cantidad_enviar").val(),'ipt_cantidad_stock':$("#ipt_cantidad_stock").val(),'ipt_despacho_id':$("#ipt_despacho_id").val(),'ipt_id_planta':$("#ipt_id_planta").val(),'rece_id':$("#rece_id").val(),'ipt_costo_unitario':$("#ipt_costo_unitario").val()},
                success: function(data){
                    if (data.success=="true") {
                        $("#modalORPDespacho").modal('toggle');
                        swal("El despacho orden de producción!", "Fue registrado correctamente!", "success");
                        $('#lts-ingreso_orp').DataTable().ajax.reload();
                        $('#lts-despacho_orp').DataTable().ajax.reload();
                    }else{
                        swal("Error..!",data.mensaje , "error");
                    }
                },
                error: function(result) {
                        swal("Error..!", result, "error");
                }
        });
   }

   function listarProductoTerminado(){
        var t3 = $('#lts-producto-terminado').DataTable( {
            "processing": true,
            "serverSide": true,
            "responsive":true,
            "destroy":true,
            "ajax": "lstProductoTerminado",
            "columns":[
                {data: 'acciones'},
                {data: 'ipt_id'},
                {data: 'nombreReceta'},
                {data: 'orprod_codigo'},
                {data: 'orprod_nro_orden'},
                {data: 'total'},
                {data: 'ipt_lote'},
                {data: 'ipt_fecha_vencimiento'},
                {data: 'ipt_costo_unitario'},
                {data: 'usuario'},
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
         t3.on( 'order.dt search.dt', function () {
                t3.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
        } ).draw();

        var t4 = $('#lts-despacho_pt').DataTable( {
             "processing": true,
                "serverSide": true,
                "responsive":true,
                "destroy":true,
                "ajax": "listaDespachoPT",
                "columns":[
                    {data: 'dao_id'},
                    {data: 'rece_nombre'},
                    {data: 'orprod_codigo'},
                    {data: 'dao_codigo_salida'},
                    {data: 'dao_cantidad'},
                    {data: 'origen'},
                    {data: 'destino'},
                    {data: 'lineaProduccion'},
                    {data: 'dao_fecha_despacho'},
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
            t4.on( 'order.dt search.dt', function () {
                    t4.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
            } ).draw();
       }

    function obtenerPT(id,cantidad,reseta){
        var route = "/obtenerPTDespacho/"+id.value;
        $("#ipt_sobrante_pt").val(cantidad);
        $("#idreceta_pt").val(reseta);
        $.get(route, function(res){
            $("#ipt_id_pt").val(res.data.ipt_id );
            $("#ipt_orprod_id").val(res.data.ipt_orprod_id);
            $("#ipt_planta_pt").val(res.data.id_planta );
            $("#ctl_codigo_pt").val(res.data.orprod_codigo);
            $("#ctl_producto_pt").val(res.data.rece_nombre+" "+res.data.rece_presentacion+" "+res.data.sab_nombre);
            $("#ipt_fecha_despacho_pt").val(res.fecha_despacho.date);
            $("#ipt_costo_unitario").val(res.data.ipt_costo_unitario );
            $("#ipt_fecha_vencimiento").val(res.data.ipt_fecha_vencimiento );
            $("#ipt_hora_falta").val(res.data.ipt_hora_falta );
            $("#ipt_lote").val(res.data.ipt_lote);
        });
    }


    function registrarProductoTerminado(){
        var cantsobrante = parseFloat($("#ipt_sobrante_pt").val());
        var cantdespacho = parseFloat($("#ipt_despacho").val());
        var token =$("#token").val();
        var route = "/registrarDespachoPT";
        if (cantsobrante < cantdespacho) {
            swal('Advertencia','Cantidad Despacho: '+cantdespacho+', es mayor a la cantidad sobrante: '+cantsobrante,'warning');
        }else{
            console.log("positivo");
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {'ipt_id_pt':$("#ipt_id_pt").val(),'ipt_planta_pt':$("#ipt_planta_pt").val(),'ipt_sobrante_pt':$("#ipt_sobrante_pt").val(),'ipt_fecha_despacho_pt':$("#ipt_fecha_despacho_pt").val(),'ipt_despacho_id_pt':$("#ipt_despacho_id_pt").val(),'idreceta_pt':$("#idreceta_pt").val(),'ipt_orprod_id':$("#ipt_orprod_id").val(),'ipt_costo_unitario':$("#ipt_costo_unitario").val(),'ipt_fecha_vencimiento':$("#ipt_fecha_vencimiento").val(),'ipt_hora_falta':$("#ipt_hora_falta").val(),'ipt_lote':$("#ipt_lote").val(),'ipt_despacho':$("#ipt_despacho").val()},
                success: function(data){
                    if (data.success=="true") {
                        $("#modalPTDespacho").modal('toggle');
                        swal("El despacho producto terminado!", "Fue registrado correctamente!", "success");
                        $('#lts-producto-terminado').DataTable().ajax.reload();
                        $('#lts-despacho_pt').DataTable().ajax.reload();
                    }else{
                        swal("Error..!",data.mensaje , "error");
                    }
                },
                error: function(result) {
                        swal("Error..!", result, "error");
                }
            });
        }
        
    }

    function listarCanastilloGeneral(){
        var t5 = $('#lts-canastilla-general').DataTable( {
         "processing": true,
            "serverSide": true,
            "responsive":true,
            "destroy":true,
            "ajax": "lstCanastillosG",
            "columns":[
                {data: 'acciones'},
                {data: 'iac_id'},
                {data: 'iac_nro_ingreso'},
                {data: 'iac_fecha_ingreso'},
                {data: 'producto'},
                {data: 'ctl_descripcion'},
                {data: 'ctl_material'},
                {data: 'ctl_foto_canastillo'},
                {data: 'iac_cantidad'},
                {data: 'conductor'},
                {data: 'usuario'},
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
        t5.on( 'order.dt search.dt', function () {
                t5.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
        } ).draw();


        var t6 = $('#lts-canastilla-despacho').DataTable( {
             "processing": true,
            "serverSide": true,
            "responsive":true,
            "destroy":true,
            "ajax": "lstCanastillaDespacho",
            "columns":[
                {data: 'iac_id'},
                {data: 'iac_nro_ingreso'},
                {data: 'iac_fecha_ingreso'},
                {data: 'ctl_descripcion'},
                {data: 'ctl_material'},
                {data: 'ctl_foto_canastillo'},
                {data: 'iac_cantidad'},
                {data: 'iac_fecha_salida'},
                {data: 'iac_codigo_salida'},
                {data: 'conductor'},
                {data: 'usuario'},
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
        t6.on( 'order.dt search.dt', function () {
                t6.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
        } ).draw();
    }

    function obtenerDatosCanastillo(id){
        console.log("aaaa");
        var route = "/obtenerDatosCanastillo/"+id.value;
        $.get(route, function(res){
            $("#iac_id").val(res.data.iac_id );
            $("#ctl_descripcion").val(res.data.ctl_descripcion);
            $("#iac_fecha_ingreso").val(res.data.iac_fecha_ingreso);
            $("#iac_fecha_despacho").val(res.fecha_despacho.date);
            $("#iac_cantidad").val(res.data.iac_cantidad);
            $("#iac_de_id").val(1);
            $("#iac_planta_id").val(res.data.iac_origen);
        });
    }


    function registrarCanastilla(){
         var token =$("#token").val();
        var route = "/regCanastillaDespacho";
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'iac_id':$("#iac_id").val(),'ctl_descripcion':$("#ctl_descripcion").val(),'iac_fecha_ingreso':$("#iac_fecha_ingreso").val(),'iac_fecha_despacho':$("#iac_fecha_despacho").val(),'iac_cantidad':$("#iac_cantidad").val(),'iac_de_id':$("#iac_de_id").val(),'iac_planta_id':$("#iac_planta_id").val()},
                success: function(data){
                    if (data.success=="true") {
                        $("#modalCanastilloDespacho").modal('toggle');
                        swal("El canastilo!", "Fue despachado correctamente!", "success");
                        $('#lts-canastilla-general').DataTable().ajax.reload();
                        $('#lts-canastilla-despacho').DataTable().ajax.reload();
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

