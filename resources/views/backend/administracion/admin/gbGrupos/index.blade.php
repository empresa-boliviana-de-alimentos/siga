@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.admin.gbGrupos.partials.modalUpdate')
@include('backend.administracion.admin.gbGrupos.partials.modalCreate')
<div class="row">
   <div class="col-md-12">
      <section class="content-header">
       <div class="header_title">
         <h3>
            Grupo
            <small>
                <button class="btn btn-dark fa fa-plus-square pull-right" data-target="#myCreate" data-toggle="modal">&nbsp;Nuevo</button>
            </small>
         </h3>
       </div>
      </section>
   </div>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
            </div>
            <div class="box-body">
            <div id="no-more-tables">
           <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-grupo" style="width:100%">
        <thead class="cf">
            <tr>
                <th>
                    Acciones
                </th>
                <th>
                    Grupo
                </th>
                <th>
                    Imagen
                </th>
                <th>
                    Fecha
                </th>
                <th>
                    Estado
                </th>
            </tr>
        </thead>
        <tr>
        </tr>
    </table>
</div>
@endsection
@push('scripts')
<script>
    $('#lts-grupo').DataTable( {
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/Grupo/create",
        "columns":[
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'grp_grupo'},
                {data: 'grp_imagen'},
                {data: 'grp_registrado'},
                {data: 'grp_estado'},

        ],

        "language": {
            "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });

    function Mostrar(btn){
    var route = "/Grupo/"+btn.value+"/edit";
    $.get(route, function(res){
        $("#nombre").val(res.grp_grupo);
        $("#imagen").val(res.grp_imagen);
        $("#fecha1").val(res.grp_registrado);
        $("#fecha2").val(res.grp_modificado);
        $("#usuarioId").val(res.grp_usr_id);
        $("#estado").val(res.grp_estado);
        $("#id").val(res.grp_id);
    });
    }
    function registrar()
    {
         var route="Grupo";
         var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'grp_grupo':$("#nombrereg").val(),'grp_imagen':$("#imagenreg").val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#myCreate").modal('toggle');
                    swal("El Grupo!", "Fue registrado correctamente!", "success");
                    $('#lts-grupo').DataTable().ajax.reload();

                },
                error: function(result) {
                        swal("Opss..!", "Sucedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    }

    $("#actualizar").click(function(){
        var value =$("#id").val();
        var route="Grupo/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {'grp_grupo':$("#nombre").val(),'grp_imagen':$("#imagen").val(),'grp_registrado':$("#fecha1").val(),'grp_modificado':$("#fecha2").val(),'grp_usr_id':$("#usuarioId").val(),'grp_estado':$("#estado").val()},
            success: function(data){
                $("#myUpdate").modal('toggle');
                swal("El Grupo!", "Fue actualizado correctamente!", "success");
                $('#lts-grupo').DataTable().ajax.reload();


            },  error: function(result) {
                  console.log(result);
                 swal("Opss..!", "El Grupo no se puedo actualizar intente de nuevo!", "error")
            }
        });
        });

    function Eliminar(btn){
    var route="Grupo/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el Grupo?",
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
                    $('#lts-grupo').DataTable().ajax.reload();
                    swal("Grupo!", "Fue eliminado correctamente!", "success");
                },
                    error: function(result) {
                        swal("Opss..!", "El Grupo tiene registros en otras tablas!", "error")
                }
            });
    });
    }
</script>
@endpush




