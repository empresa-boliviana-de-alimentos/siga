<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myCreate" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 container-fluit">
                        {!! Form::open(['class'=>'form-horizontal','id'=>'reglasnuevo'])!!}
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>
                                    <small>
                                    <div class="pull-right"><button class="btn btn-default" data-dismiss="modal" onclick="limpiarRegla();" type="button">
                                    Cerrar
                                    </button>
                                    <a type = "submit" class = "btn btn-primary" id="new_regla" disabled="disabled" onclick="GuardarRegla();">Guardar</a></div></small>
                                    Nueva Reglas de Negocio
                                </h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal">
                                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="form-group col-md-2 pull-right">
                                        {!! Form::text('rn_version',null, array('maxlength'=>'4','class' => 'form-control','id'=>'r_version','name'=>'r_version')) !!}
                                    </div>
                                    <label class="form-group col-md-1 pull-right" for="">
                                        Version:
                                    </label>
                                    <div class="form-group col-md-9 pull-right">
                                        {!! Form::text('r_nombre',null, array('maxlength'=>'50','class' => 'form-control','id'=>'r_nombre')) !!}
                                    </div>
                                    <label class="form-group col-md-1 pull-lefth" for="">
                                        Nombre:
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-2 pull-right">
                                        {!! Form::text('rn_orden',null, array('maxlength'=>'3','class' => 'form-control mayusculas','id'=>'r_orden','name'=>'r_orden')) !!}
                                    </div>
                                    <label class="form-group col-md-1 pull-right" for="">&nbsp;&nbsp;Orden:</label>
                                    <div class="form-group col-md-9 pull-right">
                                        {!! Form::text('rn_direccion',null, array('maxlength'=>'100','class' => 'form-control mayusculas','id'=>'r_descripcion','name'=>'r_descripcion')) !!}
                                    </div>
                                    <label class="form-group col-md-1 pull-lefth" for="">
                                        Descripcion:
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-2 pull-right">
                                    </div>
                                    <label class="form-group col-md-1 pull-right" for="">
                                    </label>
                                    <div class="form-group col-md-9 pull-right">
                                        {!! Form::text('rn_identificador',null, array('maxlength'=>'25','class' => 'form-control mayusculas','id'=>'rn_identificador','name'=>'rn_identificador', 'onKeyUp'=>'this.value = this.value.toUpperCase()' )) !!}
                                    </div>
                                    <label class="form-group col-md-1 pull-lefth" for="">
                                        Identificador:
                                    </label>
                                </div>

                                <div class="col-md-12">
                                <h4 style="color:#0B610B" align="center">Líneas de Código
                                <small>
                                <div class="pull-right">
                                <select class="form-control pull-right" id="s_regla2" name="s_regla2" placeholder="Seleccione" onchange="nuevaLinea(document.getElementById('s_regla2').value);">
                                  <option value="N" selected="selected">-- Seleccionar --</option>
                                  <option value="T">Triger</option>
                                  <option value="R">Servicio Rest</option>
                                  <option value="S">Servicio SP</option>
                                  <option value="C">Conexión DB</option>
                                </select>
                                </div>
                                <div class="pull-right">
                                    <input id="idinput" name="idinput" type="hidden">
                                    <div id="serviciocomboN"></div>
                                </div>
                                <div class="col-md-1 pull-right">
                                    <a   type="button" id="nuevaLineacmdT" style="cursor:pointer;">
                                      <i class="fa fa-trash fa-2x fa-fw" style="color:#ef5350" title="Limpiar Resultado" onclick="eliminarResultado();"></i>
                                    </a>
                                </div>
                                </small>
                                </h4><HR></div>
                                <div class="">
                                    <div id="newcodigo"></div>
                                    <div class="form-group">
                                        <label class="col-md-1">Resultado:
                                        </label>
                                        <div class="col-md-11">
                                            <div id="newresultado"></div>
                                        </div>
                                    </div>
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
<script>
    var servicioID;
    function SeleccionarServicios($t)
    {
      var htmlUnidades='';servicioID=$t;
      $.ajax({
            url: "v1_0/reglaNegocio/get_ServiciosRS/"+$t,
            headers: {'X-CSRF-TOKEN': $("#token").val()},
            type: 'GET',
            dataType: 'json',
            success: function(data){
                htmlUnidades = '<select class="js-example-basic-single form-control" id="s_servicio" name="s_servicio" onChange="selectServicio();">';
                if($t=='R'){htmlUnidades +='<option value=0>--Seleccionar Servicio REST--</option>';}
                if($t=='S'){htmlUnidades +='<option value=0>--Seleccionar Servicio SP--</option>';}
                if($t=='C'){htmlUnidades +='<option value=0>--Seleccionar Conexión DB--</option>';}
                for (var i = 0; i < data.length; i++) {
                    //if($('#ctp_id').val() == data[i].workspace){

                        htmlUnidades +='<option value='+data[i].ser_id+'>'+data[i].ser_nombre+'</option>';
                    //}
                }
                htmlUnidades += '</select>';
               
                if($('#mestado').val()=='N')
                { $('#serviciocomboN').html(htmlUnidades);}
                else
                { $('#serviciocomboU').html(htmlUnidades);}
            },  error: function(result) {
                console.log(result);
            }
        });
    }

    function selectServicio()
    {
        var seleccion=document.getElementById("s_servicio").value;cargando();
        if(servicioID=='R')
        {
            var route="v1_0/reglanegocio/ejecutar_REST";
            var token =$("#token").val();
            $.ajax({
              url: route,
              headers: {},
              type: 'GET',
              dataType: 'json',
              data: {'id':document.getElementById("s_servicio").value},
                  success: function(data){
                        $.LoadingOverlay("hide");
                        $('#mensaje').html(JSON.stringify(data));
                        $("#modalMensaje").modal("show");
                        var predio='$_dataR=ejecutar_REST('+seleccion+');';
                        var antes=$("#scd_"+$('#idinput').val()+"").val();
                        $("#scd_"+$('#idinput').val()+"").val(antes +''+predio);
                  },
                  error: function(result) {
                        $.LoadingOverlay("hide");
                        swal("Opss..!", "Succedio un problema al ejecutar el servicio!", "error");
                  }
            });
            $("#s_servicio").val("..Seleccionar Servicio REST..");
        }
        else if(servicioID=='S')
        {
            var route="v1_0/reglaNegocio/ejecutar_Query";
            var token =$("#token").val();
            $.ajax({
              url: route,
              headers: {},
              type: 'GET',
              dataType: 'json',
              data: {'id':document.getElementById("s_servicio").value},
                      success: function(data){
                        $.LoadingOverlay("hide");
                        $('#mensaje').html(JSON.stringify(data));
                        $("#modalMensaje").modal("show");
                        var predio='$_dataS=ejecutar_SP('+seleccion+');';
                        var antes=$("#scd_"+$('#idinput').val()+"").val();
                        $("#scd_"+$('#idinput').val()+"").val(antes +''+predio);
                  },
                  error: function(result) {
                        $.LoadingOverlay("hide");
                        swal("Opss..!", "Succedio un problema al ejecutar el servicio!", "error");
                  }
            });
            $("#s_servicio").val("..Seleccionar Servicio DB..");
        }
        else if(servicioID=='C')
        {
            var route="v1_0/reglanegocio/ejecutar_Conn";
            var token =$("#token").val();
            var id_Conexion = document.getElementById("s_servicio").value;
            $.ajax({
              url: route,
              headers: {},
              type: 'GET',
              dataType: 'json',
              data: {'id':document.getElementById("s_servicio").value},
                success: function(data){
                    var srv_data_con = {"tipoG":data.tipo,"db":data.bd,"contraseña":data.contraseña,"usuario":data.usuario,
                        "host":data.host,"puerto":data.puerto,};
                    srv_data_con = JSON.stringify(srv_data_con);

                
                    $.LoadingOverlay("hide");
                    swal("Conexión Correcta!", data.res, "success");
                    var concatena='';var cadconn="$_conn1";var contador=1;
                    arrDibujo.forEach(function (item, index, array)  { concatena=concatena+ $("#scd_"+item.id+"").val(); });
                    for(var i=1;i<=20;i++)  { if (concatena.indexOf("$_conn"+i+"=") >= 0) { if($("#scd_"+$('#idinput').val()+"").val()==''){cadconn="$_conn"+(i+1); contador=i+1;}else{cadconn="$_conn"+$('#idinput').val(); contador=$('#idinput').val();} }}
                    var predio='';
                    var cadconn1='$_conn'+contador;
                    if(data.tipo=='mongodb'){ 
                            //predio=cadconn1+'=coneccionMDB("'+data.tipo+'","'+data.bd+'","'+data.host+'","'+data.puerto+'");\n';
                            predio=cadconn1+'=coneccionMBD("'+id_Conexion+'");\n';
                            predio=predio+'$colección'+contador+'=$_conn'+contador+'->nombreDB;\n'+'$cursor'+contador+'=$colección'+contador+'->find();\n';
                            predio=predio+'var_dump($cursor'+contador+');';
                    } 
                    else if(data.tipo!='mssql'){

                        //predio=cadconn1+'=coneccionDB("'+data.tipo+'","'+data.bd+'","'+data.host+'","'+data.puerto+'","'+data.usuario+'","'+data.contraseña+'");\n';
                        predio=cadconn1+'=coneccionBD("'+id_Conexion+'");\n';
                        predio=predio+'$_tipo'+contador+'="Select";\n'+'$_query'+contador+'="select * from";\n$_dataDB'+contador+'=ejecutar_Query('+cadconn+',$_query'+contador+',$_tipo'+contador+');\n';
                        predio=predio+'echo($_dataDB'+contador+');';
                       } 
                    else
                    {
                        //predio=cadconn1+'=coneccionDB("'+data.tipo+'","'+data.bd+'","'+data.host+'","'+data.puerto+'","'+data.usuario+'","'+data.contraseña+'");\n';
                        predio=cadconn1+'=coneccionBD("'+id_Conexion+'");\n';
                        predio=predio+'$_tipo'+contador+'=\'EXEC\';\n'+'$_query'+contador+'=\'EXEC dbo...... ;\';\n$_dataDB'+contador+'=ejecutar_Query('+cadconn+',$_query'+contador+',$_tipo'+contador+');\n';
                        predio=predio+'echo($_dataDB'+contador+');';
                    }
                    $("#scd_"+$('#idinput').val()+"").val(predio);
                },
                error: function(result) {
                        $.LoadingOverlay("hide");
                        console.log(result);
                        swal("Opss..!", "Succedio un problema al conectar con la base de datos!", "error");
                  }
            });
            $("#s_servicio").val("..Seleccionar Servicio DB..");
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
          data: {'base':$('#r_gertor').val(),'host':$('#r_servidor').val(),'usuario':$('#r_usuariodb').val(),'clave':$('#r_passworddb').val(),'nombrebd':$('#r_nombredb').val(),'puerto':$('#r_puerto').val()},
            success: function(data){
                $('#resultadoConn').html('<h4 class="col-md-14" style="color:#0B610B" align="center">Cadena de Conexión</h4><HR><div class="form-group"><div class="col-md-12" align="center" style="color:#0B610B">'+data.res+'</div><div align="center">La variable \'$_Tipo\', determina que tipo de consulta realizará (SELECT, INSERT, UPDATE, DELET, CREATE).</div></div>');
                swal("Exito!", "Conexión correcta a la Base de Datos!", "success");
                var predio='';
                if($('#r_gertor').val()!='mssql')
                {
                    predio='$_conn=\''+data.res+'\'; $_userdb=\''+$('#r_usuariodb').val()+'\'; $_passdb=\''+data.pass+'\';\n'+
                    '$_tipo=\'Select\';\n'+'$_query=\'select * from \';\n$_dataDB=ejecutar_DB($_conn,$_query,$_userdb,$_passdb,$_tipo);';
                }
                else
                {
                    predio='$_conn=\''+data.res+'\'; $_userdb=\''+$('#r_usuariodb').val()+'\'; $_passdb=\''+data.pass+'\';\n'+
                    '$_tipo=\'EXEC\';\n'+'$_query=\'EXEC dbo..... ;\';\n$_dataDB=ejecutar_DB($_conn,$_query,$_userdb,$_passdb,$_tipo);';
                }

                
                
                $("#scd_"+$('#idinput').val()+"").val(predio);
                $.LoadingOverlay("hide");
            },
            error: function(result) {
                $.LoadingOverlay("hide");
                console.log('error',result);
                $('#resultadoConn').html('');
                $("#scd_"+$('#idinput').val()+"").val('');
                swal("Error!", "Incoherencias en los datos,\n para conectar a la Base de Datos "+$('#r_nombredb').val()+".", "error");
            }
        }); 
    }

    function capares($long)
    {
        var dato = $long;
        dato=((dato.replace(/['']+/g, "&039;")).replace(/['"]+/g, "&040;")).replace(/['<]+/g, "&041;");
        dato=(dato.replace(/['>]+/g, "&042;")).replace(/['\\]+/g, "&043;");
        return dato;
    }

    function uncapares($long)
    {
        var dato = $long;
        dato=((dato.replace(/&039;/gi, "'")).replace(/&040;/gi, "\"")).replace(/&041;/gi, "<");
        dato=(dato.replace(/&042;/gi, ">")).replace(/&043;/gi, "\\");
        return dato;
    }

</script>
@endpush