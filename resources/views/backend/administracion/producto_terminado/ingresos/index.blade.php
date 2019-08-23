@extends('backend.template.app')
@section('main-content')
<style type="text/css" media="screen">
  .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td{
    padding: 1px;
}
table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px 10px;
    color: dimgrey;
    font-size: 8px;
}
</style>
@include('backend.administracion.insumo.insumo_solicitud.solicitud_recibida.partials.modalCreateAprobacion')
@include('backend.administracion.insumo.insumo_solicitud.solicitud_recibida.partials.modalCreateAproSolInsumos')

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">                
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">INGRESO ALMACÉN</p>
            </div>
            <div class="col-md-3 text-right">
            </div>
        </div>
    </div>
    <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" class="col-md-12">
                        <li class="active" id="tabsolReceta" class="col-md-6">
                            <a data-toggle="tab" href="#solReceta" class="btn btn-primary" style="font-size: 11px">
                              PRODUCTO TERMINADO
                            </a>
                        </li>
                        <li id="tabsolInsumo" class="col-md-6">
                            <a data-toggle="tab" href="#solInsumo" class="btn btn-warning" style="font-size: 11px">
                                CANASTILLOS
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade in active" id="solReceta">
                       <div class="box">
                                <div class="box-header with-border text-center">
                                    <h3 class="box-title">
                                        LISTADO DE INGRESOS DE PRODUCTOS TERMINADOS
                                    </h3>
                                </div>
                            <div id="no-more-tables">
                                <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-solporReceta">
                                    <thead class="cf">
                                                <tr>
                                                    <th>
                                                        No
                                                    </th>
                                                    <th>
                                                        No.
                                                    </th>
                                                    <th>
                                                        N° ORP
                                                    </th>
                                                    <th>
                                                        N° SALIDA
                                                    </th>
                                                    <th>
                                                        Fecha
                                                    </th>
                                                    <th>
                                                        Receta
                                                    </th>
                                                    <th>
                                                        Solicitante
                                                    </th>
                                                    <th>
                                                        Estado
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>
                                                        N°
                                                    </th>
                                                    <th>
                                                        Opc.
                                                    </th>
                                                    <th>
                                                        N° ORP
                                                    </th>
                                                    <th>
                                                        N° SALIDA
                                                    </th>
                                                    <th>
                                                        Fecha
                                                    </th>
                                                    <th>
                                                        Receta
                                                    </th>
                                                    <th>
                                                        Solicitante
                                                    </th>
                                                    <th>
                                                        Estado
                                                    </th>

                                                </tr>
                                            </tfoot>
                                </table>
                            </div>
                        </div>
                        </div>
                        <div class="tab-pane fade" id="solInsumo">
                            <div class="box">
                                <div class="box-header with-border text-center">
                                    <h3 class="box-title">
                                        LISTADO DE INGRESOS DE CANASTILLOS
                                    </h3>
                                </div>
                                <div class="box-body">
                                 <div id="no-more-tables">
                                    <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-solporInsumo">
                                        <thead class="cf">
                                                <tr>
                                                    <th>
                                                        N°
                                                    </th>
                                                    <th>
                                                        Opc.
                                                    </th>
                                                    <th>
                                                        N° ORP
                                                    </th>
                                                    <th>
                                                        N° SALIDA
                                                    </th>
                                                    <th>
                                                        Fecha
                                                    </th>
                                                    <th>
                                                        Receta
                                                    </th>
                                                    <th>
                                                        Solicitante
                                                    </th>
                                                    <th>
                                                        Estado
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>
                                                        N°
                                                    </th>
                                                    <th>
                                                        Opc.
                                                    </th>
                                                    <th>
                                                        N° ORP
                                                    </th>
                                                    <th>
                                                        N° SALIDA
                                                    </th>
                                                    <th>
                                                        Fecha
                                                    </th>
                                                    <th>
                                                        Receta
                                                    </th>
                                                    <th>
                                                        Solicitante
                                                    </th>
                                                    <th>
                                                        Estado
                                                    </th>

                                                </tr>
                                            </tfoot>
                                    </table>
                                </div>
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

<!-- <section class="content"> -->


