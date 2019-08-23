@extends('backend.template.app')
@section('main-content')

@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateProductor')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateDestino')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateRespRecep')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioMielMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">Acopio Producción de Miel</label></h4>
                </div>
                
                <div class="col-md-2">
              
                <!-- <a class="btn btn-success" role="button" data-toggle="modal" data-href="#acopioProductor" href="#acopioProductor">
            <i class="fa fa-plus">
            </i> REGISTRAR ACOPIO POR PRODUCTOR
        </a> -->
                <a class="btn btn-default"  onclick="LimpiarDatosProduccion();" data-href="#acopioProductor" href="#acopioProductor" data-toggle="modal" style="background: #616A6B"><h6 style="color: white;"><i class="fa fa-plus">
                    </i> &nbsp;NUEVO ACOPIO POR PRODUCTOR</h6>
                </a> 
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                    <div class="box-body">


<div id="no-more-tables">
    <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                  <label>
                                      BUSQUEDA POR NOMBRES:
                                  </label>
                                  <input type="text" name="buscarnom" id="buscarnom" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                  <label>
                                      BUSQUEDA POR AP PATERNO:
                                  </label>
                                  <input type="text" name="buscarpat" id="buscarpat" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                  <label>
                                      BUSQUEDA POR AP MATERNO:
                                  </label>
                                  <input type="text" name="buscarmat" id="buscarmat" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-acopio-produccion">
        <thead class="cf">
            <tr>
		        <th>
                    Cod Proveedor
                </th>
                <th>
                    Nro. Acopio
                </th>
                <th>
                    Nombre Proveedor
                </th>
                <th>
                    Ap. Paterno Prov.
                </th>
                <th>
                    Ap. Materno Prov.
                </th>
                <th>
                    Fecha/Hora Acopio
                </th>
                <th>
                    T. Marcos Cosechados
                </th>
                <th>
                    T. P. Neto
                </th>
                <th>
                    P. Bruto baldes filt.
                </th>
                <th>
                    P. Bruto baldes Centrif.
                </th>  
                <th>
                    P. Bruto baldes Impu.
                </th>              
                <th>
                    Rechazado/Aceptado
                </th>
      </tr>
        </thead>
    </table>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
    var tablaProdProp =  $('#lts-acopio-produccion').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/AcopioMielProduccion/create",
            "columns":[
                // {data: 'acciones',orderable: false, searchable: false},
                {data: 'aco_num_act'},
		        {data: 'aco_numaco'},
                {data: 'prov_nombre'},
                {data: 'prov_ap'},
                {data: 'prov_am'},
                {data: 'aco_fecha_acop'},
                {data: 'prom_total_marcos'}, 
                {data: 'prom_peso_neto'},
                {data: 'prom_peso_bruto_filt'},
                {data: 'prom_peso_bruto_centrif'},
                {data: 'prom_peso_bruto_imp'},
                {data: 'materiPrima'},
                
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });
    $('#buscarnom').on( 'keyup', function () {
    tablaProdProp
        .columns( 2 )
        .search( this.value )
        .draw();
    } );

    $('#buscarpat').on( 'keyup', function () {
    tablaProdProp
        .columns( 3 )
        .search( this.value )
        .draw();
    } );

    $('#buscarmat').on( 'keyup', function () {
    tablaProdProp
        .columns( 4 )
        .search( this.value )
        .draw();
    } );
    function MostrarAcopio(btn){
        var route = "/AcopioMiel/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#id1").val(res.id_acopio);
            // $("#id_acopio1").val(res.id_acopio);
            $("#id_proveedor1").val(res.id_proveedor);
            $("#id_lugar1").val(res.id_lugar);
            $("#centro_acopio1").val(res.centro_acopio); 
            $("#peso_neto1").val(res.peso_neto);
            $("#id_tipo1").val(res.id_tipo); 
            $("#nro_acopio1").val(res.nro_acopio);
            $("#id_unidad1").val(res.id_unidad);
            $("#cantidad1").val(res.cantidad);
            $("#costo1").val(res.costo);
            $("#total1").val(res.total);
            $("#imp_sup1").val(res.imp_sup);
            $("#total_imp_sup1").val(res.total_imp_sup);
            $("#fecha_acopio1").val(res.fecha_acopio);
            $("#fecha_resgistro1").val(res.fecha_resgistro);
            $("#observacion1").val(res.observacion);
            $("#boleta1").val(res.boleta);
            $("#nro_recibo1").val(res.nro_recibo);
            $("#id_zona1").val(res.id_zona);
            $("#id_tipo_acopio1").val(res.id_tipo_acopio);
            $("#id_prop_fq1").val(res.id_prop_fq);
            $("#id_prop_org1").val(res.id_prop_org);
            $("#id_resp_recepcion1").val(res.id_resp_recepcion);
            $("#acta_entrega1").val(res.acta_entrega);
            $("#pago1").val(res.pago);
            $("#id_destino1").val(res.id_destino);             
        });
    }
    $("#registro").click(function(){
        var items = [];
        $('.items_colums').each(function () {
            var index = $(this).attr('index');
            items.push({
                    codigo: $('#item_codigo_' + index).val(),
                    marca: $('#item_marca_'+index).val()
            });

        });
        items2 = JSON.stringify(items);
        console.log(items2);

        var route="/AcopioMielProduccion";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        console.log($('#spTotal').val());
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'id_proveedor':$("#id_proveedorProductor").val(),
                    'codigos_colmenas':items2,
                    'produccion_latitud':$('#coordslat').val(),
                    'produccion_longitud':$('#coordslng').val(),
                    'fecha_acopio':$('#fecha_acopio').val(),
                    'observacion':$('#observacion').val(),
                    'nro_marcos_centrifigados':$('#nro_marcocentrif').val(),
                    'peso_bruto_baldes_filtrados':$('#br_baldesfilt').val(),
                    'peso_bruto_baldes_centrifrifugados':$('#br_baldescentrif').val(),
                    'peso_bruto_baldes_impuresas':$('#br_baldesimpu').val(), 
                    'numero_baldes':$('#cant_baldes').val(), 
                    'peso_neto_produccion_propia':$('#peso_neto').val(), 
                    'acta_entrega':$('#acta_entrega').val(), 
                    'responsable_recepcion_produccion':$('#id_resp_recepcion').val(),                       
                    'destino_produccion':$('#id_destino').val(),
                    'acopio_materia_prima_produccion' :$('#aco_mapri').val(),
                    'aco_total_colm': $('#spTotal').html(),
		            'aco_numaco' : $('#nro_acopio').val()
                },
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#acopioProductor").modal('toggle');
                    // swal("El Acopio!", "Se registrado correctamente!", "success");
                    // $('#lts-acopio-produccion').DataTable().ajax.reload();
                    swal({ 
                            title: "Exito",
                            text: "Registrado con Exito",
                            type: "success" 
                        },function(){
                            location.reload();
                    });
                    
                },
                error: function(result) {
                    // swal("OpssApo..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                    console.log(result);
                    if (result.responseText === "Vacio") {
                        swal("Opss..!", "Error, Debe registrar al menos un codigo de colmena!", "error");
                    }else{
                        var errorCompleto='Tiene los siguientes errores: ';
                        $.each(result.responseJSON.errors,function(indice,valor){
                            errorCompleto = errorCompleto + valor+' ' ;                       
                        });
                        swal("Opss..., Hubo un error!",errorCompleto,"error");
                    }
                }
        });
    });
    $("#actualizar").click(function(){
        var value =$("#id1").val();
        var route="/AcopioMiel/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {'id_proveedor':$("#id_proveedor1").val(),
                    'id_lugar':$("#id_lugar1").val(),
                    'centro_acopio':$("#centro_acopio1").val(),
                    'peso_neto':$("#peso_neto1").val(),
                    'id_tipo':$("#id_tipo1").val(),
                    'nro_acopio':$("#nro_acopio1").val(),
                    'id_unidad':$("#id_unidad1").val(),
                    'cantidad':$('#cantidad1').val(),
                    'costo':$('#costo1').val(),
                    'total':$('#total1').val(),
                    'imp_sup':$('#imp_sup1').val(),
                    'total_imp_sup':$('#total_imp_sup1').val(),
                    'fecha_acopio':$('#fecha_acopio1').val(),
                    'observacion':$('#observacion1').val(),
                    'boleta':$('#boleta1').val(),
                    'nro_recibo':$('#nro_recibo1').val(),
                    'id_zona':$('#id_zona1').val(),
                    'id_tipo_acopio':$('#id_tipo_acopio1').val(),
                    'id_prop_fq':$('#id_prop_fq1').val(), 
                    'id_prop_org':$('#id_prop_org1').val(), 
                    'id_resp_recepcion':$('#id_resp_recepcion1').val(), 
                    'acta_entrega':$('#acta_entrega1').val(), 
                    'pago':$('#pago1').val(),                     
                    'id_destino':$('#id_destino1').val()},
            success: function(data){
                $("#UpdateFondosAvance").modal('toggle');
                swal("El Acopio!", "Fue actualizado correctamente!", "success");
                $('#lts-acopio').DataTable().ajax.reload();
                
                 
            },  error: function(result) {
                  console.log(result);
                 swal("Opss..!", "El acopio no se puedo actualizar intente de nuevo!", "error")
            }
        });
        });
    
    function Eliminar(btn){
    var route="/AcopioMiel/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el acopio?", 
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
                    $('#lts-acopio').DataTable().ajax.reload();
                    swal("Acopio!", "Fue eliminado correctamente!", "success");
                },
                    error: function(result) {
                        swal("Opss..!", "El acopio tiene registros en otras tablas!", "error")
                }
            });
    });
    }

    $("#registroDestino").click(function(){
        var route="/Destino";
         var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'des_descripcion':$("#destino").val()
                    },
                success: function(data){
                    $("#nuevoDestino").modal('toggle');
                    swal("El Destino!", "Se ha registrado correctamente!", "success");
                    // $('#lts-acopio').DataTable().ajax.reload();
                    
                },
                error: function(result) {
                    swal("OpssApo..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });

    $("#registroRespRecep").click(function(){
        var route="/RespRecep";
         var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'rec_nombre':$("#rec_nombre").val(),
                   'rec_ap':$("#rec_ap").val(),
                   'rec_am':$("#rec_am").val(),
                   'rec_ci':$("#rec_ci").val()
                    },
                success: function(data){
                    $("#nuevoRespRecep").modal('toggle');
                    swal("El Recepcionista!", "Se ha registrado correctamente!", "success");
                    // $('#lts-acopio').DataTable().ajax.reload();
                    
                },
                error: function(result) {
                    swal("OpssApo..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });

    function LimpiarDatosProduccion()
    {
        $("#id_proveedorProductor").empty();
        $("#acta_entrega").val("");
        $("#departamento").val("");
        $("#municipio").val("");
        $("#comunidad").val("");
        $("#coordslat").val("");
        $("#coordslng").val("");        
        $("#nro_marcocentrif").val("");        
        $("#br_baldesfilt").val("");        
        $("#br_baldescentrif").val("");        
        $("#br_baldesimpu").val("");        
        $("#cant_baldes").val("");        
        $("#peso_neto").val("");        
        $("#id_destino").val("");
        $("#id_resp_recepcion").empty();
        $("#observacion").val("");
        $('.items_colums').remove();
        document.getElementById('spTotal').innerHTML = "0.00";      
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