@extends('admin.app')
@section('main-content')

@include('acopio.acopio_lacteos.acopio.partials.modalCreate')
@include('acopio.acopio_lacteos.acopio.partials.modalCreateTot')
@include('acopio.acopio_lacteos.acopio.partials.modalListar')

<div align="right" class="page-header">
    <td>
        
        <center> <h2><font face="Showcard Gothic"> Acopios Lacteos Proveedores </font> </h2></center>
        <!--<a href="{{ url('regrecepleche') }}" class="button button-glow button-rounded button-warning">
            <h4 class="list-group-item-heading count"> REGISTRO NUEVO ACOPIO</h4>  
       </a>-->
        <a class="btn btn-primary fa fa-print pull-right" href="BoletaProvL" target="_blank" class="btn btn-primary fa fa-print">Generar Reporte Diariooooo</a>

       <button class="button button-glow button-rounded button-success" data-target="#myCreateRTOT" data-toggle="modal"  type="button" onClick="MostrarCantidades2();">
            Enviar Registros del dia
        </button>
    </td>
</div>
<div class="panel panel-danger table-edit">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span>
                <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    LISTADO DE ACOPIO REGISTRADOS
            </span>
        </h3>
    </div>
    <div class="panel-body">
        <div id="sample_editable_1_wrapper" class="">
            <table class="table table-striped table-bordered table-hover dataTable no-footer" id="lts-acopio" role="grid"> 
                <thead class="table_head">
                    <tr>
                        <th class="sorting">Opciones</th>
                        <th class="sorting">Nombre Completo</th>
                        <th class="sorting">CI</th>
                        <th class="sorting">Tel</th>
                        <th class="sorting">Lugar Acopio</th>
                                              
                    </tr>
               </thead>
           </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#lts-acopio').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/AcopioLacteos/create",
            "columns":[
                {data: 'acciones', orderable: false, searchable: false},
                {data: 'nombreCompleto'},
                {data: 'prov_ci'},
                {data: 'prov_tel'},
                {data: 'prov_departamento'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });

    $("#registro").click(function(){
        var route="/AcopioLacteos";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'cod_prov':$("#cod_prov").val(),
                   'aco_apr' :$("#aco_apr").val(),
                   'aco_hrs' :$("#aco_hrs").val(),
                   'aco_can' :$('#aco_can').val(),
                   'aco_obs' :$('#aco_obs').val(),
                   'aco_tenv':$('#aco_tenv').val(),
                   'aco_cond':$('#aco_cond').val(),
                   'aco_tem' :$('#aco_tem').val(),
                   'aco_sng' :$('#aco_sng').val(),
                   'aco_palc':$('#aco_palc').val(),
                   'aco_asp' :$('#aco_asp').val(),
                   'aco_col' :$('#aco_col').val(),
                   'aco_olo' :$('#aco_olo').val(),
                   'aco_sab' :$('#aco_sab').val()},
               success: function(data){
                    $("#myCreateRCA").modal('toggle');
                    swal("El Acopio!", "Se ha registrado correctamente!", "success");                    
                },
                error: function(result) {
                        swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });
//envio de datos a planta central
    $("#registroG").click(function(){
        var route="/AcopioLacteosGen";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'cant_prov1' :$("#cant_prov1").val(),
                   'cant_lech1' :$("#cant_lech1").val(),
                   'acog_obs'   :$("#acog_obs").val(),
                   'acog_tem'   :$('#acog_tem').val(),
                   'acog_sng'   :$('#acog_sng').val(),
                   'acog_palc'  :$('#acog_palc').val(),
                   'acog_asp'   :$('#acog_asp').val(),
                   'acog_col'   :$('#acog_col').val(),
                   'acog_olo'   :$('#acog_olo').val(),
                   'acog_sab'   :$('#acog_sab').val()},
               success: function(data){
                    $("#myCreateRTOT").modal('toggle');
                    swal("El Acopio General Dia!", "Se ha registrado correctamente El acopio General!", "success");                    
                },
                error: function(result) {
                        swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });




//FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN REGISTRO
    function MostrarProveedor2(btn){
        var route = "/AcopioLacteos/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#cod_prov").val(res.prov_id);
            $("#cod_nom").val(res.prov_nombre);
            $("#cod_ap").val(res.prov_ap);
            $("#cod_am").val(res.prov_am); 
          });
    }
    function MostrarProveedor(btn){
        var route = "/AcopioLacteos/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#cod_prov1").val(res.prov_id);
            $("#cod_nom1").val(res.prov_nombre);
            $("#cod_ap1").val(res.prov_ap);
            $("#cod_am1").val(res.prov_am); 
          });
    }
 //FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN LISTADO   
    function MostrarCantidades2(){
        var route = "/AcopioLacteosSum";
        $.get(route, function(res){ 
            $("#cant_prov1").val(res[0].xtotalprov);
            $("#cant_lech1").val(res[0].xtotal);
        });
    }

  function EliminarPRov(btn){
    var route="/Proveedor/"+btn.value+"";
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
