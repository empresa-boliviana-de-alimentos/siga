<div class="modal fade modal-default" id="myUpdateCatalogo" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 container-fluit">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <h4 class="modal-title" id="myModalLabel">Formulario Modificar Parametro</h4>
              </div>
              <div class="panel-body">
                {!! Form::open(['class'=>'form-horizontal','id'=>'catalogo2'])!!}
                <form class="form-horizontal">
                  <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <input id="u_id" type="hidden">
                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="col-sm-14">
                            {!!Form::label('ctp_descripcion','Descripción:')!!}
                            <input class="form-control" onKeyUp="this.value=this.value.toUpperCase();" id="u_ctp_descripcion" name="ctp_descripcion" type="text" placeholder="Ingrese la descripción" maxlength="40">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="col-sm-14">
                            {!!Form::label('ctp_codigo','Código:')!!}
                            {!! Form::text('ctp_codigo', null, array('placeholder' => 'Ingrese un código','maxlength'=>'10','class' => 'form-control','id'=>'u_ctp_codigo')) !!}
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="col-sm-14">
                            {!!Form::label('ctp_clasificador','Clasificación:')!!}
                            {!! Form::text('ctp_clasificador', null, array('placeholder' => 'Ingrese la clasificación','maxlength'=>'15','class' => 'form-control','id'=>'u_ctp_clasificador')) !!}
                          </div>
                        </div>
                      </div>
                    </input>
                  </input>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="LimpiarUP()">Cerrar</button>
        {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizar','class'=>'btn btn-warning'], $secure=null)!!}
        {!! Form::close() !!}
      </div>
        
    </div>
  </div>
</div>