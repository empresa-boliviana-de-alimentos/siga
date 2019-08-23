@extends('backend.template.app')
@include('backend.administracion.admin.gbAccesos.partials.modalCreate')
@include('backend.administracion.admin.gbAccesos.partials.modalUpdate')
@section('main-content')
<div class="row">
 <div class="col-md-12">
  <section class="content-header">
     <div class="header_title">
       <h3>
        Accesos
        <small>
            <button class="btn btn-warning fa fa-plus-square pull-right" data-target="#myCreate" data-toggle="modal">&nbsp;Nuevo</button>
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
                       <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-acceso" style="width: 100px">
                          <thead class="cf">
                              <tr>
                                <th>Controles</th>
                                <th>Acceso Opcion</th>
                                <th>Acceso Rol</th>
                                <th>Fecha Registro</th>
                                <th>Fecha Modificacion</th>
                                <th>Acceso Usuario</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                @endsection

                @push('script')
                <script>
                  $('#lts-acceso').DataTable({
                     "responsive": true,
                     "processing": true,
                     "serverSide": true,
                     "ajax": "Acceso/create",
                     "columns":[
                     {data: 'acciones',orderable: false, searchable: false},
                     {data: 'acc_id'},
                     {data: 'opc_opcion'},
                     {data: 'rls_rol'},
                     {data: 'acc_registrado'},
                     {data: 'acc_modificado'},
                     {data: 'usr_usuario'},
                     {data: 'acc_estado'}
                     ],
                     "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                });
                  function MostrarAcceso(btn){
                     var route = "/Acceso/"+btn.value+"/edit";
                     $.get(route, function(res){
                        $("#accid").val(res.acc_id);
                        $("#opcopcion").val(res.opc_opcion);
                        $("#rol").val(res.rls_rol);
                        $("#accregistrado").val(res.acc_registrado);
                        $("#accmodificado").val(res.acc_modificado);
                        $("#usrusuario").val(res.usr_usuario);
                        $("#accestado").val(res.acc_estado);
                    });
                 }

                 $("#registro").click(function(){
                     var route="Acceso";
                     var token =$("#token").val();
                     $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'opc_opcion':$("#opcopcion").val(),
                            'rls_rol':$("#rol").val(),
                            'acc_registrado':$("#accregistrado").val(),
                            'acc_modificado':$("accmodificado").val(),
                            'usr_usuario':$("#usrusuario").val(),
                            'acc_estado':$("#accestado").val()
                        },
                        success: function(data){
                           $("#myCreate").modal('toggle');
                           swal("Acceso!", "registro correcto","success");
                           $('#lts-acceso').DataTable().ajax.reload();
                       },
                       error: function(result)
                       {
                        swal("Opss..!", "Error al registrar el dato", "error");
                    }
                });
                 });

                 $("#actualizar").click(function(){
                    var value =$("#id").val();
                    var route="Acceso/"+value+"";
                    var token =$("#token").val();
                    $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'PUT',
                        dataType: 'json',
                        data: {
                          'opc_opcion':$("#opcopcion").val(),
                          'rls_rol':$("#rol").val(),
                          'acc_registrado':$("#accregistrado").val(),
                          'acc_modificado':$("accmodificado").val(),
                          'usr_usuario':$("#usrusuario").val(),
                          'acc_estado':$("#accestado").val()
                      },
                      success: function(data){
                        $("#myUpdate").modal('toggle');
                        swal("Acceso!", "edicion exitosa!", "success");
                        $('#lts-acceso').DataTable().ajax.reload();

                    },  error: function(result) {
                      console.log(result);
                      swal("Opss..!", "Edicion rechazada", "error")
                  }
              });
                });

                 function Eliminar(btn){
                    var route="Acceso/"+btn.value+"";
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
                            $('#lts-acceso').DataTable().ajax.reload();
                            swal("Acceso!", "El registro fue dado de baja!", "success");
                        },
                        error: function(result) {
                            swal("Opss..!", "error al procesar la solicitud", "error")
                        }
                    });
                 });
                }
            </script>
            <script type="text/javascript">
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
            </script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#acceso').bootstrapValidator({
                        message: 'Valor errado',
                        feedbackIcons: {
                            valid: 'glyphicon glyphicon-ok',
                            invalid: 'glyphicon glyphicon-remove',
                            validating: 'glyphicon glyphicon-refresh'
                        },
                        fields: {
                            opc_opcion: {
                                message: 'Registro no valido',
                                validators: {
                                    notEmpty: {
                                        message: 'Dato requerido'
                                    },
                                    stringLength: {
                                        min: 4,
                                        max: 100,
                                        message: 'Campo mayor a 4 caracteres y un maximo de 50'
                                    },
                                    regexp: {
                                        regexp: /(\s*[a-zA-Z]+$)/,
                                        message: 'Solo caracteres alfabeticos'
                                    }
                                }
                            },
                        }
                    });
                });
            </script>
            @endpush
