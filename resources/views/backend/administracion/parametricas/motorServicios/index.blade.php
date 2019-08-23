@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.parametricas.motorServicios.partials.modalCreate')
@include('backend.administracion.parametricas.motorServicios.partials.modalUpdate')
@include('backend.administracion.parametricas.motorServicios.partials.modalLlamada')
@include('backend.administracion.parametricas.motorServicios.partials.modalServicio')
@include('backend.administracion.parametricas.motorServicios.partials.modalImportar')

<div class="row">
    <div class="col-md-12">
        <section class="content-header">
            <div class="header_title">
                <h3>
                Servicios
                <small>
                    <button class="btn btn-primary fa fa-plus-square pull-right" data-target="#myCreate" data-toggle="modal" onClick="Limpiar();">&nbsp;Nuevo</button>
                     <button class="btn btn-info pull-right" data-target="#modalImportar" data-toggle="modal" data-placement="top"><i class="fa fa-upload"></i> <i class="fa fa-database"></i>&nbsp;Importar</button>
                <div class="col-md-offset-0"> 
                    <div class="col-sm-3"> 
                    </div> 
                    <label class="col-md-1"> Workspace:</label>   
                    <div class="col-sm-3" id="lista_workspace"> 
                    </div>
                    <div class="col-sm-3"> 
                    </div> 
                </div>
                </small>
                </h3>
            </div>
        </section>
    </div>
    <div id="listServicio">
</div>
</div>
<input id="mestadoMS" type="hidden" class="form-control">

