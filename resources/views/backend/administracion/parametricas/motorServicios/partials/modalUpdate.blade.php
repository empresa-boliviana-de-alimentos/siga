<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="modalUpdate" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 container-fluit">
            {!! Form::open(['class'=>'form-horizontal','id'=>'motorUP'])!!}
            <div class="panel panel-info">
              <div class="panel-heading">
                <h4>
                  <small>
                  <div class="pull-right">
                  <div class="pull-right" id="idbotonUP"></div>
                  <button class="btn btn-default" data-dismiss="modal" onclick="Limpiar();" type="button">
                  Cerrar
                  </button>
                  <a type = "button" class = "pull-right btn btn-primary" id="gen_factura" onclick="ActualizarRegistro();">Actualizar</a></div></small>
                  Actualizar Motor de Servicios
                </h4>
                <input id="upid" name="id" value="id" type="hidden" class="form-control">
              </div>
            </div>
            <div class="panel-body">
              <form class="form-horizontal">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="col-md-1" for="">
                        Nombre:
                    </label>
                    <div class="col-md-4">
                        {!! Form::text('ue_direccion',null, array('maxlength'=>'100','class' => 'form-control mayusculas','id'=>'nombre1','name'=>'nombre1')) !!}
                    </div>
                    <label class="col-md-1" for="">
                        Descripcion:</label>
                    <div class="col-md-6">
                        {!! Form::text('ue_nombre',null, array('maxlength'=>'50','class' => 'form-control mayusculas','id'=>'descripcion1','name'=>'descripcion1')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1">
                        Tipo:
                    </label>
                    <div class="col-md-4">
                        <select class="form-control" id="tiposer1" name="tiposer1" onchange="CrearServicio(this.value)">
                            <option value="N" selected="selected">-- Seleccionar --</option>
                            <option value="R">Servicio REST</option>
                            <option value="S">Servicio SP</option>
                            <option value="C">Conexión BD</option>
                        </select>
                    </div>
                    <div id="serviciocomboU"></div>
                </div>

                <div id="upcabeceraCrear"></div>
                <div id="argCrearUP">
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
                <div id="upargumentopintarCrear"></div>
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
