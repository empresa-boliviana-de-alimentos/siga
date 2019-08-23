@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_lacteos.acopio.partials.modalListar')
@include('backend.administracion.acopio.acopio_lacteos.acopio.partials.modalCreateTot')
@include('backend.administracion.acopio.acopio_lacteos.acopio.partials.modalCreateModulo')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('acopio_lacteos') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h3><label for="box-title">Acopios Lacteos Modulos y/o Centros de Acopios</label></h3>
                </div>
                <div class="col-md-2">
                <!-- <button class="btn fa fa-plus-square pull-right btn-dark"  onclick="LimpiarPersona();" data-target="#myListar" data-toggle="modal">&nbsp;Nuevo</button>
                </div> -->
                <!-- <button class="btn fa fa-plus-square pull-right btn-dark" data-target="#myListar" data-toggle="modal">&nbsp;Nuevo Modulo</button> -->
                <a type="button" class="btn pull-right btn-dark" data-target="#myCreateModulo" data-toggle="modal" style="background: #0067B4"><h7 style="color:white">+&nbsp;&nbsp;NUEVO MODULO/CENTRO ACOPIO</h7></a>
                </div>
                <div class="col-md-4">
                     <a class="btn btn-danger" href="BoletaAcopiodia" target="_blank" class="btn btn-primary fa fa-print">Generar Reporte Diario</a>
                      <?php  
                     date_default_timezone_set('America/New_York');
                     $fechact=date('Y-m-d');
                     //echo $dat;
                    // echo $fechact;
                     if($fechact==$fecha)
                     { 
                        echo  '<div class="hidden" id="contenido">';
                        echo'<button class="btn btn-success" data-target="#myCreateRTOT" data-toggle="modal"  type="button" onClick="MostrarCantidades2();">Enviar Registros del dia</button>' ;
                        echo '</div>';
                     }
                     else
                     {
                        echo'<button class="btn btn-success" data-target="#myCreateRTOT" data-toggle="modal"  type="button" onClick="MostrarCantidades2();">Enviar Registros del dia</button>' ;
                     }
                    ?>  
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<!--
<div align="right" class="page-header">
     <td>
        
        <center> <h2><font face="Showcard Gothic"> Acopios Lacteos Proveedores </font> </h2></center>
        <a class="btn btn-primary fa fa-print pull-right" href="BoletaAcopiodia" target="_blank" class="btn btn-primary fa fa-print">Generar Reporte Diariooooo</a>
       
       <button class="button button-glow button-rounded button-success" data-target="#myCreateRTOT" data-toggle="modal"  type="button" onClick="MostrarCantidades2();">
            Enviar Registros del dia
        </button>
    </td>
</div>-->
<div class="panel panel-default">
    <div class="panel-heading text-center">
        <h3 class="panel-title">
            <span>
                <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    LISTADO DE MODULOS Y/O CENTROS DE ACOPIO REGISTRADOS
            </span>
        </h3>
    </div>
    <div class="panel-body">
        <div id="sample_editable_1_wrapper" class="">
            <table class="table table-striped table-bordered table-hover dataTable no-footer" id="lts-acopio" role="grid"> 
                <thead class="table_head">
                    <tr>
                        <th class="sorting">Opciones</th>
                        <th class="sorting">Modulo y/o Centro</th>
                        <th class="sorting">CI</th>
                        <th class="sorting">Tel</th>
                        <th class="sorting">Lugar Acopio</th>                                              
                    </tr>
               </thead>
           </table>
        </div>
    </div>
    {{-- <div class="panel-body">
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
    </div> --}}
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
                {data: 'modulo_ci'},
                {data: 'modulo_tel'},
                {data: 'modulo_dir'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

          columnDefs: [{
          width: "400px",
          targets: 0
          }]
       
    });

//     function Limpiar(){
//         $("#cod_prov").val("");$("#aco_apr").val("");$("#aco_hrs").val("");$("#aco_can").val("");$("#aco_obs").val("");
//         $("#aco_tenv").val("");$("#aco_cond").val("");$("#aco_tem").val("");$("#aco_sng").val("");$("#aco_palc").val("");
//         $("#aco_asp").val("");$("#aco_col").val("");$("#aco_olo").val("");$("#aco_sab").val("");
//     }

