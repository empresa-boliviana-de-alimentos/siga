@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.insumo.insumo_recetas.partials.modalCreate')
<!-- @include('backend.administracion.insumo.insumo_registro.servicios.partials.modalUpdate') -->
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">LISTADO DE RECETAS</p>
            </div>
            <div class="col-md-3 text-right">
                <a href="{{url('RegistroReceta')}}" class="btn btn-default btn-xs" style="background: #616A6B;">
                        <h6 style="color: white;"><i class="fa fa-plus">
                    </i>&nbsp;NUEVA RECETA</h6>
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
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-receta">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Codigo Receta
                                    </th>
                                    <th>
                                        Operaciones
                                    </th>
                                    <th>
                                        Nombre Receta
                                    </th>
                                    <th>
                                        Base
                                    </th>
                                    <th>
                                        Unidad
                                    </th>
                                    <!--<th>
                                        Planta
                                    </th>-->
                                    <th>
                                        Linea Producción
                                    </th>
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
                                        Codigo Receta
                                    </th>
                                    <th>
                                        Operaciones
                                    </th>
                                    <th>
                                        Nombre Receta
                                    </th>
                                    <th>
                                        Base
                                    </th>
                                    <th>
                                        Unidad
                                    </th>
                                    <!--<th>
                                        Planta
                                    </th>-->
                                    <th>
                                        Linea Producción
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
    var t = $('#lts-receta').DataTable( {

         "processing": true,
            "serverSide": true,
            "ajax": "/InsumoRecetas/create/",
            "columns":[
                {data: 'rece_id',orderable: false, searchable: false},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'rece_codigo'},
                {data: 'rece_nombre'},
                {data: 'rece_rendimiento_base'},
                {data: 'umed_nombre'},
                {data: 'linea_prod'},

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

     function Limpiar(){
        $("#nombre").val("");
        $("#empresa").val("");
        $("#nit").val("");
        $("#factura").val("");
        $("#costo").val("");
        $("#mes").val("");
      }

        $("#registroReceta").click(function(){
            var route="/InsumoRecetas";
            var token =$("#token").val();

            var items = [];
            var codigo;
            var codIns;
            var descIns;
            var idIns;
            $('.items_columsReceta2').each(function(){
                // var cant = $(this).find('td:eq(2) input').val();
                // if (cant == "") {
                //     swal("Opss..., Hubo un error! asdasd","error");
                // }else{
                    codigo = $(this).find('td:eq(0) select').val();
                    console.log(codigo);
                    codIns = codigo.split("+")[0];
                    descIns = codigo.split("+")[1];
                    idIns = codigo.split("+")[2];
                    items.push({
                        // nro: $(this).find('td:eq(0) input').val(),
                        ins_id: idIns,
                        cod_ins: codIns,
                        descripcion: descIns,
                        //unidad: $(this).find('td:eq(1) select').val(),
                        cantidad: $(this).find('td:eq(1) input').val(),
                        // rango_adicional: $(this).find('td:eq(4) input').val()
                        rango_adicional: "0"
                    });
                // }
            });

            itemsReceta = JSON.stringify(items);
            console.log(itemsReceta);

            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'nombre_receta':$("#nombre_receta").val(),
                'cantidad_minima_receta':$("#cant_minima").val(),
                'unidad_base':$("#unidad_base").val(),
                'planta_receta':$("#receta_planta").val(),
                'produccion_receta':$("#receta_produccion").val(),
                'mercado_receta':$("#receta_mercado").val(),
                'rec_data': itemsReceta,

                },
                success: function(data){
                    $("#myCreateReceta").modal('toggle');
                    //swal("Receta!", "registro correcto","success");
                    //$('#lts-receta').DataTable().ajax.reload();
                    swal({
                                title: "Exito",
                                text: "Registrado con Exito",
                                type: "success"
                                            },
                                function(){
                                        location.reload();
                            });
                },
                error: function(result)
                {
                // swal("Opss..!", "Error al registrar el dato", "error");
                    var errorCompleto='Tiene los siguientes errores: ';
                    $.each(result.responseJSON.errors,function(indice,valor){
                        errorCompleto = errorCompleto + valor+' ' ;
                    });
                    swal("Opss..., Hubo un error!",errorCompleto,"error");
                }
            });
        });

        function Eliminar(btn){
        var route="/InsumoRecetas/"+btn.value+"";
        var token =$("#token").val();
        swal({   title: "Eliminacion de registro?",
          text: "Uds. esta a punto de eliminar 1 registro",
          type: "warning",   showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Eliminar!",
          closeOnConfirm: false
        }, function(){
           $.ajax({
                    url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'DELETE',
                    dataType: 'json',

                    success: function(data){
                        $('#lts-receta').DataTable().ajax.reload();
                        swal("Acceso!", "El registro fue dado de baja!", "success");
                    },
                        error: function(result) {
                            swal("Opss..!", "error al procesar la solicitud", "error")
                    }
                });
        });
        }


</script>
@endpush
