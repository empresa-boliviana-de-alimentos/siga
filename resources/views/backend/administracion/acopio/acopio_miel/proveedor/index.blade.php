@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_miel.proveedor.partials.modalCreate')
@include('backend.administracion.acopio.acopio_miel.proveedor.partials.modalUpdate')
@include('backend.administracion.acopio.acopio_miel.proveedor.partials.modalContrato')
@include('backend.administracion.acopio.acopio_miel.proveedor.partials.modalListaContrato')
<style type="text/css">
#loader {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  background: rgba(0,0,0,0.75) url(img/loading.gif) no-repeat center center;
  z-index: 10000;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioMielMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">Proveedores de Miel</label></h4>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                <!-- <button class="btn fa fa-plus-square pull-right btn-dark"  onclick="LimpiarPersona();" data-target="#myCreate" data-toggle="modal">&nbsp;Nuevo</button> -->
                <a type="button" onclick="LimpiarPersona();" class="btn pull-right btn-default" data-target="#myCreate" data-toggle="modal" style="background: #616A6B"><h7 style="color:white">+&nbsp;&nbsp;NUEVO PROVEEDOR</h7></a>
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
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-proveedor">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        ACCIONES
                                    </th>
                                    <th>
                                        NOMBRES
                                    </th>
                                    <th>
                                        APELLIDO PATERNO
                                    </th>
                                    <th>
                                        APELLIDO MATERNO
                                    </th>
                                    <th>
                                        CI
                                    </th>
                                    <th>
                                        TELEFONO
                                    </th>
                                    <th>
                                        TIPO PROVEEDOR
                                    </th>
                                    <th>
                                        FOTO
                                    </th>
                                    <th>
                                        DOCUMENTO PDF
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
            </div>      
        </div>
