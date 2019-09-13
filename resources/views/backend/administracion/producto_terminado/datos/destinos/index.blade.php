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

    .my_style {
        font-weight:bold;
        color:black;
        background: #ffc107;
        text-align: right;
    }
    .my_style2 {
        text-align: right;
    }

</style>
@section('main-content')
@include('backend.administracion.producto_terminado.datos.destinos.partials.modalCreate')
@include('backend.administracion.producto_terminado.datos.destinos.partials.modalUpdate')

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('MenuDato') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">LISTA DE DESTINOS</p>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myCreateDestino">REGISTRAR</button>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover table-striped table-condensed cf" id = "lts-destino">
                                <thead class="cf">
                                    <tr>
                                        <th>Opciones</th>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Departamento</th>
                                        <th>Mercado</th>
                                        <th>Linea de trabajo</th>
                                        <th>Planta</th>
                                        <th>Usuario</th>
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
   $('#lts-destino').DataTable( {
        "processing": true,
        "serverSide": true,
        "destroy":true,
        "ajax": "MenuDestinos/create",
        "columns":[
            {data: 'acciones',orderable: false, searchable: false},
            {data: 'de_id'},
            {data: 'de_nombre'},
            {data: 'de_departamento'},
            {data: 'de_mercado'},
            {data: 'de_linea_trabajo'},
            {data: 'de_planta_id'},
            {data: 'de_usr_id'},
            {data: 'de_estado'},
        ],
        "language": {
            "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
   function MostrarDestinos(btn){
    var route = "MenuDestinos/"+btn.value+"/edit";
    $.get(route, function(res){
        $("#de_linea_trabajo1").val(res.de_linea_trabajo);
        $("#de_planta_id1").val(res.de_planta_id);
        $("#de_mercado1").val(res.de_mercado);
        $("#de_departamento1").val(res.de_departamento);
        $("#de_nombre1").val(res.de_nombre);
        $("#de_id1").val(res.de_id);
    });
    }
    function registrar()
    {
         var route="MenuDestinos";
         var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'de_nombre':$("#de_nombre").val(),'de_departamento':$("#de_departamento").val(),'de_mercado':$("#de_mercado").val(),'de_linea_trabajo':$("#de_linea_trabajo").val(),'de_planta_id':$("#de_planta_id").val()},
                success: function(data){
                    $("#myCreateDestino").modal('toggle');
                    swal("El Destino!", "Fue registrado correctamente!", "success");
                    $('#lts-destino').DataTable().ajax.reload();

                },
                error: function(result) {
                        swal("Error!", "Sucedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    }

    $("#actualizar").click(function(){
        var value =$("#de_id1").val();
        console.log("valor",value);
        var route="MenuDestinos/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {'de_nombre':$("#de_nombre1").val(),'de_departamento':$("#de_departamento1").val(),'de_mercado':$("#de_mercado1").val(),'de_linea_trabajo':$("#de_linea_trabajo1").val(),'de_planta_id':$("#de_planta_id1").val()},
            success: function(data){
                $("#myUpdateDestino").modal('toggle');
                swal("El Destino!", "Fue actualizado correctamente!", "success");
                $('#lts-destino').DataTable().ajax.reload();


            },  error: function(result) {
                  console.log(result);
                 swal("Error..!", "El Destino no se puedo actualizar intente de nuevo!", "error")
            }
        });
        });

    function EliminarDestino(btn){
        var route="MenuDestinos/"+btn.value+"";
        var token =$("#token").val();
        swal({   title: "Esta seguro de eliminar el Destino?",
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
                        $('#lts-destino').DataTable().ajax.reload();
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


