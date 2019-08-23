@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_frutos.proveedor.partials.modalCreate')
@include('backend.administracion.acopio.acopio_frutos.proveedor.partials.modalUpdate')


<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioFrutosMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">Proveedores de Frutos</label></h4>
                </div>
                <div class="col-md-2">
                <button class="btn fa fa-plus-square pull-right btn-dark"  onclick="LimpiarPersona();" data-target="#myCreate" data-toggle="modal">&nbsp;Nuevo</button>
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
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-proveedor" style="width:100%">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        Acciones
                                    </th>
                                    <th>
                                        Nombres
                                    </th>
                                    <th>
                                        Apellido Paterno
                                    </th>
                                    <th>
                                        Apellido Materno
                                    </th>
                                    <th>
                                        CÃ©dula
                                    </th>
                                    <th>
                                        Telefono
                                    </th>
                                    <th>
                                        Tipo Proveedor
                                    </th>
                                  <!--  <th>
                                        Foto
                                    </th>-->
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
    $('#lts-proveedor').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/ProveedorFrutos/create",
            "columns":[
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'nombreCompleto'},
                {data: 'prov_ap'},
                {data: 'prov_am'},
                {data: 'prov_ci'},
                {data: 'prov_tel'},
                {data: 'tipoProv'},
            ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });
    function MostrarPersona(btn){
        var route = "/ProveedorFrutos/"+btn.value+"/edit";
        console.log(route);
       // var rutaImagen= "imagenes/proveedores/miel/";
        $.get(route, function(res){
            $("#id1").val(res.prov_id);
            $("#nombres1").val(res.prov_nombre);
            $("#apellido_paterno1").val(res.prov_ap);
            $("#apellido_materno1").val(res.prov_am); 
            $("#ci1").val(res.prov_ci);
            $("#exp1").val(res.prov_exp); 
            $("#telefono1").val(res.prov_tel);
            $("#direccion1").val(res.prov_direccion);
            //$("#imagen1").val(res.prov_foto);
          //  $("#imagenProv").attr("src",rutaImagen+res.prov_foto);
            $("#nit1").val(res.prov_nit);
            $("#cuenta_bancaria1").val(res.prov_cuenta);
            $("#id_departamento1").val(res.prov_departamento);
            $("#id_municipio1").val(res.prov_id_municipio);
            $("#id_comunidad1").val(res.prov_id_comunidad);
            $("#id_asociacion1").val(res.prov_id_asociacion);
            $("#id_rau1").val(res.prov_rau);
            $("#id_tipo_prov1").val(res.prov_id_tipo);
            $("#id_convenio1").val(res.prov_id_convenio);
            $("#lugar_proveedor1").val(res.prov_lugar);
            $("#coordslng1").val(res.prov_longitud);
            $("#coordslat1").val(res.prov_latitud);
             
        });
    }
    $("#registro").click(function(){
        var route="/ProveedorFrutos";
         var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {
                    'nombres':$("#nombres").val(),
                    'apellido_paterno':$("#apellido_paterno").val(),
                    'apellido_materno':$("#apellido_materno").val(),
                    'ci':$("#ci").val(),
                    'exp':$("#exp").val(),
                    'telefono':$("#telefono").val(),
                    'direccion':$('#direccion').val(),
                    'id_departamento':$('#id_departamento').val(),
                    'id_tipo_prov':$('#id_tipo_prov').val(),
                    'id_convenio':$('#id_convenio').val(),
                    'prov_rau':$('#prov_rau').val(),
                    'provincia':$('#id_provincia').val(),
                    'com_nombre':$('#comunidad').val(),
                },
                success: function(data){
                    $("#myCreate").modal('toggle');
                    swal("El Proveedor!", "Se registrado correctamente!", "success");
                    $('#lts-proveedor').DataTable().ajax.reload();         
                },
                error: function(result) {
                    swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });

    $("#actualizar").click(function(){
        var value =$("#id1").val();
        var route="/ProveedorMiel/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {'prov_nombre':$("#nombres1").val(),'prov_ap':$("#apellido_paterno1").val(),'prov_am':$("#apellido_materno1").val(),'prov_ci':$("#ci1").val(),'prov_exp':$("#exp1").val(),'prov_tel':$("#telefono1").val(),'prov_direccion':$('#direccion1').val(),'prov_foto':$('#imagen1').val(),'prov_nit':$('#nit1').val(),'prov_cuenta':$('#cuenta_bancaria1').val(),'prov_departamento':$('#id_departamento1').val(),'prov_id_municipio':$('#id_municipio1').val(),'prov_id_comunidad':$('#id_comunidad1').val(),'prov_id_asociacion':$('#id_asociacion1').val(),'prov_rau':$('#id_rau1').val(),'prov_id_tipo':$('#id_tipo_prov1').val(),'prov_id_convenio':$('#id_convenio1').val(),'prov_lugar':$('#lugar_proveedor1').val(),'prov_latitud':$('#coordslat1').val(), 'prov_longitud': $('#coordslng1').val()},
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
        console.log($('#municipio').val());
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: { 'municipio':$("#municipio").val(),
                    'id_depto':$('#id_depto').val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#nuevoMunicipio").modal('toggle');
                    swal("El Municipio!", "Se ha registrado correctamente!", "success");
                    // $('#myCreate').ajax.reload();
                    
                },
                error: function(result) {
                    swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
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
            data: { 'comunidad':$("#comunidad").val(),
                    'id_municipio':$('#id_municipio').val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#nuevaComunidad").modal('toggle');
                    swal("La Comunidad!", "Se ha registrado correctamente!", "success");
                    // $('#myCreate').ajax.reload();
                    
                },
                error: function(result) {
                    swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
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
            data: { 'asociacion':$("#asociacion").val(),
                    'sigla':$("#sigla").val(),
                    'id_municipio':$('#id_municipio').val()},
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#nuevaAsociacion").modal('toggle');
                    swal("La Asocaciacion!", "Se ha registrado correctamente!", "success");
                    // $('#myCreate').ajax.reload();
                    
                },
                error: function(result) {
                    swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
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
                                    min: 1,
                                    max: 40,
                                      message: 'La persona requiere mas de 1 letras y un limite de 40'
                                },
                                regexp: {
                                    regexp: /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/,
                                    message: 'El nombre de la persona solo puede ser alfabetico'
                                }
                            }
                        },
                        apellido_paterno: {
                            message: 'El apellido paterno es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'Apellido paterno es obligatorio'
                                },
                                stringLength: {
                                    min: 1,
                                    max: 30,
                                    message: 'El apellido requiere mas de 1 caracteres y un limite de 30'
                                },
                                regexp: {
                                    // regexp: /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/,
                                    // message: 'El apellido de la persona solo puede ser alfabetico'
                                }
                            }
                        },
                        apellido_materno: {
                            message: 'El apellido materno es requerido',
                            validators: {
                                notEmpty: {
                                    message: 'Apellido materno es obligatorio'
                                },
                                stringLength: {
                                    min: 1,
                                    max: 30,
                                    message: 'El apellido requiere mas de 1 caracteres y un limite de 30'
                                },
                                regexp: {
                                    // regexp: /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/,
                                    // message: 'El apellido de la persona solo puede ser alfabetico'
                                }
                            }
                        },
                        ci: {
                            validators: {
                                notEmpty: {
                                    message: 'Carnet de identidad es requerido'
                                },
                                regexp: {
                                    regexp: /^[0-9]+$/,
                                    message: 'El ci tiene que ser numerico'
                                }
                            }
                        },

                        coordslat: {
                            validators: {
                                notEmpty: {
                                    message: 'Latitud es requerida'
                                },
                            }
                        },
                        coordslng: {
                            validators: {
                                notEmpty: {
                                    message: 'Longitud es requerida'
                                }
                            }
                        },
                        
                        telefono: {
                            validators: {
                                notEmpty: {
                                    message: 'Telefono es requerido'
                                },
                                regexp: {
                                    regexp: /^[0-9]+$/,
                                    message: 'El Nro de Telefono tiene que ser numerico'
                                }
                            }
                        },
                        cuenta_bancaria: {
                            validators: {
                                notEmpty: {
                                    message: 'Cuenta Bancaria es requerida'
                                }
                            }
                        },
                        direccion: {
                            validators: {
                                notEmpty: {
                                    message: 'direccion es requerida'
                                },
                            }
                        },
                      
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