<!-- </section> -->
@endsection
@push('scripts')

<script>

    var t = $('#lts-solporReceta').DataTable( {
         "processing": true,
            "serverSide": true,
            "ajax": "/solRecibidas/create/",
            "columns":[
                {data: 'orprod_id',orderable: false, searchable: false},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'orprod_nro_orden'},
                {data: 'orprod_nro_salida'},
                {data: 'orprod_registrado'},
                {data: 'rece_nombre'},
                {data: 'nombresCompletoRe'},
                {data: 'estado_orprod'},
                // {data: 'solrec_id'},
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
   t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
   var t1 = $('#lts-solporInsumo').DataTable( {

         "processing": true,
            "serverSide": true,
            "ajax": "listAdicional",
            "columns":[
                {data: 'orprod_id',orderable: false, searchable: false},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'orprod_nro_orden'},
                {data: 'orprod_nro_salida'},
                {data: 'orprod_registrado'},
                {data: 'rece_nombre'},
                {data: 'nombresCompletoAdi'},
                {data: 'sol_ins_estado'},
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
        t1.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    var t2 = $('#lts-solporTraspaso').DataTable( {

         "processing": true,
            "serverSide": true,
            "ajax": "listTraspaso",
            "columns":[
                {data: 'orprod_id',orderable: false, searchable: false},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'orprod_nro_orden'},
                {data: 'orprod_nro_salida'},
                {data: 'orprod_registrado'},
                {data: 'nombre_planta'},
                {data: 'nombresCompletoTras'},
                {data: 'sol_tras_estado'},
                // {data: 'solmaq_id'},
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
        t2.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    var t2 = $('#lts-solporMaquila').DataTable( {

         "processing": true,
            "serverSide": true,
            "ajax": "listMaquila",
            "columns":[
                {data: 'orprod_id',orderable: false, searchable: false},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'orprod_nro_orden'},
                {data: 'orprod_nro_salida'},
                {data: 'orprod_registrado'},
                {data: 'maquila_nombre'},
                {data: 'nombresCompletoMa'},
                {data: 'sol_maq_estado'},
                // {data: 'solmaq_id'},
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
        t2.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    // MOSTRAR SOLICITUD POR RECETAS
    function mostrarSolReceta(btn){
        var route = "MostrarSolReceta/"+btn.value;
        $.get(route, function(res){
            console.log(res);
            $("#id_solReceta").val(res.sol_id);
            $("#cod_solReceta").val(res.sol_codnum);
            $("#nombre_sol_receta").val(res.rec_nombre);
            $("#sol_cantidad_rec").val(res.sol_cantidad);
            $("#solicitante_sol_rec").val(res.prs_nombres+' '+res.prs_paterno+' '+res.prs_materno);
            $("#mercado_sol_rec").val(res.merc_nombre);
            $( "#TableSolRecetas tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
            var datosSolRec = JSON.parse(res.sol_data);
            console.log('Total item: '+datosSolRec.length);
            for (i = 0; i < datosSolRec.length; i++){
                 $("#TableSolRecetas").append('<tr class="items_columsAproReceta3">' +
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosSolRec[i].codigo_insumo + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosSolRec[i].descripcion_insumo + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosSolRec[i].unidad + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosSolRec[i].cantidad+ '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="hidden" name="nro[]" class="form-control" readonly value="'+ datosSolRec[i].rango_adicional + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="hidden" name="nro[]" class="form-control" readonly value="'+ datosSolRec[i].id_insumo + '"></input></td>'+'</tr>');
            }
        });
    }
    // END MOSTRAR SOLICITUD POR RECETA
    // MOSTRAR SOLICITUD POR INSUMOS
    function mostrarSolInsumos(btn){
        var route = "MostrarSolInsumo/"+btn.value;
        $.get(route, function(res){
            console.log(res);
            $("#id_soladi").val(res.sol_id);
            $("#cod_soladi").val(res.sol_codnum);
            $("#nombre_sol_insumos").val(res.rec_nombre);
            // $("#sol_insumos_lote").val(res.soladi_num_lote);
            // $("#sol_insumos_salida").val(res.soladi_num_salida);
            $("#sol_nota_salida").val(res.sol_nro_salida);
            $("#solicitante_sol_insumos").val(res.prs_nombres+' '+res.prs_paterno+' '+res.prs_materno);
            $("#mercado_sol_insumos").val(res.merc_nombre);
            $("#observ_sol_insumos").val(res.sol_obs);
            $( "#TableSolInsumos tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
            var datosSolAdi = JSON.parse(res.sol_data);
            console.log('Total item: '+datosSolAdi.length);
            for (i = 0; i < datosSolAdi.length; i++){
                 $("#TableSolInsumos").append('<tr class="items_columsInsumos3">' +
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosSolAdi[i].codigo_insumo + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosSolAdi[i].descripcion_insumo + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosSolAdi[i].unidad + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosSolAdi[i].cantidad+ '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="hidden" name="nro[]" class="form-control" readonly value="'+ datosSolAdi[i].rango_adicional + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosSolAdi[i].solicitud_adicional + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosSolAdi[i].observaciones + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="hidden" name="nro[]" class="form-control" readonly value="'+ datosSolAdi[i].id_insumo + '"></input></td>'+'</tr>');
            }
        });
    }
    // END MOSTRAR SOLICITUD POR INSUMOS
    // MOSTRAR SOLICITUD POR TRASPASO/MAQUILA
    function mostrarSolTraspaso(btn){
        var route = "MostrarSolTrapaso/"+btn.value;
        $.get(route, function(res){
            console.log(res);
            $("#id_solMaquila").val(res.sol_id);
            $("#id_insumo").val(res.ins_id);
            $("#cod_solMaquila").val(res.sol_codnum);
            $("#codigo_insumo").val(res.ins_codigo);
            $("#nombre_sol_traspaso").val(res.ins_desc);
            $("#sol_cant_traspaso").val(res.sol_cantidad);
            $("#sol_um_traspaso").val(res.sol_um);
            $("#sol_origen_traspaso").val(res.planta_origen);
            $("#sol_destino_traspaso").val(res.planta_destino);
            $("#sol_obs_traspaso").val(res.sol_obs);
        });
    }
    // END MOSTRAR SOLICITUD POR TRASPASO/MAQUILA

    // APROVACIONES
    // APROVACION DE RECETA
    $("#aprovacionReceta").click(function(){
            var route="AprovacionSolReceta";
            var token =$("#token").val();

            var itemSolRec = [];

            $('.items_columsAproReceta3').each(function(){
                itemSolRec.push({
                    id_insumo: $(this).find('td:eq(5) input').val(),
                    codigo_insumo: $(this).find('td:eq(0) input').val(),
                    descripcion_insumo: $(this).find('td:eq(1) input').val(),
                    unidad: $(this).find('td:eq(2) input').val(),
                    cantidad: $(this).find('td:eq(3) input').val(),
                    // rango_adicional: $(this).find('td:eq(4) input').val(),
                    rango_adicional: "0",
                    solicitud_adicional: "0"
                });
            });

            itemsRecetaSol = JSON.stringify(itemSolRec);
            console.log('Json Table Regsitro: '+itemsRecetaSol);
            // console.log('id Receta: '+$("#receta_id").val());
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'aprsol_solreceta_id':$("#id_solReceta").val(),
                'aprsol_data':itemsRecetaSol,
                'aprsol_cod_solReceta': $("#cod_solReceta").val()
                },
                success: function(data){
                    //var resJson = JSON.parse(data);
                    console.log('resultado: '+data.aprsol_id);
                    $('#idBolRecetaSol').val(data.aprsol_id);
                    $('#iframeboleta').attr('src', 'BoletaAprovaReceta/'+data.aprsol_id);
                    $('#myBoletaAprobaReceta').modal('show');
                    $("#myCreateSolRecibidas").modal('toggle');
                    //swal("Solicitud Enviada!", "Enviada con Exito","success");
                    $('#lts-solporReceta').DataTable().ajax.reload();
                },
                error: function(result)
                {
                swal("Opss..!", "Error al Enviar la solicitud", "error");
                }
        });
    });
    // APROVACION DE INSUMO ADICIONAL
    $("#aprovacionInsumoAdi").click(function(){
            var route="AprovSolInsAdicional";
            var token =$("#token").val();

            var itemSolAdi = [];

            $('.items_columsInsumos3').each(function(){
                itemSolAdi.push({
                    id_insumo: $(this).find('td:eq(7) input').val(),
                    codigo_insumo: $(this).find('td:eq(0) input').val(),
                    descripcion_insumo: $(this).find('td:eq(1) input').val(),
                    unidad: $(this).find('td:eq(2) input').val(),
                    cantidad: $(this).find('td:eq(3) input').val(),
                    rango_adicional: $(this).find('td:eq(4) input').val(),
                    solicitud_adicional: $(this).find('td:eq(5) input').val(),
                    observacion: $(this).find('td:eq(6) input').val()
                });
            });

            itemsAdiSol = JSON.stringify(itemSolAdi);
            console.log('Json Table Regsitro: '+itemsAdiSol);
            // console.log('id Receta: '+$("#receta_id").val());
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'aprsol_soladi_id':$("#id_soladi").val(),
                'aprsol_data':itemsAdiSol,
                'aprsol_cod_soladi':$("#cod_soladi").val()
                },
                success: function(data){
                    //var resJson = JSON.parse(data);
                    console.log('resultado: '+data.aprsol_id);
                    $('#idBolRecetaSol').val(data.aprsol_id);
                    $('#iframeboletaAdi').attr('src', 'BoletaAprovaInsumoAdi/'+data.aprsol_id);
                    $('#myBoletaAprobaInsumoAdi').modal('show');
                    $("#myCreateSolInsumos").modal('toggle');
                    //swal("Solicitud Enviada!", "Enviada con Exito","success");
                    $('#lts-solporInsumo').DataTable().ajax.reload();
                },
                error: function(result)
                {
                swal("Opss..!", "Error al Enviar la solicitud", "error");
                }
        });
    });
    // APROVACION DE TRAPASO/MAQUILA
    $("#aprovMaquila").click(function(){
            var route="AprovSolTraspaso";
            var token =$("#token").val();

            var itemSolMaquila = [];

            // $('.items_columsReceta3').each(function(){
                itemSolMaquila.push({
                    id_insumo: $("#id_insumo").val(),
                    codigo_insumo: $("#codigo_insumo").val(),
                    descripcion_insumo: $("#nombre_sol_traspaso").val(),
                    unidad: $("#sol_um_traspaso").val(),
                    cantidad: $("#sol_cant_traspaso").val(),
                    rango_adicional: "0",
                    solicitud_adicional: "0"
                });
            // });

            itemsMaquilaSol = JSON.stringify(itemSolMaquila);
            console.log('Json Table Regsitro: '+itemsMaquilaSol);
            // console.log('id Receta: '+$("#receta_id").val());
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'aprsol_solmaq_id':$("#id_solMaquila").val(),
                'aprsol_data':itemsMaquilaSol,
                'aprsol_cod_solmaquila':$("#cod_solMaquila").val()
                },
                success: function(data){
                    console.log('resultado: '+data.aprsol_id);
                    $('#idBolMaquilaSol').val(data.aprsol_id);
                    $('#iframeboletaMaq').attr('src', 'BoletaAprovaTraspaso/'+data.aprsol_id);
                    $('#myBoletaAprobaInsumoMaq').modal('show');
                    $("#myCreateSolTraspaso").modal('toggle');
                    //swal("Solicitud Enviada!", "Enviada con Exito","success");
                    $('#lts-solporMaquila').DataTable().ajax.reload();
                },
                error: function(result)
                {
                swal("Opss..!", "Error al Enviar la solicitud", "error");
                }
        });
    });

    // RECHAZOS A SOLICITUDES
    // RECHAZO SOLICITUD RECETA
    $("#rechazoReceta").click(function(){
            var route="RechazoSolReceta";
            var token =$("#token").val();

            var itemSolRec = [];

            $('.items_columsAproReceta3').each(function(){
                itemSolRec.push({
                    id_insumo: $(this).find('td:eq(5) input').val(),
                    codigo_insumo: $(this).find('td:eq(0) input').val(),
                    descripcion_insumo: $(this).find('td:eq(1) input').val(),
                    unidad: $(this).find('td:eq(2) input').val(),
                    cantidad: $(this).find('td:eq(3) input').val(),
                    rango_adicional: $(this).find('td:eq(4) input').val()
                });
            });

            itemsRecetaSol = JSON.stringify(itemSolRec);
            console.log('Json Table Regsitro: '+itemsRecetaSol);
            // console.log('id Receta: '+$("#receta_id").val());
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'aprsol_solreceta_id':$("#id_solReceta").val(),
                'aprsol_data':itemsRecetaSol,
                },
                success: function(data){
                    console.log(data);
                    swal(data, "La solicitud por receta por rechazada!", "error");
                    $("#myCreateSolRecibidas").modal('toggle');
                    $('#lts-solporReceta').DataTable().ajax.reload();
                },
                error: function(result)
                {
                swal("Opss..!", "Error al Enviar la solicitud", "error");
                }
        });
    });
    // RECHAZO SOLICITUD INSUMO ADICIONAL
    $("#rechazoInsumoAdi").click(function(){
            var route="RechazoSolInsumoAdi";
            var token =$("#token").val();

            var itemSolAdi = [];

            $('.items_columsInsumos3').each(function(){
                itemSolAdi.push({
                    id_insumo: $(this).find('td:eq(7) input').val(),
                    codigo_insumo: $(this).find('td:eq(0) input').val(),
                    descripcion_insumo: $(this).find('td:eq(1) input').val(),
                    unidad: $(this).find('td:eq(2) input').val(),
                    cantidad: $(this).find('td:eq(3) input').val(),
                    rango_adicional: $(this).find('td:eq(4) input').val(),
                    cantidad_adicional: $(this).find('td:eq(5) input').val(),
                    observacion: $(this).find('td:eq(6) input').val(),
                });
            });

            itemsAdiSol = JSON.stringify(itemSolAdi);
            console.log('Json Table Regsitro: '+itemsAdiSol);
            // console.log('id Receta: '+$("#receta_id").val());
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'aprsol_soladi_id':$("#id_soladi").val(),
                'aprsol_data':itemsAdiSol,
                },
                success: function(data){
                    console.log(data);
                    swal(data, "La solicitud por insumo adicional fue rechazada!", "error");
                    $("#myCreateSolInsumos").modal('toggle');
                    //swal("Solicitud Enviada!", "Enviada con Exito","success");
                    $('#lts-solporInsumo').DataTable().ajax.reload();
                },
                error: function(result)
                {
                swal("Opss..!", "Error al Enviar la solicitud", "error");
                }
        });
    });
    // RECHAZO SOLICITUD TRAPASO MAQUILA
    $("#rechazoMaquila").click(function(){
            var route="RechazoSolTraspaso";
            var token =$("#token").val();

            var itemSolMaquila = [];

            // $('.items_columsInsumos3').each(function(){
                itemSolMaquila.push({
                    id_insumo: $("#id_insumo").val(),
                    codigo_insumo: $("#codigo_insumo").val(),
                    descripcion_insumo: $("#nombre_sol_traspaso").val(),
                    unidad: $("#sol_um_traspaso").val(),
                    cantidad: $("#sol_cant_traspaso").val()
                });
            // });

            itemsMaquilaSol = JSON.stringify(itemSolMaquila);
            console.log('Json Table Regsitro: '+itemsMaquilaSol);
            // console.log('id Receta: '+$("#receta_id").val());
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'aprsol_solmaq_id':$("#id_solMaquila").val(),
                'aprsol_data':itemsMaquilaSol,
                },
                success: function(data){
                   console.log(data);
                    swal(data, "La solicitud por Traspaso/Maquila fue rechazada!", "error");
                    $("#myCreateSolTraspaso").modal('toggle');
                    //swal("Solicitud Enviada!", "Enviada con Exito","success");
                    $('#lts-solporMaquila').DataTable().ajax.reload();
                },
                error: function(result)
                {
                swal("Opss..!", "Error al Enviar la solicitud", "error");
                }
        });
    });
</script>
@endpush

