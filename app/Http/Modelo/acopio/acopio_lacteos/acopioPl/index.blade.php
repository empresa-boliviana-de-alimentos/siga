@extends('admin.app')
@section('main-content')

@include('acopio.acopio_lacteos.acopioPl.partials.modalCreate')
@include('acopio.acopio_lacteos.acopioPl.partials.modalListar')

<div align="right" class="page-header">
    <td>
        
        <center> <h2><font face="Showcard Gothic"> Acopios Lacteos Ingreso Plantas </font> </h2></center>
        <<a class="btn btn-primary fa fa-print pull-right" href="BoletaProvL" target="_blank" class="btn btn-primary fa fa-print">Generar Reporte Diariooooo</a> 
    </td>
</div>
<div class="panel panel-danger table-edit">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span>
                <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    LISTADO DE ACOPIO RECEPCIONISTAS
            </span>
        </h3>
    </div>
    <div class="panel-body">
        <div id="sample_editable_1_wrapper" class="">
            <table class="table table-striped table-bordered table-hover dataTable no-footer" id="lts-recep" role="grid"> 
                <thead class="table_head">
                    <tr>
                        <th class="sorting">Opciones</th>
                        <th class="sorting">Nombre Completo</th>
                        <th class="sorting">Fecha</th>
                        <th class="sorting">Cantidad Prov</th>
                        <th class="sorting">Cantidad Leche</th>
                                              
                    </tr>
               </thead>
           </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#lts-recep').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/AcopioLacteosPlantas/create",
            "columns":[
                {data: 'acciones', orderable: false, searchable: false},
                {data: 'detlac_nom_rec'},
                {data: 'detlac_fecha'},
                {data: 'detlac_cant_prov'},
                {data: 'detlac_cant'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });

    /*$("#registro").click(function(){
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
*/
 $("#registroaco").click(function(){
        var route="/AcopioLacteosPlantas";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'lab_rec'  :$("#lab_rec").val(),
                   'lab_apr'  :$("#lab_apr").val(),
                   'lab_cant' :$("#lab_cant").val(),
                   'lab_cond' :$('#lab_cond').val(),
                   'lab_tra'  :$('#lab_tra').val(),
                   'lab_enc'  :$('#lab_enc').val(),
                   'lab_obs'  :$('#lab_obs').val(),
                   'lab_tem'  :$('#lab_tem').val(),
                   'lab_aci'  :$('#lab_aci').val(),
                   'lab_ph'   :$('#lab_ph').val(),
                   'lab_sng'  :$('#lab_sng').val(),
                   'lab_den'  :$('#lab_den').val(),
                   'lab_mgra' :$('#lab_mgra').val(),
                   'lab_palc' :$('#lab_palc').val(),
                   'lab_pant' :$('#lab_pant').val(),
                   'lab_asp'  :$('#lab_asp').val(),
                   'lab_col'  :$('#lab_col').val(),
                   'lab_olo'  :$('#lab_olo').val(),
                   'lab_sab'  :$('#lab_sab').val()},
               success: function(data){
                    $("#myCreatePl").modal('toggle');
                    swal("El Acopio!", "Se ha registrado correctamente!", "success");                    
                },
                error: function(result) {
                        swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });



//FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN REGISTRO
    function Mostrardat(btn){
        var route = "/AcopioLacteosPlantas/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#lab_rec").val(res.detlac_nom_rec);
            $("#lab_cant").val(res.detlac_cant);
            $("#lab_id_rec").val(res.detlac_id_rec);
            //$("#cod_am").val(res.prov_am); 
          });
    }
 //FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN LISTADO   
  /*  function MostrarCantidades(){
        var route = "/AcopioLacteos/sumacantleche";
        $.get(route, function(res){
            $("#cod_usu").val(res.usr_id);
            $("#cod_nomb").val(res.usr_usuario);
           // $("#cod_ap1").val(res.prov_ap);
            //$("#cod_am1").val(res.prov_am); 
          });
    }*/
  
     

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
