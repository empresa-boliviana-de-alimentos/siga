@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_frutos.acopio.partials.modalCreate')
@include('backend.administracion.acopio.acopio_frutos.acopio.partials.modalListar')
@include('backend.administracion.acopio.acopio_frutos.acopio.partials.modalCreateFru')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
              <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioFrutosMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>  
                <div class="col-md-8">
                     <h4><label for="box-title">Acopios Frutos Proveedores</label></h4>
                </div>
                <div class="col-md-2">
                 <button class="btn fa fa-plus-square pull-right btn-dark" data-target="#myCreateFru" data-toggle="modal"  type="button">
                      Nueva Fruta
                    </button>
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
                    LISTADO DE ACOPIO REGISTRADOS
            </span>
        </h3>
    </div>
    <div class="panel-body">
        <div id="sample_editable_1_wrapper" class="">
            <table class="table table-striped table-bordered table-hover dataTable no-footer" id="lts-acopio" role="grid" style="width:100%"> 
                <thead class="table_head">
                    <tr>
                        <th class="" style="width:250px;">Opciones</th>
                        <th class="">Nombre Completo</th>
                        <th class="">CI</th>
                        <th class="">Tel</th>
                        <th class="">Lugar Acopio</th>                 
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
            "ajax": "/AcopioFrutos/create",
            "columns":[
                {data: 'acciones', orderable: false, searchable: false},
                {data: 'nombreCompleto'},
                {data: 'prov_ci'},
                {data: 'prov_tel'},
                {data: 'nombre_planta'},
        ],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });

    $("#registro").click(function(){
        var route="/AcopioFrutos";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {
              /*     'cod_prov':$("#cod_prov").val(),
                   'aco_id_tipofru' :$("#aco_id_tipofru").val(),
                   'aco_descartefru' :$("#aco_descartefru").val(),
                   'aco_calibrefru':$("#aco_calibrefru").val(),
                   'aco_ramhojafru' :$('#aco_ramhojafru').val(),
                   'aco_infestfru':$('#aco_infestfru').val(),
                   'aco_dañadosfru':$('#aco_dañadosfru').val(),
                   'aco_extrañosfru' :$('#aco_extrañosfru').val(),
                   'aco_cant_uni' :$('#aco_cant_uni').val(),
                   'aco_lotefru':$('#aco_lotefru').val(),
                   'aco_preciofru':$('#aco_preciofru').val(),
                   'aco_nomchofer' :$('#aco_nomchofer').val(),
                   'aco_placa' :$('#aco_placa').val(),
                   'aco_cantaprob' :$('#total').val(),
                   'aco_olor' :$('#aco_olor').val(),*/
                  },
               success: function(data){
                    $("#myCreateRepFruto").modal('toggle');
                    swal("El Acopio!", "Se ha registrado correctamente!", "success");                    
                },
                error: function(result) {
                        swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });

    $("#registrofru").click(function(){
        var route="/RegistroFrutos";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {
                   'tipfr_nombre':$("#nombre_fru").val(),
                 
                  },
               success: function(data){
                    $("#myCreateFru").modal('toggle');
                    swal("Se ha registrado correctamente!", "success");       
                    location.reload('/AcopioFrutos');             
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
        var route="/AcopioFrutosGen";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'cant_prov1' :$("#cant_prov1").val(),
                   'cant_fruta' :$("#cant_fruta").val(),
                   'acog_obs'   :$("#acog_obs").val(),
                   'cant_descorte'   :$('#cant_descarte').val(),
                   //'prov_nombre'   :$('#provnombreCompleto').val(),
                  },
               success: function(data){
                    $("#myCreateRTOT").modal('toggle');
                    swal("El Acopio General Dia!", "Se ha registrado correctamente El acopio General!", "success");                    
                },
                error: function(result) {
                        swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });

    $("#registroG2").click(function(){
        var route="/AcopioFrutosGen";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'cant_prov1' :$("#cant_prov1").val(),
                   'cant_fruta' :$("#provcant_fruta").val(),
                   'acog_obs'   :$("#acog_obs1").val(),
                   'cant_descorte'   :$('#provcant_descarte').val(),
                   'prov_nombre'   :$('#provnombreCompleto').val(),
                  },
               success: function(data){
                    $("#myCreateTotProv").modal('toggle');
                    swal("El Acopio General Dia!", "Se ha registrado correctamente El acopio General!", "success");                    
                },
                error: function(result) {
                        swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });

//FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN REGISTRO
    function MostrarProveedor2(btn){
   //   console.log(btn);
        var route = "/AcopioFrutos/"+btn.value+"/edit";
        console.log(route);
        $.get(route, function(res){
            $("#idaco").val(res.dac_id);
            $("#cod_prov").val(res.prov_id);
            $("#cod_nom").val(res.prov_nombre+' '+res.prov_ap+' '+res.prov_am); 
            $("#cod_ci").val(res.prov_ci+' '+res.dep_exp);
            $("#cod_tel").val(res.prov_tel);
            $("#nombre_dep").val(res.dep_nombre);
            $("#rau").val(res.prov_rau); 
            var val =$("#rau").val();
            if (val==1) {
              $("#rau1").val('SI');
            }
            else
            {
              $("#rau1").val('NO');
            }
            $("#aco_infestfru").val(res.dac_infestfru);
            $("#aco_extrañosfru").val(res.dac_extrañosfru);
            $("#aco_olor").val(res.dac_olor);
            $("#aco_nomchofer").val(res.dac_nomchofer);
            $("#aco_placa").val(res.dac_placa);
            $("#aco_lotefru").val(res.dac_lotefru);
            $("#aco_id_tipofru").val(res.dac_id_tipofru);

            $("#idaco").val(res.dac_id_acopio);
            $("#planta").val(res.dac_id_planta);
            $("#dep").val(res.prov_departamento);
            $("#provincia").val(res.prov_id_provincia);
            $("#comunidad").val(res.prov_id_comunidad);
            $("#nomdep").val(res.dep_nombre);
            $("#provi_nom").val(res.provi_nom);
            $("#com_nombre").val(res.com_nombre);

            $("#cichofer").val(res.dac_ci_chofer);
            $("#tipo_vehiculo").val(res.dac_tipo_vehi);
            $("#fecha_acopio").val(res.dac_fecha_acop);
            $("#aco_preciofru").val(res.dac_preciofru);
            $("#aco_cant_uni").val(res.dac_cantaprob);
            $("#aco_pesofru").val(res.dac_peso_fru);
            $("#aco_descartefru").val(res.dac_descant_fru);
            $("#aco_pesodescfru").val(res.dac_despeso_fru);
            $("#total").val(res.dac_cantot);
            $("#totalpeso").val(res.dac_pesotot);
            $("#estadodec").val(res.dac_estado);
            var est = document.getElementById('estadodec').value;
            console.log(est);
            if (est=='A') 
            { 
                $('#estadoA').show();
                $('#estadoC').hide();
            }else 
            {
                $('#estadoC').show();
                $('#estadoA').hide();
            }
          });
    }


     $("#actualizar").click(function(){
        var value =$("#idaco").val();
        console.log(value);
        var route="/AcopioFrutos/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {
                   'dac_id_acopio':$("#idaco").val(),
                   'dac_id_planta' :$("#planta").val(),
                   'dac_calibrefru' :$("#aco_calibrefru").val(),
                   'dac_ramhojafru':$("#aco_ramhojafru").val(),
                   'dac_dañadosfru' :$('#aco_dañadosfru').val(),
                   'dac_nomchofer':$('#aco_nomchofer').val(),
                   'dac_placa':$('#aco_placa').val(),
                   'dac_fecha_acop' :$('#fecha_acopio').val(),
                   'dac_id_tipofru' :$('#aco_id_tipofru').val(),
                   'dac_preciofru':$('#aco_preciofru').val(),
                   // 'aco_preciofru':$('#aco_cant_uni').val(),
                   'dac_preciofru' :$('#aco_preciofru').val(),
                   // 'aco_placa' :$('#aco_descartefru').val(),
                   'dac_cantaprob' :$('#aco_cant_uni').val(),
                   'dac_cantot' :$('#total').val(),
                   'dac_pesotot' :$('#totalpeso').val(),
                   'dac_estado' : 'C',
                   'dac_ci_chofer' :$('#cichofer').val(),
                   'dac_tipo_vehi' :$('#tipo_vehiculo').val(),
                   'dac_peso_fru' :$('#aco_pesofru').val(),
                   'dac_descant_fru' :$('#aco_descartefru').val(),
                   'dac_despeso_fru' :$('#aco_pesodescfru').val(),
                   'dac_id_rec' :$('#user').val(),
            },
            success: function(data){
                $("#myCreateRepFruto").modal('toggle');
                swal("El acopio!", "Fue registrado correctamente!", "success");
                $('#lts-acopio').DataTable().ajax.reload(); 
            },  error: function(result) {
                  console.log(result);
                 swal("Opss..!", "El acopio no se pudo registar intente de nuevo!", "error")
            }
        });
        });
 //FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN LISTADO   
    function MostrarProveedor(btn){
        var route = "/AcopioFrutos/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#cod_prov1").val(res.prov_id);
            $("#cod_nom1").val(res.prov_nombre);
            $("#cod_ap1").val(res.prov_ap);
            $("#cod_am1").val(res.prov_am);  
          });
    }
//FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN LISTADO   
    function MostrarCantidades2(){ 
        var route = "/AcopioFrutosSum";
        $.get(route, function(res){ 
            $("#cant_prov1").val(res[0].totprov1);
            $("#cant_fruta").val(res[0].totcantidad1);
            $("#cant_descarte").val(res[0].totdescorte1);
            $("#nombreCompleto").val(res[0].xprov_nombre);
       //     $("#cant_fruta1").val(res[0].cant1);
       //     $("#cant_fruta1").val(res[0].cant1);
        //    var val = $("#cant_descarte").val();
         //   console.log(val);
        });
    }

    function MostrarCantidades3(btn){ 
        var route = "/AcopioFrutosSumProv/"+btn.value+" ";
        $.get(route, function(res){ 
          //  $("#cant_prov1").val(res[0].totprov1);
            $("#provcant_fruta").val(res[0].xtotcantidad1);
            $("#provcant_descarte").val(res[0].xtotdescorte1);
            $("#provnombreCompleto").val(res[0].xpprov_nombre);
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
@endpush
