<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="modalLlamada" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="row container-fluit">
      <div class="panel panel-secundary">
        <div class="">
          <div class="">
            <div class="">
              <div class="panel-heading">
                <h3>
                    Respusta a Servicio
                    <small>
                    <div class="pull-right"><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="ServicioAnt();">Retornar</button></div></small>
                </h3>
              </div>
              <div class="panel-body">
                 {!! Form::open(['class'=>'form-horizontal','id'=>'niveles'])!!}
                    <input type="hidden" name="csrf-token" value=" {{ csrf_token() }}" id="token">
                      <div class="form-group">
                        <div class="col-md-12">
                            <label for="">Resultado:
                            </label>
                            <textarea class="form-control" id="sr_dato" name="sr_dato" placeholder="" rows="10" ></textarea>
                        </div>
                      </div>
                    </input>
                  {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


