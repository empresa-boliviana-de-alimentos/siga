@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.insumo.insumo_solicitud.solicitud_receta.partials.modalCreateSolReceta')
@include('backend.administracion.insumo.insumo_solicitud.solicitud_receta.partials.modalBoletaSolReceta')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                    <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('InsumoSolicitudesMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">LISTADO DE SOLICITUDES POR RECETAS</label></h4>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                <button class="btn pull-right btn-dark" style="background: #616A6B" data-target="#myCreateSolReceta" data-toggle="modal"><h6 style="color: white;">+&nbsp;NUEVA SOLICITUD POR RECETA</h6></button>
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
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-solreceta">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    
                                    <th>
                                        Opciones
                                    </th>
                                    <th>
                                        Nro Solicitud
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        Receta
                                    </th>
                                    <th>
                                        Estado
                                    </th>
                                    <!-- <th>
                                        Nro Lote
                                    </th>  -->                                   
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    
                                    <th>
                                        Opciones
                                    </th>
                                    <th>
                                        Nro Solicitud
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        Receta
                                    </th>
                                    <th>
                                        Estado
                                    </th>
                                    <!-- <th>
                                        Nro Lote
                                    </th>   -->                                  
                                </tr>
                            </tfoot>
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
    var t = $('#lts-solreceta').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/solReceta/create/",
            "columns":[
                {data: 'sol_id'},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'sol_codnum'},
                {data: 'sol_registrado'},
                {data: 'rec_nombre'},
                {data: 'sol_estado'},
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

        $("#registroSolicitudReceta").click(function(){
            var route="/solReceta";
            var token =$("#token").val();

            var itemSolRec = [];

            $('.items_columsReceta3').each(function(){
                itemSolRec.push({
                    id_insumo: $(this).find('td:eq(4) input').val(),
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
                'receta_solicitud':$("#receta_id").val(),
                'cantidad_solicitud':$("#cant_min_solrec").val(),
                'mercado_solicitud':$("#sol_receta_mercado").val(),
                'solrec_data':itemsRecetaSol,
                },
                success: function(data){
                    //var resJson = JSON.parse(data);
                    console.log('id del saolrec: '+data.sol_id);
                    $('#idBolRecetaSol').val(data.sol_id);
                    $('#iframeboleta').attr('src', 'boletaSolReceta/'+data.sol_id);
                    $('#myBoletaSolReceta').modal('show'); 
                    $("#myCreateSolReceta").modal('toggle');
                    //swal("Solicitud Enviada!", "Enviada con Exito","success");                    
                    $('#lts-solreceta').DataTable().ajax.reload();
                },
                error: function(result)
                {
                // swal("Opss..!", "Error al Enviar la solicitud", "error");
                    var errorCompleto='Tiene los siguientes errores: ';
                    $.each(result.responseJSON.errors,function(indice,valor){
                        errorCompleto = errorCompleto + valor+' ' ;                       
                    });
                    swal("Opss..., Hubo un error!",errorCompleto,"error");
                }
            });
        });





     

</script>
@endpush

