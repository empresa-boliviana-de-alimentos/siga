<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="modalServicio" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 container-fluit">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h4>
                    <small>
                    <div class="pull-right">
                    <button type = "button" class = "btn btn-warning pull-right" data-dismiss = "modal" id="serviciollamar" onclick="llamarServicio();">Ejecutar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div></small>
                    Ejecutar Servicio
                </h4>
                <input id="tipo" name="hid" type="hidden">
                <input id="cant" name="hid" type="hidden">
              </div>
            </div>
            <div class="panel-body">
               {!! Form::open(['class'=>'form-horizontal','id'=>'niveles'])!!}
                  <input type="hidden" name="csrf-token" value=" {{ csrf_token() }}" id="token">
                      <div id="cabecera"></div>
                      <h4 style="color:#0B610B" align="center">Argumentos</h4><HR>
                      <div id="argumentopintar"></div>

                  </input>
                {!! Form::close() !!}
            </div>

          </div>
        </div>
      </div>
        
    </div>
      
  </div>
</div>


