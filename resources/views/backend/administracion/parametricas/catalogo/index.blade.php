@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.parametricas.catalogo.partials.modalCreate')
@include('backend.administracion.parametricas.catalogo.partials.modalUpdate')

<div class="row">
   <div class="col-md-12">
      <section class="content-header">
       <div class="header_title">
         <h3>
            Parametros
            <small>
                <button class="btn btn-warning fa fa-plus-square pull-right" data-target="#myCreateCatalogo" data-toggle="modal">&nbsp;Nuevo</button>
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
                <table class="table table-hover table-striped" id="lts-catalogo">
                    <thead class="cf">
                        <tr>
                            <th>Acciones</th>
                            <th>Descripción</th>
                            <th>Código</th>
                            <th>Clasificador</th>
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
</section>

@endsection
@push('scripts')
<script>

    $('#lts-catalogo').DataTable({
      
         "processing": true,
            "serverSide": true,
            "ajax": "/parametro/create",
            "columns":[
                        {data: 'acciones', orderable: false, searchable: false},
                        {data: 'ctp_descripcion'},
                        {data: 'ctp_codigo'},
                        {data: 'ctp_clasificador'},
                        {data: 'ctp_estado'},
            ],        
        "language": {
            "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });

    function MostrarCatalogo(btn){
    var route = "/parametro/"+ btn.value + "/edit";
    $.get(route, function(res){
        $("#u_id").val(res.ctp_id);
        $("#u_ctp_descripcion").val(res.ctp_descripcion);
        $("#u_ctp_codigo").val(res.ctp_codigo); 
        $("#u_ctp_clasificador").val(res.ctp_clasificador);       
    });
    }

    function Limpiar(){
        $("#r_ctp_descripcion").val("");$("#r_ctp_codigo").val("");$("#r_ctp_clasificador").val("");
        $('#catalogo').data('bootstrapValidator').resetForm();
    }
    function LimpiarUP(){
        $('#catalogo2').data('bootstrapValidator').resetForm();
    }

    $("#registro").click(function(){
        var route="../parametro";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'ctp_descripcion':$("#r_ctp_descripcion").val(),'ctp_codigo':$("#r_ctp_codigo").val(),'ctp_clasificador':$("#r_ctp_clasificador").val()},
                success: function(data){
                    $("#myCreateCatalogo").modal('toggle');Limpiar();
                    swal("El Parametro!", "Fue registrado correctamente!", "success");
                    $('#lts-catalogo').DataTable().ajax.reload();
                },
                error: function(result) {
                        swal("Opss..!", "Sucedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });

    $("#actualizar").click(function(){
        var value =$("#u_id").val();
        var route="/parametro/"+value+"";
        var token =$("#token").val();
            $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {'ctp_id':$("#u_id").val(),'ctp_descripcion':$("#u_ctp_descripcion").val(),'ctp_codigo':$("#u_ctp_codigo").val(),'ctp_clasificador':$("#u_ctp_clasificador").val()},
            success: function(data){
                $("#myUpdateCatalogo").modal('toggle');LimpiarUP();
                swal("El Parametro!", "Fue actualizado correctamente!", "success");
                $('#lts-catalogo').DataTable().ajax.reload();

            },  error: function(result) {
                  console.log(result);
                 swal("Error!", "El Parametro no se puedo actualizar intente de nuevo!", "error")
            }
        });
    });

    function Eliminar(btn){
    var route="/parametro/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el Parametro?", 
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
                    $('#lts-catalogo').DataTable().ajax.reload();
                    swal("El Parametro!", "Fue eliminado correctamente!", "success");
                },
                    error: function(result) {
                        swal("Opss..!", "El Parametro tiene registros en otras tablas!", "error")
                }
            });
    });
    }

</script>
<script type="text/javascript">
    $(document).ready(function() {
                $('#catalogo').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        ctp_descripcion: {
                            message: 'La descripción no es valida',
                            validators: {
                                notEmpty: {
                                    message: 'Ingrese una descripción válida'
                                },
                                regexp: {
                                    regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/\s/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                                    message: 'No se aceptan caracteres especiales'
                                },
                                stringLength: {
                                    min: 3,
                                    max: 40,
                                    message: 'Se requiere mas de 3 caracteres y un limite de 40'
                                }
                            }
                        },
                        ctp_codigo: {
                            row: '.form-group',
                            validators: {
                                notEmpty: {
                                    message: 'Ingrese un código válido '

                                },
                              regexp: {
                                   regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                                    message: 'No se aceptan caracteres especiales'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 10,
                                    message: 'Se requiere mas de 2 caracteres y un limite de 10'
                                }
                            }
                        },
                        ctp_clasificador: {
                            row: '.form-group',
                            validators: {
                                notEmpty: {
                                    message: 'Ingrese un clasificador válido'
                                },
                                regexp: {
                                    regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                                    message: 'No se aceptan caracteres especiales'
                                },
                                stringLength: {
                                    min: 1,
                                    max: 15,
                                    message: 'Se requiere mas de 1 caracter y un limite de 15'
                                }
                            }
                        },
                    }
                });
                $('#catalogo2').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        ctp_descripcion: {
                            message: 'La descripción no es valida',
                            validators: {
                                notEmpty: {
                                    message: 'Ingrese una descripción válida'
                                },
                                regexp: {
                                    regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/\s/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                                    message: 'No se aceptan caracteres especiales'
                                },
                                stringLength: {
                                    min: 3,
                                    max: 40,
                                    message: 'Se requiere mas de 3 caracteres y un limite de 40'
                                }
                            }
                        },
                        ctp_codigo: {
                            row: '.form-group',
                            validators: {
                                notEmpty: {
                                    message: 'Ingrese un código válido '

                                },
                              regexp: {
                                   regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                                    message: 'No se aceptan caracteres especiales'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 10,
                                    message: 'Se requiere mas de 2 caracteres y un limite de 10'
                                }
                            }
                        },
                        ctp_clasificador: {
                            row: '.form-group',
                            validators: {
                                notEmpty: {
                                    message: 'Ingrese un clasificador válido'
                                },
                                regexp: {
                                    regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                                    message: 'No se aceptan caracteres especiales'
                                },
                                stringLength: {
                                    min: 1,
                                    max: 15,
                                    message: 'Se requiere mas de 1 caracter y un limite de 15'
                                }
                            }
                        },
                    }
                });
            });
</script>
@endpush

