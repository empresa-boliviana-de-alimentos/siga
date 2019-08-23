@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.admin.gbPersonas.partials.modalCreate')
@include('backend.administracion.admin.gbPersonas.partials.modalUpdate')
<div class="row">
   <div class="col-md-12">
      <section class="content-header">
       <div class="header_title">
         <h3>
            Persona
            <small>
                <button class="btn fa fa-plus-square pull-right btn-dark" onclick="LimpiarPersona();" style="background:#7ACCCE" data-target="#myCreate" data-toggle="modal">&nbsp;Nuevo</button>
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
    <div id="no-more-tables">
    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-persona" style="width:100%">
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
                    Area Produccion
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
                    Estado
                </th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $('#lts-persona').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "Persona/create",
            "columns":[
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'nombreCompleto'},
                {data: 'prs_ci'},
                {data: 'areaProd'},
                {data: 'prs_direccion'},
                {data: 'prs_telefono'},
                {data: 'prs_celular'},
                {data: 'prs_correo'},
                {data: 'prs_fec_nacimiento'},
                {data: 'prs_estado'},

        ],

        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });
    function MostrarPersona(btn){
        var route = "Persona/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#id1").val(res.prs_id);
            $("#nombres1").val(res.prs_nombres);
            $("#paterno1").val(res.prs_paterno);
            $("#materno1").val(res.prs_materno);
            $("#ci1").val(res.prs_ci);
            $("#fec_nacimiento1").val(res.prs_fec_nacimiento);
            $("#direccion1").val(res.prs_direccion);
            $("#direccionaux1").val(res.prs_direccion2);
            $("#telefono1").val(res.prs_telefono);
            $("#telefonoaux1").val(res.prs_telefono2);
            $("#celular1").val(res.prs_celular);
            $("#correo1").val(res.prs_correo);
            $("#estadocivil1").val(res.prs_id_estado_civil);
            

        });
    }
    $("#registro").click(function(){
        var route="Persona";
         var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
             headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'prs_ci':$("#ci").val(),'prs_nombres':$("#nombres").val(),'prs_paterno':$("#paterno").val(),'prs_materno':$("#materno").val(),'prs_direccion':$("#direccion").val(),'prs_direccion2':$("#direccionaux").val(),'prs_telefono':$('#telefono').val(),'prs_telefono2':$('#telefonoaux').val(),
                'prs_celular':$('#celular').val(),
                'prs_correo':$('#correo').val(),
                'prs_id_estado_civil':$('#estadocivil').val(),
                'prs_fec_nacimiento':$('#fec_nacimiento').val(),

                'prs_linea_trabajo':$('#lineatrabajo').val(),
                'prs_id_garantia':$('#tipg').val(),
                'prs_id_relacion':$('#rel').val(),
                //'prs_id_relacion':$('#rel1').val(),
                //'prs_id_produccion':$('#fec_nacimiento').val(),
                'prs_id_tipopersona':$('#rol').val(),
                'prs_id_zona':$('#zona').val(),
                'prs_nomparentesco':$('#nompar').val(),
                'prs_ciparentesco':$('#cipar').val(),
                'prs_exparentesco':$('#expar').val(),
                'prs_numbien':$('#nroreg').val(),
                'prs_valorbien':$('#valorbien').val()
            },
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#myCreate").modal('toggle');
                    swal("La Persona!", "Se registrado correctamente!", "success");
                    $('#lts-persona').DataTable().ajax.reload();

                },
                error: function(result) {
                        swal("Opss..!", "Sucedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });
    $("#actualizar").click(function(){
        var value =$("#id1").val();
        var route="Persona/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {'prs_ci':$("#ci1").val(),'prs_nombres':$("#nombres1").val(),'prs_paterno':$("#paterno1").val(),'prs_materno':$("#materno1").val(),'prs_direccion':$("#direccion1").val(),'prs_direccion2':$("#direccionaux1").val(),'prs_telefono':$('#telefono1').val(),'prs_telefono2':$('#telefonoaux1').val(),'prs_celular':$('#celular1').val(),'prs_correo':$('#correo1').val(),'prs_id_estado_civil':$('#estadocivil1').val(),'prs_fec_nacimiento':$('#fec_nacimiento1').val()},
            success: function(data){
                $("#myUpdate").modal('toggle');
                swal("La Persona!", "Fue actualizado correctamente!", "success");
                $('#lts-persona').DataTable().ajax.reload();


            },  error: function(result) {
                  console.log(result);
                 swal("Opss..!", "La Persona no se puedo actualizar intente de nuevo!", "error")
            }
        });
        });

    function Eliminar(btn){
    var route="Persona/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar la persona?",
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
                    swal("Persona!", "Fue eliminado correctamente!", "success");
                },
                    error: function(result) {
                        swal("Opss..!", "El La persona tiene registros en otras tablas!", "error")
                }
            });
    });
    }

    function LimpiarPersona()
    {
        $("#nombres").val("");
        $("#paterno").val("");
        $("#materno").val("");
	$("#ci").val("");      
        $("#direccion").val("");
        $("#direccionaux").val("");
        $("#telefono").val("");
        $("#telefonoaux").val(""); 
        $("#celular").val("");
        $("#correo").val("");         
        $("#fec_nacimiento").val("");
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
</script>
@endpush
