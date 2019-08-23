@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_lacteos.modulo.partials.modalCreateModulo')
@include('backend.administracion.acopio.acopio_lacteos.acopio.partials.modalCreateTot')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('acopio_lacteos') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-5">
                     <h3><label for="box-title">Modulos y/o Centros de Acopio</label></h3>
                </div>
                <div class="col-md-2">
                  <p><h6>Cant. Recibida: &nbsp;<span style="color:blue;">{{ Number_format($cantidad_recibido,2,'.',',') }}</span></h6></p>
                  <p><h6>Cant. Acopiada: <span style="color:blue;">{{ Number_format($cantidad_acopiada,2,'.',',') }}</span></h6></p>
                  <p><h6>Cant. Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:blue;">{{ Number_format($cantidad_total,2,'.',',') }}</span></h6></p>
                </div>
                <div class="col-md-2">
                  <a href="ReporteDiarioAcopioModulos" class="btn btn-primary btn-lg fa fa-file-pdf-o" style="color:white;" target="_blank"><h7 style="color:white">&nbsp;REPORTE DEL DIA</h7></a>
                </div>
                <div class="col-md-2">
                <a type="button" onclick="LimpiarRegistroModu();" class="btn pull-right btn-default" data-target="#myCreateModulo" data-toggle="modal" style="background: #616A6B"><h7 style="color:white">+&nbsp;&nbsp;MODULO/CENTRO ACOPIO</h7></a>
                </div>
                <!-- <div class="btn pull-right col-md-4">
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
                </div> -->
              
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
                    LISTADO DE MODULOS Y/O CENTROS DE ACOPIO REGISTRADOS
            </span>
        </h3>
    </div>
    <div class="panel-body">
        <div id="sample_editable_1_wrapper" class="">
            <table class="table table-striped table-bordered table-hover dataTable no-footer" id="lts-modulo" role="grid" style="width:100%"> 
                <thead class="table_head">
                    <tr>
                        <th class="sorting text-center">LISTAR</th>
                        <th class="sorting text-center">MODULO Y/O CENTRO ACOPIO</th>
                        <th class="sorting text-center">NOMBRE RESPONSABLE</th>
                        <th class="sorting text-center">CI. RESPONSABLE</th>
                        <th class="sorting text-center">TELF. RESPONSABLE</th>
                        <th class="sorting text-center">LUGAR ACOPIO</th>                                              
                    </tr>
               </thead>
           </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#lts-modulo').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "ModuloLacteos/create",
            "columns":[
                {data: 'acciones', orderable: false, searchable: false},
                {data: 'modulo_modulo'},
                {data: 'nombreCompleto'},
                {data: 'modulo_ci'},
                {data: 'modulo_tel'},
                {data: 'modulo_dir'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

          // columnDefs: [{
          // width: "400px",
          // targets: 0
          // }]
       
    });

     $("#registroModulo").click(function(){
        var route="ModuloLacteos";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'nombre_modulo':$("#modu_modulo").val(),
                   'modulo_nombres':$("#modu_nombres").val(),
                   'modulo_paterno':$("#modu_paterno").val(),
                   'modulo_materno':$("#modu_materno").val(),
                   'modulo_ci':$('#modu_ci').val(),
                   'modulo_telefono':$('#modu_telefono').val(),
                   'modulo_direccion':$('#modu_direccion').val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#myCreateModulo").modal('toggle');
                    swal("El Modulo/Centro de Acopio!", "Se registrado correctamente!", "success");
                    $('#lts-modulo').DataTable().ajax.reload();
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

    function LimpiarRegistroModu()
    {
      document.getElementById("check").checked = false;
      document.getElementById("ocultar").style.display='none';
      $('#modu_modulo').val('');
      $('#modu_nombres').val('');
      $('#modu_paterno').val('');
      $('#modu_materno').val('');
      $('#modu_ci').val('');
      $('#modu_telefono').val('');
      $('#modu_direccion').val('');
    }    

    //FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN LISTADO   
       function MostrarCantidades2(){ 
         var route1="/AcopioRecepcion"
         // if()
        var route = "/AcopioLacteosSum";
        $.get(route, function(res){ 
            $("#cant_prov1").val(res[0].xtotalprov);
            $("#cant_lech1").val(res[0].xtotal);
        });
      }

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
</script>
@endpush