@endsection
@push('scripts')
<script>
    function cargar_workspace(){
        cargando();
        var route="v1_0/motorServicios/lst_workspace";
          var htmlItems="";
          $.ajax({
            url: route,
                type: 'GET',
                dataType: 'json',
                data: {
                    
                },
                success: function(resp){
                    var data = resp.data;
                     htmlItems = '<select id="ctp_id" name="ctp_id"  class="form-control" onchange="MostrarServiciosCl(ctp_id.value)">';
                    for (var i = 0; i < data.length; i++) {
                      htmlItems += '<option value='+data[i].id_ctp+' name='+data[i].descripcion+'>'+data[i].descripcion +'</option>';
                    }
                    htmlItems += '</select>';
                    $('#lista_workspace').html(htmlItems);
                    $.LoadingOverlay("hide");
                },
                error: function(result) {
                    $.LoadingOverlay("hide");
                    swal("Opss..!", "Sucedio un problema al obtener los datos!", "error");
                }
        });
    }
    function MostrarServiciosCl (value) {
        //var id = $('#ctp_id').val();
        cargando();
        var htmlBoton="";
        htmlstServicio='';
        
        htmlstServicio+='<section class="content">';
        htmlstServicio+='<div class="tab-content">';
        htmlstServicio+='<div class="box-body">';
        htmlstServicio+='<table class="table table-hover table-striped table-bordered todolist" id="lst-motor1">';
        htmlstServicio+='<thead><tr><th>Opciones</th><th>ID</th><th>Nombre</th><th>Descripción</th><th>Endpoint / SP / Conexión</th><th>Argumentos</th><th>Exportar</th><th>Tipo</th></tr></thead>';
        $.LoadingOverlay("hide");

        var route1="v1_0/motorServicios/lst_servicios1";
        $.ajax({
            url: route1,
            type: 'POST',
            dataType: 'json',
            data: {
                "Workspace":value
            },
            success: function(data){
                data = data.Mensaje;
                var targ='';
                var datarg='';
                for (var i = 0; i < data.length; i++) {
                    targ='';
                    datarg=JSON.parse(data[i]._srv_argumentos);
                    for (key in datarg)
                    {
                        targ=targ+'('+key+'='+datarg[key]+')';
                    }

                    if(data[i]._srv_tipo_servicio == 'C'){
                    htmlstServicio+='<tr><td><button class="btncirculo" style="background:#29b6f6" data-target="#modalUpdate" data-toggle="modal" data-placement="top" onClick="editarServicio(' + data[i]._srv_id + ');" title="Modificar" type="button"><i class="glyphicon glyphicon-pencil"></i></button><button  class="btncirculo "   style="background:#ef5350" onClick="darBajaMotorServicio(' + data[i]._srv_id + ');" data-placement="top" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button></td>'+
                    '<td>'+ data[i]._srv_id+'</td>'+
                    '<td>'+ data[i]._srv_nombre+'</td>'+
                    '<td>'+ data[i]._srv_descripcion+'</td>';    
                    }else{
                       htmlstServicio+= '<tr><td><button class="btncirculo" style="background:#ffa726" data-target="#modalServicio" data-toggle="modal" data-placement="top" onClick="cargarServicio(' + data[i]._srv_id + ');" title="Ejecutar Servicio" type="button"><i class="fa fa-rocket"></i></button><button class="btncirculo" style="background:#29b6f6" data-target="#modalUpdate" data-toggle="modal" data-placement="top" onClick="editarServicio(' + data[i]._srv_id + ');" title="Modificar" type="button"><i class="glyphicon glyphicon-pencil"></i></button><button  class="btncirculo "   style="background:#ef5350" onClick="darBajaMotorServicio(' + data[i]._srv_id + ');" data-placement="top" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button></td>'+
                    '<td align="left">'+ data[i]._srv_id+'</td>'+
                    '<td align="left">'+ data[i]._srv_nombre+'</td>'+
                    '<td align="left">'+ data[i]._srv_descripcion+'</td>';
                    }

                    if(data[i]._srv_tipo_servicio == 'R'){htmlstServicio+='<td>'+ data[i]._srv_endpoint+' Método: '+data[i]._srv_verbo+'</td>';}
                    else if(data[i]._srv_tipo_servicio == 'S'){htmlstServicio+='<td>'+ data[i]._srv_sp+' DB: '+data[i]._srv_bd+'</td>';}
                    else if(data[i]._srv_tipo_servicio == 'C'){htmlstServicio+='<td>Conexión:'+ data[i]._srv_sp+'</td>';}
                    //htmlstServicio+='<td>'+ data[i]._srv_argumentos +'</td>';
                    htmlstServicio+='<td>'+ targ +'</td>';
                    //'<td align="left">'+ data[i]._srv_argumentos+'</td>';
                    htmlstServicio+='<td><a class="btn btn-info btn-circle" onClick="exportarServicio(' + data[i]._srv_id + ');" type="button"><i class="fa fa-download"  title="Exportar Servicio" ></i> <i class="fa fa-database"  title="Exportar Servicio"></i></a></td>';
                    if(data[i]._srv_tipo_servicio == 'R'){htmlstServicio+='<td><i class="fa fa-circle" style="color:#64dd17"></i>&nbsp;REST</td>';
                    }else if(data[i]._srv_tipo_servicio == 'S'){htmlstServicio+='<td align=left><i class="fa fa-circle" style="color:#ff9800"></i>&nbsp;SP</td>';}
                    else if(data[i]._srv_tipo_servicio == 'C'){htmlstServicio+='<td align=left><i class="fa fa-circle" style="color:#03A9F4"></i>&nbsp;CONN</td>';}
                    '</tr>';

                }
                htmlstServicio +='</table>';
                htmlstServicio +='</div>';
                htmlstServicio +='</div>';
                //htmlstRegla +='</div>';
                htmlstServicio +='</section>';
                $('#listServicio').html(htmlstServicio);
                $('#lst-motor1').DataTable( {
                    "language": {
                        "url": "lenguaje"
                    },
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                });
            },
            error: function(result) {
                $.LoadingOverlay("hide");
                swal("Error..!", "Verifique que los campos esten llenados Gracias...!", "error");
            }
        });
    }


    
    function descargarArchivo(contenidoEnBlob, nombreArchivo) 
    {
        var reader = new FileReader();
        reader.onload = function (event) 
        {
            var save = document.createElement('a');
            save.href = event.target.result;
            save.target = '_blank';
            save.download = nombreArchivo || 'archivo.dat';
            var clicEvent = new MouseEvent('click',
            {
                'view': window,
                'bubbles': true,
                'cancelable': true
            });
            save.dispatchEvent(clicEvent);
            (window.URL || window.webkitURL).revokeObjectURL(save.href);
        };
        reader.readAsDataURL(contenidoEnBlob);
    };

    function generarTexto(data)
    {
        var texto = [];
        texto.push(data);
        return new Blob(texto, { type: 'text/plain'});
    };

    function exportarServicio($id) 
    {
        var value = '';
        var id    = $id;
        var route = "v1_0/motorServicios/getExportar/"+id;
        swal({   title: "Esta seguro de realizar la Exportación?",
            text: "Presione ok para la Exportación del Servicio de la Base de Datos!",
            type: "warning",   showCancelButton: true,
            confirmButtonColor: "#58d68d",
            confirmButtonText: "Si, Exportar!",
            closeOnConfirm: false
        }, function(){
            $.ajax({                        
               type: "GET",                 
               url: route,                      
               success: function(data)             
                {
                    value=JSON.stringify(data);
                    var nombre_txt = 'motor.txt'
                    descargarArchivo(generarTexto(value), nombre_txt);
                    swal("Servicio!", " Exportación realizada correctamente!", "success");
                },
                error: function(result)
                {
                    console.log('error',result);  
                }
            });
        });
        

        
    }

    function cargando(){
      var texto   = $("<div>", {
             text    : "PROCESANDO....",
                id      : "myEstilo",
                css     : {
                "font-size" : "30px",
                    "position": "relative",
                    "width": "500px",
                    "height": "300px",
                    "left": "180px",
                    "top":"50px"
                },
                fontawesome : "fa fa-spinner"
            });
            $.LoadingOverlay("show",{
                    custom  : texto,
                    color:"rgba(255, 255, 255, 0.8)",
            });
    }

    $('#lst-motor').DataTable({
        "fixedHeader": true,
        "processing": true,
        "serverSide": true,
        "destroy":true,
        "responsive": true,
        "ajax": "v1_0/motorServicios/lst_motor_servicios",
        "columns":[
                    {data: 'acciones', orderable: false, searchable: false},
                    {data: '_srv_id'},
                    {data: '_srv_nombre'},
                    {data: '_srv_descripcion'},
                    {data: '_EnSPConn'},
                    {data: '_srv_arg'},
                    {data: '_tipo'},
        ],
        "language": {
            "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    /*
    function listaMotor(dato){
        var htmlListaSuc="";
cargando();
        var id= "";

        htmlListaSuc+='<div class="row">';
        htmlListaSuc+='<div class="col-md-12 table-responsive">' ;
        htmlListaSuc+='<table id="lsta-motoresbd" class="table table-hover table-striped table-bordered todolist" cellspacing="0" width="100%" >';
        htmlListaSuc+='<thead style="background: linear-gradient(#e8f5e9,#2e7d32);-webkit-background-clip: background;color: #000000;"><tr><th>Opciones</th><th>ID</th><th>Nombre</th><th>Descripción</th><th>Endpoint / SP / Conexión</th><th>Argumentos</th><th>Tipo</th></tr></thead>';

        var route1="v1_0/motorServicios/lst_motor_servicios";
        $.ajax({
            url: route1,
            type: 'GET',
            dataType: 'json',
            data: {
            },
            success: function(data){
                cargando();
                var targ='';
var datarg='';
                for (var i = 0; i < data.length; i++) {
                    var lineas = JSON.parse(data[i]._srv_data);
                    var prop = JSON.parse(data[i]._srv_propiedades);
                    //var arg=JSON.parse(lineas.srv_argumentos);
                    targ='';
datarg=lineas.srv_argumentos;
                    for (key in datarg)
                    {
                        targ=targ+'('+key+'='+datarg[key]+') ';
                    }
                    var recopilado = '';
                    var recopilado1 = '';
                    if(lineas.srv_tipo_servicio == 'C')
                    {
                    htmlListaSuc+='<tr><td><button class="btncirculo" style="background:#29b6f6" data-target="#modalUpdate" data-toggle="modal" data-placement="top" onClick="editarServicio(' + data[i]._srv_id + ');" title="Modificar" type="button"><i class="glyphicon glyphicon-pencil"></i></button><button  class="btncirculo "   style="background:#ef5350" onClick="darBajaMotorServicio(' + data[i]._srv_id + ');" data-placement="top" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button></td>'+
                    '<td>' + data[i]._srv_id + '</td>' +
                    '<td>' + prop.srv_nombre + '</td>' +
                    '<td>' + prop.srv_descripcion + '</td>';
                    }
                    else
                    {
                    htmlListaSuc+='<tr><td><button class="btncirculo" style="background:#ffa726" data-target="#modalServicio" data-toggle="modal" data-placement="top" onClick="cargarServicio(' + data[i]._srv_id + ');" title="Ejecutar Servicio" type="button"><i class="fa fa-rocket"></i></button><button class="btncirculo" style="background:#29b6f6" data-target="#modalUpdate" data-toggle="modal" data-placement="top" onClick="editarServicio(' + data[i]._srv_id + ');" title="Modificar" type="button"><i class="glyphicon glyphicon-pencil"></i></button><button  class="btncirculo "   style="background:#ef5350" onClick="darBajaMotorServicio(' + data[i]._srv_id + ');" data-placement="top" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button></td>'+
                    '<td>' + data[i]._srv_id + '</td>' +
                    '<td>' + prop.srv_nombre + '</td>' +
                    '<td>' + prop.srv_descripcion + '</td>';
                    }

                    if(lineas.srv_tipo_servicio == 'R'){htmlListaSuc+='<td>'+ lineas.srv_endpoint+' Metodo: '+lineas.srv_endpoint_verbo+'</td>';}
                    else if(lineas.srv_tipo_servicio == 'S'){htmlListaSuc+='<td>'+ lineas.srv_sp+' DB: '+lineas.srv_bd+'</td>';}
                    else if(lineas.srv_tipo_servicio == 'C'){htmlListaSuc+='<td>Cadena de conexión \"'+ lineas.srv_sp+'\"</td>';}
                    htmlListaSuc+='<td>'+ targ +'</td>';
                    if(lineas.srv_tipo_servicio == 'R'){htmlListaSuc+='<td align=center><i class="fa fa-circle" style="color:#64dd17"></i>&nbsp;REST</td>';}
                    else if(lineas.srv_tipo_servicio == 'S'){htmlListaSuc+='<td align=center><i class="fa fa-circle" style="color:#ff9800"></i>&nbsp;SP</td>';}
                    else if(lineas.srv_tipo_servicio == 'C'){htmlListaSuc+='<td align=center><i class="fa fa-circle" style="color:#03A9F4"></i>&nbsp;CONN</td>';}
                }
                $.LoadingOverlay("hide");
                htmlListaSuc +='</tr></table>';
                htmlListaSuc +='</div>';
                htmlListaSuc +='</div>';
                htmlListaSuc +='</div>';
                $('#lst-motor').html(htmlListaSuc);
                $('#lsta-motoresbd').DataTable( {
                    "fixedHeader": true,
                    "destroy":true,
                    "responsive": true,
                    "processing": true,
                    "language": {
                        "url": "lenguaje"
                    },
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                });
                $.LoadingOverlay("hide");
            },
            error: function(result) {
                $.LoadingOverlay("hide");
                swal("Error!", "Sucedio un problema al recibir los datos!", "error");
            }
        });
    }*/

    $(document).ready(function (){
       MostrarServiciosCl(0);
       cargar_workspace();
       
    });

    function ActualizarRegistro(){
        if($("#nombre1").val() == '')
        {
            swal("Alerta!", "El nombre es requerido para el motor de servicio.", "warning");
        }
        else if($("#tiposer1").val() == 'N')
        {
         swal("Alerta!", "Debe seleccionar un Tipo de Servicio!", "warning");
        }
        else {
            cargando();
            var route1="v1_0/motorServicios/actualizarServicio";
            var objetoArgumento = {};
            for (var i = 0; i<arrCodigo.length; i++) {
              if($("#tipoarg"+arrDibujo[i].id+"").val() == 'S') {
                objetoArgumento[''+$("#clave"+arrDibujo[i].id+"").val()] = '\''+$("#valor"+arrDibujo[i].id+"").val()+'\'';
              } else {
                objetoArgumento[''+$("#clave"+arrDibujo[i].id+"").val()] = $("#valor"+arrDibujo[i].id+"").val();
              }
            }
            var prop = {srv_nombre: $("#nombre1").val(),srv_descripcion: $("#descripcion1").val()};
            if($("#tiposer1").val() == 'S' || $("#tiposer1").val() == 'C') {
                $db = $("#s_dbC").val();
                $sp = $("#s_spC").val();
                $host = $("#s_hostC").val();
                $clave = $("#s_claveC").val();
                $gestor = $("#s_gestorC").val();
                $puerto = $("#s_puertoC").val();
                $usuario = $("#s_usuarioC").val();
                $endpoint = "";
                $verboser = "";
            }
            else if($("#tiposer1").val() == 'R') {
                $db = "";
                $sp = "";
                $host = "";
                $clave = "";
                $gestor = "";
                $puerto = "";
                $usuario = "";
                $endpoint = $("#s_endponitC").val();
                $verboser = $("#s_endpointverboC").val();
            }
            srv_data = {
                "srv_bd": $db,
                "srv_sp": $sp,
                "srv_host": $host,
                "srv_clave": $clave,
                "srv_gestor": $gestor,
                "srv_puerto": $puerto,
                "srv_usuario": $usuario,
                "srv_endpoint": $endpoint,
                "srv_argumentos": objetoArgumento,
                "srv_tipo_servicio": $("#tiposer1").val(),
                "srv_endpoint_verbo": $verboser
            };
            datos_con = {
                "srv_bd": $db,
                "srv_host": $host,
                "srv_clave": $clave,
                "srv_gestor": $gestor,
                "srv_puerto": $puerto,
                "srv_usuario": $usuario,
            };
            $.ajax({
              url: route1,
              headers: {'X-CSRF-TOKEN': $("#token").val()},
              type: 'POST',
              dataType: 'json',
              data: {
               "id":$("#upid").val(),
               "datos":JSON.stringify(srv_data),
               "propiedades":JSON.stringify(prop)
              },
              success: function(data){
                  $.LoadingOverlay("hide");
                  $('#motorUP').data('bootstrapValidator').resetForm();
                  $("#modalUpdate").modal('toggle');
                  swal("Servicio!", "Fue actualizada correctamente!", "success");
                  $('#lst-motor').DataTable().ajax.reload(null,false);
                  location.reload();
                },
              error: function(result) {
                  $.LoadingOverlay("hide");
                  swal("Error!", "Sucedio un problema al actualizar los datos!", "error");
              }
            });    
            
            
        }
    }

    function darBajaMotorServicio(nro_editar){
        var route1="v1_0/motorServicios/darBajaMotorServicio";
        swal({   title: "Esta seguro de eliminar el Servicio?",
            text: "Presione ok para dar de baja el Servicio de la Base de Datos!",
            type: "warning",   showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Eliminar!",
            closeOnConfirm: false
        }, function(){
        $.ajax({
                url: route1,
                type: 'POST',
                dataType: 'json',
                data: {
                  "idServicio":nro_editar
              },
              success: function(data){
                $.LoadingOverlay("hide");
                swal("Servicio!", " Fue Eliminada correctamente!", "success");
                $('#lst-motor').DataTable().ajax.reload(null,false);
                location.reload(true);

            },
            error: function(result) {
                $.LoadingOverlay("hide");
                swal("Error!", "Sucedio un problema al dar de baja los datos!", "error");
            }
        });
     });
    }

    function editarServicio($nro_editar){
        var route1="v1_0/motorServicios/get_Dato_Servicio/"+$nro_editar;
        $.ajax({
          url: route1,
          type: 'GET',
          dataType: 'json',
          data: {
          },
          success: function(data){
                Limpiar();
                $('#mestadoMS').val('U');
                $("#nombre1").val(data[0]._ser_nombre);
                $("#descripcion1").val(data[0]._ser_descripcion);

                CrearServicio(data[0]._ser_tipo_servicio);
                $("#upid").val(data[0]._ser_id);
                $("#tiposer1").val(data[0]._ser_tipo_servicio);
                if(data[0]._ser_tipo_servicio=='R')
                {
                    $("#s_endponitC").val(data[0]._ser_endpoint);
                    $("#s_endpointverboC").val(data[0]._ser_endpoint_verbo);
                    $("#s_dbC").val('');
                    $("#s_spC").val('');
                    $("#s_hostC").val('');
                    $("#s_claveC").val('');
                    $("#s_gestorC").val('');
                    $("#s_puertoC").val('');
                    $("#s_usuarioC").val('');
                }
                else
                {
                    $("#s_dbC").val(data[0]._ser_bd);
                    $("#s_spC").val(data[0]._ser_sp);
                    $("#s_hostC").val(data[0]._ser_host);
                    $("#s_claveC").val(data[0]._ser_clave);
                    $("#s_gestorC").val(data[0]._ser_gestor);
                    $("#s_puertoC").val(data[0]._ser_puerto);
                    $("#s_usuarioC").val(data[0]._ser_usuario);
                    $("#s_endponitC").val('');
                    $("#s_endpointverboC").val('');
                }


                var argumentos = JSON.parse(data[0]._ser_argumentos);
                var htmlARG="";
                var cadena='';
                var cont=0;
                var tipoA='';
                cadena='';
                cont=0;
                arrDibujo.forEach(function (item, index, array)
                {
                    arrCodigo[cont].arg_clave=$("#clave"+item.id+"").val();
                    arrCodigo[cont].arg_valor=$("#valor"+item.id+"").val();
                    arrCodigo[cont].arg_tipo=$("#tipoarg"+item.id+"").val();
                    cont=cont+1;
                });
                for (key in argumentos)
                {
                    htmlARG=' Título:</label>'+
                    '<div class="col-md-3">'+
                        '<input class="form-control" id="clave'+contCodigo+'" name="clave" ></input>'+
                    '</div>'+
                    '<label class="col-md-1" for="">Valor:</label>'+
                    '<div class="col-md-3">'+
                        '<input class="form-control" id="valor'+contCodigo+'" name="valor" ></input>'+
                    '</div>'+
                    '<label class="col-md-1">Tipo :</label>'+
                    '<div class="col-md-2">'+
                        '<select class="form-control" id="tipoarg'+contCodigo+'" name="tipoarg'+contCodigo+'">'+
                            '<option value="N" selected="selected">--Seleccione--</option>'+
                            '<option value="I">Entero</option>'+
                            '<option value="S">Cadena</option>'+
                        '</select>'+
                    '</div><div class="col-md-1">'+
                    '<a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-trash fa-2x fa-fw" style="color:#ef5350" title="Eliminar argumento" onclick="menosLinea('+contCodigo+');"></i>'+
                    '</a></div></div>';

                    if(argumentos[key].indexOf("\'") > -1){tipoA='S';}else{tipoA='I';}
                    arrCodigo.push({arg_clave:key,arg_valor:argumentos[key].replace(/['"]+/g, ""),arg_tipo:tipoA});
                    arrDibujo.push({scd_codigo:htmlARG,id: contCodigo});
                    contCodigo++;
                }

                cont=1;
                for (var i=0; i<arrDibujo.length;i++)
                {
                    cadena=cadena + '<div class="form-group"><label class="col-md-1">'+cont+arrDibujo[i].scd_codigo;
                    cont++;
                }
                $('#upargumentopintarCrear').html(cadena);

                cont=0;
                arrDibujo.forEach(function (item, index, array)
                {
                    $("#clave"+item.id+"").val(arrCodigo[cont].arg_clave);
                    //$("#clave"+item.id+"").val(titulo[cont]);
                    $("#valor"+item.id+"").val(arrCodigo[cont].arg_valor);
                    $("#tipoarg"+item.id+"").val(arrCodigo[cont].arg_tipo);
                    cont=cont+1;
                });
            },
            error: function(result) {
                swal("Error!", "Sucedio un problema al cargar la información!", "error");
            }
        });
    }

    function Limpiar()
    {
        $('#mestadoMS').val('N');
        $("#s_dbC").val("");
        $("#s_spC").val("");
        $("#s_hostC").val("");
        $("#s_claveC").val("");
        $("#s_gestorC").val("");
        $("#s_puertoC").val("");
        $("#s_usuarioC").val("");
        $("#s_endponitC").val("");
        $("#tiposer").val("N");
        $("#s_endpointverboC").val("N");
        $("#s_nombreC").val("");
        $("#s_descripcionC").val("");
        contCodigo=1;
        arrCodigo=[];
        arrDibujo=[];
        var e = document.getElementById("cabeceraCrear");
        while (e.hasChildNodes())
        {e.removeChild(e.firstChild);}
        $("#argumentopintarCrear").html('');
        var e = document.getElementById("upcabeceraCrear");
        while (e.hasChildNodes())
        {e.removeChild(e.firstChild);}
        $("#upargumentopintarCrear").html('');
        $('#motor').data('bootstrapValidator').resetForm();
        $('#motorUP').data('bootstrapValidator').resetForm();
    }


    function CrearServicio($tipo) {
        //alert($tipo);
        htmlcabecera = "";
        if ($tipo =='R') {
            htmlcabecera='<div class="form-group"><div class="col-md-9" >'+
            '<label class="control-label">'+
            'Endpoint:'+
            '</label>'+
            '<input class="form-control" id="s_endponitC" name="s_endponitC" placeholder="" type="text" ></input>'+
            '</div>'+
            '<div class="col-md-3" >'+
            '<label class="control-label">'+
            'Endpoint Verbo:'+
            '</label>'+
            '<select class="form-control" id="s_endpointverboC" name="s_endpointverboC">'+
                '<option value="N" selected="selected">-- Seleccionar --</option>'+
                '<option value="GET">GET</option>'+
                '<option value="POST">POST</option>'+
                '<option value="PUT">PUT</option>'+
            '</select>'+
            '</div></div>';
            document.getElementById('argCrear').style.display = 'block';
            document.getElementById('argCrearUP').style.display = 'block';
            $('#idboton').html('');
            $('#idbotonUP').html('');
            $('#serviciocomboN').html('');
            $('#serviciocomboU').html('');
        }
        else if ($tipo =='S') {
            htmlcabecera='<div class="form-group">'+
            '<div class="col-md-3" >'+
            '<label class="control-label">'+
            'Gestor BD:'+
            '</label>'+
            '<select class="form-control" id="s_gestorC" name="s_gestorC">'+
                '<option value="N" selected="selected">-- Seleccionar --</option>'+
                '<option value="postgres">postgres</option>'+
                '<option value="mssql">mssql</option>'+
                '<option value="mysql">mysql</option>'+
                '<option value="mongodb">mongodb</option>'+
            '</select>'+
            '</div>'+
            '<div class="col-md-3" >'+
            '<label class="control-label">'+
            'Base de Datos:'+
            '</label>'+
            '<input class="form-control" id="s_dbC" name="s_dbC" placeholder="" type="text" ></input>'+
            '</div>'+
            '<div class="col-md-3" >'+
            '<label class="control-label">'+
            'Host:'+
            '</label>'+
            '<input class="form-control" id="s_hostC" name="s_hostC" placeholder="" type="text" ></input>'+
            '</div>'+
            '<div class="col-md-3" >'+
            '<label class="control-label">'+
            'Puerto:'+
            '</label>'+
            '<input class="form-control" id="s_puertoC" name="s_puertoC" placeholder="" type="text" ></input>'+
            '</div></div>'+
            '<div class="form-group"><div class="col-md-4" >'+
            '<label class="control-label">'+
            'Servicio:'+
            '</label>'+
            '<div id="procedimientoSP"></div>'+
            '</div>'+
            '<div class="col-md-4" >'+
            '<label class="control-label">'+
            'Usuario:'+
            '</label>'+
            '<input class="form-control" id="s_usuarioC" name="s_usuarioC" placeholder="" type="text" ></input>'+
            '</div>'+
            '<div class="col-md-4" >'+
            '<label class="control-label">'+
            'Clave:'+
            '</label>'+
            '<input class="form-control" id="s_claveC" name="s_claveC" placeholder="" type="password" ></input>'+
            '</div></div>';

            SeleccionarServicios();
            if($('#mestadoMS').val()=='N')
            {$('#idboton').html('<a type = "button" class = "btn btn-warning" id="conecter" onclick="conexionDB();">Conectear DB</a>');document.getElementById('argCrear').style.display = 'block';}
            else
            {$('#idbotonUP').html('<a type = "button" class = "btn btn-warning" id="conecter" onclick="conexionDB();">Conectear DB</a>');document.getElementById('argCrearUP').style.display = 'block';}
        }
        else if ($tipo =='C') {
            htmlcabecera='<div class="form-group">'+
            '<div class="col-md-3" >'+
            '<label class="control-label">'+
            'Gestor BD:'+
            '</label>'+
            
            '<select class="form-control" id="s_gestorC" name="s_gestorC">'+
                '<option value="N" selected="selected">-- Seleccionar --</option>'+
                '<option value="postgres">postgres</option>'+
                '<option value="mssql">mssql</option>'+
                '<option value="mysql">mysql</option>'+
                '<option value="mongodb">mongodb</option>'+
            '</select>'+
            '</div>'+
            '<div class="col-md-3" >'+
            '<label class="control-label">'+
            'Base de Datos:'+
            '</label>'+
            '<input class="form-control" id="s_dbC" name="s_dbC" placeholder="" type="text" ></input>'+
            '</div>'+
            '<div class="col-md-3" >'+
            '<label class="control-label">'+
            'Host:'+
            '</label>'+
            '<input class="form-control" id="s_hostC" name="s_hostC" placeholder="" type="text" ></input>'+
            '</div>'+
            '<div class="col-md-3" >'+
            '<label class="control-label">'+
            'Puerto:'+
            '</label>'+
            '<input class="form-control" id="s_puertoC" name="s_puertoC" placeholder="" type="text" ></input>'+
            '</div></div>'+
            '<div class="form-group">'+
            '<div class="col-md-6" >'+
            '<input class="form-control" id="s_spC" name="s_spC" placeholder="" type="hidden" ></input>'+
            '<label class="control-label">'+
            'Usuario:'+
            '</label>'+
            '<input class="form-control" id="s_usuarioC" name="s_usuarioC" placeholder="" type="text" ></input>'+
            '</div>'+
            '<div class="col-md-6" >'+
            '<label class="control-label">'+
            'Clave:'+
            '</label>'+
            '<input class="form-control" id="s_claveC" name="s_claveC" placeholder="" type="password" ></input>'+
            '</div></div>';


            if($('#mestadoMS').val()=='N')
            {$('#idboton').html('<a type = "button" class = "btn btn-warning" id="conecter" onclick="conexionDB();">Conectear DB</a>');document.getElementById('argCrear').style.display = 'none';$('#serviciocomboN').html('');}
            else
            {$('#idbotonUP').html('<a type = "button" class = "btn btn-warning" id="conecter" onclick="conexionDB();">Conectear DB</a>');document.getElementById('argCrearUP').style.display = 'none';$('#serviciocomboU').html('');}
        }
        else {
            htmlcabecera='<div class="form-group"></div>';
        }
        if($('#mestadoMS').val()=='N')
        {$('#cabeceraCrear').html(htmlcabecera);}
        else
        {$('#upcabeceraCrear').html(htmlcabecera);}

        if($tipo =='S')$('#procedimientoSP').html('<input class="form-control" id="s_spC" name="s_spC" placeholder="" type="text" ></input>');
    }

    function cargarServicio($id){
        var route = "v1_0/motorServicios/getRestDinamico/"+$id;
        $.get(route, function(res){
            var nuevoarg = new Object();
            var htmlcabecera="";
datoargt=[];
            $("#tipo").val(res.data[0]._ser_tipo_servicio);
            if (res.data[0]._ser_tipo_servicio =='R')
            {
                htmlcabecera='<div class="form-group"><div class="col-md-8" >'+
                '<label class="control-label">'+
                'Endpoint:'+
                '</label>'+
                '<input class="form-control" id="s_endponit" name="s_endponit" placeholder="" type="text" value="'+res.data[0]._ser_endpoint+'" readonly></input>'+
                '</div>'+
                '<div class="col-md-4" >'+
                '<label class="control-label">'+
                'Endpoint Verbo:'+
                '</label>'+
                '<input class="form-control" id="s_endpointverbo" name="s_endpointverbo" placeholder="" type="text" value="'+res.data[0]._ser_endpoint_verbo+'" readonly></input>'+
                '</div></div>';
                $('#cabecera').html(htmlcabecera);
                var argumentos=JSON.parse(res.data[0]._ser_argumentos);
                var htmlARG="";
var i=1;
var dime =false;
                for (key in argumentos)
                {
                    nuevoarg[key]= argumentos[key];
                    if(multiple(i,4)==true || i==1){htmlARG=htmlARG+'<div class="form-group">';}
                    htmlARG=htmlARG+'<div class="col-md-3">'+
                    '<label>'+key+':'+
                    '</label>'+
                    '<div class="">'+
                    '<input class="form-control" id="sr_'+key+'" name="sr_'+key+'" placeholder="" type="text" value="'+argumentos[key]+'">'+
                    '</input>'+
                    '</div>'+
                    '</div>';
                    if(multiple(i,4)){htmlARG=htmlARG+'</div>';}
                    i++;
                }
                datoargt.push(nuevoarg);
                $('#argumentopintar').html(htmlARG);
            }
            else
            {
                htmlcabecera='<div class="form-group">'+
                '<div class="col-md-3" >'+
                '<label class="control-label">'+
                'Gestor BD:'+
                '</label>'+
                '<input class="form-control" id="s_gestor" name="s_gestor" placeholder="" type="text" value="'+res.data[0]._ser_gestor+'" readonly></input>'+
                '</div>'+
                '<div class="col-md-3" >'+
                '<label class="control-label">'+
                'Base de Datos:'+
                '</label>'+
                '<input class="form-control" id="s_db" name="s_db" placeholder="" type="text" value="'+res.data[0]._ser_bd+'" readonly></input>'+
                '</div>'+
                '<div class="col-md-3" >'+
                '<label class="control-label">'+
                'Host:'+
                '</label>'+
                '<input class="form-control" id="s_host" name="s_host" placeholder="" type="text" value="'+res.data[0]._ser_host+'" readonly></input>'+
                '</div>'+
                '<div class="col-md-3" >'+
                '<label class="control-label">'+
                'Puerto:'+
                '</label>'+
                '<input class="form-control" id="s_puerto" name="s_puerto" placeholder="" type="text" value="'+res.data[0]._ser_puerto+'" readonly></input>'+
                '</div></div>'+
                '<div class="form-group"><div class="col-md-4" >'+
                '<label class="control-label">'+
                'Servicio:'+
                '</label>'+
                '<input class="form-control" id="s_sp" name="s_sp" placeholder="" type="text" value="'+res.data[0]._ser_sp+'" readonly></input>'+
                '</div>'+
                '<div class="col-md-4" >'+
                '<label class="control-label">'+
                'Usuario:'+
                '</label>'+
                '<input class="form-control" id="s_usuario" name="s_usuario" placeholder="" type="text" value="'+res.data[0]._ser_usuario+'" readonly></input>'+
                '</div>'+
                '<div class="col-md-4" >'+
                '<label class="control-label">'+
                'Clave:'+
                '</label>'+
                '<input class="form-control" id="s_clave" name="s_clave" placeholder="" type="password" value="'+res.data[0]._ser_clave+'" readonly></input>'+
                '</div></div>';
                $('#cabecera').html(htmlcabecera);

                var argumentos=JSON.parse(res.data[0]._ser_argumentos);
                var htmlARG="";
                var i=1;
                var dime =false;
                for (key in argumentos)
                {
                    nuevoarg[key]= argumentos[key];
                    if(multiple(i,4)==true || i==1){htmlARG=htmlARG+'<div class="form-group">';}
                    htmlARG=htmlARG+'<div class="col-md-3">'+
                    '<label>'+key+':'+
                    '</label>'+
                    '<div class="">'+
                    '<input class="form-control" id="sr_'+key+'" name="sr_'+key+'" placeholder="" type="text" value="'+argumentos[key]+'">'+
                    '</input>'+
                    '</div>'+
                    '</div>';
                    if(multiple(i,4)){htmlARG=htmlARG+'</div>';}
                    i++;
                }
                datoargt.push(nuevoarg);
                $('#argumentopintar').html(htmlARG);
            }
        });
    }

    function llamarServicio(){
        var condicion =$("#tipo").val();
cargando();
        var arg1= new Object();
        if(condicion=='R')
        {
            var argumentos=JSON.parse(JSON.stringify(datoargt[0]));
            for (key in argumentos)
            {
                arg1[key]=$("#sr_"+key+"").val();
            }
            var route="v1_0/motorServicios/ejcutar_REST_API";
            var token =$("#token").val();
            $.ajax({
              url: route,
              headers: {},
              type: 'GET',
              dataType: 'json',
              data: {'metodo':$("#s_endpointverbo").val(),
              'url':$("#s_endponit").val(),
              'argumentos':JSON.stringify(arg1)},
                success: function(data){
                    $.LoadingOverlay("hide");
                    $("#modalLlamada").modal("show");
                    $("#sr_dato").val(JSON.stringify(data));
                },
                error: function(result) {
                    console.log('Error: ',result);
                    $.LoadingOverlay("hide");
                    swal("Error!", "Succedio un problema al ejecutar el servicio!", "error");
              }
          });
        }
        else
        {
            var argumentos=JSON.parse(JSON.stringify(datoargt[0]));
            for (key in argumentos)
            {
                arg1[key]=$("#sr_"+key+"").val();
            }
            EjecutarServicio(arg1);
        }
    }

    function ServicioAnt(){
        $("#modalServicio").modal("show");
    }

    function EjecutarServicio($argumento){
        var arg_envio =$argumento;
        var route="v1_0/motorServicios/servicioSP";
        $.ajax({
            url: route,
            type: 'POST',
            data : {
                'gestor':$("#s_gestor").val(),
                'host':$("#s_host").val(),
                'usuario':$("#s_usuario").val(),
                'clave':$("#s_clave").val(),
                'bd_nombre':$("#s_db").val(),
                'puerto':$("#s_puerto").val(),
                'servicio':$("#s_sp").val(),
                'argumento':arg_envio,
            },
            success: function(resultado) {
                $.LoadingOverlay("hide");
                $("#modalLlamada").modal("show");
                $("#sr_dato").val(JSON.stringify(resultado));//data.respuesta.success.dataSql
            },
            error: function(resultado) {
                $.LoadingOverlay("hide");
                swal("Error!", "Sucedio un problema al ejecutar el servicio!", "error");
            }
        });
    }

    function multiple(valor, multiple){
        resto = valor % multiple;
        if(resto==0)
            {return true;}
        else
            {return false;}
    }

</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#motor').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                s_nombreC: {
                    row: '.col-xs-4',
                    message: 'El nombre es incorrecto',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un nombre válido'
                        },
                        regexp: {
                            regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/\s/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                            message: 'No se aceptan carecteres especiales'
                        },
                        stringLength: {
                            min: 5,
                            message: 'Minimo 5 caracteres'
                        }
                    }
                },
                s_descripcionC: {
                    row: '.col-xs-6',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese una descripción válida'
                        },
                        regexp: {
                            regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/\s/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                            message: 'No se aceptan caracteres especiales'
                        }
                    }
                },
                tiposer: {
                        validators: {
                        notEmpty: { // <=== Use notEmpty instead of Callback validator
                        message: 'Seleccione un tipo de servicio.'
                        }
                    }
                },
                s_endponit: {
                    row: '.form-group',
                    message: 'El nombre es incorrecto',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese una URL válida'
                        }
                    }
                },
                s_endpointverbo: {
                    row: '.form-group',
                    validators: {
                        notEmpty: { // <=== Use notEmpty instead of Callback validator
                        message: 'Seleccione un Metodo.'
                        }
                    }
                },
                s_gestor: {
                    row: '.form-group',
                    validators: {
                        notEmpty: { // <=== Use notEmpty instead of Callback validator
                        message: 'Seleccione un gestor de Base de Datos.'
                        }
                    }
                },
                s_db: {
                    row: '.form-group',
                    message: 'Base de Datos es incorrecto',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese una Base de Datos válida'
                        },
                        regexp: {
                            regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/\s/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                            message: 'No se aceptan carecteres especiales'
                        }
                    }
                },
                s_host: {
                    row: '.form-group',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un HOST válido'
                        }
                    }
                },
                s_puerto: {
                    row: '.form-group',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un numero válido'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Sólo numeros'
                        }
                    }
                },
                s_sp: {
                    row: '.form-group',
                    message: 'SP es incorrecto',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un procedimiento almacenado válido'
                        }
                    }
                },
                s_usuario: {
                    row: '.form-group',
                    message: 'Usuario incorrecto',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un procedimiento almacenado válido'
                        }
                    }
                },
                s_clave: {
                    row: '.form-group',
                    message: 'Contraseña incorrecta',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un procedimiento almacenado válido'
                        }
                    }
                },
            }
        }).on('error.field.bv', function(e, data) {
            if (data.bv.getSubmitButton()) {data.bv.disableSubmitButtons(false);}
        }).on('success.field.fv', function(e, data) {
            if (data.bv.getSubmitButton()) {data.bv.disableSubmitButtons(false);}
        });
        $('#motorUP').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nombre1: {
                    row: '.col-xs-4',
                    message: 'El nombre es incorrecto',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un nombre válido'
                        },
                        regexp: {
                            regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/\s/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                            message: 'No se aceptan carecteres especiales'
                        },
                        stringLength: {
                            min: 5,
                            message: 'Minimo 5 caracteres'
                        }
                    }
                },
                descripcion1: {
                    row: '.col-xs-6',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese una descripción válida'
                        },
                        regexp: {
                            regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/\s/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                            message: 'No se aceptan caracteres especiales'
                        }
                    }
                },
                tiposer1: {
                        validators: {
                        notEmpty: { // <=== Use notEmpty instead of Callback validator
                        message: 'Seleccione un tipo de servicio.'
                        }
                    }
                },
                s_endponit: {
                    row: '.form-group',
                    message: 'El nombre es incorrecto',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese una URL válida'
                        }
                    }
                },
                s_endpointverbo: {
                    row: '.form-group',
                    validators: {
                        notEmpty: { // <=== Use notEmpty instead of Callback validator
                        message: 'Seleccione un Metodo.'
                        }
                    }
                },
                s_gestor: {
                    row: '.form-group',
                    validators: {
                        notEmpty: { // <=== Use notEmpty instead of Callback validator
                        message: 'Seleccione un gestor de Base de Datos.'
                        }
                    }
                },
                s_db: {
                    row: '.form-group',
                    message: 'Base de Datos es incorrecto',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese una Base de Datos válida'
                        },
                        regexp: {
                            regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9/\s/a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
                            message: 'No se aceptan carecteres especiales'
                        }
                    }
                },
                s_host: {
                    row: '.form-group',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un HOST válido'
                        }
                    }
                },
                s_puerto: {
                    row: '.form-group',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un numero válido'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Sólo numeros'
                        }
                    }
                },
                s_sp: {
                    row: '.form-group',
                    message: 'SP es incorrecto',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un procedimiento almacenado válido'
                        }
                    }
                },
                s_usuario: {
                    row: '.form-group',
                    message: 'Usuario incorrecto',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un procedimiento almacenado válido'
                        }
                    }
                },
                s_clave: {
                    row: '.form-group',
                    message: 'Contraseña incorrecta',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un procedimiento almacenado válido'
                        }
                    }
                },
            }
        }).on('error.field.bv', function(e, data) {
            if (data.bv.getSubmitButton()) {data.bv.disableSubmitButtons(false);}
        }).on('success.field.fv', function(e, data) {
            if (data.bv.getSubmitButton()) {data.bv.disableSubmitButtons(false);}
        });
    });
</script>
@endpush