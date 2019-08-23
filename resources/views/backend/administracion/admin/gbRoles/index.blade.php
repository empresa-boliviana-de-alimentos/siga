@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.admin.gbRoles.partials.modalUpdate')
@include('backend.administracion.admin.gbRoles.partials.modalCreate')
<div class="row">
   <div class="col-md-12">
      <section class="content-header">
       <div class="header_title">
         <h3>
            Roles
            <small>
                <button class="btn btn-dark fa fa-plus-square pull-right" onclick="LimpiarRol();" data-target="#myCreate" data-toggle="modal">&nbsp;Nuevo</button>
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
            <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-rol" style="width:100%">
            <thead class="cf">
            <tr>
                <th>
                    Acciones
                </th>
                <th>
                    Nombre
                </th>
                <th>
                    Fecha registro
                </th>
                <th>
                    Fecha modificado
                </th>
                <th>
                    Estado
                </th>
		<th>
                    Area Produccion
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
    $('#lts-rol').DataTable( {
            "responsive": true, 
            "processing": true,
            "serverSide": true,
            "ajax": "Rol/create",
            "columns":[
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'rls_rol'},
                {data: 'rls_registrado'},
                {data: 'rls_modificado'},
                {data: 'rls_estado'},
		{data: 'areaProd'},
        ],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });

    function Mostrar(btn){
    var route = "/Rol/"+btn.value+"/edit";
    $.get(route, function(res){
        $("#rol").val(res.rls_rol);
        $("#id").val(res.rls_id);
    });
    }
    $("#registro").click(function(){
        var route="Rol";
         var token =$("#token").val();
        $.ajax({
            url: route,
             headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            data: {'rls_rol':$("#rls_rol").val(),'linea_trabajo':$("#lineatrabajo").val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#myCreate").modal('toggle');
                    swal("El Rol!", "Se registrado correctamente!", "success");
                    $('#lts-rol').DataTable().ajax.reload();

                },
                error: function(result) {
                        swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });

	$("#actualizar").click(function(){
            var value =$("#id").val();
            var route="Rol/"+value+"";
            var token =$("#token").val();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'PUT',
                dataType: 'json',
                data: {'rls_rol':$("#rol").val(),'rls_linea_trabajo':$("#lineatrabajo1").val()},
                success: function(data){
                    $("#myUpdate").modal('toggle');
                    swal("El Rol!", "Fue actualizado correctamente!", "success");
                    $('#lts-rol').DataTable().ajax.reload();


                },  error: function(result) {
                      console.log(result);
                     swal("Opss..!", "El Rol no se puedo actualizar intente de nuevo!", "error")
                }
            });
        });



	function Eliminar(btn){
    var route="Rol/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el Rol?",
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
                $('#lts-rol').DataTable().ajax.reload();
                swal("Rol!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El Grupo tiene registros en otras tablas!", "error")
            }
        });
    });
    }

    function LimpiarRol()
    {
        $("#rls_rol").val("");        
    }
</script>
@endpush


