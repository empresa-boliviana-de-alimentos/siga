@extends('backend.template.app')
@include('backend.administracion.producto_terminado.datos.transportista.partials.modalCreateVehiculo')
@include('backend.administracion.producto_terminado.datos.transportista.partials.modalUpdateVehiculo')
@include('backend.administracion.producto_terminado.datos.transportista.partials.modalCreateConductor')
@include('backend.administracion.producto_terminado.datos.transportista.partials.modalUpdateConductor')

<style type="text/css" media="screen">
        .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td{
        padding: 1px;
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
<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">PRODUCTO TERMINADO </h3>
<span class="pull-right">
    <!-- Tabs -->
    <ul class="nav panel-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-car"></i>  TRANSPORTE</a></li>
        <li><a href="#tab2" data-toggle="tab"><i class="fa fa-user"></i>  CONDUCTOR</a></li>
    </ul>
</span>
</div>
<div class="panel-body">
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myCreateVehiculos">REGISTRAR</button>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover table-striped table-condensed cf" id = "lts-vehiculos">
                                <thead class="cf">
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Placa</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Tipo</th>
                                        <th>Roseta Inspeccion</th>
                                        <th>Restriccion Transito</th>
                                        <th>Restriccion Municipio </th>
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
        <div class="tab-pane" id="tab2">
             <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                                <div class="box-header with-border">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myCreateConductor">REGISTRAR</button>
                                </div>
                                <div class="box-body">
                                    <div id="no-more-tables">
                                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-persona">
                                            <thead class="cf">
                                                <tr>
                                                    <th>
                                                        Acciones
                                                    </th>
                                                    <th>
                                                        Nombre Completo
                                                    </th>
                                                    <th>
                                                        C.I.
                                                    </th>
                                                    <th>
                                                        Estado Civil
                                                    </th>
                                                    <th>
                                                        Direccion
                                                    </th>
                                                    <th>
                                                        Telefono
                                                    </th>
                                                    <th>
                                                        Celular
                                                    </th>
                                                    <th>
                                                        Correo
                                                    </th>
                                                    <th>
                                                        Fecha Nac.
                                                    </th>
                                                    <th>
                                                        Licencia de Conducir
                                                    </th>
                                                     <th>
                                                        Categoria
                                                    </th>
                                                    <th>
                                                        Vehiculo Asignado placa
                                                    </th>
                                                    <th>
                                                        Chasis
                                                    </th>
                                                    <th>
                                                        Estado
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
</div>

@endsection

@push('scripts')
<script>
    $('#lts-vehiculos').DataTable( {
        "processing": true,
        "serverSide": true,
        "destroy":true,
        "ajax": "/Vehiculos/create",
        "columns":[
            {data: 'acciones',orderable: false, searchable: false},
            {data: 'veh_placa'},
            {data: 'veh_marca'},
            {data: 'veh_modelo'},
            {data: 'veh_tipo'},
            {data: 'veh_roseta_inspeccion'},
            {data: 'veh_restriccion_transito'},
            {data: 'veh_restriccion_municipio'},
            {data: 'veh_usr_id'},
            {data: 'veh_estado'},
        ],
        "language": {
            "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });

    function MostrarVehiculos(btn){
       var route = "/Vehiculos/"+ btn.value + "/edit";
        $.get(route, function(res){
            $("#id1").val(res.veh_id);
            $("#u_placa1").val(res.veh_placa);
            $("#u_mar1").val(res.veh_marca);
            $("#u_mod1").val(res.veh_modelo);
            $("#u_tip1").val(res.veh_tipo);
            $("#u_chas1").val(res.veh_chasis);
            $("#u_ros_soat1").val(res.veh_roseta_soat);
            $("#u_ros_ins1").val(res.veh_roseta_inspeccion);
            $("#u_res_tra1").val(res.veh_restriccion_transito);
            $("#u_res_gam1").val(res.veh_restriccion_municipio);
        });
    }

    function Limpiar()
    {
        $("#u_placa").val("");
        $("#u_marca").val("");
        $("#u_modelo").val("");
        $("#u_tipo").val("");
        $("#u_chasis").val("");
        $("#u_roseta_soat").val("");
        $("#u_roseta_inspeccion").val("");
        $("#u_restriccion_transito").val("");
        $("#u_restriccion_gamlp").val("");
        $("#vehiculo").data('bootstrapValidator').resetForm();
        $("#vehiculo1").data('bootstrapValidator').resetForm();
     }

    $("#registro").click(function(){
        var route="Vehiculos";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {
                'veh_placa':$("#u_placa").val(),
                'veh_marca':$("#u_marca").val(),
                'veh_modelo':$("#u_modelo").val(),
                'veh_tipo':$("#u_tipo").val(),
                'veh_chasis':$("#u_chasis").val(),
                'veh_roseta_soat':$("#u_roseta_soat").val(),
                'veh_roseta_inspeccion':$("#u_roseta_inspeccion").val(),
                'veh_restriccion_transito':$("#u_restriccion_transito").val(),
                'veh_restriccion_gamlp':$("#u_restriccion_gamlp").val()
               },
                success: function(data){
                    $("#myCreateVehiculos").modal('toggle');$("#vehiculo").data('bootstrapValidator').resetForm();
                    swal("Vehiculo!", "Fue registrado correctamente!", "success");
                    $('#lts-vehiculos').DataTable().ajax.reload();
                },
                error: function(result) {
                        swal("Opss..!", "Sucedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });

   $("#actualizar").click(function(){
        var value =$("#id1").val();
        var route="/Vehiculos/"+value+"";
        var token =$("#token").val();
            $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {
               'veh_placa':$("#u_placa1").val(),
               'veh_marca':$("#u_mar1").val(),
               'veh_modelo':$("#u_mod1").val(),
               'veh_tipo':$("#u_tip1").val(),
               'veh_chasis':$("#u_chas1").val(),
               'veh_roseta_soat':$("#u_ros_soat1").val(),
               'veh_roseta_inspeccion':$("#u_ros_ins1").val(),
               'veh_restriccion_transito':$("#u_res_tra1").val(),
               'veh_restriccion_municipio':$("#u_res_gam1").val()
           },
            success: function(data){
                $("#myUpdateVehiculos").modal('toggle');$("#vehiculo1").data('bootstrapValidator').resetForm();
                swal("Vehiculo!", "Fue actualizado correctamente!", "success");
                $('#lts-vehiculos').DataTable().ajax.reload();


            },  error: function(result) {
                  console.log(result);
                 swal("Opss..!", "Vehiculo no se puedo actualizar intente de nuevo!", "error")
            }
        });
    });

    function Eliminar(btn){
        var route="/Vehiculos/"+btn.value+"";
        var token =$("#token").val();
            swal({   title: "Esta seguro de eliminar El Vehiculo?",
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
                    $('#lts-vehiculos').DataTable().ajax.reload();
                    swal("Vehiculo!", "Fue eliminado correctamente!", "success");
                },
                    error: function(result) {
                        swal("Opss..!", "Vehiculo tiene registros en otras tablas!", "error")
                }
            });
        });
    }

</script>

<script type="text/javascript">
    $(document).ready(function() {
                $('#vehiculo').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        veh_placa: {
                            validators: {
                                notEmpty: {
                                    message: 'Número de placa es requerido'
                                },
                                stringLength: {
                                    min: 4,
                                    max: 7,
                                    message: 'El modelo requiere mas de 4 caracteres y un limite de 7'
                                },
                            }
                        },
                         veh_marca: {
                            message: 'La marca del vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'La marca de vehiculo es obligatorio'
                                },
                                stringLength: {
                                    min: 4,
                                    max: 10,
                                    message: 'El modelo requiere mas de 4 caracteres y un limite de 10'
                                },
                            }
                        },
                        veh_modelo: {
                            validators: {
                                notEmpty:{
                                    message: 'Año del modelo es requerido'
                                },
                                  stringLength: {
                                    min: 2,
                                    max: 4,
                                    message: 'El modelo requiere mas de 2 caracteres y un limite de 4'
                                },
                                regexp: {
                                    regexp: /^[0-9]+$/,
                                    message: 'El modelo tiene que ser numerico'
                                }
                            }
                        },
                        veh_tipo: {
                            message: 'El tipo de vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'El tipo de vehiculo es obligatorio'
                                },
                                stringLength: {
                                    min: 4,
                                    max: 15,
                                    message: 'El tipo requiere mas de 4 caracteres y un limite de 15'
                                },

                            }
                        },
                        veh_chasis: {
                            message: 'El chasis de vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'El chasis de vehiculo es obligatorio'
                                },
                                 stringLength: {
                                    min: 4,
                                    max: 40,
                                    message: 'El tipo requiere mas de 4 caracteres y un limite de 40'
                                },
                            }
                        },
                        veh_roseta_soat: {
                            message: ' Año de Soat del vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'Soat del véhiculo es obligatorio'
                                },
                                regexp: {
                                    regexp: /^[0-9]+$/,
                                    message: 'Soat tiene que ser numerico'
                                }
                            }
                        },
                        veh_roseta_inspeccion: {
                            message: 'La roseta de inspección del vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'La roseta de inspección del  véhiculo es obligatorio'
                                },
                                stringLength: {
                                    min: 1,
                                    max: 2,
                                    message: 'introdusca un SI ó No'
                                },
                            }
                        },
                        veh_restriccion_transito: {
                            message: 'Día de restriccion del vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'Día de restricción del véhiculo es obligatorio'
                                },
                                stringLength: {
                                    min: 3,
                                    max: 8,
                                    message: 'Día de restricción requiere mas de 4 caracteres y un limite de 7'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z]+$/,
                                    message: 'El dia de restriccion  solo puede ser alfabetico'
                                }
                            }
                        },
                        veh_restriccion_gamlp: {
                            message: 'Restriccion del Municipio del vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'Restriccion del Municipio del véhiculo es obligatorio'
                                },
                            }
                        },
                    }
                });
            });
