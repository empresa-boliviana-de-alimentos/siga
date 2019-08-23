@extends('admin.app')
@section('main-content')

@include('acopio.acopio_lacteos.proveedor.partials.modalCreate')
@include('acopio.acopio_lacteos.proveedor.partials.modalUpdate')

<div align="right" class="page-header">
    <td>
        
        <center> <h2><font face="Showcard Gothic"> Proveedores Lacteos </font> </h2></center>
       <!-- <button class="btn btn-warning" data-target="#myCreate" data-toggle="modal" style="background:#7ACCCE" type="button">-->
         <button class="button button-glow button-rounded button-success" data-target="#myCreate" data-toggle="modal"  type="button">
            Registrar Nuevo Proveedor
        </button>
    </td>
</div>
<!--<div id="no-more-tables">-->
<!--<table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-proveedor">-->
<div class="panel panel-danger table-edit">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span>
                <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    LISTADO DE PROVEEDORES REGISTRADOS
            </span>
        </h3>
    </div>
    <div class="panel-body">
        <div id="sample_editable_1_wrapper" class="">
            <table class="table table-striped table-bordered table-hover dataTable no-footer" id="lts-proveedor" role="grid"> 
                <thead class="table_head">
                    <tr>
                   
                        <th class="sorting">Opciones</th>
                        <th class="sorting">Nombres</th>
                        <th class="sorting">CI</th>
                        <th class="sorting">Telefono</th>
                        <th class="sorting">Lugar</th>
                        <th class="sorting">Tipo</th>
                                              
                    </tr>
               </thead>
           </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#lts-proveedor').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/ProveedorL/create",
            "columns":[
                {data: 'acciones', orderable: false, searchable: false},
                {data: 'nombreCompleto'},
                {data: 'prov_ci'},
                {data: 'prov_tel'},
                {data: 'prov_lugar'},
                {data: 'prov_id_tipo'}, 
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });

    $("#registro").click(function(){
        var route="/ProveedorL";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'pro_nombres':$("#n_nombres").val(),
                   'pro_ap':$("#n_ap").val(),
                   'pro_am':$("#n_am").val(),
                   'pro_ci':$('#n_ci').val(),
                   'n_exp':$('#n_exp').val(),
                   'imgProveedorL':$('#imgProveedorL').val(),
                   'pro_tel':$('#n_tel').val(),
                   'n_dep':$('#n_dep').val(),
                   'pro_mun':$('#n_mun').val(),
                   'pro_com':$('#n_com').val(),
                   'n_lugpro':$('#n_lugpro').val(),
                   'n_tipo':$('#n_tipo').val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#myCreate").modal('toggle');
                    swal("El Proveedor!", "Se registrado correctamente!", "success");
                    $('#lts-proveedor').DataTable().ajax.reload();
                    
                },
                error: function(result) {
                        swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });
  
    /*$("#actualizar").click(function(){
        var value =$("#id1").val();
        var route="/Proveedor/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: { 'pro_nombres':$("#e_nombres").val(),
                    'pro_ap':$("#e_ap").val(),
                    'pro_am':$("#e_am").val(),
                    'pro_ci':$('#e_ci').val(),
                    'e_exp':$('#e_exp').val(),
                    'pro_tel':$('#e_tel').val(),
                    'e_dep':$('#e_dep').val(),
                    'pro_mun':$('#e_mun').val(),
                    'pro_com':$('#e_com').val(),
                    'n_lugpro':$('#e_lugpro').val(),
                    'n_tipo':$('#e_tipo').val()},
            success: function(data){
                $("#myUpdate").modal('toggle');
                swal("El Proveedor!", "Fue actualizado correctamente!", "success");
                $('#lts-proveedor').DataTable().ajax.reload();
            },  error: function(result) {
                // console.log(result);
                 swal("Opss..!", "El PRoveedor no se puedo actualizar intente de nuevo!", "error")
            }
        });
    });*/


    $("#actualizar").click(function(){
        var value =$("#id1").val();
        var route="/ProveedorL/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: { 'prov_nombre'       :$("#e_nombres").val(),
                    'prov_ap'           :$("#e_ap").val(),
                    'prov_am'           :$("#e_am").val(),
                    'prov_ci'           :$('#e_ci').val(),
                    'prov_exp'          :$('#e_exp').val(),
                    'prov_tel'          :$('#e_tel').val(),
                    'prov_departamento' :$('#e_dep').val(),
                    'prov_id_municipio' :$('#e_mun').val(),
                    'prov_id_comunidad' :$('#e_com').val(),
                    'prov_lugar'        :$('#e_lugpro').val(),
                    'prov_id_tipo'      :$('#e_tipo').val()},
            success: function(data){
                $("#myUpdate").modal('toggle');
                swal("El Proveedor!", "Fue actualizado correctamente!", "success");
                $('#lts-proveedor').DataTable().ajax.reload();
            },  error: function(result) {
                // console.log(result);
                 swal("Opss..!", "El PRoveedor no se puedo actualizar intente de nuevo!", "error")
            }
        });
    });




    function MostrarProveedor(btn){
        var route = "/ProveedorL/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#id1").val(res.prov_id);
            $("#e_nombres").val(res.prov_nombre);
            $("#e_ap").val(res.prov_ap);
            $("#e_am").val(res.prov_am); 
            $("#e_ci").val(res.prov_ci);
            $("#e_exp").val(res.prov_exp); 
            $("#e_tel").val(res.prov_tel);
            $("#e_dep").val(res.prov_departamento);
            $("#e_mun").val(res.prov_id_municipio);
            $("#e_com").val(res.prov_id_comunidad);
            $("#e_lugpro").val(res.prov_lugar);
            $("#e_tipo").val(res.prov_id_tipo);
          


        });
    }

     
  function EliminarPRov(btn){
    var route="/ProveedorL/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar al proveedor?", 
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
                    $('#lts-proveedor').DataTable().ajax.reload();
                    swal("Proveedor!", "Fue eliminado correctamente!", "success");
                },
                    error: function(result) {
                        swal("Opss..!", "El proveedor tiene registros en otras tablas!", "error")
                }
            });
    });
     }
