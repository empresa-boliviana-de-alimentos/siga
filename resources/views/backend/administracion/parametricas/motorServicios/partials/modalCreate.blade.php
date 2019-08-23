<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myCreate" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 container-fluit">
                        {!! Form::open(['class'=>'form-horizontal','id'=>'motor'])!!}
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>
                                    <small>
                                    <div class="pull-right">
                                    <div class="pull-right" id="idboton"></div>
                                    <button class="btn btn-default" data-dismiss="modal" onclick="Limpiar();" type="button">
                                    Cerrar
                                    </button>

                                    <a type = "button" class = "pull-right btn btn-primary" id="gen_factura" onclick="CrearNuevoRegistro();">Guardar</a></div></small>
                                    Motor Servicios
                                </h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal">
                                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="col-xs-1 control-label" for="">
                                        Nombre:
                                    </label>
                                    <div class="col-xs-4">
                                        {!! Form::text('s_nombreC',null, array('maxlength'=>'100','class' => 'form-control','id'=>'s_nombreC','name'=>'s_nombreC')) !!}
                                    </div>
                                    <label class="col-xs-1 control-label" for="">
                                        Descripcion:</label>
                                    <div class="col-xs-6">
                                        {!! Form::text('ue_nombre',null, array('maxlength'=>'50','class' => 'form-control','id'=>'s_descripcionC','name'=>'s_descripcionC')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-1">
                                        Tipo:
                                    </label>
                                    <div class="col-md-4">
                                        <select class="form-control" id="tiposer" name="tiposer" onchange="CrearServicio(this.value)">
                                            <option value="N" selected="selected">-- Seleccionar --</option>
                                            <option value="R">Servicio REST</option>
                                            <option value="S">Servicio SP</option>
                                            <option value="C">Conexión BD</option>
                                        </select>
                                        
                                    </div>
                                    <div id="serviciocomboN"></div>

                                </div>

                                <div id="cabeceraCrear"></div>
                                <div id="argCrear">
                                <h4 style="color:#0B610B" align="center">Argumentos
                                <small>
                                <div class="pull-right">
                                    <a   type="button" id="eliminarLineacmdT" style="cursor:pointer;">
                                      <i class="fa fa-trash fa-2x fa-fw" style="color:#ef5350" title="Eliminar todos los Argumentos" onclick="eliminarTArgumento();"></i>
                                    </a>
                                    <a   type="button" id="nuevaLineacmdT" style="cursor:pointer;">
                                      <i class="fa fa-plus-square fa-2x fa-fw" style="color:#29b6f6" title="Agregar Nuevo Argumento" onclick="crearArgumento();"></i>
                                    </a>
                                </div>
                                </small>
                                </h4><HR>
                                <div id="argumentopintarCrear"></div>
                                <div id="argumentopintarSp"></div>
                                </div>
                                
                                </input>
                            </form>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
</div>


@push('scripts')
<script type="text/javascript">
    var contCodigo=1;
    var arrCodigo=[];
    var arrDibujo=[];

    function crearArgumento(){
        var nuevoarg = new Object();var nuevoarg2 = new Object();
        var htmlARG;
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

            var cadena='';var cont=0;
            arrDibujo.forEach(function (item, index, array) 
            {
                arrCodigo[cont].arg_clave=$("#clave"+item.id+"").val();
                arrCodigo[cont].arg_valor=$("#valor"+item.id+"").val();
                arrCodigo[cont].arg_tipo=$("#tipoarg"+item.id+"").val();//document.getElementById("tipoarg"+item.id+"").value();
                cont=cont+1;
            });

            nuevoarg['scd_codigo']= contCodigo;
            nuevoarg2['scd_codigo']= htmlARG;
            arrCodigo.push({arg_clave:'', arg_valor:'', arg_tipo:'N'});
            arrDibujo.push({scd_codigo:htmlARG,id: contCodigo});
            contCodigo++;
            
            cont=1;
            for (var i=0; i<arrDibujo.length;i++)
            {
                
                cadena=cadena + '<div class="form-group"><label class="col-md-1">'+cont+arrDibujo[i].scd_codigo;
                cont++;
            }
            if($('#mestadoMS').val()=='N')
            {$('#argumentopintarCrear').html(cadena);}
            else
            {$('#upargumentopintarCrear').html(cadena);}
            
            cont=0;
            arrDibujo.forEach(function (item, index, array) 
            {
                $("#clave"+item.id+"").val(arrCodigo[cont].arg_clave);
                $("#valor"+item.id+"").val(arrCodigo[cont].arg_valor);
                $("#tipoarg"+item.id+"").val(arrCodigo[cont].arg_tipo);
                cont=cont+1;
            });
    }

    function eliminarTArgumento(){
        contCodigo=1;
        arrCodigo=[];
        arrDibujo=[];
        if($('#mestadoMS').val()=='N')
        {$("#argumentopintarCrear").html('');}
        else
        {$("#upargumentopintarCrear").html('');}
    }

    function menosLinea($id){
        if(contCodigo>1)
        {
            swal({title: "Esta seguro de eliminar?",
                text: "Se eliminará el argumento seleccionado!",
                type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Si, Eliminar!",closeOnConfirm: true
            }, function(){
                var cadena='';var cont=0;var pos=-1;
                arrDibujo.forEach(function (item, index, array) 
                {
                    arrCodigo[cont].arg_clave=$("#clave"+item.id+"").val();
                    arrCodigo[cont].arg_valor=$("#valor"+item.id+"").val();
                    arrCodigo[cont].arg_tipo=$("#tipoarg"+item.id+"").val();//document.getElementById("tipoarg"+item.id+"").value();
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
                if($('#mestadoMS').val()=='N')
                {$('#argumentopintarCrear').html(cadena);}
                else
                {$('#upargumentopintarCrear').html(cadena);}
                
                cont=0;
                arrDibujo.forEach(function (item, index, array) 
                {
                    $("#clave"+item.id+"").val(arrCodigo[cont].arg_clave);
                    $("#valor"+item.id+"").val(arrCodigo[cont].arg_valor);
                    $("#tipoarg"+item.id+"").val(arrCodigo[cont].arg_tipo);//document.getElementById("tipoarg"+item.id+"").value(arrCodigo[cont].arg_tipo);
                    cont=cont+1;
                });
            });
        }
    }

    function CrearNuevoRegistro() {
        if($("#s_nombreC").val() == '')
        {
            swal("Alerta!", "El nombre es requerido para el motor de servicio.", "warning");
        } 
        else if($("#tiposer").val() == 'N')
        {
            swal("Alerta!", "Debe seleccionar un Tipo de Servicio!", "warning");
        }
        else {
            cargando();
            var objetoArgumento = {}; //var argumentoTitulo=[]; var cont=11;
            for (var i = 0; i<arrCodigo.length; i++) {
              if($("#tipoarg"+arrDibujo[i].id+"").val() == 'S') {
                objetoArgumento[$("#clave"+arrDibujo[i].id+"").val()] = '\''+$("#valor"+arrDibujo[i].id+"").val()+'\'';
              } else {
                objetoArgumento[$("#clave"+arrDibujo[i].id+"").val()] = $("#valor"+arrDibujo[i].id+"").val();
              }

            }

            if($("#tiposer").val() == 'S' || $("#tiposer").val() == 'C') {
                $db = $("#s_dbC").val();
                $sp = $("#s_spC").val();
                $host = $("#s_hostC").val();
                $clave = $("#s_claveC").val();
                $gestor = $("#s_gestorC").val();
                $puerto = $("#s_puertoC").val();
                $usuario = $("#s_usuarioC").val();
                $endpoint = "";
                $verboser = "";
                //$titulos = JSON.stringify(argumentoTitulo);
            }
            else if($("#tiposer").val() == 'R') { 
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
            srv_propiedades = {
                        "srv_nombre": $("#s_nombreC").val(),
                        "srv_descripcion": $("#s_descripcionC").val()
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
                  "srv_tipo_servicio": $("#tiposer").val(),
                  "srv_endpoint_verbo": $verboser
                  //"srv_tituloarg": $titulos
            }
            if($("#tiposer").val()== 'C'){
                var route="v1_0/motorServicios/insertarServicio";
                //alert($("#ctp_id").val());
                $.ajax({
                    url: route,
                    headers: {'X-CSRF-TOKEN': $("#token").val()},
                    type: 'POST',
                    data : {
                        'dataServicio':JSON.stringify(srv_data),
                        'propiedades':JSON.stringify(srv_propiedades),
                        'workspace':$('#ctp_id').val(),
                        'tiposervicio':$('#tiposer').val(),
                    },
                    success: function(resultado) {
                        $.LoadingOverlay("hide");
                        $('#motor').data('bootstrapValidator').resetForm();
                        $("#myCreate").modal('toggle');
                        swal("Nuevo Servicio!", "Fue Registrado correctamente!", "success");
                        $('#lst-motor').DataTable().ajax.reload(null,false);
                        $('#s_usuarioC').val("");
                        $('#s_claveC').val("");
                        
                        //MostrarServiciosCl(0);
                        location.reload();
                    },
                    error: function(resultado) {
                        $.LoadingOverlay("hide");
                        swal("Error!", "Sucedio un problema al registrar el servicio!", "error");
                    }
                });
                
            }else{
                if($('#ctp_id').val()!= 0){
                // alert(22222);
                     var route="v1_0/motorServicios/insertarServicio";
                    //alert($("#ctp_id").val());
                    $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': $("#token").val()},
                        type: 'POST',
                        data : {
                            'dataServicio':JSON.stringify(srv_data),
                            'propiedades':JSON.stringify(srv_propiedades),
                            'workspace':$('#ctp_id').val(),
                            'tiposervicio':$('#tiposer').val(),
                        },
                        success: function(resultado) {
                            $.LoadingOverlay("hide");
                            $('#motor').data('bootstrapValidator').resetForm();
                            $("#myCreate").modal('toggle');
                            swal("Nuevo Servicio!", "Fue Registrado correctamente!", "success");
                            $('#lst-motor').DataTable().ajax.reload(null,false);
                            MostrarServiciosCl($('#ctp_id').val());
                            //location.reload();
                        },
                        error: function(resultado) {
                            $.LoadingOverlay("hide");
                            swal("Error!", "Sucedio un problema al registrar el servicio!", "error");
                        }
                    });
                }
                else{
                    swal("Alerta!", "Debe seleccionar un Tipo de Base De datos!", "warning");
                    $.LoadingOverlay("hide");
                }
            }    
               
        }
    }

    function conexionDB()
    {
        var route="v1_0/reglaNegocio/conexion_DB";cargando();
        var token =$("#token").val();
        $.ajax({
          url: route,
          headers: {},
          type: 'POST',
          dataType: 'json',
          data: {'base':$('#s_gestorC').val(),'host':$('#s_hostC').val(),'usuario':$('#s_usuarioC').val(),'clave':$('#s_claveC').val(),'nombrebd':$('#s_dbC').val(),'puerto':$('#s_puertoC').val()},
            success: function(data){
                if($("#tiposer").val() == 'C'){$('#s_spC').val(data.res);}
                
                
                //$('#resultadoConn').html('<h4 class="col-md-14" style="color:#0B610B" align="center">Cadena de Conexión</h4><HR><div class="form-group"><div class="col-md-12" align="center" style="color:#0B610B">'+data.res+'</div><div align="center">La variable \'$_Tipo\', determina que tipo de consulta realizará (SELECT, INSERT, UPDATE, DELET, CREATE).</div></div>');
                swal("Exito!", "Conexión correcta a la Base de Datos!", "success");
                
                $.LoadingOverlay("hide");
            },
            error: function(result) {
                $.LoadingOverlay("hide");
                console.log('error',result);
                swal("Error!", "Incoherencias en los datos,\n para conectar a la Base de Datos "+$('#s_dbC').val()+".", "error");
            }
        }); 
    }

    function SeleccionarServicios()
    {
      
      var htmlUnidades='';servicioID='C';
      $.ajax({
            url: "v1_0/reglaNegocio/get_ServiciosRS/C",
            headers: {'X-CSRF-TOKEN': $("#token").val()},
            type: 'GET',
            dataType: 'json',
            success: function(data){
                htmlUnidades = '<label class="col-md-1">Conexión:</label><div class="col-md-6"><select class="js-example-basic-single form-control" id="s_servicioCnn" name="s_servicioCnn" onChange="selectServicio();">';
                htmlUnidades +='<option value=0>--Seleccionar una conexión DB existente--</option>';
                for (var i = 0; i < data.length; i++) {
                    if(data[i].workspace == $('#ctp_id').val() ){
                        htmlUnidades +='<option value='+data[i].ser_id+'>'+data[i].ser_nombre+'</option>';
                    }
                }
                htmlUnidades += '</select></div>';

                if($('#mestadoMS').val()=='N')
                { $('#serviciocomboN').html(htmlUnidades);}
                else
                { $('#serviciocomboU').html(htmlUnidades);}
            },  error: function(result) {
                console.log(result);//https://openclassrooms.com/courses/descubre-bootstrap/plugins-jquery http://www.scriptcase.net/?gclid=CIeFqq_2k9YCFQoGhgodXMQN9Q
                //"background: linear-gradient(transparent,green);-webkit-background-clip: background;color: #000000;"
            }
        });
    }
    
    function selectAtributos(atributos){
        parametros = atributos;
        parametros = parametros.replace("{", "");
        parametros = parametros.replace("}", "");
        parametros = parametros.split( ",");
        longitud = parametros.length;
        var htmlARG = '';
        for (var i = 0; i <= longitud; i++) {

            htmlARG='<div class="col-md-12">'+
                '<label class="col-md-1"> Título:</label>'+
                '<div class="col-md-3">'+
                    '<input class="form-control" id="clave'+i+'" name="clave" ></input>'+
                '</div>'+
                '<label class="col-md-1" for="">Valor:</label>'+
                '<div class="col-md-3">'+
                    '<input class="form-control" id="valor'+i+'" name="valor" ></input>'+
                '</div>'+
                '<label class="col-md-1">Tipo :</label>'+
                '<div class="col-md-2">'+
                    '<select class="form-control" id="tipoarg'+i+'" name="tipoarg'+i+'">'+
                        '<option value="N" selected="selected">--Seleccione--</option>'+
                        '<option value="I">Entero</option>'+
                        '<option value="S">Cadena</option>'+
                    '</select>'+
                '</div><div class="col-md-1">'+
                '<a style="cursor:pointer;" type="button">'+
                '<i class="fa fa-trash fa-2x fa-fw" style="color:#ef5350" title="Eliminar argumento" onclick="menosLinea('+i+');"></i>'+
                '</a></div></div>';
        }
        htmlARG += htmlARG;
        //$('#argumentopintarSp').html(htmlARG);
    }
    function selectServicio()
    {
        var seleccion=$("#s_servicioCnn").val();//document.getElementById("s_servicioCnn").value;cargando();

        var route="v1_0/motorServicios/llama_Conn";
        var token =$("#token").val();
        if(seleccion!=0)
        {
            $.ajax({
              url: route,
              headers: {},
              type: 'GET',
              dataType: 'json',
              data: {'id':$("#s_servicioCnn").val()},
                  success: function(data){
                        $.LoadingOverlay("hide");
                        $("#s_dbC").val(data[0]._ser_bd);
                        $("#s_hostC").val(data[0]._ser_host);
                        $("#s_claveC").val(data[0]._ser_clave);
                        $("#s_gestorC").val(data[0]._ser_gestor);
                        $("#s_puertoC").val(data[0]._ser_puerto);
                        $("#s_usuarioC").val(data[0]._ser_usuario);
                        
                        if(data[0]._ser_sp.length!=0)
                        {
                            var htmlUnidades='<select class="js-example-basic-single form-control" id="s_spC" name="s_spC" onchange = "selectAtributos(this.value)" ><option value=0>--Seleccionar--</option>';
                            if(data[0]._ser_gestor=='postgres')
                            {
                                data[0]._ser_sp.forEach(function (item, index, array) 
                                {   
                                    
                                    htmlUnidades +='<option value='+item.proargnames+'>'+item.proname+'</option>'; });
                            }
                            else if(data[0]._ser_gestor=='mssql')
                            {
                                data[0]._ser_sp.forEach(function (item, index, array) 
                                { htmlUnidades +='<option value='+item.ROUTINE_NAME+'>'+item.ROUTINE_NAME+'</option>'; });
                            }
                            else if(data[0]._ser_gestor=='mysql')
                            {
                                data[0]._ser_sp.forEach(function (item, index, array) 
                                { htmlUnidades +='<option value='+item.specific_name+'>'+item.specific_name+'</option>'; });
                            }
                            htmlUnidades += '</select>';
                            $('#procedimientoSP').html(htmlUnidades);
                        }
                        else
                        {
                            $('#procedimientoSP').html('<input class="form-control" id="s_spC" name="s_spC" placeholder="" type="text" ></input>');
                        }
                        
                  },
                  error: function(result) {
                        $.LoadingOverlay("hide");
                        console.log(result);
                        swal("Opss..!", "Succedio un problema al conectar con la base de datos!", "error");
                  }
            });
        }     
    }

    </script>
@endpush