</script>


<script type="text/javascript">
    $(document).ready(function() {
                $('#vehiculo1').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {

                        veh_placa: {
                            validators: {
                                notEmpty: {
                                    message: 'Número de placa es requerido'
                                },
                                stringLength: {
                                    min: 4,
                                    max: 7,
                                    message: 'La placa requiere mas de 4 caracteres y un limite de 7'
                                },
                            }
                        },
                         veh_marca: {
                            message: 'La marca del vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'La marca de vehiculo es obligatorio'
                                },
                                stringLength: {
                                    min: 4,
                                    max: 10,
                                    message: 'La marca requiere mas de 4 caracteres y un limite de 10'
                                },

                            }
                        },
                        veh_modelo: {
                            validators: {
                                notEmpty:{
                                    message: 'El modelo es requerido'
                                },
                                  stringLength: {
                                    min: 4,
                                    max: 10,
                                    message: 'El modelo requiere mas de 4 caracteres y un limite de 10'
                                },
                                 regexp: {
                                    regexp: /^[0-9]+$/,
                                    message: 'El modelo tiene que ser númerico'
                                }
                            }
                        },
                        veh_tipo: {
                            message: 'El tipo de vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'El tipo de vehiculo es obligatorio'
                                },
                                stringLength: {
                                    min: 4,
                                    max: 15,
                                    message: 'El tipo requiere mas de 4 caracteres y un limite de 15'
                                },
                            }
                        },
                        veh_chasis: {
                            message: 'El chasis de vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'El chasis de vehiculo es obligatorio'
                                },
                                stringLength: {
                                    min: 4,
                                    max: 40,
                                    message: 'El tipo requiere mas de 4 caracteres y un limite de 40'
                                },
                            }
                        },
                        veh_roseta_soat: {
                            message: 'Año de Soat del vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'Soat del véhiculo es obligatorio'
                                },
                                regexp: {
                                    regexp: /^[0-9]+$/,
                                    message: 'Soat tiene que ser númerico'
                                }
                            }
                        },
                        veh_roseta_inspeccion: {
                            message: 'La roseta de inspección del vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'La roseta de inspección del  véhiculo es obligatorio'
                                },
                                 stringLength: {
                                    min: 1,
                                    max: 2,
                                    message: 'introdusca un SI ó NO'
                                },
                            }
                        },
                        veh_restriccion_transito: {
                            message: 'Día de restriccion del vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'Día de restricción del véhiculo es obligatorio'
                                },
                                stringLength: {
                                    min: 3,
                                    max: 8,
                                    message: 'Día de restricción requiere mas de 4 caracteres y un limite de 7'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z]+$/,
                                    message: 'El dia de restriccion  solo puede ser alfabetico'
                                },
                            }
                        },
                        veh_restriccion_gamlp: {
                            message: 'Restriccion del Municipio del vehiculo es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'Restriccion del Municipio del véhiculo es obligatorio'
                                },
                            }
                        },
                    }
                });
            });

    $('#lts-persona').DataTable( {
         "responsive": true,
         "processing": true,
            "serverSide": true,
            "ajax": "Conductor/create",
            "columns":[
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'nombreCompleto'},
                {data: 'pcd_ci'},
                {data: 'pcd_id_estado_civil'},
                {data: 'pcd_direccion'},
                {data: 'pcd_telefono'},
                {data: 'pcd_celular'},
                {data: 'pcd_correo'},
                {data: 'pcd_fec_nacimiento'},
                {data: 'pcd_nro_licencia'},
                {data: 'pcd_categoria'},
                {data: 'veh_placa'},
                {data: 'veh_chasis'},
                {data: 'pcd_estado'},
        ],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });

     function MostrarConductor(btn){
        var route = "Conductor/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#id1").val(res.pcd_id);
            $("#nombres1").val(res.pcd_nombres);
            $("#paterno1").val(res.pcd_paterno);
            $("#materno1").val(res.pcd_materno);
            $("#ci1").val(res.pcd_ci);
            $("#fec_nacimiento1").val(res.pcd_fec_nacimiento);
            $("#direccion1").val(res.pcd_direccion);
            $("#celular1").val(res.pcd_celular);
            $("#telefono1").val(res.pcd_telefono);
            $("#correo1").val(res.pcd_correo);
            $("#estadocivil1").val(res.pcd_id_estado_civil);
            $("#licencia1").val(res.pcd_nro_licencia);
            $("#categoria1").val(res.pcd_categoria);
            $("#vehiculo1").val(res.pcd_veh_id);
        });
    }

    $("#registroConductor").click(function(){
            var route="Conductor";
             var token =$("#token").val();
            //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
            $.ajax({
                url: route,
                 headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {'pcd_ci':$("#ci").val(),'pcd_nombres':$("#nombres").val(),'pcd_paterno':$("#paterno").val(),'pcd_materno':$("#materno").val(),'pcd_direccion':$("#direccion").val(),'pcd_telefono':$('#telefono').val(),'pcd_celular':$('#celular').val(),'pcd_correo':$('#correo').val(),'pcd_id_estado_civil':$('#estadocivil').val(),'pcd_fec_nacimiento':$('#fec_nacimiento').val(),'pcd_categoria':$('#categoria').val(),'pcd_nro_licencia':$('#pcd_licencia').val(),'pcd_veh_id':$('#pcd_veh_id').val()},
                    success: function(data){
                        $("#myCreateConductor").modal('toggle');
                        swal("El conductor!", "Se registrado correctamente!", "success");
                        $('#lts-persona').DataTable().ajax.reload();
                    },
                    error: function(result) {
                            swal("Opss..!", "Sucedio un problema al registrar inserte bien los datos!", "error");
                    }
            });
    });
    $("#actualizarConductor").click(function(){
        var value =$("#id1").val();
        var route="Conductor/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {'pcd_ci':$("#ci1").val(),'pcd_nombres':$("#nombres1").val(),'pcd_paterno':$("#paterno1").val(),'pcd_materno':$("#materno1").val(),'pcd_direccion':$("#direccion1").val(),'pcd_telefono1':$('#telefono1').val(),'pcd_celular':$('#celular1').val(),'pcd_correo':$('#correo1').val(),'pcd_id_estado_civil':$('#estadocivil1').val(),'pcd_fec_nacimiento':$('#fec_nacimiento1').val(),'pcd_nro_licencia':$('#licencia1').val(),'pcd_categoria':$('#categoria1').val(),'pcd_veh_id':$('#vehiculo1').val()},
            success: function(data){
                $("#myUpdateConductor").modal('toggle');
                swal("El conductor!", "Fue actualizado correctamente!", "success");
                $('#lts-persona').DataTable().ajax.reload();
            },  error: function(result) {
                  console.log(result);
                 swal("Opss..!", "El conductor no se puedo actualizar intente de nuevo!", "error")
            }
        });
    });

    function EliminarConductor(btn){
        var route="Conductor/"+btn.value+"";
        var token =$("#token").val();
        swal({   title: "Esta seguro de eliminar al conductor?",
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
                        $('#lts-persona').DataTable().ajax.reload();
                        swal("el conductor!", "Fue eliminado correctamente!", "success");
                    },
                        error: function(result) {
                            swal("Opss..!", "El conductor tiene registros en otras tablas!", "error")
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
                $('#conductor').bootstrapValidator({
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
                        pcd_licencia: {
                            message: 'El numero de licencia es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'la licencia es obligatorio'
                                },
                                regexp: {
                                    regexp: /^[0-9]+$/,
                                    message: 'La licencia tiene que ser númerico'
                                }
                            }
                        },
                        pcd_categoria: {
                            message: 'La categoria es requerida',
                            validators: {
                                notEmpty: {
                                    message: 'La categoria es obligatoria'
                                },
                                 stringLength: {
                                    min: 1,
                                    max: 1,
                                    message: 'introdusca categoria A,B O C'
                                },
                            }
                        },

                    }
                });
            });
</script>

</script>
@endpush