</div>
<div id="loader"></div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {    
    var table = $('#lts-proveedor').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/ProveedorMiel/create",
            "columns":[
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'prov_nombre'},
                {data: 'prov_ap'},
                {data: 'prov_am'},
                {data: 'prov_ci'},
                {data: 'prov_tel'},
                {data: 'tipoProv'},
                {data: 'prov_foto',
                 'targets': [15,16],
      'searchable': false,
      'orderable':false,
      'render': function (data, type, full, meta) {
      return '<img src=imagenes/proveedores/miel/'+data+' style="height:100px;width:100px;"/>';
                        }
             },
             {data: 'prov_doc_pdf',
                 'targets': [15,16],
      'searchable': false,
      'orderable':false,
      'render': function (data, type, full, meta) {
        if (data == 'sin_doc_escaneado') {
            return 'NO HAY ARCHIVO';
        }else if(!data){
            return 'NO HAY ARCHIVO';
        }
      return '<a target="_blank" href="/documentosPDF/proveedores/miel/'+data+'" class="btn btn-primary btn-lg fa fa-file-pdf-o"> DOCUMENTOS<br>PDF</a>';
                        }
             },
                //{data: 'acciones',orderable: false, searchable: false},
                
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });
    $('#buscarnom').on( 'keyup', function () {
    table
        .columns( 1 )
        .search( this.value )
        .draw();
    } );

    $('#buscarpat').on( 'keyup', function () {
    table
        .columns( 2 )
        .search( this.value )
        .draw();
    } );

    $('#buscarmat').on( 'keyup', function () {
    table
        .columns( 3 )
        .search( this.value )
        .draw();
    } );
});

    function MostrarPersona(btn){
        var route = "/ProveedorMiel/"+btn.value+"/edit";
        var rutaImagen= "imagenes/proveedores/miel/";
        var rutaDoc = "documentosPDF/proveedores/miel/";
        $.get(route, function(res){
            $("#id1").val(res.prov_id);
            $("#nombres1").val(res.prov_nombre);
            $("#apellido_paterno1").val(res.prov_ap);
            $("#apellido_materno1").val(res.prov_am); 
            $("#ci1").val(res.prov_ci);
            $("#exp1").val(res.prov_exp); 
            $("#telefono1").val(res.prov_tel);
            $("#direccion1").val(res.prov_direccion);
            $("#imagen1").val(res.prov_foto);
            $("#imagenProv").attr("src",rutaImagen+res.prov_foto);
            $("#imagenActual").val(res.prov_foto);
            $("#doc_actual").attr("src",rutaDoc+res.prov_doc_pdf);
            $("#doc_actual_nombre").val(res.prov_doc_pdf);
            $("#nit1").val(res.prov_nit);
            $("#cuenta_bancaria1").val(res.prov_cuenta);
            $("#id_departamento1").val(res.prov_departamento);
            $("#id_municipio1").val(res.prov_id_municipio);
            $("#id_comunidad1").val(res.prov_id_comunidad);
            $("#id_asociacion1").val(res.prov_id_asociacion);
            $("#id_rau1").val(res.prov_rau);
            if ($("#id_rau1").val() == 2) {
                $('#dvOcultar1').hide();
            }else{
                $('#dvOcultar1').show();
            }
            $("#id_tipo_prov1").val(res.prov_id_tipo);
            if ($("#id_tipo_prov1").val() != 11) {
               $('#dvOcultar3').hide();
            } else if($("#id_tipo_prov1").val()==11){
                $('#dvOcultar3').show();
            } 
            $("#id_convenio1").val(res.prov_id_convenio);
            $("#lugar_proveedor1").val(res.prov_lugar);
            $("#coordslng1").val(res.prov_longitud);
            $("#coordslat1").val(res.prov_latitud);
            $(".img_file").val('');
            $("#img2").attr("src","");
            $("#img2").attr("title","");
            $(".archivo_pdf").val('');
            $("#viewer").attr("src","");
        });
    }
    // CONTRATOS
    function MostrarListaContratos(btn){
        var route = "listarContrato/"+btn.value;
        $.get(route, function(res){
            console.log(res[0]);
            document.getElementById("nombre_prov").innerHTML = res[0].prov_ap+' '+res[0].prov_am+' '+res[0].prov_nombre;
            $( "#TableContratos tbody tr" ).each( function(){ this.parentNode.removeChild( this ); }); 
              // var datosJson = JSON.parse(res);
              console.log('Total item: '+res.length);
                for (i = 0; i < res.length; i++){
                     $("#TableContratos").append('<tr class="items_columsReceta3">' + 
                        '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ res[i].contrato_nro + '"></input></td>'+
                        '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ res[i].contrato_precio + '"></input></td>'+
                        '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ res[i].contrato_deuda + '"></input></td>'+'</tr>');
                }
                itemAux = res;
        });
    }
    function MostrarProvContrato(btn){
        var route = "mostrarProvContra/"+btn.value;
        $("#nro_contrato_prov").val("");
        $("#precio_contrato").val("");
        $("#precio_cuotas").val("");
        $.get(route, function(res){
            console.log(res);
            $("#nombre_proveedor").val(res.prov_ap+' '+res.prov_am+' '+res.prov_nombre);
            $("#idProvContrato1").val(res.prov_id);
        });
    }
    $("#registroContrato").click(function(){
        var route="registrarContrato";
        var token =$("#token").val();
        console.log('Contrato Nro: '+ $("#nro_contrato_prov").val());
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'contrato_id_prov':$("#idProvContrato1").val(),
                    'contrato_nro':$("#nro_contrato_prov").val(),
                    'contrato_precio':$("#precio_contrato").val(),
                    'contrato_deuda':$("#precio_cuotas").val()},
                success: function(data){
                    $("#myContrato").modal('toggle');
                    swal("El contrato!", "Se registrado correctamente!", "success");
                    $('#lts-proveedor').DataTable().ajax.reload();
                    
                },
                error: function(result) {
                    swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });
    // END CONTRATOS
    var spinner = $('#loader');
    $("#registro").click(function(){
        var route="/ProveedorMiel";
         var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        console.log("REGISTRANDO AL PROVEEDOR");
        spinner.show();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            async:false,
            processData: false,
            contentType: false,
            data:new FormData($("#proveedor")[0]),
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    spinner.hide();
                    $("#myCreate").modal('toggle');
                    swal("El Proveedor!", "Se registrado correctamente!", "success");
                    $('#lts-proveedor').DataTable().ajax.reload();
                    
                },
                error: function(result) {
                    spinner.hide();
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
        var route="/ProveedorMielUpdate/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            async:false,
            processData: false,
            contentType: false,
            data:new FormData($("#proveedor1")[0]),
            success: function(data){
                $("#myUpdate").modal('toggle');
                swal("El proveedor!", "Fue actualizado correctamente!", "success");
                $('#lts-proveedor').DataTable().ajax.reload();
                
                 
            },  error: function(result) {
                  console.log(result);
                 swal("Opss..!", "El proveedor no se puedo actualizar intente de nuevo!", "error")
            }
        });
        });
    // $("#actualizar").click(function(){
    //     var value =$("#id1").val();
    //     var route="/ProveedorMiel/"+value+"";
    //     var token =$("#token").val();
    //     $.ajax({
    //         url: route,
    //         headers: {'X-CSRF-TOKEN': token},
    //         type: 'PUT',
    //         dataType: 'json',
    //         data: {'prov_nombre':$("#nombres1").val(),'prov_ap':$("#apellido_paterno1").val(),'prov_am':$("#apellido_materno1").val(),'prov_ci':$("#ci1").val(),'prov_exp':$("#exp1").val(),'prov_tel':$("#telefono1").val(),'prov_direccion':$('#direccion1').val(),'prov_foto':$('#imagen1').val(),'prov_nit':$('#nit1').val(),'prov_cuenta':$('#cuenta_bancaria1').val(),'prov_departamento':$('#id_departamento1').val(),'prov_id_municipio':$('#id_municipio1').val(),'prov_id_comunidad':$('#id_comunidad1').val(),'prov_id_asociacion':$('#id_asociacion1').val(),'prov_rau':$('#id_rau1').val(),'prov_id_tipo':$('#id_tipo_prov1').val(),'prov_id_convenio':$('#id_convenio1').val(),'prov_lugar':$('#lugar_proveedor1').val(),'prov_latitud':$('#coordslat1').val(), 'prov_longitud': $('#coordslng1').val()},
    //         success: function(data){
    //             $("#myUpdate").modal('toggle');
    //             swal("El proveedor!", "Fue actualizado correctamente!", "success");
    //             $('#lts-proveedor').DataTable().ajax.reload();
                
                 
    //         },  error: function(result) {
    //               console.log(result);
    //              swal("Opss..!", "El proveedor no se puedo actualizar intente de nuevo!", "error")
    //         }
    //     });
    //     });
    
    function Eliminar(btn){
    var route="/ProveedorMiel/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el proveedor?", 
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

    $("#registroMunicipio").click(function(){
        var route="/Municipio";
         var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        console.log($('#nombre_municipio').val());
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: { 'nombre_municipio':$("#nombre_municipio").val(),
                    'municipio_departamento':$('#id_depto').val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#nuevoMunicipio").modal('toggle');
                    swal("El Municipio!", "Se ha registrado correctamente!", "success");
                    // $('#myCreate').ajax.reload();                    
                },
                error: function(result) {                    
                    console.log(result);
                    if (result.responseText === "existe") {
                        swal("Opss..!", "Error, El municipio ya existe en el departamento, verifique bien por favor!", "error");
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
    $("#registroComunidad").click(function(){
        var route="/Comunidad";
         var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        // console.log($('#comunidad').val());
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: { 'nombre_comunidad':$("#nombre_comunidad").val(),
                    'com_municipio':$('#com_municipio').val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#nuevaComunidad").modal('toggle');
                    swal("La Comunidad!", "Se ha registrado correctamente!", "success");
                    // $('#myCreate').ajax.reload();
                    
                },
                error: function(result) {
                    // swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                    console.log(result);
                    if (result.responseText === "existe") {
                        swal("Opss..!", "Error, La comunidad ya existe en el municipio, verifique bien por favor!", "error");
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
    $("#registroAsociacion").click(function(){
        var route="/Asociacion";
         var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        // console.log($('#comunidad').val());
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: { 'nombre_asociacion':$("#nombre_asociacion").val(),
                    'sigla':$("#sigla").val(),
                    'aso_municipio':$('#aso_municipio').val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#nuevaAsociacion").modal('toggle');
                    swal("La Asocaciacion!", "Se ha registrado correctamente!", "success");
                    // $('#myCreate').ajax.reload();
                    
                },
                error: function(result) {
                    // swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                    console.log(result);
                    if (result.responseText === "existe") {
                        swal("Opss..!", "Error, La Asociacion ya existe en el municipio, verifique bien por favor!", "error");
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

    function LimpiarPersona()
    {
        $("#nombres").val("");
        $("#apellido_paterno").val("");
        $("#apellido_materno").val("");      
        $("#ci").val("");
        $("#coordslat").val("");
        $("#coordslng").val("");
        $("#telefono").val(""); 
        $("#direccion").val("");
        $("#nit").val("");         
        $("#cuenta_bancaria").val("");
        $("#departamento").val("");
        $("#municipio").val("");
        $("#comunidad").val("");
        $("#asociacion").val("");
        $("#tipo_proveedor").val("");
        var imagen =  document.getElementById("img-prov");
        imagen.className = "fileinput fileinput-new";
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
                $('#proveedor').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        nombres: {
                            message: 'La persona no es valida',
                            validators: {
                                notEmpty: {
                                    message: 'El nombre es requerida'
                                },
                                stringLength: {
                                    min: 3,
                                    max: 40,
                                      message: 'La persona requiere mas de 3 letras y un limite de 40'
                                },
                                regexp: {
                                    regexp: /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/,
                                    message: 'El nombre de la persona solo puede ser alfabetico'
                                }
                            }
                        },
                        
                        ci: {
                            validators: {
                                notEmpty: {
                                    message: 'Carnet de identidad es requerido'
                                }
                            }
                        }

                        
                    }
                });
            });
</script>

<script>
    var marker;
    var coords = {};
    //Funcion principal
    initMap = function () 
    {
        //usamos la API para geolocalizar el usuario
        navigator.geolocation.getCurrentPosition(
            function (position){
                coords = {
                    lng: position.coords.longitude,
                    lat: position.coords.latitude
                };
            setMapa(coords);//pasamos las coordenadas al metodo para crear mapa

            setMapa2(coords);//pasamos las coodenadas al metodo para crear mapa update

            }, function(error){console.log(error);});
    }

    function setMapa (coordslat, coordslng)
    {
        //se crea una nueva instancia del objeto mapa
        var map = new google.maps.Map(document.getElementById('map'),
        {
            zoom: 13,
            center: new google.maps.LatLng(coords.lat,coords.lng),
        }); 
        //Creamos el marcador en el mapa con sus propiedades
        //para nuestro objetivo tenemos que poner el atributo draggable en true
        //position pondremos las mismas Coordenadas que obtuvimos en la geolocalizacion
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: new google.maps.LatLng(coords.lat,coords.lng),
        });
        //agregamos un evento al marcador junto con la funcion callback al iguadragend que indica 
        //cuando el usuario a soltado el marcador
        marker.addListener('click', toggleBounce);
        marker.addListener('dragend', function(event)
        {
            //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
            document.getElementById("coordslat").value = this.getPosition().lat();
            document.getElementById("coordslng").value = this.getPosition().lng();
        });
    }

    function setMapa2(coordslat1, coordslng1)
    {
        //se crea una nueva instancia del objeto mapa
        var map = new google.maps.Map(document.getElementById('mapUpdate'),
        {
            zoom: 13,
            center: new google.maps.LatLng(coords.lat,coords.lng),
        }); 
        //Creamos el marcador en el mapa con sus propiedades
        //para nuestro objetivo tenemos que poner el atributo draggable en true
        //position pondremos las mismas Coordenadas que obtuvimos en la geolocalizacion
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: new google.maps.LatLng(coords.lat,coords.lng),
        });
        //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
        //cuando el usuario a soltado el marcador
        marker.addListener('click', toggleBounce);
        marker.addListener('dragend', function(event)
        {
            //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
            document.getElementById("coordslat1").value = this.getPosition().lat();
            document.getElementById("coordslng1").value = this.getPosition().lng();
        });
    }

    //callback al hacer click en el marcador lo que hace es quitar y poner la animacion BOUNCE
    function toggleBounce(){
        if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
        }else{
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }
    //Carga de la libreria de google maps
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQ8D5zq8vK9PnanQ36WW9-DpwI8vmtyB0&callback=initMap">
    </script>

@endpush