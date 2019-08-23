<div class="modal fade modal-default" id="myCreateCatalogo" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 container-fluit">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <h4 class="modal-title" id="myModalLabel">Formulario de Registro Parametro</h4>
              </div>
              <div class="panel-body">
                {!! Form::open(['class'=>'form-horizontal','id'=>'catalogo'])!!}
                <form class="form-horizontal">
                  <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                    <div class="form-group">
                      <div class="col-md-12">
                        <div class="col-sm-14">
                          {!!Form::label('ctp_descripcion','Descripción:')!!}
                          <input class="form-control" id="r_ctp_descripcion" name="ctp_descripcion" type="text" placeholder="Ingrese la descripción" maxlength="40">
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="col-md-12">
                        <div class="col-sm-14">
                          {!!Form::label('ctp_codigo','Código:')!!}
                          {!! Form::text('ctp_codigo', null, array('placeholder' => 'Ingrese un código','maxlength'=>'10','class' => 'form-control','id'=>'r_ctp_codigo')) !!}
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="col-md-12">
                        <div class="col-sm-14">
                          {!!Form::label('ctp_clasificador','Clasificación:')!!}
                          {!! Form::text('ctp_clasificador', null, array('placeholder' => 'Ingrese la clasificación','maxlength'=>'15','class' => 'form-control','id'=>'r_ctp_clasificador')) !!}
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
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="Limpiar()">Cerrar</button>
        {!!link_to('#',$title='Guardar', $attributes=['id'=>'registro','class'=>'btn btn-warning'], $secure=null)!!}
        {!! Form::close() !!}
      </div>
        
    </div>
  </div>
</div>