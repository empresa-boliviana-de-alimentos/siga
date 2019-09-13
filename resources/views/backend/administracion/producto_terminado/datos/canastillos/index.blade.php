@extends('backend.template.app')
<style type="text/css" media="screen">
    .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td{
        padding: 1px;
        font-size: 12px;
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
    }
    tbody td {
      background-color: #EEEEEE;
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
@include('backend.administracion.producto_terminado.datos.canastillos.partials.modalCreate')
@include('backend.administracion.producto_terminado.datos.canastillos.partials.modalUpdate')

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('MenuDato') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">LISTA DE CANASTILLOS</p>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myCreateCanastillo">REGISTRAR</button>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover table-striped table-condensed" id = "lts-canastillo">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>#</th>
                                        <th>Descripion</th>
                                        <th>Codigo</th>
                                        <th>Productos a transporte</th>
                                        <th>Altura</th>
                                        <th>Ancho</th>
                                        <th>Largo</th>
                                        <th>Peso</th>
                                        <th>Material</th>
                                        <th>Observacion</th>
                                        <th>C/logo</th>
                                        <th>Foto/Adjunto</th>
                                        <th>Almacenamiento</th>
                                        <th>Transporte</th>
                                        <th>Aplicación</th>
                                        <th>Estado</th>
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
@endsection
@push('scripts')
<script>

   $('#lts-canastillo').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive":true,
        "destroy":true,
        "ajax": "MenuCanastillos/create",
        "columns":[
            {data: 'acciones',orderable: false, searchable: false},
            {data: 'ctl_id'},
            {data: 'ctl_descripcion'},
            {data: 'ctl_codigo'},
            {data: 'ctl_rece_id'},
            {data: 'ctl_altura'},
            {data: 'ctl_ancho'},
            {data: 'ctl_largo'},
            {data: 'ctl_peso'},
            {data: 'ctl_material'},
            {data: 'ctl_observacion'},
            {data: 'ctl_logo'},
            {data: 'ctl_foto_canastillo'},
            {data: 'ctl_almacenamiento'},
            {data: 'ctl_transporte'},
            {data: 'ctl_aplicacion'},
            {data: 'ctl_estado'},
        ],
        "language": {
            "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });

   function MostrarCanastillos(btn){
        var route = "MenuCanastillos/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#ctl_descripcion1").val(res.ctl_descripcion);
            $("#ctl_codigo1").val(res.ctl_codigo);
            $("#ctl_rece_id1").val(res.ctl_rece_id);
            $("#ctl_altura1").val(res.ctl_altura);
            $("#ctl_ancho1").val(res.ctl_ancho);
            $("#ctl_largo1").val(res.ctl_largo);
            $("#ctl_peso1").val(res.ctl_peso);
            $("#ctl_material1").val(res.ctl_material);
            $("#ctl_observacion1").val(res.ctl_observacion);
            $("#ctl_logo1").val(res.ctl_logo);
            $("#ctl_foto_canastillo1").val(res.ctl_foto_canastillo);
            $("#ctl_almacenamiento1").val(res.ctl_almacenamiento);
            $("#ctl_transporte1").val(res.ctl_transporte);
            $("#ctl_aplicacion1").val(res.ctl_aplicacion);
            $("#ctl_id").val(res.ctl_id);
            $('#imagenUpdate').attr('src','archivo/canastillo/'+res.ctl_foto_canastillo);
            $('#imgCapture').val(res.ctl_foto_canastillo);
        });
    }

    function registrar()
    {
        console.log("persona",new FormData($("#canastillos")[0]));
        var route="MenuCanastillos";
        var token =$("#token").val();
        $.ajax({
            url: route,
             headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            async:false,
            processData: false,
            contentType: false,
            dataType: 'json',
            data:new FormData($("#canastillos")[0]),
                success: function(data){
                    $("#myCreateCanastillo").modal('toggle');
                    swal("El canastillo!", "Se registro correctamente!", "success");
                    $('#lts-canastillo').DataTable().ajax.reload();
                },
                error: function(result) {
                        swal("Error..!", "Sucedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    }

      $("#actualizar").click(function(){
        var value =$("#ctl_id").val();
        var route="updateCanastillo";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            async:false,
            processData: false,
            contentType: false,
            dataType: 'json',
            data:new FormData($("#canastillosUpdate")[0]),
            success: function(data){
                $("#myUpdateCanastillo").modal('hide');
                $('.modal-backdrop').remove();
                swal("El canastillo!", "Fue actualizado correctamente!", "success");
                $('#lts-canastillo').DataTable().ajax.reload();
            },error: function(result) {
                  console.log(result);
                 swal("Opss..!", "El canastillo no se puedo actualizar intente de nuevo!", "error")
            }
        });
        });

    function EliminarCanastillo(btn){
        var route="MenuCanastillos/"+btn.value+"";
        var token =$("#token").val();
        swal({   title: "Esta seguro de eliminar el Canastillo?",
          text: "Presione ok para eliminar el registro de la base de datos!",
          type: "warning",   showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si, Eliminar!",
          closeOnConfirm: false
        }, function(){
           $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',

                success: function(data){
                    $('#lts-canastillo').DataTable().ajax.reload();
                    swal("Destino!", "Fue eliminado correctamente!", "success");
                },
                    error: function(result) {
                        swal("Error..!", "El Destino tiene registros en otras tablas!", "error")
                }
            });
        });
    }

</script>
@endpush


