<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="modalUpdate" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 container-fluit">
                        {!! Form::open(['class'=>'form-horizontal','id'=>'reglasUP'])!!}
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>
                                    <small>
                                    <div class="pull-right"><button class="btn btn-default" data-dismiss="modal" onclick="limpiarRegla();" type="button">
                                    Cerrar
                                    </button>
                                    <a type = "submit" class = "btn btn-primary" id="gen_factura" disabled="disabled" onclick="modificarCodigo();">Actualizar</a></div></small>
                                    Actualizar Reglas de Negocio
                                </h4>
                                <h4> 
                                <input id="id" name="id" value="id" type="hidden" class="form-control"> 
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal">
                                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="form-group col-md-2 pull-right">
                                        {!! Form::text('rn_version',null, array('maxlength'=>'4','class' => 'form-control','id'=>'version','name'=>'version')) !!}
                                    </div>
                                    <label class="form-group col-md-1 pull-right" for="">
                                        Version:
                                    </label>
                                    <div class="form-group col-md-9 pull-right">
                                        {!! Form::text('nombre',null, array('maxlength'=>'50','class' => 'form-control','id'=>'nombre','name'=>'nombre')) !!}
                                    </div>
                                    <label class="form-group col-md-1 pull-lefth" for="">
                                        Nombre:
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-2 pull-right">
                                        {!! Form::text('rn_orden',null, array('maxlength'=>'3','class' => 'form-control mayusculas','id'=>'orden','name'=>'orden')) !!}
                                    </div>
                                    <label class="form-group col-md-1 pull-right" for="">&nbsp;&nbsp;Orden:</label>
                                    <div class="form-group col-md-9 pull-right">
                                        {!! Form::text('rn_direccion',null, array('maxlength'=>'100','class' => 'form-control mayusculas','id'=>'descripcion','name'=>'descripcion')) !!}
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
                                        {!! Form::text('rn_identificador1',null, array('maxlength'=>'25','class' => 'form-control mayusculas','id'=>'rn_identificador1','name'=>'rn_identificador1', 'onKeyUp'=>'this.value = this.value.toUpperCase()')) !!}
                                    </div>
                                    <label class="form-group col-md-1 pull-lefth" for="">
                                        Identificador:
                                    </label>
                                </div>
                                <div class="col-md-12">
                                <h4 style="color:#0B610B" align="center">Líneas de Código
                                <small>
                                <div class="pull-right">
                                <select class="form-control pull-right" id="s_regla3" name="s_regla3" placeholder="Seleccione" onchange="nuevaLinea(document.getElementById('s_regla3').value);">
                                  <option value="N" selected="selected">-- Seleccionar --</option>
                                  <option value="T">Triger</option>
                                  <option value="R">Servicio Rest</option>
                                  <option value="S">Servicio SP</option>
                                  <option value="C">Conexión DB</option>
                                </select>
                                </div>
                                <div class="pull-right">
                                    <input id="idinput" name="idinput" type="hidden">
                                    <div id="serviciocomboU"></div>
                                </div></small>
                                </h4><HR></div>
                                <div class="">
                                    <div id="upcodigo"></div>
                                    <div class="form-group">
                                        <label class="col-md-1">Resultado:
                                        </label>
                                        <div class="col-md-11">
                                            <div id="upresultado"></div>
                                        </div>
                                    </div>
                                </div>
                                </input>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
/*
    function listaCodigo(id){
        
        var htmlListaSuc="";
        htmlListaSuc+='<div id="res"></div>';
        var route1="/v1_0/reglaNegocio/ejecutar/"+id;
        $.ajax({
            url: route1,
            type: 'GET',
            data: {
            },
            success: function(data){
                $('#lst-motor').html(data);
            },
            error: function(result) {
                swal("Opss..!", "Sucedio un problema al recibir los datos!", "error");
            }
        });
    }

   $(document).ready(function (){       
    });
*/
</script>
@endpush