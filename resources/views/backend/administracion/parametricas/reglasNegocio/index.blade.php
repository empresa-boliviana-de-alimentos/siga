@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.parametricas.reglasNegocio.partials.modalCreate')
@include('backend.administracion.parametricas.reglasNegocio.partials.modalUpdate')
@include('backend.administracion.parametricas.reglasNegocio.partials.modalReglas')
@include('backend.administracion.parametricas.reglasNegocio.partials.modalMensaje')
@include('backend.administracion.parametricas.reglasNegocio.partials.modalDB')

<div class="row">
    <div class="col-md-12">
        <section class="content-header">
            <div class="header_title">
                <h3>
                Reglas de Negocio
                <small>
                    <button class="btn btn-primary fa fa-plus-square pull-right" data-target="#myCreate" data-toggle="modal" onClick="limpiarRegla();">&nbsp;Nuevo</button>
                    <button class="btn btn-warning fa fa-gears pull-right" data-target="#modalReglas" data-toggle="modal" onClick="SeleccionarReglas();">&nbsp;Ejecutar RN</button>

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
    <div id="listRegla">
</div>
</div>
<input id="mestado" type="hidden" class="form-control">

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
                     htmlItems = '<select id="ctp_id" name="ctp_id"  class="form-control" onchange="MostrarReglas(ctp_id.value)">';
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
    function MostrarReglas (value) {
        cargando();
        var htmlBoton="";
        htmlstRegla='';
        htmlstRegla+='<section class="content">';
        htmlstRegla+='<div class="tab-content">';
        htmlstRegla+='<div class="box-body">';
        htmlstRegla+='<table class="table table-hover table-striped table-bordered todolist" id="lst-regla1">';
        htmlstRegla+='<thead><tr><th>Opciones</th><th>ID</th><th>Identificador</th><th>Nombre</th><th>Descripción</th><th>Versión</th></tr></thead>';
        $.LoadingOverlay("hide");

        var route1="v1_0/reglaNegocio/lst_reglasNegocio1";
        $.ajax({
            url: route1,
            type: 'POST',
            dataType: 'json',
            data: {
                "Workspace":value
            },
            success: function(data){
                data = data.Mensaje;
                for (var i = 0; i < data.length; i++) { 
                        htmlstRegla+='<tr><th><button class="btncirculo" style="background:#29b6f6" fa fa-plus-square pull-right" data-target="#modalUpdate" data-toggle="modal" data-placement="top" onClick="lst_codigo(' + data[i]._scd_id + ')" title="Modificar" type="button"><i class="glyphicon glyphicon-pencil"></i></button> <button class="btncirculo" style="background:#ef5350" onClick="darBajaRegladeNegocio(' + data[i]._scd_id + ');" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button></th>';
                        htmlstRegla+=
                        '<td align="left">'+ data[i]._scd_id+'</td>'+
                        '<td align="left">'+ data[i].identificador+'</td>'+
                        '<td align="left">'+ data[i]._scd_nombre+'</td>'+
                        '<td align="left">'+ data[i]._scd_descripcion+'</td>'+
                        '<td align="left">'+ data[i]._scd_version+'</td>'+
                        '</tr>';
                
                }
                htmlstRegla +='</table>';
                htmlstRegla +='</div>';
                htmlstRegla +='</div>';
                //htmlstRegla +='</div>';
                htmlstRegla +='</section>';
                $('#listRegla').html(htmlstRegla);
                $('#lst-regla1').DataTable( {
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
        
    var longitud ;
    var contCodigo=1;
    var arrCodigo=[];
    var arrDibujo=[];

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
        "ajax": "v1_0/reglaNegocio/lst_reglasNegocio",
        "columns":[
                    {data: 'acciones', orderable: false, searchable: false},
                    {data: '_scd_id'},
                    {data: '_scd_nombre'},
                    {data: '_scd_descripcion'},
                    {data: '_scd_version'},
                    {data: '_scd_codigo'},
        ],
        "language": {
            "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
  
    function lst_codigo($id ){
        var route1="v1_0/reglaNegocio/get_datos_Codigo/"+$id;
        cargando();
        $.ajax({
            url: route1,
            type: 'GET',
            data: {
            },
            success: function(data){
                limpiarRegla();
                $('#mestado').val('U');
               // console.log("error...",data);
                document.getElementById('rn_identificador1').value = data[0].identificador;
                for (var i = 0 ; i < data.length; i++) {
                    $("#id").val(data[i].rn_id);
                    var prop = JSON.parse(data[i].rn_prpiedades);
                    document.getElementById('orden').value =prop.scd_orden;
                    document.getElementById('nombre').value =prop.scd_nombre;
                    document.getElementById('version').value =prop.scd_version;
                    document.getElementById('descripcion').value =prop.scd_descripcion;

                    var cod = JSON.parse(data[i].rn_data);
                    var htmlARG;
                    var cadena='';
                    var cont=0;
                    arrDibujo.forEach(function (item, index, array)
                    {
                        arrCodigo[cont].scd_codigo=$("#scd_"+item.id+"").val();
                        cont=cont+1;
                    });
                    for (var j=0; j<cod.length;j++)
                    {
                        htmlARG=' Triger:'+
                                '</label>'+
                                '<div class="col-md-10">'+
                                '<textarea class="form-control" id="scd_'+contCodigo+'" name="scd_'+contCodigo+'" rows="3" placeholder="" type="text">'+
                                '</textarea>'+
                                '</div><div class="col-md-1">'+
                                '<a style="cursor:pointer;" type="button">'+
                                '<i class="fa fa-cogs fa-2x fa-fw" title="Ejecutar línea de Código" onclick="llamarTriger('+contCodigo+');"></i>'+
                                '</a><a style="cursor:pointer;" type="button">'+
                                '<i class="fa fa-trash fa-2x fa-fw" style="color:#ef5350" title="Eliminar línea de Código" onclick="menosLinea('+contCodigo+');"></i>'+
                                '</a></div></div>';

                        arrCodigo.push({scd_codigo:uncapares(cod[j].scd_codigo)});
                        arrDibujo.push({scd_codigo:htmlARG,id: contCodigo});
                        contCodigo++;
                    }
                    cont=1;
                    for (var i=0; i<arrDibujo.length;i++)
                    {
                        cadena=cadena + '<div class="form-group"><label class="col-md-1">'+cont+arrDibujo[i].scd_codigo;
                        cont++;
                    }
                    $('#upcodigo').html(cadena);
                    cont=0;
                    arrDibujo.forEach(function (item, index, array)
                    {
                        $("#scd_"+item.id+"").val(arrCodigo[cont].scd_codigo);
                        cont=cont+1;
                    });
                }
                $.LoadingOverlay("hide");
            },
            error: function(result) {
                console.log('error',result);
                $.LoadingOverlay("hide");
                swal("Error!", "Sucedio un problema al cargar la información!", "error");
            }
        });
    }

    function modificarCodigo(){
        cargando();
        var propiedades = {"scd_orden": $("#orden").val(),
                       "scd_nombre": $("#nombre").val(),
                       "scd_version": $("#version").val(),
                       "scd_descripcion": $("#descripcion").val()
                    };

        var array=[];
        for (var i = 0; i < arrCodigo.length; i++) {
            array.push({scd_codigo:capares($("#scd_"+arrDibujo[i].id).val())});
            //array.push({scd_codigo:$("#scd_"+arrDibujo[i].id).val()});
        }
        var reglas = JSON.stringify(array);
        var route1="v1_0/reglanegocio/editarCodigo";
            $.ajax({
                url: route1,
                headers: {'X-CSRF-TOKEN': $("#token").val()},
                type: 'POST',
                dataType: 'json',
                data: {
                    "id":$("#id").val(),
                    "datosCodigo":reglas,
                    "propiedades":JSON.stringify(propiedades),
                    "identificador":$("#rn_identificador1").val().toUpperCase()
                },
                success: function(data){
                    $.LoadingOverlay("hide");
                    $('#reglasUP').data('bootstrapValidator').resetForm();
                    $('#reglasUP').trigger("reset");
                    $("#modalUpdate").modal('toggle');
                    swal("Actualizar Regla de Negocio!", "Fue actualizado correctamente!", "success");
                    $('#lst-motor').DataTable().ajax.reload(null,true);
                    MostrarReglas($('#ctp_id').val());
                },
                error: function(result) {
                    $.LoadingOverlay("hide");
                    swal("Error!", "Sucedio un problema al registrar la información!", "error");

                }
            });
    }

    function darBajaRegladeNegocio(dato){
        var route1="v1_0/reglaNegocio/darBajaRegla_Negocio";
        swal({   title: "Esta seguro de eliminar la Regla de Negocio?",
                text: "Presione ok para dar de baja la Regla de Negocio de la Base de Datos!",
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
                      "idReglaNegocio":dato
                },
                  success: function(data){
                    swal("Regla de Negocio!", " Fue Eliminada correctamente!", "success");
                    MostrarReglas($('#ctp_id').val());
                    $('#lst-motor').DataTable().ajax.reload(null,false);
                    $( document ).ready( readyFn );
                },
                error: function(result) {
                    swal("Error!", "Sucedio un problema al dar de baja los datos!", "error");
                }
            });
         });
    }


    /*  Ejecutar Regla de Negocio  */
    function ejecutarRegaNegocio(){
        if(document.getElementById('s_regla').value!=0)
        {
            var concatena='';
            cargando();
            for(var i=1;i<contCodigo;i++)
            {
                concatena=concatena +"\n"+ $("#sr_cod_"+i+"").val();
            }
            var route="v1_0/reglanegocio/ejecutarPaso";
            var token =$("#token").val();
            $.ajax({
              url: route,
              headers: {},
              type: 'GET',
              dataType: 'json',
              data: {'ejecutar':concatena},
                success: function(data){
                    $.LoadingOverlay("hide");
                    if(data!=false)
                    {
                        $('#cargacodigo').html('<div class="form-group"><div class="col-md-12"><div class="panel panel-info" style="width:100%; height:115px; overflow-y:scroll; background:#e8f5e9;">' + JSON.stringify(data) +'</div></div></div>');
                    }
                    else
                    {
                        $('#mensaje').html(data);
                        $("#modalMensaje").modal("show");
                    }
                },
                error: function(result) {
                    $.LoadingOverlay("hide");
                    if (result.responseText.indexOf("<!DOCTYPE html>") > -1)
                    {
                        console.log('ERROR',result);
                        $('#mensaje').html(result.responseText);
                        $("#modalMensaje").modal("show");
                    }
                    else
                    {
                        $('#cargacodigo').html('<div class="form-group"><div class="col-md-12"><div class="panel panel-info" style="width:100%; height:115px; overflow-y:scroll; background:#e8f5e9;">' + result.responseText +'</div></div></div>');
                    }
                }
            });
        }
        else
        {
            swal("Alerta!", "Es necesario seleccionar una de las reglas de negocio para su ejecución!", "warning");
        }
    }

    function cargarRegla(){
        if(document.getElementById('s_regla').value!=0)
        {
            var route = "v1_0/reglaNegosio/get_Codigo/"+document.getElementById('s_regla').value;
            $.get(route, function(res){
                var nuevoarg = new Object();
                var htmlcabecera="";
                datoargt=[];
                contCodigo=1;
                var argumentos=res;
                var cont=1;
                var htmlARG="";
                var i=1;
                var dime =false;
                var fila=true;
                for (key in argumentos)
                {
                    cont=parseInt(key)+1;
                    nuevoarg[key]= argumentos[key];
                    if(fila){htmlARG=htmlARG+'<div class="form-group">';}
                    htmlARG=htmlARG+'<div class="">'+
                                    '<div align="right"><label class="col-md-1">'+cont+' Triger:'+
                                    '</label></div>'+
                                    '<div class="col-md-11">'+
                                    '<textarea class="form-control" id="sr_cod_'+i+'" name="sr_cod_'+i+'" rows="2" placeholder="" type="text">'+uncapares(argumentos[key].scd_codigo)+
                                    '</textarea>'+
                                    '</div>'+
                                    '</div>';
                    if(fila){htmlARG=htmlARG+'</div>';}
                    i++;
                    contCodigo++;
                }
                datoargt.push(nuevoarg);
                $('#cargaregla').html(htmlARG);
            });
            $('#cargacodigo').html('');
        }
        else
        {
            $('#cargaregla').html('');
            $('#cargacodigo').html('');
        }
    }

    function modificarEjecutar(){
        if(document.getElementById('s_regla').value!=0)
        {
            cargando();
            var arraydata=[];
            for(var i=1;i<contCodigo;i++)
            {arraydata.push({scd_codigo:capares($("#sr_cod_"+i+"").val())});}
            var route1="v1_0/reglaNegocio/up_DataCodigo";
            $.ajax({
                url: route1,
                type: 'POST',
                dataType: 'json',
                data: {
                    "id":document.getElementById('s_regla').value,
                    "datosCodigo":JSON.stringify(arraydata)
                },
                success: function(data){
                    $.LoadingOverlay("hide");
                    swal("Regla de negocio!", "Fue actualizado correctamente!", "success");
                    $('#lst-motor').DataTable().ajax.reload(null,false);
                },
                error: function(result) {
                    $.LoadingOverlay("hide");
                    swal("Error!", "Sucedio un problema al actualizar los datos!", "error");
                }
            });
        }
        else
        {
            swal("Alerta!", "Seleccione una de las reglas de negocio!", "warning");
        }
    }

    function limpiarRegla(){
        $('#mestado').val('N');
        $('#r_nombre').val('');
        $('#r_version').val('1.0');
        $('#r_descripcion').val('');
        $('#r_orden').val('10');
        arrCodigo=[];
        arrDibujo=[];
        contCodigo=1;
        $('#newcodigo').html('');
        $('#newresultado').html('');
        $('#upcodigo').html('');
        $('#upresultado').html('');
        $('#serviciocomboN').html('');
        $('#serviciocomboU').html('');
        $('#reglasnuevo').data('bootstrapValidator').resetForm();
        $('#reglasUP').data('bootstrapValidator').resetForm();
        if(document.getElementById('ctp_id').value != 0)
        {
            var route1="v1_0/reglaNegocio/identificador";
            $.ajax({
                url: route1,
                type: 'POST',
                dataType: 'json',
                data: {
                    "idworkspace":document.getElementById('ctp_id').value
                },
                success: function(data){
                    identificador = data[0].sp_identificador;
                    $.LoadingOverlay("hide");
                    $('#rn_identificador').val(identificador.toUpperCase());
                },
                error: function(result) {
                    $.LoadingOverlay("hide");
                    swal("Error!", "Sucedio un problema al obtener el identificador!", "error");
                }
            });
        }
    }


    function nuevaLinea($estado){
        var nuevoarg = new Object();
        var nuevoarg2 = new Object();
        var htmlARG;
        if ($estado=='T')
        {
            htmlARG=' Triger:'+
                    '</label>'+
                    '<div class="col-md-10">'+
                    '<textarea class="form-control" id="scd_'+contCodigo+'" name="scd_'+contCodigo+'" rows="3" placeholder="" type="text">'+
                    '</textarea>'+
                    '</div><div class="col-md-1">'+
                    '<a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-cogs fa-2x fa-fw" title="Ejecutar línea de Código" onclick="llamarTriger('+contCodigo+');"></i>'+
                    '</a><a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-trash fa-2x fa-fw" style="color:#ef5350" title="Eliminar línea de Código" onclick="menosLinea('+contCodigo+');"></i>'+
                    '</a></div></div>';
            $('#serviciocomboN').html('');
            $('#serviciocomboU').html('');
        }
        else if ($estado=='S')
        {
            htmlARG=' SP:'+
                    '</label>'+
                    '<div class="col-md-10">'+
                    '<textarea class="form-control" id="scd_'+contCodigo+'" name="scd_'+contCodigo+'" rows="3" placeholder="" type="text">'+
                    '</textarea>'+
                    '</div><div class="col-md-1">'+
                    '<a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-rocket fa-2x fa-fw" style="color:#ffa726" title="Servicio SP" onclick="llamarSP('+contCodigo+');"></i>'+
                    '</a><a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-cogs fa-2x fa-fw" title="Ejecutar línea de Código" onclick="llamarTriger('+contCodigo+');"></i>'+
                    '</a><a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-trash fa-2x fa-fw" style="color:#ef5350" title="Eliminar línea de Código" onclick="menosLinea('+contCodigo+');"></i>'+
                    '</a></div></div>';
            SeleccionarServicios($estado);
        }
        else if ($estado=='R')
        {
            htmlARG=' REST:'+
                    '</label>'+
                    '<div class="col-md-10">'+
                    '<textarea class="form-control" id="scd_'+contCodigo+'" name="scd_'+contCodigo+'" rows="3" placeholder="" type="text">'+
                    '</textarea>'+
                    '</div><div class="col-md-1">'+
                    '<a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-rocket fa-2x fa-fw" style="color:#ffa726" title="Servicio REST" onclick="llamarRest('+contCodigo+');"></i>'+
                    '</a><a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-cogs fa-2x fa-fw" title="Ejecutar línea de Código" onclick="llamarTriger('+contCodigo+');"></i>'+
                    '</a><a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-trash fa-2x fa-fw" style="color:#ef5350" title="Eliminar línea de Código" onclick="menosLinea('+contCodigo+');"></i>'+
                    '</a></div></div>';
            SeleccionarServicios($estado);
        }
        else if ($estado=='C')
        {
            htmlARG=' DB:'+
                    '</label>'+
                    '<div class="col-md-10">'+
                    '<textarea class="form-control" id="scd_'+contCodigo+'" name="scd_'+contCodigo+'" rows="3" placeholder="" type="text">'+
                    '</textarea>'+
                    '</div><div class="col-md-1">'+
                    '<a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-database fa-2x fa-fw" style="color:#ffa726" title="Conexión Base de Datos" onclick="llamarDB('+contCodigo+');"></i>'+
                    '</a><a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-cogs fa-2x fa-fw" title="Ejecutar línea de Código" onclick="llamarTriger('+contCodigo+');"></i>'+
                    '</a><a style="cursor:pointer;" type="button">'+
                    '<i class="fa fa-trash fa-2x fa-fw" style="color:#ef5350" title="Eliminar línea de Código" onclick="menosLinea('+contCodigo+');"></i>'+
                    '</a></div></div>';
            SeleccionarServicios($estado);
        }
        else if ($estado=='N')
        {
            swal("Alerta!", "Seleccione una de las acciones!", "warning");
        }
        if($estado!='N')
        {
            var cadena='';
            var cont=0;
            arrDibujo.forEach(function (item, index, array)
            {
                arrCodigo[cont].scd_codigo=$("#scd_"+item.id+"").val();
                cont=cont+1;
            });

            nuevoarg['scd_codigo']= contCodigo;
            nuevoarg2['scd_codigo']= htmlARG;
            arrCodigo.push({scd_codigo:''});
            arrDibujo.push({scd_codigo:htmlARG,id: contCodigo});
            contCodigo++;

            cont=1;
            for (var i=0; i<arrDibujo.length;i++)
            {

                cadena=cadena + '<div class="form-group"><label class="col-md-1">'+cont+arrDibujo[i].scd_codigo;
                cont++;
            }
            if($('#mestado').val()=='N')
            {$('#newcodigo').html(cadena);$('#newresultado').html('');}
            else
            {$('#upcodigo').html(cadena);$('#upresultado').html('');}

            cont=0;
            arrDibujo.forEach(function (item, index, array)
            {
                $("#scd_"+item.id+"").val(arrCodigo[cont].scd_codigo);
                cont=cont+1;
            });

            $('#idinput').val(contCodigo -1);
        }
        if($('#mestado').val()=='N')
        {$("#s_regla2").val("Seleccionar");}
        else
        {$("#s_regla3").val("Seleccionar");}

    }

    function eliminarResultado(){
        $('#newresultado').html('');
    }

    function menosLinea($id){
        if(contCodigo>1)
        {
            swal({title: "Esta seguro de eliminar?",
                text: "Se eliminará el contenido del campo de código!",
                type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Si, Eliminar!",closeOnConfirm: true
            }, function(){
                var cadena='';
                var cont=0;
                var pos=-1;
                arrDibujo.forEach(function (item, index, array)
                {
                    arrCodigo[cont].scd_codigo=$("#scd_"+item.id+"").val();
                    cont=cont+1;
                });
                pos = arrDibujo.map(function(e) {return e.id;}).indexOf($id);
                arrCodigo.splice(pos,1);
                arrDibujo.splice(pos,1);

                cont=1;
                for (var i=0; i<arrDibujo.length;i++)
                {
                    cadena=cadena + '<div class="form-group"><label class="col-md-1">'+cont+arrDibujo[i].scd_codigo;
                    cont++;
                }
                if($('#mestado').val()=='N')
                {$('#newcodigo').html(cadena);$('#newresultado').html('');}
                else
                {$('#upcodigo').html(cadena);$('#upresultado').html('');}

                cont=0;
                arrDibujo.forEach(function (item, index, array)
                {
                    $("#scd_"+item.id+"").val(arrCodigo[cont].scd_codigo);
                    cont=cont+1;
                });
            });
        }
    }

    /*GUARDAR REGLA*/
    function GuardarRegla(){
        if ($('#r_nombre').val()=='')
        {
            swal("Alerta!", "El nombre es requerido para la regla de negocio.", "warning");
        }
        else if ($('#r_version').val()=='')
        {
            swal("Alerta!", "La versión es requerido para la regla de negocio.", "warning");
        }
        else if (arrCodigo.length==0)
        {
            swal("Alerta!", "Es necesario introducir campos de código para la regla de negocio.", "warning");
        }
        else if ($('#rn_identificador').val()=='')
        {
            swal("Alerta!", "El identificador es necesario para guardar la regla.", "warning");
        }
        else
        {
            cargando();
            var cabezera = [];
            var propiedades = {
                scd_nombre: $('#r_nombre').val(),
                scd_version: $('#r_version').val(),
                scd_descripcion: $('#r_descripcion').val(),
                scd_orden: $('#r_orden').val(),
             }
            cabezera.push(propiedades);
            for (var i=0; i<arrCodigo.length;i++)
            {
                arrCodigo[i].scd_codigo=capares($("#scd_"+arrDibujo[i].id).val());
            }
            if($('#ctp_id').val()!= 0){

                var route1="v1_0/reglaNegocio/nuevo_registro";
                $.ajax({
                    url: route1,
                    headers: {'X-CSRF-TOKEN': $("#token").val()},
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "datos":JSON.stringify(arrCodigo),
                        "propiedades":JSON.stringify(cabezera[0]),
                        "usuario":1,
                        'workspace':$('#ctp_id').val(),
                        'identificador':$('#rn_identificador').val(),
                    },

                    success: function(data){
                        $.LoadingOverlay("hide");
                        $('#reglasnuevo').data('bootstrapValidator').resetForm();
                        $('#reglasnuevo').trigger("reset");
                        $("#myCreate").modal('toggle');
                        swal("Regla de Negocio!", "Fue registrada correctamente!", "success");
                        $('#lst-motor').DataTable().ajax.reload(null,false);
                        MostrarReglas($('#ctp_id').val());
                    },
                    error: function(result) {
                        $.LoadingOverlay("hide");
                        swal("Error!", "Sucedio un problema al registrar los datos!", "error");
                    }
                });
            }else{
                $.LoadingOverlay("hide");
                swal("Error!", "Debe Seleccionar Un WorsPace Por Favor! ", "error");
            }
        }
    }

    function llamarRest($c){
        $('#idinput').val($c);
        SeleccionarServicios('R');
    }

    function llamarSP($c){
        $('#idinput').val($c);
        SeleccionarServicios('S');
    }

    function llamarDB($c){
        $('#idinput').val($c);
        SeleccionarServicios('C');
    }

    function llamarTriger($c){
        var concatena='';
        var cont=0;
        cargando();
        arrDibujo.forEach(function (item, index, array)
        {
            if(item.id<=$c)
            {
                concatena=concatena +"\n"+ capares($("#scd_"+item.id+"").val());
                cont=cont+1;
            }
        });
        
        var route="v1_0/reglanegocio/ejecutarPaso";
        var token =$("#token").val();
        $.ajax({
          url: route,
          headers: {},
          type: 'GET',
          dataType: 'json',
          data: {'ejecutar':concatena},
            success: function(data){
                $.LoadingOverlay("hide");
                if(data!=false)
                {
                    if($('#mestado').val()=='N')
                    {$('#newresultado').html('<div class="panel panel-info" style="width:100%; height:115px; overflow-y:scroll; background:#e8f5e9;">'+JSON.stringify(data)+'</div>');}
                    else
                    {$('#upresultado').html('<div class="panel panel-info" style="width:100%; height:115px; overflow-y:scroll; background:#e8f5e9;">'+JSON.stringify(data)+'</div>');}
                }
                else
                {
                    $('#mensaje').html(data);
                    $("#modalMensaje").modal("show");
                }
            },
            error: function(result) {
                $.LoadingOverlay("hide");
                if (result.responseText.indexOf("<!DOCTYPE html>") > -1)
                {
                    console.log('ERROR',result);
                    $('#mensaje').html(result.responseText);
                    $("#modalMensaje").modal("show");
                }
                else
                {
                    if($('#mestado').val()=='N')
                    {$('#newresultado').html('<div class="panel panel-info" style="width:100%; height:115px; overflow-y:scroll; background:#e8f5e9;">'+result.responseText+'</div>');}
                    else
                    {$('#upresultado').html('<div class="panel panel-info" style="width:100%; height:115px; overflow-y:scroll; background:#e8f5e9;">'+result.responseText+'</div>');}
                }
            }
        });
    }

    function listaConeccion(){
            var route1="v1_0/reglaNegocio/coneccionDB";
            $.ajax({
                url: route1,
                type: 'POST',
                dataType: 'json',
                data: {
                },
                success: function(data){

                   console.log("resultado");
                },
                error: function(result) {
                  // console.log(result);
                }
            });
    }
    $(document).ready(function (){
       MostrarReglas(0);
       cargar_workspace();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#reglasnuevo').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                r_nombre: {
                    row: '.form-group',
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
                r_version: {
                    row: '.form-group',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un numero válido'
                        },
                        regexp: {
                            regexp: /^[0-9-.-0-9]+$/,
                            message: 'Sólo numeros'
                        },
                        stringLength: {
                            min: 1,
                            max: 3,
                            message: 'Minimo 3 caracteres'
                        }
                    }
                },
                r_descripcion: {
                    row: '.form-group',
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
                r_orden: {
                    row: '.form-group',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un numero válido'
                        },
                        regexp: {
                            regexp: /^[0-9-]+$/,
                            message: 'Sólo numeros'
                        },
                        stringLength: {
                            min: 1,
                            max: 3,
                            message: 'Minimo 3 caracteres'
                        }
                    }
                }
            }
        }).on('error.field.bv', function(e, data) {
            if (data.bv.getSubmitButton()) {data.bv.disableSubmitButtons(false);}
        }).on('success.field.fv', function(e, data) {
            if (data.bv.getSubmitButton()) {data.bv.disableSubmitButtons(false);}
        });
        $('#reglasUP').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nombre: {
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
                version: {
                    row: '.form-group',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un numero válido'
                        },
                        regexp: {
                            regexp: /^[0-9-.-0-9]+$/,
                            message: 'Sólo numeros'
                        },
                        stringLength: {
                            min: 1,
                            max: 3,
                            message: 'Minimo 3 caracteres'
                        }
                    }
                },
                descripcion: {
                    row: '.form-group',
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
                orden: {
                    row: '.form-group',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese un numero válido'
                        },
                        regexp: {
                            regexp: /^[0-9-]+$/,
                            message: 'Sólo numeros'
                        },
                        stringLength: {
                            min: 1,
                            max: 3,
                            message: 'Minimo 3 caracteres'
                        }
                    }
                }
            }
        }).on('error.field.bv', function(e, data) {
            if (data.bv.getSubmitButton()) {data.bv.disableSubmitButtons(false);}
        }).on('success.field.fv', function(e, data) {
            if (data.bv.getSubmitButton()) {data.bv.disableSubmitButtons(false);}
        });
    });
</script>

@endpush