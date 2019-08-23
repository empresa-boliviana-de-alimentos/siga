@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_lacteos.recepcionPl.partials.modalCreate')
@include('backend.administracion.acopio.acopio_lacteos.acopio.partials.modalCreateTot')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('acopio_lacteos') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h3><label for="box-title">Recepcion Planta Lacteos Modulos y/o Centros de Acopio</label></h3>
                </div>
                <div class="btn pull-right col-md-4">
                     <a class="btn btn-primary btn-md fa fa-file-pdf-o" style="color:#ffffff" href="BoletaAcopiodia" target="_blank"><h7 style="color:#ffffff"> Generar Reporte Diario</h7></a>
                      <?php  
                     date_default_timezone_set('America/New_York');
                     $fechact=date('Y-m-d');
                     //echo $dat;
                   // echo $fecha;
                    //echo $turnulo=is_null($tur);
                      if($fechact==$fecha and $tur==0)
                     { 
                        echo  '<div class="hidden" id="contenido">';
                        echo'<button class="btn btn-success" data-target="#myCreateRTOT" data-toggle="modal"  type="button" onClick="MostrarCantidades2();" style="background:#2b5a2b;"><h7 style="color:#ffffff">Enviar Registros del dia</h7></button>' ;
                        echo '</div>';
                     }
                     elseif($fechact==$fecha and $tur==1)
                     { 
                        echo  '<div class="hidden" id="contenido">';
                        echo'<button class="btn btn-success" data-target="#myCreateRTOT" data-toggle="modal"  type="button" onClick="MostrarCantidades2();" style="background:#2b5a2b;"><h7 style="color:#ffffff">Enviar Registros del dia</h7></button>' ;
                        echo '</div>';
                     }
                     elseif($fechact==$fecha and $tur==2) 
                     {
                        echo  '<div class="hidden" id="contenido">';
                        echo'<button class="btn btn-success" data-target="#myCreateRTOT" data-toggle="modal"  type="button" onClick="MostrarCantidades2();" style="background:#2b5a2b;"><h7 style="color:#ffffff">Enviar Registros del dia</h7></button>' ;
                        echo '</div>';
                     }else
                     {
                        echo'<button class="btn btn-success" data-target="#myCreateRTOT" data-toggle="modal"  type="button" onClick="MostrarCantidades2();" style="background:#2b5a2b;"><h7 style="color:#ffffff">Enviar Registros del dia</h7></button>' ;
                     }
                    ?>  
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading text-center">
        <h3 class="panel-title">
            <span>
                <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    LISTADO RECEPCION DE MODULOS Y/O CENTROS
            </span>
        </h3>
    </div>
    <div class="panel-body">
        <div id="sample_editable_1_wrapper" class="">
            <table class="col-md-12 table-bordered table-striped table-condensed cf" style="font-size:7; width:100%" id="lts-acopio"> 
                <thead class="table_head">
                    <tr>
                        <th>Opciones</th>
                        <th>Modulo y/o Centro</th>
                        <th>Asociacion/Representante</th>
                        <th>CI</th>
                        <th>Tel</th>
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
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/AcopioRecepcion/create",
            "columns":[
                {data: 'acciones', orderable: false, searchable: false},
                {data: 'modulo_modulo'},
                {data: 'nombreCompleto'},
                {data: 'modulo_ci'},
                {data: 'modulo_tel'}
                // {data: 'lugardep'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

          columnDefs: [{
          // width: "400px",
          targets: 0
          }]
       
    });

    function Limpiar(){
        $("#cod_prov").val("");$("#aco_apr").val("");$("#aco_hrs").val("");$("#aco_can").val("");$("#aco_obs").val("");
        $("#aco_tenv").val("");$("#aco_cond").val("");$("#aco_tem").val("");$("#aco_sng").val("");$("#aco_palc").val("");
        $("#aco_asp").val("");$("#aco_col").val("");$("#aco_olo").val("");$("#aco_sab").val("");
    }

    function LimpiarReg(){
        $("#cod_prov2").val("");$("#aco_apr").val("");$("#aco_can").val("");$("#aco_can_baldes").val("");$("#aco_obs").val("");$("#aco_obs").val("");$("#aco_hrs").val("");
    }

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
                   'sabor' :$('#aco_sab').val()},
               success: function(data){
                    $("#myCreateRCA").modal('toggle');Limpiar()
                    swal("El Acopio!", "Se ha registrado correctamente!", "success");                    
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



//envio de datos a planta central
    $("#registroG").click(function(){
        var route="/AcopioLacteosGen";
        var token =$("#token").val();
        swal({   title: "Confirmacion de envio?",
              text: "Usted esta seguro de enviar los totales a Laboratorio",
              type: "warning",   
              showCancelButton: true,
              confirmButtonColor: "#28A345",
              confirmButtonText: "Enviar!",
              closeOnConfirm: true
            },function(){  
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'cant_prov1' :$("#cant_prov1").val(),
                   'cant_lech1' :$("#cant_lech1").val(),
                   'acog_obs'   :$("#acog_obs").val(),
                   'temperatura':$('#acog_tem').val(),
                   'sng'        :$('#acog_sng').val(),
                   'prueba_alcohol'  :$('#acog_palc').val(),
                   'aspecto'   :$('#acog_asp').val(),
                   'color'   :$('#acog_col').val(),
                   'olor'   :$('#acog_olo').val(),
                   'sabor'   :$('#acog_sab').val()},
               success: function(data){
                   $("#myCreateRTOT").modal('toggle');
                   
                 // swal("El Acopio General Dia!", "Se ha registrado correctamente El acopio General!", "success");  
                    location.reload('/AcopioLacteos');                  
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
});

$("#registroModuloAco").click(function(){
        var route="AcopioRecepcion";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');

        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'recmod_id_mod':$("#cod_prov2").val(),
                   'recmod_acepta':$("#aco_apr").val(),
                   'recmod_cant_recep':$("#aco_can").val(),
                   'recmod_cant_bal_recep':$("#aco_can_baldes").val(),
                   'recmod_obs':$('#aco_obs').val(),
                   'recmod_hora':$('#aco_hrs').val(),
                 },
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#myCreateRecepcion").modal('toggle');LimpiarReg();
                    swal("El Modulo/Centro de Acopio!", "Se registrado correctamente!", "success");
                    $('#lts-acopio').DataTable().ajax.reload();
                    console.log(data);
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

//FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN REGISTRO
    function MostrarModulo(btn){
        var route = "/AcopioRecepcion/"+btn.value+"/edit";
        console.log (route);
        $.get(route, function(res){
            $("#cod_prov2").val(res.modulo_id);
            $("#cod_nom2").val(res.modulo_modulo);
            // $("#cod_ap2").val(res.modulo_paterno);
            // $("#cod_am2").val(res.modulo_materno); 
          });
    }
 //FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN LISTADO   
    // function MostrarProveedor(btn){
    //     var route = "/AcopioLacteos/"+btn.value+"/edit";
    //     $.get(route, function(res){
    //         $("#cod_prov1").val(res.prov_id);
    //         $("#cod_nom1").val(res.prov_nombre);
    //         $("#cod_ap1").val(res.prov_ap);
    //         $("#cod_am1").val(res.prov_am);  
    //       });
    // }

//FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN LISTADO   
    function MostrarCantidades2(){ 
        //var route1="/AcopioLacteosverificar"
       // if()
        var route = "/AcopioLacteosSum";
        $.get(route, function(res){ 
          console.log(res);
            // $("#cant_prov1").val(res[0].xtotalprov);
            $("#cant_lech1").val(res.cantidad_total);
        });

        //var route2="/AcopioLacteosGen";

    }

    
</script>
@endpush
