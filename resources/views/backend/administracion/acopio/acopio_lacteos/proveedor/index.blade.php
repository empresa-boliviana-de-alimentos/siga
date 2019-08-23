@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_lacteos.proveedor.partials.modalCreate')
@include('backend.administracion.acopio.acopio_lacteos.proveedor.partials.modalUpdate')
@include('backend.administracion.acopio.acopio_lacteos.acopio_modulo.partials.modalCreateAcopio')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('ModuloLacteos') }}"><span class="fa fas fa-angle-double-left" style="color: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;ATRAS</h7></a>
                </div>
                <div class="col-md-6">
                     <h4><label for="box-title">&nbsp;&nbsp;PROVEEDORES DEL MODULO: {{ $datos_modulo->modulo_modulo}}</label></h4>
                </div>
                <input type="hidden" id="cantidad_recibida" value="{{$cantidad_total}}">
                <div class="col-md-3">
                  <p><h6>Cant. Recibida: &nbsp;<span style="color:blue;">{{ Number_format($cantidad_recibido->cant_total_recibida,2,'.',',') }}</span></h6></p>
                  <p><h6>Cant. Acopiada: <span style="color:blue;">{{ Number_format($cantidad_acopiada,2,'.',',') }}</span></h6></p>
                  <p><h6>Cant. Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:blue;">{{ Number_format($cantidad_total,2,'.',',') }}</span></h6></p>
                </div>
                <div class="col-md-2">
                <!-- <button class="btn fa fa-plus-square pull-right btn-dark"  data-target="#myCreate" data-toggle="modal">&nbsp;Nuevo</button> -->
                <a type="button" onclick="LimpiarRegistroModu();" class="btn btn-default" data-target="#myCreate" data-toggle="modal" style="background: #616A6B"><h7 style="color:white">+&nbsp;&nbsp;NUEVO PROVEEDOR</h7></a>
                </div>
                <input type="hidden" id="id_modulo" name="id_modulo" value="{{$id_modulo}}">
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
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-proveedor" style="width:100%">
                            <thead class="cf">
                               <tr>
                                <th class="sorting text-center">OPCIONES</th>
                                <th class="sorting text-center">NOMBRES</th>
                                <th class="sorting text-center">CI</th>
                                <th class="sorting text-center">NRO NIT</th>
                                <th class="sorting text-center">NRO DOCUMENTO</th>
                                <th class="sorting text-center">TELEFONO</th>
                                <th class="sorting text-center">LUGAR</th>
                                <th class="sorting text-center">RAU</th>
                            </tr>
                            </thead>
                            <tr>
                            </tr>
                    </table>
                </div>    
            </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    ListarProveedores();
});
function ListarProveedores() {
    console.log($("#id_modulo").val());
    $('#lts-proveedor').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "/listarModuloCreate/"+$("#id_modulo").val(),
               type: "GET",
               data: {"id_modulo": $("#id_modulo").val()}
             },

            // "ajax": "listarModuloCreate/"+$("#id_modulo").val()
            "columns":[
                {data: 'acciones', orderable: false, searchable: false},
                {data: 'nombreCompleto'},
                {data: 'prov_ci'},
                {data: 'prov_nit'},
                {data: 'prov_cuenta'},
                {data: 'prov_tel'},
                {data: 'lugarprov'},
                {data: 'rau'},  
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });
}

    function Limpiar(){
        $("#n_nombres").val("");$("#n_ap").val("");$("#n_am").val("");$("#n_ci").val("");$("#n_exp").val("");
        $("#n_tel").val("");$("#n_dep").val("");$("#n_mun").val("");$("#n_lugpro").val("");$("#n_tipo").val("");
        $("#id_comunidad").val("");$("#id_asociacion").val("");
    }

    $("#registro").click(function(){
        var route="/registrarProveedorMod";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'nombres':$("#n_nombres").val(),
                   'paterno':$("#n_ap").val(),
                   'materno':$("#n_am").val(),
                   'ci':$('#n_ci').val(),
                   'expedido':$('#n_exp').val(),
                   'pro_tel':$('#n_tel').val(),
                   'departamento':$('#n_dep').val(),
                   'municipio':$('#municipio').val(),
                   'lugar_proveedor':$('#lugar_proveedor').val(),
                   // 'tipo_proveedor':$('#tipo_proveedor').val(),
                   'rau': $('#rau').val(),
                   'nro_nit':$('#nronit').val(),
                   'nro_cuenta':$('#nrocuenta').val(),
                   'imgProveedorL':$("#imgProveedorL").val(),
                   'prov_id_modulo': $("#id_modulo").val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#myCreate").modal('toggle');Limpiar();
                    swal("El Proveedor!", "Se registrado correctamente!", "success");
                    $('#lts-proveedor').DataTable().ajax.reload();
                    
                },
                error: function(result) {
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
                    'prov_lugar'        :$('#e_lugpro').val(),
                    // 'prov_id_tipo'      :$('#e_tipo').val()},
                    'prov_rau'          :$('#e_rau').val(),
                    'prov_nit'          :$('#e_nit').val(),
                    'prov_cuenta'       :$('#e_cuenta').val()},
            success: function(data){
                $("#myUpdate").modal('toggle');
                swal("El Proveedor!", "Fue actualizado correctamentessss!", "success");
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
          console.log(res);
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
            $("#e_rau").val(res.prov_rau);
            if ($("#e_rau").val()==2) {
                $('.ocultarP').hide();
               $("#e_nit").val("");
                $("#e_cuenta").val("");
            }else{
                $('.ocultarP').show();
                
                $("#e_nit").val(res.prov_nit);
                $("#e_cuenta").val(res.prov_cuenta);
            }

        });
    }
 function LimpiarRegistroModu(){
            $("#n_nombres").val("");
            $("#n_ap").val("");
            $("#n_am").val("");
            $('#n_ci').val("");
            $('#n_exp').val("1");
            $('#n_tel').val("");
            $('#n_dep').val("1");
            $('#n_mun').val("0");
            $('#lugar_proveedor').val("0");
            $('#n_tipo').val("");
            $('#rau').val("0");
            $('#nronit').val("");
            $('#nrocuenta').val("");
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

// REGISTRO DE ACOPIO
function MostrarRegistroAco(btn){
    var route = "/ProveedorLacteos/"+btn.value;
    $.get(route, function(res){
    console.log(res);
        $("#cod_prov").val(res[0].prov_id);
        $("#cod_nom").val(res[0].prov_nombre+' '+res[0].prov_ap+' '+res[0].prov_am);
        // $("#cod_ap").val(res[0].prov_ap);
        // $("#cod_am").val(res[0].prov_am);
    });
}


$("#registroAco").click(function(){
        var route="/RegistrarAcopioProv";
        var token =$("#token").val();
        var cant_recibida = parseFloat($("#cantidad_recibida").val());
        var aco_cant = parseFloat($("#aco_can").val());
        if (cant_recibida >= aco_cant) {
          console.log("CANTIDAD RECIBIDA: "+cant_recibida+', ACOPIO: '+aco_cant);
          $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'cod_prov':$("#cod_prov").val(),
                   'certificado_aceptacion' :$("#aco_apr").val(),
                   'hora' :$("#aco_hrs").val(),
                   'cantidad' :$('#aco_can').val(),
                   'aco_obs' :$('#aco_obs').val(),
                   'tipo_envase':$('#aco_tenv').val(),
                   'condiciones_higiene':$('#aco_cond').val(),
                   'temperatura' :$('#aco_tem').val(),
                   'sng' :$('#aco_sng').val(),
                   'prueba_alcohol':$('#aco_palc').val(),
                   'aspecto' :$('#aco_asp').val(),
                   'color' :$('#aco_col').val(),
                   'olor' :$('#aco_olo').val(),
                   'sabor' :$('#aco_sab').val(),
                   'fecha_acopio':$('#fecha_acopio').val()},
               success: function(data){
                    $("#myCreateRCAprov").modal('toggle');
                    // swal("El Acopio!", "Se ha registrado correctamente!", "success"); 
                    swal({ 
                                title: "Exito",
                                text: "Registrado con Exito",
                                type: "success" 
                                            },
                                function(){
                                        location.reload();
                            });                   
                },
                error: function(result) {
                    var errorCompleto='Tiene los siguientes errores: ';
                    $.each(result.responseJSON.errors,function(indice,valor){
                       errorCompleto = errorCompleto + valor+' ' ;                       
                    });
                    swal("Opss..., Hubo un error!",errorCompleto,"error");
                }
        });
        }else{
          console.log("NO SE PUEDE");
          swal('no se pudo registrar!','La cantidad acopiada: '+$("#aco_can").val()+', sobrepasa a la cantidad enviada: '+$("#cantidad_recibida").val(),'error');
        }
        
});
</script>
<script type="text/javascript">
  
  $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                language: "es",
                autoclose: true,
                
            });

            var fecha= new Date();
            var vDia;
            var vMes;

            if ((fecha.getMonth()+1) < 10) { vMes = "0" + (fecha.getMonth()+1); }
            else { vMes = (fecha.getMonth()+1); }

            if (fecha.getDate() < 10) { vDia = "0" + fecha.getDate(); }
            else{ vDia = fecha.getDate(); }
 
</script>
@endpush
{{-- <style type="text/css">
     .button {
  background-color: #000000; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
</style>
 --}}