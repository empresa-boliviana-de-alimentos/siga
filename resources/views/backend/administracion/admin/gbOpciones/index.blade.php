@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.admin.gbOpciones.partials.modalUpdate')
@include('backend.administracion.admin.gbOpciones.partials.modalCreate')

<div class="row">
 <div class="col-md-12">
  <section class="content-header">
     <div class="header_title">
       <h3>
        Opciones
        <small>
            <button class="btn btn-round btn-dark fa fa-plus-square pull-right" data-target="#myCreate" data-toggle="modal">&nbsp;Nuevo</button>
        </small>
    </h3>
</div>
</section>
</div>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="box-header with-border">
                </div>
                <div class="box-body">
                    <div id="unseen">
                        <table class="table table-bordered table-striped table-condensed" id="lts-opcion" style="width:100%">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        Acciones
                                    </th>
                                    <th>
                                        Grupo
                                    </th>
                                    <th>
                                        Contenido
                                    </th>
                                    <th>
                                        Ruta
                                    </th>
                                    <th>
                                        Usuario
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
                        $('#lts-opcion').DataTable( {
                           "responsive": true,
                           "processing": true,
                           "serverSide": true,
                           "ajax": "Opcion/create",
                           "columns":[
                           {data: 'acciones',orderable: false, searchable: false},
                           {data: 'grp_grupo'},
                           {data: 'opc_opcion'},
                           {data: 'opc_contenido'},
                           {data: 'usr_usuario'},
                           ],

                           "language": {
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

                    });
                        function Mostrar(btn){
                            var route = "Opcion/"+btn.value+"/edit";
                            $.get(route, function(res){
                                $("#grp_id").val(res.opc_grp_id);
                                $("#opc_opcion").val(res.opc_opcion);
                                $("#opc_contenido").val(res.opc_contenido);
                                $("#opc_estado").val(res.opc_estado);
                                $("#id").val(res.opc_id);
                            });
                        }

                        $("#registro").click(function(){
                            var route="Opcion";
                            var token =$("#token").val();
                            //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
                            $.ajax({
                                url: route,
                                headers: {'X-CSRF-TOKEN': token},
                                type: 'POST',
                                dataType: 'json',
                                data: {'opc_grp_id':$("#grpid").val(),'opc_opcion':$("#opcopcion").val(),'opc_contenido':$("#opccontenido").val()},
                                success: function(data){
                                        //$('#myCreate').fadeIn(1000).html(data);
                                        $("#myCreate").modal('toggle');
                                        swal("La opcion!", "Fue registrada correctamente!", "success");
                                        $('#lts-opcion').DataTable().ajax.reload();

                                    },
                                    error: function(result) {
                                        swal("Opss..!", "Sucedio un problema al registrar inserte bien los datos!", "error");
                                    }
                                });
                        });

                        $("#actualizar").click(function(){
                            var value =$("#id").val();
                            var route="Opcion/"+value+"";
                            var token =$("#token").val();
                            $.ajax({
                                url: route,
                                headers: {'X-CSRF-TOKEN': token},
                                type: 'PUT',
                                dataType: 'json',
                                data: {'opc_grp_id':$("#grp_id").val(),'opc_opcion':$("#opc_opcion").val(),'opc_contenido':$("#opc_contenido").val(),'opc_estado':$("#opc_estado").val()},
                                success: function(data){
                                    $("#myUpdate").modal('toggle');
                                    swal("La opcion!", "Fue actualizado correctamente!", "success");
                                    $('#lts-opcion').DataTable().ajax.reload();
                                },  error: function(result) {
                                  console.log(result);
                                  swal("Opss..!", "El Grupo no se puedo actualizar intente de nuevo!", "error")
                              }
                          });
                        });

                        function Eliminar(btn){
                            var route="Opcion/"+btn.value+"";
                            var token =$("#token").val();
                            swal({   title: "Esta seguro de eliminar la opcion?",
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
                                    $('#lts-opcion').DataTable().ajax.reload();
                                    swal("Opcion!", "Fue eliminado correctamente!", "success");
                                },
                                error: function(result) {
                                    swal("Opss..!", "El Grupo tiene registros en otras tablas!", "error")
                                }
                            });
                         });
                        }
                    </script>
                    @endpush

