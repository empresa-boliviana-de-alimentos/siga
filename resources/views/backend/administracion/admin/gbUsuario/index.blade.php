@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.admin.gbUsuario.partials.modalregUsuario')
@include('backend.administracion.admin.gbUsuario.partials.modalupUsuario')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-8">
                     <h4><label for="box-title">Modulo de Usuarios</label></h4>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                <button class="btn btn-dark fa fa-plus-square pull-right" onclick="LimpiarUsuario();" data-target="#myUserCreate" data-toggle="modal">&nbsp;Nuevo</button>
                </div>
            </div>
            </div>
        </div>
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
    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-usuario" style="width:100%">
        <thead class="cf">
            <tr>
                <th>
                    Acciones
                </th>
                <th>
                    Nombre
                </th>
                <th>
                    Paterno
                </th>
                <th>
                    Usuario
                </th>
                <th>
                    Clave
                </th>
                <th>
                    Estado
                </th>
                <th>
                    Registro
                </th>
                <th>
                    Area Produccion
                </th>
		        <th>
                    Planta
                </th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $('#lts-usuario').DataTable({
                    "responsive": true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": "Usuario/create",
                    "columns":[
                    		{data: 'acciones',orderable: false, searchable: false},
                    		{data: 'prs_nombres'},
                    		{data: 'prs_paterno'},
                    		{data: 'usr_usuario'},
                    		{data: 'password'},
                    		{data: 'usr_estado'},
                    		{data: 'usr_registrado'},
                    		{data: 'areaProd'},
				{data: 'nombre_planta'}
                    ],
                      "language": {
                        "url": "/lenguaje"
                    },
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
 	});
 	$("#registroUsuario").click(function()
    {
        var route="Usuario";
         var token =$("#token").val();
        $.ajax({
            url: route,
             headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'usr_usuario':$("#usuario").val(),'usr_clave':$("#clave").val(),'usr_prs_id':$("#usr_prs_id").val(),'usr_linea_trabajo':$("#usr_linea_trabajo").val(),'usr_planta_id':$("#usr_planta_id").val(),'usr_zona_id':$("#usr_zona_id").val(),'usr_id_turno':$("#usr_id_turno").val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#myUserCreate").modal('toggle');
                    swal("El Usuario!", "Fue registrado correctamente!", "success");
                    $('#lts-usuario').DataTable().ajax.reload();

                },
                error: function(result) {
                        swal("Opss..!", "Sucedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });
 	function MostrarUsuario(btn)
 	{
    	var route = "Usuario/"+btn.value+"/edit";
    	$.get(route, function(res){
            $("#usr_id").val(res.usr_id);
        	$("#usuario1").val(res.usr_usuario);
            $("#usr_clave1").val(res.usr_clave);
        	$("#clave1").val("");
        	$("#usr_prs_id1").val(res.usr_prs_id);
            $("#usr_id_turno1").val(res.usr_id_turno);
    	});
    }
 	$("#actualizar").click(function()
 	{
        
        if($("#clave1").val() != "" && $("#usuario1").val()){
            
            swal({title: "Esta seguro de actualizar los datos del Usuario?",
                    text: "Presione ok para confirmar!",
                    type: "warning",   showCancelButton: true,
                    confirmButtonColor: "#6cdd55",
                    confirmButtonText: "Si, Actualizar!",
                    closeOnConfirm: false
                }, function(){
                    var value =$("#usr_id").val();
                    var route="Usuario/"+value+"";
                    var token =$("#token").val();
                    $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'PUT',
                        dataType: 'json',
                        data: {'usr_usuario':$("#usuario1").val(),'usr_clave':$("#clave1").val(),'usr_prs_id':$("#usr_prs_id1").val(),'usr_id_turno':$("#usr_id_turno1").val()},
                        success: function(data){
                            $("#myUserUpdate").modal('toggle');
                            swal("El Usuario!", "Fue actualizado correctamente!", "success");
                            $('#lts-usuario').DataTable().ajax.reload();
                        },  error: function(result) {
                              console.log(result);
                             swal("Opss..!", "El Grupo no se puedo actualizar intente de nuevo!", "error")
                        }
                    });
            });
        }else{
            swal("Opss..!", "Es necesario llenar de informacion para Actualizar los datos!", "error");
        }

        
    });
    function EliminarUsuario(btn){
        var route="Usuario/"+btn.value+"";
        var token =$("#token").val();
        swal({   title: "Esta seguro de eliminar al usuario?",
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
                    $('#lts-usuario').DataTable().ajax.reload();
                    swal("Usuario!", "Fue eliminado correctamente!", "success");
                },
                    error: function(result) {
                        swal("Opss..!", "El Usuario tiene registros en otras tablas!", "error")
                }
            });
         });
    }

    function LimpiarUsuario()
    {
        $("#usuario").val("");
        $("#clave").val("");
        $("#usr_prs_id").val("");
        
    }
</script>
@endpush