//     // $("#registro").click(function(){
//     //     var route="/AcopioLacteos";
//     //     var token =$("#token").val();
//     //     $.ajax({
//     //         url: route,
//     //         headers: {'X-CSRF-TOKEN': token},
//     //         type: 'POST',
//     //         dataType: 'json',
//     //         data: {'cod_prov':$("#cod_prov").val(),
//     //                'certificado_aceptacion' :$("#aco_apr").val(),
//     //                'hora' :$("#aco_hrs").val(),
//     //                'cantidad' :$('#aco_can').val(),
//     //                'aco_obs' :$('#aco_obs').val(),
//     //                'tipo_envase':$('#aco_tenv').val(),
//     //                'condiciones_higiene':$('#aco_cond').val(),
//     //                'temperatura' :$('#aco_tem').val(),
//     //                'sng' :$('#aco_sng').val(),
//     //                'prueba_alcohol':$('#aco_palc').val(),
//     //                'aspecto' :$('#aco_asp').val(),
//     //                'color' :$('#aco_col').val(),
//     //                'olor' :$('#aco_olo').val(),
//     //                'sabor' :$('#aco_sab').val()},
//     //            success: function(data){
//     //                 $("#myCreateRCA").modal('toggle');Limpiar()
//     //                 swal("El Acopio!", "Se ha registrado correctamente!", "success");                    
//     //             },
//     //             error: function(result) {
//     //                 var errorCompleto='Tiene los siguientes errores: ';
//     //                 $.each(result.responseJSON.errors,function(indice,valor){
//     //                    errorCompleto = errorCompleto + valor+' ' ;                       
//     //                 });
//     //                 swal("Opss..., Hubo un error!",errorCompleto,"error");
//     //             }
//     //     });
//     // });



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
                   // 'temperatura':$('#acog_tem').val(),
                   // 'sng'        :$('#acog_sng').val(),
                   // 'prueba_alcohol'  :$('#acog_palc').val(),
                   // 'aspecto'   :$('#acog_asp').val(),
                   // 'color'   :$('#acog_col').val(),
                   // 'olor'   :$('#acog_olo').val(),
                   // 'sabor'   :$('#acog_sab').val()},
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

//  // $("#envioAlm").click(function(){
//  //            var route="/AcopioLacteosEnvioAlm";
//  //            var token =$("#token").val();
//  //            swal({   title: "Confirmacion de envio a Almacen?",
//  //              text: "Usted esta seguro de enviar los totales a Almacen",
//  //              type: "warning",   
//  //              showCancelButton: true,
//  //              confirmButtonColor: "#28A345",
//  //              confirmButtonText: "Enviar!",
//  //              closeOnConfirm: true
//  //            },function(){
//  //                $.ajax({
//  //                    url: route,
//  //                    headers: {'X-CSRF-TOKEN': token},
//  //                    type: 'POST',
//  //                    dataType: 'json',
//  //                    data: {
//  //                    'enval_cant_total':$("#enval_cant_total").val(),
//  //                    'enval_cost_total':$("#enval_cost_total").val(),
//  //                    'enval_registro':$("#enval_registro").val(),
//  //                    'planta_destino':$("#enval_destino").val(),         
//  //                    },
//  //                    success: function(data){
//  //                        // $("#myCreateEnvioAlm").modal('toggle');
//  //                        // swal("Acceso!", "registro correcto","success");
//  //                        // $('#lts-enviosalmacen').DataTable().ajax.reload();

//  //                        console.log('id del envio_alm: '+data.enval_id);
//  //                        $('#idBolEnvioAlm').val(data.enval_id);
//  //                        $('#iframeboletaEnvioAlm').attr('src', 'boletaEnvioAlm/'+data.enval_id);
//  //                        $('#myBoletaEnvioAlm').modal('show'); 
//  //                        $("#myCreateEnvioAlm").modal('toggle');
//  //                        $('#lts-enviosalmacenlac').DataTable().ajax.reload();
//  //                        location.reload('/AcopioLacteosEnvioAlm');
//  //                    },
//  //                    error: function(result)
//  //                    {
//  //                    // swal("Opss..!", "Error al registrar el dato", "error");
//  //                        var errorCompleto='Tiene los siguientes errores: ';
//  //                        $.each(result.responseJSON.errors,function(indice,valor){
//  //                            errorCompleto = errorCompleto + valor+' ' ;                       
//  //                        });
//  //                        swal("Opss..., Hubo un error!",errorCompleto,"error");
//  //                    }
//  //                });
//  //            });
//  //        });

// //FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN REGISTRO
//     function MostrarProveedor2(btn){
//         var route = "/AcopioLacteos/"+btn.value+"/edit";
//         $.get(route, function(res){
//             $("#cod_prov").val(res.prov_id);
//             $("#cod_nom").val(res.prov_nombre);
//             $("#cod_ap").val(res.prov_ap);
//             $("#cod_am").val(res.prov_am); 
//           });
//     }
//  //FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN LISTADO   
//     function MostrarProveedor(btn){
//         var route = "/AcopioLacteos/"+btn.value+"/edit";
//         $.get(route, function(res){
//             $("#cod_prov1").val(res.prov_id);
//             $("#cod_nom1").val(res.prov_nombre);
//             $("#cod_ap1").val(res.prov_ap);
//             $("#cod_am1").val(res.prov_am);  
//           });
//     }

// //FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN LISTADO   
//     function MostrarCantidades2(){ 
//         //var route1="/AcopioLacteosverificar"
//        // if()
//         var route = "/AcopioLacteosSum";
//         $.get(route, function(res){ 
//             $("#cant_prov1").val(res[0].xtotalprov);
//             $("#cant_lech1").val(res[0].xtotal);
//         });

//         //var route2="/AcopioLacteosGen";

//     }

    
</script>
@endpush
