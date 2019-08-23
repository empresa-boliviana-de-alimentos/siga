@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateFondos')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalUpdateFondos')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateDestino')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateRespRecep')

<div class="row">
    <div class="col-md-12">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(Session::has('success'))
            <div class="alert alert-info">
                {{Session::get('success')}}
            </div>
            @endif
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioMielMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">Acopio Fondos en Avance de Miel</label></h4>
                </div>
                
                <!-- <div class="col-md-2"> -->
               <!-- <a class="btn btn-success" role="button" data-toggle="modal" onclick="LimpiarDatos();" data-href="#acopioFondos" href="#AcopioFondoAvance">
                    <i class="fa fa-plus">
                    </i> &nbsp;NUEVO ACOPIO POR FONDOS EN AVANCE
                </a> -->
                <!-- <button class="btn btn-success"  onclick="LimpiarDatos();" data-href="#acopioFondos" href="#AcopioFondoAvance" data-toggle="modal"><i class="fa fa-plus">
                    </i> &nbsp;NUEVO ACOPIO POR FONDOS EN AVANCE</button>
                </div> -->
                <div class="col-md-2">
                    <a href="{{url('AcopioMielNuevo')}}" class="btn btn-default" style="background: #616A6B;">  
                        <h6 style="color: white;"><i class="fa fa-plus">
                    </i> &nbsp;NUEVO ACOPIO POR FONDOS EN AVANCE</h6>
                    </a>
                </div>
                <div class="col-md-1"></div>

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
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-acopio">
                            <thead class="cf">
                                <tr>
                                    <!-- <th>
                                        Acciones
                                    </th> -->
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
                                        Total Peso Neto
                                    </th>
                                    <th>
                                        Total Peso Bruto
                                    </th>
                                    <th>
                                        Total Costo Compra
                                    </th>
                                    <th>
                                        Rechazado/Aceptado
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
            </div>
        </div>
</div>
@endsection

@push('scripts')
<script>
    var tableAcoFA = $('#lts-acopio').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/AcopioMiel/create",
            "columns":[
                // {data: 'acciones',orderable: false, searchable: false},
                {data: 'aco_num_act'},
		{data: 'aco_numaco'},
                {data: 'prov_nombre'},
                {data: 'prov_ap'},
                {data: 'prov_am'},
                {data: 'aco_fecha_acop'},
                {data: 'prom_peso_neto'},
                {data: 'prom_peso_bruto'},           
                {data: 'prom_total'},
                {data: 'materiPrima'},
                
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });
    $('#buscarnom').on( 'keyup', function () {
    tableAcoFA
        .columns( 2 )
        .search( this.value )
        .draw();
    } );

    $('#buscarpat').on( 'keyup', function () {
    tableAcoFA
        .columns( 3 )
        .search( this.value )
        .draw();
    } );

    $('#buscarmat').on( 'keyup', function () {
    tableAcoFA
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
        var route="/AcopioMiel";
         var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: { 'id_proveedor':$("#id_proveedor").val(),
                    'peso_neto':$("#peso_neto").val(),
                    'peso_tara':$("#peso_tara").val(),
                    'acta_entrega':$("#acta_entrega").val(),
                    'humedad':$("#humedad").val(),
                    'cantidad':$('#cantidad').val(),
                    'costo':$('#costo').val(),
                    'total':$('#total').val(),
                    'peso_bruto':$('#peso_bruto').val(),
                    'fecha_acopio':$('#fecha_acopio').val(),
                    'fecha_resgistro':$('#fecha_resgistro').val(),
                    'fecha_recibo':$('#fecha_recibo').val(),
                    'observacion':$('#observacion').val(),
                    'is_pago':$('#is_pago').val(),
                    'nro_recibo':$('#nro_recibo').val(),
                    'responsable_recepcion':$('#id_resp_recepcion').val(),                   
                    'destino':$('#id_destino').val(),
                    'aco_mapri' :$('#aco_mapri').val(),
		            'aco_numaco' :$('#nro_acopio').val() },  
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#AcopioFondoAvance").modal('toggle');
                    // swal("El Acopio!", "Se registrado correctamente!", "success");
                    // $('#lts-acopio').DataTable().ajax.reload();
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
                    var errorCompleto='Tiene los siguientes errores: ';
                    $.each(result.responseJSON.errors,function(indice,valor){
                       errorCompleto = errorCompleto + valor+' ' ;                       
                    });
                    swal("Opss..., Hubo un error!",errorCompleto,"error");
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
                    // 'fecha_resgistro':$('#fecha_resgistro').val(),
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

    function LimpiarDatos()
    {
        $("#id_proveedor").empty();
        $("#nro_recibo").val("0");
        $("#centro_acopio").val("");
        $("#central_org").val("");
        $("#humedad").val("");
        // $("#peso_tara").val("");
        $("#peso_bruto").val("");
        $("#peso_neto").val("");
        $("#rau").val("");
        $("#cantidad").val("");
        $("#costo").val("");
        $("#total").val("");
        $("#id_destino").empty();
        $("#id_resp_recepcion").empty();
        $("#observacion").val("");       
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
                $('#acopio').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {             
                       
                        humedad: {
                            validators: {
                                notEmpty: {
                                    message: 'Humedad Requerida'
                                }
                            }
                        },
                        peso_bruto: {
                            validators: {
                                notEmpty: {
                                    message: 'Peso Bruto Requirida'
                                }
                            }
                        },
                        cantidad: {
                            validators: {
                                notEmpty: {
                                    message: 'Cantidad Requerida'
                                },
                                integer: {
                                    message: 'El valor debe ser entero'
                                }
                            }
                        },
                        id_resp_recepcion: {
                            validators: {
                                notEmpty: {
                                    message: 'Responsable Requerida'
                                }
                            }
                        }
                    }
                });
            });
</script>
@endpush