</script>
<!--<script type="text/javascript">
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
</script>-->
<!--<script type="text/javascript">
    $(document).ready(function() {
                $('#persona').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        prs_nombres: {
                            message: 'La persona no es valida',
                            validators: {
                                notEmpty: {
                                    message: 'La persona es requerida'
                                },
                                stringLength: {
                                    min: 4,
                                    max: 20,
                                      message: 'La persona requiere mas de 4 letras y un limite de 20'
                                },
                                regexp: {
                                    regexp: /(\s*[a-zA-Z]+$)/,
                                    message: 'El nombre de la persona solo puede ser alfabetico'
                                }
                            }
                        },
                        prs_paterno: {
                            message: 'El apellido es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'Apellido paterno es obligatorio'
                                },
                                stringLength: {
                                    min: 4,
                                    max: 15,
                                    message: 'El apellido requiere mas de 4 caracteres y un limite de 15'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z]+$/,
                                    message: 'El apellido de la persona solo puede ser alfabetico'
                                }
                            }
                        },
                        prs_materno: {
                            message: 'El apellido es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'Apellido materno es obligatorio'
                                },
                                stringLength: {
                                    min: 4,
                                    max: 15,
                                    message: 'El apellido requiere mas de 4 caracteres y un limite de 15'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z]+$/,
                                    message: 'El apellido de la persona solo puede ser alfabetico'
                                }
                            }
                        },
                        prs_ci: {
                            validators: {
                                notEmpty: {
                                    message: 'Carnet de identidad es requerido'
                                }
                            }
                        },

                        prs_fec_nacimiento: {
                            validators: {
                                notEmpty: {
                                    message: 'Fecha de nacimiento es requerida'
                                },
                            }
                        },
                        prs_direccion: {
                            validators: {
                                notEmpty: {
                                    message: 'Direccion es requerida'
                                }
                            }
                        },
                        
                        prs_correo: {
                            validators: {
                         
                                emailAddress: {
                                    message: 'Entrada no es una dirección de correo electrónico válida'
                                }
                            }
                        },
                      
                    }
                });
            });
</script>-->
@endpush
